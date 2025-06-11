@extends('layouts.app')

@section('title', 'Tambah Soal')

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <h4>Terjadi Kesalahan!</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Soal untuk Tugas: {{ $tugas->judul }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.soal.store') }}" method="POST" id="formSoal">
                            @csrf
                            <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">

                            <div class="form-group mb-3">
                                <label for="pertanyaan">Pertanyaan</label>
                                <textarea class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan" name="pertanyaan"
                                    rows="3" required>{{ old('pertanyaan') }}</textarea>
                                @error('pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="jenis_soal">Jenis Soal</label>
                                <select class="form-control @error('jenis_soal') is-invalid @enderror" id="jenis_soal"
                                    name="jenis_soal" required>
                                    <option value="uraian" {{ $tugas->jenis === 'uraian' ? 'selected' : '' }}>Uraian
                                    </option>
                                    <option value="pilihan_ganda" {{ $tugas->jenis === 'pilihan_ganda' ? 'selected' : '' }}>
                                        Pilihan Ganda</option>
                                </select>
                                @error('jenis_soal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="poin">Poin</label>
                                <input type="number" class="form-control @error('poin') is-invalid @enderror"
                                    id="poin" name="poin" value="{{ old('poin', 10) }}" min="1" required>
                                @error('poin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="urutan">Urutan</label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                    id="urutan" name="urutan" value="{{ old('urutan', 1) }}" min="1" required>
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="jawaban-container" style="display: none;">
                                <h4>Pilihan Jawaban</h4>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        * Minimal 2 pilihan jawaban
                                        * Satu jawaban harus dipilih sebagai jawaban benar
                                    </small>
                                </div>
                                <div class="jawaban-list">
                                </div>
                                <button type="button" class="btn btn-secondary mb-3" onclick="tambahJawaban()">
                                    <i class="fas fa-plus"></i> Tambah Pilihan Jawaban
                                </button>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="submit" class="btn btn-info" name="add_more" value="true">
                                    Simpan & Tambah Soal Lain
                                </button>
                                <a href="{{ route('admin.tugas.show', $tugas->id) }}" class="btn btn-secondary">
                                    Selesai
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let jawabanCounter = 0;

        function toggleJawabanContainer() {
            const jenisSoal = $('#jenis_soal').val();
            const container = $('#jawaban-container');

            if (jenisSoal === 'pilihan_ganda') {
                container.show();
                if ($('.jawaban-item').length < 2) {
                    while ($('.jawaban-item').length < 2) {
                        tambahJawaban();
                    }
                }
            } else {
                container.hide();
            }
        }

        function tambahJawaban() {
            const jawabanHtml = `
            <div class="jawaban-item mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="jawaban[${jawabanCounter}][teks_jawaban]"
                        placeholder="Teks jawaban" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="radio" name="jawaban_benar" value="${jawabanCounter}"
                                onchange="updateJawabanBenar(${jawabanCounter})" ${jawabanCounter === 0 ? 'checked' : ''}>
                            <label class="mb-0 ml-2">Jawaban Benar</label>
                        </div>
                        <button type="button" class="btn btn-danger" onclick="hapusJawaban(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" name="jawaban[${jawabanCounter}][jawaban_benar]" value="${jawabanCounter === 0 ? '1' : '0'}">
                </div>
            </div>
            `;
            $('.jawaban-list').append(jawabanHtml);
            jawabanCounter++;
        }

        function hapusJawaban(button) {
            const jawabanItem = $(button).closest('.jawaban-item');
            if ($('.jawaban-item').length <= 2) {
                alert('Minimal harus ada 2 pilihan jawaban!');
                return;
            }

            if (jawabanItem.find('input[type="radio"]').prop('checked')) {
                $('.jawaban-item').first().find('input[type="radio"]').prop('checked', true);
                updateJawabanBenar($('.jawaban-item').first().find('input[type="radio"]').val());
            }

            jawabanItem.remove();
        }

        function updateJawabanBenar(index) {
            // Reset semua jawaban ke false
            $('input[name^="jawaban"][name$="[jawaban_benar]"]').val('0');
            // Set jawaban yang dipilih ke true
            $(`input[name="jawaban[${index}][jawaban_benar]"]`).val('1');
        }

        $(document).ready(function() {
            $('#jenis_soal').change(toggleJawabanContainer);
            toggleJawabanContainer();

            // Validasi form sebelum submit
            $('#formSoal').on('submit', function(e) {
                const jenisSoal = $('#jenis_soal').val();

                if (jenisSoal === 'pilihan_ganda') {
                    // Cek minimal 2 pilihan jawaban
                    if ($('.jawaban-item').length < 2) {
                        e.preventDefault();
                        alert('Minimal harus ada 2 pilihan jawaban!');
                        return false;
                    }

                    // Cek apakah semua pilihan jawaban sudah diisi
                    let empty = false;
                    $('.jawaban-item input[type="text"]').each(function() {
                        if (!$(this).val()) {
                            empty = true;
                            return false;
                        }
                    });

                    if (empty) {
                        e.preventDefault();
                        alert('Semua pilihan jawaban harus diisi!');
                        return false;
                    }

                    // Cek apakah ada jawaban yang dipilih sebagai benar
                    if (!$('input[name="jawaban_benar"]:checked').length) {
                        e.preventDefault();
                        alert('Harus memilih satu jawaban yang benar!');
                        return false;
                    }
                }
            });
        });
    </script>
@endpush
