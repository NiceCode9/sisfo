@extends('layouts.app')

@section('title', 'Edit Soal')

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
                        <h3 class="card-title">Edit Soal untuk Tugas: {{ $soal->tugas->judul }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('soal.update', $soal->id) }}" method="POST" id="formSoal">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="pertanyaan">Pertanyaan</label>
                                <textarea class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan" name="pertanyaan"
                                    rows="3" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                                @error('pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="poin">Poin</label>
                                <input type="number" class="form-control @error('poin') is-invalid @enderror"
                                    id="poin" name="poin" value="{{ old('poin', $soal->poin) }}" min="1"
                                    max="100" required>
                                @error('poin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="urutan">Urutan</label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                    id="urutan" name="urutan" value="{{ old('urutan', $soal->urutan) }}" min="1"
                                    required>
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($soal->jenis_soal === 'pilihan_ganda')
                                <div id="jawaban-container">
                                    <h4>Pilihan Jawaban</h4>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            * Minimal 2 pilihan jawaban
                                            * Satu jawaban harus dipilih sebagai jawaban benar
                                        </small>
                                    </div>
                                    <div class="jawaban-list">
                                        @foreach ($soal->jawaban as $index => $jawaban)
                                            <div class="jawaban-item mb-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        name="jawaban[{{ $index }}][teks_jawaban]"
                                                        placeholder="Teks jawaban" value="{{ $jawaban->teks_jawaban }}"
                                                        required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <input type="radio" name="jawaban_benar"
                                                                value="{{ $index }}"
                                                                onchange="updateJawabanBenar({{ $index }})"
                                                                {{ $jawaban->jawaban_benar ? 'checked' : '' }}>
                                                            <label class="mb-0 ml-2">Jawaban Benar</label>
                                                        </div>
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="hapusJawaban(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden"
                                                        name="jawaban[{{ $index }}][jawaban_benar]"
                                                        value="{{ $jawaban->jawaban_benar ? '1' : '0' }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-secondary mb-3" onclick="tambahJawaban()">
                                        <i class="fas fa-plus"></i> Tambah Pilihan Jawaban
                                    </button>
                                </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('tugas.show', $soal->tugas_id) }}" class="btn btn-secondary">
                                    Batal
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
        let jawabanCounter = {{ $soal->jawaban->count() }};

        function tambahJawaban() {
            const jawabanHtml = `
            <div class="jawaban-item mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="jawaban[${jawabanCounter}][teks_jawaban]"
                        placeholder="Teks jawaban" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="radio" name="jawaban_benar" value="${jawabanCounter}"
                                onchange="updateJawabanBenar(${jawabanCounter})">
                            <label class="mb-0 ml-2">Jawaban Benar</label>
                        </div>
                        <button type="button" class="btn btn-danger" onclick="hapusJawaban(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" name="jawaban[${jawabanCounter}][jawaban_benar]" value="0">
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
            // Validasi form sebelum submit
            $('#formSoal').on('submit', function(e) {
                @if ($soal->jenis_soal === 'pilihan_ganda')
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
                @endif
            });
        });
    </script>
@endpush
