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
                        <th>Tagok száma</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>{{ $group->game }}</td>
                                <td>{{ $group->leader->full_name() }}</td>
                                <td>{{ $group->shortDescription() }}</td>
                                <td>{{ $group->usersCount() }}</td>
                                <td>
                                    @if ($group->leader->id === auth()->id())
                                        <!-- Ha a felhasználó a csoport vezetője, csak a szerkesztés és törlés gombok jelennek meg -->
                                        <x-danger-button id="deleteBtn" onclick="deleteGroup({{ $group->id }})"
                                            title="Törlés">
                                            <i class="fa-solid fa-trash"></i>
                                        </x-danger-button>
                                        <a href="{{ route('dashboard.groups.edit', $group->id) }}"
                                            class="btn btn-primary" title="Szerkesztés">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @else
                                        <!-- Ha a felhasználó nem a csoport vezetője -->
                                        @if ($group->isUserMember(auth()->id()))
                                            <!-- Ha a felhasználó csatlakozott a csoportba, csak a kilépés gomb jelenik meg -->
                                            <form action="{{ route('groups.leave', $group->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-danger" title="Kilépés">
                                                    <i class="fa-solid fa-right-from-bracket"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Ha a felhasználó nem csatlakozott a csoportba, csak a csatlakozás gomb jelenik meg -->
                                            <form action="{{ route('groups.join', $group->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-success" title="Csatlakozás">
                                                    <i class="fa-solid fa-right-to-bracket"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
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
