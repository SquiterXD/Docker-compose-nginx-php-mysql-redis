<script type="text/javascript">
    $(document).ready(function() {
        $("#re-create-btn").click(async function( event ) {
            event.preventDefault();
            swal({
                html: true,
                title: 'เรียกข้อมูลประมาณการผลิตประจำปักษ์ใหม่',
                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการเรียกข้อมูลประมาณการผลิตประจำปักษ์ใหม่หรือไม่ ?</span></h2>',
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
            var url = $("#re-create-btn").attr("data-url");
            console.log(url)
            $.ajax({
                url: url,
                type: 'GET',
                // data: { period : period, coa : coa },
            })
            .done(function(res) {
                if(res.status == "S"){
                    swal({
                        title: 'เรียกข้อมูลประมาณการผลิตประจำปักษ์ใหม่',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการเรียกข้อมูลประมาณการผลิตประจำปักษ์ใหม่เรียบร้อยแล้ว </span>',
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