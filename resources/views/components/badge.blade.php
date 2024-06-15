@php
    $colors = match($type) {
        'gray' => 'bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700/10',
        'red' => 'bg-red-50 text-red-700 ring-red-600/10 dark:border-red-700 dark:bg-red-500/10',
        'yellow' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-yellow-800/20',
        'green' => 'bg-green-50 text-green-700 ring-green-600/20 dark:border-green-700 dark:bg-gray-500/10',
        'blue' => 'bg-blue-50 text-blue-700 ring-blue-700/10 dark:bg-blue-900 dark:text-blue-300 dark:ring-blue-800/10',
        'indigo' => 'bg-indigo-50 text-indigo-700 ring-indigo-700/10 dark:bg-indigo-900 dark:text-indigo-300 dark:ring-indigo-800/10',
        'purple' => 'bg-purple-50 text-purple-700 ring-purple-700/10 dark:bg-purple-900 dark:text-purple-300 dark:ring-purple-800/10',
        'pink' => 'bg-pink-50 text-pink-700 ring-pink-700/10 dark:bg-pink-900 dark:text-pink-300 dark:ring-pink-800/10',
        default => 'bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700/10',
    }
@endphp

<span class="flex flex-row justify-center rounded-md px-2 py-1 w-full text-xl ring-1 ring-inset transition ease-in-out duration-150 {{ $colors }}">
    {{ $text }}
</span>

