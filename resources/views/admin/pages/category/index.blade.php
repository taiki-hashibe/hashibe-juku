<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '投稿カテゴリー',
        ],
    ]">
        <div>
            <x-admin.anchor variant="primary" class="text-sm"
                href="{{ route('admin.category.create') }}">新規作成</x-admin.anchor>
            <x-admin.anchor variant="success" class="text-sm me-2"
                href="{{ route('admin.category.sort') }}">並べ替え</x-admin.anchor>
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
                        名前</x-admin.th>
                    <x-admin.th>
                        親カテゴリー</x-admin.th>
                    <x-admin.th>
                        投稿数</x-admin.th>
                    <x-admin.th>
                        アクセス数</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td>
                            <div class="aspect-square w-12 h-12 overflow-hidden">
                                <img class="w-full h-full object-cover" src="{{ $item->thumbnail() }}" alt="">
                            </div>
                        </x-admin.td>
                        <x-admin.td class="max-w-36 truncate">
                            {{ $item->name }}</x-admin.td>
                        <x-admin.td>
                            @if ($item->parent)
                                <a href="{{ route('admin.category.show', [
                                    'category' => $item->parent->id,
                                ]) }}"
                                    class="underline max-w-36 block truncate">{{ $item->parent->name }}</a>
                            @endif
                        </x-admin.td>
                        <x-admin.td class="text-right">
                            {{ $item->posts()->publish()->count() }}
                        </x-admin.td>
                        <x-admin.td class="text-right">
                            {{ $item->accessLogs->count() }}
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.anchor
                                href="{{ route('admin.category.show', [
                                    'category' => $item->id,
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
