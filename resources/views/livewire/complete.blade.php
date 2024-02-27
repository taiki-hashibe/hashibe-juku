<div>
    <button wire:click="toggle" wire:key="bookmark" class="px-0 md:px-4 py-1 me-2 group">
        <div class="flex items-center">
            <div
                class="p-1 border-2 border-transparent rounded-full me-2 {{ $completePost ? 'bg-orange-400 text-white group-hover:bg-white group-hover:border-orange-400 group-hover:text-orange-400' : 'text-slate-800 group-hover:bg-white group-hover:border-orange-400 group-hover:text-orange-400' }}">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>

            </div>
            <span class="text-sm text-slate-700 font-bold group-hover:underline hidden md:block">
                @if ($completePost)
                    完了済み
                @else
                    レッスンを完了する！
                @endif
            </span>
        </div>
    </button>
</div>
