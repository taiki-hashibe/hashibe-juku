<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'カリキュラム',
        ],
    ]">
        <div>
            <x-admin.anchor variant="primary" class="text-sm"
                href="{{ route('admin.curriculum.create') }}">新規作成</x-admin.anchor>
            <x-admin.anchor variant="success" class="text-sm me-2"
                href="{{ route('admin.curriculum.sort') }}">並べ替え</x-admin.anchor>
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
                        タイトル</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td class="max-w-36 truncate">
                            {{ $item->name }}</x-admin.td>
                        <x-admin.td>
                            <x-admin.anchor
                                href="{{ route('admin.curriculum.show', [
                                    'curriculum' => $item->id,
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
