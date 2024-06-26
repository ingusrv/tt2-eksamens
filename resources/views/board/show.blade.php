<x-app-layout>
<div class="p-12">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ $board->name }}</h1>

    <h2 class="font-bold dark:text-gray-100">Pievienot jaunu kolonnu</h2>
    <form method="POST" action="{{route("column.store", $board->id)}}">
        @csrf
        @method("POST")

        <input class="px-2 py-1" type="text" id="name" name="name" maxlength="255" placeholder="Kolonnas nosaukums" required>

        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1">Pievienot</button>
    </form>

    <div class="flex flex-row mt-6 gap-x-4 overflow-x-scroll">
        @php
            $columnCount = count($columns);
        @endphp
        @for ($i = 0; $i < $columnCount; $i++)
            @php
                $column = $columns[$i];
                $prevColumn = $i === 0 ? null : $columns[$i-1]->id;
                $nextColumn = $i === $columnCount - 1 ? null : $columns[$i+1]->id;
            @endphp

            <div class="flex flex-col mb-4">
                <div class="text-lg font-bold dark:text-gray-100 mb-2">{{$column->name}}</div>
                <div class="dark:text-gray-100">order: {{$column->order}}</div>
                <div class="dark:text-gray-100">previous: {{$prevColumn}}</div>
                <div class="dark:text-gray-100">next: {{$nextColumn}}</div>

                @if ($prevColumn != null)
                    <form method="POST" action="{{route("column.swap", [$board->id, $column->id, $prevColumn])}}">
                        @csrf
                        @method("PATCH")

                        <div class="flex flex-col gap-y-1">
                            <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Pārvietot pa kreisi</button>
                        </div>
                    </form>
                @endif
                @if ($nextColumn != null)
                    <form method="POST" action="{{route("column.swap", [$board->id, $column->id, $nextColumn])}}">
                        @csrf
                        @method("PATCH")

                        <div class="flex flex-col gap-y-1">
                            <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Pārvietot pa labi</button>
                        </div>
                    </form>
                @endif

                <form method="POST" action="{{route("column.destroy", [$board->id, $column->id])}}">
                    @csrf
                    @method("DELETE")

                    <div class="flex flex-col gap-y-1">
                        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Dzēst</button>
                    </div>
                </form>

                <form method="POST" action="{{route("card.store", [$board->id, $column->id])}}">
                    @csrf
                    @method("POST")

                    <div class="flex flex-col gap-y-1">
                        <!--<label for="text" class="dark:text-gray-100">Teksts:</label>-->
                        <input class="px-2 py-1" type="text" id="text" name="text" placeholder="Teksts" required>
                        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Pievienot</button>
                    </div>
                </form>

                <h3 class="dark:text-gray-100">Cards:</h3>

                <div class="flex flex-col gap-y-2">
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
                        <div class="dark:bg-gray-800">
                            <p class="dark:text-gray-100">{{$card->text}}</p>
                            <div class="dark:text-gray-100">order: {{$card->order}}</div>
                            <div class="dark:text-gray-100">previous: {{$prevCard}}</div>
                            <div class="dark:text-gray-100">next: {{$nextCard}}</div>

                            @if ($prevCard != null)
                                <form method="POST" action="{{route("card.swap", [$board->id, $column->id, $card->id, $prevCard])}}">
                                    @csrf
                                    @method("PATCH")

                                    <div class="flex flex-col gap-y-1">
                                        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Pārvietot uz augšu</button>
                                    </div>
                                </form>
                            @endif
                            @if ($nextCard != null)
                                <form method="POST" action="{{route("card.swap", [$board->id, $column->id, $card->id, $nextCard])}}">
                                    @csrf
                                    @method("PATCH")

                                    <div class="flex flex-col gap-y-1">
                                        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Pārvietot uz leju</button>
                                    </div>
                                </form>
                            @endif
                            <form method="POST" action="{{route("card.destroy", [$board->id, $column->id, $card->id])}}">
                                @csrf
                                @method("DELETE")

                                <div class="flex flex-col gap-y-1">
                                    <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">Dzēst</button>
                                </div>
                            </form>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>
</div>
</x-app-layout>
