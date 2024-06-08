<div
    x-data="{
        mode: localStorage.getItem('colorMode') || 'light', // Set initial state
        setColorMode: m => {
            if (m === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('colorMode', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('colorMode', 'light');
            }
            mode = m; // Update mode variable after setting
        }
    }"
    x-init="() => {
        // No need to check localStorage here, initial state is set in x-data
    }"
    class="flex items-center justify-center"
>
    <!-- Icons hidden on mobile view -->
    <button
        @click="mode === 'light' ? mode = 'dark' : mode = 'light'; setColorMode(mode);"
        class="hidden sm:flex items-center justify-center w-5 h-5 rounded-full focus:outline-none"
    >
        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24">
            <path x-show="mode === 'light'" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
            <path x-show="mode === 'dark'" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 21a9 9 0 0 1-.5-17.986V3c-.354.966-.5 1.911-.5 3a9 9 0 0 0 9 9c.239 0 .254.018.488 0A9.004 9.004 0 0 1 12 21Z"/>
        </svg>
    </button>

    <!-- Text for light mode -->
    <div class="sm:hidden flex flex-row justify-center space-x-5 my-5">
        <x-button element="submit" type="light" text="Light mode"
                  @click="mode === 'dark' ? mode = 'light' : mode = 'dark'; setColorMode(mode);"/>
        <x-button element="submit" type="dark" text="Dark mode"
                  @click="mode === 'light' ? mode = 'dark' : mode = 'light'; setColorMode(mode);"/>
    </div>

</div>
