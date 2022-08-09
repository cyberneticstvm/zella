<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
   {!! DNS1D::getBarcodeHTML($product->sku, 'C128', 3, 33, 'black') !!}
   <!--<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" />-->
</body>
</html>