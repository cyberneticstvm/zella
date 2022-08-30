<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
    <small>{{ $product->name }}</small>
    {!! DNS1D::getBarcodeHTML($product->sku, 'C128', 1, 25, 'black') !!}
    <small>AED: {{ $product->selling_price }}</small>
   <!--<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" />-->
</body>
</html>