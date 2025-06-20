<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perizinan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .filters {
            margin-bottom: 20px;
        }
        .filters p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Perizinan</h2>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="filters">
        <h4>Filter yang Digunakan:</h4>
        <p>Status Izin: {{ $filters['status_izin'] ?? 'Semua' }}</p>
        <p>Jenis Permohonan: {{ $filters['jenis_permohonan'] ?? 'Semua' }}</p>
        <p>Jenis Izin: {{ $filters['jenis_izin'] ?? 'Semua' }}</p>
        @if(isset($filters['tanggal_awal']) && isset($filters['tanggal_akhir']))
            <p>Periode: {{ date('d/m/Y', strtotime($filters['tanggal_awal'])) }} - {{ date('d/m/Y', strtotime($filters['tanggal_akhir'])) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemohon</th>
                <th>Jenis Izin</th>
                <th>Jenis Permohonan</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Nomor Izin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_pemohon }}</td>
                    <td>{{ $item->jenis_izin }}</td>
                    <td>{{ $item->jenis_permohonan }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->proses_terakhir }}</td>
                    <td>{{ $item->nomor_izin ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem.</p>
    </div>
</body>
</html> 