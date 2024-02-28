<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '記事',
            'href' => route('admin.post.index'),
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
    <x-admin.edit-form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-admin.edit-form-row required>
            <x-slot name="label">タイトル</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="title" value="{{ old('title') }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">サムネイル画像</x-slot>
            <x-slot name="field">
                <label x-data="{ imagePreview: null }"
                    class="cursor-pointer w-full mb-4 block px-3 py-2 border border-slate-300 rounded-md text-start flex flex-col justify-center items-center py-4">
                    <template x-if="imagePreview">
                        <div class="w-40 aspect-video rounded-sm overflow-hidden border-2">
                            <img class="w-full h-full object-cover" :src="imagePreview" class="imgPreview"
                                alt="">
                        </div>
                    </template>
                    <template x-if="!imagePreview">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 opacity-60 mb-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <span class="text-sm opacity-60">アップロード</span>
                        </div>
                    </template>
                    <input type="file" name="image" class="hidden" accept="image/*" wire:model="file"
                        @change="setImagePreview">
                    <script>
                        function setImagePreview(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    this.imagePreview = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        }
                    </script>
                </label>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">動画</x-slot>
            <x-slot name="field">
                <x-admin.media-upload name="video"></x-admin.media-upload>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">動画(フリー)</x-slot>
            <x-slot name="field">
                <x-admin.media-upload name="video_free"></x-admin.media-upload>
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
            <x-slot name="label">記事(フリー)</x-slot>
            <x-slot name="field">
                {{-- @livewire('admin.post-image-finder') --}}
                <textarea id="editor-free" name="content_free">
                    {{ old('content_free') }}
                </textarea>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">詳細</x-slot>
            <x-slot name="field">
                <x-admin.form.textarea name="description">{{ old('description') }}</x-admin.form.textarea>
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
        <x-admin.edit-form-row>
            <x-slot name="label">公式LINE追加用URL</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="line_link"
                    value="{{ old('line_link') }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">一般公開日時</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="datetime-local" name="public_release_at"
                    value="{{ old('public_release_at') }}"></x-admin.form.input>
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
