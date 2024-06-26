<x-app-layout>

<div class="p-12">
    <h2 class="font-bold dark:text-gray-100">Izveidot jaunu dēli</h2>
    <form class="mb-6" method="POST" action="{{route("board.store")}}">
        @csrf
        @method("POST")

        <input class="px-2 py-1" type="text" id="name" name="name" maxlength="255" placeholder="Dēļa nosaukums" required>

        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1">Izveidot</button>
    </form>

    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Mani kanban dēļi</h1>

    <div class="dark:bg-gray-800 p-6 flex flex-row gap-4">
        @foreach ($boards as $board)
            <div class="dark:text-gray-100 bg-gray-600 dark:bg-gray-600 p-6 w-max">
                <p class="text-lg font-semibold text-center mb-2">{{ $board->name }}</p>
                <a href="{{ route("board.show", $board->id) }}">Atvērt</a>
                <a href="{{ route("board.edit", $board->id) }}">Iestatījumi</a>
            </div>
        @endforeach
    </div>
<div>
</x-app-layout>
