<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Web 2 - Enhanced Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Root Variables */
        :root {
            --primary-color: #4e73df;
            --primary-dark: #2e59d9;
            --primary-light: #6f8ae4;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --sidebar-width: 250px;
            --topbar-height: 70px;
            --transition-speed: 0.3s;
        }

        /* Global Styles */
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--light-color);
            overflow-x: hidden;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Layout */
        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Enhanced Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(150deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            transition: all var(--transition-speed) ease;
            position: fixed;
            z-index: 1100;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.15);
        }

        #sidebar.toggled {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h2 {
            font-size: 1.2rem;
            margin: 0;
            white-space: nowrap;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-brand h2 i {
            font-size: 1.4rem;
            margin-right: 0.5rem;
            color: var(--light-color);
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 1rem 1rem;
            position: relative;
        }

        .sidebar-divider::after {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        /* Enhanced Navigation Items */
        .nav-item {
            position: relative;
            margin: 0.5rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: var(--light-color);
            transform: scaleY(0);
            transition: transform var(--transition-speed) ease;
        }

        .nav-link:hover::before,
        .nav-link.active::before {
            transform: scaleY(1);
        }

        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        .nav-link i {
            margin-right: 0.8rem;
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
            transition: all var(--transition-speed) ease;
        }

        .nav-link:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        /* Enhanced Content Wrapper */
        #content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all var(--transition-speed) ease;
            background: linear-gradient(135deg, var(--light-color) 0%, #ffffff 100%);
        }

        #content-wrapper.toggled {
            margin-left: 0;
        }

        /* Enhanced Topbar */
        .topbar {
            height: var(--topbar-height);
            background: white;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1090;
            backdrop-filter: blur(10px);
        }

        .sidebar-toggle {
            color: var(--primary-color);
            background: none;
            border: none;
            font-size: 1.5rem;
            padding: 0.5rem;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            border-radius: 0.5rem;
        }

        .sidebar-toggle:hover {
            color: var(--primary-dark);
            background: var(--light-color);
            transform: scale(1.1);
        }

        /* Enhanced User Info */
        .user-info {
            display: flex;
            align-items: center;
            margin-left: auto;
            padding: 0.5rem 1rem;
            background: var(--light-color);
            border-radius: 2rem;
            transition: all var(--transition-speed) ease;
        }

        .user-info:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-2px);
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.8rem;
            border: 2px solid var(--primary-color);
            transition: all var(--transition-speed) ease;
        }

        .user-info:hover img {
            border-color: white;
        }

        .user-info .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info .user-role {
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        /* Enhanced Content Area */
        #content {
            padding: 1.5rem;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Enhanced Cards */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.15);
            margin-bottom: 1.5rem;
            transition: all var(--transition-speed) ease;
            overflow: hidden;
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h6 {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        /* Enhanced Footer */
        .footer {
            padding: 1.5rem;
            background: white;
            text-align: center;
            color: var(--secondary-color);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        }

        /* Enhanced Logout Button */
        .logout-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            width: 100%;
            text-align: left;
            padding: 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--danger-color), var(--warning-color));
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }

        .logout-btn:hover::before {
            opacity: 0.2;
        }

        .logout-btn:hover {
            color: white;
            transform: translateX(5px);
        }

        .logout-btn i {
            margin-right: 0.8rem;
            width: 1.5rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Animations */
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

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        .slide-in {
            animation: slideIn 0.5s ease forwards;
        }

        /* Loading Spinner */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--light-color);
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 220px;
            }
        }

        @media (max-width: 992px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            #sidebar.toggled {
                margin-left: 0;
            }

            #content-wrapper {
                margin-left: 0;
            }

            #content-wrapper.toggled {
                margin-left: var(--sidebar-width);
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 0 1rem;
            }

            .user-info {
                display: none;
            }

            #content {
                padding: 1rem;
            }
        }

        /* Enhanced Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--light-color);
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: var(--primary-color);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.05);
        }

        .table tbody tr:hover {
            background-color: var(--light-color);
        }

        /* Custom Buttons */
        .btn-custom {
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all var(--transition-speed) ease;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-brand">
                <h2><i class="fas fa-laptop-code"></i>Praktikum Web 2</h2>
                </div>

<div class="sidebar-divider my-3">
    <span class="sidebar-heading">Menu Utama</span>
</div>

<!-- Main Navigation Items -->
<div class="nav-item">
    <a href="{{route('admin.index')}}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</div>

<!-- Academic Menu Section -->
<div class="nav-item">
    <a href="{{route('mahasiswa.index')}}" class="nav-link {{ request()->routeIs('mahasiswa.index') ? 'active' : '' }}">
        <i class="fas fa-fw fa-user-graduate"></i>
        <span>Mahasiswa</span>
    </a>
</div>

<!-- Logout Section -->
<div class="sidebar-divider my-3"></div>

<div class="nav-item">
    <form action="{{route('logout')}}" method="post" id="formlogout" class="nav-link p-0">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
</div>
</nav>

<!-- Content Wrapper -->
<div id="content-wrapper">
<!-- Topbar -->
<nav class="topbar">
    <button id="sidebarToggle" class="sidebar-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Search Bar -->
    <div class="d-none d-md-flex ms-4">
        <div class="input-group">
            <input type="text" class="form-control border-0 small" placeholder="Search for..." aria-label="Search">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Profile -->
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownUser">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('formlogout').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<div id="content" class="fade-in">
    @yield('content')
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid">
        <div class="copyright">
            <span>Copyright &copy; Praktikum Web 2 2024 | M.Haldi 2210010283</span>
        </div>
    </div>
</footer>
</div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
// Sidebar Toggle
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const contentWrapper = document.getElementById('content-wrapper');

sidebarToggle.addEventListener('click', function(e) {
    e.preventDefault();
    sidebar.classList.toggle('toggled');
    contentWrapper.classList.toggle('toggled');
});

// Logout Confirmation
const formLogout = document.getElementById('formlogout');
formLogout.addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin keluar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4e73df',
        cancelButtonColor: '#858796',
        confirmButtonText: 'Ya, Logout',
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
            formLogout.submit();
        }
    });
});

// Flash Messages
@if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
@endif

@if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session("error") }}',
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
@endif
});
</script>
</body>
</html>