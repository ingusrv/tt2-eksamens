<section>
    <header>
        <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">
            {{ __('Import board') }}
        </h2>

        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ __("Import a board from a json file.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('board.import') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div>
            <x-input-label for="board" :value="__('File')" />
            <x-text-input id="board" name="board" type="file" class="mt-1 block w-full" required/>
            <x-input-error class="mt-2" :messages="$errors->get('board')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Import') }}</x-primary-button>

            @if (session('status') === 'board-imported')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-neutral-600 dark:text-neutral-400"
                >{{ __('Imported.') }}</p>
            @endif
        </div>
    </form>
</section>
