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
                        ユーザーID</x-admin.th>
                    <x-admin.th>ステータス</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td>
                            {{ $item->user_id }}</x-admin.td>
                        <x-admin.td>
                            <x-admin.publish-level-enum :level="$item->status"></x-admin.publish-level-enum>
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
