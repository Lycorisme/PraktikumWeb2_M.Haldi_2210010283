<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Print-specific styles */
        @media print {
            @page {
                size: A4 landscape;
                margin: 1.5cm;
            }
            
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }
        }

        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            color: #333;
        }

        .page-container {
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1200px;
        }

        .header-section {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }

        .university-logo {
            max-width: 100px;
            height: auto;
        }

        .document-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin: 1rem 0;
        }

        .metadata {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .table-container {
            margin: 2rem 0;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        .data-table th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 1rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .data-table td {
            padding: 1rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .student-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }

        .footer-section {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #dee2e6;
        }

        .signature-area {
            margin-top: 2rem;
            text-align: right;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
            color: rgba(0,0,0,0.03);
            z-index: -1;
            pointer-events: none;
        }

        .stripe-row {
            background-color: #f8f9fa;
        }

        .print-info {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 1rem;
        }
    </style>
</head>
<body onload="window.print()">
    <!-- Watermark -->
    <div class="watermark">CONFIDENTIAL</div>

    <div class="page-container">
        <!-- Header Section -->
        <header class="header-section">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="{{asset('images/logo-uniska-ok-300x300.png')}}" alt="Logo Universitas" class="university-logo">
                </div>
                <div class="col">
                    <h1 class="document-title">Data Mahasiswa</h1>
                    <div class="metadata">
                        <div>Tahun Akademik: {{date('Y')}}/{{date('Y')+1}}</div>
                        <div>Tanggal Cetak: {{Carbon\Carbon::now()->format('d F Y H:i:s')}}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Table Section -->
        <div class="table-container">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%">No</th>
                        <th scope="col" style="width: 20%">Jurusan</th>
                        <th scope="col" style="width: 15%">NPM</th>
                        <th scope="col" style="width: 25%">Nama</th>
                        <th scope="col" style="width: 20%">Tanggal Lahir</th>
                        <th scope="col" style="width: 15%">Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $data)
                    <tr class="{{$loop->iteration % 2 == 0 ? 'stripe-row' : ''}}">
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$data->jurusan}}</td>
                        <td>{{$data->npm}}</td>
                        <td>{{$data->nama}}</td>
                        <td>{{Carbon\Carbon::parse($data->tanggal_lahir)->format('d F Y')}}</td>
                        <td class="text-center">
                            <img src="{{asset('storage/mahasiswa/'.$data->foto)}}" 
                                 alt="Foto {{$data->nama}}" 
                                 class="student-photo"
                                 onerror="this.src='{{asset('storage/default-avatar.png')}}'"
                            >
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <footer class="footer-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="print-info">
                        <p class="mb-1">
                            <small>
                                <i class="fas fa-info-circle"></i> 
                                Dokumen ini dicetak secara otomatis pada {{Carbon\Carbon::now()->format('d F Y H:i:s')}}
                            </small>
                        </p>
                        <p class="mb-1">
                            <small>
                                <i class="fas fa-shield-alt"></i>
                                Dokumen ini dilindungi dan bersifat rahasia
                            </small>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="signature-area">
                        <p>{{config('app.city')}}, {{Carbon\Carbon::now()->format('d F Y')}}</p>
                        <p>Kepala Program Studi</p>
                        <br><br><br>
                        <p><strong>________________________</strong></p>
                        <p>NIP. ...</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Print Button (only visible on screen) -->
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add page numbers
            let style = document.createElement('style');
            style.innerHTML = `
                @media print {
                    .page-container {
                        counter-reset: page;
                    }
                    .page-container::after {
                        content: "Halaman " counter(page);
                        counter-increment: page;
                        position: fixed;
                        bottom: 1cm;
                        right: 1cm;
                        font-size: 0.8rem;
                        color: #666;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>