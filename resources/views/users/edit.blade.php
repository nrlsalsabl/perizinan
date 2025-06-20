@extends('layouts.app')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Edit User')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    </head>
@endsection

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Edit User</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control" id="username" value="{{ $user->username }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="font-weight-bold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nip" class="font-weight-bold">NIP</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    </div>
                                    <input type="text" name="nip" class="form-control" id="nip" value="{{ $user->nip }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jabatan" class="font-weight-bold">Jabatan/Role</label>
                                <select name="jabatan" id="jabatan" class="form-control select2">
                                    <option value="admin" {{ $user->jabatan == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="front office" {{ $user->jabatan == 'front office' ? 'selected' : '' }}>Front Office</option>
                                    <option value="back office" {{ $user->jabatan == 'back office' ? 'selected' : '' }}>Back Office</option>
                                    <option value="kasi" {{ $user->jabatan == 'kasi' ? 'selected' : '' }}>Kasi</option>
                                    <option value="user" {{ $user->jabatan == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="font-weight-bold">Telepon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Jabatan",
                allowClear: true
            });
        });
    </script>
@endsection
