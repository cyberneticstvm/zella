<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
   <p>Barcode</p>
   {!! DNS1D::getBarcodeHTML($product->sku, 'C39') !!}
   <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('11', 'C39')}}" alt="barcode" />
</body>
</html>