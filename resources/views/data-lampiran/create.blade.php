@extends('layouts.app')

@section('title', 'Data Lampiran')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body {
                background: #f8f9fa;
            }
            .form-container {
                background: white;
                padding: 3rem;
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                max-width: 900px;
                margin: 2rem auto;
                transition: all 0.3s ease;
            }
            .form-container:hover {
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }
            .form-title {
                color: #2c3e50;
                font-weight: 800;
                margin-bottom: 2.5rem;
                text-align: center;
                position: relative;
                padding-bottom: 15px;
                font-size: 2.2rem;
            }
            .form-title::after {
                content: '';
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                bottom: 0;
                width: 100px;
                height: 4px;
                background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
                border-radius: 2px;
            }
            .form-control {
                border-radius: 12px;
                padding: 12px 20px;
                border: 2px solid #e9ecef;
                transition: all 0.3s;
                font-size: 1rem;
                background-color: #f8f9fa;
            }
            .form-control:focus {
                border-color: #3498db;
                box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
                background-color: #fff;
            }
            .form-group {
                margin-bottom: 1.5rem;
            }
            .form-group label {
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 0.8rem;
                font-size: 1.1rem;
            }
            .form-group label i {
                color: #3498db;
                margin-right: 8px;
            }
            .btn {
                padding: 12px 30px;
                border-radius: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: all 0.3s;
            }
            .btn-success {
                background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
                border: none;
                box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
            }
            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(46, 204, 113, 0.3);
            }
            .btn-secondary {
                background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
                border: none;
                box-shadow: 0 4px 15px rgba(149, 165, 166, 0.2);
            }
            .btn-secondary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(149, 165, 166, 0.3);
            }
            .file-input-container {
                position: relative;
                margin-bottom: 1.5rem;
                background: #f8f9fa;
                padding: 20px;
                border-radius: 12px;
                border: 2px dashed #dee2e6;
                transition: all 0.3s;
            }
            .file-input-container:hover {
                border-color: #3498db;
                background: #e9ecef;
            }
            .file-input-container label {
                display: block;
                margin-bottom: 15px;
                color: #2c3e50;
                font-weight: 600;
            }
            .file-input-container input[type="file"] {
                position: relative;
                width: 100%;
                padding: 10px;
                background: white;
                border-radius: 8px;
                border: 1px solid #dee2e6;
            }
            .preview-container {
                margin-top: 15px;
                display: none;
            }
            .preview-container.active {
                display: block;
            }
            .preview-frame {
                width: 100%;
                height: 200px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 10px;
            }
            .preview-buttons {
                display: flex;
                gap: 10px;
                margin-top: 10px;
            }
            .preview-buttons .btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
            .section-title {
                color: #2c3e50;
                font-size: 1.8rem;
                font-weight: 700;
                margin: 2.5rem 0 2rem;
                padding-bottom: 10px;
                border-bottom: 3px solid #3498db;
            }
            .error-message {
                color: #e74c3c;
                font-size: 0.9rem;
                margin-top: 5px;
                font-weight: 500;
            }
            .form-row {
                margin-bottom: 1.5rem;
            }
            @media (max-width: 768px) {
                .form-container {
                    padding: 2rem;
                    margin: 1rem;
                }
                .form-title {
                    font-size: 1.8rem;
                }
            }
        </style>
    </head>
