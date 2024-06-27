<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Panel Order') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Edit the display order of your panels on the dashboard.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.panelOrder') }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        @php
            $optionCount = count($panelOptions);
        @endphp
        <div>
            <x-input-label for="firstPanel" :value="__('First panel')" />
            <x-select-input id="firstPanel" name="firstPanel" class="mt-1 block w-full" required>
                @for ($i = 0; $i < $optionCount; $i++)
                    @php
                        $value = $panelOptions[$i]["value"];
                        $name = $panelOptions[$i]["name"];
                        $panelItem = $panelOrder[0];
                    @endphp
                    <option value="{{$value}}" {{$value === $panelItem ? "selected" : ""}}>
                        {{$name}}
                    </option>
                @endfor
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('firstPanel')" />
        </div>

        <div>
            <x-input-label for="secondPanel" :value="__('Second panel')" />
            <x-select-input id="secondPanel" name="secondPanel" class="mt-1 block w-full" required>
                @for ($i = 0; $i < $optionCount; $i++)
                    @php
                        $value = $panelOptions[$i]["value"];
                        $name = $panelOptions[$i]["name"];
                        $panelItem = $panelOrder[1];
                    @endphp
                    <option value="{{$value}}" {{$value === $panelItem ? "selected" : ""}}>
                        {{$name}}
                    </option>
                @endfor
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('secondPanel')" />
        </div>

        @if ($user->role === 1)
        <div>
            <x-input-label for="thirdPanel" :value="__('Third panel')" />
            <x-select-input id="thirdPanel" name="thirdPanel" class="mt-1 block w-full" required>
                @for ($i = 0; $i < $optionCount; $i++)
                    @php
                        $value = $panelOptions[$i]["value"];
                        $name = $panelOptions[$i]["name"];
                        $panelItem = $panelOrder[2];
                    @endphp
                    <option value="{{$value}}" {{$value === $panelItem ? "selected" : ""}}>
                        {{$name}}
                    </option>
                @endfor
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('thirdPanel')" />
        </div>

        <div>
            <x-input-label for="fourthPanel" :value="__('Fourth panel')" />
            <x-select-input id="fourthPanel" name="fourthPanel" class="mt-1 block w-full" required>
                @for ($i = 0; $i < $optionCount; $i++)
                    @php
                        $value = $panelOptions[$i]["value"];
                        $name = $panelOptions[$i]["name"];
                        $panelItem = $panelOrder[3];
                    @endphp
                    <option value="{{$value}}" {{$value === $panelItem ? "selected" : ""}}>
                        {{$name}}
                    </option>
                @endfor
            </x-select-input>

            <x-input-error class="mt-2" :messages="$errors->get('fourthPanel')" />
        </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'panel-order-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Updated.') }}</p>
            @endif
        </div>
    </form>
</section>
