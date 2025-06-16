<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de registros</title>
</head>
<body>
    <h2>Productos con stock minimo</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae ea optio doloribus accusantium corporis, asperiores libero deserunt iusto! Voluptatibus soluta obcaecati iste consequuntur dolorem a doloremque facilis dolores, laborum atque? </p>
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
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->supplier_name }}</td>
                    <td>{{ $product->cost_price }}</td>
                    <td>{{ $product->sale_price }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</body>
</html>