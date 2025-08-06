@extends('layouts.app')
@section('title', 'Kenaikan Kelas')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Proses Kenaikan Kelas</li>
                </ol>
            </nav>
            <h2 class="h4">Proses Kenaikan Kelas</h2>
            <p class="mb-0">Halaman untuk mengelola kenaikan kelas siswa (Kelas 10-11).</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form id="formKenaikan">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="kelas_asal" class="form-label">Kelas Asal</label>
                        <select class="form-select" id="kelas_asal" name="kelas_asal" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->tingkat }} - {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">*Hanya kelas 10-11 yang dapat dinaikkan</small>
                    </div>
                </div>

                <div class="row mb-4" id="siswaSection" style="display: none;">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Daftar Siswa</h5>
                            <span class="badge bg-info" id="jumlahSiswa">0 Siswa</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tableSiswa">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50px">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas Awal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data siswa akan dimuat via AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <div id="selectedInfo" class="mt-2 text-muted">
                            <small>Belum ada siswa yang dipilih</small>
                        </div>
                    </div>
                </div>

                <div class="row mb-4" id="kelasTujuanSection" style="display: none;">
                    <div class="col-md-6">
                        <label for="kelas_tujuan" class="form-label">Kelas Tujuan</label>
                        <select class="form-select" id="kelas_tujuan" name="kelas_tujuan" required>
                            <option value="">Pilih Kelas Tujuan</option>
                        </select>
                        <small class="text-muted" id="kelasTujuanInfo"></small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" id="btnProses" disabled>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Proses Kenaikan Kelas
                        </button>
                        <button type="button" class="btn btn-secondary" id="btnReset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let isProcessing = false;

            $('#kelas_asal').change(function() {
                var kelasId = $(this).val();
                resetForm();

                if (kelasId) {
                    loadSiswa(kelasId);
                    loadKelasTujuan(kelasId);
                }
            });

            // Check all siswa
            $('#checkAll').change(function() {
                const isChecked = $(this).prop('checked');
                $('.siswa-check').prop('checked', isChecked);
                updateSelectedInfo();
                toggleProsesButton();
            });

            // Handle perubahan checkbox siswa
            $(document).on('change', '.siswa-check', function() {
                updateCheckAllState();
                updateSelectedInfo();
                toggleProsesButton();
            });

            // Handle perubahan kelas tujuan
            $('#kelas_tujuan').change(function() {
                toggleProsesButton();
            });

            // Submit form
            $('#formKenaikan').submit(function(e) {
                e.preventDefault();
                if (!isProcessing) {
                    prosesKenaikan();
                }
            });

            // Reset button
            $('#btnReset').click(function() {
                resetForm();
            });

            function resetForm() {
                $('#siswaSection, #kelasTujuanSection').hide();
                $('#tableSiswa tbody').empty();
                $('#kelas_tujuan').html('<option value="">Pilih Kelas Tujuan</option>');
                $('#checkAll').prop('checked', false);
                $('#btnProses').prop('disabled', true);
                $('#jumlahSiswa').text('0 Siswa');
                $('#selectedInfo').html('<small class="text-muted">Belum ada siswa yang dipilih</small>');
                $('#kelasTujuanInfo').text('');
            }

            function loadSiswa(kelasId) {
                $.ajax({
                    url: "{{ route('kenaikan-kelas.get-siswa') }}",
                    type: "GET",
                    data: {
                        kelas_id: kelasId
                    },
                    beforeSend: function() {
                        $('#siswaSection').show();
                        $('#tableSiswa tbody').html(
                            '<tr><td colspan="4" class="text-center">Loading...</td></tr>');
                    },
                    success: function(response) {
                        if (response.success) {
                            var html = '';
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, siswa) {
                                    html += '<tr>' +
                                        '<td><div class="form-check"><input type="checkbox" class="form-check-input siswa-check" name="siswa_ids[]" value="' +
                                        siswa.id + '" id="siswa_' + siswa.id +
                                        '"><label class="form-check-label" for="siswa_' + siswa
                                        .id + '"></label></div></td>' +
                                        '<td>' + siswa.nis + '</td>' +
                                        '<td>' + siswa.nama + '</td>' +
                                        '<td>' + siswa.kelas_awal + '</td>' +
                                        '</tr>';
                                });
                                $('#jumlahSiswa').text(response.data.length + ' Siswa');
                            } else {
                                html =
                                    '<tr><td colspan="4" class="text-center text-muted">Tidak ada siswa di kelas ini</td></tr>';
                                $('#jumlahSiswa').text('0 Siswa');
                            }
                            $('#tableSiswa tbody').html(html);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Gagal memuat data siswa';
                        $('#tableSiswa tbody').html(
                            '<tr><td colspan="4" class="text-center text-danger">' + errorMsg +
                            '</td></tr>');
                        showAlert('danger', errorMsg);
                    }
                });
            }

            function loadKelasTujuan(kelasId) {
                $.ajax({
                    url: "{{ route('kenaikan-kelas.get-kelas-tujuan') }}",
                    type: "GET",
                    data: {
                        kelas_id: kelasId
                    },
                    success: function(response) {
                        if (response.success) {
                            var html = '<option value="">Pilih Kelas Tujuan</option>';
                            $.each(response.data, function(index, kelas) {
                                html += '<option value="' + kelas.id + '">' + kelas.tingkat +
                                    ' - ' + kelas.nama_kelas + '</option>';
                            });
                            $('#kelas_tujuan').html(html);
                            $('#kelasTujuanSection').show();
                            $('#kelasTujuanInfo').text('*Siswa akan naik ke tingkat ' + response.data[0]
                                .tingkat);
                        } else {
                            var html = '<option value="">Pilih Kelas Tujuan</option>';
                            html += '<option value="lulus">Lulus</option>';
                            $('#kelas_tujuan').html(html);
                            $('#kelasTujuanSection').show();
                            showAlert('warning', response.message);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Gagal memuat kelas tujuan';
                        showAlert('danger', errorMsg);
                    }
                });
            }

            function updateCheckAllState() {
                const totalCheckboxes = $('.siswa-check').length;
                const checkedCheckboxes = $('.siswa-check:checked').length;

                $('#checkAll').prop('checked', totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes);
            }

            function updateSelectedInfo() {
                const checkedCount = $('.siswa-check:checked').length;
                const totalCount = $('.siswa-check').length;

                if (checkedCount === 0) {
                    $('#selectedInfo').html('<small class="text-muted">Belum ada siswa yang dipilih</small>');
                } else {
                    $('#selectedInfo').html(
                        `<small class="text-info"><strong>${checkedCount} dari ${totalCount} siswa dipilih</strong></small>`
                    );
                }
            }

            function toggleProsesButton() {
                const hasSelectedSiswa = $('.siswa-check:checked').length > 0;
                const hasKelasTujuan = $('#kelas_tujuan').val();

                $('#btnProses').prop('disabled', !(hasSelectedSiswa && hasKelasTujuan) || isProcessing);
            }

            function prosesKenaikan() {
                var siswaIds = $('.siswa-check:checked').map(function() {
                    return $(this).val();
                }).get();

                if (siswaIds.length === 0) {
                    showAlert('warning', 'Pilih minimal satu siswa');
                    return;
                }

                if (!$('#kelas_tujuan').val()) {
                    showAlert('warning', 'Pilih kelas tujuan');
                    return;
                }

                if (!confirm(`Apakah Anda yakin ingin memproses kenaikan kelas untuk ${siswaIds.length} siswa?`)) {
                    return;
                }

                isProcessing = true;
                $('#btnProses').prop('disabled', true).find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: "{{ route('kenaikan-kelas.proses') }}",
                    type: "POST",
                    data: {
                        kelas_asal_id: $('#kelas_asal').val(),
                        kelas_tujuan_id: $('#kelas_tujuan').val(),
                        siswa_ids: siswaIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', response.message);
                            resetForm();
                            $('#kelas_asal').val('');
                        } else {
                            showAlert('danger', response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON?.message);
                        const errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan';
                        showAlert('danger', errorMsg);
                    },
                    complete: function() {
                        isProcessing = false;
                        $('#btnProses').find('.spinner-border').addClass('d-none');
                        toggleProsesButton();
                    }
                });
            }

            function showAlert(type, message) {
                const alertClass = `alert-${type}`;
                const alert = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Remove existing alerts
                $('.alert').remove();

                // Add new alert at the top
                $(alert).insertAfter('.py-4');

                // Auto dismiss after 5 seconds
                setTimeout(function() {
                    $('.alert').alert('close');
                }, 5000);
            }
        });
    </script>
@endpush
