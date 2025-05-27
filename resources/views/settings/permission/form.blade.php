@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ isset($permission) ? 'Edit Permission' : 'Tambah Permission Baru' }}
            </h6>
        </div>
        <div class="card-body">
            <form
                action="{{ isset($permission) ? route('admin.permissions.update', $permission->id) : route('admin.permissions.store') }}"
                method="POST">
                @csrf
                @if (isset($permission))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name">Nama Permission</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $permission->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: group.action (contoh: ppdb.calon_siswa.view)</small>
                </div>

                <div class="mb-3">
                    <label for="group">Group</label>
                    <input type="text" list="groups" class="form-control @error('group') is-invalid @enderror"
                        id="group" name="group" value="{{ old('group', $permission->group ?? '') }}" required>
                    <datalist id="groups">
                        @foreach ($groups as $group)
                            <option value="{{ $group }}">
                        @endforeach
                    </datalist>
                    @error('group')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="2">{{ old('description', $permission->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection
