@section('title')
    Beállítások
@endsection

<x-app-layout>
    <div class="dashboard_card">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="dashboard_card">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="dashboard_card">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
