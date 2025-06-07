@extends('layouts.app')

@section('title', 'Tambah Soal')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Soal untuk Tugas: {{ $tugas->judul }}</h3>
                    </div>W
                    <div class="card-body">
                        <form action="{{ route('admin.soal.store') }}" method="POST" id="formSoal">
                            @csrfW
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
                                <div class="jawaban-list">
                                    <div class="jawaban-item mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="jawaban[0][teks_jawaban]"
                                                placeholder="Teks jawaban">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="radio" name="jawaban_benar" value="0"
                                                        onchange="updateJawabanBenar(0)">
                                                    <label class="mb-0 ml-2">Jawaban Benar</label>
                                                </div>
                                            </div>
                                            <input type="hidden" name="jawaban[0][jawaban_benar]" value="false">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary mb-3" onclick="tambahJawaban()">
                                    Tambah Pilihan Jawaban
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
        let jawabanCounter = 1;

        function toggleJawabanContainer() {
            const jenisSoal = $('#jenis_soal').val();
            const container = $('#jawaban-container');

            if (jenisSoal === 'pilihan_ganda') {
                container.show();
                if ($('.jawaban-item').length === 0) {
                    tambahJawaban();
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
                        placeholder="Teks jawaban">
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
                    <input type="hidden" name="jawaban[${jawabanCounter}][jawaban_benar]" value="false">
                </div>
            </div>
        `;
            $('.jawaban-list').append(jawabanHtml);
            jawabanCounter++;
        }

        function hapusJawaban(button) {
            $(button).closest('.jawaban-item').remove();
        }

        function updateJawabanBenar(index) {
            // Reset semua jawaban ke false
            $('input[name^="jawaban"][name$="[jawaban_benar]"]').val('false');
            // Set jawaban yang dipilih ke true
            $(`input[name="jawaban[${index}][jawaban_benar]"]`).val('true');
        }

        $(document).ready(function() {
            $('#jenis_soal').change(toggleJawabanContainer);
            toggleJawabanContainer();
        });
    </script>
@endpush
