
            $(document).ready(function () {
            $("#menu-toggle").click(function (e) {
                e.preventDefault();
                $("#menu-content").slideToggle(300); // 300ms slide effect
            });
        });
    function alert_success_message(title,message)
    {
        $.notify({
                icon: 'flaticon-alarm-1',
                title: title,
                message: message,
            },{
                type: 'success',
                placement: {
                    from: "top",
                    align: "right"
                },
                time: 1000,
            });
    }
    function alert_success(message,title="Success!",icon="flaticon-alarm-1")
    {

        $.notify({
            icon: icon,
            title: title,
            message:message,
        },{
            type: 'success',
            placement: {
                from: "top",
                align: "right"
            },
            time: 1000,
        });
    }
    function alert_error(message,title="Success!",icon="flaticon-alarm-1")
    {

        $.notify({
            icon: icon,
            title: title,
            message:message,
        },{
            type: 'danger',
            placement: {
                from: "top",
                align: "right"
            },
            time: 1000,
        });
    }
     function see_key(id)
     {

        const input = document.getElementById('secret'+id);
            const icon = $("#secretToggleBtn" + id);
            if (input.type === 'password') {
                input.type = 'text';
                icon.removeClass('fa-eye');
                icon.addClass('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.removeClass('fa-eye-slash');
                icon.addClass('fa-eye');
            }
     }
 $(document).ready(function() {
        $('#myTableCustom').DataTable({
            "info": false,
            "paging": false // Disable pagination
        });
    });
    $(document).ready(function() {

        $('.js-example-basic-single').select2();
        $('.select2').select2();
    });

        $('#myTable').DataTable({
            "order": []
        })
        $('#myTable_export').DataTable({
            "order": [],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        })
        $('#myTable1').DataTable({
            "order": []
        })
        $('#myTable2').DataTable({
            "order": []
        })
        $('#myTable3').DataTable({
            "order": []
        })
