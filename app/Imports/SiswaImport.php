<?php

namespace App\Imports;

use App\Models\CalonSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SiswaImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    private $errors = [];
    private $successCount = 0;
    private $skipCount = 0;

    public function collection(Collection $rows)
    {
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', true)->first();

        if (!$tahunAjaranAktif) {
            throw new \Exception('Tidak ada tahun ajaran aktif yang ditemukan');
        }

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 karena index dimulai dari 0 dan ada header

            try {
                DB::beginTransaction();

                // Validasi NIK unik
                if (CalonSiswa::where('nik', $row['nik'])->exists()) {
                    $this->errors[] = "Baris {$rowNumber}: NIK {$row['nik']} sudah terdaftar";
                    $this->skipCount++;
                    DB::rollBack();
                    continue;
                }

                // Validasi NISN unik
                if (Siswa::where('nisn', $row['nisn'])->exists()) {
                    $this->errors[] = "Baris {$rowNumber}: NISN {$row['nisn']} sudah terdaftar";
                    $this->skipCount++;
                    DB::rollBack();
                    continue;
                }

                // Validasi NIS unik
                if (Siswa::where('nis', $row['nis'])->exists()) {
                    $this->errors[] = "Baris {$rowNumber}: NIS {$row['nis']} sudah terdaftar";
                    $this->skipCount++;
                    DB::rollBack();
                    continue;
                }

                // Cari kelas berdasarkan tingkat dan nama
                $kelas = Kelas::where('tingkat', $row['tingkat_kelas'])
                    ->where('nama_kelas', $row['nama_kelas'])
                    ->first();

                if (!$kelas) {
                    $this->errors[] = "Baris {$rowNumber}: Kelas {$row['tingkat_kelas']}-{$row['nama_kelas']} tidak ditemukan";
                    $this->skipCount++;
                    DB::rollBack();
                    continue;
                }

                // Parse tanggal lahir
                $tanggalLahir = null;
                if (!empty($row['tanggal_lahir'])) {
                    try {
                        // Coba berbagai format tanggal
                        if (is_numeric($row['tanggal_lahir'])) {
                            // Excel date serial number
                            $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
                        } else {
                            // String date
                            $tanggalLahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        $this->errors[] = "Baris {$rowNumber}: Format tanggal lahir tidak valid";
                        $this->skipCount++;
                        DB::rollBack();
                        continue;
                    }
                }

                // Buat data calon siswa
                $calonSiswaData = [
                    'nik' => $row['nik'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
                    'tempat_lahir' => $row['tempat_lahir'] ?? '',
                    'tanggal_lahir' => $tanggalLahir,
                    'agama' => $row['agama'] ?? 'Islam',
                    'alamat' => $row['alamat'] ?? '',
                    'no_hp' => $row['no_hp'] ?? null,
                    'email' => $row['email'] ?? null,
                    'asal_sekolah' => $row['asal_sekolah'] ?? null,
                    'nama_ayah' => $row['nama_ayah'] ?? '',
                    'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? '',
                    'nama_ibu' => $row['nama_ibu'] ?? '',
                    'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? '',
                    'no_hp_orang_tua' => $row['no_hp_orang_tua'] ?? null,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'no_pendaftaran' => 'IMPRT-' . Carbon::now()->format('YmdHis') . '-' . $rowNumber,
                    'status_pendaftaran' => 'diterima'
                ];

                $calonSiswa = CalonSiswa::create($calonSiswaData);

                // Buat data siswa
                $siswa = $calonSiswa->siswa()->create([
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'nis' => $row['nis'],
                    'nisn' => $row['nisn'],
                    'kelas_awal' => $row['kelas_awal'] ?? '7',
                ]);

                // Buat riwayat kelas
                $siswa->riwayatKelas()->create([
                    'kelas_id' => $kelas->id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'status' => 'aktif',
                    'keterangan' => 'Import data dari Excel',
                ]);

                // Buat user account
                $username = $row['nik'];
                $email = $row['email'] ?? $username . '@smppiri.sch.id';

                // Pastikan username unik
                $originalUsername = $username;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $originalUsername . $counter;
                    $counter++;
                }

                // Pastikan email unik
                $originalEmail = $email;
                $counter = 1;
                while (User::where('email', $email)->exists()) {
                    $emailParts = explode('@', $originalEmail);
                    $email = $emailParts[0] . $counter . '@' . $emailParts[1];
                    $counter++;
                }

                $siswa->user()->create([
                    'name' => $calonSiswa->nama_lengkap,
                    'email' => $email,
                    'username' => $username,
                    'password' => Hash::make('password123'),
                    'slug' => Str::slug($calonSiswa->nama_lengkap . '-' . $username),
                ]);

                $this->successCount++;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->errors[] = "Baris {$rowNumber}: " . $e->getMessage();
                $this->skipCount++;
            }
        }
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|max:16',
            'nisn' => 'required|max:10',
            'nis' => 'required|max:10',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:L,P,l,p',
            'tempat_lahir' => 'nullable|max:255',
            'tanggal_lahir' => 'nullable',
            'agama' => 'nullable|max:50',
            'alamat' => 'nullable|max:255',
            'no_hp' => 'nullable|max:15',
            'email' => 'nullable|email|max:255',
            'asal_sekolah' => 'nullable|max:255',
            'nama_ayah' => 'nullable|max:255',
            'pekerjaan_ayah' => 'nullable|max:100',
            'nama_ibu' => 'nullable|max:255',
            'pekerjaan_ibu' => 'nullable|max:100',
            'no_hp_orang_tua' => 'nullable|max:15',
            'tingkat_kelas' => 'required',
            'nama_kelas' => 'required',
            'kelas_awal' => 'nullable',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi',
            'nisn.required' => 'NISN wajib diisi',
            'nis.required' => 'NIS wajib diisi',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P',
            'tingkat_kelas.required' => 'Tingkat kelas wajib diisi',
            'nama_kelas.required' => 'Nama kelas wajib diisi',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getSkipCount(): int
    {
        return $this->skipCount;
    }
}
