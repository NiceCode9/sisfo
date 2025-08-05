@extends('landing.guest')

@section('title', 'Ekstrakurikuler')

@section('content')
    <!-- Hero Section -->
    <section class="hero-bg min-h-[60vh] flex items-center justify-center text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Ekstrakurikuler
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                    Kembangkan bakat dan minatmu melalui berbagai kegiatan ekstrakurikuler yang menarik
                </p>
            </div>
        </div>

        <!-- Floating shapes -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white opacity-10 rounded-full animate-float"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-white opacity-5 rounded-full animate-float animation-delay-200">
        </div>
    </section>

    <!-- Ekstrakurikuler Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4 animate-slide-up">
                    Pilihan Ekstrakurikuler
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto animate-slide-up animation-delay-100">
                    Bergabunglah dengan ekstrakurikuler pilihan dan kembangkan potensi terbaikmu
                </p>
            </div>

            @if ($ekstrakurikulers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($ekstrakurikulers as $index => $ekskul)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-scale animate-slide-up"
                            style="animation-delay: {{ ($index + 1) * 0.1 }}s">

                            <!-- Image -->
                            <div class="h-48 bg-gradient-to-br from-primary to-secondary relative overflow-hidden">
                                @if ($ekskul->foto_url)
                                    <img src="{{ $ekskul->foto_url }}" alt="{{ $ekskul->nama_ekskul }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-users text-6xl text-white opacity-50"></i>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $ekskul->status_label }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-3">
                                    {{ $ekskul->nama_ekskul }}
                                </h3>

                                <p class="text-gray-600 mb-6 line-clamp-3">
                                    {{ $ekskul->deskripsi ?? 'Bergabunglah dengan ekstrakurikuler ini dan kembangkan kemampuanmu!' }}
                                </p>

                                <!-- Action Button -->
                                <button onclick="openModal('{{ $ekskul->id }}', '{{ $ekskul->nama_ekskul }}')"
                                    class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition duration-300">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Daftar Sekarang
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-white rounded-2xl shadow-lg p-12 max-w-md mx-auto">
                        <i class="fas fa-info-circle text-6xl text-gray-400 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Ekstrakurikuler</h3>
                        <p class="text-gray-600">Ekstrakurikuler sedang dalam persiapan. Silakan cek kembali nanti.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Modal Pendaftaran -->
    <div id="modalPendaftaran"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-primary to-secondary text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Pendaftaran Ekstrakurikuler</h3>
                        <p class="text-blue-100 mt-1" id="namaEkskul">-</p>
                    </div>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 transition duration-200">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="formPendaftaran" class="p-6">
                @csrf
                <input type="hidden" id="ekstrakurikuler_id" name="ekstrakurikuler_id">

                <!-- Alert Messages -->
                <div id="alertSuccess"
                    class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="successMessage"></span>
                    </div>
                </div>

                <div id="alertError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span id="errorMessage"></span>
                    </div>
                </div>

                <!-- Pilih Siswa -->
                <div class="mb-6">
                    <label for="siswa_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-primary"></i>
                        Pilih Nama Siswa
                    </label>
                    <select id="siswa_id" name="siswa_id" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition duration-200">
                        <option value="">-- Pilih Nama Siswa --</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} -
                                {{ $s->kelas ?? 'Kelas tidak diset' }}</option>
                        @endforeach
                    </select>
                    <div id="siswa_id_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <!-- Catatan -->
                <div class="mb-6">
                    <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-sticky-note mr-2 text-primary"></i>
                        Catatan (Opsional)
                    </label>
                    <textarea id="catatan" name="catatan" rows="3"
                        placeholder="Tulis catatan atau alasan mengapa ingin bergabung..."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition duration-200 resize-none"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-xl font-semibold hover:bg-gray-300 transition duration-200">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn"
                        class="flex-1 bg-gradient-to-r from-primary to-secondary text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Modal Functions
        function openModal(ekskulId, namaEkskul) {
            document.getElementById('ekstrakurikuler_id').value = ekskulId;
            document.getElementById('namaEkskul').textContent = namaEkskul;

            const modal = document.getElementById('modalPendaftaran');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');

            // Reset form and alerts
            document.getElementById('formPendaftaran').reset();
            document.getElementById('ekstrakurikuler_id').value = ekskulId;
            hideAlerts();

            // Animate modal
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('modalPendaftaran');
            const modalContent = document.getElementById('modalContent');

            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function hideAlerts() {
            document.getElementById('alertSuccess').classList.add('hidden');
            document.getElementById('alertError').classList.add('hidden');

            // Hide field errors
            const errorElements = document.querySelectorAll('[id$="_error"]');
            errorElements.forEach(el => el.classList.add('hidden'));
        }

        function showAlert(type, message) {
            hideAlerts();
            const alertElement = document.getElementById(type === 'success' ? 'alertSuccess' : 'alertError');
            const messageElement = document.getElementById(type === 'success' ? 'successMessage' : 'errorMessage');

            messageElement.textContent = message;
            alertElement.classList.remove('hidden');
        }

        function showFieldErrors(errors) {
            Object.keys(errors).forEach(field => {
                const errorElement = document.getElementById(`${field}_error`);
                if (errorElement) {
                    errorElement.textContent = errors[field][0];
                    errorElement.classList.remove('hidden');
                }
            });
        }

        // Form Submit
        document.getElementById('formPendaftaran').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            // Show loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mendaftar...';
            submitBtn.disabled = true;

            hideAlerts();

            try {
                const formData = new FormData(this);

                const response = await fetch('{{ route('ekstrakurikuler.daftar') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('success', data.message);

                    // Close modal after 2 seconds
                    setTimeout(() => {
                        closeModal();
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }

            } catch (error) {
                if (error.name === 'TypeError') {
                    // Network error
                    showAlert('error', 'Terjadi kesalahan koneksi. Silakan coba lagi.');
                } else {
                    showAlert('error', error.message);
                }
            } finally {
                // Restore button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Handle validation errors from server
        window.addEventListener('validationErrors', function(e) {
            showFieldErrors(e.detail.errors);
        });

        // Close modal when clicking outside
        document.getElementById('modalPendaftaran').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Modal animations */
        #modalContent.scale-95 {
            transform: scale(0.95);
        }

        #modalContent.scale-100 {
            transform: scale(1);
        }

        #modalContent.opacity-0 {
            opacity: 0;
        }

        #modalContent.opacity-100 {
            opacity: 1;
        }
    </style>
@endpush
