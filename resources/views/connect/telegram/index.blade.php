@extends('layout.master')
@section('title', "Telegram")
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Connect with Telegram Bot</h4>
                </div>
                <div class="card-body p-4">
                    <p class="lead text-center">
                        Follow the steps below to reconnect and interact with our Telegram bot:
                    </p>

                    <ol class="list-group list-group-numbered mb-4">
                        <li class="list-group-item">
                            Open the <strong>Telegram App</strong> on your mobile or desktop.
                        </li>
                        <li class="list-group-item">
                            Search for our bot by name or username:<br>
                            <code>{{"@".config('myconfig.CON.TelegramBot.name')}}</code>
                        </li>
                        <li class="list-group-item">
                            Start a chat with the bot by sending this command:<br>
                            <code>/start connect-{{unique_encrypt($link->id)}}</code>
                        </li>
                        <li class="list-group-item">
                            Wait for the confirmation message from the bot.
                        </li>
                        <li class="list-group-item">
                            Status @if(!empty($link->chat_id))<div class="badge badge-success">Connected</div>@else<div class="badge">Not Connected yet!</div>@endif <a class="ml-1" href="{{route('system.connect.telegram.view')}}">Refresh</a>
                        </li>
                    </ol>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:void" onclick="reconnect('{{route('system.connect.telegram.reconnect')}}')" class="btn btn-primary btn-lg">
                            <i class="fa fa-reload me-2"></i>Revoke Current and Create New Connect ID
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center text-muted">
                    If you're having trouble, contact support or refresh the page.
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function reconnect(url) {
            swal({
        title: "Confirmation!",
        text: "Are you sure you want to proceed?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: false,
    }).then((res) => {
        if (res) {
  $.ajax({
                url:url,
                type: 'post',
                data: {'_token':'{{ csrf_token() }}'},
                success: function(response) {
                     swal("Success", response.message, "success");
                    if (response.code == 1) {
                      setTimeout(() => {
                        window.location.reload()
                      }, 2000);
                    } else if (response.code == 0) {
                        swal("Sorry!", response.message, "error");
                    } else {
                        swal("Sorry!", "Unexpected response", "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
        }})
}
</script>
@endsection
