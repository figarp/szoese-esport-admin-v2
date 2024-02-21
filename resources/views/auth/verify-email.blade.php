<x-guest-layout>
    <h2>Hitelesítés</h2>
    <div class="mb-4 small text-muted">
        <p>Köszönjük, a regisztrációt! Kérjük, hitelesítsd az e-mail címedet a linkre kattintva, amelyet elküldtünk a
            megadott címre! Ha nem kaptad meg az e-mailt, szívesen küldünk egy másikat.</p>
        <p><strong>Mivel friss az oldal, az innen kapott emailek valószínűleg a spam mappában lesznek
                megtalálhatóak!</strong></p>
    </div>

    <div class="mb-4 small text-muted">
        <p>Az email címedet <a href="{{ route('profile.edit') }}">itt</a> tudod megváltoztatni.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-weight-bold small text-success">
            {{ __('A regisztráció során megadott e-mail címre egy új ellenőrző linket küldtünk.') }}
        </div>
    @endif

    <div class="mt-4 d-flex justify-content-between align-items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Megerősítő levél újra küldése') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-danger">
                {{ __('Kijelentkezés') }}
            </button>
        </form>
    </div>
</x-guest-layout>
