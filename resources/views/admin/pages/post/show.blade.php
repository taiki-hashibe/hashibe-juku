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
        <x-admin.row>
            <x-slot name="label">記事</x-slot>
            <x-slot name="value">
                <x-post-content :post="$item"></x-post-content>
            </x-slot>
        </x-admin.row>
        {{-- @if ($item->thumbnail())
            <x-admin.row>
                <x-slot name="label">サムネイル画像</x-slot>
                <x-slot name="value">
                    <div class="w-24 h-24 rounded-sm overflow-hidden border-2">
                        <img class="w-full h-full object-cover" src="{{ $item->thumbnail() }}" alt="">
                    </div>
                </x-slot>
            </x-admin.row>
        @endif --}}
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
            <x-slot name="label">作成者</x-slot>
            <x-slot name="value">
                @if ($item->admin)
                    <a href="{{ route('admin.admin.show', [
                        'admin' => $item->admin->id,
                    ]) }}"
                        class="underline">{{ $item->admin->name }}</a>
                @else
                    <span>削除された管理者</span>
                @endif
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">アクセス数</x-slot>
            <x-slot name="value">
                {{ $item->accessLogs->count() }}
            </x-slot>
        </x-admin.row>
        @if ($item->exercises->count() !== 0)
            <x-admin.row>
                <x-slot name="label">演習</x-slot>
                <x-slot name="value">
                    <ul>
                        @foreach ($item->exercises as $exercise)
                            <li class="mb-2">
                                <p class="font-bold mb-1">{{ $exercise->question }}</p>
                                <ul class="ps-5">
                                    @foreach ($exercise->choices as $choice)
                                        <li>
                                            <p class="flex items-center relative">
                                                @if ($choice->is_correct)
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                        class="w-4 h-4 text-green-500 absolute -left-4">
                                                        <path fill-rule="evenodd"
                                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                                {{ $choice->text }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </x-slot>
            </x-admin.row>
        @endif
        <div class="flex justify-end mt-8 md:px-4">
            @if ($item->isEditable())
                <div>
                    @if ($item->status === 'publish')
                        <x-admin.anchor variant="orange" class="me-2" target="_blank"
                            href="{{ $item->category
                                ? route('content.post', [
                                    'post' => $item->slug,
                                    'category' => $item->category->slug,
                                ])
                                : route('post.post', [
                                    'post' => $item->slug,
                                ]) }}">ページを確認する</x-admin.anchor>
                    @endif
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
