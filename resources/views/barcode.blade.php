<html>
<head>
    <title>Zella Boutique UAE</title>
    <style>
        small{
            font-size:10px;
        }
    </style>
</head>
<body>
    <small>{{ $product->name }}</small><br/>    
    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" width="144" height="95" /><br/>
    <small>AED: {{ $product->selling_price }}</small>
</body>
</html>