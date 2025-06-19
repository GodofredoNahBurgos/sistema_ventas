<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de Compra</title>
    <style>
        body{
            font-family: DejaVu, Sans, sans-serif;
        }
        .ticket{
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px solid #000;
        }
        .title{
            font-size: 18px;
            font-weight: bold;
        }
        .detail{
            text-align: left;
            margin-top: 10px;
        }
        .total{
            font-size: 17px;
            font-weight: bold;
            margin-top: 10px;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        th, td{
            border-bottom: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
 
    </style>
</head>

<body>
    <div class="ticket">
        <h1 class="title">Ticket de Compra</h1>
        <p><strong>Cajero: </strong> {{ $sale->user_name }}</p>
        <div class="detail">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                    <tr>
                        <td class="border border-gray-300 text-center">{{ $detail->product_name }}</td>
                        <td class="border border-gray-300 text-center">{{ $detail->quantity }}</td>
                        <td class="border border-gray-300 text-center">{{ $detail->unit_price }}</td>
                        <td class="border border-gray-300 text-center">{{ $detail->sub_total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="total"><strong>Total de Venta: </strong>{{ '$'.$sale->total_sale }}</p>
        <p><strong>Fecha: </strong>{{ $sale->created_at }}</p>
        <p>Gracias por su compra.</p>
    </div>
</body>
</html>