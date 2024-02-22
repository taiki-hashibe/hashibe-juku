<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '投稿',
        ],
    ]">
        <div>
            <x-admin.anchor variant="primary" class="text-sm" href="{{ route('admin.post.create') }}">新規作成</x-admin.anchor>
            <x-admin.anchor variant="success" class="text-sm me-2"
                href="{{ route('admin.post.sort') }}">カテゴリーの無い投稿の並べ替え</x-admin.anchor>
        </div>
    </x-admin.breadcrumb>
    @if (session('success'))
        <x-alert status="success" title="{{ session('success') }}"></x-alert>
    @endif
    <div class="px-8 mb-4">
        <form class="flex" action="{{ route('admin.post.index') }}" method="get">
            <button class="flex items-center me-2">
                <input type="checkbox" @if (!request()->all_post) checked @endif>
                <span>自分の投稿のみ</span>
                <input type="checkbox" class="hidden" name="all_post" @if (!request()->all_post) checked @endif>
            </button>
        </form>
    </div>
    <x-admin.table-container>
        <x-admin.table>
            <x-admin.thead>
                <x-admin.tr>
                    {{-- <x-admin.th>
                        サムネイル</x-admin.th> --}}
                    <x-admin.th>
                        タイトル</x-admin.th>
                    <x-admin.th>
                        カテゴリー</x-admin.th>
                    <x-admin.th>
                        アクセス数
                    </x-admin.th>
                    <x-admin.th>
                        ブックマーク</x-admin.th>
                    <x-admin.th>
                        完了</x-admin.th>
                    <x-admin.th>
                        公開ステータス</x-admin.th>
                    <x-admin.th>
                        公開範囲</x-admin.th>
                    <x-admin.th>
                        作成者
                    </x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        {{-- <x-admin.td>
                            <div class="aspect-square w-12 h-12 overflow-hidden">
                                <img class="w-full h-full object-cover" src="{{ $item->thumbnail() }}" alt="">
                            </div>
                        </x-admin.td> --}}
                        <x-admin.td>
                            <p class="max-w-36 truncate">{{ $item->title }}</p>
                        </x-admin.td>
                        <x-admin.td>
                            @if ($item->category)
                                <a href="{{ route('admin.category.show', [
                                    'category' => $item->category->id,
                                ]) }}"
                                    class="max-w-36 truncate block underline">{{ $item->category->name }}</a>
                            @endif
                        </x-admin.td>
                        <x-admin.td class="text-right">
                            {{ $item->accessLogs->count() }}
                        </x-admin.td>
                        <x-admin.td class="text-right">
                            {{ $item->bookmarks->count() }}
                        </x-admin.td>
                        <x-admin.td class="text-right">
                            {{ $item->completes->count() }}
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.content-status-badge :status="$item->status"></x-admin.content-status-badge>
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.publish-level-enum :level="$item->publish_level"></x-admin.publish-level-enum>
                        </x-admin.td>
                        <x-admin.td>
                            @if ($item->admin)
                                <a href="{{ route('admin.admin.show', [
                                    'admin' => $item->admin->id,
                                ]) }}"
                                    class="max-w-24 truncate block underline">{{ $item->admin->name }}</a>
                            @else
                                <span>削除された管理者</span>
                            @endif
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.anchor
                                href="{{ route('admin.post.show', [
                                    'post' => $item->id,
                                ]) }}"
                                variant="primary">詳細</x-admin.anchor>
                        </x-admin.td>
                    </x-admin.tr>
                @endforeach
            </x-admin.tbody>
        </x-admin.table>
    </x-admin.table-container>
    {{ $items->paginate(24)->withQueryString()->links() }}
</x-admin.auth-layout>