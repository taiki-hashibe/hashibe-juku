<x-admin.guest-layout>
    <div class="w-full relative pt-24 lg:pt-36">

        <div class="flex justify-center px-6">
            <div class="w-full sm:w-96 bg-white border shadow-md">
                <div class="bg-slate-800 mb-8 py-3">
                    <p class="text-center text-white font-bold text-lg">管理画面ログイン</p>
                </div>
                <div class="px-4 pb-6">
                    @if ($errors->any())
                        <div class="mt-6">
                            <x-alert status="danger" title="ログインできませんでした" message="{{ session('message') }}"></x-alert>
                        </div>
                    @endif
                    <form class="px-4" action="{{ route('admin.login') }}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label>
                                <p class="ps-3 mb-1">メールアドレス</p>
                                <x-admin.form.input name="email" type="email"></x-admin.form.input>
                            </label>
                        </div>
                        <div class="mb-6">
                            <label>
                                <p class="ps-3 mb-1">パスワード</p>
                                <x-admin.form.input name="password" type="password"></x-admin.form.input>
                            </label>
                        </div>
                        <button class="bg-blue-400 text-white font-bold w-full py-2">ログイン</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.guest-layout>
