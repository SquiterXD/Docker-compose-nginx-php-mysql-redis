<script type="text/javascript">
    Dropzone.autoDiscover = false;

    $(document).ready(function(){

        var setCostCenter = false;
        var receiptType = "{{ $receiptType }}";
        var receiptParentId = "{{ $receiptParentId }}";
        var parentCurrencyId = "{{ $parentCurrencyId }}";
        var orgId = "{{ $parent->org_id }}";
        var canEdit = {{ $parent->canImportantEditData() }}

        // bindFormCreateReceiptEvent();
        bindEventReceiptRows();

    /////////////////////////////////////////////////////////////
    ////////////////// RECEIPT HEADER SCRIPT ////////////////////

        //////////////////////////
        //// RENDER CREATE RECEIPT
        $("#btn-create-receipt").click(function(){
            renderFormCreateReceipt();
        });

        //////////////////////////
        //// RENDER ALL RECEIPTS
        function renderReceiptRows(){

            $.ajax({
                url: "{{ url('/') }}/ie/receipts/get_rows",
                type: 'GET',
                data: { receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                        // parent_id = cash_advance_id or reimbursement_id
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#table_receipts tbody").html(result);
                bindEventReceiptRows();
                refreshTableTotalRows();
                refreshTotalAmount(receiptType);
                if(receiptType == 'CLEARING'){
                    refreshDiffCAAndClearingAmount();
                }
            });
        }

        /////////////////////////////
        // Refresh  TOTAL MOUNT
        function refreshTableTotalRows()
        {
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/get_table_total_rows",
                type: 'GET',
                data: { receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                        // parent_id = cash_advance_id or reimbursement_id
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#table_receipts_total_rows tbody").html(result);
            });
        }

        /////////////////////////////
        // REFRESH REIM AMOUNT
        function refreshTotalAmount(receiptType)
        {
            let  = '';
            if(receiptType == 'REIMBURSEMENT'){
                url = "{{ url('/') }}/ie/reimbursements/"+receiptParentId+"/get_total_amount";
            }else if(receiptType == 'CLEARING' || receiptType == 'CASH-ADVANCE'){
                url = "{{ url('/') }}/ie/cash-advances/"+receiptParentId+"/get_total_amount";
            }else if(receiptType == 'INVOICE'){
                url = "{{ url('/') }}/ie/invoices/"+receiptParentId+"/get_total_amount";
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: { receipt_type : receiptType },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#receipt_grand_total_amount,#receipt_grand_total_amount_compare").html(result);
            });
        }

        //////////////////////////////////////
        // REFRESH DIFF CA & CLEARING AMOUNT
        function refreshDiffCAAndClearingAmount()
        {
            $.ajax({
                url: "{{ url('/') }}/ie/cash-advances/"+receiptParentId+"/get_diff_ca_and_clearing_amount",
                type: 'GET',
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                $("#div_diff_ca_and_clearing_amount").html(result);
            });
        }

        ///////////////////////////////////
        //// BIND EVENT TABLE RECEIPT ROWS
        function bindEventReceiptRows(){

            $("#table_receipts .receipt-collapse-row").click(function(e){
                let icon = $(this).find("i");
                let receipt = $(this).attr('data-receipt');
                let tr = $("tr#tr_"+receipt);
                if (tr.is(':visible')) {
                    tr.addClass('animated fadeOutUp')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animated fadeOutUp').hide();
                    });
                    icon.removeClass('fa-caret-down');
                    icon.addClass('fa-caret-right');
                } else {
                    tr.show().addClass('animated fadeInDown')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animated fadeInDown');
                    });
                    icon.removeClass('fa-caret-right');
                    icon.addClass('fa-caret-down');
                }
                e.preventDefault();
            });

            // EDIT RECEIPT EVENT
            $("[id^='btn_edit_receipt_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                $("#modal_edit_receipt").modal('show');
                renderFormEditReceipt(receiptId);
            });

            // DUPLICATE RECEIPT EVENT
            $("[id^='btn_duplicate_receipt_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                swal({
                    html: true,
                    title: 'Copy receipt ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to copy this receipt ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, copy it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitDuplicateReceipt(receiptId);
                    }
                });
                event.preventDefault();
            });

            // REMOVE RECEIPT EVENT
            $("[id^='btn_remove_receipt_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                swal({
                    html: true,
                    title: 'Remove receipt ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this receipt ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitRemoveReceipt(receiptId);
                    }
                });
                event.preventDefault();
            });

            // EVENT SHOW COA RECEIPT LINE
            $("[id^='button_coa_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                // $("#modal_coa_receipt_line").modal('show');
                renderFormCOAReceiptLine(receiptId,receiptLineId);
            });

            // EVENT ADD RECEIPT LINE
            $("[id^='btn_add_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                $("#modal_create_receipt_line").modal('show');
                renderFormCreateReceiptLine(receiptId);
            });

            // EVENT SHOW RECEIPT LINE INFORMATIONS
            $("[id^='button_show_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                $("#modal_show_receipt_line").modal('show');
                renderShowReceiptLineInformations(receiptId,receiptLineId);
            });

            // EVENT EDIT RECEIPT LINE
            $("[id^='button_edit_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                $("#modal_edit_receipt_line").modal('show');
                renderFormEditReceiptLine(receiptId,receiptLineId);
            });

            // EVENT DUPLICATE RECEIPT LINE
            $("[id^='button_duplicate_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                swal({
                    html: true,
                    title: 'Copy receipt line ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to copy this receipt line ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, copy it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitDuplicateReceiptLine(receiptId,receiptLineId);
                    }
                });
                event.preventDefault();
            });

            // EVENT REMOVE RECEIPT LINE
            $("[id^='button_remove_receipt_line_']").click(function(){
                var receiptId = $(this).attr('data-receipt-id');
                var receiptLineId = $(this).attr('data-receipt-line-id');
                swal({
                    html: true,
                    title: 'Remove receipt line ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this receipt line ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitRemoveReceiptLine(receiptId,receiptLineId);
                    }
                });
                event.preventDefault();
            });

            $("[id^='btn_open_dff_line_']").click(function() {
                let requestId = $(this).attr('data-request-id');
                let requestType = $(this).attr('data-request-type');
                $('#modal-dff-line').modal('show');
                renderFormLine(requestId, requestType)
            });
        }

        ////////////////////////////////
        //// RENDER FORM CREATE RECEIPT
        function renderFormCreateReceipt(){

            $.ajax({
                url: "{{ url('/') }}/ie/receipts/form_create",
                type: 'GET',
                data: { receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_create_receipt").html('\
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
                $("#modal_content_create_receipt").html(result);
                bindFormCreateReceiptEvent();
            });

        }

        ////////////////////////////////
        //// RENDER FORM EDIT RECEIPT
        function renderFormEditReceipt(receiptId){

            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/form_edit",
                type: 'GET',
                data: { receipt_id : receiptId,
                        receipt_type : receiptType,
                        receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_edit_receipt").html('\
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
                $("#modal_content_edit_receipt").html(result);
                bindFormEditReceiptEvent(receiptId);
            });

        }

        ////////////////////////////////////////
        //// BIND EVENT TO FORM CREATE RECEIPT
        function bindFormCreateReceiptEvent(){

            if(receiptType == 'REIMBURSEMENT'){
                showOracleVendorDetail("#form-create-receipt");
            }

            showOtherVendorForm("#form-create-receipt");

            $('#form-create-receipt select[name="vendor_id"]').change(function(e){
                var selectValue = $(this);
                if (selectValue.val() != '') {
                    showOtherVendorForm("#form-create-receipt");
                    if(selectValue.val() != 'other'){
                        getVendorSites("#form-create-receipt");
                        $('#form-create-receipt').find('#span_vendor_site_code_required').removeClass('d-none');
                    }else{
                        clearVendorDetail('#form-create-receipt');
                        $('#form-create-receipt').find('#ddl_vendor_site_code').html('').select2({data: [{id: '', text: '-'}]}).attr('disabled','');
                        $('#form-create-receipt').find('#span_vendor_site_code_required').addClass('d-none');
                    }
                }else {
                    clearVendorDetail('#form-create-receipt');
                    showOtherVendorForm("#form-create-receipt");
                    $('#form-create-receipt').find('#ddl_vendor_site_code').html('').select2({data: [{id: '', text: '-'}]}).attr('disabled','');
                    $('#form-create-receipt').find('#span_vendor_site_code_required').addClass('d-none');
                }
            });

            $('#form-create-receipt select[name="vendor_site_code"]').change(function(e){
                showOracleVendorDetail("#form-create-receipt");
            });

            $("#form-create-receipt").find(".select2").select2();

            /// BTN SUBMIT CREATE
            $("#btn_submit_create_receipt").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitReceipt('create');
                if(valid){
                    $(this).attr('disabled','disabled');
                    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Loading...`);
                    
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else {
                        // $("#form-create-receipt").submit();
                        submitFormCreateReceipt();
                    }
                }
            });

            ////////////////////////////////////////////
            //// SUBMIT ADD RECEIPT WITH ATTACHMENT (DROPZONE)
            var token = "{{ csrf_token() }}";
            var myDropzone = new Dropzone("div#dropzoneReceiptAttachment", {
                previewTemplate: $('#template-container').html(),
                url: "{{ url('/') }}/ie/receipts/store",
                params: {
                   _token: token
                },
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 2,
                maxFilesize: 5, // MB
                acceptedFiles: '.jpg, .jpeg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .7z, .txt',
                // Dropzone settings
                init: function() {
                    var myDropzone = this;
                    this.on("maxfilesexceeded", function(file) {
                        toastr.options = {
                            "timeOut": "3000",
                        }
                        toastr.error(file.name + ' upload failed.');
                    });
                    this.on('error', function(file, response) {
                        this.removeFile(file);
                        toastr.options = {
                            "timeOut": "3000",
                        }
                        toastr.error(response);
                    });
                    this.on('queuecomplete', function(){
                        $("#btn_submit_create_receipt").button('reset');
                        // renderFormCreateReceipt();
                        renderReceiptRows();
                        $("#modal_create_receipt").modal('hide');
                    });
                }
            });
            myDropzone.on('sending', function(file, xhr, formData){

                formData.append('receipt_type', $("input[name='receipt_type']").val());
                formData.append('receipt_parent_id', $("input[name='receipt_parent_id']").val());
                formData.append('receipt_number', $("input[name='receipt_number']").val());
                formData.append('receipt_date', $("input[name='receipt_date']").val());
                formData.append('employee_id', $("select[name='employee_id']  option:selected").val());
                // formData.append('location_id', $("select[name='location_id'] option:selected").val());
                // formData.append('currency_id', $("select[name='currency_id'] option:selected").val());
                // formData.append('exchange_rate', $("input[name='exchange_rate']").val());
                // if(receiptType == 'REIMBURSEMENT' || receiptType == 'CLEARING'){
                    // formData.append('establishment_id', $("select[name='establishment_id'] option:selected").val());
                    formData.append('vendor_id', $("select[name='vendor_id'] option:selected").val());
                    formData.append('vendor_site_code', $("select[name='vendor_site_code'] option:selected").val());
                    formData.append('vendor_tax_address', $("input[name='vendor_tax_address']").val());
                    formData.append('vendor_name', $("input[name='vendor_name']").val());
                    formData.append('vendor_tax_id', $("input[name='vendor_tax_id']").val());
                    formData.append('vendor_branch_name', $("input[name='vendor_branch_name']").val());
                // }
                formData.append('jusification', $("textArea[name='jusification']").val());
                formData.append('project', $("select[name='project']  option:selected").val());
                formData.append('job', $("input[name='job']").val());
                formData.append('recharge', $("select[name='recharge'] option:selected").val());

            });
            myDropzone.on("success", function(file, result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                    $("#modal_create_receipt").modal('hide');
                }else{
                    if(result.receiptId){
                        receiptId = result.receiptId;
                        // AUTO SHOW RECEIPT LINE CREATE FORM
                        $("#modal_create_receipt").modal('hide');
                        $('#modal_create_receipt').on('hidden.bs.modal', function () {
                            // AUTO SHOW RECEIPT LINE CREATE FORM
                            $("#modal_create_receipt_line").modal('show');
                            $('#modal_create_receipt').off('hidden.bs.modal');
                        })
                        renderFormCreateReceiptLine(receiptId);
                        // RENDOR RECEIPT TABLE ROWS
                        renderReceiptRows();
                    }
                }
            });

            $('#form-create-receipt #txt_receipt_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT CREATE RECEIPT WITH OUT ATTACHMENT
        function submitFormCreateReceipt(){
            var formData = $('#form-create-receipt').serialize();
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/store",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                    $("#modal_create_receipt").modal('hide');
                }else{
                    receiptId = result.receiptId;
                    $("#modal_create_receipt").modal('hide');
                    $('#modal_create_receipt').on('hidden.bs.modal', function () {
                        // AUTO SHOW RECEIPT LINE CREATE FORM
                        $("#modal_create_receipt_line").modal('show');
                        $('#modal_create_receipt').off('hidden.bs.modal');
                    });
                    renderFormCreateReceiptLine(receiptId);
                    // RENDOR RECEIPT TABLE ROWS
                    renderReceiptRows();
                }
                // renderFormCreateReceipt();
            });
        }

        ////////////////////////////////////////
        //// BIND EVENT TO FORM EDIT RECEIPT
        function bindFormEditReceiptEvent(receiptId){

            // showOracleVendorDetail("#form-edit-receipt");
            showOtherVendorForm("#form-edit-receipt");

            $('#form-edit-receipt select[name="vendor_id"]').change(function(e){
                var selectValue = $(this);
                if (selectValue.val() != '') {
                    showOtherVendorForm("#form-edit-receipt");
                    if(selectValue.val() != 'other'){
                        getVendorSites("#form-edit-receipt");
                        $('#form-edit-receipt').find('#span_vendor_site_code_required').removeClass('d-none');
                    }else{
                        clearVendorDetail("#form-edit-receipt");
                        $('#form-edit-receipt').find('#ddl_vendor_site_code').html('').select2({data: [{id: '', text: '-'}]}).attr('disabled','');
                        $('#form-edit-receipt').find('#span_vendor_site_code_required').addClass('d-none');
                    }
                }else {
                    clearVendorDetail("#form-edit-receipt");
                    showOtherVendorForm("#form-edit-receipt");
                    $('#form-edit-receipt').find('#ddl_vendor_site_code').html('').select2({data: [{id: '', text: '-'}]}).attr('disabled','');
                    $('#form-edit-receipt').find('#span_vendor_site_code_required').addClass('d-none');
                }
            });

            $('#form-edit-receipt select[name="vendor_site_code"]').change(function(e){
                showOracleVendorDetail("#form-edit-receipt");
            });

            $("#form-edit-receipt").find(".select2").select2();
            $("#form-edit-receipt").find("select[name='employee_id']").prop("disabled", !canEdit);

            /// BTN SUBMIT EDIT
            $("#btn_submit_edit_receipt").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitReceipt('edit');
                if(valid){
                    if( document.getElementById("inputReceiptAttachment").files.length != 0 ){
                        $("#form-add-receipt-attachment").submit();
                    }
                    $(this).attr('disabled','disabled');
                    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Loading...`);
                    submitFormEditReceipt(receiptId);
                }
            });

            // ADD ATTACHMENT
            $("#inputReceiptAttachment").change(function(){
                if(this.value){
                    let filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                    $("#receiptAttachmentDescText").text(filename);
                    $("#receiptAttachmentDesc").removeClass("d-none");
                    $("#btnAddReceiptFile").addClass("d-none");
                }else{
                    $("#receiptAttachmentDescText").text("");
                    $("#receiptAttachmentDesc").addClass("d-none");
                    $("#btnAddReceiptFile").removeClass("d-none");
                }
            });

            // UPLOAD ATTACHMENT
            $("#btnUploadReceiptFile").click(function(){
                $("#form-add-receipt-attachment").submit();
            });

            // CANCEL ATTACHMENT
            $("#btnCancelReceiptFile").click(function(){
                $("#inputReceiptAttachment").val('');
                $("#receiptAttachmentDescText").text("");
                $("#receiptAttachmentDesc").addClass("d-none");
                $("#btnAddReceiptFile").removeClass("d-none");
            });

            ////////////////////////////////////////////
            //// SUBMIT ADD RECEIPT ATTACHMENT
            $("#form-add-receipt-attachment").submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);
                var receiptId = $(this).find("input[name='receipt_id']").val();
                $.ajax({
                    url: "{{ url('/') }}/ie/receipts/"+receiptId+"/add_attachment",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    beforeSend: function(){
                        $("#btnUploadReceiptFile").button('loading');
                        $("#btnCancelReceiptFile").attr('disabled','disabled');
                    }
                })
                .done(function(result) {
                    if(result.toUpperCase() != 'SUCCESS'){
                        swal({
                          title: "Error !",
                          text: "sorry something went wrong.",
                          type: "error",
                          // timer: 2000,
                          showConfirmButton: true
                        });
                    }else{
                        renderReceiptRows();
                    }
                    renderFormEditReceipt(receiptId);
                });
                return false;
            });

            // BTN REMOVE ATTACHMENT
            $("[id^='btn_remove_receipt_attachment_']").click(function(e) {
                var receiptId = $(this).attr('data-receipt-id');
                var attachmentId = $(this).attr('data-attachment-id');
                swal({
                    html: true,
                    title: 'Remove attachment ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this attachment ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        submitRemoveReceiptAttachment(receiptId,attachmentId);
                    }
                });
                event.preventDefault();
            });

            $('#form-edit-receipt #txt_receipt_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT EDIT RECEIPT WITH OUT ATTACHMENT
        function submitFormEditReceipt(receiptId)
        {
            var formData = $('#form-edit-receipt').serialize();
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/update",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    swal({
                      title: "Error !",
                      text: result.err_msg,
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                }
                // renderFormEditReceipt(receiptId);
                $("#modal_edit_receipt").modal('hide');
            });
        }

        ///////////////////////////////////
        //// SUBMIT DUPLICATE RECEIPT
        function submitDuplicateReceipt(receiptId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/duplicate",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}",
                        receipt_parent_id: receiptParentId,
                        receipt_type: receiptType },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        ///////////////////////////////////
        //// SUBMIT REMOVE RECEIPT
        function submitRemoveReceipt(receiptId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/remove",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT REMOVE RECEIPT ATTACHMENT
        function submitRemoveReceiptAttachment(receiptId,attachmentId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/attachments/"+attachmentId+"/remove",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
                renderFormEditReceipt(receiptId);
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT DUPLICATE RECEIPT LINE
        function submitDuplicateReceiptLine(receiptId,receiptLineId){
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/duplicate",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        ////////////////////////////////////////////
        //// SUBMIT REMOVE RECEIPT LINE
        function submitRemoveReceiptLine(receiptId,receiptLineId){
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/remove",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if(result.toUpperCase() != 'SUCCESS'){
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong.",
                      type: "error",
                      // timer: 2000,
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                    swal.close();
                }
            });
        }

        //////////////////////////////////
        //// VALIDATE BEFORE SUBMIT RECEIPT
        function validateBeforeSubmitReceipt(formType)
        {
            if(formType == 'create'){
                var formId = "#form-create-receipt";
            }else{
                var formId = "#form-edit-receipt";
            }

            $(formId).find("input[name='receipt_number']").next("div.error_msg").remove();
            $(formId).find("input[name='receipt_date']").next("div.error_msg").remove();
            // if(formType == 'create'){
                // $(formId).find("#select2-ddl_location_id-container").parent().next("div.error_msg").remove();
                // $(formId).find("select[name='currency_id']").next("div.error_msg").remove();
                // $(formId).find("input[name='exchange_rate']").next("div.error_msg").remove();
            // }
            // $(formId).find("select[name='establishment_id']").next("div.error_msg").remove();
            $(formId).find("#select2-ddl_vendor_id-container").parent().next("div.error_msg").remove();
            $(formId).find("#select2-ddl_vendor_site_code-container").parent().next("div.error_msg").remove();
            // $(formId).find("input[name='vendor_tax_address']").next("div.error_msg").remove();
            $(formId).find("input[name='vendor_name']").next("div.error_msg").remove();
            // $(formId).find("input[name='vendor_tax_id']").next("div.error_msg").remove();
            // $(formId).find("input[name='vendor_branch_name']").next("div.error_msg").remove();
            // $(formId).find("textArea[name='jusification']").next("div.error_msg").remove();
            $(formId).find("#select2-ddl_project-container").parent().next("div.error_msg").remove();
            $(formId).find("input[name='job']").next("div.error_msg").remove();
            $(formId).find("#select2-ddl_recharge-container").parent().next("div.error_msg").remove();

            $(formId).find("input[name='receipt_number']").removeClass('err_validate');
            $(formId).find("input[name='receipt_date']").removeClass('err_validate');
            if(formType == 'create'){
                // $(formId).find("select[name='currency_id']").removeClass('err_validate');
                // $(formId).find("input[name='exchange_rate']").removeClass('err_validate');
            }
            // $(formId).find("select[name='establishment_id']").removeClass('err_validate');
            $(formId).find("input[name='vendor_name']").removeClass('err_validate');
            // $(formId).find("input[name='vendor_tax_address']").removeClass('err_validate');
            // $(formId).find("input[name='vendor_tax_id']").removeClass('err_validate');
            // $(formId).find("input[name='vendor_branch_name']").removeClass('err_validate');
            // $(formId).find("textArea[name='jusification']").removeClass('err_validate');
            $(formId).find("input[name='job']").removeClass('err_validate');

            var valid = true;
            var receipt_number = $(formId).find("input[name='receipt_number']").val();
            var receipt_date = $(formId).find("input[name='receipt_date']").val();
            // if(formType == 'create'){
                // var location_id = $(formId).find("select[name='location_id'] option:selected").val();
                // var currency_id = $(formId).find("select[name='currency_id'] option:selected").val();
                // var exchange_rate = $(formId).find("input[name='exchange_rate']").val();
            // }
            // var establishment_id = $(formId).find("select[name='establishment_id'] option:selected").val();
            var vendor_tax_address = $(formId).find("input[name='vendor_tax_address']").val();
            var vendor_id = $(formId).find("select[name='vendor_id'] option:selected").val();
            var vendor_site_code = $(formId).find("select[name='vendor_site_code'] option:selected").val();
            var vendor_name = $(formId).find("input[name='vendor_name']").val();
            var vendor_tax_id = $(formId).find("input[name='vendor_tax_id']").val();
            var vendor_branch_name = $(formId).find("input[name='vendor_branch_name']").val();
            // var jusification = $(formId).find("textArea[name='jusification']").val();
            var project = $(formId).find("select[name='project']  option:selected").val();
            var job = $(formId).find("input[name='job']").val();
            var recharge = $(formId).find("select[name='recharge'] option:selected").val();

            // if(!receipt_number && !['CASH-ADVANCE', 'REIMBURSEMENT'].includes(receiptType)){
            //     valid = false;
            //     $(formId).find("input[name='receipt_number']").addClass('err_validate');
            //     $(formId).find("input[name='receipt_number']").after('<div class="error_msg"> tax invoice/receipt number is required. </div>');
            // }
            if(!receipt_number){
                valid = false;
                $(formId).find("input[name='receipt_number']").addClass('err_validate');
                $(formId).find("input[name='receipt_number']").after('<div class="error_msg"> tax invoice/receipt number is required. </div>');
            }
            // if(!receipt_date && !['CASH-ADVANCE', 'REIMBURSEMENT'].includes(receiptType)){
            //     valid = false;
            //     $(formId).find("input[name='receipt_date']").addClass('err_validate');
            //     $(formId).find("input[name='receipt_date']").after('<div class="error_msg"> date is required.</div>');
            // }
            // if(formType == 'create'){
                // if(!location_id){
                //     valid = false;
                //     $(formId).find("#select2-ddl_location_id-container").parent().after('<div class="error_msg"> destination is required. </div>');
                // }
                // if(currency_id != parentCurrencyId){
                //     if(exchange_rate == ''){
                //         valid = false;
                //         $(formId).find("input[name='exchange_rate']").addClass('err_validate');
                //         $(formId).find("input[name='exchange_rate']").after('<div class="error_msg"> exchange rate is required.</div>');
                //     }else if(!$.isNumeric(exchange_rate)){
                //         valid = false;
                //         $(formId).find("input[name='exchange_rate']").addClass('err_validate');
                //         $(formId).find("input[name='exchange_rate']").after('<div class="error_msg"> exchange rate must be a number.</div>');
                //     }
                // }
            // }

            // USE ONLY REIMBURSEMENT && CLEARING
            // if(receiptType == 'REIMBURSEMENT' || receiptType == 'CLEARING'){

                // if(!establishment_id){
                //     valid = false;
                //     $(formId).find("select[name='establishment_id']").addClass('err_validate');
                //     $(formId).find("select[name='establishment_id']").after('<div class="error_msg"> tmith branch is required.</div>');
                // }

                if(!vendor_id && !['CASH-ADVANCE'].includes(receiptType)){
                    valid = false;
                    $(formId).find("#select2-ddl_vendor_id-container").parent().after('<div class="error_msg"> vendor is required. </div>');
                }
                if(vendor_id == 'other'){
                    if(!vendor_name){
                        valid = false;
                        $(formId).find("input[name='vendor_name']").addClass('err_validate');
                        $(formId).find("input[name='vendor_name']").after('<div class="error_msg"> vendor name is required.</div>');
                    }
                    // if(!vendor_tax_address){
                    //     valid = false;
                    //     $(formId).find("input[name='vendor_tax_address']").addClass('err_validate');
                    //     $(formId).find("input[name='vendor_tax_address']").after('<div class="error_msg"> address is required.</div>');
                    // }
                    // if(!vendor_tax_id){
                    //     valid = false;
                    //     $(formId).find("input[name='vendor_tax_id']").addClass('err_validate');
                    //     $(formId).find("input[name='vendor_tax_id']").after('<div class="error_msg"> tax id is required.</div>');
                    // }else{
                        if(vendor_tax_id.length != 13){
                            valid = false;
                            $(formId).find("input[name='vendor_tax_id']").addClass('err_validate');
                            $(formId).find("input[name='vendor_tax_id']").after('<div class="error_msg"> tax id must be 13 digits.</div>');
                        }
                    // }
                    // if(!vendor_branch_name){
                    //     valid = false;
                    //     $(formId).find("input[name='vendor_branch_name']").addClass('err_validate');
                    //     $(formId).find("input[name='vendor_branch_name']").after('<div class="error_msg"> branch number is required.</div>');
                    // }else{
                    //     if(vendor_branch_name.length > 5){
                    //         valid = false;
                    //         $(formId).find("input[name='vendor_branch_name']").addClass('err_validate');
                    //         $(formId).find("input[name='vendor_branch_name']").after('<div class="error_msg"> branch number maximum is 5 digits.</div>');
                    //     }
                    // }
                }else {
                    if(!vendor_site_code && !['CASH-ADVANCE'].includes(receiptType)){
                        valid = false;
                        $(formId).find("#select2-ddl_vendor_site_code-container").parent().after('<div class="error_msg"> vendor site is required. </div>');
                    }
                }
            // }

            // if(!jusification){
            //     valid = false;
            //     $(formId).find("textArea[name='jusification']").addClass('err_validate');
            //     $(formId).find("textArea[name='jusification']").after('<div class="error_msg"> description is required.</div>');
            // }
            // if(!project){
            //     valid = false;
            //     $(formId).find("#select2-ddl_project-container").parent().after('<div class="error_msg"> project is required.</div>');
            // }
            // if(!job){
            //     valid = false;
            //     $(formId).find("input[name='job']").addClass('err_validate');
            //     $(formId).find("input[name='job']").after('<div class="error_msg"> job is required.</div>');
            // }
            // if(!recharge){
            //     valid = false;
            //     $(formId).find("#select2-ddl_recharge-container").parent().after('<div class="error_msg"> recharge is required.</div>');
            // }

            return valid;
        }

        function showOracleVendorDetail(formId)
        {
            // USE ONLY REIMBURSEMENT && CLEARING
            // if(receiptType == 'REIMBURSEMENT' || receiptType == 'CLEARING'){

                var vendorId =  $(formId).find('select[name="vendor_id"] option:selected');
                var vendorSiteCode = $(formId).find('select[name="vendor_site_code"] option:selected');
                var divOracleVendorDetail = $(formId).find('#div_oracle_vendor_detail');

                if (vendorId.val() != '' && vendorId.val() != 'other' && vendorSiteCode.val() != '') {
                    divOracleVendorDetail.fadeIn('slow');
                    $.ajax({
                        url: "{{ url('/') }}/ie/receipts/get_vendor_detail/"+vendorId.val()+"/site/"+vendorSiteCode.val(),
                        type: 'GET',
                        beforeSend: function( xhr ) {
                            //
                        }
                    })
                    .done(function(result) {
                        // divOracleVendorDetail.html(result);
                        $(formId).find('#txt_vendor_tax_id').val(result.taxId);
                        $(formId).find('#txt_vendor_branch_name').val(result.branchNumber);
                        $(formId).find('#txt_vendor_tax_address').val(result.taxAddress);
                    });

                } else {
                    // divOracleVendorDetail.fadeOut('slow');
                    // divOracleVendorDetail.html('');
                    clearVendorDetail(formId);
                }

            // }
        }

        function clearVendorDetail(formId)
        {
            $(formId).find('#txt_vendor_name').val('');
            $(formId).find('#txt_vendor_tax_id').val('');
            $(formId).find('#txt_vendor_branch_name').val('');
            $(formId).find('#txt_vendor_tax_address').val('');
        }

        function showOtherVendorForm(formId) {
            var selectValue =  $(formId).find('select[name="vendor_id"] option:selected');
            var tagShowOtherVendor = $(formId).find('#showOtherVendor');

            if (selectValue.val() == 'other') {
                tagShowOtherVendor.fadeIn('slow');
            } else {
                tagShowOtherVendor.fadeOut('slow');
            }
        }

        function getVendorSites(formId)
        {
            var vendorId =  $(formId).find('select[name="vendor_id"] option:selected');
            var divVendorSites = $(formId).find('#div_vendor_sites');

            $.ajax({
                url: "{{ url('/') }}/ie/receipts/get_vendor_sites/"+vendorId.val(),
                type: 'GET',
                beforeSend: function( xhr ) {
                    $(formId).find('select[name="vendor_site_code"]').attr('disabled','disabled');
                }
            })
            .done(function(result) {
                divVendorSites.html(result);
            }).then(()=>{
                $(formId).find('select[name="vendor_site_code"]').select2();
                showOracleVendorDetail(formId);
            });
        }

        ///////////////////////////////////////////////////////////
        ////////////////// RECEIPT LINE SCRIPT ////////////////////

        /////////////////////////////////////
        //// RENDER FORM CREATE RECEIPT LINE
        function renderFormCreateReceiptLine(receiptId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/form_create",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_create_receipt_line").html('\
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
                $("#modal_content_create_receipt_line").html(result);
                bindFormCreateReceiptLineEvent(receiptId);
            });
        }

        /////////////////////////////////////
        //// RENDER FORM EDIT RECEIPT LINE
        function renderFormEditReceiptLine(receiptId, receiptLineId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/form_edit",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_edit_receipt_line").html('\
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
                $("#modal_content_edit_receipt_line").html(result);
                bindFormEditReceiptLineEvent(receiptId, receiptLineId);
            });
        }

         ////////////////////////////////
        //// RENDER FORM COA RECEIPT LINE
        function renderFormCOAReceiptLine(receiptId,receiptLineId){

            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/form_coa",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_coa_receipt_line").html('\
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
                let formId = '#modal_coa_receipt_line';
                $("#modal_content_coa_receipt_line").html(result);
                $(formId).find(".select2").select2();
                $(formId).find("#submit_adjust_account").attr('disabled','');
                bindEventReceiptLineCoa(receiptId,receiptLineId);
            });

        }

        function bindEventReceiptLineCoa(receiptId,receiptLineId)
        {
            var defaultSubAccountCode = '';
            var defaultSubAccountCode = '';
            var defaultSubAccountCode = '';
            var setSubAccount = false;
            var setSubAccount = false;
            var setSubAccount = false;

            function getInputCostCenterCode(departmentCode,costCenterCode){
                let formId = '#modal_coa_receipt_line';
                $.ajax({
                    url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/input_cost_center_code",
                    type: 'GET',
                    data: { department_code : departmentCode,
                            cost_center_code : costCenterCode },
                    beforeSend: function( xhr ) {
                        $(formId).find("#txt_cost_center_code").attr('disabled','disabled');
                        $(formId).find('#submit_adjust_account').prop('disabled', true);
                    }
                })
                .done(function(result) {
                    $(formId).find("#div_ddl_cost_center_code").html(result);
                    $(formId).find('#submit_adjust_account').prop('disabled', false);
                    setCostCenter = false;
                });
            }

            function getInputBudgetDetailCode(budgetTypeCode,budgetDetailCode){
                let formId = '#modal_coa_receipt_line';
                $.ajax({
                    url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/input_budget_detail_code",
                    type: 'GET',
                    data: { budget_type_code : budgetTypeCode,
                            budget_detail_code : budgetDetailCode },
                    beforeSend: function( xhr ) {
                        $(formId).find("#txt_budget_detail_code").attr('disabled','disabled');
                        $(formId).find('#submit_adjust_account').prop('disabled', true);
                    }
                })
                .done(function(result) {
                    $(formId).find("#div_ddl_budget_detail_code").html(result);
                    $(formId).find('#submit_adjust_account').prop('disabled', false);
                    setBudgetDetail = false;
                });
            }

            function getInputSubAccountCode(accountCode,subAccountCode){
                let formId = '#modal_coa_receipt_line';
                $.ajax({
                    url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/input_sub_account_code",
                    type: 'GET',
                    data: { account_code : accountCode,
                            sub_account_code : subAccountCode },
                    beforeSend: function( xhr ) {
                        $(formId).find("#txt_sub_account_code").attr('disabled','disabled');
                        $(formId).find('#submit_adjust_account').prop('disabled', true);
                    }
                })
                .done(function(result) {
                    $(formId).find("#div_ddl_sub_account_code").html(result);
                    $(formId).find('#submit_adjust_account').prop('disabled', false);
                    setSubAccount = false;
                });
            }

            $("#modal_coa_receipt_line").find("#submit_adjust_account").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                submitAdjustAccount($(this));
            });

            function submitAdjustAccount(form)
            {
                let combinationCode = $("#modal_coa_receipt_line").find('#txt_set_code_combination').val();
                $.ajax({
                    url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/validate_combination",
                    type: 'GET',
                    data: { combination_code : combinationCode },
                    beforeSend: function( xhr ) {
                        disableForm();
                        $('#modal_coa_receipt_line').find('#submit_adjust_account').prop('disabled', true);
                    },
                    error: function(thrownError){
                        enableFormCOA();
                        let formId = "#modal_coa_receipt_line";
                        $(formId).find('#txt_set_code_combination').addClass('err_validate');
                        $(formId).find('#list-msg').append('<li>'+thrownError.responseJSON.message+'</li>');
                        $(formId).find('#div_show_error_msg').removeClass('d-none');
                    },
                })
                .done(function(result) {
                    enableFormCOA();
                    let formId = "#modal_coa_receipt_line";
                    $(formId).find('#submit_adjust_account').prop('disabled', false);
                    if(result.status != 'P'){
                        showErrorMsg(result.error_lists);
                    }else {
                        $('#form-adjust-coa-receipt-line').submit();
                    }
                });
            }

            $("#modal_coa_receipt_line").find('#txt_set_code_combination').change(function(e){
                e.preventDefault();

                hideErrorMsg();
                validateCombination();
            });

            function validateCombination(){
                let formId = "#modal_coa_receipt_line";
                let combinationCode = $(formId).find('#txt_set_code_combination').val();
                console.log();
                $.ajax({
                    url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/validate_combination",
                    type: 'GET',
                    data: { combination_code : combinationCode },
                    beforeSend: function( xhr ) {
                        disableForm();
                        $('#modal_coa_receipt_line').find('#submit_adjust_account').prop('disabled', true);
                    },
                    error: function(thrownError){
                        enableFormCOA();
                        $(formId).find('#txt_set_code_combination').addClass('err_validate');
                        $(formId).find('#list-msg').append('<li>'+thrownError.responseJSON.message+'</li>');
                        $(formId).find('#div_show_error_msg').removeClass('d-none');
                    },
                })
                .done(function(result) {
                    enableFormCOA();
                    $(formId).find('#submit_adjust_account').prop('disabled', false);
                    if(result.status != 'P'){
                        showErrorMsg(result.error_lists);
                    }else {
                        var combination = $(formId).find('#txt_set_code_combination').val().split('.');
                        setSelectOption(combination);
                    }
                });
            }

            function setSelectOption(combination){

                let formId = "#modal_coa_receipt_line";
                let companyCode = combination[0];
                let evmCode = combination[1];
                let departmentCode = combination[2];
                let costCenterCode = combination[3];

                let budgetYearCode = combination[4];
                let budgetTypeCode = combination[5];
                let budgetDetailCode = combination[6];
                let budgetReasonCode = combination[7];

                let accountCode = combination[8];
                let subAccountCode = combination[9];
                let reserve1Code = combination[10];
                let reserve2Code = combination[11];

                let company = $(formId).find("#txt_company_code");
                if(company.val() != companyCode){
                    company.val(companyCode).trigger('change');
                }
                let evm = $(formId).find("#txt_evm_code");
                if(evm.val() != evmCode){
                    evm.val(evmCode).trigger('change');
                }
                let department = $(formId).find("#txt_department_code");
                if(department.val() != departmentCode){
                    defaultCostCenterCode = costCenterCode;
                    setCostCenter = true;
                    department.val(departmentCode).trigger('change');
                }else {
                    let cost = $(formId).find("#txt_cost_center_code");
                    if(cost.val() != costCenterCode){
                        cost.val(costCenterCode).trigger('change');
                    }
                }

                let bgYear = $(formId).find("#txt_budget_year_code");
                if(bgYear.val() != budgetYearCode){
                    bgYear.val(budgetYearCode).trigger('change');
                }
                let bgType = $(formId).find("#txt_budget_type_code");
                if(bgType.val() != budgetTypeCode){
                    defaultBudgetDetailCode = budgetDetailCode;
                    setBudgetDetail = true;
                    bgType.val(budgetTypeCode).trigger('change');
                }else {
                    let bgDetail = $(formId).find("#txt_budget_detail_code");
                    if(bgDetail.val() != budgetDetailCode){
                        bgDetail.val(budgetDetailCode).trigger('change');
                    }
                }
                let bgReason = $(formId).find("#txt_budget_reason_code");
                if(bgReason.val() != budgetReasonCode){
                    bgReason.val(budgetReasonCode).trigger('change');
                }
                
                let acc = $(formId).find("#txt_account_code");
                if(acc.val() != accountCode){
                    defaultSubAccountCode = subAccountCode;
                    setSubAccount = true;
                    acc.val(accountCode).trigger('change');
                }else {
                    let sub = $(formId).find("#txt_sub_account_code");
                    if(sub.val() != subAccountCode){
                        sub.val(subAccountCode).trigger('change');
                    }
                }
                let reserv1 = $(formId).find("#txt_reserve1_code");
                if(reserv1.val() != reserve1Code){
                    reserv1.val(reserve1Code).trigger('change');
                }
                let reserv2 = $(formId).find("#txt_reserve2_code");
                if(reserv2.val() != reserve2Code){
                    reserv2.val(reserve2Code).trigger('change');
                }
            }

            $("#modal_coa_receipt_line").find("#txt_company_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(0, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_evm_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(1, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_department_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(2, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_department_code").on('change', function(e){
                e.preventDefault();
                setShowCombine(2, $(this).val());
                setShowCombine(3, setCostCenter ? defaultCostCenterCode : '00');
                var departmentCode = $("#txt_department_code").val();
                getInputCostCenterCode(departmentCode, setCostCenter ? defaultCostCenterCode : '00');
            });
            $("#modal_coa_receipt_line").find("#txt_cost_center_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(3, $(this).val());
            });

            $("#modal_coa_receipt_line").find("#txt_budget_year_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(4, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_budget_type_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(5, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_budget_type_code").on('change', function(e){
                e.preventDefault();
                setShowCombine(5, $(this).val());
                setShowCombine(6, setBudgetDetail ? defaultBudgetDetailCode : '000000');
                var budgetTypeCode = $("#txt_budget_type_code").val();
                getInputBudgetDetailCode(budgetTypeCode, setBudgetDetail ? defaultBudgetDetailCode : '000000');
            });
            $("#modal_coa_receipt_line").find("#txt_budget_detail_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(6, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_budget_reason_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(7, $(this).val());
            });
            
            $("#modal_coa_receipt_line").find("#txt_account_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(8, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_account_code").on('change', function(e){
                e.preventDefault();
                setShowCombine(8, $(this).val());
                setShowCombine(9, setSubAccount ? defaultSubAccountCode : '000');
                let accountCode = $("#modal_coa_receipt_line").find("#txt_account_code").val();
                getInputSubAccountCode(accountCode, setSubAccount ? defaultSubAccountCode : '000');
            });
            $("#modal_coa_receipt_line").find("#txt_sub_account_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(9, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_reserve1_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(10, $(this).val());
            });
            $("#modal_coa_receipt_line").find("#txt_reserve2_code").on('select2:close', function(e){
                e.preventDefault();
                setShowCombine(11, $(this).val());
            });

            function setShowCombine(index, value){
                let formId = "#modal_coa_receipt_line";
                let combination = $(formId).find('#txt_set_code_combination').val().split('.');
                combination[index] = value;
                combination = combination.join('.');

                $(formId).find('#txt_set_code_combination').val(combination);
                $(formId).find('#submit_adjust_account').prop('disabled', false);
                hideErrorMsg();
            }

            function disableForm()
            {
                let formId = "#modal_coa_receipt_line";
                $(formId).find("#txt_set_code_combination").attr('disabled','disabled');
                $(formId).find("#txt_company_code").attr('disabled','disabled');
                $(formId).find("#txt_evm_code").attr('disabled','disabled');
                $(formId).find("#txt_department_code").attr('disabled','disabled');
                $(formId).find("#txt_cost_center_code").attr('disabled','disabled');
                $(formId).find("#txt_budget_year_code").attr('disabled','disabled');
                $(formId).find("#txt_budget_type_code").attr('disabled','disabled');
                $(formId).find("#txt_budget_detail_code").attr('disabled','disabled');
                $(formId).find("#txt_budget_reason_code").attr('disabled','disabled');
                $(formId).find("#txt_account_code").attr('disabled','disabled');
                $(formId).find("#txt_sub_account_code").attr('disabled','disabled');
                $(formId).find("#txt_reserve1_code").attr('disabled','disabled');
                $(formId).find("#txt_reserve2_code").attr('disabled','disabled');
            }

            function enableFormCOA()
            {
                let formId = "#modal_coa_receipt_line";
                $(formId).find("#txt_set_code_combination").removeAttr('disabled');
                $(formId).find("#txt_company_code").removeAttr('disabled');
                $(formId).find("#txt_evm_code").removeAttr('disabled');
                $(formId).find("#txt_department_code").removeAttr('disabled');
                $(formId).find("#txt_cost_center_code").removeAttr('disabled');
                $(formId).find("#txt_budget_year_code").removeAttr('disabled');
                $(formId).find("#txt_budget_type_code").removeAttr('disabled');
                $(formId).find("#txt_budget_detail_code").removeAttr('disabled');
                $(formId).find("#txt_budget_reason_code").removeAttr('disabled');
                $(formId).find("#txt_account_code").removeAttr('disabled');
                $(formId).find("#txt_sub_account_code").removeAttr('disabled');
                $(formId).find("#txt_reserve1_code").removeAttr('disabled');
                $(formId).find("#txt_reserve2_code").removeAttr('disabled');
            }

            function showErrorMsg(msgLists = [])
            {
                let formId = "#modal_coa_receipt_line";
                $(formId).find('#txt_set_code_combination').addClass('err_validate');

                msgLists.forEach(msg => {
                    $(formId).find('#list-msg').append('<li>'+msg+'</li>');
                });

                $(formId).find('#div_show_error_msg').removeClass('d-none');
            }

            function hideErrorMsg()
            {
                let formId = "#modal_coa_receipt_line";
                $(formId).find('#list-msg').html('');
                $(formId).find('#div_show_error_msg').addClass('d-none');
                $(formId).find('#txt_set_code_combination').removeClass('err_validate');
            }
        }

        function renderShowReceiptLineInformations(receiptId, receiptLineId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/get_show_infos",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_show_receipt_line").html('\
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
                $("#modal_content_show_receipt_line").html(result);
            });
        }

        function bindFormCreateReceiptLineEvent(receiptId)
        {
            /// BTN SUBMIT CREATE
            $("#btn_submit_create_receipt_line").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitCreateReceiptLine(receiptId);
                if(valid){
                    $(this).attr('disabled','disabled');
                    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Loading...`);
                    submitFormCreateReceiptLine(receiptId);
                }
            });
        }

        function bindFormEditReceiptLineEvent(receiptId, receiptLineId)
        {
            /// BTN SUBMIT EDIT
            $("#btn_submit_edit_receipt_line").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var valid = validateBeforeSubmitEditReceiptLine(receiptId);
                if(valid){
                    $(this).attr('disabled','disabled');
                    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Loading...`);
                    submitFormEditReceiptLine(receiptId, receiptLineId);
                }
            });
        }

        function validateBeforeSubmitCreateReceiptLine(receiptId)
        {
            var formId = "#form-create-receipt-line";

            $(formId).find("select[name='category_id']").parent().next("div.error_msg").remove();
            $(formId).find("select[name='category_id']").removeClass('err_validate');
            $(formId).find("select[name='sub_category_id']").parent().next("div.error_msg").remove();
            $(formId).find("select[name='sub_category_id']").removeClass('err_validate');

            // $(formId).find("input[name='amount']").parent().next("div.error_msg").remove();
            // $(formId).find("input[name='amount']").removeClass('err_validate');
            // $(formId).find("input[name='amount_inc_vat']").parent().next("div.error_msg").remove();
            // $(formId).find("input[name='amount_inc_vat']").removeClass('err_validate');

            $(formId).find("textArea[name='description']").next("div.error_msg").remove();
            $(formId).find("textArea[name='description']").removeClass('err_validate');

            $(formId).find("#div_alert_form_amount").addClass("d-none");
            $(formId).find("#ul_alert_form_amount").html('');

            var valid = true; var arr_err_amount = [];
            var category_id = $(formId).find("select[name='category_id'] option:selected").val();
            var sub_category_id = $(formId).find("select[name='sub_category_id'] option:selected").val();
            var quantity = $(formId).find("input[name='quantity']").val();
            var uom = $(formId).find("input[name='uom']").val();
            var second_quantity = $(formId).find("input[name='second_quantity']").val();
            var second_uom = $(formId).find("input[name='second_uom']").val();
            var amount = $(formId).find("input[name='amount']").val();
            var amount_inc_vat = $(formId).find("input[name='amount_inc_vat']").val();
            var primary_amount = $(formId).find("input[name='primary_amount']").val();
            var primary_vat_amount = $(formId).find("input[name='primary_vat_amount']").val();
            var primary_amount_inc_vat = $(formId).find("input[name='primary_amount_inc_vat']").val();
            var description = $(formId).find("textArea[name='description']").val();

            if(!category_id){
                valid = false;
                $(formId).find("select[name='category_id']").addClass('err_validate');
                $(formId).find("select[name='category_id']").parent().after('<div class="error_msg"> category is required. </div>');
            }

            if(!sub_category_id){
                valid = false;
                $(formId).find("select[name='sub_category_id']").addClass('err_validate');
                $(formId).find("select[name='sub_category_id']").parent().after('<div class="error_msg"> sub-category is required. </div>');
            }

            if(!description){
                valid = false;
                $(formId).find("textArea[name='description']").addClass('err_validate');
                $(formId).find("textArea[name='description']").after('<div class="error_msg"> Line description is required.</div>');
            }

            if(quantity == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวน");
            }else if(!$.isNumeric(quantity)){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวนเป็นตัวเลข");
            }
            if(uom == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุหน่วยนับ");
            }
            if(second_quantity == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวน");
            }else if(!$.isNumeric(second_quantity)){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวนเป็นตัวเลข");
            }
            if(second_uom == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุหน่วยนับ");
            }
            if(amount == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(amount)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }else{
                // // VALIDATE WHT
                // if(whtSubCategoryId == sub_category_id){
                //     if(parseFloat(amount) > 0 ){
                //         valid = false;
                //         arr_err_amount.push("wht amount must be negative value.");
                //     }
                // }
            }

            if(amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(amount_inc_vat)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }

            if(primary_amount == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(primary_amount)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }

            if(receiptType != 'CASH-ADVANCE'){
                if(primary_vat_amount == ''){
                    valid = false;
                    arr_err_amount.push("กรุณาระบุยอดเงินภาษีมูลค่าเพิ่ม");
                }else if(!$.isNumeric(primary_vat_amount)){
                    valid = false;
                    arr_err_amount.push("กรุณาระบุยอดเงินภาษีมูลค่าเพิ่มเป็นตัวเลข");
                }
            }

            if(primary_amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(primary_amount_inc_vat)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }

            if(arr_err_amount.length > 0){
                $(formId).find("#div_alert_form_amount").removeClass("d-none");
                for (index in arr_err_amount) {
                    let li = '<li>'+arr_err_amount[index]+'</li>';
                    $(formId).find("#ul_alert_form_amount").append(li);
                }
            }

            var validInfos = validateReceiptLineInformations(formId,receiptId);
            if(valid){ valid = validInfos; }

            return valid;
        }

        function validateBeforeSubmitEditReceiptLine(receiptId)
        {
            var formId = "#form-edit-receipt-line";

            $(formId).find("#div_alert_form_amount").addClass("d-none");
            $(formId).find("#ul_alert_form_amount").html('');

            $(formId).find("textArea[name='description']").next("div.error_msg").remove();
            $(formId).find("textArea[name='description']").removeClass('err_validate');

            var valid = true; var arr_err_amount = [];

            var quantity = $(formId).find("input[name='quantity']").val();
            var uom = $(formId).find("input[name='uom']").val();
            var second_quantity = $(formId).find("input[name='second_quantity']").val();
            var second_uom = $(formId).find("input[name='second_uom']").val();
            var amount = $(formId).find("input[name='amount']").val();
            var amount_inc_vat = $(formId).find("input[name='amount_inc_vat']").val();
            var primary_amount = $(formId).find("input[name='primary_amount']").val();
            var primary_vat_amount = $(formId).find("input[name='primary_vat_amount']").val();
            var primary_amount_inc_vat = $(formId).find("input[name='primary_amount_inc_vat']").val();
            var sub_category_id = $(formId).find("input[name='sub_category_id']").val();
            var description = $(formId).find("textArea[name='description']").val();

            if(!description){
                valid = false;
                $(formId).find("textArea[name='description']").addClass('err_validate');
                $(formId).find("textArea[name='description']").after('<div class="error_msg"> Line description is required.</div>');
            }
            if(quantity == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวน");
            }else if(!$.isNumeric(quantity)){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวนเป็นตัวเลข");
            }
            if(uom == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุหน่วยนับ");
            }
            if(second_quantity == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวน");
            }else if(!$.isNumeric(second_quantity)){
                valid = false;
                arr_err_amount.push("กรุณาระบุจำนวนเป็นตัวเลข");
            }
            if(second_uom == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุหน่วยนับ");
            }
            if(amount == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(amount)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }else{
                // // VALIDATE WHT
                // if(whtSubCategoryId == sub_category_id){
                //     if(parseFloat(amount) > 0 ){
                //         valid = false;
                //         arr_err_amount.push("wht amount must be negative value.");
                //     }
                // }
            }

            if(amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(amount_inc_vat)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }

            if(primary_amount == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(primary_amount)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินไม่รวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }

            if(receiptType != 'CASH-ADVANCE'){
                if(primary_vat_amount == ''){
                    valid = false;
                    arr_err_amount.push("กรุณาระบุภาษีมูลค่าเพิ่ม");
                }else if(!$.isNumeric(primary_vat_amount)){
                    valid = false;
                    arr_err_amount.push("กรุณาระบุภาษีมูลค่าเพิ่มเป็นตัวเลข");
                }
            }

            if(primary_amount_inc_vat == ''){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่ม");
            }else if(!$.isNumeric(primary_amount_inc_vat)){
                valid = false;
                arr_err_amount.push("กรุณาระบุยอดเงินรวมภาษีมูลค่าเพิ่มเป็นตัวเลข");
            }

            if(arr_err_amount.length > 0){
                $(formId).find("#div_alert_form_amount").removeClass("d-none");
                for (index in arr_err_amount) {
                    let li = '<li>'+arr_err_amount[index]+'</li>';
                    $(formId).find("#ul_alert_form_amount").append(li);
                }
            }
            var validInfos = validateReceiptLineInformations(formId,receiptId);
            if(valid){ valid = validInfos; }

            return valid;
        }

        function validateReceiptLineInformations(formId, receiptId)
        {
            var validInfos = true;

            $(formId).find("[id^='ip_sub_category_infos_']").each(function(index, element) {

                $(element).removeClass('err_validate');
                $(element).next("div.error_msg").remove();

                var value = $(element).val();
                var required = $(element).attr('data-required');
                var label = $(element).attr('data-label');
                if(required == 'required' && !value){
                    validInfos = false;
                    $(element).addClass('err_validate');
                    $(element).after('<div class="error_msg"> '+label+' is required. </div>');
                }

            });

            return validInfos;
        }

        function submitFormCreateReceiptLine(receiptId)
        {
            var formData = $('#form-create-receipt-line').serialize();
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/store",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    var errMsg = result.err_msg;
                    if(!errMsg){
                        errMsg = "sorry something went wrong.";
                    }
                    swal({
                      title: "Error !",
                      text: errMsg,
                      type: "error",
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                }
                renderFormCreateReceiptLine(receiptId);
                $("#modal_create_receipt_line").modal('hide');
            });
        }

        function submitFormEditReceiptLine(receiptId, receiptLineId)
        {
            var formData = $('#form-edit-receipt-line').serialize();
            $.ajax({
                url: "{{ url('/') }}/ie/receipts/"+receiptId+"/lines/"+receiptLineId+"/update",
                type: 'POST',
                data: formData,
                beforeSend: function( xhr ) {
                    //
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    var errMsg = result.err_msg;
                    if(!errMsg){
                        errMsg = "sorry something went wrong.";
                    }
                    swal({
                      title: "Error !",
                      text: errMsg,
                      type: "error",
                      showConfirmButton: true
                    });
                }else{
                    renderReceiptRows();
                }
                $("#modal_content_edit_receipt_line").html('');
                $("#modal_edit_receipt_line").modal('hide');
            });
        }

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
            });

        }

    });
</script>