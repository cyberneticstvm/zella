<!DOCTYPE html>
<html>
<head>
    <title>Zella Boutique UAE</title>
    <style>
        table{
            font-size: 15px;
        }
        .bordered th, .bordered td{
            border: 1px solid #e6e6e6;
            padding: 5px;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>
    <center>
        <img src="./images/zella-logo-pdf.png" width="25%"/>
        <p>Phone: 0562659619, 0521734496</p>
        <h5>PRODUCT LIST</h5>
    </center>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th>Product Name</th><th>SKU</th><th>Collection Name</th><th>Selling Price</th><th>Description</th></tr>
        <tbody>
            @php $c = 1; @endphp
            @foreach($products as $row)
            <tr>
                <td>{{ $c++ }}</td>
                <td>{{ $row->pname }}</td>
                <td>{{ $row->sku }}</td>
                <td>{{ $row->cname }}</td>
                <td>{{ $row->selling_price }}</td>
                <td>{{ $row->description }}</td>
            </tr>           
            @endforeach
        </tbody>
    </table>
</body>
</html>