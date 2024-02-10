@section('title')
    Jelentkezések
@endsection

<x-app-layout>
    {{-- Tagok Kezelése --}}
    <div class="dashboard_card">
        <div class="max-w-xl">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#users" aria-selected="true" role="tab">Én
                        Jelentkezéseim</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#groups" aria-selected="false" tabindex="-1"
                        role="tab">Beérkező Jelentkezések</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade show active" id="users" role="tabpanel">
                    @include('dashboard.applications.partials.users-applications-table')
                </div>
                <div class="tab-pane fade" id="groups" role="tabpanel">
                    @include('dashboard.applications.partials.incoming-applications-table')
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            loadDataTable();
        });

        function loadDataTable() {
            let table1 = new DataTable('#my_applications_table');
            let table2 = new DataTable('#incoming_applications_table');
        }
    </script>
</x-app-layout>
