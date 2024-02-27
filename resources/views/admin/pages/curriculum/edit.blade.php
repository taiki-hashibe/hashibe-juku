<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'カリキュラム',
            'href' => route('admin.curriculum.index'),
        ],
        [
            'label' => $item->name,
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.curriculum.update', [
        'curriculum' => $item->id,
    ]) }}"
        method="POST">
        @method('PUT')
        @csrf
        <x-admin.edit-form-row required>
            <x-slot name="label">タイトル</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="name"
                    value="{{ old('name') ?? $item->name }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row required>
            <x-slot name="label">詳細</x-slot>
            <x-slot name="field">
                <x-admin.form.textarea
                    name="description">{{ old('description') ?? $item->description }}</x-admin.form.textarea>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row required>
            <x-slot name="label">投稿</x-slot>
            <x-slot name="field">
                <livewire:admin.curriculum-post-editor :selected="$item->posts" />
            </x-slot>
        </x-admin.edit-form-row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.button variant="primary">保存</x-admin.button>
            </div>
        </div>
    </x-admin.edit-form>
</x-admin.auth-layout>
