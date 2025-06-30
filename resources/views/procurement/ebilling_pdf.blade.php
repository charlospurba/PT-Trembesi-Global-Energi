<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Billing - Trembesi Global Energi</title>
    <style>
        @page {
            margin: 40px 40px 80px 40px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 22px;
            color: #b91c1c;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-col p {
            margin: 3px 0;
            line-height: 1.4;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
        }

        table.items th,
        table.items td {
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 13px;
        }

        table.items th {
            background-color: #f3f4f6;
            text-align: left;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="content">
    <!-- Header -->
    <div class="header">
        <h1>Trembesi Global Energi</h1>
        <p>E-Billing Document</p>
    </div>

    <!-- Information Section -->
    <div class="info-section">
        <div class="info-col">
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Vendor:</strong> {{ $vendor }}</p>
        </div>
        <div class="info-col">
            <p><strong>Customer:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items">
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <p class="total">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
</div>

<!-- Footer -->
<div class="footer">
    &copy; {{ date('Y') }} Trembesi Global Energi — This document was generated electronically and is valid without signature.
</div>

</body>
</html>
