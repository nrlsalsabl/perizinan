@extends('layouts.app')

@section('title', 'Master Notifikasi')

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
        <h1 class="mb-4">Master Notifikasi</h1>

        <form action="{{ route('notifikasi.master') }}" method="GET">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search...">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        @if ($masterNotifikasis->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Category</th>
                        <th>Text SMS</th>
                        <th>Text Email</th>
                        <th>Subject Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($masterNotifikasis as $notifikasi)
                        <tr>
                            <td>
                                <a href="{{ route('notifikasi.edit', $notifikasi->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('notifikasi.destroy', $notifikasi->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                            <td>{{ $notifikasi->category }}</td>
                            <td>{{ $notifikasi->text_sms }}</td>
                            <td>{{ $notifikasi->text_email }}</td>
                            <td>{{ $notifikasi->subject_email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $masterNotifikasis->links() }}
        @else
            <p>No notifications found.</p>
        @endif
    </div>
@endsection
