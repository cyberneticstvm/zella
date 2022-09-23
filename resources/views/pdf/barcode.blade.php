<!--<html>
<head>
    <title>Zella Boutique UAE</title>
    <style>
        small{
            font-size:10px;
        }
    </style>
</head>
<body>
    <small>{{ $product->name }}</small>
    {!! DNS1D::getBarcodeHTML($product->sku, 'C128', .5, 15, 'black') !!}
    <small>AED: {{ $product->selling_price }}</small>
   <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" />

   <pre></pre>

   <small>{{ $product->name }}</small>
    {!! DNS1D::getBarcodeHTML($product->sku, 'C128', 4, 150, 'black') !!}
    <small>AED: {{ $product->selling_price }}</small>
</body>
</html>-->
<html>
<head>
    <title>Zella Boutique UAE</title>
    <style>
        small{
            font-size:10px;
        }
        @media print {  
            @page {
                size: 3.8mm 2.5mm; /* landscape */
            }
        }
    </style>
</head>
<body>
    <small>{{ $product->name }}</small><br/>    
    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->sku, 'C128')}}" alt="{{ $product->sku }}" width="144" height="95" /><br/>
    <small>AED: {{ $product->selling_price }}</small>
</body>
</html>