<section class="mt-5">
    <h1 class="mb-3">Játékoscsoportba érkező jelentkezések</h1>
    <table id="incoming_applications_table">
        <thead>
            <th>Jelentkező Neve</th>
            <th>Jelentkező Email Címe</th>
            <th>Csoport</th>
            <th>Jelentkezés Dátuma</th>
            <th>Állapot</th>
            <th>Műveletek</th>
        </thead>
        <tbody>
            @foreach ($incoming_applications as $application)
                <tr>
                    <td>{{ $application->user->full_name() }}</td>
                    <td>{{ $application->user->email }}</td>
                    <td>{{ $application->group->game }}</td>
                    <td>{{ $application->created_at }}</td>
                    <td>{!! $application->getStatus() !!}</td>
                    <td>
                        <div class="d-flex gap-1">
                            @can('manage_group_members', $application->group->id)
                                @if ($application->status === 'pending')
                                    <form action="{{ route('application.accept', $application->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-success" title="Elfogadás">
                                            <i class="fa-solid fa-square-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('application.reject', $application->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-danger" title="Elutasítás">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('dashboard.application.destroy', $application->id) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" title="Törlés">
                                            <i class="fa-solid fa-trash"></i>
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
