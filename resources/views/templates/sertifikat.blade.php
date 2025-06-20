<!DOCTYPE html>
<html>
<head>
    <title>SURAT IZIN TEMPAT USAHA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px 60px 60px 60px;
            background: #fff;
            border: 1px solid #ddd;
            position: relative;
        }
        .logo {
            width: 80px;
            margin: 0 auto 10px auto;
            display: block;
        }
        .header {
            text-align: center;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 16px;
            margin: 0;
            font-weight: normal;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 13px;
        }
        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 18px 0 24px 0;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0;
            text-transform: uppercase;
        }
        .nomor {
            text-align: center;
            font-size: 15px;
            margin-bottom: 24px;
        }
        .fields {
            margin-left: 40px;
            margin-bottom: 40px;
        }
        .fields-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }
        .fields-table td {
            padding: 2px 6px 2px 0;
            vertical-align: top;
        }
        .fields-table .label {
            width: 220px;
        }
        .fields-table .colon {
            width: 10px;
        }
        .footer {
            margin-top: 60px;
            text-align: right;
        }
        .footer .date {
            margin-bottom: 60px;
        }
        .footer .nip {
            margin-top: 60px;
        }
        .print-date {
            position: absolute;
            bottom: 20px;
            left: 60px;
            font-size: 12px;
            color: #666;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button">Print Sertifikat</button>
    <div class="container">
        <img src="{{ asset('storage/logo_garuda.png') }}" class="logo" alt="Logo">
        <div class="header">
            <h1>PEMERINTAH PROVINSI KALIMANTAN TIMUR</h1>
            <h2>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h2>
            <p>JL.BASUKI RAHMAT NO.78 SAMARINDA, KALIMANTAN TIMUR.</p>
        </div>
        <hr>
        <div class="title">SURAT {{ strtoupper($data['jenis_izin'] ?? '') }}</div>
        <div class="nomor">NOMOR: {{ $data['no_izin'] ?? '...........' }}</div>
        <div class="fields">
            <table class="fields-table">
                <tr><td class="label">Nama Perusahaan</td><td class="colon">:</td><td>{{ $data['nama_perusahaan'] ?? '' }}</td></tr>
                <tr><td class="label">Alamat Perusahaan</td><td class="colon">:</td><td>{{ $data['alamat_perusahaan'] ?? '' }}</td></tr>
                <tr><td class="label">Lokasi Izin</td><td class="colon">:</td><td>{{ $data['lokasi_izin'] ?? '' }}</td></tr>
                <tr><td class="label">NIB</td><td class="colon">:</td><td>{{ $data['nib'] ?? '' }}</td></tr>
                <tr><td class="label">Nama Pemohon</td><td class="colon">:</td><td>{{ $data['nama_pemohon'] ?? '' }}</td></tr>
                <tr><td class="label">NIK</td><td class="colon">:</td><td>{{ $data['nik'] ?? '' }}</td></tr>
                <tr><td class="label">Alamat Pemohon</td><td class="colon">:</td><td>{{ $data['alamat'] ?? '' }}</td></tr>
                <tr><td class="label">NPWP</td><td class="colon">:</td><td>{{ $data['npwp'] ?? '' }}</td></tr>
                <tr><td class="label">Tanggal Terbit</td><td class="colon">:</td><td>{{ $data['tanggal_terbit'] ?? '' }}</td></tr>
                <tr><td class="label">Jenis Izin</td><td class="colon">:</td><td>{{ $data['jenis_izin'] ?? '' }}</td></tr>
                <tr><td class="label">Jenis Permohonan</td><td class="colon">:</td><td>{{ $data['jenis_permohonan'] ?? '' }}</td></tr>
                <tr><td class="label">Masa Berlaku</td><td class="colon">:</td><td>{{ $data['masa_berlaku'] ?? '5 Tahun' }}</td></tr>
                <tr><td class="label">Nomor Resi</td><td class="colon">:</td><td>{{ $data['resi'] ?? '' }}</td></tr>
                <tr><td class="label">Status</td><td class="colon">:</td><td>{{ $data['status'] ?? 'Aktif' }}</td></tr>
            </table>
        </div>
        <div class="footer">
            <div class="date">Samarinda, {{ $data['tanggal_terbit'] ?? '....................' }}</div>
            <div>Kepala Dinas</div>
            @if(isset($ttdType) && $ttdType === 'digital' && !empty($data['ttd_path']))
                <div style="margin-top:10px;margin-bottom:10px;">
                    <img src="{{ $data['ttd_path'] }}" alt="TTD Kadis" style="width:120px;">
                </div>
            @else
                <div style="height:60px;"></div>
            @endif
            <div style="font-weight:bold;">{{ $data['kadis_nama'] ?? '' }}</div>
            <div>NIP. {{ $data['kadis_nip'] ?? '' }}</div>
        </div>
        <div class="print-date">Dicetak tanggal: {{ now()->format('d/m/Y') }}</div>
    </div>
</body>
</html>