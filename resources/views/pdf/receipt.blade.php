<!DOCTYPE html>
<html>
<head>
    <title>Απόδειξη #{{$receipt->number}}</title>
    <style type="text/css">
        @page { margin: 250px 25px; }
        body { margin: 0; font-family: DejaVu Sans; font-size: 0.7rem; }
        .underline { text-decoration: underline; }
        .center-align { text-align: center; }
        .right-align { text-align: right; }
        .left-align { text-align: left; }
        .padding-left { padding-left: 10px; }
        .right { float: right; }
        .v-align-btm { width: 300px; float: right; margin-top: 50px; }
        /*for a5, v-align-btm -> position bottom is -600, body -> font-size is 0.7rem*/
        /*for a4, v-align-btm -> position bottom is -870, body -> font-size is 1rem*/
        header { position: fixed; top: -210px; left: 0px; right: 0px; height: 200px; border: 1px solid #ccc; border-radius: 5px; padding: 10px 10px 0 10px; }
        footer { position: fixed; bottom: -210px; left: 0px; right: 0px; height: 110px; border: 1px solid #ccc; border-radius: 5px; padding: 5px 10px 0 10px; }
        main { padding-top: 40px; }
        table { width: 100%; text-align: left; }
        tr.top img { width: 200px; }
        tr.top p { text-align: right; font-size: 14px; }
        tr.information td { font-size: 16px; padding-top: 20px; }
        tr.item-head { background: #eee; border-bottom: 1px solid #ddd; color: #263238; }
        tr.item-head th { font-size: 16px; padding: 5px; }
        tr.item-line td { font-size: 14px; padding: 5px; }
        tr.posa th, td { font-size: 14px; }
        tr.posa td { width: 140px; padding-left: 15px; }
    </style>
</head>
<body>
    <header>
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td>
                    <img src="{{asset('img/logo.png')}}"">
                </td>
                
                <td valign="middle">
                    <p>
                        Απόδειξη #: {{$receipt->number}}<br>
                        {{ date('d/m/Y', strtotime($receipt->created_at)) }}
                    </p>
                </td>
            </tr>
            
            <tr class="information">
                <td class="left-align">
                    Εταιρεία: Όνομα<br>
                    Εταιρεία: Διεύθυνση<br>
                    Εταιρεία: ΤΚ, Περιοχή
                </td>
                
                <td class="right-align">
                    {{$order->name}}<br>
                    {{$order->address}}<br>
                    {{$order->tk}}, {{$order->city}}
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table>
            <tr class="posa">
                <th rowspan="4" valign="middle" class="posa-comment"></th>
                <th class="right-align">Υποσύνολο</th>
                <td>{{ number_format($order->subtotal, 2, ',', ' ') }} &euro;</td>
            </tr>
            <tr class="posa">
                <th class="right-align">ΦΠΑ</th>
                <td>{{ number_format($order->tax, 2, ',', ' ') }} &euro;</td>
            </tr>
            <tr class="posa">
                <th class="right-align">Μεταφορικά</th>
                <td>{{ number_format($order->shipping, 2, ',', ' ') }} &euro;</td>
            </tr>
            <tr class="posa">
                <th class="right-align">Σύνολο</th>
                <td>{{ number_format($order->total, 2, ',', ' ') }} &euro;</td>
            </tr>
        </table>
    </footer>

    <main>
        <table style="margin-bottom: 40px;">
            <tr class="item-head">
                <th>Πληρωμή</th>
            </tr>
            <tr class="item-line">
                <td>{{ $order->payment }}</td>
            </tr>
        </table>

        <table>
            <tr class="item-head">
                <th>Προϊόν</th>
                <th class="right-align">Ποσό</th>
            </tr>
            @foreach ($products as $item)
            <tr class="item-line">
                <td>{{ $item->product->name }}</td>
                <td class="right-align">{{ number_format($item->total, 2, ',', ' ') }} &euro;</td>
            </tr>
            @endforeach
        </table>
    </main>
</body>
</html>