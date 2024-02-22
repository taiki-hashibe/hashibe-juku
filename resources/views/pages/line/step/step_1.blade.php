<x-guest-layout class="bg-white" :unlink="true">
    <div class="mb-8">
        <div class="mb-24">
            <h2 class="text-3xl md:text-5xl font-black text-center mb-8">自己紹介</h2>
            <video controls class="mb-8">
                <source src="{{ config('line.video.1') }}" type="video/mp4">
            </video>
            <p class="text-center leading-8">
                {{ $user->name }}さん<br>
                友だち追加ありがとうございます。
                <br>
                本日は僕の自己紹介動画になります！<br>
                ベースと出会うまで、プロになったきっかけなどについてお話ししました。<br>
                <br>
                また、ページの下の方にアンケートがありますので、そちらも回答いただけると嬉しいです！<br>
                それでは今後の配信もお楽しみに！
            </p>
        </div>
        <hr class="mb-24">
        <div class="mb-24">
            <div class="w-full flex flex-col">
                <h3 class="text-xl font-bold text-center mb-4">アンケート</h3>
                @if ($user->questionnaire()->where('route_name', 'line.step.step-1')->doesntExist())
                    <form action="{{ route('line.step.step-1') }}" method="post">
                        @csrf
                        <x-form-group>
                            <x-label required error="question_1">
                                {{ $user->name }}さんはベースをもう弾いていますか？
                            </x-label>
                            <x-input-radio name="question_1" value="弾いている！" />
                            <x-input-radio name="question_1" value="弾いていない！" />
                        </x-form-group>
                        <x-form-group>
                            <x-label required error="question_2">
                                ベース歴はどれくらいですか？
                            </x-label>
                            <x-input-radio name="question_2" value="1年未満" />
                            <x-input-radio name="question_2" value="1～3年" />
                            <x-input-radio name="question_2" value="3～5年" />
                            <x-input-radio name="question_2" value="5年以上" />
                        </x-form-group>
                        <x-form-group>
                            <x-label required error="question_3">
                                {{ $user->name }}さんが気になる奏法や練習したいことはありますか？
                            </x-label>
                            <x-input-radio name="question_3" value="まだわからない" />
                            <x-input-radio name="question_3" value="スラップ" />
                            <x-input-radio name="question_3" value="ジャズ" />
                            <x-input-radio name="question_3" value="リズムについて" />
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
