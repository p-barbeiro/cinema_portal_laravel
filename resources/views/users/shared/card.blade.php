<div class="flex flex-col space-y-6">
    <div class="border border-gray-200 shadow rounded-none sm:rounded-xl bg-white dark:bg-gray-900 dark:border-gray-700 my-5 p-5 md:p-0">
        <div class="flex flex-col lg:flex-row-reverse h-auto">
            <div class="place-content-center h-auto p-5 md:p-5 md:ps-0 mx-auto md:m-0">
                <!-- Replace 'getPoster()' with a method that retrieves user's photo -->
                <img class="object-center object-cover w-full h-auto rounded-full md:min-h-96 md:min-w-80 md:max-w-64"
                     src="{{ $user->getPhotoUrl() }}" alt="User Photo">
            </div>

            <div class="w-full p-5 text-center md:text-left space-y-1 flex flex-col">
                <div class="flex flex-row justify-between">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">{{ $user->name }}</h2>
                    <div class="flex flex-row space-x-2">
                        <!-- Example of buttons for actions -->
                        @can('view', $user)
                            <a href="{{ route('users.show', ['user' => $user]) }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500 font-medium">
                                View
                            </a>
                        @endcan
                        @can('update', $user)
                            <a href="{{ route('users.edit', ['user' => $user]) }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500 font-medium">
                                Edit
                            </a>
                        @endcan

                    </div>
                </div>
                <hr>
                <figcaption class="font-medium">
                    <div class="flex justify-center md:justify-start font-base text-base space-x-6 text-gray-700 dark:text-gray-300 md:mb-5">
                        <div>Email: {{ $user->email }}</div>
                        <!-- Replace with other user details as needed -->
                    </div>
                </figcaption>
                <!-- Example of showing additional information -->
                <div class="font-base text-base space-x-6 text-gray-700 dark:text-gray-300 md:mb-5">
                    <!-- Example of displaying user's roles or permissions -->
                    <div>Type: {{ $user->types->pluck('name')->implode(', ') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
