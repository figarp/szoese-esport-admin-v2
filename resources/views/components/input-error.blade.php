@props(['messages'])

@if ($messages)
    <div class="alert alert-danger" style="margin: 10px;" role="alert">
        <ul class="pl-2 pr-2 m-0">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
