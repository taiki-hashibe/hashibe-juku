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
            'href' => route('admin.inflow-route.index'),
        ],
        [
            'label' => $item->name,
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.row-container>
        <x-admin.row>
            <x-slot name="label">URL</x-slot>
            <x-slot name="value">
                <button type="button" onclick="copyInflowRouteUrl({{ $item->id }})"
                    class="w-full flex justify-between items-center border px-3 py-2 rounded-md">
                    <input id="ir-url-{{ $item->id }}" type="text" class="me-2 block focus:outline-none"
                        value="{{ $item->url() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                    </svg>

                </button>
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">テスト用URL</x-slot>
            <x-slot name="value">
                <a href="{{ $item->url() . '?test=1' }}" target="_blank" class="underline"
                    rel="noopener noreferrer">{{ $item->url() . '?test=1' }}</a>
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">経路</x-slot>
            <x-slot name="value">{{ $item->route }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">流入元</x-slot>
            <x-slot name="value">{{ $item->source }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">リダイレクト先</x-slot>
            <x-slot name="value">
                <a target="_blank" href="{{ $item->redirect_url }}">{{ $item->redirect_url }}</a>
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">流入数</x-slot>
            <x-slot name="value">
                <p>{{ $item->logs->count() }}</p>
                <div x-data="{ show: false }">
                    <a class="text-sm block" @click="show = !show">詳細</a>
                    <div x-show="show" class="mt-2">
                        <ul>
                            @foreach ($item->logs as $log)
                                <li>{{ $log->created_at->format('Y年m月d日 H時i分s秒') }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </x-slot>
        </x-admin.row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.anchor variant="primary" class="me-2"
                    href="{{ route('admin.inflow-route.edit', [
                        'inflow_route' => $item->id,
                    ]) }}">編集</x-admin.anchor>
                <div x-data="{ deleteOpen: false }" class="inline-block">
                    <x-admin.button @click="deleteOpen = true" variant="danger">削除</x-admin.button>
                    <x-modal key="deleteOpen">
                        <p class="mb-4">
                            本当に<b>{{ $item->name }}</b>を削除しますか？
                        </p>
                        <form
                            action="{{ route('admin.inflow-route.destroy', [
                                'inflow_route' => $item->id,
                            ]) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <x-admin.button variant="outline-danger" class="w-full">確定</x-admin.button>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </x-admin.row-container>
</x-admin.auth-layout>
