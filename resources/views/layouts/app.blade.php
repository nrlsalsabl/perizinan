<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Select2 (opsional, jika digunakan) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">

    @yield('head')
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800 min-h-full">
    <div id="app" class="flex h-full">
        <div id="viewport" class="flex flex-col w-full">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Content Area -->
            <div class="content-area flex flex-col flex-1 overflow-hidden">
                <!-- Navbar -->
                @include('layouts.navbar')

                <!-- Main Content -->
                <div class="container-fluid px-6 py-4 flex-1 overflow-y-auto">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- Sidebar and Dropdown JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar collapse/expand
            const sidebarElement = document.getElementById('sidebar');
            const collapseBtn = document.getElementById('sidebar-collapse-btn');
            const collapseIcon = collapseBtn?.querySelector('i');
            let collapsed = false;

            if (collapseBtn && collapseIcon && sidebarElement) {
                collapseBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    collapsed = !collapsed;
                    sidebarElement.classList.toggle('collapsed', collapsed);
                    collapseIcon.classList.toggle('zmdi-chevron-left', !collapsed);
                    collapseIcon.classList.toggle('zmdi-chevron-right', collapsed);
                });
            }

            // Dropdown toggle
            document.querySelectorAll('#sidebar .nav-link.dropdown-toggle').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (!sidebarElement.classList.contains('collapsed')) {
                        const menu = link.nextElementSibling;
                        if (menu && menu.classList.contains('dropdown-menu')) {
                            document.querySelectorAll('#sidebar .dropdown-menu').forEach(m => {
                                if (m !== menu) m.classList.remove('show');
                            });
                            menu.classList.toggle('show');
                        }
                    }
                });
            });

            // Close dropdowns when clicked outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('#sidebar')) {
                    document.querySelectorAll('#sidebar .dropdown-menu').forEach(m => m.classList.remove('show'));
                }
            });

            // Mobile sidebar toggle
            let viewport = document.getElementById('viewport');
            let sidebarToggle = document.querySelector('.sidebar-toggle');
            if (sidebarElement && viewport && sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebarElement.classList.toggle('active');
                    viewport.classList.toggle('sidebar-active');
                });
            }

            // Select2 init
            if (typeof $().select2 === 'function') {
                $('.select2').select2({
                    placeholder: "Pilih Akses",
                    allowClear: true
                });
            }

            // Select All Function
            $('#select-all').on('click', function () {
                let allOptions = [];
                $('#daftar_akses option').each(function () {
                    allOptions.push($(this).val());
                });
                $('#daftar_akses').val(allOptions).trigger('change');
            });

            // Deselect All Function
            $('#deselect-all').on('click', function () {
                $('#daftar_akses').val(null).trigger('change');
            });
        });
    </script>

    @yield('script')
</body>

</html>
