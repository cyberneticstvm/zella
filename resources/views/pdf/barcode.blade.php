<!DOCTYPE html>
<html>
<head>
    <title>Zella Boutique UAE</title>
</head>
<body>
   <p>Barcode</p>
   <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('http://google.com')) !!} ">
</body>
</html>