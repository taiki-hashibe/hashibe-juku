<x-admin.auth-layout>
    @php
        $breadcrumbs = [
            [
                'label' => '投稿',
                'href' => route('admin.post.index'),
            ],
        ];
        if ($category) {
            $breadcrumbs[] = [
                'label' => $category->name,
                'href' => route('admin.category.show', ['category' => $category->id]),
            ];
        }
        $breadcrumbs[] = [
            'label' => '投稿の並び替え',
        ];
    @endphp
    <x-admin.breadcrumb :pages="$breadcrumbs"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    @php
        $param = [];
        if ($category) {
            $param['category'] = $category->id;
        }
    @endphp
    <x-admin.edit-form action="{{ route('admin.post.sort', $param) }}" method="POST">
        @csrf
        <ul id="post-list" class="md:p-4 md:pl-8">
            @foreach ($collection as $sortItem)
                <li class="flex flex-col md:flex-row border rounded-md duration-100 bg-white hover:bg-slate-100 mb-2"
                    style="cursor: grab">
                    <input type="hidden" name="sort_item[][id]" value="{{ $sortItem->id }}">
                    <div class="w-full mb-4 md:mb-0 md:px-4 py-2 md:pl-8 text-slate-700 dark:text-slate-400">
                        <span>
                            {{ $sortItem->title }}
                        </span>
                        <x-admin.content-status-badge :status="$sortItem->status"></x-admin.content-status-badge>
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
