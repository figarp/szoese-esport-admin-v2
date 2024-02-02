<section>
    <header>
        <h2>
            {{ __('Tagok Kezelése') }}
        </h2>

        <p>
            {{ __('Regisztrált felhasználók kezelése. ') }}
        </p>
    </header>
    <table id="tblData">
        <thead>
            <th>Teljes Név</th>
            <th>Felhasználónév</th>
            <th>Email cím</th>
            <th>Beosztás</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->full_name() }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->display_name }}</td>
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
        let table = new DataTable('#tblData');
    }
</script>
