<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '投稿カテゴリー',
            'href' => route('admin.category.index'),
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
            <x-slot name="label">名前</x-slot>
            <x-slot name="value">{{ $item->name }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">詳細</x-slot>
            <x-slot name="value">
                <p class="whitespace-pre-line">{{ $item->description }}</p>
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">サムネイル画像</x-slot>
            <x-slot name="value">
                @if ($item->thumbnail())
                    <div class="w-24 h-24 rounded-sm overflow-hidden border-2">
                        <img class="w-full h-full object-cover" src="{{ $item->thumbnail() }}" alt="">
                    </div>
                @endif
            </x-slot>
        </x-admin.row>
        @if ($item->parent)
            <x-admin.row>
                <x-slot name="label">親カテゴリー</x-slot>
                <x-slot name="value">
                    <a href="{{ route('admin.category.show', [
                        'category' => $item->parent->id,
                    ]) }}"
                        class="underline">{{ $item->parent->name }}</a>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->children->count() > 0)
            <x-admin.row>
                <x-slot name="label">子カテゴリー</x-slot>
                <x-slot name="value">
                    <ul class="mb-3">
                        @foreach ($item->children()->sortOrder()->get() as $children)
                            <li><a href="{{ route('admin.category.show', [
                                'category' => $children->id,
                            ]) }}"
                                    class="underline">{{ $children->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <x-admin.anchor variant="success" class="text-sm me-2 mb-2 inline-block"
                        href="{{ route('admin.category.sort', [
                            'category' => $item->id,
                        ]) }}">並べ替え</x-admin.anchor>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->posts()->editable()->count() > 0)
            <x-admin.row>
                <x-slot name="label">投稿</x-slot>
                <x-slot name="value">
                    <ul class="mb-3">
                        @foreach ($item->posts()->editable()->sortOrder()->get() as $post)
                            <li class="mb-2"><a
                                    href="{{ route('admin.post.show', [
                                        'post' => $post->id,
                                    ]) }}"
                                    class="underline">
                                    <span>{{ $post->title }} </span>
                                    <x-admin.content-status-badge :status="$post->status"></x-admin.content-status-badge>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <x-admin.anchor variant="success" class="text-sm me-2 mb-2 inline-block"
                        href="{{ route('admin.post.sort', [
                            'category' => $item->id,
                        ]) }}">並べ替え</x-admin.anchor>
                </x-slot>
            </x-admin.row>

        @endif
        <x-admin.row>
            <x-slot name="label">アクセス数</x-slot>
            <x-slot name="value">
                {{ $item->accessLogs->count() }}
            </x-slot>
        </x-admin.row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.anchor variant="primary" class="me-2"
                    href="{{ route('admin.category.edit', [
                        'category' => $item->id,
                    ]) }}">編集</x-admin.anchor>
                <div x-data="{ deleteOpen: false }" class="inline-block">
                    <x-admin.button @click="deleteOpen = true" variant="danger">削除</x-admin.button>
                    <x-modal key="deleteOpen">
                        <p class="mb-4">
                            本当に<b>{{ $item->name }}</b>を削除しますか？
                        </p>
                        <form
                            action="{{ route('admin.category.destroy', [
                                'category' => $item->id,
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
