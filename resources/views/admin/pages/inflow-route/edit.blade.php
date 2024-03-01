<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => '流入経路',
            'href' => route('admin.inflow-route.index'),
        ],
        [
            'label' => '編集',
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.edit-form action="{{ route('admin.inflow-route.update', [
        'inflow_route' => $item->id,
    ]) }}"
        method="POST">
        @csrf
        @method('PUT')
        <x-admin.edit-form-row>
            <x-slot name="label">経路</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="route"
                    value="{{ old('route') ?? $item->route }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>

        <x-admin.edit-form-row>
            <x-slot name="label">流入元</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="source"
                    value="{{ old('source') ?? $item->source }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>

        <x-admin.edit-form-row>
            <x-slot name="label">リダイレクト先</x-slot>
            <x-slot name="field">
                <x-admin.form.input type="text" name="redirect_url"
                    value="{{ old('redirect_url') ?? $item->redirect_url }}"></x-admin.form.input>
            </x-slot>
        </x-admin.edit-form-row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                <x-admin.button variant="primary">保存</x-admin.button>
            </div>
        </div>
    </x-admin.edit-form>
</x-admin.auth-layout>
