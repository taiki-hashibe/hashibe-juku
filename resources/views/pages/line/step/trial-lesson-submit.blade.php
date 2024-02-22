<x-guest-layout class="bg-white" :unlink="true" :noindex="true">
    <div class="mb-8">
        <div class="mb-24">
            <h2 class="text-xl font-black text-center mb-8">お申込みが完了しました！</h2>
            <p class="text-center leading-8">
                {{ $user->name }}さん、無料体験レッスンのお申込みありがとうございます！<br>
                内容を確認次第、公式LINEよりご連絡差し上げます。<br>
                <br>
                では引き続きよろしくお願いいたします！
            </p>
        </div>
    </div>
</x-guest-layout>
