<x-admin.auth-layout>
    @php
        $breadcrumbs = [
            [
                'label' => '投稿カテゴリー',
                'href' => route('admin.category.index'),
            ],
        ];
        if ($item) {
            $breadcrumbs[] = [
                'label' => $item->name,
            ];
        }
        $breadcrumbs[] = [
            'label' => '並べ替え',
        ];
    @endphp
    <x-admin.breadcrumb :pages="$breadcrumbs"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    @php
        $param = [];
        if ($item) {
            $param['category'] = $item->id;
        }
    @endphp
    <x-admin.edit-form action="{{ route('admin.category.sort', $param) }}" method="POST">
        @csrf
        <ul id="category-list" class="md:p-4 md:pl-8">
            @foreach ($collection as $sortItem)
                <li class="flex flex-col md:flex-row border rounded-md duration-100 bg-white hover:bg-slate-100 mb-2"
                    style="cursor: grab">
                    <input type="hidden" name="sort_item[][id]" value="{{ $sortItem->id }}">
                    <div class="w-full mb-4 md:mb-0 md:px-4 py-2 md:pl-8 text-slate-700 dark:text-slate-400">
                        {{ $sortItem->name }}
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.button variant="primary">保存</x-admin.button>
            </div>
        </div>
    </x-admin.edit-form>
</x-admin.auth-layout>
