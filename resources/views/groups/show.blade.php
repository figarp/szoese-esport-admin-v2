<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $group->game }} Csoport - SZoESE E-Sport</title>
    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/szoese_esport_logo_32.png') }}" type="image/x-icon">
    <meta name="description" content="{{ $group->description }}">
    <meta property="og:title" content="{{ $group->game }} Csoport - SZoESE E-Sport">
    <meta property="og:description" content="{{ $group->description }}">
    <meta property="og:image" content="{{ Storage::url($group->image->path) }}">
    <meta property="og:url" content="https://esportszoese.hu/groups/{{ $group->id }}">
    <meta property="og:type" content="website">

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
        <x-go-back-button href="{{ route('groups.index') }}" />
        <div class="max-w-xl">
            <div class="d-flex flex-column justify-content-center align-items-center gap-5 mb-3">
                <div class="imageContrainer">
                    @if ($group->image_id === null)
                        <img src="{{ Vite::asset('resources/images/szoese_esport_logo_128.png') }}" alt=""
                            class="img-fluid">
                    @else
                        <img src="{{ Storage::url($group->image->path) }}" alt="" class="img-fluid">
                    @endif
                </div>
                <table class="table table-sm table-hover">
                    <tbody>
                        <tr>
                            <th>Csoportnév</th>
                            <td>{{ $group->game }}</td>
                        </tr>
                        <tr>
                            <th>Csoportvezető</th>
                            <td>{{ $group->leader->full_name() }}</td>
                        </tr>
                        <tr>
                            <th>Elérhetőség</th>
                            <td>{{ $group->leader->email }}</td>
                        </tr>
                        <tr>
                            <th>Létrehozás Dátuma</th>
                            <td>{{ $group->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Létszám</th>
                            <td>{{ $group->membersCount() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <section class="mb-5">
                <h3>Leírás</h3>
                <p class="lead">
                    {!! nl2br($group->description) !!}
                </p>
            </section>

            <div class="mb-5 mt-3 d-flex justify-content-center">
                <a class="btn btn-primary" href="{{ route('dashboard.groups.index') }}">
                    Csatlakozz!
                </a>
            </div>
        </div>
</body>

</html>
