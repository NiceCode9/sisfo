@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Data Ekstrakurikuler</h4>
                        <button type="button" class="btn btn-primary" id="btn-create">
                            <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="ekstrakurikuler-table">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Foto</th>
                                        <th width="20%">Nama Ekstrakurikuler</th>
                                        <th width="30%">Deskripsi</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Anggota Aktif</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ekstrakurikulers as $index => $ekskul)
                                        <tr id="row-{{ $ekskul->id }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($ekskul->foto)
                                                    <img src="{{ asset('storage/' . $ekskul->foto) }}"
                                                        alt="{{ $ekskul->nama_ekskul }}" class="img-thumbnail"
                                                        style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('ekstrakurikuler.show', $ekskul->slug) }}"
                                                    class="text-decoration-none fw-bold">
                                                    {{ $ekskul->nama_ekskul }}
                                                </a>
                                            </td>
                                            <td>{{ Str::limit($ekskul->deskripsi, 100) }}</td>
                                            <td>
                                                @if ($ekskul->getRawOriginal('status'))
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $ekskul->anggotaAktif() }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('ekstrakurikuler.show', $ekskul->slug) }}"
                                                        class="btn btn-sm btn-info" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if (!auth()->user()->hasRole('siswa'))
                                                        <button type="button" class="btn btn-sm btn-warning btn-edit"
                                                            data-id="{{ $ekskul->slug }}" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                            data-id="{{ $ekskul->slug }}"
                                                            data-name="{{ $ekskul->nama_ekskul }}" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data ekstrakurikuler</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create/Edit -->
    <div class="modal fade" id="ekstrakurikulerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Tambah Ekstrakurikuler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="ekstrakurikuler-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="method" name="_method" value="">
                    <input type="hidden" id="ekstrakurikuler-id" name="id" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_ekskul" class="form-label">Nama Ekstrakurikuler <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_ekskul" name="nama_ekskul" required>
                                    <div class="invalid-feedback" id="error-nama_ekskul"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback" id="error-status"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                            <div class="invalid-feedback" id="error-deskripsi"></div>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <div class="form-text">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB</div>
                            <div class="invalid-feedback" id="error-foto"></div>

                            <!-- Preview Image -->
                            <div id="image-preview" class="mt-2" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail"
                                    style="max-width: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">
                            <span id="btn-text">Simpan</span>
                            <span id="btn-loading" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Create Button
            $('#btn-create').click(function() {
                resetForm();
                $('#modal-title').text('Tambah Ekstrakurikuler');
                $('#method').val('');
                $('#ekstrakurikuler-id').val('');
                $('#ekstrakurikulerModal').modal('show');
            });

            // Edit Button
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: `/ekstrakurikuler/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;

                            resetForm();
                            $('#modal-title').text('Edit Ekstrakurikuler');
                            $('#method').val('PUT');
                            $('#ekstrakurikuler-id').val(data.id);
                            $('#nama_ekskul').val(data.nama_ekskul);
                            $('#deskripsi').val(data.deskripsi);
                            $('#status').val(data.status ? '1' : '0');

                            // Show existing image if available
                            if (data.foto) {
                                $('#image-preview').show();
                                $('#preview-img').attr('src', `/storage/${data.foto}`);
                            }

                            $('#ekstrakurikulerModal').modal('show');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal memuat data', 'error');
                    }
                });
            });

            // Delete Button
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus "${name}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/ekstrakurikuler/${id}`,
                            type: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Berhasil!', response.message, 'success');
                                    $(`#row-${id}`).remove();

                                    // Update row numbers
                                    updateRowNumbers();
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Gagal menghapus data', 'error');
                            }
                        });
                    }
                });
            });

            // Form Submit
            $('#ekstrakurikuler-form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const id = $('#ekstrakurikuler-id').val();
                const method = $('#method').val();

                let url = '/ekstrakurikuler';
                let type = 'POST';

                if (method === 'PUT') {
                    url = `/ekstrakurikuler/${id}`;
                    formData.append('_method', 'PUT');
                }

                // Show loading
                $('#btn-text').addClass('d-none');
                $('#btn-loading').removeClass('d-none');
                $('#btn-save').prop('disabled', true);

                // Clear previous errors
                clearErrors();

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#ekstrakurikulerModal').modal('hide');
                            location.reload(); // Reload page to show updated data
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            showErrors(errors);
                        } else {
                            Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                        }
                    },
                    complete: function() {
                        // Hide loading
                        $('#btn-text').removeClass('d-none');
                        $('#btn-loading').addClass('d-none');
                        $('#btn-save').prop('disabled', false);
                    }
                });
            });

            // File Input Change Event
            $('#foto').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-img').attr('src', e.target.result);
                        $('#image-preview').show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#image-preview').hide();
                }
            });

            // Helper Functions
            function resetForm() {
                $('#ekstrakurikuler-form')[0].reset();
                $('#image-preview').hide();
                clearErrors();
            }

            function clearErrors() {
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            }

            function showErrors(errors) {
                for (const field in errors) {
                    $(`#${field}`).addClass('is-invalid');
                    $(`#error-${field}`).text(errors[field][0]);
                }
            }

            function updateRowNumbers() {
                $('#ekstrakurikuler-table tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }
        });
    </script>
@endpush
