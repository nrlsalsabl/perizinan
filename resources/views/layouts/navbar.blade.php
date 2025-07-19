<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #37474f 0%, #263238 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuAvatar"
                   role="button" data-toggle="dropdown" aria-expanded="false">
                    <span class="text-white me-2" style="font-size: 1rem; font-weight: 600; letter-spacing: 0.5px; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                        {{ Auth::user()->username }}
                    </span>
                    <div class="avatar-container" style="position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="white"
                            class="bi bi-person-circle" viewBox="0 0 16 16" style="margin-left: 5px; transition: all 0.3s ease;">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                        <div class="avatar-pulse" style="position: absolute; top: 0; left: 5px; width: 36px; height: 36px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.3); animation: pulse 2s infinite;"></div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar" style="border-radius: 12px; box-shadow: 0 8px 16px rgba(0,0,0,0.15); border: none; overflow: hidden;">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="transition: all 0.3s ease; padding: 12px 20px; color: #37474f;">
                            <i class="bx bx-log-out-circle pe-2" style="font-size: 1.2rem;"></i> 
                            <span style="font-weight: 500;">Logout</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.05); opacity: 0.4; }
        100% { transform: scale(1); opacity: 0.7; }
    }
    .dropdown-item:hover {
        /* background-color: #f5f5f5 !important; */
        transform: translateX(5px);
    }
    .nav-link:hover svg {
        transform: scale(1.1);
    }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Bootstrap 4 dropdowns
        $('.dropdown-toggle').dropdown();

        // Add hover effect to dropdown items
        $('.dropdown-item').hover(
            function() { $(this).css('background-color', '#f8f9fa'); },
            function() { $(this).css('background-color', ''); }
        );

        // Add click animation
        $('.dropdown-item').on('mousedown', function() {
            $(this).css('transform', 'scale(0.98)');
        }).on('mouseup mouseleave', function() {
            $(this).css('transform', 'scale(1)');
        });
    });
</script>
@endpush
