






<div class="modal fade" id="mainLoader1" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" >
        <div class="modal-content">


            <div class="modal-body"  >
                <h4 style="text-align: center;color:gray">Please Wait...</h3>
                <br><br>
                <div style="width: 100%;" class="myFlex">
                    <img src="{{asset('loaders/loader1.gif')}}" style="width: 100px">
                </div>
                <br><br>
            </div>

        </div>
    </div>
</div>
<script>
    function show_loader(event){

        $("#mainLoader1").modal('show')
    }
</script>
