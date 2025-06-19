<!DOCTYPE html>
<html>

<head>
    <title>E-Billing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }

        .empty {
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>E-Billing</h1>
        <p>Vendor: {{ $vendor ?? 'N/A' }}</p>
        <p>Date: {{ $date ?? now()->format('Y-m-d') }}</p>
        <p>Customer: {{ $user->name ?? 'Guest' }}</p>
    </div>

    @if (!empty($cartItems))
        <table class="table">
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
                        <td>{{ $item['name'] ?? 'N/A' }}</td>
                        <td>{{ $item['quantity'] ?? 0 }}</td>
                        <td>Rp. {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: Rp. {{ number_format($totalPrice ?? 0, 0, ',', '.') }}
        </div>
    @else
        <div class="empty">
            <p>No items found for this e-billing.</p>
        </div>
    @endif

    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
</body>

</html>
