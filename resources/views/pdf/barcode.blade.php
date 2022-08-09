<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
   <!--{!! DNS1D::getBarcodeHTML($product->sku, 'C39') !!}-->
   <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C39')}}" alt="{{ $product->sku }}" />
</body>
</html>