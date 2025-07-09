@php
    $color = match($status) {
        'Terverifikasi' => 'badge badge-success',
        'Pendaftaran' => 'badge badge-warning',
        'Ditolak' => 'badge badge-danger',
        'Proses BackOffice' => 'badge badge-info',
        'Cetak Izin' => 'badge badge-primary',
        null => 'badge badge-secondary',
        default => 'badge badge-light'
    };
@endphp

<span class="{{ $color }}">{{ $status ?? 'Belum Diproses' }}</span>
