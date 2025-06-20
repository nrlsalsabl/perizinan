@extends('layouts.app')

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
    <div class="container">
        <h1>Tambah Alur</h1>

        <form action="{{ route('task.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="task">Taskname</label>
                <input type="text" name="taskname" class="form-control" id="taskname" value="{{ $task->taskname }}"
                    required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" id="status">
                    <option value="proses"{{ $task->status ? 'selected' : '' }}>Proses</option>
                    <option value="ditolak"{{ $task->status ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai"{{ $task->status ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var multiSelect = document.querySelector('#ms1');
            if (multiSelect) {
                new coreui.MultiSelect(multiSelect);
            }
        });
    </script> --}}
@endsection
