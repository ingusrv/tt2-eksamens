<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="px-4 sm:px-0">
            <h1 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">{{__("Create new board")}}</h1>
            <form method="POST" action="{{route('board.store')}}">
                @csrf
                @method("POST")

                <x-text-input class="px-2 py-1" type="text" id="name" name="name" maxlength="255" placeholder="{{__('Board name')}}" required />

                <x-primary-button type="submit">{{__("Create")}}</x-primary-button>
            </form>
        </div>
    </div>

    @foreach ($panelOrder as $panel)
        @switch ($panel)
            @case ("myboards")
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <h2 class="my-6 px-4 sm:px-0 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{__("My boards")}}</h2>
                    <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg grid grid-cols-2 gap-4 sm:flex sm:flex-row sm:flex-wrap">
                        @forelse ($boards as $board)
                            <div class="p-6 sm:w-40 text-neutral-900 dark:text-neutral-100 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex flex-col gap-y-1 text-center">
                                <p class="text-lg font-bold text-center mb-4 overflow-hidden text-ellipsis" title="{{$board->name}}">{{$board->name}}</p>
                                <a href="{{route('board.show', $board->id)}}">{{__("View")}}</a>
                                <a href="{{route('board.edit', $board->id)}}">{{__("Settings")}}</a>
                            </div>
                        @empty
                            <p class="col-span-3 p-4 w-full text-bold text-center dark:text-neutral-100">{{__("No boards! To get started, create a new board")}}</p>
                        @endforelse
                    </div>
                </div>
                @break
            @case ("sharedboards")
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h2 class="my-6 px-4 sm:px-0 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{__("Boards shared with me")}}</h2>
                    <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg grid grid-cols-2 gap-4 sm:flex sm:flex-row sm:flex-wrap">
                        @forelse ($sharedBoards as $board)
                            <div class="p-6 sm:w-40 text-neutral-900 dark:text-neutral-100 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex flex-col gap-y-1 text-center">
                                <p class="text-lg font-bold text-center mb-4 overflow-hidden text-ellipsis" title="{{$board->name}}">{{ $board->name }}</p>
                                <a href="{{route('board.show', $board->id)}}">{{__("View")}}</a>
                                <a href="{{route('board.edit', $board->id)}}">{{__("Settings")}}</a>
                            </div>
                        @empty
                            <p class="w-full text-bold text-center dark:text-neutral-100">{{__("No boards")}}</p>
                        @endforelse
                    </div>
                </div>
                @break
            @case ("allboards")
                @if ($user->role === 1)
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h2 class="my-6 px-4 sm:px-0 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{__("All boards")}}</h2>
                        <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg grid grid-cols-2 gap-4 sm:flex sm:flex-row sm:flex-wrap">
                            @forelse ($allBoards as $board)
                                <div class="p-6 sm:w-40 text-neutral-900 dark:text-neutral-100 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex flex-col gap-y-1 text-center">
                                    <p class="text-lg font-bold text-center mb-4 overflow-hidden text-ellipsis" title="{{$board->name}}">{{$board->name}}</p>
                                    <a href="{{ route('adminBoard.show', $board->id) }}">{{__("View")}}</a>
                                    <a href="{{ route('board.edit', $board->id) }}">{{__("Settings")}}</a>
                                </div>
                            @empty
                                <p class="w-full text-bold text-center dark:text-neutral-100">{{__("No boards")}}</p>
                            @endforelse
                        </div>
                    </div>
                @endif
                @break
            @case ("allusers")
                @if ($user->role === 1)
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h2 class="my-6 px-4 sm:px-0 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{__("All users")}}</h2>
                        <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg overflow-x-scroll">
                            <table class="mt-6 w-full dark:text-neutral-100">
                                <thead class="text-left">
                                    <th class="p-2">{{__("Username")}}</th>
                                    <th class="p-2">{{__("Email")}}</th>
                                    <th class="p-2">{{__("Created at")}}</th>
                                    <th class="p-2">{{__("Updated at")}}</th>
                                    <th class="p-2">{{__("Actions")}}</th>
                                </thead>
                                <tbody>
                                @foreach($allUsers as $allUser)
                                    <tr>
                                        <td class="p-2">{{$allUser->name}}</td>
                                        <td class="p-2">{{$allUser->email}}</td>
                                        <td class="p-2">{{$allUser->created_at}}</td>
                                        <td class="p-2">{{$allUser->updated_at}}</td>
                                        <td class="p-2">
                                            <form method="POST" action="{{route('adminUser.destroy', $allUser->id)}}">
                                                @csrf
                                                @method("DELETE")

                                                <x-danger-button type="submit">{{__("Delete")}}</x-danger-button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @break
            @default
                <!-- Ja nesakrīt ar kādu atslēgu tad nav labi -->
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <p class="col-span-3 p-4 w-full text-bold text-center dark:text-neutral-100">{{__("Unknown panel")}}</p>
                </div>
                @break
        @endswitch
    @endforeach
</div>
</x-app-layout>
