{!! Form::open([
    'route' => ['ie.reimbursements.set_status',$reim->reimbursement_id],
    'method' => 'POST',
    'id' => 'form-send-request',
    'class' => 'form-horizontal'
]) !!}
{!! Form::hidden('activity','SEND_REQUEST') !!}
<div class="modal-body">
    <div class="row m-b-sm">
        <div class="col-md-12">
            @if($hierarchyTypeLists->count())
                <select class="form-control select2" name="hierarchy_type" id="txt_hierarchy_type">
                    @foreach ($hierarchyTypeLists as $type)
                        <option value="{{ $type->hierarchy_type_id }}" {{ $defaultType->hierarchy_type_id == $type->hierarchy_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            @else
                <div class="text-center">
                    <h5>ไม่มีสายอนุมัติ</h5>
                </div>
            @endif
        </div>
    </div>
    <div class="row {{ $hierarchyTypeLists->count() ? 'm-b-sm' : '' }}">
        <div class="col-md-12" id="div_ddl_hierarchy">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="div_hierarchy_user_list">
            
        </div>
    </div>
    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
    <div class="row">
        <div class="col-md-2">

        </div>
        {{-- <div class="col-md-8">
            <label>Invoice Number</label>
            {!! Form::text('invoice_no', $reim->invoice_no, ['class'=>'form-control','id'=>'txt_invoice_no', 'autocomplete'=>'off']) !!}
        </div> --}}
        {{-- <div class="col-md-6">
            <label>Invoice Date</label>
            {!! Form::text('invoice_date', $reim->invoice_date, ['class'=>'form-control','id'=>'txt_invoice_date', 'autocomplete'=>'off']) !!}
        </div> --}}
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="submit" id="btn-submit-send-request" class="btn btn-sm btn-primary" disabled>Save</button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function(){

        var reimId = "{{ $reim->reimbursement_id }}";

        $('#txt_invoice_date').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked",
        });

        $('.select2').select2({width: "100%"});

        let typeId = $("#txt_hierarchy_type").val();

        if(typeId){
            getHierarchies(typeId);
        }

        $('#txt_hierarchy_type').change(function() {
            getHierarchies($(this).val());
        });

        function getHierarchies(typeId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/get_hierarchies",
                type: 'GET',
                data: {type_id: typeId},
                beforeSend: function( xhr ) {
                    $('#div_hierarchy_user_list').html('');
                    $("#txt_hierarchy_type").prop("disabled", true);
                    $("#btn-submit-send-request").prop("disabled", true);
                    $("#div_ddl_hierarchy").html('\
                    <div class="m-t-sm m-b-sm">\
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
                $("#div_ddl_hierarchy").html(result);
                $("#txt_hierarchy_name_id").select2({width: "100%"});
                $("#txt_hierarchy_type").prop("disabled", false);
                let nameId = $("#txt_hierarchy_name_id").val();
                if(nameId){
                    getHierarchyUserLists(nameId);
                }
            });
        }

        function getHierarchyUserLists(nameId)
        {
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/"+reimId+"/get_hierarchy_user_lists",
                type: 'GET',
                data: {name_id: nameId},
                beforeSend: function( xhr ) {
                    $("#txt_hierarchy_type").prop("disabled", true);
                    $("#txt_hierarchy_name_id").prop("disabled", true);
                    $("#div_hierarchy_user_list").html('\
                    <div class="m-t-sm m-b-sm">\
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
                $("#div_hierarchy_user_list").html(result);
                $("#txt_hierarchy_type").prop("disabled", false);
                $("#txt_hierarchy_name_id").prop("disabled", false);
                $("#btn-submit-send-request").prop("disabled", false);
            });
        }

    });
</script>

