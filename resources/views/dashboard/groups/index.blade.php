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
                                <td><a href="{{ route('dashboard.groups.show', $group->id) }}">{{ $group->game }}</a>
                                </td>
                                <td>{{ $group->leader->full_name() }}</td>
                                <td>{{ $group->shortDescription() }}</td>
                                <td>{{ $group->membersCount() }}</td>
                                <td>
                                    <div class="d-flex gap-1 align-items-center">
                                        @can('join_group', $group->id)
                                            <form action="{{ route('application.store') }}" method="POST">
                                                @csrf
                                                <input type="text" id="group_id" name="group_id" value="{{ $group->id }}" hidden>
                                                <input type="text" id="user_id" name="user_id" value="{{ Auth::user()->id }}" hidden>
                                                <button type="submit" id="submitButton" class="btn btn-success" title="Csatlakozás">
                                                    <i class="fa-solid fa-right-to-bracket"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('leave_group', $group->id)
                                            <form action="{{ route('groups.leave', $group->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" title="Kilépés">
                                                    <i class="fa-solid fa-right-from-bracket"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('edit_group', $group->id)
                                            <form action="{{ route('dashboard.groups.edit', $group->id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" title="Szerkesztés">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('delete_group')
                                            <button class="btn btn-danger" title="Törlés" data-bs-toggle="modal"
                                                data-bs-target="#deleteGroup{{ $group->id }}Modal">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <x-modal id="deleteGroup{{ $group->id }}Modal" name="Csoport Törlése">
                                                <p>Biztosan törölni szeretnéd a '<strong>{{ $group->game }}</strong>' nevű
                                                    csoportot?</p>
                                                <form action="{{ route('dashboard.groups.destroy', $group->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')

                                                    <div class="form-group mb-3">
                                                        <x-input-label for="group{{ $group->id }}"
                                                            value="{{ __('A megerősítéshez írd be a csoport nevét!') }}" />
                                                        <x-text-input id="group{{ $group->id }}"
                                                            name="group{{ $group->id }}" type="text"
                                                            oninput="checkGroupName('group{{ $group->id }}', '{{ $group->game }}', 'deleteGroup{{ $group->id }}Btn')"
                                                            class="is-invalid" />
                                                    </div>

                                                    <button type="submit" class="btn btn-danger" title="Törlés"
                                                        id="deleteGroup{{ $group->id }}Btn" disabled>
                                                        <i class="fa-solid fa-trash"></i>
                                                        <span>Törlés</span>
                                                    </button>
                                                </form>
                                            </x-modal>
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

                    $('form').submit(function(){
                        $(this).find('button[type="submit"]').prop('disabled', true);
                    });
                });

                function checkGroupName(inputId, groupName, btn) {
                    console.log(inputId, groupName)
                    if ($('#' + inputId).val() === groupName) {
                        $('#' + inputId).addClass('is-valid').removeClass('is-invalid');
                        $('#' + btn).prop('disabled', false);
                    } else {
                        $('#' + inputId).addClass('is-invalid').removeClass('is-valid');
                        $('#' + btn).prop('disabled', true);
                    }
                }

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
