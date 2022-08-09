<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
   {!! DNS1D::getBarcodeHTML($product->sku, 'C128', 1, 25, 'black') !!}
   {{ $product->name }}
   <!--<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" />-->
</body>
</html>