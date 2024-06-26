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
        @foreach ($columns as $column)
            <div class="flex flex-col mb-4">
                <div class="text-lg font-bold dark:text-gray-100 mb-2">{{$column->name}}</div>
                <div class="dark:text-gray-100">order: {{$column->order}}</div>

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
                    @foreach ($column->cards()->get()->sortBy("order") as $card)
                        <div class="dark:bg-gray-800">
                            <p class="dark:text-gray-100">{{$card->text}}</p>
                            <div class="dark:text-gray-100">order: {{$card->order}}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
</x-app-layout>
