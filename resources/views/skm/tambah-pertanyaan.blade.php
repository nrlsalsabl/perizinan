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
        <h1>Tambah Pertanyaan Survey</h1>

        <form action="{{ route('skm.store-pertanyaan') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="pertanyaan">Pertanyaan</label>
                <input type="text" name="pertanyaan" class="form-control" id="pertanyaan"
                    placeholder="Masukkan pertanyaan" required>
            </div>

            <div class="form-group">
                <label>Pilihan Jawaban dan Bobot Nilai</label>
                <div id="jawaban-list">
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <input type="text" name="jawaban[0][pilihan_jawaban]" class="form-control"
                                placeholder="Pilihan Jawaban" required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="jawaban[0][bobot_nilai]" class="form-control"
                                placeholder="Bobot Nilai" min="1" max="5" required>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-jawaban" class="btn btn-secondary">Tambah Jawaban</button>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
        </form>
    </div>

    <script>
        let jawabanIndex = 1;
        document.getElementById('add-jawaban').addEventListener('click', function() {
            const jawabanList = document.getElementById('jawaban-list');
            const newJawaban = `
            <div class="row mb-2">
                <div class="col-md-8">
                    <input type="text" name="jawaban[${jawabanIndex}][pilihan_jawaban]" class="form-control" placeholder="Pilihan Jawaban" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="jawaban[${jawabanIndex}][bobot_nilai]" class="form-control" placeholder="Bobot Nilai" min="1" max="5" required>
                </div>
            </div>
        `;
            jawabanList.insertAdjacentHTML('beforeend', newJawaban);
            jawabanIndex++;
        });
    </script>
@endsection
