<section class="mt-5">
    <h1 class="mb-3">Tagok Kezelése</h1>
    <table id="usersDataTable">
        <thead>
            <th>Teljes Név</th>
            <th>Felhasználónév</th>
            <th>Email cím</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->full_name() }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('dashboard.admin.userManagement.edit', $user->id) }}" class="btn btn-info"
                            role="button" title="Szerkesztés"><i class="fa-solid fa-pen-to-square"></i></a>
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
</script>
