<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-PTSP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 800px;
        }
        .register-title {
            color: #2c3e50;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }
        .register-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #3498db;
            border-radius: 3px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header text-center mb-5">
            <h2 class="register-title">
                <i class="fas fa-user-plus mr-2"></i>Pendaftaran Akun
            </h2>
            <p class="register-subtitle">Silakan lengkapi form berikut untuk membuat akun baru</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5><i class="fas fa-exclamation-triangle mr-2"></i>Error Validasi</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.registrasi') }}" method="POST" class="register-form">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nik" class="form-label">
                        <i class="fas fa-id-card mr-2"></i>NIK
                    </label>
                    <input type="text" id="nik" name="nik" class="form-control form-control-lg" placeholder="Masukkan NIK" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="npwp" class="form-label">
                        <i class="fas fa-file-invoice mr-2"></i>NPWP Perorangan
                    </label>
                    <input type="text" id="npwp" name="npwp" class="form-control form-control-lg" placeholder="Masukkan NPWP" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username" class="form-label">
                        <i class="fas fa-user mr-2"></i>Username
                    </label>
                    <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Buat username" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="name" class="form-label">
                        <i class="fas fa-signature mr-2"></i>Nama Lengkap
                    </label>
                    <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Nama sesuai KTP" required>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">
                    <i class="fas fa-map-marker-alt mr-2"></i>Alamat Pemohon
                </label>
                <textarea id="alamat" name="alamat" class="form-control form-control-lg" rows="3" placeholder="Alamat lengkap" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="provinsi" class="form-label">
                        <i class="fas fa-map mr-2"></i>Provinsi
                    </label>
                    <select class="form-control form-control-lg select2" id="provinsi" name="provinsi" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    @error('provinsi')
                        <div class="invalid-feedback d-block">{!! $message !!}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="kabupaten_kota" class="form-label">
                        <i class="fas fa-map-marked-alt mr-2"></i>Kabupaten/Kota
                    </label>
                    <select class="form-control form-control-lg select2" id="kabupaten_kota" name="kabupaten_kota" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                    @error('kabupaten_kota')
                        <div class="invalid-feedback d-block">{!! $message !!}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="kecamatan" class="form-label">
                        <i class="fas fa-map-pin mr-2"></i>Kecamatan
                    </label>
                    <select class="form-control form-control-lg select2" id="kecamatan" name="kecamatan" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    @error('kecamatan')
                        <div class="invalid-feedback d-block">{!! $message !!}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone mr-2"></i>No. Handphone
                    </label>
                    <input type="text" id="phone" name="phone" class="form-control form-control-lg" placeholder="Contoh: 081234567890" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="kode_pos" class="form-label">
                        <i class="fas fa-mail-bulk mr-2"></i>Kode Pos
                    </label>
                    <input type="text" id="kode_pos" name="kode_pos" class="form-control form-control-lg" placeholder="Kode pos wilayah" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope mr-2"></i>Email
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email aktif" required>
                </div>
            </div>

            <input type="hidden" name="jabatan" value="user">

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Buat password" required>
                </div>
            </div>

            <div class="form-group mt-5">
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-lg" onclick="window.location='{{ route('perizinan-online') }}'">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>
                </div>
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
            console.log('mulai');
            // Load data ke select singkatan
            const get_subprovinsi2 = () => {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subprovinsi2') }}",
                    type: 'GET',
                    success: function(json) {
                        // Clear select options
                        $('#provinsi').empty();
                        // Tambahkan opsi default
                        $('#provinsi').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item
                                .nama);
                            $('#provinsi').append(new Option(item.nama, item.id));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

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

            const get_subkecamatan = () => {
                const idKabupaten = $('#kabupaten_kota').val();
                if (!idKabupaten) return;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('kecamatan.get_subkecamatan') }}",
                    type: 'GET',
                    data: {
                        kabupaten_kota: idKabupaten
                    },
                    success: function(json) {
                        // Clear select options
                        $('#kecamatan').empty();
                        // Tambahkan opsi default
                        $('#kecamatan').append(new Option("-- No Parent --", ""));
                        // Tambahkan opsi dari data
                        $.each(json.data, function(i, item) {
                            console.log('item.id: ', item.id, 'name', item.nama);
                            $('#kecamatan').append(new Option(item.nama, item.id));
                        });
                        console.log('Data diterima:', json);
                    },
                    error: function(error) {
                        console.error('Error fetching subprovinsi:', error);
                    },
                });
            };

            // Panggil fungsi saat ada perubahan pada <select>
            $('#provinsi').on('change', function() {
                get_subkabupaten();
            });

            // Panggil fungsi saat ada perubahan pada <select>
            $('#kabupaten_kota').on('change', function() {
                get_subkecamatan();
            });

            // Panggil fungsi untuk memuat data awal
            get_subprovinsi2();
        });
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
</body>

</html>
