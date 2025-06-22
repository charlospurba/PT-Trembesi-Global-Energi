<!DOCTYPE html>
<html>

<head>
    <title>E-Billing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>E-Billing Receipt</h1>
    <p><strong>Customer:</strong> {{ $user->name }} ({{ $user->email }})</p>
    <p><strong>Vendor:</strong> {{ $vendor }}</p>
    <p><strong>Date:</strong> {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3">Total</td>
                <td>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
