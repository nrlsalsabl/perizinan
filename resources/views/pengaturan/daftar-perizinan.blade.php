@extends('layouts.app')

@section('title', 'Daftar Perizinan')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i>Daftar Perizinan</h3>
            </div>
            
            <div class="card-body">
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="search" placeholder="Cari perizinan..." oninput="filterData()">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Jenis Perizinan</th>
                                <th class="text-center">Masa Berlaku</th>
                                <th class="text-center">Retribusi</th>
                                <th class="text-center">PO</th>
                                <th class="text-center">BU</th>
                                <th class="text-center">SOP</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Online</th>
                                <th class="text-center">Format No Izin</th>
                                <th class="text-center">Dinas/Badan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarPerizinan as $perizinan)
                                <tr>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('daftar-perizinan.edit', $perizinan->id) }}" 
                                               class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('daftar-perizinan.destroy', $perizinan->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>{{ $perizinan->kode }}</td>
                                    <td>{{ $perizinan->nama_jenis_perizinan }}</td>
                                    <td>{{ $perizinan->masa_berlaku }}</td>
                                    <td>{{ $perizinan->retribusi }}</td>
                                    <td>{{ $perizinan->po }}</td>
                                    <td>{{ $perizinan->bu }}</td>
                                    <td>{{ $perizinan->sop }}</td>
                                    <td>
                                        <span class="badge badge-{{ $perizinan->status == 'Aktif' ? 'success' : 'secondary' }}">
                                            {{ $perizinan->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $perizinan->online ? 'success' : 'danger' }}">
                                            {{ $perizinan->online ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </td>
                                    <td>{{ $perizinan->format_no_izin }}</td>
                                    <td>{{ $perizinan->dinas_badan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        {{-- {{ $daftarPerizinan->links() }} --}}
                    </div>
                    <div>
                        <a href="{{ route('daftar-perizinan.create') }}" class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>Tambah Perizinan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($daftarPerizinan->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $daftarPerizinan->links('pagination::bootstrap-4') }}
    </div>
    @endif
    <script>
        function filterData() {
            const search = document.getElementById('search').value;
            window.location.href = `?search=${search}`;
        }
    </script>
@endsection
