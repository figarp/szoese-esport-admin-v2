<section class="mt-5">
    <h1 class="mb-3">Jelentkezéseim</h1>
    <table id="my_applications_table">
        <thead>
            <th>Csoport</th>
            <th>Csoportvezető elérhetősége</th>
            <th>Jelentkezés Dátuma</th>
            <th>Állapot Frissítve</th>
            <th>Állapot</th>
            <th>Műveletek</th>
        </thead>
        <tbody>
            @foreach ($users_applications as $application)
                <tr>
                    <td>{{ $application->group->game }}</td>
                    <td>{{ $application->group->leader->email }}</td>
                    <td>{{ $application->created_at }}</td>
                    <td>
                        @if ($application->updated_at > $application->created_at)
                            {{ $application->updated_at }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{!! $application->getStatus() !!}</td>
                    <td>
                        @can('destroy_application', $application->id)
                            <form action="{{ route('dashboard.application.destroy', $application->id) }}" method="post">
                                @csrf
                                @method('delete')

                                <button class="btn btn-danger" title="Visszavonás">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
