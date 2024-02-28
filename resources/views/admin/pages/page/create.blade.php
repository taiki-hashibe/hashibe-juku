<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ページの管理',
            'href' => route('admin.page.index'),
        ],
        [
            'label' => '新規作成',
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        @foreach ($errors->all() as $e)
            <div class="mb-3">
                <p class="text-red-500 font-bold mb-1">{{ $e }}</p>
            </div>
        @endforeach
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.page.store') }}" method="POST">
        @csrf
        <x-admin.edit-form-row required>
            <x-slot name="label">タイトル</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="title" value="{{ old('title') }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">本文</x-slot>
            <x-slot name="field">
                <textarea id="editor" name="content">
                    {{ old('content') }}
                </textarea>
            </x-slot>
        </x-admin.edit-form-row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.button variant="primary" id="video-submit-button">保存</x-admin.button>
            </div>
        </div>
    </x-admin.edit-form>
    <x-admin.ckeditor-script></x-admin.ckeditor-script>
</x-admin.auth-layout>
