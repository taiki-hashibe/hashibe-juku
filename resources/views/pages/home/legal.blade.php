<x-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName()) }}
    <h2 class="text-slate-700 mb-12 font-bold text-lg px-4">特定商取引法に基づく表記</h2>
    <div class="wp-content px-4 mb-12">
        <figure class="wp-block-table">
            <table>
                <tbody>
                    <tr>
                        <td><strong>販売業社の名称</strong></td>
                        <td>橋部太樹</td>
                    </tr>
                    <tr>
                        <td><strong>所在地</strong></td>
                        <td>請求があったら遅滞なく開示します</td>
                    </tr>
                    <tr>
                        <td><strong>電話番号</strong></td>
                        <td>請求があったら遅滞なく開示します</td>
                    </tr>
                    <tr>
                        <td><strong>メールアドレス</strong></td>
                        <td>tb.ba.700@gmail.com</td>
                    </tr>
                    <tr>
                        <td><strong>運営統括責任者</strong></td>
                        <td>橋部太樹</td>
                    </tr>
                    <tr>
                        <td><strong>追加手数料等の追加料金</strong></td>
                        <td>特にありません</td>
                    </tr>
                    <tr>
                        <td><strong>交換および返品（返金ポリシー）</strong></td>
                        <td>商品の性質上、返品は承っておりません</td>
                    </tr>
                    <tr>
                        <td><strong>引渡時期</strong></td>
                        <td>即時</td>
                    </tr>
                    <tr>
                        <td><strong>受け付け可能な決済手段</strong></td>
                        <td>クレジットカード</td>
                    </tr>
                    <tr>
                        <td><strong>決済期間</strong></td>
                        <td>毎月自動更新</td>
                    </tr>
                </tbody>
            </table>
        </figure>

        <h2 class="wp-block-heading">お支払いについて</h2>

        <p>月額のご利用料金のお支払いに関しては、Stripeの規定に従います。なお、決裁手数料については、お客様にご負担をお願いしております。</p>

        <p>※ 有料プランのご利用申し込み手続きが完了した時点で課金が行われ、引き落としはStripe Inc.との契約に基づく定められた日に行われます。</p>

        <p>＊ 有料プランのご利用料金に関する請求および収納は、Stripeが提供する自動更新の定期購読型課金機能を通じて行います。なお、本サービスと課金機能は独立しており、連動していません。</p>

        <p>定期購読型課金機能の解約手続きを行っても、既に支払い済みの購読期間についての払い戻し等は行われませんので、ご留意ください。</p>

        <p>※ お客様が未成年者である場合、購入申し込みが行われた時点で、法定代理人である保護者や親権者の同意があったものとみなされます。</p>

    </div>
</x-layout>
