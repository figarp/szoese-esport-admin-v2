@section('title')
    Admin
@endsection

<x-app-layout>
    {{-- Tagok Kezelése --}}
    <div class="dashboard_card">
        <div class="max-w-xl">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#users" aria-selected="true"
                        role="tab">Tagok</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#groups" aria-selected="false" tabindex="-1"
                        role="tab">Csoportok</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade show active" id="users" role="tabpanel">
                    @include('dashboard.admin.partials.member-management-table')
                </div>
                <div class="tab-pane fade" id="groups" role="tabpanel">
                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
                        Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four
                        loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk
                        aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore
                        aesthetic magna delectus mollit.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Játékoscsoportok Kezelése --}}
</x-app-layout>
