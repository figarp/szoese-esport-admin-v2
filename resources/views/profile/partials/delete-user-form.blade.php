<section>
    <header>
        <h2>
            {{ __('Fiók Törlése') }}
        </h2>

        <p>
            {{ __('A fiók törlését követően minden hozzá tartozó adat véglegesen törlődni fog.') }}
        </p>
    </header>

    <x-danger-button data-bs-toggle="modal"
        data-bs-target="#deleteAccountModal">{{ __('Fiók Törlése') }}</x-danger-button>
</section>

<x-modal id="deleteAccountModal" name="Fiók Törlése">
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2>
            {{ __('Biztos törlöd a fiókod?') }}
        </h2>

        <p>
            {{ __('A megerősítéshez add meg a jelszavad!') }}
        </p>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Jelszó') }}" class="sr-only" />

            <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                placeholder="{{ __('Jelszó') }}" />
        </div>

        <div class="mt-5">
            <x-secondary-button data-bs-dismiss="modal">
                {{ __('Mégsem') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Törlöm a fiókom') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
