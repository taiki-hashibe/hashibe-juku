<div x-data="{ messageOpen: true }">
    <div x-show="messageOpen" @click.outside="messageOpen = false"
        class="absolute top-0 right-0 mt-20 md:mt-6 me-3 md:me-10" x-transition:enter="transition liner duration-200"
        x-transition:enter-start="opacity-0 scale-0" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition liner duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-0">
        <div class="flex border shadow-md rounded-md ps-2 pe-4 py-2 bg-app-white">
            <div class="w-full md:max-w-md me-4">
                <div class="float-left text-success-500 me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-justify break-all">{{ $slot }}</p>
            </div>
            <button @click="messageOpen = false" class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
