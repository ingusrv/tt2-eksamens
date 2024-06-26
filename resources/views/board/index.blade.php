<x-app-layout>

<div class="p-12">
    <h1 class="font-bold dark:text-gray-100">Izveidot jaunu dēli</h2>
    <form class="mb-6" method="POST" action="{{route("board.store")}}">
        @csrf
        @method("POST")

        <input class="px-2 py-1" type="text" id="name" name="name" maxlength="255" placeholder="Dēļa nosaukums" required>

        <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1">Izveidot</button>
    </form>

    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Mani kanban dēļi</h1>
    <div class="dark:bg-gray-800 p-6 flex flex-row gap-4">
        @forelse ($boards as $board)
            <div class="dark:text-gray-100 bg-gray-600 dark:bg-gray-600 p-6 w-max">
                <p class="text-lg font-semibold text-center mb-2">{{ $board->name }}</p>
                <a href="{{ route("board.show", $board->id) }}">Atvērt</a>
                <a href="{{ route("board.edit", $board->id) }}">Iestatījumi</a>
            </div>
        @empty
            <p class="text-bold text-center dark:text-gray-100">{{__("No boards! To get started, create a new board")}}</p>
        @endforelse
    </div>

    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Ar mani kopīgotie kanban dēļi</h1>
    <div class="dark:bg-gray-800 p-6 flex flex-row gap-4">
        @forelse ($sharedBoards as $board)
            <div class="dark:text-gray-100 bg-gray-600 dark:bg-gray-600 p-6 w-max">
                <p class="text-lg font-semibold text-center mb-2">{{ $board->name }}</p>
                <a href="{{ route("board.show", $board->id) }}">Atvērt</a>
                <a href="{{ route("board.edit", $board->id) }}">Iestatījumi</a>
            </div>
        @empty
            <p class="text-bold text-center dark:text-gray-100">{{__("No boards")}}</p>
        @endforelse
    </div>

    @if ($user->role === 1)
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Visi kanban dēļi</h1>
    <div class="dark:bg-gray-800 p-6 flex flex-row gap-4">
        @forelse ($allBoards as $board)
            <div class="dark:text-gray-100 bg-gray-600 dark:bg-gray-600 p-6 w-max">
                <p class="text-lg font-semibold text-center mb-2">{{ $board->name }}</p>
                <a href="{{ route("adminBoard.show", $board->id) }}">Atvērt</a>
                <a href="{{ route("board.edit", $board->id) }}">Iestatījumi</a>
            </div>
        @empty
            <p class="text-bold text-center dark:text-gray-100">{{__("No boards")}}</p>
        @endforelse
    </div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Visi lietotāji</h1>
    <div class="dark:bg-gray-800 p-6 flex flex-row gap-4">
        <table class="mt-6 w-full dark:text-gray-100">
            <thead class="text-left">
                <th>{{  __("Username") }}</th>
                <th>{{  __("Email") }}</th>
                <th>{{  __("Created at") }}</th>
                <th>{{  __("Updated at") }}</th>
                <th>{{  __("Actions") }}</th>
            </thead>
            <tbody>
            @foreach($allUsers as $allUser)
                <tr>
                    <td>{{$allUser->name}}</td>
                    <td>{{$allUser->email}}</td>
                    <td>{{$allUser->created_at}}</td>
                    <td>{{$allUser->updated_at}}</td>
                    <td>
                        <form method="POST" action="{{route("adminUser.destroy", $allUser->id)}}">
                            @csrf
                            @method("DELETE")

                            <div class="flex flex-col gap-y-1">
                                <button type="submit" class="dark:bg-gray-300 dark:text-black px-2 py-1 w-full">{{__("Delete")}}</button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
<div>
</x-app-layout>
