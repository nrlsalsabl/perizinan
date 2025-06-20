<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PTSP</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero {
            text-align: center;
            padding: 2rem 0;
        }
        .logos {
            gap: 2rem;
        }
        .service-item {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
        }
        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .service-item a {
            text-decoration: none;
            color: #2c3e50;
        }
        .service-item img {
            height: 80px;
            margin-bottom: 1.5rem;
            object-fit: contain;
        }
        .service-item h4 {
            font-weight: 600;
            margin-top: 1rem;
        }
        .hero p {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <section class="hero">
            <div class="logos d-flex justify-content-center align-items-center">
                <img src="https://e-ptsp.kaltimprov.go.id/assets/portal/img/logo.png" height="100px" alt="Logo 1"/>
                <img src="https://e-ptsp.kaltimprov.go.id/assets/portal/img/LOGO_DPMPTSP2.png" width="300px" alt="Logo 2"/>
            </div>
            <p class="text-muted">Silakan pilih salah satu layanan kami untuk informasi lebih lanjut:</p>
        </section>
        <div class="row">
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="service-item">
                    <a href="https://oss.go.id/">
                        <img src="https://e-ptsp.kaltimprov.go.id/assets/portal/img/oss.png" alt="Online Single Submission">
                        <h4><i class="fas fa-share-square mr-2"></i>Online Single Submission</h4>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="service-item">
                    <a href="{{ route('perizinan-online') }}">
                        <img src="https://e-ptsp.kaltimprov.go.id/assets/portal/img/eptsp.png" alt="Perizinan Online">
                        <h4><i class="fas fa-file-alt mr-2"></i>Perizinan Online</h4>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="service-item">
                    <a href="{{ route('persyaratan') }}">
                        <img src="https://e-ptsp.kaltimprov.go.id/assets/portal/img/clipboard.png" alt="Persyaratan">
                        <h4><i class="fas fa-clipboard-list mr-2"></i>Persyaratan</h4>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="service-item">
                    <a href="https://dpmptsp.kaltimprov.go.id/home?v2">
                        <img src="https://e-ptsp.kaltimprov.go.id/assets/portal/img/web.png" alt="Website">
                        <h4><i class="fas fa-globe mr-2"></i>Website</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
