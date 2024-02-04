<section class="mt-5">
    <h1 class="mb-3">Tagok Kezelése</h1>
    <table id="usersDataTable">
        <thead>
            <th>Teljes Név</th>
            <th>Felhasználónév</th>
            <th>Email cím</th>
            <th>Beosztás</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->full_name() }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            {{ $role->display_name }}
                        @endforeach
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
