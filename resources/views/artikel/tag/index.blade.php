@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Tags</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tagModal">
                                <i class="fas fa-plus"></i> Tambah Tag
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tagsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Articles</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Create/Edit Tag -->
    <div class="modal fade" id="tagModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Tambah Tag</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="tagForm">
                    <div class="modal-body">
                        <div id="tagContainer">
                            <!-- Dynamic tag forms will be added here -->
                            <div class="tag-form-group" data-index="0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name_0">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="tags[0][name]" id="name_0"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_title_0">Meta Title</label>
                                            <input type="text" class="form-control" name="tags[0][meta_title]"
                                                id="meta_title_0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="description_0">Description</label>
                                            <textarea class="form-control" name="tags[0][description]" id="description_0" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_description_0">Meta Description</label>
                                            <textarea class="form-control" name="tags[0][meta_description]" id="meta_description_0" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_active_0" checked>
                                                <label class="form-label" class="form-check-label" for="is_active_0">
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-danger remove-tag-btn"
                                                style="display: none;">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="text-center" id="addTagSection">
                            <button type="button" class="btn btn-info" id="addTagBtn">
                                <i class="fas fa-plus"></i> Tambah Tag Lagi
                            </button>
                        </div>

                        <input type="hidden" id="tagId" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let tagIndex = 0;
            let isEdit = false;

            // Initialize DataTable
            const table = $('#tagsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('artikel.tags.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'articles_count',
                        name: 'articles_count',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Reset modal when opening
            $('#tagModal').on('show.bs.modal', function() {
                if (!isEdit) {
                    resetForm();
                }
            });

            // Add new tag form
            $('#addTagBtn').click(function() {
                tagIndex++;
                addTagForm(tagIndex);
                updateRemoveButtons();
            });

            // Remove tag form
            $(document).on('click', '.remove-tag-btn', function() {
                $(this).closest('.tag-form-group').remove();
                updateRemoveButtons();
            });

            // Form submission
            $('#tagForm').submit(function(e) {
                e.preventDefault();

                let submitData = {};

                if (isEdit) {
                    // For edit mode, handle single tag
                    submitData = {
                        name: $('#name_0').val(),
                        description: $('#description_0').val(),
                        meta_title: $('#meta_title_0').val(),
                        meta_description: $('#meta_description_0').val(),
                        is_active: $('#is_active_0').is(':checked') ? 1 : 0
                    };
                } else {
                    // For create mode, handle multiple tags
                    submitData.tags = [];

                    $('.tag-form-group').each(function() {
                        const index = $(this).data('index');
                        const tagData = {
                            name: $(`#name_${index}`).val(),
                            description: $(`#description_${index}`).val(),
                            meta_title: $(`#meta_title_${index}`).val(),
                            meta_description: $(`#meta_description_${index}`).val(),
                            is_active: $(`#is_active_${index}`).is(':checked') ? 1 : 0
                        };
                        submitData.tags.push(tagData);
                    });
                }

                const url = isEdit ? `/artikel/tags/${$('#tagId').val()}` :
                    '{{ route('artikel.tags.store') }}';
                const method = isEdit ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: submitData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': method
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                            $('#tagModal').modal('hide');
                            table.ajax.reload();
                            resetForm();
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        for (let key in errors) {
                            errorMessage += errors[key].join(', ') + '\n';
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Edit tag
            $(document).on('click', '.edit-btn', function() {
                const tagId = $(this).data('id');
                isEdit = true;

                $.ajax({
                    url: `/artikel/tags/${tagId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const tag = response.data;

                            $('#modalTitle').text('Edit Tag');
                            $('#tagId').val(tag.id);
                            $('#addTagSection').hide();

                            // Fill form with tag data
                            $('#name_0').val(tag.name);
                            $('#description_0').val(tag.description);
                            $('#meta_title_0').val(tag.meta_title);
                            $('#meta_description_0').val(tag.meta_description);
                            $('#is_active_0').prop('checked', tag.is_active);

                            // Hide remove button for single edit
                            $('.remove-tag-btn').hide();

                            $('#tagModal').modal('show');
                        }
                    }
                });
            });

            // Delete tag
            $(document).on('click', '.delete-btn', function() {
                const tagId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Tag ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/artikel/tags/${tagId}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                    table.ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON.message ||
                                        'Terjadi kesalahan',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            function addTagForm(index) {
                const formHtml = `
            <div class="tag-form-group" data-index="${index}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name_${index}">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tags[${index}][name]" id="name_${index}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="meta_title_${index}">Meta Title</label>
                            <input type="text" class="form-control" name="tags[${index}][meta_title]" id="meta_title_${index}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="description_${index}">Description</label>
                            <textarea class="form-control" name="tags[${index}][description]" id="description_${index}" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="meta_description_${index}">Meta Description</label>
                            <textarea class="form-control" name="tags[${index}][meta_description]" id="meta_description_${index}" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active_${index}" checked>
                                <label class="form-label" class="form-check-label" for="is_active_${index}">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <button type="button" class="btn btn-danger remove-tag-btn">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        `;

                $('#tagContainer').append(formHtml);
            }

            function updateRemoveButtons() {
                const tagForms = $('.tag-form-group');
                if (tagForms.length > 1) {
                    $('.remove-tag-btn').show();
                } else {
                    $('.remove-tag-btn').hide();
                }
            }

            function resetForm() {
                $('#tagForm')[0].reset();
                $('#modalTitle').text('Tambah Tag');
                $('#tagId').val('');
                $('#addTagSection').show();

                // Remove all additional tag forms
                $('.tag-form-group').not(':first').remove();

                // Reset first form
                $('.tag-form-group:first input, .tag-form-group:first textarea').val('');
                $('#is_active_0').prop('checked', true);

                tagIndex = 0;
                isEdit = false;
                updateRemoveButtons();
            }
        });
    </script>
@endpush
