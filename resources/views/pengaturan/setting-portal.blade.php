@extends('layouts.app')

@section('title', 'Setting Portal')

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
        <h1 class="mb-4">Setting Portal</h1>

        <form action="{{ route('setting-portal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_file">Nama File</label>
                <input type="text" name="nama_file" id="nama_file" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" name="file" id="file" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Image</button>
        </form>

        @if ($settingPortals->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settingPortals as $index => $settingPortal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $settingPortal->nama_file }}</td>
                            <td>{{ $settingPortal->status }}</td>
                            <td>
                                <form action="{{ route('setting-portal.destroy', $settingPortal->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                {{-- <a href="{{ route('setting-portal.edit', $settingPortal->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
