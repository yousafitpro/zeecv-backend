<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $invoice->number ?? 'INV-'.$id }}</h1>
    <p>Date: {{ now()->format('M d, Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items ?? [] as $item)
                <tr>
                    <td>{{ $item->package->title }}</td>
                    <td>1</td>
                    <td>${{ number_format($item['amount'], 2) }}</td>
                    <td>${{ number_format(1 * $item['amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Subtotal</td>
                <td class="total">${{ number_format($subtotal ?? 0, 2) }}</td>
            </tr>
           
            <tr>
                <td colspan="3" class="total">Grand Total</td>
                <td class="total">${{ number_format($subtotal ?? 0, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>