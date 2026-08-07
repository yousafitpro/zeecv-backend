<table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
    @foreach($payments as $index => $payment)
        {{-- ========== ORDER HEADER ========== --}}
        <thead>
            <tr>
                <th colspan="10" style="background-color: #1d3557; color: #fff; padding: 10px; text-align: center; font-size: 18px;">
                    Order #{{ $payment->id }} — {{ ucfirst($payment->status) }}
                </th>
            </tr>
            <tr>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">#</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Order ID</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Created At</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Order Status</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Payment Status</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Amount</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Customer</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Phone</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">City</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Country</th>
            </tr>
        </thead>

        <tbody>
            {{-- ========== ORDER MAIN ROW ========== --}}
            <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $index + 1 }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">#{{ $payment->id }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ ucfirst($payment->order_status ?? '-') }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ ucfirst($payment->status) }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">${{ number_format($payment->amount, 2) }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->name }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->phone }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->city }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->country }}</td>
            </tr>

            {{-- ========== ORDER NOTES ========== --}}
            @if(isset($payment->notes) && count($payment->notes) > 0)
                <tr>
                    <td colspan="10" style="padding: 10px;">
                        <strong style="color:#1d3557;">Notes:</strong>
                        <table style="border-collapse: collapse; width: 100%; margin-top: 5px; font-size: 13px;">
                            <thead>
                                <tr style="background-color: #a8dadc;">
                                    <th style="border: 1px solid #ccc; padding: 6px;">Date</th>
                                    <th style="border: 1px solid #ccc; padding: 6px;">User</th>
                                    <th style="border: 1px solid #ccc; padding: 6px;">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment->notes as $note)
                                    <tr>
                                        <td style="border: 1px solid #ccc; padding: 6px;">{{ $note->created_at->format('d M Y, h:i A') }}</td>
                                        <td style="border: 1px solid #ccc; padding: 6px;">{{ $note->user->name ?? 'System' }}</td>
                                        <td style="border: 1px solid #ccc; padding: 6px;">{{ $note->note }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endif

            {{-- Spacer row between orders --}}
            <tr><td colspan="10" style="height: 25px;"></td></tr>
        </tbody>
    @endforeach
</table>
