<x-admin.auth-layout>
    @php
        $breadcrumbs = [
            [
                'label' => 'カリキュラム',
                'href' => route('admin.curriculum.index'),
            ],
        ];
        $breadcrumbs[] = [
            'label' => '並べ替え',
        ];
    @endphp
    <x-admin.breadcrumb :pages="$breadcrumbs"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.curriculum.sort') }}" method="POST">
        @csrf
        <ul id="curriculum-list" class="md:p-4 md:pl-8">
            @foreach ($items->get() as $item)
                <li class="flex flex-col md:flex-row border rounded-md duration-100 bg-white hover:bg-slate-100 mb-2"
                    style="cursor: grab">
                    <input type="hidden" name="order[]" value="{{ $item->id }}">
                    <div class="w-full mb-4 md:mb-0 md:px-4 py-2 md:pl-8 text-slate-700 dark:text-slate-400">
                        {{ $item->name }}
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
