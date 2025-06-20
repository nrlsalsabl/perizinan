@extends('layouts.app')

@section('title', 'Edit Kecamatan')

@section('head')
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard')</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    </head>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-edit mr-2"></i>Edit Kecamatan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="provinsi" class="font-weight-bold">Provinsi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <select class="form-control select2" id="provinsi" name="provinsi" required></select>
                        </div>
                        @error('provinsi')
                            <div class="invalid-feedback d-block">{!! $message !!}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kabupaten_kota" class="font-weight-bold">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                            </div>
                            <select class="form-control select2" id="kabupaten_kota" name="kabupaten_kota" required>
                                <option value="{{ $kecamatan->kabupaten_kota }}"{{ $kecamatan->kabupaten_kota ? 'selected' : '' }}>
                                    {{ $kecamatan->kabupaten_kota }}
                                </option>
                            </select>
                        </div>
                        @error('kabupaten_kota')
                            <div class="invalid-feedback d-block">{!! $message !!}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode" class="font-weight-bold">Kode <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-code"></i></span>
                            </div>
                            <input type="text" name="kode" id="kode" class="form-control" 
                                value="{{ $kecamatan->kode }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama" class="font-weight-bold">Nama <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-signs"></i></span>
                            </div>
                            <input type="text" name="nama" id="nama" class="form-control" 
                                value="{{ $kecamatan->nama }}" required>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            console.log('mulai');
            // Ambil data kecamatan untuk form edit
            const kecamatanId = "{{ $kecamatan->id }}"; // Pastikan ini terisi dari controller
            const fetchProvinsiUrl = "{{ route('kecamatan.edit', ':id') }}".replace(':id', kecamatanId);

            // Fetch data kecamatan dan isi form
            $.ajax({
                url: fetchProvinsiUrl,
                method: 'GET',
                success: function(response1) {
                    $.ajax({
                        url: '{{ route('kecamatan.get_subprovinsi2') }}', // Route untuk get_subprovinsi2
                        method: 'GET',
                        success: function(response2) {
                            const provinsiSelect = $('#provinsi');
                            provinsiSelect.empty(); // Kosongkan select box

                            console.log('Data dari kecamatan.edit:', response1);
                            console.log('Data dari get_subprovinsi2:', response2);

                            // Tambahkan data dari fetchProvinsiUrl
                            response1.provinsi.forEach(provinsi => {
                                const isSelected = provinsi.nama === response1
                                    .kecamatan.provinsi ? 'selected' : '';
                                provinsiSelect.append(
                                    `<option value="${provinsi.id}" ${isSelected}>${provinsi.kode} - ${provinsi.nama}</option>`
                                );
                            });

                            // Tambahkan data dari get_subprovinsi2
                            // response2.data.forEach(subprovinsi => {
                            //     provinsiSelect.append(
                            //         `<option value="${subprovinsi.id}">${subprovinsi.nama}</option>`
                            //     );
                            // });
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data subprovinsi', xhr);
                        }
                    });
                },
                error: function(xhr) {
                    console.error('Gagal mengambil data kecamatan', xhr);
                }
            });


            // Load data ke select singkatan
            // const get_subprovinsi2 = () => {
            //     $.ajax({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         url: "{{ route('kecamatan.get_subprovinsi2') }}",
            //         type: 'GET',
            //         success: function(json) {
            //             // Clear select options
            //             $('#provinsi').empty();
            //             // Tambahkan opsi default
            //             $('#provinsi').append(new Option("-- No Parent --", ""));
            //             // Tambahkan opsi dari data
            //             $.each(json.data, function(i, item) {
            //                 console.log('item.id: ', item.id, 'name', item
            //                     .nama);
            //                 $('#provinsi').append(new Option(item.nama, item.id));
            //             });
            //             console.log('Data diterima:', json);
            //         },
            //         error: function(error) {
            //             console.error('Error fetching subprovinsi:', error);
            //         },
            //     });
            // };

            const get_subkabupaten = () => {
                const idProvinsi = $('#provinsi').val();
                if (!idProvinsi) return;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subkabupaten') }}",
                    type: 'GET',
                    data: {
                        provinsi: idProvinsi
                    },
                    success: function(json) {
                        // Clear select options
                        $('#kabupaten_kota').empty();
                        // Tambahkan opsi default
                        $('#kabupaten_kota').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item.nama);
                            $('#kabupaten_kota').append(new Option(item.nama, item.id));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

            // Load kode berdasarkan pilihan singkatan
            const get_kodekabupaten = () => {
                const kabupaten_kota = $('#kabupaten_kota').val();
                if (!kabupaten_kota) return;

                $.ajax({
                    url: "{{ route('kecamatan.get_kodekabupaten') }}",
                    type: 'GET',
                    data: {
                        kabupaten_kota
                    },
                    success: function(json) {
                        console.log(json.data);
                        $('#kode').val(json.nextkode || 0);
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching kode:', error);
                    },
                });
            };

            // Panggil fungsi saat ada perubahan pada <select>
            $('#provinsi').on('change', function() {
                get_subkabupaten();
            });

            // // Panggil fungsi saat ada perubahan pada <select>
            $('#kabupaten_kota').on('change', function() {
                get_kodekabupaten();
            });

            // Panggil fungsi untuk memuat data awal
            // get_subprovinsi2();
        });
    </script>
@endsection
