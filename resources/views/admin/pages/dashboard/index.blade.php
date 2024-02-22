<x-admin.auth-layout>
    <x-admin.breadcrumb :pages="[
        [
            'label' => 'ダッシュボード',
        ],
    ]">
    </x-admin.breadcrumb>
    <div class="mt-4 mb-3">
        <div class="relative rounded-xl border">
            <div class="overflow-x-scroll my-8">
                <div class="px-6">
                    <x-admin.contents-map :isParent="true" />
                </div>
            </div>
        </div>
    </div>
</x-admin.auth-layout>
