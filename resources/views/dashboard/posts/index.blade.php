@section('title')
    Dashboard
@endsection

<x-app-layout>
    <div class="dashboard_card">
        <div class="max-w-xl">
            <section class="mt-5">
                <h1 class="mb-3">Bejegyzések</h1>

                <p>A szakosztály legújabb közleményei. Tagként itt olvashatod összegezve a csoportod bejegyzéseit.</p>

                <form action="{{ route('dashboard.posts.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Keresés..."
                            value="{{ request()->query('search') }}">
                        <button type="submit" class="btn btn-primary">Keresés</button>
                    </div>
                </form>

                @can('manage_posts')
                    <a href="{{ route('dashboard.posts.create') }}" class="btn btn-primary mb-5">
                        <i class="fa-solid fa-plus"></i>
                        <span>Bejegyzés létrehozása</span>
                    </a>
                @endcan

                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>

                @forelse ($posts as $post)
                    <div class="card mb-3">

                        <div class="d-flex">
                            <div class="card-body">
                                <h3 class="card-title d-flex align-items-center gap-2">
                                    <span>{{ $post->title }}</span>
                                    @if ($post->group())
                                        <img src="{{ Storage::url($post->group()->image->path) }}" class="groupIcon"
                                            title="{{ $post->group()->game }}">
                                    @endif
                                </h3>
                                <h6 class="card-subtitle text-muted">{{ $post->author->full_name() }}</h6>
                                <div class="card-body">
                                    <p class="card-text">{!! nl2br($post->slug) !!}</p>
                                </div>
                            </div>
                            @if ($post->image_id !== null)
                                <img src="{{ Storage::url($post->image->path) }}" alt=""
                                    class="indexImg align-self-center">
                            @endif
                        </div>
                        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                            <span>{{ $post->created_at }}</span>

                            @can('manage_posts')
                                <div class=" d-flex gap-1">
                                    <form action="{{ route('dashboard.posts.edit', $post->id) }}" method="get">
                                        @csrf

                                        <button class="btn btn-primary" title="Szerkesztés">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('dashboard.posts.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('delete')

                                        <button class="btn btn-danger" title="Törlés">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p>Nincsenek posztok...</p>
                @endforelse
                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
