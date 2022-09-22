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
                margin: 2cm;
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