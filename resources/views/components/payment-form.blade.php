<div {{ $attributes->merge([
    'class' => '',
]) }}>
    <x-gradation-container>
        <form id="form" action="{{ $action }}" method="post" class="mb-8">
            @csrf
            {{-- @if (config('app.env') !== 'production')
                <p class="text-slate-400"><span class="me-2">テストカード番号</span><span
                        class="text-sm">※この項目は本番環境では表示されません</span>
                </p>
                <div x-data="{ open: false }" class="relative mb-3">
                    <button type="button" onclick="copyTestCardNumber()"
                        class="w-full flex justify-between items-center border px-3 py-2 rounded-md">
                        <input id="test-card-number" type="text" class="me-2 focus:outline-none"
                            value="4000003920000003">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                        </svg>

                    </button>
                    <div x-cloak @click.outside="open = false" class="absolute bottom-full"></div>
                </div>
                <script>
                    function copyTestCardNumber() {
                        // クリップボードにテストカード番号をコピーする
                        const testCardNumber = document.getElementById('test-card-number');
                        testCardNumber.select();
                        document.execCommand('copy');

                        Alpine.store('open', true);
                    }
                </script>
            @endif --}}
            <div class="mb-6">
                <label class="font-semibold ms-1 mb-1">ご利用料金</label>
                <p class="">月額
                    {{ $price->unit_amount }}円</p>
            </div>
            <div>
                <div class="mb-3">
                    <label for="card-holder-name" class="font-semibold ms-1 mb-1">カード名義</label>
                    <input id="card-holder-name" name="card_holder_name" type="text"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none">
                </div>
                <div class="mb-3">
                    <label class="font-semibold ms-1 mb-1">カード情報</label>
                    <div id="card-element" class="block bg-white w-full px-3 py-3 border border-slate-300 rounded-md">
                    </div>
                    <p id="card-error" class="text-sm text-rose-600"></p>
                </div>
                {{ $slot }}
            </div>
        </form>
        <x-gradation-button id="card-button" data-secret="{{ $intent->client_secret }}"
            class="w-full">確定</x-gradation-button>
    </x-gradation-container>
    <script src="https://js.stripe.com/v3"></script>
    <script>
        /* 基本設定*/
        const stripe_public_key = "{{ config('stripe.key') }}"
        const stripe = Stripe(stripe_public_key);
        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            cardButton.disabled = true;
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                console.error(error);
                document.querySelector("#card-element").classList.remove("border-slate-300");
                document.querySelector("#card-element").classList.add("border-rose-600");
                document.querySelector("#card-error").innerText = "このカードは利用できません"
                cardButton.disabled = false;
            } else {
                const form = document.querySelector("#form");
                const paymentMethod = setupIntent.payment_method;
                const paymentMethodElm = document.createElement("input");
                paymentMethodElm.setAttribute("type", "hidden");
                paymentMethodElm.setAttribute("name", "payment_method");
                paymentMethodElm.setAttribute("value", paymentMethod);

                if (form) {
                    form.appendChild(paymentMethodElm);
                    form.submit();
                } else {
                    console.error('#form not found');
                    cardButton.disabled = false;
                }
            }
        });
    </script>

</div>
