<script>


$(document).ready(function(){
    getAlerts()
})



   function alert_read_all(element)
   {
           $.ajax({
                        url: "{{route('app.alerts.read_all')}}",
                        type: 'post',
                        data:{'_token':'{{ csrf_token() }}'} ,
                        success: function(response) {
                          getAlerts()
                        },
                        error: function(xhr) {
                            let errorMessage = "Something went wrong.";
                            if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                                errorMessage = xhr.e.responseJSON.message;
                            }
                            swal("Error!", errorMessage, "error");
                        }
                    });
   }
   function alerts_set_as_ready(element)
   {
       id=$(element).data('alert-id')
       web_url=$(element).data('web-url')
       $.ajax({
                        url: "{{route('app.alerts.read')}}",
                        type: 'post',
                        data:{'_token':'{{ csrf_token() }}','alert_id':id} ,
                        success: function(response) {
                           if(response.code=='1')
                           {
                             window.location.href=web_url
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
   }
    function getAlerts() {
   $.ajax({
                url: "{{route('app.alerts.view')}}",
                type: 'get',
                data:{'_token':'{{ csrf_token() }}'} ,
                success: function(response) {
                    $("#alert_box").empty()
                    $("#alert_box").html(response)
                },
                error: function(xhr) {
                    let errorMessage = "Something went wrong.";
                    if (xhr.e.responseJSON && xhr.e.responseJSON.message) {
                        errorMessage = xhr.e.responseJSON.message;
                    }
                    swal("Error!", errorMessage, "error");
                }
            });
}
    window.addEventListener('globalAlert', function(e) {
        if(e.detail.alert.receiver=='{{auth()->user()->id}}')
        {
            getAlerts();
            $.notify({
            icon: 'flaticon-alarm-1',
            title:e.detail.alert.title,
            message:e.detail.alert.message,
            url: e.detail.alert.web_url,      // URL you want to open
            target: '_self'
        });
            const sound = document.getElementById('alert-sound');
            if (sound) {
                sound.play().catch(error => {
                    console.warn('Sound play failed:', error);
                });
            }
        }
    });
</script>
