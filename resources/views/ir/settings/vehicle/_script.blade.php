<script type="text/javascript">
    $(document).ready(function() {
        $("#pull_btn").click(async function( event ) {
            event.preventDefault();
            swal({
                html: true,
                title: 'ดึงข้อมูลยานพาหนะ',
                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการดึงข้อมูลดึงข้อมูลยานพาหนะใหม่หรือไม่ ?</span></h2>',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                confirmButtonClass: 'btn btn-primary btn-lg tw-w-25',
                cancelButtonClass: 'btn btn-danger btn-lg tw-w-25',
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm, ){
                if (isConfirm) {
                    showFormRequest();
                }
            });
        });

        function showFormRequest()
        {
            var url = $("#pull_btn").attr("href");
            console.log(url);
            $.ajax({
                url: url,
                type: 'GET',
            })
            .done(function(res) {
                if(res.status == "S"){
                    swal({
                        title: 'ดึงข้อมูลยานพาหนะใหม่',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการดึงข้อมูลยานพาหนะใหม่เรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    window.location.reload();
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                }
            });
        }
    });
</script>