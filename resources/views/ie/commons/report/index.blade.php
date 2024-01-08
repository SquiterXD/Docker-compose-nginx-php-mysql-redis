@extends('layouts.app')

@section('title', 'Reports')

@section('page-title')
    <h2>
        Reports<br/>
        <small>รายงาน</small>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>Reports</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Report</label>
                                {!! Form::select('report_name', [''=>'-']+$reportLists, null, ["class" => 'form-control select2', "id"=>"txt_report_name", "autocomplete" => "off"]) !!}
                            </div>
                        </div>
                        <div class="d-none" id="div_ct_invoice">
                            <hr>
                            <form id="form_ct_invoice" action="{{ route('ie.report.ct-invoice') }}" class="form-horizontal" target="_blank">
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">ประเภทเอกสาร <span class="text-danger">*</span></label>
                                        <select name="document_type" class='form-control select2' autocomplete="off" id='ddl_ct_invoice_document_type'>
                                            <option value="">-</option>
                                            <option value="CASH-ADVANCE">ใบยืมเงินทดรอง</option>
                                            <option value="CLEARING">ใบเคลียร์ยืมเงินทดรอง</option>
                                            <option value="REIMBURSEMENT">ใบเบิกเงินสำรองจ่าย / PR - TO AP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">หน่วยงานผู้ขอเบิก / ผู้ยืม</label>
                                        {!! Form::select('department', [''=>'-']+$departmentLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">ชือผู้ขอเบิก / ผู้ยืม</label>
                                        {!! Form::select('requester', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                {{-- <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">Supplier Name</label>
                                        {!! Form::select('supplier_id', [''=>'-']+$supplierLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div> --}}
                                {{-- <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">Entered By</label>
                                        {!! Form::text('preparer', null, ["class" => 'form-control', "autocomplete" => "off"]) !!}
                                    </div>
                                </div> --}}
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">วันที่ขอเบิก / ขอยืมตั้งแต่</label>
                                        {!! Form::text('request_date_from', null, ["class" => 'form-control', "id"=>"txt_request_date_from", "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงวันที่ขอเบิก / ขอยืม</label>
                                        {!! Form::text('request_date_to', null, ["class" => 'form-control', "id"=>"txt_request_date_to","autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">เลขที่ใบแจ้งหนี้ตั้งแต่</label>
                                        {!! Form::select('invoice_no_from', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงเลขที่ใบแจ้งหนี้</label>
                                        {!! Form::select('invoice_no_to', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">เลขที่เอกสารตั้งแต่</label>
                                        {!! Form::select('document_no_from', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงเลขที่เอกสาร</label>
                                        {!! Form::select('document_no_to', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" id="btn-submit-ct-invoice" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-none" id="div_ct_wht">
                            <hr>
                            <form id="form_ct_wht" action="{{ route('ie.report.ct-wht') }}" class="form-horizontal" target="_blank">
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">รหัสกลุ่มภาษี</label>
                                        {!! Form::select('group_tax_type', $groupTaxCodes, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ประเภทภาษี <span class="text-danger">*</span></label>
                                        {!! Form::select('wht_type', [''=>'-']+$whtTypeLists, null, ["class" => 'form-control select2', "autocomplete" => "off", "id"=>'ddl_ct_wht_wht_type']) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">รหัสผู้ยืม</label>
                                        {!! Form::text('preparer', null, ["class" => 'form-control', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ประเภทเอกสาร <span class="text-danger">*</span></label>
                                        <select name="document_type" class='form-control select2' autocomplete="off" id='ddl_ct_wht_document_type'>
                                            <option value="">-</option>
                                            <option value="CASH-ADVANCE">ใบยืมเงินทดรอง</option>
                                            <option value="CLEARING">ใบเคลียร์ยืมเงินทดรอง</option>
                                            <option value="REIMBURSEMENT">ใบเบิกเงินสำรองจ่าย / PR - TO AP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">วันที่เริ่มต้น <span class="text-danger">*</span></label>
                                        {!! Form::text('start_date', null, ["class" => 'form-control', "id"=>"txt_start_date", "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">วันที่สิ้นสุด <span class="text-danger">*</span></label>
                                        {!! Form::text('end_date', null, ["class" => 'form-control', "id"=>"txt_end_date", "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">เลขที่เอกสารตั้งแต่</label>
                                        {!! Form::select('document_no_from', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงเลขที่เอกสาร</label>
                                        {!! Form::select('document_no_to', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" id="btn-submit-ct-wht" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-none" id="div_ct_ca">
                            <hr>
                            <form id="form_ct_ca_register" action="{{ route('ie.report.ct-ca') }}" class="form-horizontal" target="_blank">
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">วันที่ยืม ตั้งแต่ <span class="text-danger">*</span></label>
                                        {!! Form::text('start_date', null, ["class" => 'form-control', "id"=>"txt_start_date", "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">วันที่ยืม ถึง <span class="text-danger">*</span></label>
                                        {!! Form::text('end_date', null, ["class" => 'form-control', "id"=>"txt_end_date", "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">หน่วยงาน ตั้งแต่</label>
                                        {!! Form::select('department_from', [''=>'-']+$departmentLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">หน่วยงาน ถึง</label>
                                        {!! Form::select('department_to', [''=>'-']+$departmentLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">ประเภทการยืม</label>
                                        <select name="advance_type" class='form-control select2' autocomplete="off" id='ddl_advance_type'>
                                            <option value="">-</option>
                                            <option value="ในประเทศ">ในประเทศ</option>
                                            <option value="ต่างประเทศ">ต่างประเทศ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">ชื่อผู้ยืม</label>
                                        {!! Form::text('requester', null, ["class" => 'form-control', "autocomplete" => "off", "maxlength" => "255"]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" id="btn-submit-ct-ca" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-none" id="div_ct_budget">
                            <hr>
                            <form id="form_ct_budget" action="{{ route('ie.report.ct-budget') }}" class="form-horizontal" target="_blank">
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">หน่วยงาน Requester<span class="text-danger">*</span></label>
                                        {!! Form::select('department', [''=>'-']+$departmentLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ประเภทเอกสาร <span class="text-danger">*</span></label>
                                        <select name="document_type" class='form-control select2' autocomplete="off" id='ddl_ct_budget_document_type'>
                                            <option value="">-</option>
                                            <option value="CASH-ADVANCE">ใบยืมเงินทดรอง</option>
                                            <option value="CLEARING">ใบเคลียร์ยืมเงินทดรอง</option>
                                            <option value="REIMBURSEMENT">ใบเบิกเงินสำรองจ่าย / PR - TO AP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">เลขที่เอกสารตั้งแต่</label>
                                        {!! Form::select('document_no_from', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off", "maxlength" => "255"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงเลขที่เอกสาร</label>
                                        {!! Form::select('document_no_to', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off", "maxlength" => "255"]) !!}
                                    </div>
                                    {{-- <label for="">เลขที่เอกสาร</label>
                                    {!! Form::text('document_no', null, ["class" => 'form-control', "autocomplete" => "off", "maxlength" => "255"]) !!} --}}
                                </div>
                                <div class="row m-b-sm d-none" id="div_need_by_date">
                                    <div class="col-md-12">
                                        <label for="">วันที่ต้องการรับเงิน</label>
                                        {!! Form::text('need_by_date', null, ["class" => 'form-control', "id"=>"txt_need_by_date", "autocomplete" => "off", "maxlength" => "255"]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" id="btn-submit-ct-budget" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-none" id="div_ct_vat">
                            <hr>
                            <form id="form_ct_vat" action="{{ route('ie.report.ct-vat') }}" class="form-horizontal" target="_blank">
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">ประเภทเอกสาร <span class="text-danger">*</span></label>
                                        <select name="document_type" class='form-control select2' autocomplete="off" id='ddl_ct_vat_document_type'>
                                            <option value="">-</option>
                                            <option value="CASH-ADVANCE">ใบยืมเงินทดรอง</option>
                                            <option value="CLEARING">ใบเคลียร์ยืมเงินทดรอง</option>
                                            <option value="REIMBURSEMENT">ใบเบิกเงินสำรองจ่าย / PR - TO AP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">หน่วยงานผู้ขอเบิก / ผู้ยืม</label>
                                        {!! Form::select('department', [''=>'-']+$departmentLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">ชือผู้ขอเบิก / ผู้ยืม</label>
                                        {!! Form::select('requester', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                {{-- <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">Supplier Name</label>
                                        {!! Form::select('supplier_id', [''=>'-']+$supplierLists, null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div> --}}
                                {{-- <div class="row m-b-sm">
                                    <div class="col-md-12">
                                        <label for="">Entered By</label>
                                        {!! Form::text('preparer', null, ["class" => 'form-control', "autocomplete" => "off"]) !!}
                                    </div>
                                </div> --}}
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">วันที่ขอเบิก / ขอยืมตั้งแต่</label>
                                        {!! Form::text('request_date_from', null, ["class" => 'form-control', "id"=>"txt_request_date_from", "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงวันที่ขอเบิก / ขอยืม</label>
                                        {!! Form::text('request_date_to', null, ["class" => 'form-control', "id"=>"txt_request_date_to","autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">เลขที่ใบแจ้งหนี้ตั้งแต่</label>
                                        {!! Form::select('invoice_no_from', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงเลขที่ใบแจ้งหนี้</label>
                                        {!! Form::select('invoice_no_to', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <div class="row m-b-sm">
                                    <div class="col-md-6">
                                        <label for="">เลขที่เอกสารตั้งแต่</label>
                                        {!! Form::select('document_no_from', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">ถึงเลขที่เอกสาร</label>
                                        {!! Form::select('document_no_to', [''=>'-'], null, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" id="btn-submit-ct-vat" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function() {

            var defaultDepartment = "{{ optional(optional(Auth::user())->PersonalDeptLocation)->dept_cd_f02 ?? null }}";

            $("#div_ct_budget").find("select[name='department']").val(defaultDepartment);

            $(".select2").select2({width: "100%"});

            $('#txt_request_date_from, #txt_request_date_to, #txt_start_date, #txt_end_date, #txt_need_by_date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                multidate: false,
                keyboardNavigation: false,
                autoclose: true,
                todayBtn: "linked"
            });

            // $('#txt_request_date_to').datepicker({
            //     format: 'dd/mm/yyyy',
            //     todayBtn: true,
            //     multidate: false,
            //     keyboardNavigation: false,
            //     autoclose: true,
            //     todayBtn: "linked"
            // });

            $("#div_ct_invoice").find("select[name='document_type']").change(() =>{
                getCtInvoiceDocument();
            });

            $("#div_ct_invoice").find("select[name='department']").change(() =>{
                getCtInvoiceDepartment();
            });

            $("#div_ct_invoice").find("select[name='requester']").change(() =>{
                getCtInvoiceDocument();
            });

            $("#div_ct_vat").find("select[name='document_type']").change(() =>{
                getCtVatDocument();
            });

            $("#div_ct_vat").find("select[name='department']").change(() =>{
                getCtVatDepartment();
            });

            $("#div_ct_vat").find("select[name='requester']").change(() =>{
                getCtVatDocument();
            });

            $("#div_ct_wht").find("select[name='document_type']").change(() =>{
                getCtWhtDocument();
            });

            $("#div_ct_wht").find("select[name='group_tax_type']").change(() =>{
                getCtWhtDocument();
            });

            $("#div_ct_wht").find("select[name='wht_type']").change(() =>{
                getCtWhtDocument();
            });

            $("#div_ct_budget").find("select[name='document_type']").change(() =>{
                let department = $("#div_ct_budget").find("select[name='department']").val();
                if(department){
                    getCtBudgetDocument();
                }
            });

            $("#div_ct_budget").find("select[name='department']").change(() =>{
                let docType = $("#div_ct_budget").find("select[name='document_type']").val();
                if(docType){
                    getCtBudgetDocument();
                }
            });

            $('#txt_report_name').change(() =>{
                let reportName = $('#txt_report_name').val();

                showCtInvoice(reportName == 'ct-invoice');
                showCtWht(reportName == 'ct-wht');
                showCtCa(reportName == 'ct-ca');
                showCtBudget(reportName == 'ct-budget');
                showCtVat(reportName == 'ct-vat');
            });

            $('#ddl_ct_budget_document_type').change(() =>{
                let docType = $('#ddl_ct_budget_document_type').val();

                showNeedByDate( ['CASH-ADVANCE', 'CLEARING'].includes(docType) );
            });

            $('#btn-submit-ct-invoice').click(() =>{
                event.preventDefault();
                let formId = '#form_ct_invoice';
                let valid = true;
                let docType = $(formId).find('#ddl_ct_invoice_document_type').val();

                $(formId).find("#ddl_ct_invoice_document_type").removeClass('err_validate');
                $(formId).find("#ddl_ct_invoice_document_type").next("div.error_msg").remove();
                
                if(!docType){
                    $(formId).find("#ddl_ct_invoice_document_type").addClass('err_validate');
                    $(formId).find("#ddl_ct_invoice_document_type").after('<div class="error_msg"> กรุณาเลือกประเภทเอกสาร</div>');
                    valid = false;
                }
                
                if(valid) {
                    $(formId).submit();
                }
            });

            $('#btn-submit-ct-wht').click(() =>{
                event.preventDefault();
                let formId = '#form_ct_wht';
                let valid = true;
                let wht_type = $(formId).find('#ddl_ct_wht_wht_type').val();
                let start = $(formId).find('#txt_start_date').val();
                let end = $(formId).find('#txt_end_date').val();
                let docType = $(formId).find('#ddl_ct_wht_document_type').val();

                $(formId).find("#ddl_ct_wht_wht_type").removeClass('err_validate');
                $(formId).find("#ddl_ct_wht_wht_type").next("div.error_msg").remove();
                $(formId).find("#txt_start_date").removeClass('err_validate');
                $(formId).find("#txt_start_date").next("div.error_msg").remove();
                $(formId).find("#txt_end_date").removeClass('err_validate');
                $(formId).find("#txt_end_date").next("div.error_msg").remove();
                $(formId).find("#ddl_ct_wht_document_type").removeClass('err_validate');
                $(formId).find("#ddl_ct_wht_document_type").next("div.error_msg").remove();

                if(!wht_type){
                    $(formId).find("#ddl_ct_wht_wht_type").addClass('err_validate');
                    $(formId).find("#ddl_ct_wht_wht_type").after('<div class="error_msg"> กรุณากรอกประเภทภาษี</div>');
                    valid = false;
                }

                if(!start){
                    $(formId).find("#txt_start_date").addClass('err_validate');
                    $(formId).find("#txt_start_date").after('<div class="error_msg"> กรุณากรอกวันที่เริ่มต้น</div>');
                    valid = false;
                }

                if(!end){
                    $(formId).find("#txt_end_date").addClass('err_validate');
                    $(formId).find("#txt_end_date").after('<div class="error_msg"> กรุณากรอกวันที้สิ้นสุด</div>');
                    valid = false;
                }
                
                if(!docType){
                    $(formId).find("#ddl_ct_wht_document_type").addClass('err_validate');
                    $(formId).find("#ddl_ct_wht_document_type").after('<div class="error_msg"> กรุณาเลือกประเภทเอกสาร</div>');
                    valid = false;
                }
                
                if(valid) {
                    $(formId).submit();
                }
            });

            $('#btn-submit-ct-ca').click(() =>{
                event.preventDefault();
                let formId = '#form_ct_ca_register';
                let valid = true;
                let start = $(formId).find('#txt_start_date').val();
                let end = $(formId).find('#txt_end_date').val();

                $(formId).find("#txt_start_date").removeClass('err_validate');
                $(formId).find("#txt_start_date").next("div.error_msg").remove();
                $(formId).find("#txt_end_date").removeClass('err_validate');
                $(formId).find("#txt_end_date").next("div.error_msg").remove();

                if(!start){
                    $(formId).find("#txt_start_date").addClass('err_validate');
                    $(formId).find("#txt_start_date").after('<div class="error_msg"> กรุณากรอกวันที่ยืม</div>');
                    valid = false;
                }

                if(!end){
                    $(formId).find("#txt_end_date").addClass('err_validate');
                    $(formId).find("#txt_end_date").after('<div class="error_msg"> กรุณากรอกวันที่ยืม</div>');
                    valid = false;
                }
                
                if(valid) {
                    $(formId).submit();
                }
            });

            $('#btn-submit-ct-budget').click(() =>{
                event.preventDefault();
                let formId = '#form_ct_budget';
                let valid = true;
                let department = $(formId).find("select[name='department'] option:selected").val();
                let docType = $(formId).find('#ddl_ct_budget_document_type').val();

                $(formId).find("select[name='department']").removeClass('err_validate');
                $(formId).find("select[name='department']").next("div.error_msg").remove();
                $(formId).find("#ddl_ct_budget_document_type").removeClass('err_validate');
                $(formId).find("#ddl_ct_budget_document_type").next("div.error_msg").remove();

                if(!department){
                    $(formId).find("select[name='department']").addClass('err_validate');
                    $(formId).find("select[name='department']").after('<div class="error_msg"> กรุณาเลือกหน่วยงาน</div>');
                    valid = false;
                }

                if(!docType){
                    $(formId).find("#ddl_ct_budget_document_type").addClass('err_validate');
                    $(formId).find("#ddl_ct_budget_document_type").after('<div class="error_msg"> กรุณาเลือกประเภทเอกสาร</div>');
                    valid = false;
                }

                if(valid){
                    $(formId).submit();
                }
            });

            $('#btn-submit-ct-vat').click(() =>{
                event.preventDefault();
                let formId = '#form_ct_vat';
                let valid = true;
                let docType = $(formId).find('#ddl_ct_vat_document_type').val();

                $(formId).find("#ddl_ct_vat_document_type").removeClass('err_validate');
                $(formId).find("#ddl_ct_vat_document_type").next("div.error_msg").remove();
                
                if(!docType){
                    $(formId).find("#ddl_ct_vat_document_type").addClass('err_validate');
                    $(formId).find("#ddl_ct_vat_document_type").after('<div class="error_msg"> กรุณาเลือกประเภทเอกสาร</div>');
                    valid = false;
                }
                
                if(valid) {
                    $(formId).submit();
                }
            });

            function showCtInvoice(check)
            {
                let form = '#div_ct_invoice';
                if(check){
                    $(form).removeClass('d-none');
                }else {
                    $(form).addClass('d-none');
                }
            }

            function showCtWht(check)
            {
                let form = '#div_ct_wht';
                if(check){
                    $(form).removeClass('d-none');
                }else {
                    $(form).addClass('d-none');
                }
            }

            function showCtCa(check)
            {
                let form = '#div_ct_ca';
                if(check){
                    $(form).removeClass('d-none');
                }else {
                    $(form).addClass('d-none');
                }
            }

            function showCtBudget(check)
            {
                let form = '#div_ct_budget';
                if(check){
                    $(form).removeClass('d-none');
                }else {
                    $(form).addClass('d-none');
                }
            }

            function showCtVat(check)
            {
                let form = '#div_ct_vat';
                if(check){
                    $(form).removeClass('d-none');
                }else {
                    $(form).addClass('d-none');
                }
            }

            function showNeedByDate(check)
            {
                let form = '#div_need_by_date';
                if(check){
                    $(form).removeClass('d-none');
                }else {
                    $(form).addClass('d-none');
                }
            }

            function getCtInvoiceDepartment()
            {
                let department = $("#div_ct_invoice").find("select[name='department']").val();
                $.ajax({
                    type: "get",
                    url:  "{{ url('/') }}/ie/report/ct-invoice/getCtInvoiceRequester",
                    data: {
                        _token: "{{ csrf_token() }}",
                        department: department,
                    },
                    beforeSend: function() {
                    },
                    success: function (response) {
                        var result = [{
                            id: '',
                            text: '-'
                        }];

                        for(var i in response){
                            result.push({
                                id: i,
                                text: response[i]
                            })
                        }

                        if(result.length){
                            $("#div_ct_invoice").find("select[name='requester']").html('').select2({data: result});
                        }else {
                            $("#div_ct_invoice").find("select[name='requester']").html('').select2({data: [{id: '', text: '-'}]});
                        }
                    },
                    error: function(evt, xhr, status) {
                        swal(evt.responseJSON.message, null, "error");
                    },
                    complete: function(data) {
                        $("#div_ct_invoice").find("select[name='requester']").val('').change();
                    }
                });
            }

            function getCtInvoiceDocument()
            {
                let department = $("#div_ct_invoice").find("select[name='department']").val();
                let docType = $("#div_ct_invoice").find("select[name='document_type']").val();
                let requester = $("#div_ct_invoice").find("select[name='requester']").val();

                if(docType){
                    $.ajax({
                        type: "get",
                        url:  "{{ url('/') }}/ie/report/ct-invoice/getCtInvoiceDocument",
                        data: {
                            _token: "{{ csrf_token() }}",
                            department: department,
                            requester: requester,
                            doc_type: docType,
                        },
                        beforeSend: function() {
                        },
                        success: function (response) {
                            var resultDoc = [{
                                id: '',
                                text: '-'
                            }];

                            var resultInv = [{
                                id: '',
                                text: '-'
                            }];

                            for(var i in response){
                                resultDoc.push({
                                    id: response[i].document_no,
                                    text: response[i].document_no
                                });

                                if(response[i].invoice_no){
                                    resultInv.push({
                                        id: response[i].invoice_no,
                                        text: response[i].invoice_no
                                    });
                                }
                            }

                            resultInv.sort((a, b) => {
                                let fa = a.text.toLowerCase(),
                                    fb = b.text.toLowerCase();

                                if (fa < fb) {
                                    return -1;
                                }
                                if (fa > fb) {
                                    return 1;
                                }
                                return 0;
                            });

                            if(resultDoc.length){
                                $("#div_ct_invoice").find("select[name='document_no_from']").html('').select2({data: resultDoc});
                                $("#div_ct_invoice").find("select[name='document_no_to']").html('').select2({data: resultDoc});
                            }else {
                                $("#div_ct_invoice").find("select[name='document_no_from']").html('').select2({data: [{id: '', text: '-'}]});
                                $("#div_ct_invoice").find("select[name='document_no_to']").html('').select2({data: [{id: '', text: '-'}]});
                            }

                            if(resultInv.length){
                                $("#div_ct_invoice").find("select[name='invoice_no_from']").html('').select2({data: resultInv});
                                $("#div_ct_invoice").find("select[name='invoice_no_to']").html('').select2({data: resultInv});
                            }else {
                                $("#div_ct_invoice").find("select[name='invoice_no_from']").html('').select2({data: [{id: '', text: '-'}]});
                                $("#div_ct_invoice").find("select[name='invoice_no_to']").html('').select2({data: [{id: '', text: '-'}]});
                            }
                        },
                        error: function(evt, xhr, status) {
                            swal(evt.responseJSON.message, null, "error");
                        },
                        complete: function(data) {
                            $("#div_ct_invoice").find("select[name='document_no_from']").val('').change();
                            $("#div_ct_invoice").find("select[name='document_no_to']").val('').change();
                            $("#div_ct_invoice").find("select[name='invoice_no_from']").val('').change();
                            $("#div_ct_invoice").find("select[name='invoice_no_to']").val('').change();
                        }
                    });
                }
            }

            function getCtWhtDocument()
            {
                let docType = $("#div_ct_wht").find("select[name='document_type']").val();
                let groupTaxCode = $("#div_ct_wht").find("select[name='group_tax_type']").val();
                let whtType = $("#div_ct_wht").find("select[name='wht_type']").val();

                if(docType){
                    $.ajax({
                        type: "get",
                        url:  "{{ url('/') }}/ie/report/ct-wht/getCtWhtDocument",
                        data: {
                            _token: "{{ csrf_token() }}",
                            doc_type: docType,
                            group_tax_code: groupTaxCode,
                            wht_type: whtType,
                        },
                        beforeSend: function() {
                        },
                        success: function (response) {
                            var resultDoc = [{
                                id: '',
                                text: '-'
                            }];

                            for(var i in response){
                                resultDoc.push({
                                    id: response[i].document_no,
                                    text: response[i].document_no
                                });
                            }

                            if(resultDoc.length){
                                $("#div_ct_wht").find("select[name='document_no_from']").html('').select2({data: resultDoc});
                                $("#div_ct_wht").find("select[name='document_no_to']").html('').select2({data: resultDoc});
                            }else {
                                $("#div_ct_wht").find("select[name='document_no_from']").html('').select2({data: [{id: '', text: '-'}]});
                                $("#div_ct_wht").find("select[name='document_no_to']").html('').select2({data: [{id: '', text: '-'}]});
                            }
                        },
                        error: function(evt, xhr, status) {
                            swal(evt.responseJSON.message, null, "error");
                        },
                        complete: function(data) {
                            $("#div_ct_wht").find("select[name='document_no_from']").val('').change();
                            $("#div_ct_wht").find("select[name='document_no_to']").val('').change();
                        }
                    });
                }
            }

            function getCtBudgetDocument()
            {
                let department = $("#div_ct_budget").find("select[name='department']").val();
                let docType = $("#div_ct_budget").find("select[name='document_type']").val();

                if(docType && department){
                    $.ajax({
                        type: "get",
                        url:  "{{ url('/') }}/ie/report/ct-budget/getCtBudgetDocument",
                        data: {
                            _token: "{{ csrf_token() }}",
                            department: department,
                            doc_type: docType,
                        },
                        beforeSend: function() {
                        },
                        success: function (response) {
                            var resultDoc = [{
                                id: '',
                                text: '-'
                            }];

                            for(var i in response){
                                resultDoc.push({
                                    id: response[i].document_no,
                                    text: response[i].document_no
                                });
                            }

                            if(resultDoc.length){
                                $("#div_ct_budget").find("select[name='document_no_from']").html('').select2({data: resultDoc});
                                $("#div_ct_budget").find("select[name='document_no_to']").html('').select2({data: resultDoc});
                            }else {
                                $("#div_ct_budget").find("select[name='document_no_from']").html('').select2({data: [{id: '', text: '-'}]});
                                $("#div_ct_budget").find("select[name='document_no_to']").html('').select2({data: [{id: '', text: '-'}]});
                            }
                        },
                        error: function(evt, xhr, status) {
                            swal(evt.responseJSON.message, null, "error");
                        },
                        complete: function(data) {
                            $("#div_ct_budget").find("select[name='document_no_from']").val('').change();
                            $("#div_ct_budget").find("select[name='document_no_to']").val('').change();
                        }
                    });
                }
            }

            function getCtVatDepartment()
            {
                let department = $("#div_ct_vat").find("select[name='department']").val();
                $.ajax({
                    type: "get",
                    url:  "{{ url('/') }}/ie/report/ct-vat/getCtVatRequester",
                    data: {
                        _token: "{{ csrf_token() }}",
                        department: department,
                    },
                    beforeSend: function() {
                    },
                    success: function (response) {
                        var result = [{
                            id: '',
                            text: '-'
                        }];

                        for(var i in response){
                            result.push({
                                id: i,
                                text: response[i]
                            })
                        }

                        if(result.length){
                            $("#div_ct_vat").find("select[name='requester']").html('').select2({data: result});
                        }else {
                            $("#div_ct_vat").find("select[name='requester']").html('').select2({data: [{id: '', text: '-'}]});
                        }
                    },
                    error: function(evt, xhr, status) {
                        swal(evt.responseJSON.message, null, "error");
                    },
                    complete: function(data) {
                        $("#div_ct_vat").find("select[name='requester']").val('').change();
                    }
                });
            }

            function getCtVatDocument()
            {
                let department = $("#div_ct_vat").find("select[name='department']").val();
                let docType = $("#div_ct_vat").find("select[name='document_type']").val();
                let requester = $("#div_ct_vat").find("select[name='requester']").val();

                if(docType){
                    $.ajax({
                        type: "get",
                        url:  "{{ url('/') }}/ie/report/ct-vat/getCtVatDocument",
                        data: {
                            _token: "{{ csrf_token() }}",
                            department: department,
                            requester: requester,
                            doc_type: docType,
                        },
                        beforeSend: function() {
                        },
                        success: function (response) {
                            var resultDoc = [{
                                id: '',
                                text: '-'
                            }];

                            var resultInv = [{
                                id: '',
                                text: '-'
                            }];

                            for(var i in response){
                                resultDoc.push({
                                    id: response[i].document_no,
                                    text: response[i].document_no
                                });

                                if(response[i].invoice_no){
                                    resultInv.push({
                                        id: response[i].invoice_no,
                                        text: response[i].invoice_no
                                    });
                                }
                            }

                            resultInv.sort((a, b) => {
                                let fa = a.text.toLowerCase(),
                                    fb = b.text.toLowerCase();

                                if (fa < fb) {
                                    return -1;
                                }
                                if (fa > fb) {
                                    return 1;
                                }
                                return 0;
                            });

                            if(resultDoc.length){
                                $("#div_ct_vat").find("select[name='document_no_from']").html('').select2({data: resultDoc});
                                $("#div_ct_vat").find("select[name='document_no_to']").html('').select2({data: resultDoc});
                            }else {
                                $("#div_ct_vat").find("select[name='document_no_from']").html('').select2({data: [{id: '', text: '-'}]});
                                $("#div_ct_vat").find("select[name='document_no_to']").html('').select2({data: [{id: '', text: '-'}]});
                            }

                            if(resultInv.length){
                                $("#div_ct_vat").find("select[name='invoice_no_from']").html('').select2({data: resultInv});
                                $("#div_ct_vat").find("select[name='invoice_no_to']").html('').select2({data: resultInv});
                            }else {
                                $("#div_ct_vat").find("select[name='invoice_no_from']").html('').select2({data: [{id: '', text: '-'}]});
                                $("#div_ct_vat").find("select[name='invoice_no_to']").html('').select2({data: [{id: '', text: '-'}]});
                            }
                        },
                        error: function(evt, xhr, status) {
                            swal(evt.responseJSON.message, null, "error");
                        },
                        complete: function(data) {
                            $("#div_ct_vat").find("select[name='document_no_from']").val('').change();
                            $("#div_ct_vat").find("select[name='document_no_to']").val('').change();
                            $("#div_ct_vat").find("select[name='invoice_no_from']").val('').change();
                            $("#div_ct_vat").find("select[name='invoice_no_to']").val('').change();
                        }
                    });
                }
            }

        });

    </script>
@stop