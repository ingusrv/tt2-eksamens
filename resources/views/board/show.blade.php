<x-app-layout>
<div class="pt-12">
    <div class="mb-6 px-4">
        <h1 class="sm:px-0 text-2xl font-bold text-neutral-900 dark:text-neutral-100 overflow-hidden text-ellipsis" title="{{$board->name}}">{{ $board->name }}</h1>
        <div class="dark:text-neutral-400">{{$canEdit ? __("Can edit") : __("Can view")}}</div>
    </div>

    @if ($canEdit)
        <div class="mb-6 px-4">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">{{__("Create new column")}}</h2>
            <form method="POST" action="{{route('column.store', $board->id)}}">
                @csrf
                @method("POST")

                <x-text-input class="px-2 py-1" type="text" id="name" name="name" maxlength="255" placeholder="{{__('Column name')}}" required />

                <x-primary-button type="submit">{{__("Add")}}</x-primary-button>
            </form>
        </div>
    @endif

    <div class="h-[64rem] px-4 flex flex-row gap-x-4 overflow-scroll">
        @php
            $columnCount = count($columns);
        @endphp
        @for ($i = 0; $i < $columnCount; $i++)
            @php
                $column = $columns[$i];
                $prevColumn = $i === 0 ? null : $columns[$i-1]->id;
                $nextColumn = $i === $columnCount - 1 ? null : $columns[$i+1]->id;
            @endphp

            <div class="h-max px-2 pb-3 flex flex-col mb-4 bg-white dark:bg-neutral-800 shadow rounded-lg" x-data="{ addCardOpen: false }">
                <div class="px-2 py-2 flex flex-row">
                    <h3 class="w-fit text-lg font-bold text-neutral-900 dark:text-neutral-100 overflow-hidden text-ellipsis" title="{{$column->name}}">{{$column->name}}</h3>
                    @if ($canEdit)
                        <div class="dropdown ml-auto relative" x-data="{ open: false }">
                            <button class="block h-full my-auto" @click="open = !open">
                                <svg class="text-white cursor-pointer"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            </button>
                            <div class="dropdown-menu bg-white dark:bg-neutral-800 border border-neutral-600 py-1 z-20 shadow rounded-lg absolute" :class="{'invisible': !open}">
                                <div class="top-0 flex flex-col right-0 mt-2 w-28 text-neutral-100 origin-top-right bg-transparent focus:outline-none">
                                    <button @click="open = false; addCardOpen = !addCardOpen" type="submit" class="w-full px-4 py-2 text-sm hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Add card")}}</button>
                                    @if ($prevColumn != null)
                                        <form method="POST" action="{{route("column.swap", [$board->id, $column->id, $prevColumn])}}">
                                            @csrf
                                            @method("PATCH")

                                            <button @click="open = false" type="submit" class="w-full px-4 py-2 text-sm bg-transparent hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Move left")}}</button>
                                        </form>
                                    @endif
                                    @if ($nextColumn != null)
                                        <form method="POST" action="{{route("column.swap", [$board->id, $column->id, $nextColumn])}}">
                                            @csrf
                                            @method("PATCH")

                                            <button @click="open = false" type="submit" class="w-full px-4 py-2 text-sm bg-transparent hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Move right")}}</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{route("column.destroy", [$board->id, $column->id])}}">
                                        @csrf
                                        @method("DELETE")

                                        <button @click="open = false" type="submit" class="w-full px-4 py-2 text-sm bg-transparent hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Delete")}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!--
                <div class="dark:text-gray-100">order: {{$column->order}}</div>
                <div class="dark:text-gray-100">previous: {{$prevColumn}}</div>
                <div class="dark:text-gray-100">next: {{$nextColumn}}</div>
                -->


                @if ($canEdit)
                    <form class="mb-4" method="POST" :class="{'hidden': !addCardOpen}" action="{{route("card.store", [$board->id, $column->id])}}">
                        @csrf
                        @method("POST")

                        <div class="flex flex-col gap-y-1">
                            <!--<label for="text" class="dark:text-gray-100">Teksts:</label>-->
                            <x-text-input type="text" id="text" name="text" placeholder="{{__('Text')}}" required />
                            <x-primary-button type="submit" class="w-full">{{__("Add")}}</x-primary-button>
                        </div>
                    </form>
                @endif

                <div class="w-64 flex flex-col gap-y-2">
                    @php
                        $cards = $column->cards()->orderBy("order", "asc")->get();
                        $cardCount = count($cards);
                    @endphp
                    @for ($j = 0; $j < $cardCount; $j++)
                        @php
                            $card = $cards[$j];
                            $prevCard = $j === 0 ? null : $cards[$j-1]->id;
                            $nextCard = $j === $cardCount - 1 ? null : $cards[$j+1]->id;
                        @endphp
                        <div class="p-1 flex flex-row dark:bg-neutral-700 rounded-lg">
                            <p class="dark:text-neutral-100">{{$card->text}}</p>
                            <!--
                            <div class="dark:text-gray-100">order: {{$card->order}}</div>
                            <div class="dark:text-gray-100">previous: {{$prevCard}}</div>
                            <div class="dark:text-gray-100">next: {{$nextCard}}</div>
                            -->

                            @if ($canEdit)
                                <div class="grow-0 dropdown ml-auto relative" x-data="{ open: false }">
                                    <button class="block h-full my-auto" @click="open = !open">
                                        <svg class="text-white cursor-pointer"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                                    </button>
                                    <div class="dropdown-menu bg-white dark:bg-neutral-800 border border-neutral-600 py-1 z-10 shadow rounded-lg absolute" :class="{'invisible': !open}">
                                        <div class="top-0 flex flex-col right-0 mt-2 w-28 text-neutral-100 origin-top-right bg-transparent focus:outline-none">
                                            @if ($prevCard != null)
                                                <form method="POST" action="{{route("card.swap", [$board->id, $column->id, $card->id, $prevCard])}}">
                                                    @csrf
                                                    @method("PATCH")

                                                    <div class="flex flex-col gap-y-1">
                                                        <button @click="open = false" type="submit" class="w-full px-4 py-2 text-sm bg-transparent hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Move up")}}</button>
                                                    </div>
                                                </form>
                                            @endif
                                            @if ($nextCard != null)
                                                <form method="POST" action="{{route("card.swap", [$board->id, $column->id, $card->id, $nextCard])}}">
                                                    @csrf
                                                    @method("PATCH")

                                                    <div class="flex flex-col gap-y-1">
                                                        <button @click="open = false" type="submit" class="w-full px-4 py-2 text-sm bg-transparent hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Move down")}}</button>
                                                    </div>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{route("card.destroy", [$board->id, $column->id, $card->id])}}">
                                                @csrf
                                                @method("DELETE")

                                                <div class="flex flex-col gap-y-1">
                                                    <button @click="open = false" type="submit" class="w-full px-4 py-2 text-sm bg-transparent hover:bg-neutral-100 hover:text-neutral-900 border-0">{{__("Delete")}}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>
</div>
</x-app-layout>
