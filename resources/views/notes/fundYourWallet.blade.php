






<div class="modal fade" id="fundYourWallet" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header" style="background-color: #E6C3C7">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white">Notification </h5>
                <button style="color: white" type="button"  data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="min-height: 300px; background-color: #E6C3C7" >

                <div style="position: absolute; width: 95%">
                    <img src="{{asset('images/notes/fundYourWallet.png')}}">

                </div>
                <div style="position: absolute; bottom: 40px; left: 20%">
                    <a href="/dashboard#AddFunds" onclick="CloseFundModal()" ><button class="btn btn-primary" >   <i class="ti-plus"></i> Add Funds</button></a>
                </div>
                <div style="position: absolute; width: 95%">
                    <h4 style="color: white; font-weight: bold">
                        Fund Your Wallet and Link Your Debit Visa or any other credit card.
                    </h4>

                </div>
            </div>
            {{--            <div class="modal-footer text-center">--}}
            {{--                <button type="button" class="btn btn-secondary"--}}
            {{--                        data-dismiss="modal"> Cancel--}}
            {{--                </button>--}}
            {{--                <button data-dismiss="modal" form="service-suggestion"--}}
            {{--                        class="btn btn-primary"> Ok--}}
            {{--                </button>--}}
            {{--            </div>--}}

        </div>
    </div>
</div>
<script>
    function CloseFundModal()
    {
        $("#fundYourWallet").modal("hide")
        $("#AddFunds").fadeOut("slow");
        $("#AddFunds").css('background-color','lightblue')
        $("#AddFunds").fadeIn("slow");
        setTimeout(function (){
            $("#AddFunds").css('background-color','white')
        },1000)

    }
</script>
@if(user_setting(auth()->user()->id)->is_membership_expired=='false' && userNotes(auth()->user()->id)->fundYourWallet=='false')

    <script>
         setTimeout(function (){

             $("#fundYourWallet").modal("show")
             <?php
             if (userNotes(auth()->user()->id)->fundYourWallet=='false')
             {
                 $note=userNotes(auth()->user()->id);
                 $note->fundYourWallet='true';
                 $note->save();
             }

             ?>
         },2000)
    </script>

    @endif
