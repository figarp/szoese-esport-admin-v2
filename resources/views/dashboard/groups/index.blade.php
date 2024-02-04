@section('title')
    Játékoscsoportok
@endsection

<x-app-layout>
    <div class="dashboard_card">
        <div class="max-w-xl">
            <section class="mt-5">
                <h1 class="mb-3">Csoportok</h1>
                @can('create_group')
                    <a href="{{ route('dashboard.groups.create') }}" class="btn btn-primary mb-5">
                        <i class="fa-solid fa-plus"></i>
                        <span>Új Csoport</span>
                    </a>
                @endcan
                <table id="usersDataTable">
                    <thead>
                        <th>Játék</th>
                        <th>Vezető</th>
                        <th>Leírás</th>
                        <th>Tagok száma</th>
                        <th>Műveletek</th>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>{{ $group->game }}</td>
                                <td>{{ $group->leader->full_name() }}</td>
                                <td>{{ $group->shortDescription() }}</td>
                                <td>{{ $group->membersCount() }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @can('join_group', $group->id)
                                            <form action="{{ route('groups.join', $group->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-success" title="Csatlakozás">
                                                    <i class="fa-solid fa-right-to-bracket"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('leave_group', $group->id)
                                            <form action="{{ route('groups.leave', $group->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger" title="Kilépés">
                                                    <i class="fa-solid fa-right-from-bracket"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('edit_group', $group->id)
                                            <form action="{{ route('dashboard.groups.edit', $group->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-primary" title="Szerkesztés">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('delete_group')
                                            <form action="{{ route('dashboard.groups.destroy', $group->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger" title="Törlés">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            <script type="text/javascript">
                $(document).ready(function() {
                    loadDataTable();
                });

                function loadDataTable() {
                    let table = new DataTable('#usersDataTable');
                }

                function deleteGroup(id) {
                    document.getElementById('deleteBtn').disabled = true;

                    Swal.fire({
                        title: "Biztos vagy benne?",
                        text: "A csoport törlését nem lehet visszaállítani!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Igen, töröld!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/dashboard/groups/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                })
                                .then(() => {
                                    location.reload();
                                })
                                .catch(error => {
                                    // Hiba esetén hibaüzenet megjelenítése
                                    console.log(error);
                                    Swal.fire({
                                        title: "Hiba!",
                                        text: `Ismeretlen hiba történt...`,
                                        icon: "error"
                                    });

                                    document.getElementById('deleteBtn').disabled = false;
                                })
                        } else {
                            document.getElementById('deleteBtn').disabled = false;
                        }
                    });
                }
            </script>

        </div>
    </div>
</x-app-layout>
