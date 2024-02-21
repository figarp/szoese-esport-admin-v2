@section('title')
    Csoport Létrehozása
@endsection

<x-app-layout>
    <section class="dashboard_card">
        <x-go-back-button href="{{ route('dashboard.groups.index') }}" />
        <div class="max-w-xl">
            <form method="POST" action="{{ route('dashboard.groups.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <x-input-label for="game" :value="__('Játék')" />
                    <x-text-input id="game" type="text" name="game" required autofocus />
                    <x-input-error :messages="$errors->get('game')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="description" :value="__('Ismertető')" />
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div class="form-group mb-3">
                    <label for="image" class="form-label mt-4">Kép</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="leader">Vezető</label>
                    <input type="text" id="leader" name="leader" class="form-select" autocomplete="off">
                    <div id="leaderOptionsContainer"></div>
                </div>

                <div class="d-flex justify-content-between">
                    <x-secondary-button>
                        <a style="text-decoration: none; color: white;"
                            href="{{ url()->previous() }}"">{{ __('Mégse') }}</a>
                    </x-secondary-button>

                    <x-primary-button id="submit_form" disabled>
                        {{ __('Létrehozás') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>

<script type="text/javascript">
    const leaderInput = document.getElementById("leader");
    const submitButton = document.getElementById("submit_form");
    const leaderOptionsContainer = document.getElementById("leaderOptionsContainer");

    leaderInput.addEventListener("input", function() {
        const searchQuery = this.value.trim();

        if (searchQuery.length === 0) {
            leaderOptionsContainer.innerHTML = '';
            return;
        }

        // AJAX kérés a vezetők kereséséhez
        fetch(`/dashboard/search-leaders?query=${searchQuery}`)
            .then(response => response.json())
            .then(data => {
                const leaders = data.leaders;

                // Ellenőrizzük, hogy a beírt érték a listában szereplő név
                const selectedLeader = leaders.find(leader => leader.full_name === searchQuery);
                if (!selectedLeader) {
                    leaderInput.classList.add('is-invalid');
                    submitButton.disabled = true;
                } else {
                    leaderInput.classList.remove('is-invalid');
                }

                const optionsHTML = leaders.map(leader =>
                    `<option onclick="selectLeader('${leader.id}', '${leader.full_name}')">${leader.full_name}</option>`
                ).join('');

                leaderOptionsContainer.innerHTML = optionsHTML;
            });
    });

    function selectLeader(id, name) {
        leaderInput.value = name;
        leaderInput.classList.remove('is-invalid');
        leaderInput.classList.add('is-valid');
        submitButton.disabled = false;
        leaderOptionsContainer.innerHTML = '';

        let hiddenInput = document.querySelector('input[name="leader_id"]');
        if (hiddenInput) {
            hiddenInput.value = id;
        } else {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'leader_id';
            hiddenInput.value = id;
            leaderInput.parentNode.appendChild(hiddenInput);
        }
    }
</script>
