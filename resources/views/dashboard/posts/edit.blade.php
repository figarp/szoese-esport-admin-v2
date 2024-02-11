@section('title')
    Bejegyzés módosítása
@endsection

<x-app-layout>
    <section class="dashboard_card">
        <x-go-back-button href="{{ route('dashboard.posts.index') }}" />
        <div class="max-w-xl">
            <form method="POST" action="{{ route('dashboard.posts.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="mb-3">
                    <x-input-label for="title" :value="__('Cím')" />
                    <x-text-input id="title" type="text" name="title" required autofocus
                        value="{{ $post->title }}" />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="slug" :value="__('Tartalom')" />
                    <textarea class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" rows="3">{!! $post->slug !!}</textarea>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <x-secondary-button>
                        <a style="text-decoration: none; color: white;"
                            href="{{ url()->previous() }}">{{ __('Mégse') }}</a>
                    </x-secondary-button>

                    <x-primary-button>
                        {{ __('Mentés') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
