<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ページの管理',
            'href' => route('admin.page.index'),
        ],
        [
            'label' => $item->title,
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.row-container>
        <x-admin.row>
            <x-slot name="label">タイトル</x-slot>
            <x-slot name="value">{{ $item->title }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">本文</x-slot>
            <x-slot name="value">
                <x-page-content :content="$item->content" />
            </x-slot>
        </x-admin.row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.anchor variant="primary" class="me-2"
                    href="{{ route('admin.page.edit', [
                        'page' => $item->id,
                    ]) }}">編集</x-admin.anchor>
                <div x-data="{ deleteOpen: false }" class="inline-block">
                    <x-admin.button @click="deleteOpen = true" variant="danger">削除</x-admin.button>
                    <x-modal key="deleteOpen">
                        <p class="mb-4">
                            本当に<b>{{ $item->name }}</b>を削除しますか？
                        </p>
                        <form
                            action="{{ route('admin.page.destroy', [
                                'page' => $item->id,
                            ]) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <x-admin.button variant="outline-danger" class="w-full">確定</x-admin.button>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </x-admin.row-container>
</x-admin.auth-layout>
