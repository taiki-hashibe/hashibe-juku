<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'カリキュラム',
            'href' => route('admin.curriculum.index'),
        ],
        [
            'label' => $item->name,
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.row-container>
        <x-admin.row>
            <x-slot name="label">タイトル</x-slot>
            <x-slot name="value">{{ $item->name }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">詳細</x-slot>
            <x-slot name="value">
                <p class="whitespace-pre-line">{{ $item->description }}</p>
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">投稿</x-slot>
            <x-slot name="value">
                <ul class="mb-6">
                    @foreach ($item->posts as $post)
                        <li class="mb-2">
                            <a class="hover:underline"
                                href="{{ route('admin.post.show', [
                                    'post' => $post->id,
                                ]) }}">{{ $post->title }}</a>
                        </li>
                    @endforeach
                </ul>
                <x-admin.anchor variant="success" class="text-sm me-2 mb-2 inline-block"
                    href="{{ route('admin.curriculum.sort-item', [
                        'curriculum' => $item->id,
                    ]) }}">並べ替え</x-admin.anchor>
            </x-slot>
        </x-admin.row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.anchor variant="primary" class="me-2"
                    href="{{ route('admin.curriculum.edit', [
                        'curriculum' => $item->id,
                    ]) }}">編集</x-admin.anchor>
                <div x-data="{ deleteOpen: false }" class="inline-block">
                    <x-admin.button @click="deleteOpen = true" variant="danger">削除</x-admin.button>
                    <x-modal key="deleteOpen">
                        <p class="mb-4">
                            本当に<b>{{ $item->name }}</b>を削除しますか？
                        </p>
                        <form
                            action="{{ route('admin.curriculum.destroy', [
                                'curriculum' => $item->id,
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
