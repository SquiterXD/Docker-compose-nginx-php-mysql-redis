<script>
    var cosCenter = {!! json_encode($segment['costCenter']) !!};
    var budgetDetail = {!! json_encode($segment['budgetDetail']) !!};
    var subAccount = {!! json_encode($segment['subAccount']) !!};

    departmentChange();
    budgettypeChange();
    mainaccountChange();

    async function departmentChange(){
        var segment3 = '{{ $accont_gl->segment3 }}';
        var segment4 = '{{ $accont_gl->segment4 }}';
        $('#cost_center').empty()
        await cosCenter.filter(function(obj) {
            if(segment3 == obj.department_code){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.cost_center_code + ' - ' + obj.description;
                    lebel_desciption = obj.description;
                }else{
                    description = obj.cost_center_code;
                    lebel_desciption = '';
                }
                var cosCenterSelect = new Option(description, obj.cost_center_code, true, true);
                $(cosCenterSelect).attr('data-value',lebel_desciption);
                $('#cost_center').append(cosCenterSelect).attr('data-value',description).val(segment4).trigger('change');
            }
        });
    }

    async function budgettypeChange(){
        var segment6 = '{{ $accont_gl->segment6 }}';
        var segment7 = '{{ $accont_gl->segment7 }}';
        $('#budget_detail').empty()
        await budgetDetail.filter(function(obj) {
            if(segment6 == obj.budget_type){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.budget_detail + ' - ' + obj.description;
                    lebel_desciption = obj.description;
                }else{
                    description = obj.budget_detail;
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.budget_detail, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#budget_detail').append(cosBudgetSelect).attr('data-value',description).val(segment7).trigger('change');
            }
        });
    }

    async function mainaccountChange(){
        var segment9 = '{{ $accont_gl->segment9 }}';
        var segment10 = '{{ $accont_gl->segment10 }}';
        $('#sub_account').empty()
        await subAccount.filter(function(obj) {
            if(segment9 == obj.main_account){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.sub_account + ' - ' + obj.description;
                    lebel_desciption = obj.description;
                }else{
                    description = obj.sub_account;
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.sub_account, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#sub_account').append(cosBudgetSelect).val(segment10).trigger('change');
            }
        });
    }

    $("#department_code").change(async function(e){
        var val = $(this).val()
        $('#cost_center').empty()
        await cosCenter.filter(function(obj) {
            if(val == obj.department_code){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.cost_center_code + ' - ' + obj.description;
                    lebel_desciption = obj.description;
                }else{
                    description = obj.cost_center_code;
                    lebel_desciption = '';
                }
                var cosCenterSelect = new Option(description, obj.cost_center_code, true, true);
                $(cosCenterSelect).attr('data-value',lebel_desciption);
                $('#cost_center').append(cosCenterSelect).attr('data-value',description).trigger('change');
            }
        });
    })

    $("#budget_type").change(async function(e){
        var val = $(this).val()
        $('#budget_detail').empty()
        await budgetDetail.filter(function(obj) {
            if(val == obj.budget_type){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.budget_detail + ' - ' + obj.description;
                    lebel_desciption = obj.description;
                }else{
                    description = obj.budget_detail;
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.budget_detail, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#budget_detail').append(cosBudgetSelect).attr('data-value',description).trigger('change');
            }
        });
    })

    $("#main_account").change(async function(e){
        var val = $(this).val()
        $('#sub_account').empty()
        await subAccount.filter(function(obj) {
            if(val == obj.main_account){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.sub_account + ' - ' + obj.description;
                    lebel_desciption = obj.description;
                }else{
                    description = obj.sub_account;
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.sub_account, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#sub_account').append(cosBudgetSelect).attr('data-value',description).trigger('change');
            }
        });
    })

    async function SaveChoseDedit(){
        var credit_code = '';
        var html_debit  = '';
        var select_length = $('.sel-debit').length
        await $('.sel-debit').each(function(i, obj) {
            if(i == (select_length - 1)){
                credit_code += obj.value;
                html_debit += $(obj).find(':selected').data('value');
            }else{
                credit_code += obj.value+'.';
                html_debit +=  $(obj).find(':selected').data('value')+'.';
            }
        });
        console.log(html_debit);
        $("#cd_deccombi").html(html_debit);
        $('#accountmapping_debit').val(credit_code)
        $("#accountmapping_id").val('');
        $("#accountmapping_code").val('');
        $("#accountmapping_name").val('');
        $("#input_mapping_code").val('');
        $("#input_mapping_name").val('');
        $("#myModal").modal('hide');
    }

    //------------------------

    departmentChange_credit();
    budgettypeChange_credit();
    mainaccountChange_credit();

    async function departmentChange_credit(){
        var segment3 = '{{ $accont_cr_gl->segment3 }}';
        var segment4 = '{{ $accont_cr_gl->segment4 }}';
        $('#cr_cost_center').empty()
        await cosCenter.filter(function(obj) {
            if(segment3 == obj.department_code){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.cost_center_code + ' - ' + obj.description
                    lebel_desciption = obj.description;
                }else{
                    description = obj.cost_center_code
                    lebel_desciption = '';
                }
                var cosCenterSelect = new Option(description, obj.cost_center_code, true, true);
                $(cosCenterSelect).attr('data-value',lebel_desciption);
                $('#cr_cost_center').append(cosCenterSelect).val(segment4).trigger('change');
            }
        });
    }

    async function budgettypeChange_credit(){
        var segment6 = '{{ $accont_cr_gl->segment6 }}';
        var segment7 = '{{ $accont_cr_gl->segment7 }}';
        $('#cr_budget_detail').empty()
        await budgetDetail.filter(function(obj) {
            if(segment6 == obj.budget_type){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.budget_detail + ' - ' + obj.description
                    lebel_desciption = obj.description;
                }else{
                    description = obj.budget_detail
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.budget_detail, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#cr_budget_detail').append(cosBudgetSelect).val(segment7).trigger('change');
            }
        });
    }

    async function mainaccountChange_credit(){
        var segment9 = '{{ $accont_cr_gl->segment9 }}';
        var segment10 = '{{ $accont_cr_gl->segment10 }}';
        $('#cr_sub_account').empty()
        await subAccount.filter(function(obj) {
            if(segment9 == obj.main_account){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.sub_account + ' - ' + obj.description
                    lebel_desciption = obj.description;
                }else{
                    description = obj.sub_account
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.sub_account, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#cr_sub_account').append(cosBudgetSelect).val(segment10).trigger('change');
            }
        });
    }

    $("#cr_department_code").change(async function(e){
        var val = $(this).val()
        $('#cr_cost_center').empty()
        await cosCenter.filter(function(obj) {
            if(val == obj.department_code){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.cost_center_code + ' - ' + obj.description
                    lebel_desciption = obj.description;
                }else{
                    description = obj.cost_center_code
                    lebel_desciption = '';
                }
                var cosCenterSelect = new Option(description, obj.cost_center_code, true, true);
                $(cosCenterSelect).attr('data-value',lebel_desciption);
                $('#cr_cost_center').append(cosCenterSelect).trigger('change');
            }
        });
    })

    $("#cr_budget_type").change(async function(e){
        var val = $(this).val()
        $('#cr_budget_detail').empty()
        await budgetDetail.filter(function(obj) {
            if(val == obj.budget_type){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.budget_detail + ' - ' + obj.description
                    lebel_desciption = obj.description;
                }else{
                    description = obj.budget_detail
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.budget_detail, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#cr_budget_detail').append(cosBudgetSelect).trigger('change');
            }
        });
    })

    $("#cr_main_account").change(async function(e){
        var val = $(this).val()
        $('#cr_sub_account').empty()
        await subAccount.filter(function(obj) {
            if(val == obj.main_account){
                var description = '';
                var lebel_desciption;
                if(obj.description != '' && obj.description != null && obj.description != '-'){
                    description = obj.sub_account + ' - ' + obj.description
                    lebel_desciption = obj.description;
                }else{
                    description = obj.sub_account
                    lebel_desciption = '';
                }
                var cosBudgetSelect = new Option(description, obj.sub_account, true, true);
                $(cosBudgetSelect).attr('data-value',lebel_desciption);
                $('#cr_sub_account').append(cosBudgetSelect).trigger('change');
            }
        });
    })

    async function SaveChoseCredit(){
        var credit_code = '';
        var html_credit  = '';
        var select_length = $('.sel-credit').length
        await $('.sel-credit').each(function(i, obj) {
            if(i == (select_length - 1)){
                credit_code += obj.value;
                html_credit +=  $(obj).find(':selected').data('value');
            }else{
                credit_code += obj.value+'.';
                html_credit +=  $(obj).find(':selected').data('value')+'.';
            }
        });

        $("#cr_deccombi").html(html_credit);
        $('#accountmapping_cedit').val(credit_code)
        $("#accountmapping_cid").val('');
        $("#accountmapping_ceditcode").val('');
        $("#accountmapping_ceditname").val('');
        $("#input_mapping_ceditcode").val('');
        $("#input_mapping_ceditname").val('');
        $("#modalCreditNote").modal('hide');
    }
</script>
