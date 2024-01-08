<script type="text/javascript">

    $(document).ready(function() {

        var APPaymentTerms = jQuery.parseJSON(JSON.stringify({!! $APPaymentTerms->toJson() !!}));
        var reimId = "{{ $reim->reimbursement_id }}";

        var screenWidth = $(document).width();
        // ADD CLASS 'mini-navbar' ONLY FOR PC SCREEN
        if(screenWidth > 767){
            $("body").addClass('mini-navbar');
        }

        $("#btn-edit-reim").click(function(){
            renderFormEditReim(reimId);
        });

        $("#btn-modal-send-request").click(function(){
            renderFormSendRequest(reimId);
        });

        function renderFormEditReim(reimId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/form_edit",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#modal_content_edit_reim").html('\
                        <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>');
                    $("#btn-submit-edit-reim").attr('disabled','');
                }
            })
            .done(function(result) {
                $("#modal_content_edit_reim").html(result);
                $("#btn-submit-edit-reim").removeAttr('disabled');
            });
        }

        function renderFormSendRequest(reimId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/form_send_request",
                type: 'GET',
                // data: { receipt_type : receiptType,
                //         receipt_parent_id : receiptParentId },
                beforeSend: function( xhr ) {
                    $("#content-modal-send-request").html('\
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
                $("#content-modal-send-request").html(result);
            });
        }

        // ENABLE FORM SUBMIT BUTTON WHEN LOAD PAGE COMPLETE
        $("button[type='submit']").removeAttr('disabled');

        /////////////////////////
        ///// ATTACHMENT

        // ADD ATTACHMENT
        $("#inputAttachment").change(function(){
            if(this.value){
                let filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                $("#attachmentDescText").text(filename);
                $("#attachmentDesc").removeClass("d-none");
                $("#btnAddFile").addClass("d-none");
            }else{
                $("#attachmentDescText").text("");
                $("#attachmentDesc").addClass("d-none");
                $("#btnAddFile").removeClass("d-none");
            }
        });

        // UPLOAD ATTACHMENT
        $("#btnUploadFile").click(function(){
            $("#btnUploadFile").button('loading');
            $("#btnCancelFile").attr('disabled','disabled');
            $("#form-add-attachment").submit();
        });

        // CANCEL ATTACHMENT
        $("#btnCancelFile").click(function(){
            $("#inputAttachment").val('');
            $("#attachmentDescText").text("");
            $("#attachmentDesc").addClass("d-none");
            $("#btnAddFile").removeClass("d-none");
        });

        // REMOVE ATTACHMENT
        $("#form-remove-attachment").submit(function( event ) {
            var form = this;
            submitForm(event,form,'remove-attachment');
        });

        //////////////////////////
        // FORM RESERVE ENCUMBRANCE
        $("#form-reserve-encumbrace").submit(function( event ) {
            var form = this;
            $("#btn-reim-reserve-encumbrace").attr('disabled', '');
            // VALIDATE RECEIPT
            let validReceipt = validateReceipt();
            if(!validReceipt){
                event.preventDefault();
                $("#btn-reim-reserve-encumbrace").removeAttr('disabled');
            }else{
                removeReceiptLineErrMsg();
                submitReserveEncumbrance(event,form,'reserve-encumbrance');
            }
        });

        //////////////////////////
        // FORM REQUEST SUBMIT
        $("#form-unreserve-encumbrace").submit(function( event ) {
            var form = this;
            $("#btn-reim-unreserve-encumbrace").attr('disabled', '');
            submitUnreserveEncumbrance(event,form,'unreserve-encumbrance');
        });

        //////////////////////////
        // FORM REQUEST SUBMIT
        $("#form-send-request").submit(function( event ) {
            var form = this;
            $("#btn-reim-send-request").attr('disabled', '');
            $("#modal-send-request").modal('hide');
            submitSendRequest(event,form,'send-request');
        });

        $("#form-unblock").submit(function( event ) {
            var form = this;
            submitForm(event,form,'unblock');
        });

        $("#form-cancel-request").submit(function( event ) {
            var form = this;
            submitForm(event,form,'cancel-request');
        });

        $("#form-approver-approve").submit(function( event ) {
            var form = this;
            submitForm(event,form,'approve',false);
        });

        $("#form-approver-send-back").submit(function( event ) {
            var form = this;
            submitForm(event,form,'send-back');
        });

        $("#form-approver-reject").submit(function( event ) {
            var form = this;
            submitForm(event,form,'reject');
        });

        ///////////////////////////////
        //// COMBINE GL ACCOUNT CODE
        function combineGLAccountCode()
        {
            let valid = true;
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/combine_receipt_gl_code_combination",
                type: 'POST',
                async: false,
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                },
                error: function(evt, xhr, status) {
                    let errMsg = "sorry something went wrong.";
                    if(evt.responseJSON){
                        errMsg = evt.responseJSON.message;
                    }
                    swal(errMsg, null, "error");
                }
            })
            .done(function(result) {
                if((result.status).toUpperCase() == 'ERROR'){
                    valid = false;
                    let errMsg = result.err_msg;
                    let errReceiptLineId = result.err_receipt_line_id;
                    if(!errMsg){
                        errMsg = "sorry something went wrong.";
                    }
                    swal({
                        html: true,
                        title: 'Combine GL Account Error !',
                        text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px">' + errMsg + '</span></h2>',
                        type: "error",
                    });
                    // SHOW ERROR MSG AT RECEIPT LINE
                    let ele = $("div#td_receipt_line_amount_"+errReceiptLineId);
                    ele.parent().parent().parent().parent().parent().parent().prev().addClass("warning_receipt_row");
                    ele.parent().parent().addClass("text-warning");
                    ele.after('<div class="error_msg" style="padding-top:0px;"><span class="text-bold"> account error </span></div>');
                }
            });

            return valid;
        }

        function submitReserveEncumbrance(event,form,formType)
        {
            // VALIDATE OVER BUDGET & EXCEED POLICY
            v = validateIsNotOverBudgetAndExceedPolicy();
            if(v.valid){
                ///////////////////////////////
                // VALIDATE PASSED
                var label = getLabelForm(formType);
                swal({
                    html: true,
                    title: label.title,
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px">' + label.text +  '</span></h2>',
                    // type: "info",
                    showCancelButton: true,
                    confirmButtonText: label.confirmButtonText,
                    cancelButtonText: label.cancelButtonText,
                    confirmButtonClass: label.confirmButtonClass,
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        form.submit();
                        loadingPage(true);
                        $("#btn-reim-reserve-encumbrace").attr('disabled', '');
                    }else{
                        $("#btn-reim-reserve-encumbrace").removeAttr('disabled');
                    }
                });
            }else{
                ///////////////////////////////
                // Over Budget
                $("#btn-reim-reserve-encumbrace").removeAttr('disabled');
                var label_invalid = getLabelForm(v.invalid_type);
                swal({
                    html: true,
                    title: label_invalid.title,
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px">' + label_invalid.text + '</span></h2>',
                    type: "error",
                });
            }
            event.preventDefault();
        }

        function submitUnreserveEncumbrance(event,form,formType)
        {

            ///////////////////////////////
            // VALIDATE PASSED
            var label = getLabelForm(formType);
            swal({
                html: true,
                title: label.title,
                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px">' + label.text +  '</span></h2>',
                // type: "info",
                showCancelButton: true,
                confirmButtonText: label.confirmButtonText,
                cancelButtonText: label.cancelButtonText,
                confirmButtonClass: label.confirmButtonClass,
                cancelButtonClass: 'btn btn-danger',
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    form.submit();
                    loadingPage(true);
                    $("#btn-reim-unreserve-encumbrace").attr('disabled', '');
                }else{
                    $("#btn-reim-unreserve-encumbrace").removeAttr('disabled');
                }
            });
            event.preventDefault();
        }

        function submitSendRequest(event,form,formType)
        {

            ///////////////////////////////
            // VALIDATE PASSED
            var label = getLabelForm(formType);
            swal({
                html: true,
                title: label.title,
                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px">' + label.text +  '</span></h2>',
                // type: "info",
                showCancelButton: true,
                confirmButtonText: label.confirmButtonText,
                cancelButtonText: label.cancelButtonText,
                confirmButtonClass: label.confirmButtonClass,
                cancelButtonClass: 'btn btn-danger',
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    form.submit();
                    loadingPage(true);
                    $("#btn-reim-send-request").attr('disabled', '');
                }else{
                    $("#btn-reim-send-request").removeAttr('disabled');
                }
            });
            event.preventDefault();
        }

        function submitForm(event,form,formType,validateReason)
        {
            // DEFAULT DATA
            validateReason = typeof validateReason !== 'undefined' ? validateReason : true;

        	var label = getLabelForm(formType);
            if(formType == 'remove-attachment' || formType == 'cancel-request'){
                swal({
                    html: true,
                    title: label.title,
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px">' + label.text +  '</span></h2>',
                    // type: "info",
                    showCancelButton: true,
                    // confirmButtonColor: "#DD6B55",
                    confirmButtonText: label.confirmButtonText,
                    cancelButtonText: label.cancelButtonText,
                    confirmButtonClass: label.confirmButtonClass,
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        form.submit();
                        loadingPage(true);
                        $("button[type='submit']").attr('disabled','disabled');
                    }else{
                        $("button[type='submit']").removeAttr('disabled');
                    }
                });

            }else if(formType == 'send-request-with-reason' || formType == 'approve' || formType == 'send-back' || formType == 'reject' || formType == 'unblock'){

                let valid = true;
                if(validateReason){
                    valid = validateFormReason(form);
                }

                if(valid){
                    form.submit();
                    loadingPage('true');
                    $("button[type='submit']").attr('disabled','disabled');
                }else{
                    $("button[type='submit']").removeAttr('disabled');
                }
            }
            event.preventDefault();
        }

        function validateFormReason(form)
        {
        	var valid = true;
            var ele_input_reason = $(form).find("textarea[name='reason']");
            ele_input_reason.removeClass('err_validate');
            ele_input_reason.next("div.error_msg").remove();

    		var reason = ele_input_reason.val();
    		if(!reason){
                valid = false;
                ele_input_reason.addClass('err_validate');
                ele_input_reason.after('<div class="error_msg"> reason is required.</div>');
    		}

            return valid;
        }

        //////////////////////////
        //// VALIDATION RECEIPT
        function validateReceipt()
        {
            let valid = true; let errCode = 0; let arrErrReceiptId = []; let arrErrMsg = [];
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/validate_receipt",
                type: 'POST',
                async: false,
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                },
                error: function(evt, xhr, status) {
                    let errMsg = "sorry something went wrong.";
                    if(evt.responseJSON){
                        errMsg = evt.responseJSON.message;
                    }
                    swal(errMsg, null, "error");
                }
            })
            .done(function(result) {
                valid = result.valid;
                errCode = result.err_code;
                arrErrReceiptId = result.err_receipt_id;
                arrErrMsg = result.err_msg;
            });

            // REMOVE RECEIPT AMOUNT ERROR MSG
            $("[id^='div_td_receipt_amount_']").each(function( index ) {
                $(this).parent().parent().removeClass("err_receipt_row");
                $(this).next("div.error_msg").remove();
            });

            // IF NOT VALID
            if(!valid){
                let label = getLabelForm(errCode);
                swal({
                    html: true,
                    title: label.title,
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> '+label.text+' </span></h2>',
                    type: "error",
                });
                // SHOW ERROR MSG
                for (i in arrErrReceiptId) {
                    $("#div_td_receipt_amount_"+arrErrReceiptId[i]).parent().parent().addClass("err_receipt_row");
                    $("#div_td_receipt_amount_"+arrErrReceiptId[i]).after('<div class="error_msg"><small> '+arrErrMsg[i]+' </small></div>');
                }
            }

            return valid;
        }

        ////////////////////////////////////////////////////
        //// VALIDATION OVER BUDGET & EXCEED POLICY
        function validateIsNotOverBudgetAndExceedPolicy()
        {
            let result = { valid : true , invalid_type : '', isError : false };

            // CHECK REQUEST AMOUNT OVER BUDGET OR NOT
            let validNotOverBudget = validateNotOverBudget();

            // CHECK REQUEST AMOUNT EXCEED POLICY OR NOT
            // let validNotExceedPolicy = validateNotExceedPolicy();

            // if(!validNotOverBudget && !validNotExceedPolicy.valid){
            //     result.valid = false;
            //     result.invalid_type = 'over-budget-exceed-policy';
            // }else if(!validNotOverBudget){
            //     result.valid = false;
            //     result.invalid_type = 'over-budget';
            // }else if(!validNotExceedPolicy.valid){
            //     result.valid = false;
            //     result.invalid_type = 'exceed-policy';
            // }

            // // IF EXCEED POLICY AND NOT ALLOW TO SUBMIT EXCEED
            // if(validNotExceedPolicy.isError){
            //     result.valid = false;
            //     result.invalid_type = 'error-exceed-policy';
            // }

            if(!validNotOverBudget){
                result.valid = false;
                result.invalid_type = 'over-budget';
            }

            return result;
        }
        function validateNotOverBudget()
        {
            let valid = true;
            let arrErrLines = [];
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/check_over_budget",
                type: 'POST',
                async: false,
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                },
                error: function(evt, xhr, status) {
                    $('#modal-send-request-with-reason').modal('hide');
                    let errMsg = "sorry something went wrong.";
                    if(evt.responseJSON){
                        errMsg = evt.responseJSON.message;
                    }
                    swal(errMsg, null, "error");
                }
            })
            .done(function(result) {
                valid = result.valid;
                arrErrLines = result.arr_err_lines;
            });

            // IF NOT VALID
            if(!valid){

                for(i in arrErrLines){
                    // SHOW ERROR MSG BY LINE
                    for(j in arrErrLines[i].receipt_line_id){
                        let ele = $("div#td_receipt_line_amount_"+arrErrLines[i].receipt_line_id[j]);
                        ele.parent().parent().parent().parent().parent().parent().prev().addClass("warning_receipt_row");
                        ele.parent().parent().addClass("text-warning");
                        if(ele.next("div.error_msg").length > 0){
                            ele.next("div.error_msg").append(' and '+arrErrLines[i].err_msg);
                        }else{
                            ele.after('<div class="error_msg" style="padding-top:0px;"><span class="text-bold"> '+arrErrLines[i].err_msg+' </span></div>');
                        }
                    }
                }

                // SHOW OVER BUDGET MSG BY ACCOUNT
                // showOverBudgetErrMsgByAccount(arrErrLines);
            }

            return valid;
        }

        function showOverBudgetErrMsgByAccount(arrErrLines)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/over_budget_err_msg_by_account",
                type: 'POST',
                async: false,
                data: { _token: "{{ csrf_token() }}", arr_err_lines: arrErrLines },
                beforeSend: function( xhr ) {
                    //
                },
                error: function(evt, xhr, status) {
                    let errMsg = "sorry something went wrong.";
                    if(evt.responseJSON){
                        errMsg = evt.responseJSON.message;
                    }
                    swal(errMsg, null, "error");
                }
            })
            .done(function(result) {
                if(result){
                    $('#div_over_budget_err_msg_by_account').html(result);
                    $('#div_over_budget_err_msg_by_account').removeClass('d-none');
                }else{
                    $('#div_over_budget_err_msg_by_account').html('');
                    $('#div_over_budget_err_msg_by_account').addClass('d-none');
                }
            });
        }

        function validateNotExceedPolicy()
        {
            let validResult = {valid : true , isError: false};
            let arrErrLines = [];
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/check_exceed_policy",
                type: 'POST',
                async: false,
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function( xhr ) {
                    //
                },
                error: function(evt, xhr, status) {
                    $('#modal-send-request-with-reason').modal('hide');
                    let errMsg = "sorry something went wrong.";
                    if(evt.responseJSON){
                        errMsg = evt.responseJSON.message;
                    }
                    swal(errMsg, null, "error");
                }
            })
            .done(function(result) {
                validResult.valid = result.valid;
                arrErrLines = result.arr_err_lines;
            });

            // IF NOT VALID
            if(!validResult.valid){

                for(i in arrErrLines){
                    // SHOW ERROR MSG
                    let ele = $("div#td_receipt_line_amount_"+arrErrLines[i].receipt_line_id);
                    ele.parent().parent().parent().parent().parent().parent().prev().addClass("warning_receipt_row");
                    ele.parent().parent().addClass("text-warning");
                    if(ele.next("div.error_msg").length > 0){
                        ele.next("div.error_msg").append(' and '+arrErrLines[i].err_msg);
                    }else{
                        ele.after('<div class="error_msg" style="padding-top:0px;"><span class="text-bold"> '+arrErrLines[i].err_msg+' </span></div>');
                    }
                }

            }

            return validResult;
        }

        function showFormSendRequestWithReason()
        {
            var modalId = '#modal-send-request-with-reason';
            $(modalId).modal('show');
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/form_send_request_with_reason",
                type: 'GET',
                beforeSend: function( xhr ) {
                    $(modalId).find('div.modal-content div.modal-body').html('\
                    <div class="m-t-lg m-b-lg">\
                        <div class="text-center sk-spinner sk-spinner-wave">\
                            <div class="sk-rect1"></div>\
                            <div class="sk-rect2"></div>\
                            <div class="sk-rect3"></div>\
                            <div class="sk-rect4"></div>\
                            <div class="sk-rect5"></div>\
                        </div>\
                    </div>');
                },
                error: function(evt, xhr, status) {
                    $(modalId).modal('hide');
                    let errMsg = "sorry something went wrong.";
                    if(evt.responseJSON){
                        errMsg = evt.responseJSON.message;
                    }
                    swal(errMsg, null, "error");
                }
            })
            .done(function(result) {
                if(result){
                    $(modalId).find('div.modal-content').html(result);
                    bindEventFormSendRequestWithReason();
                }else{
                    $(modalId).modal('hide');
                    swal({
                      title: "Error !",
                      text: "sorry something went wrong",
                      type: "error",
                      timer: 2000,
                      showConfirmButton: false
                    },function(){
                        // location.reload();
                    });
                }
            });
        }

        function bindEventFormSendRequestWithReason()
        {
            $("#form-send-request-with-reason").submit(function( event ) {
                var form = this;
                submitForm(event,form,'send-request-with-reason');
            });
        }

        function removeReceiptLineErrMsg()
        {
            $("div[id^='td_receipt_line_amount_']").each(function( index ) {
                $(this).parent().parent().parent().parent().parent().parent().prev().removeClass("warning_receipt_row");
                $(this).parent().parent().removeClass("text-warning");
                $(this).next("div.error_msg").remove();
            });
        }

        function getLabelForm(type)
        {
        	var result = {
        		title: 'Submit ?',
        		text: 'Are you sure ?',
        		confirmButtonText: 'Yes',
        		confirmButtonClass: 'btn btn-primary',
        		cancelButtonText: 'cancel'
        	};
            if(type == 'reserve-encumbrance'){
                result.title = '<h2 style="font-size:30px;">Reserve encumbrance ?</h2>';
                result.text = 'เมื่อทำการส่งข้อมูลแล้ว จะไม่สามารถแก้ไขข้อมูลได้ ต้องการส่งข้อมูลหรือไม่ ?';
                result.confirmButtonText = 'Yes, reserve it !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'unreserve-encumbrance'){
                result.title = '<h2 style="font-size:30px;">Unreserve encumbrance ?</h2>';
                result.text = 'Are you sure to unreserve encumbrance this request ?';
                result.confirmButtonText = 'Yes, unreserve it !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'send-request'){
                result.title = '<h2 style="font-size:30px;">Send request ?</h2>';
                result.text = 'Please send the original receipt and supporting document to Accounting Dept. <br/> (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)';
                result.confirmButtonText = 'Yes, send it !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'approve'){
        		result.title = 'Approve request ?';
        		result.text = 'Are you sure to approve this request ?';
        		result.confirmButtonText = 'Yes, approve it !';
        		result.confirmButtonClass = 'btn btn-primary';
        	}else if(type == 'send-back'){
        		result.title = 'Sendback request ?';
        		result.text = 'Are you sure to sendback this request ?';
        		result.confirmButtonText = 'Yes, sendback it !';
        		result.confirmButtonClass = 'btn btn-primary';
        	}else if(type == 'reject'){
        		result.title = 'Reject request ?';
        		result.text = 'Are you sure to reject this request ?';
        		result.confirmButtonText = 'Yes, reject it !';
        		result.confirmButtonClass = 'btn btn-primary';
        	}else if(type == 'remove-attachment'){
                result.title = 'Remove attachment ?';
                result.text = 'Are you sure to remove this attachment ?';
                result.confirmButtonText = 'Yes, remove it !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'unblock'){
                result.title = 'Unblock request ?';
                result.text = 'Are you sure to unblock this request ?';
                result.confirmButtonText = 'Yes, unblock it !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'cancel-request'){
                result.title = 'Cancel request ?';
                result.text = 'Are you sure to cancel this request ?';
                result.confirmButtonText = 'Yes, cancel it !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'over-budget'){
                result.title = 'Over Budget !';
                result.text = '';
                // result.text = 'Are you sure to request over budget ?';
                // result.confirmButtonText = 'Yes, i\'m sure !';
                // result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'exceed-policy'){
                result.title = 'Exceed Policy !';
                result.text = 'Are you sure to request exceed policy ?';
                result.confirmButtonText = 'Yes, i\'m sure !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'error-exceed-policy'){
                result.title = 'Exceed policy !';
                result.text = 'Your clearing request amount is exceed policy, and your selected receipt sub-category not allow to send request on exceed policy.';
            }else if(type == 'over-budget-exceed-policy'){
                result.title = 'Over Budget and Exceed Policy !';
                result.text = 'Are you sure to request over budget and exceed policy ?';
                result.confirmButtonText = 'Yes, i\'m sure !';
                result.confirmButtonClass = 'btn btn-primary';
            }else if(type == 'not-found-parent'){
                result.title = 'Invalid reimbursement data !';
                result.text = 'Please check reimbursement data.';
            }else if(type == 'not-found-receipt'){
                result.title = 'ไม่พบข้อมูลใบเสร็จ';
                result.text = 'กรุณาระบุข้อมูลใบเสร็จ';
            }else if(type == 'invalid-receipt'){
                result.title = 'Invalid reimbursement receipt data !';
                result.text = 'Please correct receipt data and send request again.';
            }

        	return result;
        }

        // ENTER DUEDATE AND PAYMENT METHOD
        $("#form-enter-due-date").find(".select2").select2({width: "100%"});

        $("#form-enter-due-date").find('#txt_due_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
            startDate : new Date(),
        });

        $("#form-enter-due-date").find('#ddl_payment_term_id').change(function(e){
            let term_id = this.value;
            let addDay = parseInt(getTermValue(term_id));
            let dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + addDay);
            $("#form-enter-due-date").find('#txt_due_date').datepicker('setDate', dueDate);
        });

        $("#form-enter-due-date").find('input[name="payment_method_type"]').change(function(){
            let formId = "#form-enter-due-date";
            let paymentMethodType = $(this).val();
            if(paymentMethodType == 'method'){
                $(formId).find("#div_payment_method_id").show();
            }else{
                $(formId).find("#div_payment_method_id").hide();
            }

        });

        $("#form-enter-due-date").submit(function(e)
        {
            let formId = "#form-enter-due-date";
            $(formId).find("#txt_due_date").removeClass('err_validate');
            $(formId).find("#ddl_payment_method_id").removeClass('err_validate');
            $(formId).find("#txt_due_date").next("div.error_msg").remove();
            $(formId).find("#ddl_payment_method_id").next("div.error_msg").remove();
            $(formId).find("#ddl_payment_term_id").next("div.error_msg").remove();
            $(formId).find("#ddl_payment_term_id").removeClass('err_validate');

            // var form = this;
            let valid = true;
            let dueDate = $(formId).find('#txt_due_date').val();
            let paymentMethodType = $(formId).find('input[name="payment_method_type"]:checked').val();
            var paymentMethodId = $(formId).find("#ddl_payment_method_id").val();
            var paymentTermId = $(formId).find("#ddl_payment_term_id").val();

            if(!dueDate){
                valid = false;
                $(formId).find("#txt_due_date").addClass('err_validate');
                $(formId).find("#txt_due_date").after('<div class="error_msg"> due date is required.</div>');
            }
            // if(paymentMethodType == 'method'){
            //     var paymentMethodId = $("#ddl_payment_method_id").val();
            //     if(!paymentMethodId){
            //         valid = false;
            //         $("#ddl_payment_method_id").addClass('err_validate');
            //         $("#ddl_payment_method_id").after('<div class="error_msg"> payment method is required.</div>');
            //     }
            // }

            if(!paymentMethodId){
                valid = false;
                $(formId).find("#ddl_payment_method_id").addClass('err_validate');
                $(formId).find("#ddl_payment_method_id").after('<div class="error_msg"> payment method is required.</div>');
            }

            if(!paymentTermId){
                valid = false;
                $(formId).find("#ddl_payment_term_id").addClass('err_validate');
                $(formId).find("#ddl_payment_term_id").after('<div class="error_msg"> payment term is required.</div>');
            }

            if(valid){
                $(formId).submit();
            }
            e.preventDefault();
            e.stopPropagation();
        });

        function getTermValue(term_id) 
        {
            var array = APPaymentTerms;
            if(term_id != ''){
                for(i in array) {
                    if(array[i].payment_term_id == term_id) {
                        return array[i].due_days;
                    }
                }
            }
            return 0;
        };

        function loadingPage(loading)
        {
            if(loading){
                $('#page-wrapper').prepend('<div id="loading-page" style="position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999999999;overflow: hidden;background:#fff"><div class="sk-spinner sk-spinner-double-bounce text-center w-100" style="font-size: 18px; margin-top: 6.5rem;"> กำลังดำเนินการ </div><div class="sk-spinner sk-spinner-double-bounce" style="width: 100px; height: 100px;"><div class="sk-double-bounce1"></div><div class="sk-double-bounce2"></div></div></div>');
            }else {
                $('#page-wrapper').find('#loading-page').remove();
            }
        }
    });

</script>