@extends('layouts.app')

@section('title', 'Daftar Pengumpulan Tugas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Pengumpulan Tugas: {{ $tugas->judul }}</h3>
                        <a href="{{ route('tugas.index') }}" class="btn btn-gray-200 btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tugas
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Info Tugas -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Mata Pelajaran</th>
                                        <td>{{ $tugas->guruKelas->guruMataPelajaran->mataPelajaran->nama_pelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>{{ $tugas->guruKelas->kelas->nama_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Batas Waktu</th>
                                        <td>{{ $tugas->batas_waktu->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Nilai</th>
                                        <td>{{ $tugas->total_nilai }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Tabel Pengumpulan -->
                        <div class="table-responsive">
                            <table id="submissions-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Siswa</th>
                                        <th>Waktu Pengumpulan</th>
                                        @if ($tugas->metode_pengerjaan === 'upload_file')
                                            <th>File Pengumpulan</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Nilai</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nilai -->
    <div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradeModalLabel">Penilaian Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="gradeForm">
                    <div class="modal-body">
                        <input type="hidden" name="pengumpulan_id" id="pengumpulan_id">
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" min="0"
                                max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea class="form-control" id="komentar" name="komentar" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pengumpulan -->
    <div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submissionModalLabel">Detail Pengumpulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="submissionDetail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush --}}

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#submissions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tugas.submissions', $tugas->id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_siswa',
                        name: 'siswa.user.name'
                    },
                    {
                        data: 'waktu_pengumpulan',
                        name: 'created_at'
                    },
                    @if ($tugas->metode_pengerjaan === 'upload_file')
                        {
                            data: 'file_pengumpulan',
                            name: 'file_pengumpulan',
                            orderable: false,
                            searchable: false,
                        },
                    @endif {
                        data: 'status',
                        name: 'nilai',
                        orderable: false
                    },
                    {
                        data: 'nilai',
                        name: 'nilai'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [2, 'desc']
                ]
            });

            // Handle grade form submission
            $('#gradeForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('tugas.grade') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#gradeModal').modal('hide');
                        table.ajax.reload();
                        notyf.open({
                            type: 'success',
                            message: response.message
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(key => {
                                toastr.error(errors[key][0]);
                                notyf.open({
                                    type: 'error',
                                    message: errors[key][0]
                                });
                            });
                        } else {
                            notyf.open({
                                type: 'error',
                                message: 'Terjadi kesalahan saat menyimpan nilai'
                            });
                        }
                    }
                });
            });
        });

        // Show grade modal
        function showGradeModal(id) {
            $('#pengumpulan_id').val(id);
            $('#nilai').val('');
            $('#komentar').val('');
            $('#gradeModal').modal('show');
        }

        // View submission details
        function viewSubmission(id) {
            $.ajax({
                url: `/tugas/submission/${id}`,
                type: 'GET',
                success: function(response) {
                    let html = `
                    <table class="table">
                        <tr>
                            <th width="200">Nama Siswa</th>
                            <td>${response.siswa.user.name}</td>
                        </tr>
                        <tr>
                            <th>Waktu Pengumpulan</th>
                            <td>${moment(response.created_at).format('DD MMM YYYY HH:mm')}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>${response.nilai ? 'Sudah Dinilai' : 'Belum Dinilai'}</td>
                        </tr>
                        <tr>
                            <th>Nilai</th>
                            <td>${response.nilai || '-'}</td>
                        </tr>
                        <tr>
                            <th>Komentar</th>
                            <td>${response.komentar || '-'}</td>
                        </tr>
                    </table>`;

                    if (response.file_pengumpulan) {
                        html += `<div class="mt-3">
                        <a href="/storage/${response.file_pengumpulan}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-download"></i> Download File Pengumpulan
                        </a>
                    </div>`;
                    }

                    // Tampilkan jawaban per soal jika ada
                    if (response.soal_jawaban && response.soal_jawaban.length > 0) {
                        html += `<div class="mt-4"><h5>Jawaban Siswa per Soal</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban Siswa</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>`;
                        response.soal_jawaban.forEach(function(item, idx) {
                            html += `<tr>
                            <td>${idx + 1}</td>
                            <td>${item.pertanyaan}</td>
                            <td>${item.jawaban_siswa !== null ? item.jawaban_siswa : '-'}</td>
                            <td>${item.nilai !== null ? item.nilai : '-'}</td>
                        </tr>`;
                        });
                        html += `</tbody></table></div>`;
                    }

                    $('#submissionDetail').html(html);
                    $('#submissionModal').modal('show');
                },
                error: function() {
                    toastr.error('Gagal memuat detail pengumpulan');
                }
            });
        }
    </script>
@endpush
