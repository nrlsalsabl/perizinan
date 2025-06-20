@extends('layouts.app')

@section('title', 'Edit Menu')

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
        <h1 class="mb-4">Edit Menu</h1>

        <form action="{{ route('menus.update', $menu) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_menu">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
            </div>
            <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" name="caption" class="form-control" value="{{ $menu->caption }}" required>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent Menu</label>
                <select name="parent_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($menus as $m)
                        <option value="{{ $m->id }}" @if ($m->id == $menu->parent_id) selected @endif>
                            {{ $m->nama_menu }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="urutan">Urutan Menu</label>
                <input type="number" name="urutan" class="form-control" value="{{ $menu->urutan }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
