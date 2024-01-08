<div class="row">
    <div class="col-md-3 m-t-sm">
        <input name="pay_to_emp" value="YES" type="radio" id="payToEmp" {{ $cashAdvance->clearing_pay_to_emp == 'YES' ? 'checked' : '' }}> 
        <label for="payToEmp" style="display: inline;">Transfer เงินโอน</label>
    </div>
    <div class="col-md-4 m-t-sm">
        <input name="pay_to_emp" value="NO" type="radio" id="notPayToEmp" {{ $cashAdvance->clearing_pay_to_emp == 'NO' ? 'checked' : '' }}> 
        <label for="notPayToEmp" style="display: inline;">Cash เงินสด</label>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6" style="padding-right: 0px;">
                <label>
                    <div>Invoice Date (วันที่ใบแจ้งหนี้) <span class="text-danger">*</span>  </div>
                </label>
                {!! Form::text('clearing_request_date', $cashAdvance->clearing_request_date, ['class'=>'form-control','id'=>'txt_clearing_request_date', 'autocomplete'=>'off']) !!}
            </div>
            <div class="col-md-6">
                <label>
                    <div>GL Date (วันที่บันทึกบัญชี) <span class="text-danger">*</span> </div>
                </label>
                {!! Form::text('clearing_gl_date', $cashAdvance->clearing_gl_date, ['class'=>'form-control','id'=>'txt_clearing_gl_date', 'autocomplete'=>'off']) !!}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        var create_date = "{{ $cashAdvance->creation_date }}";

        $('#form-edit-cash-advance').find('#txt_clearing_request_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
            startDate: new Date(create_date),
        });

        $('#form-edit-cash-advance').find('#txt_clearing_gl_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

        /////////////////////////////
        // EDIT REIM FORM EVENT AND FUNCTION
        $('#form-edit-cash-advance').submit(function(e){
            var form = this;
            $(this).find("button[type='submit']").button('loading');
            form.submit();
            e.preventDefault();
            e.stopPropagation();
        });

    });

</script>