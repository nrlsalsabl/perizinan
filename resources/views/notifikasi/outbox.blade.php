@extends('layouts.app')

@section('title', 'Outbox')

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
        <h1 class="mb-4">Outbox</h1>
        <a href="{{ route('outbox.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
        @if ($outboxes->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category</th>
                        <th>Text SMS</th>
                        <th>Text Email</th>
                        <th>Subject Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outboxes as $index => $outbox)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $outbox->category }}</td>
                            <td>{{ $outbox->text_sms }}</td>
                            <td>{{ $outbox->text_email }}</td>
                            <td>{{ $outbox->subject_email }}</td>
                            <td>
                                <form action="{{ route('outbox.destroy', $outbox->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                <a href="{{ route('outbox.edit', $outbox->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No outbox messages found.</p>
        @endif
    </div>
@endsection
