@php
    $my_balance=my_balance(auth_user_id())
@endphp
 <div class="balance-card card-balance-bg">
        <div class="balance-value">$ {{$my_balance['available']}}</div>
        <div class="balance-label">
            <span class="status-dot dot-balance"></span>
            Balance
        </div>
    </div>

    <div class="balance-card card-pending-bg">
        <div class="balance-value">$ {{$my_balance['pending']}}</div>
        <div class="balance-label">
            <span class="status-dot dot-pending"></span>
            Pending
        </div>
    </div>
