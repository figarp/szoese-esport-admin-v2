<x-guest-layout>
    <h1 class="text-center">Regisztráció</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Full Name --}}
        <div class="row g-3 mt-4 form-group">
            <div class="col">
                <x-input-label for="last_name" :value="__('Vezetéknév')" />
                <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required autofocus
                    autocomplete="last_name" />
                <x-input-error :messages="$errors->get('last_name')" />
            </div>
            <div class="col">
                <x-input-label for="first_name" :value="__('Keresztnév')" />
                <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required
                    autocomplete="first_name" />
                <x-input-error :messages="$errors->get('first_name')" />
            </div>
        </div>

        <!-- Name -->
        <div class="mt-4 form-group">
            <x-input-label for="username" :value="__('Felhasználónév')" />
            <x-text-input id="username" type="text" name="username" :value="old('username')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" />
        </div>

        <!-- Email Address -->
        <div class="mt-4 form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4 form-group">
            <x-input-label for="password" :value="__('Jelszó')" />

            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 form-group">
            <x-input-label for="password_confirmation" :value="__('Jelszó Megerősítése')" />

            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="d-flex justify-content-between mt-4">
            <div class="d-flex flex-column">
                <a href="{{ route('login') }}">
                    {{ __('Regisztrált már?') }}
                </a>
                <a href="https://drive.google.com/file/d/11AMPADhOlPULBmcJNltxclJlFpyy7ZL1/view?usp=drive_link"
                    target="_blank">
                    Adatkezelési tájékoztató
                </a>
            </div>

            <x-primary-button>
                {{ __('Regisztráció') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
