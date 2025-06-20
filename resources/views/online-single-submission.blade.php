<!-- resources/views/online-single-submission.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Single Submission - E-PTSP</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <div class="container">
            <h1>Online Single Submission</h1>
        </div>
    </header>
    <nav>
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('online-single-submission') }}">Online Single Submission</a></li>
                <li><a href="{{ route('perizinan-online') }}">Perizinan Online</a></li>
                <li><a href="{{ route('persyaratan') }}">Persyaratan</a></li>
                <li><a href="{{ route('website') }}">Website</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="content">
            <h2>Online Single Submission</h2>
            <p>Konten halaman ini tentang Online Single Submission.</p>
        </div>
    </div>
    <footer>
        <p>E-PTSP &copy; 2024</p>
    </footer>
</body>
</html>
