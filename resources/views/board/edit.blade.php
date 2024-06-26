<x-app-layout>
    <div class="py-12">
        <h1 class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6 text-2xl font-bold text-gray-900 dark:text-gray-100">Edit board</h1>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('board.partials.update-board-data')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl dark:text-gray-100">
                    @include("board.partials.share-board")
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include("board.partials.delete-board")
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
