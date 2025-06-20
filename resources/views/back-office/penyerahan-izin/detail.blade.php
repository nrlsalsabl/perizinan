@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
                color: #333;
                line-height: 1.6;
            }

            .container {
                max-width: 1200px;
                margin: 2rem auto;
                padding: 0 1rem;
            }

            .header {
                background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
                color: white;
                padding: 2rem;
                text-align: center;
                border-radius: 10px;
                margin-bottom: 2rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .header h1 {
                margin: 0;
                font-size: 2rem;
                font-weight: 600;
            }

            .card {
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                margin-bottom: 2rem;
                border: none;
            }

            .form-group {
                margin-bottom: 1.5rem;
                background: #f8f9fa;
                padding: 1.5rem;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .form-group:hover {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .form-group label {
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 0.8rem;
                font-size: 1rem;
            }

            .form-control {
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                padding: 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.95rem;
            }

            .form-control:focus {
                border-color: #1abc9c;
                box-shadow: 0 0 0 0.2rem rgba(26, 188, 156, 0.25);
            }

            .form-control[readonly] {
                background-color: #fff;
                cursor: not-allowed;
            }

            iframe {
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                margin: 1rem 0;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .btn-primary {
                background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 1rem;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .preview-btn {
                margin-top: 0.8rem;
                display: inline-block;
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }

            select.form-control {
                cursor: pointer;
                background-color: white;
            }

            .verification-status {
                background: #f8f9fa;
                padding: 1.5rem;
                border-radius: 8px;
                margin-bottom: 1.5rem;
            }

            .status-item {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
            }

            .status-item label {
                font-weight: 600;
                margin-right: 1rem;
                min-width: 120px;
                color: #2c3e50;
            }

            .status-item span {
                padding: 0.5rem 1rem;
                border-radius: 4px;
                background-color: white;
                color: #2c3e50;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .document-preview {
                background: white;
                padding: 1rem;
                border-radius: 8px;
                margin-bottom: 1rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .document-preview label {
                color: #2c3e50;
                font-weight: 600;
                margin-bottom: 1rem;
                display: block;
            }

            .btn-success {
                background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 1rem;
                color: white;
            }

            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                color: white;
            }

            @media (max-width: 768px) {
                .container {
                    margin: 1rem auto;
                }

                .header {
                    padding: 1.5rem;
                }

                .header h1 {
                    font-size: 1.5rem;
                }

                .form-group {
                    padding: 1rem;
                }

                .btn-primary, .btn-success {
                    width: 100%;
                    margin-top: 1rem;
                }
            }
        </style>
    </head>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('penyerahan-izin.update', $pendaftaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card">
                <div class="header">
                    <h1>Data Permohonan Izin</h1>
                </div>

                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resi">Resi</label>
                                <input type="text" name="resi" class="form-control" id="resi" value="{{ $pendaftaran->resi }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_izin">Jenis Izin</label>
                                <input type="text" name="jenis_izin" class="form-control" id="jenis_izin" value="{{ $pendaftaran->jenis_izin }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis_permohonan">Jenis Layanan</label>
                        <input type="text" name="jenis_permohonan" class="form-control" id="jenis_permohonan" value="{{ $pendaftaran->jenis_permohonan }}" readonly>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h1>Data Pemohon</h1>
                </div>

                <div class="p-4">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" class="form-control" id="nik" value="{{ $pemohon->nik }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $pemohon->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" value="{{ $pemohon->alamat }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" id="provinsi" value="{{ $pemohon->provinsi }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kabupaten_kota">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten_kota" class="form-control" id="kabupaten_kota" value="{{ $pemohon->kabupaten_kota }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="{{ $pemohon->kecamatan }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Telp</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ $pemohon->phone }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="email" value="{{ $pemohon->email }}" readonly>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h1>Data Perusahaan</h1>
                </div>

                <div class="p-4">
                    <div class="form-group">
                        <label for="nib">NIB</label>
                        <input type="text" name="nib" class="form-control" id="nib" value="{{ $perusahaan->nib }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" name="npwp" class="form-control" id="npwp" value="{{ $perusahaan->npwp }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" value="{{ $perusahaan->nama_perusahaan }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" value="{{ $perusahaan->alamat }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" id="provinsi" value="{{ $perusahaan->provinsi }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" name="kabupaten" class="form-control" id="kabupaten" value="{{ $perusahaan->kabupaten }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="{{ $perusahaan->kecamatan }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">No. Telp</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ $perusahaan->phone }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bentuk_perusahaan">Bentuk Perusahaan</label>
                        <input type="text" name="bentuk_perusahaan" class="form-control" id="bentuk_perusahaan" value="{{ $perusahaan->bentuk_perusahaan }}" readonly>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h1>Lokasi Izin</h1>
                </div>

                <div class="p-4">
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" id="provinsi" value="{{ $lokasi->provinsi }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" name="kabupaten" class="form-control" id="kabupaten" value="{{ $lokasi->kabupaten }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="{{ $lokasi->kecamatan }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="jalan">Jalan</label>
                        <input type="text" name="jalan" class="form-control" id="jalan" value="{{ $lokasi->jalan }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nomor">Nomor</label>
                        <input type="text" name="nomor" class="form-control" id="nomor" value="{{ $lokasi->nomor }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" name="rt" class="form-control" id="rt" value="{{ $lokasi->rt }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" name="rw" class="form-control" id="rw" value="{{ $lokasi->rw }}" readonly>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h1>Lampiran Persyaratan</h1>
                </div>

                <div class="p-4">
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Surat Permohonan ditandatangani direktur dan Bermaterai</label><br>
                        <input type="hidden" name="nama_file[]" value="Scan Surat Permohonan ditandatangani direktur dan Bermaterai">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->surat_permohonan) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->surat_permohonan) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan KTP Direktur</label>
                        <input type="hidden" name="nama_file[]" value="Scan KTP Direktur">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->ktp_dir) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->ktp_dir) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan NIB OSS</label>
                        <input type="hidden" name="nama_file[]" value="Scan NIB OSS">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->nib_oss) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->nib_oss) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Izin Usaha</label>
                        <input type="hidden" name="nama_file[]" value="Scan Izin Usaha">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->izin_usaha) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->izin_usaha) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Akta Perusahaan</label>
                        <input type="hidden" name="nama_file[]" value="Scan Akta Perusahaan">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->akta_per) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->akta_per) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Profil Perusahaan</label>
                        <input type="hidden" name="nama_file[]" value="Scan Profil Perusahaan">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->profil_per) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->profil_per) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan NPWP Kaltim</label>
                        <input type="hidden" name="nama_file[]" value="Scan NPWP Kaltim">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->npwp_kaltim) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->npwp_kaltim) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Surat Keterangan Domisili</label>
                        <input type="hidden" name="nama_file[]" value="Surat Keterangan Domisili">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->surat_domisili) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->surat_domisili) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Sertifikat Badan USaha</label>
                        <input type="hidden" name="nama_file[]" value="Scan Sertifikat Badan USaha">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->sertif_badan) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->sertif_badan) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Rencana Pengembangan Kantor Wilayah</label>
                        <input type="hidden" name="nama_file[]" value="Scan Rencana Pengembangan Kantor Wilayah">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->rencana_peng) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->rencana_peng) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Surat Penetapan Penanggung Jawab Teknik</label>
                        <input type="hidden" name="nama_file[]" value="Scan Surat Penetapan Penanggung Jawab Teknik">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->surat_pene) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->surat_pene) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Sertifikat Kompetensi Tenaga Teknik</label>
                        <input type="hidden" name="nama_file[]" value="Scan Sertifikat Kompetensi Tenaga Teknik">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->sertif_kompeten) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->sertif_kompeten) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Dokumen Sistem Manajemen Mutu Sesuai SNI beserta sertfikat ISO</label>
                        <input type="hidden" name="nama_file[]" value="Scan Dokumen Sistem Manajemen Mutu Sesuai SNI beserta sertfikat ISO">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->sertif_iso) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->sertif_iso) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan SOP</label>
                        <input type="hidden" name="nama_file[]" value="Scan SOP">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->sop) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->sop) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Daftar Peralatan yang dimiliki/disewa</label>
                        <input type="hidden" name="nama_file[]" value="Scan Daftar Peralatan yang dimiliki/disewa">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->peralatan_sewa) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->peralatan_sewa) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                    <div class="col form-group">
                        <label for="kualifikasi">Scan Surat Kuasa Bermaterai Apabila Pengurusan Izin diwakilkan</label>
                        <input type="hidden" name="nama_file[]" value="Scan Surat Kuasa Bermaterai Apabila Pengurusan Izin diwakilkan">
                        <select name="validasi[]" id="validasi" class="form-control">
                            <option value="valid" selected>Valid</option>
                            <option value="tidak valid">Tidak Valid</option>
                        </select>
                        <iframe src="{{ Storage::url($lampiran->surat_kuasa) }}" width="100%" height="150px"></iframe>
                        <a href="{{ Storage::url($lampiran->surat_kuasa) }}" class="btn btn-primary" target="_blank">preview</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h1>Cetak Izin</h1>
                </div>

                <div class="p-4">
                    <div class="form-group">
                        <label>Print Sertifikat</label>
                        <div class="mt-2">
                            <label><input type="radio" name="ttd" value="digital" checked> Tanda Tangan Digital</label>
                            <label class="ml-3"><input type="radio" name="ttd" value="manual"> Tanpa Tanda Tangan Digital</label>
                        </div>
                        <a href="/sertifikat/print/{{ $pendaftaran->id }}?template=template_surat&ttd=digital" 
                           class="btn btn-success mt-2"
                           target="_blank">
                            <i class="fa fa-print"></i> Print Sertifikat
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
    function handlePrint(event) {
        event.preventDefault();
        const ttd = document.querySelector('input[name="ttd"]:checked').value;
        const baseUrl = "{{ route('print-sertifikat', ['id' => $pendaftaran->id]) }}";
        const url = `${baseUrl}?template=template_surat&ttd=${ttd}`;
        
        // Open in new window and wait for it to load
        const printWindow = window.open(url, '_blank');
        if (printWindow) {
            printWindow.onload = function() {
                // Wait a bit for any resources to load
                setTimeout(() => {
                    printWindow.print();
                    // Close the window after printing
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                }, 1000); // Increased timeout to ensure resources are loaded
            };
        } else {
            alert('Please allow pop-ups for this website to print the certificate.');
        }
    }
    </script>
@endsection
