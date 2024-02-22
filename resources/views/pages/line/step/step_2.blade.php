<x-guest-layout class="bg-white" :unlink="true">
    <div class="mb-8">
        <div class="mb-24">
            <h2 class="text-3xl md:text-5xl font-black text-center mb-8">ぼくが練習する時に一番大切にしていること</h2>
            <video controls class="mb-8">
                <source src="{{ asset('video/video-kfewojwfe.mp4') }}" type="video/mp4">
            </video>
            <p class="text-center leading-8">
                今回は僕が練習する時に一番大切にしていることについてお話しします！<br>
                動画の視聴が完了したら下のアンケートの記入をお願いします！
            </p>
        </div>
        <hr class="mb-24">
        <div class="mb-24">
            <div class="w-full flex flex-col">
                <h3 class="text-xl font-bold text-center mb-4">アンケート</h3>
                @if ($user->questionnaire()->where('route_name', 'line.step.step-2')->doesntExist())
                    <form action="{{ route('line.step.step-2') }}" method="post">
                        @csrf
                        <x-form-group>
                            <x-label required error="question_1">
                                動画の内容はいかがでしたか？
                            </x-label>
                            <x-input-radio name="question_1" value="よくわかった" />
                            <x-input-radio name="question_1" value="まあまあわかった" />
                            <x-input-radio name="question_1" value="普通" />
                            <x-input-radio name="question_1" value="よくわからなかった" />
                            <x-input-radio name="question_1" value="全くわからなかった" />
                        </x-form-group>
                        <x-form-group>
                            <x-label>
                                他に感想があればお聞かせください！
                            </x-label>
                            <x-textarea name="question_2">
                                {{ old('question_2') }}
                            </x-textarea>
                        </x-form-group>
                        <div>
                            <button
                                class="p-0.5 shadow-lg rounded-md bg-gradient-to-r from-orange-600 to-pink-500 block rounded-md">
                                <div
                                    class="bg-white px-8 py-4 rounded-md text-white border-1 font-bold bg-gradient-to-r from-orange-600 to-pink-500 duration-200 hover:text-orange-500 hover:from-white hover:to-white hover:border-orange-500">
                                    <span>回答を送信する！</span>
                                </div>
                            </button>
                        </div>
                    </form>
                @else
                    <x-alert status="info" title="既に回答済みのアンケートです！" class="mb-6"></x-alert>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
