<section>
    <header>
        <h2>
            {{ __('Fiók Információk') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="username" :value="__('Felhasználónév')" />
            <x-text-input id="username" type="text" name="username" :value="old('username', $user->username)" required autofocus />
            <x-input-error :messages="$errors->get('username')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email cím')" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Mentés') }}</x-primary-button>
        </div>
    </form>
</section>
