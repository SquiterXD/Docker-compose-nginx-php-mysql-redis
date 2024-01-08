@if($reim->status == 'APPROVER_DECISION')

{{-- MODAL ENTER DUE DATE --}}
<div class="modal fade" id="enter-due-date" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pt-0 modal-md" role="document" style="width: 400px;">
        <div class="modal-content">
        
        {!! Form::open(['route' => ['ie.reimbursements.set_due_date',$reim->reimbursement_id], 
              'method' => 'POST',
              'id' => 'form-enter-due-date',
              'class' => 'form-horizontal']) !!}

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Enter Due Date & Payments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body clearfix">
                <div class="col-md-12">
                    <div class="row m-b-md">
                        {{-- <div>
                            <label>Payment Method (วิธีการชำระเงิน)</label>
                        </div> --}}
                        {{-- <div class="clearfix m-b-sm">
                            <label class="radio-inline"> 
                                {!! Form::radio('payment_method_type', 'method', true) !!} 
                                Method Payment 
                            </label>
                            <label class="radio-inline"> 
                                {!! Form::radio('payment_method_type', 'manual', false) !!} 
                                Manual Payment 
                            </label>
                        </div> --}}
                        {{-- <div id="div_payment_method_id" class="m-b-sm">
                            {!! Form::select('payment_method_id', [''=>''] + $APPaymentMethodLists, $defaultAPPaymentMethodId,['class'=>'form-control select2','id'=>'ddl_payment_method_id']) !!}
                        </div> --}}
                        <label>Payment Method (วิธีการชำระเงิน)</label>
                        {!! Form::select('payment_method_id', [''=>''] + $APPaymentMethodLists, $defaultAPPaymentMethodId,['class'=>'form-control select2','id'=>'ddl_payment_method_id']) !!}
                    </div>
                    <div class="row m-b-md">
                        <label>Payment Term (เงื่อนไขการชำระเงิน)</label>
                        {!! Form::select('payment_term_id', [''=>'-'] + $APPaymentTermLists, $defaultAPPaymentTermId,['class'=>'form-control select2','id'=>'ddl_payment_term_id']) !!}
                    </div>
                    <div class="row ">
                        <label>Due Date (วันที่กำหนดจ่าย)</label>
                        {!! Form::text('due_date', $reim->due_date, ['class'=>'form-control','id'=>'txt_due_date', 'autocomplete'=>'off']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
            </div>
        {!! Form::close() !!}

        </div>
    </div>
</div>

@endif