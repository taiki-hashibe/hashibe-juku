@if (!$isCanView)
    <div
        class="w-full px-2 py-4 border-primary-500 dark:border-app-slate-100 border-2 rounded-md bg-primary-50 dark:bg-app-slate-700">
        <p class="text-center font-bold mb-0">この講座を閲覧するには{{ $post->publishLevelReadable() }}登録が必要です</p>
    </div>
@endif
@if ($content)
    <div {!! $alpineData !!}>
        <div {{ $attributes->merge([
            'class' => 'content',
        ]) }}>
            {!! $content !!}
        </div>
        @foreach ($modalImages as $modalImage)
            <x-modal key="{{ 'open' . $modalImage['id'] }}" modalClass="top-[0%] px-4 sm:px-4 py-6"
                cardClass="bg-app-white w-full ps-2 pt-2 pe-2 pb-2">
                <div>
                    <div class="flex justify-end">
                        <button x-on:click="{{ 'open' . ($modalImage['id'] . '= false') }}"
                            class="p-1 text-slate-600 hover:text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <img src="{{ $modalImage['src'] }}" class="w-full" alt="" />
                </div>
            </x-modal>
        @endforeach

    </div>
@endif
