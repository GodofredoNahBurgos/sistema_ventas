<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de productos</title>
    <style>
        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid rgb(0, 0, 0);
            text-align: center;
        }
        th, td {
            padding: 5px;
            border: 1px solid rgb(0, 0, 0);
        }
    </style>
</head>
<body>
    <h2>Productos</h2>
    <p>Listado general de Productos con Stock minimo</p>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isEmpty())
                <tr>
                    <td colspan="6">No hay productos disponibles.</td>
                </tr>
            @endif
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->supplier_name }}</td>
                    <td>{{ '$'.$product->cost_price }}</td>
                    <td>{{ '$'.$product->sale_price }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</body>
</html>