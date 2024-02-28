<x-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName()) }}
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
            @if (isset($user))
                @if ($user->subscribed('online-salon'))
                    <p>既に入会済みです！<br>
                        引き続きレッスン動画をお楽しみください！
                    </p>
                @else
                    <x-payment-form action="{{ route('user.register.register') }}" :intent="$intent" :price="$price"
                        class="mb-4" />
                @endif
            @else
                <x-gradation-container class="mb-24">
                    <p class="font-bold leading-relaxed mb-6">
                        入会する前に、公式LINEを友達追加するだけで...<br>
                        <span class="font-bold text-2xl">無料でレッスン動画をお楽しみいただけます！</span><br>
                    </p>
                    <p class="leading-relaxed mb-6">
                        公式LINEを友達追加していただくと、5本のレッスン動画のフルバージョンを閲覧できます！<br>
                        思っていた感じと違って後悔してしまうのは僕としても不本意なので、まずは無料でお試しいただければと思います！
                    </p>
                    <a class="inline-block px-6 py-2 rounded-full text-white outline-1 font-bold bg-line duration-200 hover:bg-line-active"
                        href="{{ config('line.link') }}">
                        <div class="flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 me-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                            </svg>
                            <span>公式LINEを友達追加する！</span>
                        </div>
                    </a>
                </x-gradation-container>
            @endif
        </div>
    </div>
</x-layout>
