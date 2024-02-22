@section('title')
    {{ $group->game }} Csoport
@endsection

<x-app-layout>
    <section class="dashboard_card">
        <x-go-back-button href="{{ route('dashboard.groups.index') }}" />
        <div class="max-w-xl">
            <div class="d-flex flex-column justify-content-center align-items-center gap-5 mb-3">
                <div class="imageContrainer">
                    @if ($group->image_id === null)
                        <img src="{{ Vite::asset('resources/images/szoese_esport_logo_sotet_256.png') }}" alt=""
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
            <section class="mb-5">
                <h3>Tagok</h3>
                <table id="usersDataTable">
                    <thead>
                        <tr>
                            <th>Név</th>
                            <th>Felhasználónév</th>
                            <th>Beosztás</th>
                            <th>Csatlakozás Dátuma</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group->members as $member)
                            <tr>
                                <td>{{ $member->full_name() }}</td>
                                <td>{{ $member->username }}</td>
                                <td>{{ $member->getHighestRole()->display_name }}</td>
                                <td>{{ $group->memberJoinedAt($member->id) }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @can('manage_group_members', $group->id)
                                            @if ($group->leader->id !== $member->id)
                                                <form
                                                    action="{{ route('dashboard.groups.kick', [$group->id, $member->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')

                                                    <button class="btn btn-danger" title="Eltávolítás">
                                                        <i class="fa-solid fa-user-minus"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </section>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        loadDataTable();
    });

    function loadDataTable() {
        let table = new DataTable('#usersDataTable');
    }
</script>
