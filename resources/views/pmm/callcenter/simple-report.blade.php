<table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
          <thead>

            <tr>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">#</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Order ID</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Created At</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Order Status</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Payment Status</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Amount</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Parcel By</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Customer</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Phone</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">City</th>
                <th style="background-color: #457b9d; color: #fff; padding: 8px; border: 1px solid #ccc;">Country</th>
            </tr>
        </thead>
    @foreach($payments as $index => $payment)
        {{-- ========== ORDER HEADER ========== --}}
 

        <tbody>
            {{-- ========== ORDER MAIN ROW ========== --}}
            <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $index + 1 }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">#{{ $payment->id }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ ucfirst($payment->order_status ?? '-') }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ ucfirst($payment->status) }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">${{ number_format($payment->amount, 2) }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                      @if (!empty($payment->latestParcel) && !empty($payment->latestParcel->user))
                            {{$payment->latestParcel->user->name}} <br>
                            {{$payment->latestParcel->user->email}} 
                        @endif
                </td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->name }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->phone }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->city }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $payment->country }}</td>
            </tr>
        </tbody>
    @endforeach
</table>
