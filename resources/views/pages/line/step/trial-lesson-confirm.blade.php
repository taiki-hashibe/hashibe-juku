<x-guest-layout class="bg-white" :unlink="true" :noindex="true">
    <div class="mb-8">
        <div class="mb-24">
            <div class="w-full flex flex-col">
                <h3 class="text-xl font-bold text-center mb-8">無料体験レッスンお申込みフォーム</h3>
                <form action="{{ route('line.step.trial-lesson-submit') }}" method="post">
                    @csrf
                    <x-form-group>
                        <x-label>
                            希望日時1
                        </x-label>
                        <x-form-confirm>
                            {{ $date_1 }} {{ $time_1 }}
                        </x-form-confirm>
                        <input type="hidden" name="date_1" value="{{ $date_1 }}">
                        <input type="hidden" name="time_1" value="{{ $time_1 }}">
                    </x-form-group>
                    <x-form-group>
                        <x-label>
                            希望日時2
                        </x-label>
                        <x-form-confirm>
                            {{ $date_2 }} {{ $time_2 }}
                        </x-form-confirm>
                        <input type="hidden" name="date_2" value="{{ $date_2 }}">
                        <input type="hidden" name="time_2" value="{{ $time_2 }}">
                    </x-form-group>
                    <x-form-group>
                        <x-label>
                            希望日時3
                        </x-label>
                        <x-form-confirm>
                            {{ $date_3 }} {{ $time_3 }}
                        </x-form-confirm>
                        <input type="hidden" name="date_3" value="{{ $date_3 }}">
                        <input type="hidden" name="time_3" value="{{ $time_3 }}">
                    </x-form-group>
                    <x-form-group>
                        <x-label>
                            ご要望、お悩みなど
                        </x-label>
                        <x-form-confirm>
                            {{ $request_value }}
                        </x-form-confirm>
                        <textarea name="request_value" class="hidden">{{ $request_value }}</textarea>
                    </x-form-group>
                    <div>
                        <button
                            class="p-0.5 shadow-lg rounded-md bg-gradient-to-r from-orange-600 to-pink-500 block rounded-md">
                            <div
                                class="bg-white px-8 py-4 rounded-md text-white border-1 font-bold bg-gradient-to-r from-orange-600 to-pink-500 duration-200 hover:text-orange-500 hover:from-white hover:to-white hover:border-orange-500">
                                <span>確定する！</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
