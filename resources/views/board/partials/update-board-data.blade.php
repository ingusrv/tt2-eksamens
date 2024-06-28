<section>
    <header>
        <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">
            {{ __('Board Information') }}
        </h2>

        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ __("Update your board title.") }}
        </p>
    </header>

    <form method="post" action="{{ route('board.update', $board->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $board->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="privacy" :value="__('Privacy')" />
            <x-select-input id="privacy" name="privacy" class="mt-1 block w-full" required>
                @foreach ($privacyOptions as $option)
                    <option value="{{$option["value"]}}" {{$board->privacy === $option["value"] ? "selected" : ""}}>
                        {{$option["name"]}}
                    </option>
                @endforeach
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'board-data-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-neutral-600 dark:text-neutral-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
