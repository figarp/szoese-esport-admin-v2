@section('title')
    Admin
@endsection

<x-app-layout>
    {{-- Tagok Kezelése --}}
    <div class="dashboard_card">
        <div class="max-w-xl">
            @include('dashboard.admin.partials.member-management-table')
        </div>
    </div>

    {{-- Játékoscsoportok Kezelése --}}
</x-app-layout>
