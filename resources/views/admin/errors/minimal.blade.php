<x-admin.guest-layout>
    <div class="w-full flex justify-center pt-16 pb-16">
        <div class="w-full md:w-96 pb-8 border">
            <div class="bg-slate-800 text-center py-3 mb-4">
                <span class="text-white text-lg font-bold">管理画面</span>
            </div>
            <div class="px-4">
                <h1 class="text-slate-700 text-center mb-4">@yield('title')</h1>
                <a class="bg-blue-400 text-white font-bold w-full py-2 block text-center"
                    href="{{ route('admin.dashboard') }}">管理画面トップへ戻る</a>
            </div>
        </div>
    </div>
</x-admin.guest-layout>