@endsection

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container py-4">
        <div class="form-container">
            <h1 class="form-title">
                <i class="fas fa-file-alt mr-2"></i>Data Lampiran
            </h1>
            <form action="{{ route('data-lampiran.store') }}" method="POST" enctype="multipart/form-data" id="lampiranForm">
                @csrf
                <input type="hidden" name="lokasi_id" value="{{ session('lokasi_id') }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tgl_permohonan">
                            <i class="fas fa-calendar-alt"></i>Tanggal Surat Permohonan
                        </label>
                        <input type="date" id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nomor_surat">
                            <i class="fas fa-file-signature"></i>Nomor Surat Permohonan
                        </label>
                        <input type="text" id="nomor_surat" name="nomor_surat" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">
                        <i class="fas fa-user-tie"></i>Nama Penanggung Jawab
                    </label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="jenis_usaha">
                        <i class="fas fa-briefcase"></i>Jenis Usaha
                    </label>
                    <input type="text" id="jenis_usaha" name="jenis_usaha" class="form-control" required>
                </div>

                <h2 class="section-title">Lampiran Persyaratan</h2>

                <div class="file-input-container">
                    <label for="surat_permohonan">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Surat Permohonan ditandatangani direktur dan Bermaterai (pdf)
                    </label>
                    <input name="surat_permohonan" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-surat-permohonan')">
                    <div id="preview-surat-permohonan" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="ktp_dir">
                        <i class="fas fa-file-pdf mr-2"></i>Scan KTP Direktur (pdf)
                    </label>
                    <input name="ktp_dir" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-ktp-dir')">
                    <div id="preview-ktp-dir" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="nib_oss">
                        <i class="fas fa-file-pdf mr-2"></i>Scan NIB OSS (pdf)
                    </label>
                    <input name="nib_oss" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-nib-oss')">
                    <div id="preview-nib-oss" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="izin_usaha">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Izin Usaha (pdf)
                    </label>
                    <input name="izin_usaha" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-izin-usaha')">
                    <div id="preview-izin-usaha" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="akta_per">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Akta Perusahaan (pdf)
                    </label>
                    <input name="akta_per" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-akta-per')">
                    <div id="preview-akta-per" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="profil_per">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Profil Perusahaan (pdf)
                    </label>
                    <input name="profil_per" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-profil-per')">
                    <div id="preview-profil-per" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="npwp_kaltim">
                        <i class="fas fa-file-pdf mr-2"></i>Scan NPWP Kaltim (pdf)
                    </label>
                    <input name="npwp_kaltim" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-npwp-kaltim')">
                    <div id="preview-npwp-kaltim" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="surat_domisili">
                        <i class="fas fa-file-pdf mr-2"></i>Surat Keterangan Domisili (pdf)
                    </label>
                    <input name="surat_domisili" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-surat-domisili')">
                    <div id="preview-surat-domisili" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="sertif_badan">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Sertifikat Badan Usaha (pdf)
                    </label>
                    <input name="sertif_badan" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-sertif-badan')">
                    <div id="preview-sertif-badan" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="rencana_peng">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Rencana Pengembangan Kantor Wilayah (pdf)
                    </label>
                    <input name="rencana_peng" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-rencana-peng')">
                    <div id="preview-rencana-peng" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="surat_pene">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Surat Penetapan Penanggung Jawab Teknik (pdf)
                    </label>
                    <input name="surat_pene" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-surat-pene')">
                    <div id="preview-surat-pene" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="sertif_kompeten">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Sertifikat Kompetensi Tenaga Teknik (pdf)
                    </label>
                    <input name="sertif_kompeten" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-sertif-kompeten')">
                    <div id="preview-sertif-kompeten" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="sertif_iso">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Dokumen Sistem Manajemen Mutu Sesuai SNI beserta sertfikat ISO (pdf)
                    </label>
                    <input name="sertif_iso" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-sertif-iso')">
                    <div id="preview-sertif-iso" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="sop">
                        <i class="fas fa-file-pdf mr-2"></i>Scan SOP (pdf)
                    </label>
                    <input name="sop" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-sop')">
                    <div id="preview-sop" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="peralatan_sewa">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Daftar Peralatan yang dimiliki/disewa (pdf)
                    </label>
                    <input name="peralatan_sewa" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-peralatan-sewa')">
                    <div id="preview-peralatan-sewa" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="file-input-container">
                    <label for="surat_kuasa">
                        <i class="fas fa-file-pdf mr-2"></i>Scan Surat Kuasa Bermaterai Apabila Pengurusan Izin diwakilkan (pdf)
                    </label>
                    <input name="surat_kuasa" type="file" class="form-control" accept=".pdf" required onchange="previewFile(this, 'preview-surat-kuasa')">
                    <div id="preview-surat-kuasa" class="preview-container">
                        <iframe class="preview-frame" src="" frameborder="0"></iframe>
                        <div class="preview-buttons">
                            <button type="button" class="btn btn-primary" onclick="openPreview(this)">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" class="btn btn-danger" onclick="removeFile(this)">
                                <i class="fas fa-trash mr-2"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-5">
                    <button type="submit" class="btn btn-success mr-3">
                        <i class="fas fa-paper-plane mr-2"></i>Submit
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewFile(input, previewId) {
            const previewContainer = document.getElementById(previewId);
            const previewFrame = previewContainer.querySelector('iframe');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFrame.src = e.target.result;
                    previewContainer.classList.add('active');
                }
                reader.readAsDataURL(file);
            }
        }

        function openPreview(button) {
            const previewContainer = button.closest('.preview-container');
            const previewFrame = previewContainer.querySelector('iframe');
            const previewWindow = window.open('', '_blank');
            previewWindow.document.write(`
                <html>
                    <head>
                        <title>Document Preview</title>
                        <style>
                            body { margin: 0; }
                            iframe { width: 100%; height: 100vh; border: none; }
                        </style>
                    </head>
                    <body>
                        <iframe src="${previewFrame.src}"></iframe>
                    </body>
                </html>
            `);
        }

        function removeFile(button) {
            const previewContainer = button.closest('.preview-container');
            const fileInput = previewContainer.previousElementSibling;
            const previewFrame = previewContainer.querySelector('iframe');
            
            fileInput.value = '';
            previewFrame.src = '';
            previewContainer.classList.remove('active');
        }

    </script>
@endsection
