<div x-data="{ userTrialViewing: true }">
    <x-modal key="userTrialViewing">
        <div class="ps-4 mb-6">
            <button @click="userTrialViewing = false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p class="text-center mb-12">
            トライアルチケットを使ってフルバージョンの記事を見ることができます！
        </p>
        <form action="{{ route('user.post.trial-viewing') }}" method="POST" class="mb-6">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <x-gradation-button class="w-full flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 me-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
                チケットを使う！
            </x-gradation-button>
        </form>
        <div class="flex justify-center">
            <button @click="userTrialViewing = false"
                class="inline-block px-8 py-2 text-nowrap hover:underline font-bold">
                使わない
            </button>
        </div>

    </x-modal>
</div>
