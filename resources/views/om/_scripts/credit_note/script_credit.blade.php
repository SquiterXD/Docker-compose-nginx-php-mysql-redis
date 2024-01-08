<script>
    var cosCenter = {!! json_encode($segment['costCenter']) !!};
    var budgetDetail = {!! json_encode($segment['budgetDetail']) !!};
    var subAccount = {!! json_encode($segment['subAccount']) !!};

    $(".select2-tags").select2({
        tags: true
    });

    $("#department_code").change(async function(e){
        var val = $(this).val()
        $('#cost_center').empty()
        await cosCenter.filter(function(obj) {
            if(val == obj.department_code){
                var description = '';
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.cost_center_code + ' - ' + obj.description
                }else{
                    description = obj.cost_center_code
                }
                var cosCenterSelect = new Option(description, obj.cost_center_code, true, true);
                $('#cost_center').append(cosCenterSelect).trigger('change');
            }
        });
    })

    $("#budget_type").change(async function(e){
        var val = $(this).val()
        $('#budget_detail').empty()
        await budgetDetail.filter(function(obj) {
            if(val == obj.budget_type){
                var description = '';
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.budget_detail + ' - ' + obj.description
                }else{
                    description = obj.budget_detail
                }
                var cosBudgetSelect = new Option(description, obj.budget_detail, true, true);
                $('#budget_detail').append(cosBudgetSelect).trigger('change');
            }
        });
    })

    $("#main_account").change(async function(e){
        var val = $(this).val()
        $('#sub_account').empty()
        await subAccount.filter(function(obj) {
            if(val == obj.main_account){
                var description = '';
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.sub_account + ' - ' + obj.description
                }else{
                    description = obj.sub_account
                }
                var cosBudgetSelect = new Option(description, obj.sub_account, true, true);
                $('#sub_account').append(cosBudgetSelect).trigger('change');
            }
        });
    })

    async function SaveChoseCredit(){
        var credit_code = '';
        var select_length = $('.select2-tags').length
        await $('.select2-tags').each(function(i, obj) {
            if(i == (select_length - 1)){
                credit_code += obj.value;
            }else{
                credit_code += obj.value+'.';
            }
        });
        $('#accountmapping_debit').val(credit_code)
    }
</script>
