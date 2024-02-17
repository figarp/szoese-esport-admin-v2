@section('title')
    Bejegyzés létrehozása
@endsection

<x-app-layout>
    <section class="dashboard_card">
        <x-go-back-button href="{{ route('dashboard.posts.index') }}" />
        <div class="max-w-xl">
            <form method="POST" action="{{ route('dashboard.posts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <x-input-label for="title" :value="__('Cím')" />
                    <x-text-input id="title" type="text" name="title" required autofocus />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="slug" :value="__('Tartalom')" />
                    <textarea class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" rows="3"></textarea>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="image" class="form-label mt-4">Borítókép</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="visibility" class="form-label mt-4">Láthatóság</label>
                    <select class="form-select" id="visibility" name="visibility">
                        <option value="0" selected>Mindenki</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->game }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="important" name="important">
                    <label class="form-check-label" for="important">
                        FONTOS (email-es értesítők kiküldése)
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <x-secondary-button>
                        <a style="text-decoration: none; color: white;"
                            href="{{ url()->previous() }}">{{ __('Mégse') }}</a>
                    </x-secondary-button>

                    <x-primary-button>
                        {{ __('Létrehozás') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
