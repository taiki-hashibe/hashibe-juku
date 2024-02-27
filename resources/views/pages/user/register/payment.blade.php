<x-layout class="bg-white">
    <x-breadcrumb :post="null" :category="null" :item="[
        'label' => '入会案内',
        'url' => route('user.register.guidance'),
    ]" />
    <div class="mb-8">
        <x-payment-form action="{{ route('user.register.payment') }}" :intent="$intent" :price="$price"
            class="mb-4" />
    </div>
</x-layout>
