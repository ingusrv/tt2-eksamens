<x-app-layout>
    <div class="py-12">
        <h1 class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{__("Profile")}}</h1>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-panel-order')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.import-board')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
