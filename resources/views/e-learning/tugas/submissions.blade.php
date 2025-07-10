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
                                        <th>Jenis Tugas</th>
                                        <td>
                                            <span
                                                class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $tugas->jenis)) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Metode Pengerjaan</th>
                                        <td>
                                            <span
                                                class="badge {{ $tugas->metode_pengerjaan === 'online' ? 'bg-primary' : 'bg-success' }}">
                                                {{ ucfirst(str_replace('_', ' ', $tugas->metode_pengerjaan)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Batas Waktu</th>
                                        <td>
                                            {{ $tugas->batas_waktu->format('d M Y H:i') }}
                                            @if ($tugas->batas_waktu->isPast())
                                                <span class="badge bg-danger">Berakhir</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Nilai</th>
                                        <td>{{ $tugas->total_nilai }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Siswa</span>
                                        <span class="info-box-number">{{ $jumlahSiswa }}</span>
                                    </div>
                                </div>
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Sudah Mengumpulkan</span>
                                        <span class="info-box-number">{{ $jumlahPengumpulan }}</span>
                                    </div>
                                </div>
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Belum Mengumpulkan</span>
                                        <span class="info-box-number">{{ $jumlahSiswa - $jumlahPengumpulan }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Pengumpulan -->
                        <div class="table-responsive">
                            <table id="submissions-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
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
                            <label for="nilai" class="form-label">Nilai (0-100)</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" min="0"
                                max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea class="form-control" id="komentar" name="komentar" rows="3"
                                placeholder="Berikan feedback untuk siswa..."></textarea>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submissionModalLabel">Detail Pengumpulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="submissionDetail">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pengumpulan tugas ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        let deleteId = null;

        $(document).ready(function() {
            // Initialize DataTable
            table = $('#submissions-table').DataTable({
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
                        name: 'user.name'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas',
                        orderable: false
                    },
                    {
                        data: 'waktu_pengumpulan',
                        name: 'waktu_pengumpulan',
                        orderable: false
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
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nilai',
                        name: 'nilai',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                language: {
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    loadingRecords: "Memuat data...",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Handle grade form submission
            $('#gradeForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    url: "{{ route('tugas.grade') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#gradeModal').modal('hide');
                        table.ajax.reload(null, false);
                        if (typeof notyf !== 'undefined') {
                            notyf.open({
                                type: 'success',
                                message: response.message
                            });
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            console.log(xhr.responseJSON);

                            Object.keys(errors).forEach(key => {
                                if (typeof notyf !== 'undefined') {
                                    notyf.open({
                                        type: 'error',
                                        message: errors[key][0]
                                    });
                                } else {
                                    alert(errors[key][0]);
                                }
                            });
                        } else {
                            const message = xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menyimpan nilai';
                            if (typeof notyf !== 'undefined') {
                                notyf.open({
                                    type: 'error',
                                    message: message
                                });
                            } else {
                                alert(message);
                            }
                        }
                    }
                });
            });

            // Handle delete confirmation
            $('#confirmDelete').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: `/tugas/submission/${deleteId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#deleteModal').modal('hide');
                            table.ajax.reload(null, false);
                            if (typeof notyf !== 'undefined') {
                                notyf.open({
                                    type: 'success',
                                    message: response.message
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menghapus';
                            if (typeof notyf !== 'undefined') {
                                notyf.open({
                                    type: 'error',
                                    message: message
                                });
                            } else {
                                alert(message);
                            }
                        }
                    });
                }
            });
        });

        // Show grade modal
        function showGradeModal(id) {
            // Reset form
            $('#gradeForm')[0].reset();
            $('#pengumpulan_id').val(id);

            // Load existing grade if any
            $.ajax({
                url: `/tugas/submission/${id}`,
                type: 'GET',
                success: function(response) {
                    if (response.nilai) {
                        $('#nilai').val(response.nilai);
                    }
                    if (response.umpan_balik) {
                        $('#komentar').val(response.umpan_balik);
                    }
                },
                error: function(xhr) {
                    console.log('Error loading submission data:', xhr);
                }
            });

            $('#gradeModal').modal('show');
        }

        // Auto grade for multiple choice
        function autoGrade(id) {
            $.ajax({
                url: "{{ route('tugas.grade') }}",
                type: 'POST',
                data: {
                    pengumpulan_id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload(null, false);
                    if (typeof notyf !== 'undefined') {
                        notyf.open({
                            type: 'success',
                            message: response.message
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat auto nilai';
                    if (typeof notyf !== 'undefined') {
                        notyf.open({
                            type: 'error',
                            message: message
                        });
                    } else {
                        alert(message);
                    }
                }
            });
        }

        // Delete submission
        function deleteSubmission(id) {
            deleteId = id;
            $('#deleteModal').modal('show');
        }

        // Grade essay questions
        function gradeUraian(id_jawaban) {
            const input = $(`input[onchange*='gradeUraian(${id_jawaban})']`);
            const poin = input.val();
            let pengumpulanId = input.data('pengumpulan_id');

            if (poin === '' || isNaN(poin)) {
                if (typeof notyf !== 'undefined') {
                    notyf.open({
                        type: 'error',
                        message: 'Nilai harus berupa angka'
                    });
                }
                return;
            }

            $.ajax({
                url: "{{ route('tugas.grade') }}",
                type: 'POST',
                data: {
                    pengumpulan_id: pengumpulanId,
                    id_jawaban: id_jawaban,
                    poin: poin,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (typeof notyf !== 'undefined') {
                        notyf.open({
                            type: 'success',
                            message: response.message
                        });
                    }
                    // Update total score in modal
                    if (response.pengumpulan && typeof response.pengumpulan.nilai !== 'undefined') {
                        $("#submissionDetail tr:contains('Nilai') td:last").text(response.pengumpulan.nilai);
                    }
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            if (typeof notyf !== 'undefined') {
                                notyf.open({
                                    type: 'error',
                                    message: errors[key][0]
                                });
                            } else {
                                alert(errors[key][0]);
                            }
                        });
                    } else {
                        const message = xhr.responseJSON?.message || 'Gagal menyimpan nilai';
                        if (typeof notyf !== 'undefined') {
                            notyf.open({
                                type: 'error',
                                message: message
                            });
                        } else {
                            alert(message);
                        }
                    }
                }
            });
        }

        // View submission details
        function viewSubmission(id) {
            $('#submissionDetail').html(`
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: `/tugas/submission/${id}`,
                type: 'GET',
                success: function(response) {
                    let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
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
                                    <td>
                                        <span class="badge ${response.nilai ? 'bg-success' : 'bg-warning'}">
                                            ${response.nilai ? 'Sudah Dinilai' : 'Belum Dinilai'}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nilai</th>
                                    <td><strong>${response.nilai || '-'}</strong></td>
                                </tr>
                                <tr>
                                    <th>Komentar</th>
                                    <td>${response.umpan_balik || '-'}</td>
                                </tr>
                            </table>
                        </div>
                    </div>`;

                    if (response.file_pengumpulan) {
                        html += `
                        <div class="mt-3">
                            <h6>File Pengumpulan:</h6>
                            <a href="/storage/${response.file_pengumpulan}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> Download File Pengumpulan
                            </a>
                        </div>`;
                    }

                    // Show answers per question if available
                    if (response.soal_jawaban && response.soal_jawaban.length > 0) {
                        html += `
                        <div class="mt-4">
                            <h5>Jawaban Siswa per Soal</h5>
                            <div class="table-responsive">
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
                                <td>${item.jawaban_siswa !== null ? item.jawaban_siswa : '<span class="text-muted">Tidak dijawab</span>'}</td>
                                <td>`;

                            if (response.tugas.jenis === 'uraian' && item.id_jawaban) {
                                html +=
                                    `<input type="number" data-pengumpulan_id="${id}" class="form-control" value="${item.poin_diperoleh !== null ? item.poin_diperoleh : 0}" onchange="gradeUraian(${item.id_jawaban})" min="0" max="100" />`;
                            } else {
                                html += `${item.nilai !== null ? item.nilai : '-'}`;
                            }

                            html += `</td></tr>`;
                        });

                        html += `</tbody></table></div></div>`;
                    }

                    $('#submissionDetail').html(html);
                    $('#submissionModal').modal('show');
                },
                error: function(xhr) {
                    $('#submissionDetail').html(
                        '<div class="alert alert-danger">Gagal memuat detail pengumpulan</div>');
                    const message = xhr.responseJSON?.message || 'Gagal memuat detail pengumpulan';
                    if (typeof notyf !== 'undefined') {
                        notyf.open({
                            type: 'error',
                            message: message
                        });
                    } else {
                        alert(message);
                    }
                }
            });
        }
    </script>
@endpush
