<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('/images/szoese_esport_logo_32.png') }}"
                alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Főoldal</x-nav-link>
            </ul>
            <span class="navbar-nav">
                @auth
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                @else
                    <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">Bejelentkezés</x-nav-link>
                    <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">Regisztráció</x-nav-link>
                @endauth
            </span>

        </div>
    </div>
</nav>
