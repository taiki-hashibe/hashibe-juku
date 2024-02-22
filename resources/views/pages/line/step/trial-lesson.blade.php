<x-guest-layout class="bg-white" :unlink="true" :noindex="true">
    <div class="mb-8">
        <div class="mb-24">
            <h2 class="text-3xl md:text-5xl font-black text-center mb-8">無料体験レッスンについて</h2>
            <p class="text-center leading-8 mb-8">
                {{ $user->name }}さんへ<br>
                ここまで配信をご覧いただきありがとうございます！<br>
                オンラインレッスンの無料体験のご案内です！<br>
            </p>
            <p class="font-bold text-center leading-8">
                必要なもの
            </p>
            <ul class="list-disc flex flex-col items-center mb-8">
                <li>
                    ZOOM
                </li>
                <li>
                    インターネット環境
                </li>
            </ul>
            <p class="text-center">
                ※楽器をお持ちの方は楽器のご準備もお願いします！
            </p>
            <p class="text-center leading-8 mb-8">
                質問などありましたら公式LINEの方までお気軽にお問い合わせください！
            </p>
        </div>
        <hr class="mb-24">
        <div class="mb-24">
            <div class="w-full flex flex-col">
                <h3 class="text-xl font-bold text-center mb-8">無料体験レッスンお申込みフォーム</h3>
                @if ($valid)
                    <form action="{{ route('line.step.trial-lesson-confirm') }}" method="post">
                        @csrf
                        <x-form-group>
                            <x-label for="date_1" required>
                                希望日時1
                            </x-label>
                            <x-input name="date_1" type="date" class="mb-2"
                                value="{{ now()->addDays(1)->format('Y-m-d') }}"></x-input>
                            <x-input name="time_1" type="time" min="10:00" max="23:00" step="1800"
                                value="10:00" list="data-list-1"></x-input>
                            <datalist id="data-list-1">
                                <option value="10:00"></option>
                                <option value="10:30"></option>
                                <option value="11:00"></option>
                                <option value="11:30"></option>
                                <option value="12:00"></option>
                                <option value="12:30"></option>
                                <option value="13:00"></option>
                                <option value="13:30"></option>
                                <option value="14:00"></option>
                                <option value="14:30"></option>
                                <option value="15:00"></option>
                                <option value="15:30"></option>
                                <option value="16:00"></option>
                                <option value="16:30"></option>
                                <option value="17:00"></option>
                                <option value="17:30"></option>
                                <option value="18:00"></option>
                                <option value="18:30"></option>
                                <option value="19:00"></option>
                                <option value="19:30"></option>
                                <option value="20:00"></option>
                                <option value="20:30"></option>
                                <option value="21:00"></option>
                                <option value="21:30"></option>
                                <option value="22:00"></option>
                                <option value="22:30"></option>
                                <option value="23:00"></option>
                            </datalist>
                        </x-form-group>
                        <x-form-group>
                            <x-label for="date_2" required>
                                希望日時2
                            </x-label>
                            <x-input name="date_2" type="date" class="mb-2"
                                value="{{ now()->addDays(1)->format('Y-m-d') }}"></x-input>
                            <x-input name="time_2" type="time" min="10:00" max="23:00" step="1800"
                                value="10:00" list="data-list-2"></x-input>
                            <datalist id="data-list-2">
                                <option value="10:00"></option>
                                <option value="10:30"></option>
                                <option value="11:00"></option>
                                <option value="11:30"></option>
                                <option value="12:00"></option>
                                <option value="12:30"></option>
                                <option value="13:00"></option>
                                <option value="13:30"></option>
                                <option value="14:00"></option>
                                <option value="14:30"></option>
                                <option value="15:00"></option>
                                <option value="15:30"></option>
                                <option value="16:00"></option>
                                <option value="16:30"></option>
                                <option value="17:00"></option>
                                <option value="17:30"></option>
                                <option value="18:00"></option>
                                <option value="18:30"></option>
                                <option value="19:00"></option>
                                <option value="19:30"></option>
                                <option value="20:00"></option>
                                <option value="20:30"></option>
                                <option value="21:00"></option>
                                <option value="21:30"></option>
                                <option value="22:00"></option>
                                <option value="22:30"></option>
                                <option value="23:00"></option>
                            </datalist>
                        </x-form-group>
                        <x-form-group>
                            <x-label for="date_3" required>
                                希望日時3
                            </x-label>
                            <x-input name="date_3" type="date" class="mb-2"
                                value="{{ now()->addDays(1)->format('Y-m-d') }}"></x-input>
                            <x-input name="time_3" type="time" min="10:00" max="23:00" step="1800"
                                value="10:00" list="data-list-3"></x-input>
                            <datalist id="data-list-3">
                                <option value="10:00"></option>
                                <option value="10:30"></option>
                                <option value="11:00"></option>
                                <option value="11:30"></option>
                                <option value="12:00"></option>
                                <option value="12:30"></option>
                                <option value="13:00"></option>
                                <option value="13:30"></option>
                                <option value="14:00"></option>
                                <option value="14:30"></option>
                                <option value="15:00"></option>
                                <option value="15:30"></option>
                                <option value="16:00"></option>
                                <option value="16:30"></option>
                                <option value="17:00"></option>
                                <option value="17:30"></option>
                                <option value="18:00"></option>
                                <option value="18:30"></option>
                                <option value="19:00"></option>
                                <option value="19:30"></option>
                                <option value="20:00"></option>
                                <option value="20:30"></option>
                                <option value="21:00"></option>
                                <option value="21:30"></option>
                                <option value="22:00"></option>
                                <option value="22:30"></option>
                                <option value="23:00"></option>
                            </datalist>
                        </x-form-group>
                        <x-form-group>
                            <x-label for="request">
                                ご要望やお悩みがあればご記入ください
                            </x-label>
                            <x-textarea id="request_value" name="request_value"></x-textarea>
                        </x-form-group>
                        <div>
                            <button
                                class="p-0.5 shadow-lg rounded-md bg-gradient-to-r from-orange-600 to-pink-500 block rounded-md">
                                <div
                                    class="bg-white px-8 py-4 rounded-md text-white border-1 font-bold bg-gradient-to-r from-orange-600 to-pink-500 duration-200 hover:text-orange-500 hover:from-white hover:to-white hover:border-orange-500">
                                    <span>内容を確認する</span>
                                </div>
                            </button>
                        </div>
                    </form>
                @else
                    <x-alert status="info" title="無料体験レッスンのお申し込みには配信された動画のアンケートに回答する必要があります！"
                        class="mb-6"></x-alert>
                    @php
                        $questionnaireUncompleted = $user->questionnaireUnCompleted();
                    @endphp
                    <p class="text-center font-bold mb-4">
                        {{ count($questionnaireUncompleted) }}件のアンケートにご回答ください！
                    </p>
                    <ul>
                        @foreach ($questionnaireUncompleted as $routeName)
                            <li class="mb-4">
                                <a class="block px-4 py-3 border rounded-md hover:bg-indigo-50 duration-20 hover:underline"
                                    href="{{ route($routeName) }}">
                                    動画とアンケートを確認する！
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
