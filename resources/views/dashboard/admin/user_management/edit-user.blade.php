@section('title')
    Felhasználó adatainak módosítása
@endsection

<x-app-layout>
    <section class="dashboard_card">
        <x-go-back-button href="{{ route('dashboard.admin') }}" />
        <div class="max-w-xl">
            <form method="POST" action="{{ route('dashboard.admin.userManagement.update', ['id' => $user->id]) }}">
                @csrf
                @method('PUT')

                <div class="row g-3 mt-4 mb-3 form-group">
                    <div class="col">
                        <x-input-label for="last_name" :value="__('Vezetéknév')" />
                        <x-text-input id="last_name" type="text" name="last_name" :value="$user->last_name" disabled />
                    </div>
                    <div class="col">
                        <x-input-label for="first_name" :value="__('Keresztnév')" />
                        <x-text-input id="first_name" type="text" name="first_name" :value="$user->first_name" disabled />
                    </div>
                </div>

                <div class="mb-3">
                    <x-input-label for="name" :value="__('Név')" />
                    <x-text-input id="name" type="text" name="name" :value="$user->username" disabled />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="$user->email" disabled />
                </div>

                <div class="mb-5">
                    <label for="role_select" class="form-label mt-4">Beosztás</label>
                    <select class="form-select" id="role_select" name="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <x-secondary-button>
                        <a style="text-decoration: none; color: white;"
                            href="{{ url()->previous() }}"">{{ __('Mégse') }}</a>
                    </x-secondary-button>

                    <x-primary-button>
                        {{ __('Mentés') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
