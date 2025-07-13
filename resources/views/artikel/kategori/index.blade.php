@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Kategori Berita</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kategoriModal">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="kategoriTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Gambar</th>
                                        <th>Status</th>
                                        <th>Urutan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kategoriForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="kategori_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Urutan</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus kategori ini?
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
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#kategoriTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('artikel.kategori.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sort_order',
                        name: 'sort_order'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Handle form submission
            $('#kategoriForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let id = $('#kategori_id').val();
                let url = id ? `/artikel/kategori/${id}` : '/artikel/kategori';
                // let method = id ? 'PUT' : 'POST';

                if (id) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#kategoriModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message);

                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: errorMessage,
                        });
                    }
                });
            });

            // Handle edit button click
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');

                $.get('/artikel/kategori/' + id, function(data) {
                    $('#kategoriModalLabel').text('Edit Kategori');
                    $('#kategori_id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#is_active').prop('checked', data.is_active);
                    $('#sort_order').val(data.sort_order);

                    // Clear and update image preview
                    $('#imagePreview').empty();
                    if (data.image) {
                        $('#imagePreview').html('<img src="/images/kategori/' + data.image +
                            '" width="100" class="img-thumbnail mb-2">');
                    }

                    $('#kategoriModal').modal('show');
                });
            });

            // Handle delete button click
            let deleteId;
            $(document).on('click', '.delete-btn', function() {
                deleteId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            // Handle confirm delete
            $('#confirmDelete').click(function() {
                $.ajax({
                    url: '/artikel/kategori/' + deleteId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menghapus kategori',
                        });
                    }
                });
            });

            // Reset form when modal is closed
            $('#kategoriModal').on('hidden.bs.modal', function() {
                $('#kategoriForm')[0].reset();
                $('#kategori_id').val('');
                $('#kategoriModalLabel').text('Tambah Kategori Baru');
                $('#imagePreview').empty();
            });

            // Preview image before upload
            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagePreview').html('<img src="' + e.target.result +
                        '" width="100" class="img-thumbnail mb-2">');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
