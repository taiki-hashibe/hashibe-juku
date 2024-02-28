<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ユーザー',
        ],
    ]">
    </x-admin.breadcrumb>
    @if (session('success'))
        <x-alert status="success" title="{{ session('success') }}"></x-alert>
    @endif
    <x-admin.table-container>
        <x-admin.table>
            <x-admin.thead>
                <x-admin.tr>
                    <x-admin.th>
                        ID</x-admin.th>
                    <x-admin.th>名前</x-admin.th>
                    <x-admin.th>LINEのステータス</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td>
                            {{ $item->id }}</x-admin.td>
                        <x-admin.td>
                            {{ $item->name }}
                        </x-admin.td>
                        <x-admin.td>
                            @if ($item->line_status === 'unfollow')
                                <span class="px-2 inline-flex text-xs font-semibold bg-red-100 text-red-800">
                                    ブロック
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs font-semibold bg-green-100 text-green-800">
                                    有効
                                </span>
                            @endif
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.anchor
                                href="{{ route('admin.user.show', [
                                    'user' => $item->id,
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
