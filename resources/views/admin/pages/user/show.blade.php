<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ユーザー',
            'href' => route('admin.user.index'),
        ],
        [
            'label' => $item->user_id ?? $item->name,
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.row-container>
        <div class="mb-4 mt-8 px-8 flex items-center">
            <h2 class="text-lg text-slate-600 font-bold me-6">基本情報</h2>
            <hr class="grow">
        </div>
        <x-admin.row>
            <x-slot name="label">ID</x-slot>
            <x-slot name="value">{{ $item->id }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">名前</x-slot>
            <x-slot name="value">{{ $item->name }}</x-slot>
        </x-admin.row>
    </x-admin.row-container>
</x-admin.auth-layout>
