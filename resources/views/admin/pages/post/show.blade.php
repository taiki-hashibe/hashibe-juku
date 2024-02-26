<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '投稿',
            'href' => route('admin.post.index'),
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
        @if ($item->video)
            <x-admin.row>
                <x-slot name="label">動画</x-slot>
                <x-slot name="value">
                    <video id="video-js" class="video video-js" playsinline controls>
                        <source src="{{ $item->video }}">
                    </video>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->video_free)
            <x-admin.row>
                <x-slot name="label">動画(フリー)</x-slot>
                <x-slot name="value">
                    <video id="video-js" class="video video-js" playsinline controls>
                        <source src="{{ $item->video_free }}">
                    </video>
                </x-slot>
            </x-admin.row>
        @endif
        <x-admin.row>
            <x-slot name="label">記事</x-slot>
            <x-slot name="value">
                <x-post-content :post="$item"></x-post-content>
            </x-slot>
        </x-admin.row>
        @if ($item->content_free)
            <x-admin.row>
                <x-slot name="label">記事(フリー)</x-slot>
                <x-slot name="value">
                    <x-post-content :post="$item" column="content_free"></x-post-content>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->thumbnail())
            <x-admin.row>
                <x-slot name="label">サムネイル画像</x-slot>
                <x-slot name="value">
                    <div class="w-24 h-24 rounded-sm overflow-hidden border-2">
                        <img class="w-full h-full object-cover" src="{{ $item->thumbnail() }}" alt="">
                    </div>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->description)
            <x-admin.row>
                <x-slot name="label">詳細</x-slot>
                <x-slot name="value">
                    <p class="whitespace-pre-line">{{ $item->description }}</p>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->category)
            <x-admin.row>
                <x-slot name="label">カテゴリー</x-slot>
                <x-slot name="value">
                    <a href="{{ route('admin.category.show', [
                        'category' => $item->category->id,
                    ]) }}"
                        class="underline">{{ $item->category->name }}</a>
                </x-slot>
            </x-admin.row>
        @endif
        <x-admin.row>
            <x-slot name="label">公開ステータス</x-slot>
            <x-slot name="value"><x-admin.content-status-badge :status="$item->status" /></x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">公開範囲</x-slot>
            <x-slot name="value"><x-admin.publish-level-enum :level="$item->publish_level"></x-admin.publish-level-enum></x-slot>
        </x-admin.row>
        @if ($item->getRevision->count() !== 0)
            <x-admin.row>
                <x-slot name="label">リビジョン</x-slot>
                <x-slot name="value">
                    <ul class="mb-3">
                        @foreach ($item->getRevision as $revision)
                            <li class="mb-2"><a
                                    href="{{ route('admin.post.show', [
                                        'post' => $revision->id,
                                    ]) }}"
                                    class="hover:underline flex">
                                    <span>{{ $revision->created_at->format('Y年m月d日H時i分s秒') }}</span>
                                    <span class="mx-1">/</span>
                                    <span>{{ $revision->admin->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </x-slot>
            </x-admin.row>
        @endif
        @if ($item->original)
            <x-admin.row>
                <x-slot name="label">リビジョン元投稿</x-slot>
                <x-slot name="value">
                    <a href="{{ route('admin.post.show', [
                        'post' => $item->original->id,
                    ]) }}"
                        class="underline">{{ $item->original->title }}</a>
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
            @if ($item->isEditable())
                <div>
                    {{-- @if ($item->status === 'publish')
                        <x-admin.anchor variant="orange" class="me-2" target="_blank"
                            href="{{ $item->category
                                ? route('content.post', [
                                    'post' => $item->slug,
                                    'category' => $item->category->slug,
                                ])
                                : route('post.post', [
                                    'post' => $item->slug,
                                ]) }}">ページを確認する</x-admin.anchor>
                    @endif --}}
                    <x-admin.anchor variant="primary" class="me-2"
                        href="{{ route('admin.post.edit', [
                            'post' => $item->id,
                        ]) }}">編集</x-admin.anchor>
                    <div x-data="{ deleteOpen: false }" class="inline-block">
                        <x-admin.button @click="deleteOpen = true" variant="danger">削除</x-admin.button>
                        <x-modal key="deleteOpen">
                            <p class="mb-4">
                                本当に<b>{{ $item->name }}</b>を削除しますか？
                            </p>
                            <form
                                action="{{ route('admin.post.destroy', [
                                    'post' => $item->id,
                                ]) }}"
                                method="POST">
                                @method('DELETE')
                                @csrf
                                <x-admin.button variant="outline-danger" class="w-full">確定</x-admin.button>
                            </form>
                        </x-modal>
                    </div>
                </div>
            @elseif($item->status === 'revision')
                <div>
                    <div x-data="{ revert: false }" class="inline-block">
                        <x-admin.button @click="revert = true" variant="success">このリビジョンに戻す</x-admin.button>
                        <x-modal key="revert">
                            <p class="mb-4">
                                本当に<b>{{ $item->title }}</b>の変更を戻しますか？
                            </p>
                            <form
                                action="{{ route('admin.post.revert', [
                                    'post' => $item->id,
                                ]) }}"
                                method="POST">
                                @csrf
                                <x-admin.button variant="outline-danger" class="w-full">確定</x-admin.button>
                            </form>
                        </x-modal>
                    </div>
                </div>
            @endif
        </div>
    </x-admin.row-container>
</x-admin.auth-layout>
