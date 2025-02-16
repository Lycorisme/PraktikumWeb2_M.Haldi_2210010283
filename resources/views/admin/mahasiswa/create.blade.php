@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 animated-card">
                    <!-- Card Header -->
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-user-plus fa-fw me-2"></i>
                                Tambah Mahasiswa Baru
                            </h5>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Alert Error -->
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show animated-alert" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fs-5 me-2"></i>
                                <strong>Oops!</strong>
                            </div>
                            <ul class="mb-0 mt-2 ps-3">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('mahasiswa.store') }}" method="post" enctype="multipart/form-data" 
                              class="needs-validation" id="formMahasiswa" novalidate>
                            @csrf
                            
                            <div class="row">
                                <!-- Jurusan -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-graduation-cap me-2"></i>Jurusan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required>
                                            <option value="">- Pilih Jurusan -</option>
                                            <option value="TI" {{ old('jurusan') == 'TI' ? 'selected' : '' }}>Teknik Informatika</option>
                                            <option value="SI" {{ old('jurusan') == 'SI' ? 'selected' : '' }}>Sistem Informasi</option>
                                        </select>
                                        @error('jurusan')
                                        <div class="invalid-feedback animated-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- NPM -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-id-card me-2"></i>NPM
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="npm" class="form-control @error('npm') is-invalid @enderror" 
                                               value="{{ old('npm') }}" required maxlength="10" placeholder="Masukkan NPM"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <div class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Hanya angka, maksimal 10 digit
                                        </div>
                                        @error('npm')
                                        <div class="invalid-feedback animated-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nama -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-user me-2"></i>Nama Lengkap
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                               value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap">
                                        @error('nama')
                                        <div class="invalid-feedback animated-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-calendar me-2"></i>Tanggal Lahir
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="tanggal_lahir" 
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                               value="{{ old('tanggal_lahir') }}" required>
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback animated-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Foto -->
                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-camera me-2"></i>Foto
                                        </label>
                                        <div class="custom-file-container">
                                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" 
                                                   id="foto" accept="image/*" onchange="previewImage()">
                                            <div class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Format: JPG, JPEG, PNG (Maks: 2MB)
                                            </div>
                                            <div class="mt-2 text-center">
                                                <img id="preview" src="#" alt="Preview" 
                                                     class="img-thumbnail d-none" style="max-height: 200px">
                                            </div>
                                            @error('foto')
                                            <div class="invalid-feedback animated-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('mahasiswa.index') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali
                            </a>
                                <button type="reset" class="btn btn-danger" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animations */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animated-card {
    transition: all 0.3s ease;
}

.animated-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
}

.animated-alert {
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    from { transform: translateX(-100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.animated-feedback {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Form Styles */
.form-control, .form-select {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.form-label {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

/* Button Styles */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.15);
}

/* Custom Styles */
.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}

.card-header {
    border-bottom: none;
}

.custom-file-container {
    position: relative;
}

.img-thumbnail {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
}

.img-thumbnail:hover {
    transform: scale(1.05);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('formMahasiswa');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            Swal.fire({
                title: 'Oops!',
                text: 'Mohon lengkapi semua field yang diperlukan',
                icon: 'error',
                customClass: {
                    popup: 'swal2-show',
                    title: 'text-xl font-bold mb-4',
                    confirmButton: 'btn btn-primary px-4'
                },
                buttonsStyling: false
            });
        } else {
            // Show loading state
            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
        
        form.classList.add('was-validated');
    });

    // Input animations
    const inputs = document.querySelectorAll('.form-control, .form-select');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('.form-label').style.color = '#4e73df';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.querySelector('.form-label').style.color = '';
        });
    });

    // NPM Validation
    const npmInput = document.querySelector('input[name="npm"]');
    npmInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
});

// Image preview with validation
function previewImage() {
    const input = document.getElementById('foto');
    const preview = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        // Validate file size
        const fileSize = input.files[0].size / 1024 / 1024; // Convert to MB
        if (fileSize > 2) {
            Swal.fire({
                title: 'File Terlalu Besar!',
                text: 'Ukuran foto maksimal 2MB',
                icon: 'error',
                customClass: {
                    popup: 'swal2-show',
                    title: 'text-xl font-bold mb-4',
                    confirmButton: 'btn btn-primary px-4'
                },
                buttonsStyling: false
            });
            input.value = '';
            preview.src = '#';
            preview.classList.add('d-none');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Reset form with confirmation
function resetForm() {
    Swal.fire({
        title: 'Reset Form?',
        text: 'Semua data yang telah diisi akan dihapus',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'swal2-show',
            title: 'text-xl font-bold mb-4',
            confirmButton: 'btn btn-primary px-4 me-2',
            cancelButton: 'btn btn-secondary px-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formMahasiswa').reset();
            document.getElementById('preview').classList.add('d-none');
            document.getElementById('formMahasiswa').classList.remove('was-validated');
        }
    });
}

// Flash message handler
@if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        icon: 'success',
        customClass: {
            popup: 'swal2-show',
            title: 'text-xl font-bold mb-4',
            confirmButton: 'btn btn-primary px-4'
        },
        buttonsStyling: false,
        timer: 2000,
        timerProgressBar: true
    });
@endif

@if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session("error") }}',
        icon: 'error',
        customClass: {
            popup: 'swal2-show',
            title: 'text-xl font-bold mb-4',
            confirmButton: 'btn btn-primary px-4'
        },
        buttonsStyling: false
    });
@endif

// Add hover effect to all buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 0.5rem 1rem rgba(0, 0, 0, 0.15)';
    });

    button.addEventListener('mouseleave', function() {
        this.style.transform = '';
        this.style.boxShadow = '';
    });
});

// Add floating label effect
document.querySelectorAll('.form-control, .form-select').forEach(input => {
    input.addEventListener('focus', function() {
        const label = this.previousElementSibling;
        if (label && label.classList.contains('form-label')) {
            label.style.transform = 'translateY(-5px) scale(0.95)';
            label.style.color = '#4e73df';
        }
    });

    input.addEventListener('blur', function() {
        const label = this.previousElementSibling;
        if (label && label.classList.contains('form-label')) {
            if (!this.value) {
                label.style.transform = '';
            }
            label.style.color = '';
        }
    });

    // Initialize on load if has value
    if (input.value) {
        const label = input.previousElementSibling;
        if (label && label.classList.contains('form-label')) {
            label.style.transform = 'translateY(-5px) scale(0.95)';
        }
    }
});

// Add animated validation feedback
document.querySelectorAll('.form-control, .form-select').forEach(input => {
    input.addEventListener('invalid', function(e) {
        e.preventDefault();
        this.classList.add('shake-animation');
        setTimeout(() => {
            this.classList.remove('shake-animation');
        }, 500);
    });
});
</script>

<style>
/* Additional animations */
.shake-animation {
    animation: shake 0.5s ease-in-out;
}

/* Floating label animation */
.form-label {
    transition: all 0.3s ease;
    transform-origin: left top;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #4e73df;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #224abe;
}

/* Button hover animation */
.btn {
    position: relative;
    overflow: hidden;
}

.btn::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.btn:active::after {
    width: 300%;
    height: 300%;
}
</style>
@endsection