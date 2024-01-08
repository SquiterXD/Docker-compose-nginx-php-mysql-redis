<script type="text/javascript">

    $(document).ready(function(){

        var requestId = null;
        var requestType = null;
        var formType = null;

        $("#btn_open_dff_header").click(function() {
            let requestId = $(this).attr('data-request-id');
            let requestType = $(this).attr('data-request-type');
            $('#modal-dff-header').modal('show');
            renderFormHeader(requestId, requestType)
        });

        function renderFormHeader(requestId, requestType){

            $.ajax({
                url: "{{ url('/') }}/ie/dff/get_form_header",
                type: 'GET',
                data: { requestId : requestId,
                        requestType : requestType },
                beforeSend: function( xhr ) {
                    $("#modal_content_dff_header").html('\
                        <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>');
                }
            })
            .done(function(result) {
                $("#modal_content_dff_header").html(result);
            });

        }

        $("[id^='btn_open_dff_line_']").click(function() {
            let requestId = $(this).attr('data-request-id');
            let requestType = $(this).attr('data-request-type');
            $('#modal-dff-line').modal('show');
            renderFormLine(requestId, requestType)
        });

        function renderFormLine(requestId, requestType){

            $.ajax({
                url: "{{ url('/') }}/ie/dff/get_form_line",
                type: 'GET',
                data: { requestId : requestId,
                        requestType : requestType },
                beforeSend: function( xhr ) {
                    $("#modal_content_dff_line").html('\
                        <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>');
                }
            })
            .done(function(result) {
                $("#modal_content_dff_line").html(result);
                // bindFormCreateReceiptEvent();
            });
            
        }

    });

</script>