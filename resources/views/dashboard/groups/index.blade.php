@section('title')
    Játékoscsoportok
@endsection

<x-app-layout>
    <div class="dashboard_card">
        <div class="max-w-xl">
            <section class="mt-5">
                <h1 class="mb-3">Csoportok</h1>
                <a href="{{ route('dashboard.groups.create') }}" class="btn btn-primary mb-5"><i
                        class="fa-solid fa-plus"></i> <span>Új Csoport</span></a>
                <table id="usersDataTable">
                    <thead>
                        <th>Játék</th>
                        <th>Vezető</th>
                        <th>Leírás</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>{{ $group->game }}</td>
                                <td>{{ $group->leader->full_name() }}</td>
                                <td>{{ $group->shortDescription() }}</td>
                                <td>
                                    <x-danger-button onclick="deleteGroup({{ $group->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </x-danger-button>
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
                                });
                        }
                    });
                }
            </script>

        </div>
    </div>
</x-app-layout>
