    <div class="modal fade" id="employee_card" data-backdrop="static" data-keyboard="false" tabindex="1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog  " role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
                                   <button type="button" class="close" data-dismiss="modal"
                                           aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>

                           @csrf
                           <div class="modal-body" >

                            <div id="employee_card_content"></div>

                           </div>



                           </div>
                       </div>
 </div>

 <script>
 function hr_hide_employee_card(element)
    {
      $("#employee_card").modal('show')

    }
    function hr_show_employee_card(element)
    {
         var user_id=$(element).data("user-id");
               $.ajax({
                url: "{{route('user.card')}}",
                type: 'post',
                data:{user_id:user_id,'_token':'{{csrf_token()}}'},
                success: function(response) {
                     $("#employee_card_content").empty()
                     $("#employee_card_content").html(response)
                     $("#employee_card").modal('show')
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



 </script>
