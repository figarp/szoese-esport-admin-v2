<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="{{ Vite::asset('resources/images/szoese_esport_logo_128.png') }}" alt="">
            </span>

            <div class="text header-text">
                <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
                    <span class="name">SZoESE E-Sport</span>
                </a>

            </div>
        </div>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <li class="nav-link">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-house icon"></i>
                    <span class="text nav-text">Főoldal</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('dashboard.groups.index') }}">
                    <i class="fa-solid fa-gamepad icon"></i>
                    <span class="text nav-text">Csoportok</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="#">
                    <i class="fa-solid fa-user-plus icon"></i>
                    <span class="text nav-text">Jelentkezések</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('dashboard.users') }}">
                    <i class="fa-solid fa-lock icon"></i>
                    <span class="text nav-text">Tagok</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('profile.edit') }}">
                    <i class="fa-solid fa-gear icon"></i>
                    <span class="text nav-text">Beállítások</span>
                </a>
            </li>
        </div>

        <div class="bottom-content">
            <li>
                <a href="#" id="logoutBtn" class="logoutLink">
                    <i class="fa-solid fa-right-from-bracket icon"></i>
                    <span class="text nav-text">Kijelentkezés</span>
                </a>
            </li>
            {{-- <li class="mode">
                <div class="moon-sun">
                    <i class="fa-solid fa-moon icon moon"></i>
                    <i class="fa-solid fa-sun icon sun"></i>
                </div>
                <span class="mode-text text">Dark Mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li> --}}
        </div>
    </div>
</nav>

<form method="post" action="{{ route('logout') }}" id="logoutForm" class="hidden">
    @csrf
</form>
