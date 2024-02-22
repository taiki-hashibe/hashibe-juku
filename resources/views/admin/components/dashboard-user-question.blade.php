<div>
    <p class="mb-4">未回答の質問 : @if ($myUserQuestions->count() === 0)
            <span class="px-2 ms-3 inline-flex rounded-full font-semibold bg-green-100 text-green-800">
                0件
            </span>
        @else
            <span class="px-2 inline-flex rounded-full font-semibold bg-alert-100 text-alert-800">
                {{ $myUserQuestions->count() }}件
            </span>
        @endif
    </p>
    <p class="mb-4">未回答の質問(全件) : @if ($userQuestions->count() === 0)
            <span class="px-2 ms-3 inline-flex rounded-full font-semibold bg-green-100 text-green-800">
                0件
            </span>
        @else
            <span class="px-2 inline-flex rounded-full font-semibold bg-alert-100 text-alert-800">
                {{ $userQuestions->count() }}件
            </span>
        @endif
    </p>
</div>
