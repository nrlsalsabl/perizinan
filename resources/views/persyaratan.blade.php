<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persyaratan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-title {
            color: #2c3e50;
            font-weight: 700;
            margin: 2rem 0;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
            text-align: center;
        }
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 2rem;
        }
        .card-header {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        .list-group-item {
            padding: 1rem 1.5rem;
            border-left: none;
            border-right: none;
            transition: all 0.3s;
        }
        .list-group-item:hover {
            background-color: #f1f8ff;
            transform: translateX(5px);
        }
        .list-group-item::before {
            content: "•";
            color: #3498db;
            font-weight: bold;
            display: inline-block; 
            width: 1em;
            margin-left: -1em;
        }
        .alert {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .alert-heading {
            color: #2c3e50;
        }
        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            color: white;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="header-title">
            <i class="fas fa-file-alt mr-2"></i>Persyaratan Perizinan
        </h1>
        
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">
                    <i class="fas fa-file-import mr-2"></i>Dokumen Yang Diperlukan
                </h2>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-list-check mr-2"></i>Persyaratan Umum</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">KTP (Kartu Tanda Penduduk) yang masih berlaku</li>
                            <li class="list-group-item">NPWP (Nomor Pokok Wajib Pajak)</li>
                            <li class="list-group-item">Pas foto terbaru ukuran 4x6 (latar belakang merah)</li>
                            <li class="list-group-item">Surat pernyataan kebenaran dokumen</li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-list-check mr-2"></i>Persyaratan Khusus</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Surat Izin Usaha</li>
                            <li class="list-group-item">Akta Pendirian Perusahaan (jika berbentuk badan usaha)</li>
                            <li class="list-group-item">Sertifikat tanah/bukti kepemilikan</li>
                            <li class="list-group-item">Izin lingkungan dari instansi terkait</li>
                            <li class="list-group-item">Dokumen studi kelayakan (jika diperlukan)</li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Catatan Penting!</h4>
                    <p>Semua dokumen harus dilengkapi sebelum mengajukan permohonan perizinan. Dokumen yang tidak lengkap akan memperlambat proses perizinan.</p>
                    <hr>
                    <p class="mb-0"><i class="fas fa-phone-alt mr-2"></i>Untuk informasi lebih lanjut, silakan hubungi layanan pelanggan kami.</p>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-back">
                        <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
