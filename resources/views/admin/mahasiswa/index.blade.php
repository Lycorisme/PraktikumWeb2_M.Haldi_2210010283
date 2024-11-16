@extends('layouts.app')

@section('styles')
<!-- Sweet Alert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.min.css">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!-- Custom CSS -->
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .table-container {
        animation: fadeIn 0.8s ease-in-out;
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    .card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .card-header {
        background: linear-gradient(45deg, #1a237e 0%, #283593 100%);
        color: white;
        font-weight: 600;
        font-size: 1.4rem;
        padding: 1.2rem;
        border-radius: 10px 10px 0 0;
        text-align: center;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .logo-icon {
        font-size: 2rem;
        color: #fff;
        margin-right: 10px;
    }

    .card-body {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 0 0 10px 10px;
        padding: 2rem;
    }
    
    .btn {
        transition: all 0.3s ease;
        border-radius: 5px;
        font-weight: 500;
        padding: 8px 20px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .btn-primary {
        background: #4e73df;
        border: none;
    }
    
    .btn-primary:hover {
        background: #224abe;
    }
    
    .btn-success {
        background: #1cc88a;
        border: none;
    }
    
    .btn-success:hover {
        background: #169b6b;
    }
    
    .btn-warning {
        background: #f6c23e;
        border: none;
        color: white;
    }
    
    .btn-warning:hover {
        background: #dda20a;
        color: white;
    }
    
    .btn-danger {
        background: #e74a3b;
        border: none;
    }
    
    .btn-danger:hover {
        background: #be2617;
    }
    
    .search-input {
        border-radius: 20px;
        padding: 10px 20px;
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
        width: 300px;
    }
    
    .search-input:focus {
        box-shadow: 0 0 15px rgba(78,115,223,0.1);
        border-color: #4e73df;
        width: 350px;
    }
    
    .table {
        animation: slideInUp 0.5s ease-out;
        background: white;
        border-radius: 10px;
        margin-bottom: 0;
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .table th {
        background: #f8f9fc;
        color: #4e73df;
        text-transform: uppercase;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center !important;
        vertical-align: middle !important;
        padding: 1rem;
    }
    
    .table td {
        text-align: center !important;
        vertical-align: middle !important;
        padding: 1rem;
        transition: all 0.2s ease;
    }
    
    .table tr:hover td {
        background-color: #f8f9fc;
    }
    
    .student-img {
        border-radius: 8px;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin: 0 auto;
        display: block;
    }
    
    .student-img:hover {
        transform: scale(1.1);
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        padding: 3px 6px;
        border-radius: 50%;
        background: #e74a3b;
        color: white;
        font-size: 0.7rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #858796;
    }

    .table-responsive {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        margin: 0 auto;
        max-width: 900px;
    }

    .d-flex.mb-4 {
        justify-content: space-between;
        margin: 0 auto;
        max-width: 900px;
        align-items: center;
    }

    .input-group {
        width: auto;
    }

    .input-group-text {
        border: none;
        padding: 0.6rem 1.2rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="table-container">
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <i class="fas fa-graduation-cap logo-icon"></i>
                    <span>Data Mahasiswa</span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex mb-4">
                    <form action="{{route('mahasiswa.index')}}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input 
                                class="form-control search-input" 
                                type="text" 
                                name="keyword" 
                                placeholder="Cari berdasarkan nama dan jurusan..." 
                                value="{{old('keyword')}}"
                            >
                        </div>
                    </form>
                    
                    <div class="ms-auto">
                        <a href="{{route('mahasiswa.print')}}" class="btn btn-success me-2">
                            <i class="fas fa-print me-1"></i> Cetak Data
                        </a>
                        <a class="btn btn-primary" href="{{route('mahasiswa.create')}}">
                            <i class="fas fa-plus me-1"></i> Tambah Data
                        </a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama</th>
                                <th style="width: 15%;">NPM</th>
                                <th style="width: 20%;">Tanggal Lahir</th>
                                <th style="width: 15%;">Foto</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mahasiswa as $data)
                            <tr class="align-middle">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->npm}}</td>
                                <td>{{Carbon\carbon::parse($data->tanggal_lahir)->format('d-m-Y')}}</td>
                                <td>
                                    <img 
                                        src="{{asset('storage/mahasiswa/'.$data->foto)}}" 
                                        alt="Foto {{$data->nama}}" 
                                        width="60" 
                                        class="student-img"
                                    >
                                </td>
                                <td>
                                    <form action="{{route('mahasiswa.delete',$data->id)}}" method="post" class="delete-form">
                                        @csrf
                                        @method('delete')
                                        <div class="action-buttons">
                                            <a href="{{route('mahasiswa.edit',$data->id)}}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="submit" class="btn btn-danger delete-btn">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                    <p>Tidak ada data mahasiswa</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<!-- Custom JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                width: '400px',
                padding: '2em',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    
    // Success message
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        width: '400px',
        padding: '2em',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
    @endif
    
    // Error message
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        width: '400px',
        padding: '2em'
    });
    @endif
    
    // Table row hover animation
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Search input animation
    const searchInput = document.querySelector('.search-input');
    searchInput.addEventListener('focus', function() {
        this.style.width = '350px';
    });
    
    searchInput.addEventListener('blur', function() {
        if (!this.value) {
            this.style.width = '300px';
        }
    });
});
</script>
@endsection