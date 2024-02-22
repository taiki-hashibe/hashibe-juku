<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ユーザー',
        ],
    ]">
        <div>
            <x-admin.anchor variant="primary" class="text-sm me-2"
                href="{{ route('admin.user.create') }}">新規作成</x-admin.anchor>
            <x-admin.anchor variant="secondary" class="text-sm"
                href="{{ route('admin.user.index', [
                    'trashed' => 1,
                ]) }}">削除済み</x-admin.anchor>
        </div>
    </x-admin.breadcrumb>
    <div class="px-8 mb-4" x-data="{ filterOpen: false }">
        <x-admin.button variant="info" @click="filterOpen = true">絞り込む</x-admin.button>
        <x-modal key="filterOpen">
            <form action="{{ route('admin.user.index') }}" method="get">
                <div class="mb-3">
                    <label for="site">
                        <span class="block px-3">閲覧可サイト</span>
                    </label>
                    <select id="site"
                        class="block w-full rounded-md border duration-100 focus:outline-0 focus:border-purple-500 px-3 py-2"
                        name="filter[site]" id="">
                        @foreach ($filters['site'] as $filterItem)
                            <option value="{{ $filterItem['value'] }}"
                                @if ($filterItem['value']) @if (request()->filter && request()->filter['site'])
                                        @if ($filterItem['value'] === request()->filter['site'])
                                            selected @endif
                            @elseif($filterItem['value'] === config('app.site')) selected @endif
                        @endif
                        >
                        {{ $filterItem['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="company">
                        <span class="block px-3">契約社名</span>
                    </label>
                    <select id="company"
                        class="block w-full rounded-md border duration-100 focus:outline-0 focus:border-purple-500 px-3 py-2"
                        name="filter[company]" id="">
                        @foreach ($filters['company'] as $filterItem)
                            <option value="{{ $filterItem['value'] }}"
                                @if ($filterItem['value']) @if (request()->filter && $filterItem['value'] == request()->filter['company'])
                                selected @endif
                                @endif>
                                {{ $filterItem['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <x-admin.button variant="info" class="w-full">絞り込む</x-admin.button>
            </form>
        </x-modal>
    </div>
    @if (session('success'))
        <x-alert status="success" title="{{ session('success') }}"></x-alert>
    @endif
    <x-admin.table-container>
        <x-admin.table>
            <x-admin.thead>
                <x-admin.tr>
                    <x-admin.th>
                        ユーザーID</x-admin.th>
                    <x-admin.th>
                        契約社名</x-admin.th>
                    <x-admin.th>ステータス</x-admin.th>
                    <x-admin.th>閲覧可</x-admin.th>
                    <x-admin.th></x-admin.th>
                </x-admin.tr>
            </x-admin.thead>
            <x-admin.tbody class="bg-white dark:bg-slate-800">
                @foreach ($items->paginate(24) as $item)
                    <x-admin.tr>
                        <x-admin.td>
                            {{ $item->user_id }}</x-admin.td>
                        <x-admin.td>
                            @if ($item->company()->withTrashed()->first())
                                <a href="{{ route('admin.company.show', [
                                    'company' => $item->company()->withTrashed()->first()->id,
                                ]) }}"
                                    class="underline">{{ $item->company()->withTrashed()->first()->name }}</a>
                            @endif
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.publish-level-enum :level="$item->status"></x-admin.publish-level-enum>
                        </x-admin.td>
                        <x-admin.td>
                            <x-admin.site-enum :site="$item->site"></x-admin.site-enum>
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
