{!! Form::select('sub_account_code', $subAccountLists ,$subAccountCode , ["class" => 'form-control select2', "autocomplete" => "off", "id" => 'txt_sub_account_code']) !!}
<script type="text/javascript">
	$(document).ready(function(){
		$("select[name='sub_account_code']").select2({width: "100%"});
		$("#txt_sub_account_code").change(function(e){
			e.preventDefault();
			setShowCombine(9, $(this).val());
		});
		function setShowCombine(index, value){
			var combination = $('#txt_code_combination').val().split('.');

			combination[index] = value;
			combination = combination.join('.');
			$('#txt_code_combination').val(combination);
		}
	});
</script>