<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '投稿',
            'href' => route('admin.post.index'),
        ],
        [
            'label' => '新規作成',
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        @dump($errors)
        @dump($errors->get('exercises.*'))
        @foreach ($errors->all() as $e)
            <div class="mb-3">
                <p class="text-red-500 font-bold mb-1">{{ $e }}</p>
            </div>
        @endforeach
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-admin.edit-form-row required>
            <x-slot name="label">タイトル</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="title" value="{{ old('title') }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">動画</x-slot>
            <x-slot name="field">
                <x-admin.media-upload></x-admin.media-upload>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">記事</x-slot>
            <x-slot name="field">
                {{-- @livewire('admin.post-image-finder') --}}
                <textarea id="editor" name="content">
                    {{ old('content') }}
                </textarea>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">カテゴリー</x-slot>
            <x-slot name="field">
                <x-admin.form.select name="category_id">
                    <option value="">未設定</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('category_id') === $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-admin.form.select>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row required>
            <x-slot name="label">公開ステータス</x-slot>
            <x-slot name="field">
                <x-admin.form.select name="status">
                    @foreach ($status as $s)
                        <option value="{{ $s['value'] }}" @if (old('status') === $s['value']) selected @endif>
                            {{ $s['label'] }}
                        </option>
                    @endforeach
                </x-admin.form.select>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row required>
            <x-slot name="label">公開範囲</x-slot>
            <x-slot name="field">
                <x-admin.form.select name="publish_level">
                    @foreach ($publishLevels as $p)
                        <option value="{{ $p['value'] }}" @if (old('publish_level') === $p['value']) selected @endif>
                            {{ $p['label'] }}
                        </option>
                    @endforeach
                </x-admin.form.select>
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
