<x-layout class="bg-white">
    <x-breadcrumb :post="null" :category="null" :item="[
        'label' => '入会案内',
        'url' => route('user.register.guidance'),
    ]" />
    <div class="mb-8">
        <x-gradation-container class="mb-14">
            <p class="text-slate-600 font-bold leading-relaxed mb-6">
                {{ config('app.name') }}に本入会いただくと...<br>
                <span class="text-2xl">レッスン動画が無制限で見放題！</span><br>
            </p>
            <x-gradation-anchor href="#register">
                入会する！
            </x-gradation-anchor>
        </x-gradation-container>
        <p class="text-4xl font-bold mb-8">
            特典はそれだけではありません！
        </p>
        <p class="mb-14">
            {{ config('app.name') }}には<span class="text-2xl font-bold">レッスン動画が無制限で見放題</span>以外にも、<br>
            たくさんの特典があります！
        </p>
        <hr class="mb-14 border-slate-400">
        <x-gradation-badge>
            特典その１
        </x-gradation-badge>
        <h2 class="text-4xl font-bold mb-2">
            カリキュラムごとのプレイリストが閲覧可能！
        </h2>
        <p class="text-lg text-slate-600 font-bold mb-8">
            {{ isset($user) ? $user->name . 'さん' : 'あなた' }}の目的に合ったレッスン動画プレイリストで効率よく上達できます
        </p>
        <p class="leading-relaxed mb-20">
            ベースを始めたばかりでとりあえず曲が弾けるようになりたい、スラップができるようになりたい、音楽理論を学びたい、ジャズが弾けるようになりたい...<br>
            ベースを弾いていると、様々な目標が出てきますよね。<br>
            <br>
            今時インターネットには様々な情報があふれていますが、自分の目標に合った情報を見つけるのはなかなか大変です。<br>
            <br>
            {{ config('app.name') }}では<b>目標別のカリキュラムプレイリスト</b>を用意し、{{ isset($user) ? $user->name . 'さん' : 'あなた' }}の目標に合ったレッスン動画を効率よく見ることができます！
        </p>
        <x-gradation-badge>
            特典その２
        </x-gradation-badge>
        <h2 class="text-4xl font-bold mb-2">
            レッスン動画をお気に入り登録できる！
        </h2>
        <p class="text-lg text-slate-600 font-bold mb-8">
            とても大切な反復練習を効率よく行うことができます
        </p>
        <p class="leading-relaxed mb-20">
            技術や知識をしっかり身につけるためには、反復練習が欠かせません。<br>
            <br>
            {{ config('app.name') }}では、<b>レッスン動画をお気に入り登録</b>することができます。<br>
            お気に入り登録した動画はマイページから確認が可能で、反復練習を効率よく行うことができます！
        </p>
        <x-gradation-badge>
            特典その３
        </x-gradation-badge>
        <h2 class="text-4xl font-bold mb-2">
            受講完了した動画を登録して進捗を管理できる！
        </h2>
        <p class="text-lg text-slate-600 font-bold mb-8">
            進捗を管理することで、自分の成長を実感できます
        </p>
        <p class="leading-relaxed mb-20">
            {{ config('app.name') }}では、<b>受講完了した動画を登録</b>することができます。<br>
            登録した動画はマイページから確認が可能で、自分の進捗を管理することができます。<br>
            進捗を管理することで、自分の成長を実感することができます！
        </p>
        <hr class="mb-14 border-slate-400">
        <div class="mb-14">
            <p class="leading-relaxed mb-4">
                さて、当サイトのレッスン動画に関する特典をご紹介しましたが、<br>
                <span class="text-xl font-bold">
                    他にもたくさんの特典があります！
                </span><br><br>
                {{ config('app.name') }}は<b>コミュニティ</b>としての側面も大切にしており、ベース仲間と出会うこともできます！<br><br>
                また、会員限定の情報も配信しており、普段の僕の練習をのぞき見することができるかもしれません！
            </p>
            <x-gradation-anchor href="#register">
                入会する！
            </x-gradation-anchor>
        </div>
        <hr class="mb-14 border-slate-400">
        <x-gradation-badge>
            特典その４
        </x-gradation-badge>
        <h2 class="text-4xl font-bold mb-2">
            会員限定のコミュニティに参加できる！
        </h2>
        <p class="text-lg text-slate-600 font-bold mb-8">
            ベース仲間と出会い、交流することができます
        </p>
        <p class="leading-relaxed mb-20">
            {{ config('app.name') }}には、会員限定のコミュニティがあります。<br>
            {{ isset($user) ? $user->name . 'さん' : 'あなた' }}の演奏を聞いてもらったり、質問をしたり、悩みを共有したり...<br>
            仲間を見つけることでさらにベースを楽しく弾くことができます！
        </p>

        <x-gradation-badge>
            特典その５
        </x-gradation-badge>
        <h2 class="text-4xl font-bold mb-2">
            限定配信を閲覧できる！
        </h2>
        <p class="text-lg text-slate-600 font-bold mb-8">
            質問に答える配信や、普段の僕の練習をのぞき見することができるかも！
        </p>
        <p class="leading-relaxed mb-20">
            入会していただいている方限定で、質問にお答えする配信に参加したり、普段の僕の練習をのぞき見することができます！<br>
            他にもプロミュージシャンの活動の裏側をのぞき見することができるかもしれません！
        </p>
        <hr class="mb-14 border-slate-400">
        <h2 class="text-4xl font-bold mb-2">
            価格について
        </h2>
    </div>
</x-layout>
