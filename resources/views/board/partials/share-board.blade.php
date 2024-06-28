<section>
    <header>
        <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">
            {{ __('Share Board') }}
        </h2>

        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ __("Share your board with other users.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('sharedboard.store', $board->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <div>
            <x-input-label for="userId" :value="__('User')" />
            <x-select-input id="userId" name="userId" class="mt-1 block w-full" required>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->name}} ({{$user->email}})
                    </option>
                @endforeach
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('userId')" />
        </div>

        <div>
            <x-input-label for="permissions" :value="__('Permissions')" />
            <x-select-input id="permissions" name="permissions" class="mt-1 block w-full" required>
                <option value="0">
                    {{__("Can view")}}
                </option>
                <option value="1">
                    {{__("Can edit")}}
                </option>
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('permissions')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'board-shared')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-neutral-600 dark:text-neutral-400"
                >{{ __('Shared.') }}</p>
            @endif
        </div>
    </form>

    @if (count($sharedUsers)>0)
        <div class="overflow-x-scroll">
            <table class="mt-6 w-full">
                <thead class="text-left">
                    <th class="p-2">{{  __("Username") }}</th>
                    <th class="p-2">{{  __("Email") }}</th>
                    <th class="p-2">{{  __("Permissions") }}</th>
                    <th class="p-2">{{  __("Actions") }}</th>
                </thead>
                <tbody>
                @foreach($sharedUsers as $sharedUser)
                    <tr>
                        <td class="p-2">{{$sharedUser->name}}</td>
                        <td class="p-2">{{$sharedUser->email}}</td>
                        <td class="p-2">{{$sharedUser->pivot->permissions === 0 ? __("Can view") : __("Can edit")}}</td>
                        <td class="p-2">
                            <form method="POST" action="{{route("sharedboard.destroy", [$board->id, $sharedUser->id])}}">
                                @csrf
                                @method("DELETE")

                                <div class="flex flex-col gap-y-1">
                                    <x-danger-button type="submit">{{__("Remove")}}</x-danger-button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
