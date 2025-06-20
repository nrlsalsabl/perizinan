@extends('layouts.app')

@section('title', 'Edit Outbox Message')

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
        <h1 class="mb-4">Edit Outbox Message</h1>

        <form action="{{ route('outbox.update', $outbox->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ $outbox->category }}"
                    required>
            </div>
            <div class="form-group">
                <label for="text_sms">Text SMS</label>
                <textarea name="text_sms" id="text_sms" class="form-control" required>{{ $outbox->text_sms }}</textarea>
            </div>
            <div class="form-group">
                <label for="text_email">Text Email</label>
                <textarea name="text_email" id="text_email" class="form-control" required>{{ $outbox->text_email }}</textarea>
            </div>
            <div class="form-group">
                <label for="subject_email">Subject Email</label>
                <input type="text" name="subject_email" id="subject_email" class="form-control"
                    value="{{ $outbox->subject_email }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
