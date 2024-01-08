@php
    $check = optional($dff->header)->isNotLock() ?? $dff->isNotLock();
    $checkStatus = $dff->header ? in_array(optional(optional(optional($dff)->header)->parent)->status, ['CLEARED', 'APPROVED']) : in_array(optional($dff)->status, ['CLEARED', 'APPROVED']);
    $readOnly = $check || $checkStatus ? '' : 'readonly';
    $disabled = $check || $checkStatus ? '' : 'disabled';
    // dd(optional($dff->header), $check, $checkStatus, $readOnly, $disabled);
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="row ">
            <label for="" class="col-sm-4 text-right">
                {{-- <div>Pay For</div> --}}
                <div>จ่ายให้</div>
            </label>
            <div class="col-sm-6">
                {!! Form::text('pay_for', $payFor, ['class'=>'form-control','id'=>'txt_pay_for', 'autocomplete'=>'off', $readOnly]) !!}
            </div>
        </div>
        <div class="row">
            <label for="" class="col-sm-4 text-right">
                {{-- <div>Tax Code</div> --}}
                <div>รหัสกลุ่มภาษี</div>
            </label>
            <div class="col-sm-6">
                <select name="group_tax_code" id="txt_group_tax_code" class="form-control select2" {{ $disabled }}>
                    @foreach ($groupTaxCodes as $index => $item)
                        <option value="{{ $index }}">{{ $item }}</option>
                    @endforeach
                </select>
                {{-- {!! Form::text('group_tax_code', null, ['class'=>'form-control','id'=>'txt_group_tax_code', 'autocomplete'=>'off', $readOnly]) !!} --}}
            </div>
        </div>

        @if ( !in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) )
            <div class="row">
                <label for="" class="col-sm-4 text-right">
                    {{-- <div>Tax Invoice No.</div> --}}
                    <div>เลขที่ใบกำกับภาษี</div>
                </label>
                <div class="col-sm-6">
                    {!! Form::text('tax_invoice_number', $receiptNumber, ['class'=>'form-control','id'=>'txt_tax_invoice_number', 'autocomplete'=>'off', $readOnly]) !!}
                </div>
            </div>
            <div class="row">
                <label for="" class="col-sm-4 text-right">
                    {{-- <div>Tax Invoice Date</div> --}}
                    <div>วันที่ในใบกำกับภาษี</div>
                </label>
                <div class="col-sm-6">
                    {!! Form::text('tax_invoice_date', $receiptDate, ['class'=>'form-control','id'=>'txt_tax_invoice_date', 'autocomplete'=>'off', $readOnly]) !!}
                </div>
            </div>
            @if (in_array($dffType, ['invoice']))

                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>อ้างอิงใบสั่งซื้อ</div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('po_ref_number', $poRefNumber, ['class'=>'form-control','id'=>'txt_po_ref_number', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>งวดที่</div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('paid_number', $paidNumber, ['class'=>'form-control','id'=>'txt_paid_number', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>

            @endif
            @if (in_array($dffType, ['cash_advance', 'invoice']))

                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>ที่อยู่ (ภงด)</div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('address', $taxAddress, ['class'=>'form-control','id'=>'txt_address', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>
                
            @endif

            @if (in_array($dffType, ['tax_invoice']))

                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>มูลค่าสินค้า/บริการ </div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('product_value', $productValue, ['class'=>'form-control','id'=>'txt_product_value', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>ที่อยู่ </div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('address', $taxAddress, ['class'=>'form-control','id'=>'txt_address', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>
                
            @endif

            @if (in_array($dffType, ['cash_advance', 'invoice', 'tax_invoice']))

                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>สาขาที่</div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('branch_number', $branchNumber, ['class'=>'form-control','id'=>'txt_branch_number', 'autocomplete'=>'off', 'maxlength' => '5', $readOnly]) !!}
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>ID No.</div> --}}
                        <div>เลขประจำตัว (ภงด)</div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('tax_id', $taxId, ['class'=>'form-control','id'=>'txt_tax_id', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>

            @endif

            @if (in_array($dffType, ['tax_invoice']))

                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>รายการนี้หักภาษี ณ ที่จ่าย</div>
                    </label>
                    <div class="col-sm-6">
                        <select name="wht_flag" id="txt_wht_flag" class="form-control select2" {{ $disabled }}>
                            <option value="N">ไม่ใช่</option>
                            <option value="Y" {{ $whtFlag == 'Y' ? 'selected' : '' }}>ใช่</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-4 text-right">
                        {{-- <div>Address</div> --}}
                        <div>เลขที่หนังสือรับรอง</div>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('wht_ref_number', $whtRefNumber, ['class'=>'form-control','id'=>'txt_wht_ref_number', 'autocomplete'=>'off', $readOnly]) !!}
                    </div>
                </div>
                
            @endif

        @endif
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){

        let formType = "{{ $formType }}";
        if(formType == 'HEADER'){
            var formId = "#form-dff-header";
        }else {
            var formId = "#form-dff-line";
        }

        setWhtRefNumber();

        $(formId).find('#txt_wht_flag').change(function(){
            let whtFlag =  $(this).val();
            toggleWhtRefNumber(whtFlag);
        });

        function toggleWhtRefNumber(value)
        {
            if(value == 'Y'){
                $(formId).find('#txt_wht_ref_number').removeAttr("disabled"); 
            }else {
                $(formId).find('#txt_wht_ref_number').attr('disabled','disabled');
            }
        }

        function setWhtRefNumber()
        {
            let whtFlag = $(formId).find('#txt_wht_flag').val();
            toggleWhtRefNumber(whtFlag);
        }

        $("#form-dff-line").submit(function( event ) {
            event.preventDefault();
            let whtFlag = $(formId).find('#txt_wht_flag').val() == 'Y';

            $("#btn-submit-dff-line").attr('disabled', '');
            let form = this;
            if(whtFlag){
                let valid = true;

                let ele_input_pay_for = $(formId).find("input[name='pay_for']");
                let ele_input_group_tax_code = $(formId).find("select[name='group_tax_code']");
                let ele_input_tax_invoice_number = $(formId).find("input[name='tax_invoice_number']");
                let ele_input_tax_invoice_date = $(formId).find("input[name='tax_invoice_date']");
                let ele_input_product_value = $(formId).find("input[name='product_value']");
                let ele_input_address = $(formId).find("input[name='address']");
                let ele_input_branch_number = $(formId).find("input[name='branch_number']");
                let ele_input_tax_id = $(formId).find("input[name='tax_id']");
                let ele_input_wht_ref_number = $(formId).find("input[name='wht_ref_number']");

                ele_input_pay_for.removeClass('err_validate');
                ele_input_pay_for.next("div.error_msg").remove();
                
                ele_input_group_tax_code.removeClass('err_validate');
                ele_input_group_tax_code.next("div.error_msg").remove();
                
                ele_input_tax_invoice_number.removeClass('err_validate');
                ele_input_tax_invoice_number.next("div.error_msg").remove();
                
                ele_input_tax_invoice_date.removeClass('err_validate');
                ele_input_tax_invoice_date.next("div.error_msg").remove();

                ele_input_product_value.removeClass('err_validate');
                ele_input_product_value.next("div.error_msg").remove();
                
                ele_input_address.removeClass('err_validate');
                ele_input_address.next("div.error_msg").remove();

                ele_input_branch_number.removeClass('err_validate');
                ele_input_branch_number.next("div.error_msg").remove();

                ele_input_tax_id.removeClass('err_validate');
                ele_input_tax_id.next("div.error_msg").remove();

                ele_input_wht_ref_number.removeClass('err_validate');
                ele_input_wht_ref_number.next("div.error_msg").remove();

                let pay_for = ele_input_pay_for.val();
                if(!pay_for){
                    valid = false;
                    ele_input_pay_for.addClass('err_validate');
                    ele_input_pay_for.after('<div class="error_msg"> กรุณาระบุจ่ายให้</div>');
                }

                let group_tax_code = ele_input_group_tax_code.val();
                if(!group_tax_code){
                    valid = false;
                    ele_input_group_tax_code.addClass('err_validate');
                    ele_input_group_tax_code.after('<div class="error_msg"> กรุณาระบุรหัสกลุ่มภาษี</div>');
                }

                let tax_invoice_number = ele_input_tax_invoice_number.val();
                if(!tax_invoice_number){
                    valid = false;
                    ele_input_tax_invoice_number.addClass('err_validate');
                    ele_input_tax_invoice_number.after('<div class="error_msg"> กรุณาระบุเลขที่ใบกำกับภาษี</div>');
                }

                let tax_invoice_date = ele_input_tax_invoice_date.val();
                if(!tax_invoice_date){
                    valid = false;
                    ele_input_tax_invoice_date.addClass('err_validate');
                    ele_input_tax_invoice_date.after('<div class="error_msg"> กรุณาระบุวันที่ในใบกำกับภาษี</div>');
                }

                let product_value = ele_input_product_value.val();
                if(!product_value){
                    valid = false;
                    ele_input_product_value.addClass('err_validate');
                    ele_input_product_value.after('<div class="error_msg"> กรุณาระบุมูลค่าสินค้า/บริการ</div>');
                }

                let address = ele_input_address.val();
                if(!address){
                    valid = false;
                    ele_input_address.addClass('err_validate');
                    ele_input_address.after('<div class="error_msg"> กรุณาระบุที่อยู่</div>');
                }

                let branch_number = ele_input_branch_number.val();
                if(!branch_number){
                    valid = false;
                    ele_input_branch_number.addClass('err_validate');
                    ele_input_branch_number.after('<div class="error_msg"> กรุณาระบุสาขาที่</div>');
                }else {
                    if(branch_number.length != 5){
                        valid = false;
                        ele_input_branch_number.addClass('err_validate');
                        ele_input_branch_number.after('<div class="error_msg"> กรุณาระบุสาขาที่ 5 หลัก</div>');
                    }
                }

                let tax_id = ele_input_tax_id.val();
                if(!tax_id){
                    valid = false;
                    ele_input_tax_id.addClass('err_validate');
                    ele_input_tax_id.after('<div class="error_msg"> กรุณาระบุเลขประจำตัว (ภงด)</div>');
                }

                let wht_ref_number = ele_input_wht_ref_number.val();
                if(!wht_ref_number){
                    valid = false;
                    ele_input_wht_ref_number.addClass('err_validate');
                    ele_input_wht_ref_number.after('<div class="error_msg"> กรุณาระบุเลขที่หนังสือรับรอง</div>');
                }

                if(valid){
                    form.submit();
                }else {
                    $("#btn-submit-dff-line").removeAttr('disabled');
                }
            }else {
                
                let valid = true;

                let ele_input_branch_number = $(formId).find("input[name='branch_number']");

                ele_input_branch_number.removeClass('err_validate');
                ele_input_branch_number.next("div.error_msg").remove();

                let branch_number = ele_input_branch_number.val();
                if(branch_number){
                    if(branch_number.length != 5){
                        valid = false;
                        ele_input_branch_number.addClass('err_validate');
                        ele_input_branch_number.after('<div class="error_msg"> กรุณาระบุสาขาที่ 5 หลัก</div>');
                    }
                }

                if(valid){
                    form.submit();
                }else {
                    $("#btn-submit-dff-line").removeAttr('disabled');
                }
            }
        });
    
    });

</script>