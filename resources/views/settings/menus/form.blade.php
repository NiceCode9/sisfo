@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ isset($menu) ? route('admin.menus.update', $menu->id) : route('admin.menus.store') }}"
                method="POST">
                @csrf
                @if (isset($menu))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Nama Menu</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $menu->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon"
                                name="icon" value="{{ old('icon', $menu->icon ?? '') }}"
                                placeholder="Contoh: fas fa-home">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Gunakan class icon dari Font Awesome (fas) atau Bootstrap Icons (bi)
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="route">Route</label>
                            <input type="text" class="form-control @error('route') is-invalid @enderror" id="route"
                                name="route" value="{{ old('route', $menu->route ?? '') }}"
                                placeholder="Contoh: admin.dashboard">
                            @error('route')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="url">URL</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" id="url"
                                name="url" value="{{ old('url', $menu->url ?? '') }}" placeholder="Contoh: /dashboard">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Isi route atau url, tidak perlu mengisi keduanya
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="group">Group Module</label>
                            <select class="form-control @error('group') is-invalid @enderror" id="group" name="group">
                                <option value="">-- Pilih Group Module --</option>
                                <option value="Dashboard"
                                    {{ old('group', $menu->group ?? '') == 'Dashboard' ? 'selected' : '' }}>Dashboard
                                </option>
                                <option value="Master Data"
                                    {{ old('group', $menu->group ?? '') == 'Master Data' ? 'selected' : '' }}>Master Data
                                </option>
                                <option value="PPDB" {{ old('group', $menu->group ?? '') == 'PPDB' ? 'selected' : '' }}>
                                    Module PPDB</option>
                                <option value="E-Learning"
                                    {{ old('group', $menu->group ?? '') == 'E-Learning' ? 'selected' : '' }}>Module
                                    E-Learning</option>
                                <option value="Pengaturan"
                                    {{ old('group', $menu->group ?? '') == 'Pengaturan' ? 'selected' : '' }}>Pengaturan
                                </option>
                            </select>
                            @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Group digunakan untuk mengelompokkan menu di sidebar</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="parent_id">Parent Menu</label>
                            <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id"
                                name="parent_id">
                                <option value="">-- Tanpa Parent --</option>
                                @foreach ($parentMenus as $parent)
                                    @if (!isset($menu) || $parent->id != $menu->id)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="permission">Permission</label>
                            <select class="form-control @error('permission') is-invalid @enderror" id="permission"
                                name="permission">
                                <option value="">-- Tanpa Permission --</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission }}"
                                        {{ old('permission', $menu->permission ?? '') == $permission ? 'selected' : '' }}>
                                        {{ $permission }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="order">Urutan</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order"
                                name="order" value="{{ old('order', $menu->order ?? 0) }}" required>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <div class="form-check pt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $menu->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <div class="form-check pt-4">
                                <input class="form-check-input" type="checkbox" id="is_header" name="is_header"
                                    value="1" {{ old('is_header', $menu->is_header ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_header">
                                    Header Menu
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection
