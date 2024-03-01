<script>
    function copyInflowRouteUrl(id) {
        const url = document.getElementById('ir-url-' + id);
        url.select();
        document.execCommand('copy');
    }
</script>
<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '流入経路',
        ],
    ]">
        <div>
            <x-admin.anchor variant="primary" class="text-sm"
                href="{{ route('admin.inflow-route.create') }}">新規作成</x-admin.anchor>
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
                        経路</x-admin.th>
                    <x-admin.th>
                        流入元</x-admin.th>
                    <x-admin.th>
                        リダイレクト先
                    </x-admin.th>
                    <x-admin.th>
                        URL</x-admin.th>
                    <x-admin.th>
                        流入数</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td class="max-w-36 truncate">
                            {{ $item->route }}</x-admin.td>
                        <x-admin.td class="max-w-36 truncate">
                            {{ $item->source }}</x-admin.td>
                        <x-admin.td class="max-w-36 truncate">
                            {{ $item->redirect_url }}</x-admin.td>
                        <x-admin.td>
                            <button type="button" onclick="copyInflowRouteUrl({{ $item->id }})"
                                class="max-w-36 overflow-hidden flex justify-between items-center border px-3 py-2 rounded-md">
                                <input id="ir-url-{{ $item->id }}" type="text" class="me-2 focus:outline-none"
                                    value="{{ $item->url() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                </svg>

                            </button>
                        </x-admin.td>
                        <x-admin.td class="text-right">
                            {{ $item->logs->count() }}
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.anchor
                                href="{{ route('admin.inflow-route.show', [
                                    'inflow_route' => $item->id,
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
