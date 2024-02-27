<x-layout class="bg-white">
    <x-breadcrumb :post="null" :category="null" :curriculum="null" :item="[
        'label' => '入会案内',
        'url' => route('user.register.guidance'),
    ]" />
    <div class="mb-8">
        <x-gradation-container class="mb-24">
            <p class="text-slate-600 font-bold leading-relaxed mb-6">
                {{ config('app.name') }}に本入会いただくと...<br>
                <span class="text-2xl">レッスン動画が無制限で見放題！</span><br>
            </p>
            <x-gradation-anchor href="#guidance-payment-form">
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
            レッスン動画をブックマークできる！
        </h2>
        <p class="text-lg text-slate-600 font-bold mb-8">
            とても大切な反復練習を効率よく行うことができます
        </p>
        <p class="leading-relaxed mb-20">
            技術や知識をしっかり身につけるためには、反復練習が欠かせません。<br>
            <br>
            {{ config('app.name') }}では、<b>レッスン動画をブックマーク</b>することができます。<br>
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
            <x-gradation-anchor href="#guidance-payment-form">
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
        <h2 class="text-4xl font-bold mb-6">
            価格について
        </h2>
        <p class="leading-relaxed mb-8">
            ベース教室の月謝の相場は、{{ number_format(10000) }}～{{ number_format(15000) }}円程で、別途入会金などがかかる場合があります...<br>
            <br>
            {{ config('app.name') }}の料金は、<b
                class="text-lg text-slate-900">月額{{ number_format($price->unit_amount + 1000) }}円</b>で、入会金は<b
                class="text-xl text-slate-900">無料</b>となっています！<br>
            <br><br>
            <span class="font-bold text-3xl">さらに！</span><br>
        </p>
        <x-gradation-container>
            <x-gradation-badge>
                今だけのオープニングキャンペーン特割中！
            </x-gradation-badge>
            <p class="line-through text-xl fot-bold text-slate-700 mb-4">
                月額{{ number_format($price->unit_amount + 1000) }}円
            </p>
            <p class="font-bold text-5xl mb-8 text-slate-900">
                月額{{ number_format($price->unit_amount) }}円
            </p>
        </x-gradation-container>
        <p class="mb-20">
            既にレッスン動画は初心者の方に向けた基礎が学べるものから、
            中級者、上級者の方に向けた高度なテクニックの解説まで、音楽教室で教わる内容と謙遜の無い内容になっています。<br>
            <br>
            しかし、僕の目指す{{ config('app.name') }}の内容は、<b>プロミュージシャンとして活動してきた経験</b>や、<b>専門学校でプロを育成してきた経験</b>を活かした<span
                class="font-bold text-2xl">音楽の本質を学べる</span>クオリティまでもっていきたいと考えています。<br>
            <br>
            まだまだ僕には{{ isset($user) ? $user->name . 'さん' : 'あなた' }}にお伝えしたいことがたくさんあります！<br>
            僕にとって理想の形には届いていないため、オープニング期間中のみこの価格で提供することにしました！<br>
            <br>
            <br>
            <span class="text-xl font-bold text-slate-800 mb-10">
                さらになんと！
            </span>
            <br>
            <span
                class="text-4xl font-bold underline decoration-pink-400 decoration-8 underline-offset-8 leading-10">今入会いただけた方はずっとこの料金で利用できます！</span>
            <br>
            <br>
            オープニング期間が終了しても、{{ isset($user) ? $user->name . 'さん' : 'あなた' }}はいつまでもこの料金で利用できます！<br>
            <br>
            <br>
            オープニング期間のキャンペーンは<span class="font-bold text-xl">予告無く</span>終了する場合がありますので、入会を希望する方はお早めにお手続きください！
        </p>
        <hr class="mb-14 border-slate-400">
        <div class="mb-8" id="guidance-payment-form">
            <h2 class="text-4xl font-bold mb-6">入会のお手続き</h2>
            <ul class="mb-8">
                <li>
                    ※{{ config('app.name') }}の決済方法はクレジットカードのみとなっております。
                </li>
                <li>
                    ※学生の方は保護者の同意のもとクレジットカード決済をご利用ください。
                </li>
            </ul>
            @if ($user->subscribed('online-salon'))
                <p>既に入会済みです！<br>
                    引き続きレッスン動画をお楽しみください！
                </p>
            @else
                <x-payment-form action="{{ route('user.register.register') }}" :intent="$intent" :price="$price"
                    class="mb-4" />
            @endif
        </div>
    </div>
</x-layout>
