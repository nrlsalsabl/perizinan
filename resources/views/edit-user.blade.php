<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
</head>

<body>
    <div class="register-container">
        <h2 class="text-center mb-4">Register</h2>
        <form action="{{ route('update-user.registrasi', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" value="{{ $user->nik }}">
            </div>
            <div class="form-group">
                <label for="npwp">NPWP Perorangan</label>
                <input type="text" id="npwp" name="npwp" class="form-control" value="{{ $user->npwp }}">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}">
            </div>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Pemohon</label>
                <textarea id="alamat" name="alamat" class="form-control">{{ $user->alamat }}</textarea>
            </div>
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi"></select>
                @error('provinsi')
                    <div>{!! $message !!}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="kabupaten_kota">Kabupaten</label>
                <select class="form-control" id="kabupaten_kota" name="kabupaten_kota"></select>
                @error('kabupaten_kota')
                    <div>{!! $message !!}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <select class="form-control" id="kecamatan" name="kecamatan"></select>
                @error('kecamatan')
                    <div>{!! $message !!}</div>
                @enderror
            </div>
            {{-- <div class="form-group">
                <label for="kelurahan">Kelurahan/Desa</label>
                <input type="text" id="kelurahan" name="kelurahan" class="form-control" required>
            </div> --}}
            <div class="form-group">
                <label for="phone">No. Handphone</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
            </div>
            <div class="form-group">
                <label for="kode_pos">Kode Pos</label>
                <input type="text" id="kode_pos" name="kode_pos" class="form-control"
                    value="{{ $user->kode_pos }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group">
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ $user->email }}">
                    {{-- <div class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="generateCode()">Generate Code</button>
                    </div> --}}
                </div>
            </div>
            {{-- <div class="form-group">
                <label for="kode_email">Kode dari Email</label>
                <input type="text" id="kode_email" name="kode_email" class="form-control" required>
            </div> --}}
            <input type="hidden" name="jabatan" value="front end">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            </div>
            {{-- <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div> --}}
            <div class="form-group">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-secondary"
                    onclick="window.location='{{ route('dashboard') }}'">Kembali ke Halaman dashboard</button>
            </div>
        </form>
    </div>

    <script>
        function generateCode() {
            const emailField = document.getElementById('email');
            const kodeEmailField = document.getElementById('kode_email');

            if (emailField.value) {
                const generatedCode = Math.floor(100000 + Math.random() * 900000);
                alert('Kode telah dikirim ke email Anda: ' + generatedCode);
                kodeEmailField.value = generatedCode;

                // Kirim kode ke server
                fetch('{{ route('save.code') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email: emailField.value,
                            code: generatedCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Kode berhasil disimpan di sesi.');
                        } else {
                            console.error('Gagal menyimpan kode di sesi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                alert('Mohon masukkan email terlebih dahulu.');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#provinsi, #kabupaten_kota, #kecamatan').select2();

            function get_subprovinsi2(selectedProvinsi = null, callback = null) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subprovinsi2') }}",
                    type: 'GET',
                    success: function(json) {
                        $('#provinsi').empty().append(new Option("-- No Parent --", ""));
                        $.each(json.data, function(i, item) {
                            $('#provinsi').append(new Option(item.nama, item.id));
                        });
                        if (selectedProvinsi) {
                            $('#provinsi').val(selectedProvinsi).trigger('change');
                        }
                        if (callback) callback();
                    }
                });
            }

            function get_subkabupaten(selectedKabupaten = null, callback = null) {
                const idProvinsi = $('#provinsi').val();
                if (!idProvinsi) return;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subkabupaten') }}",
                    type: 'GET',
                    data: { provinsi: idProvinsi },
                    success: function(json) {
                        $('#kabupaten_kota').empty().append(new Option("-- No Parent --", ""));
                        $.each(json.data, function(i, item) {
                            $('#kabupaten_kota').append(new Option(item.nama, item.id));
                        });
                        if (selectedKabupaten) {
                            $('#kabupaten_kota').val(selectedKabupaten).trigger('change');
                        }
                        if (callback) callback();
                    }
                });
            }

            function get_subkecamatan(selectedKecamatan = null) {
                const idKabupaten = $('#kabupaten_kota').val();
                if (!idKabupaten) return;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subkecamatan') }}",
                    type: 'GET',
                    data: { kabupaten_kota: idKabupaten },
                    success: function(json) {
                        $('#kecamatan').empty().append(new Option("-- No Parent --", ""));
                        $.each(json.data, function(i, item) {
                            $('#kecamatan').append(new Option(item.nama, item.id));
                        });
                        if (selectedKecamatan) {
                            $('#kecamatan').val(selectedKecamatan).trigger('change');
                        }
                    }
                });
            }

            $('#provinsi').on('change', function() {
                get_subkabupaten();
            });

            $('#kabupaten_kota').on('change', function() {
                get_subkecamatan();
            });

            // Initial load with pre-selection
            get_subprovinsi2(window.userData.provinsi, function() {
                if (window.userData.kabupaten_kota) {
                    get_subkabupaten(window.userData.kabupaten_kota, function() {
                        if (window.userData.kecamatan) {
                            get_subkecamatan(window.userData.kecamatan);
                        }
                    });
                }
            });
        });
    </script>

    <script>
        window.userData = {
            provinsi: "{{ $user->provinsi ?? '' }}",
            kabupaten_kota: "{{ $user->kabupaten_kota ?? '' }}",
            kecamatan: "{{ $user->kecamatan ?? '' }}"
        };
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
</body>

</html>
