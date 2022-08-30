<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
    <table width="100%">
    @php $c=0; @endphp
    @foreach($products as $key => $product)
        @if($c == 0 || $c%4 == 0) <tr>  @endif
            <td>
                <small>{{ $product->name }}</small>
                {!! DNS1D::getBarcodeHTML($product->sku, 'C128', 1, 25, 'black') !!}
                <small>AED: {{ $product->selling_price. $c%4 }}</small>
            </td>
        @if($c%4 > 0 && $c%4 == 0) </tr> @endif
    {{ $c++ }}
    @endforeach
    </table>
   <!--<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" />-->
</body>
</html>