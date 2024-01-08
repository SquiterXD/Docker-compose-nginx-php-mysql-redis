@php
    $isNotlock = optional($header)->isNotLock() || in_array(optional($header)->status, ['CLEARED', 'APPROVED']);
@endphp
@if ( in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) )
    
    @if ( $isNotlock )
        {!! Form::open(['route' => ['ie.cash-advances.update_dff', $header->cash_advance_id], 'id' => 'form-dff-header','class' => 'form-horizontal', 'method' => 'patch']) !!}
            {!! Form::hidden('request_type', $requestType) !!}
            <div class="row">
                <div class="col-sm-12">
                    @include('ie.commons.dff._form_select', ['isNotLock' => $isNotlock])
                </div>
            </div>
            <hr class="m-t-sm m-b-sm">
            <div class="row">
                <div class="col-sm-12 mini-scroll-bar" id="div_form_dff" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                    {{-- @include('ie.commons.dff._form') --}}
                </div>
            </div>
            <hr class="m-t-sm m-b-sm">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
                        Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        {!! Form::close()!!}
    @else
        <div id="form-dff-header">
            <div class="row">
                <div class="col-sm-12">
                    @include('ie.commons.dff._form_select', ['isNotLock' => false])
                </div>
            </div>
            <hr class="m-t-sm m-b-sm">
            <div class="row">
                <div class="col-sm-12 mini-scroll-bar" id="div_form_dff" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                    {{-- @include('ie.commons.dff._form') --}}
                </div>
            </div>
        </div>
    @endif

@elseif ($requestType == 'REIMBURSEMENT')

    @if ( $isNotlock )
        {!! Form::open(['route' => ['ie.reimbursements.update_dff', $header->reimbursement_id], 'id' => 'form-dff-header', 'class' => 'form-horizontal', 'method' => 'patch'] ) !!}
            {!! Form::hidden('request_type', $requestType) !!}    
            <div class="row">
                <div class="col-sm-12">
                    @include('ie.commons.dff._form_select', ['isNotLock' => $isNotlock])
                </div>
            </div>
            <hr class="m-t-sm m-b-sm">
            <div class="row">
                <div class="col-sm-12 mini-scroll-bar" id="div_form_dff" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                    {{-- @include('ie.commons.dff._form') --}}
                </div>
            </div>
            <hr class="m-t-sm m-b-sm">
            <div class="row clearfix">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
                        Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        {!! Form::close()!!}
    @else
        <div id="form-dff-header">
            <div class="row">
                <div class="col-sm-12">
                    @include('ie.commons.dff._form_select', ['isNotLock' => false])
                </div>
            </div>
            <hr class="m-t-sm m-b-sm">
            <div class="row">
                <div class="col-sm-12 mini-scroll-bar" id="div_form_dff" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                    {{-- @include('ie.commons.dff._form') --}}
                </div>
            </div>
        </div>
    @endif

@else

    <h3 class="m-b-md">Error</h3>

@endif

<script type="text/javascript">

    $(document).ready(function(){

        var formId = "#form-dff-header";
        var requestId = "{{ $requestId }}";
        var requestType = "{{ $requestType }}";
        var formType = "{{ $formType }}";
        var isNotLock = "{!! $isNotlock !!}";

        $(formId).find(".select2").select2();

        let dffType = $(formId).find("#txt_dff_type").val();
        rederForm(dffType, formType)

        $(formId).find("#txt_dff_type").change(() => {
            let dffType = $(formId).find("#txt_dff_type").val();
            rederForm(dffType, formType);
        });

        function rederForm(dffType, formType)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/dff/get_form",
                type: 'GET',
                data: { dffType : dffType,
                        requestId : requestId,
                        requestType : requestType,
                        formType: formType },
                beforeSend: function( xhr ) {
                    $(formId).find("#div_form_dff").html('\
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
                $(formId).find("#div_form_dff").html(result);
                $(formId).find(".select2").select2({width: "100%"});
                if(isNotLock){
                    $(formId).find('#txt_tax_invoice_date').datepicker({
                        format: 'dd/mm/yyyy',
                        todayBtn: true,
                        multidate: false,
                        keyboardNavigation: false,
                        autoclose: true,
                        todayBtn: "linked"
                    });
                }
            });
        }

    });

</script>