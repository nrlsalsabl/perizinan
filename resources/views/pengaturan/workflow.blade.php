@extends('layouts.app')

@section('title', 'Workflow')

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
        <h1 class="mb-4">Workflow Management</h1>

        <!-- Workflow List -->
        <div class="card mb-4">
            <div class="card-header">
                Daftar Workflow
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Alur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workflows as $index => $workflow)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $workflow->nama_alur }}</td>
                                <td>
                                    <a href="{{ route('workflow.edit', $workflow->id) }}"
                                        class="btn btn-sm btn-primary mb-1">Edit</a>
                                    <form action="{{ route('workflow.destroy', $workflow->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                    {{-- <button class="btn btn-sm btn-success">Tambah Proses</button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    {{-- <div>
                        <!-- Pagination -->
                        {{ $workflows->links() }}
                    </div> --}}
                    <div>
                        <a href="{{ route('workflow.create') }}" class="btn btn-success">Tambah Data Perizinan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="card mb-4">
            <div class="card-header">
                Daftar Task
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Taskname</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $index => $task)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $task->taskname }}</td>
                                <td>{{ $task->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    {{-- <div>
                        <!-- Pagination -->
                        {{ $tasks->links() }}
                    </div> --}}
                    <div>
                        <a href="{{ route('task.create') }}" class="btn btn-success">Tambah Data Perizinan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Workflow Button -->
        {{-- <div class="text-right mb-4">
        <button class="btn btn-success">Tambah Workflow</button>
    </div> --}}

    </div>
@endsection
