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
    <x-admin.table-container>
        <x-admin.table>
            <x-admin.thead>
                <x-admin.tr>
                    <x-admin.th>
                        サムネイル</x-admin.th>
                    <x-admin.th>
                        タイトル</x-admin.th>
                    <x-admin.th>
                        カテゴリー</x-admin.th>
                    <x-admin.th>
                        アクセス数
                    </x-admin.th>
                    <x-admin.th>
                        公開ステータス</x-admin.th>
                    <x-admin.th>
                        一般公開日</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td>
                            <div class="aspect-video w-12 overflow-hidden">
                                <img class="w-full h-full object-cover" src="{{ $item->thumbnail() }}" alt="">
                            </div>
                        </x-admin.td>
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
                        <x-admin.td>
                            <x-admin.content-status-badge :status="$item->status"></x-admin.content-status-badge>
                        </x-admin.td>
                        <x-admin.td>
                            @if ($item->public_release_at)
                                {{ $item->public_release_at->format('Y年m月d日 H時i分') }}
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
