{!! Form::select('sub_account_code', $subAccountLists ,$subAccountCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_sub_account_code']) !!}
<script type="text/javascript">
	$(document).ready(function(){
		$("select[name='sub_account_code']").select2({width: "100%", selectOnClose: true});
		$("#modal-set-account").find("#txt_sub_account_code").on('select2:close', function(e){
            e.preventDefault();
            setShowCombine(9, $(this).val());
        });

		function setShowCombine(index, value){
            let formId = "#modal-set-account";
            let combination = $(formId).find('#txt_set_code_combination').val().split('.');
            combination[index] = value;
            combination = combination.join('.');

            $(formId).find('#txt_set_code_combination').val(combination);
            $(formId).find("#btn-confirm-set-account").prop('disabled', false);
            hideErrorMsg();
        }

		function hideErrorMsg()
        {
            let formId = "#modal-set-account";
            $(formId).find('#list-msg').html('');
            $(formId).find('#div_show_error_msg').addClass('d-none');
            $(formId).find('#txt_set_code_combination').removeClass('err_validate');
        }
	});
</script>