<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Csoportjaink - SZoESE E-Sport</title>
    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/szoese_esport_logo_32.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/18c03d310a.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body>
    <x-nav-bar />
    <div class="container-lg mt-5">
        <h1 class="mb-4">Csoportjaink</h1>
        @forelse ($groups as $group)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-4 mb-3">
                        <div class="imageContrainer">
                            @if ($group->image_id === null)
                                <img loading="lazy"
                                    src="{{ Vite::asset('resources/images/szoese_esport_logo_128.png') }}"
                                    alt="" class="img-fluid">
                            @else
                                <img loading="lazy" src="{{ Storage::url($group->image->path) }}" alt=""
                                    class="img-fluid">
                            @endif
                        </div>
                        <div>
                            <h4 class="card-title">{{ $group->game }}</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Csoportvezető: {{ $group->leader->full_name() }}
                        </div>

                    </div>
                    <p class="card-text m-auto">
                        {!! nl2br($group->description) !!}
                    </p>
                    <div class="d-flex justify-content-end mt-2 mb-1">
                        <a href="{{ route('groups.show', $group->id) }}" class="btn btn-info">Bővebben</a>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    {{ $group->created_at }}
                </div>
            </div>
        @empty
            <p>Jelenleg nincsenek csoportjaink...</p>
        @endforelse
    </div>
</body>

</html>
