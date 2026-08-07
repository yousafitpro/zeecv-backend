






<div class="modal fade" id="etransfer-details" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalLabel" >Available Methods</h5>
                <button  type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body"  >
                <div class="row">
                    <div class="col-md-12">
                        <div >
                            <div class="box-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-2">

                                            <img src="{{asset("icons/eft.PNG")}}" style="width:100%; min-width: 30px; max-width: 60px">

                                        </div>
                                        <div class="col-8" >
                                            <label style="font-weight: bold; margin-top: 5px"> Add funds using EFT</label><br>
                                            <small>Flat fee of 0.99 cents will apply.</small>

                                            {{--                                   <h6 class="pull-right" id="mainAccountsContainerLoader">Loading...</h6>--}}

                                        </div>
                                        <div class="col-2" >
                                            <a href="{{route('fund.addEFT')}}" class="btn btn-rounded">
                                                <span  class="fa fa-arrow-right" style="color: var(--primary); font-size: 25px"></span>
                                            </a>

                                        </div>
                                    </div><br>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <div class="box-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-2">

                                            <img src="{{asset("icons/credit.PNG")}}" style="width:100%; min-width: 30px; max-width: 60px">

                                        </div>
                                        <div class="col-8" >
                                            <label style="font-weight: bold; margin-top: 5px">  Add funds using cards</label><br>
                                            <small>3% merchant charge fee.</small>

                                            {{--                                   <h6 class="pull-right" id="mainAccountsContainerLoader">Loading...</h6>--}}

                                        </div>
                                        <div class="col-2" >


                                            <a href="{{route('fund.add')}}" class="btn btn-rounded ">
                                                <span  class="fa fa-arrow-right" style="color: var(--primary); font-size: 25px"></span>

                                            </a>

                                        </div>
                                    </div><br>

                                </div>
                            </div>
                        </div>
                    </div>

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
