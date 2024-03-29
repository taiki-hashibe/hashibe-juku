<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'カテゴリー',
            'href' => route('admin.category.index'),
        ],
        [
            'label' => $item->name,
            'href' => route('admin.category.show', ['category' => $item->id]),
        ],
        [
            'label' => '編集',
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.category.update', [
        'category' => $item->id,
    ]) }}"
        method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-admin.edit-form-row required>
            <x-slot name="label">名前</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="name"
                    value="{{ old('name') ?? $item->name }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">親カテゴリー</x-slot>
            <x-slot name="field">
                <x-admin.form.select name="parent_id">
                    <option value="">未設定</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('parent_id') ?? $item->parent?->id === $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-admin.form.select>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">詳細</x-slot>
            <x-slot name="field">
                <x-admin.form.textarea
                    name="description">{{ old('description') ?? $item->description }}</x-admin.form.textarea>
            </x-slot>
        </x-admin.edit-form-row>
        <x-admin.edit-form-row>
            <x-slot name="label">サムネイル画像</x-slot>
            <x-slot name="field">
                <label x-data="{ imagePreview: {{ $item->thumbnail() ? "'" . $item->thumbnail() . "'" : 'null' }} }"
                    class="cursor-pointer w-full mb-4 block px-3 py-2 border border-slate-300 rounded-md text-start flex flex-col justify-center items-center py-4">
                    <template x-if="imagePreview">
                        <div class="w-24 h-24 rounded-sm overflow-hidden border-2">
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
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.button variant="primary">保存</x-admin.button>
            </div>
        </div>
    </x-admin.edit-form>
</x-admin.auth-layout>
