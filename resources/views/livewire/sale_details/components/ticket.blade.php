<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de Compra</title>
    <style>

        body {
            font-family: DejaVu, Sans, sans-serif;
        }

        .ticket {
            width: 80mm;
            max-width: 80mm;
            overflow: hidden;
            font-size: 12px;
        }

        .title {
            font-weight: bold;
        }

        .detail {
            max-width: 80mm;
        }

        .total {
            font-weight: bold;
        }

        table {
            width: 60mm;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            word-break: break-word;
            overflow: hidden;
            white-space: normal;
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
                        <td class="border border-gray-300 text-center">{{ '$'.$detail->unit_price }}</td>
                        <td class="border border-gray-300 text-center">{{ '$'.$detail->sub_total }}</td>
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