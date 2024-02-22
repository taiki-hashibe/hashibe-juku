<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ユーザー',
            'href' => route('admin.user.index'),
        ],
        [
            'label' => $item->user_id ?? $item->name,
        ],
    ]"></x-admin.breadcrumb>
    @if ($errors->any())
        <x-alert status="danger" title="処理を正常に実行できませんでした。">
        </x-alert>
    @endif
    <x-admin.row-container>
        <div class="mb-4 mt-8 px-8 flex items-center">
            <h2 class="text-lg text-slate-600 font-bold me-6">基本情報</h2>
            <hr class="grow">
        </div>
        <x-admin.row>
            <x-slot name="label">ID</x-slot>
            <x-slot name="value">{{ $item->id }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">ユーザーID</x-slot>
            <x-slot name="value">{{ $item->user_id }}</x-slot>
        </x-admin.row>
        @if ($defaultPassword)
            <x-admin.row>
                <x-slot name="label">初期パスワード</x-slot>
                <x-slot name="value">{{ $item->default_password }}</x-slot>
            </x-admin.row>
        @endif
        <x-admin.row>
            <x-slot name="label">名前</x-slot>
            <x-slot name="value">{{ $item->name }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">メールアドレス</x-slot>
            <x-slot name="value">{{ $item->email }}</x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">契約会社名</x-slot>
            <x-slot name="value">
                @if ($item->company()->withTrashed()->first())
                    <a href="{{ route('admin.company.show', [
                        'company' => $item->company()->withTrashed()->first()->id,
                    ]) }}"
                        class="underline">{{ $item->company()->withTrashed()->first()->name }}</a>
                @endif
            </x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">ステータス</x-slot>
            <x-slot name="value"><x-admin.publish-level-enum :level="$item->status"></x-admin.publish-level-enum></x-slot>
        </x-admin.row>
        <x-admin.row>
            <x-slot name="label">閲覧可</x-slot>
            <x-slot name="value">
                <x-admin.site-enum :site="$item->site"></x-admin.site-enum>
            </x-slot>
        </x-admin.row>
        <div class="flex justify-end mt-8 md:px-4">
            <div>
                @if ($item->trashed())
                    <div x-data="{ restore: false }" class="inline-block">
                        <x-admin.button @click="restore = true" variant="success">復元</x-admin.button>
                        <x-modal key="restore">
                            <p class="mb-4">
                                本当に<b>{{ $item->name ?? $item->user_id }}</b>を復元しますか？
                            </p>
                            <form
                                action="{{ route('admin.user.restore', [
                                    'user' => $item->id,
                                ]) }}"
                                method="POST">
                                @csrf
                                <x-admin.button variant="success" class="w-full">確定</x-admin.button>
                            </form>
                        </x-modal>
                    </div>
                    <div x-data="{ forceDelete: false }" class="inline-block">
                        <x-admin.button @click="forceDelete = true" variant="danger">完全に削除</x-admin.button>
                        <x-modal key="forceDelete">
                            <p class="mb-4">
                                本当に<b>{{ $item->name ?? $item->user_id }}</b>を完全に削除しますか？
                            </p>
                            <form
                                action="{{ route('admin.user.force-delete', [
                                    'user' => $item->id,
                                ]) }}"
                                method="POST">
                                @csrf
                                <x-admin.button variant="outline-danger" class="w-full">確定</x-admin.button>
                            </form>
                        </x-modal>
                    </div>
                @else
                    <x-admin.anchor variant="primary" class="me-2"
                        href="{{ route('admin.user.edit', [
                            'user' => $item->id,
                        ]) }}">編集</x-admin.anchor>
                    <div x-data="{ destroy: false }" class="inline-block">
                        <x-admin.button @click="destroy = true" variant="danger">削除</x-admin.button>
                        <x-modal key="destroy">
                            <p class="mb-4">
                                本当に<b>{{ $item->name ?? $item->user_id }}</b>を削除しますか？
                            </p>
                            <form
                                action="{{ route('admin.user.destroy', [
                                    'user' => $item->id,
                                ]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <x-admin.button variant="outline-danger" class="w-full">確定</x-admin.button>
                            </form>
                        </x-modal>
                    </div>
                @endif

            </div>
        </div>
    </x-admin.row-container>
</x-admin.auth-layout>
