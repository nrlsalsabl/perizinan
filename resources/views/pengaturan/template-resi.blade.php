@extends('layouts.app')

@section('title', 'Template Resi')

@section('head')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>


    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Template Resi</h1>

        <form action="{{ route('template-resi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="keterangan">Keterangan File</label>
                <input type="text" name="keterangan" id="keterangan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="file_path">File Doc</label>
                <input type="file" name="file_path" id="file_path" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        @if ($templateResis->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keterangan File</th>
                        <th>Template Yang Aktif Sekarang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templateResis as $index => $templateResi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $templateResi->keterangan }}</td>
                            <td>{{ $templateResi->file_path }}</td>
                            <td>
                                <form action="{{ route('template-resi.destroy', $templateResi->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
