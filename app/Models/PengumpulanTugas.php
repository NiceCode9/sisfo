<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'teks_pengumpulan',
        'path_file',
        'waktu_pengumpulan',
        'nilai',
        'umpan_balik'
    ];

    protected $casts = [
        'waktu_pengumpulan' => 'datetime',
        'nilai' => 'integer'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class, 'pengumpulan_id');
    }

    /**
     * Hitung nilai otomatis untuk soal pilihan ganda/campuran
     * Akan mengisi kolom nilai pada pengumpulan_tugas
     */
    public function hitungNilaiPilihanGanda()
    {
        $tugas = $this->tugas;
        if (!in_array($tugas->jenis, ['pilihan_ganda', 'campuran', 'uraian'])) {
            return;
        }
        $soalPilihanGanda = $tugas->soal->where('tipe', 'pilihan_ganda');
        $jawabanSiswa = $this->jawabanSiswa->keyBy('soal_id');
        $benar = 0;
        $total = $soalPilihanGanda->count();
        foreach ($soalPilihanGanda as $soal) {
            $jawaban = $jawabanSiswa->get($soal->id);
            if ($jawaban && $jawaban->jawaban == $soal->kunci_jawaban) {
                $benar++;
            }
        }
        $nilai = $total > 0 ? round(($benar / $total) * $tugas->total_nilai) : 0;
        $this->nilai = $nilai;
        $this->save();
    }
}
