<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'タグ',
            'href' => route('admin.tag.index'),
        ],
        [
            'label' => '新規作成',
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.tag.store') }}" method="POST">
        @csrf
        <x-admin.edit-form-row required>
            <x-slot name="label">名前</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="name" value="{{ old('name') }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.button variant="primary">保存</x-admin.button>
            </div>
        </div>
    </x-admin.edit-form>
</x-admin.auth-layout>
