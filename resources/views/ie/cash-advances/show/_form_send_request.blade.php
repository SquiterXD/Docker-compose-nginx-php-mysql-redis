<div class="modal-body">
    <div>
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
        @if (count($pendingRequestLists))
            <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            <div class="row">
                <div class="col-md-12 mini-scroll-bar" style="max-height: 250px; overflow: auto;">
                    @foreach ($pendingRequestLists as $item)
                        <div class="row m-b-sm">
                            <div class="col-md-12">
                                <label>เลขที่บันทึก {!! $item['document_no'] !!}</label>
                                {!! Form::text('setRecordNum['.$item['id'].']', $item['record_number'], ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        var cashAdvanceId = "{{ $cashAdvance->cash_advance_id }}";
        var approveCode = "{{ $approveCode }}";

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
                url: "{{ url('/') }}/ie/cash-advances/"+cashAdvanceId+"/get_hierarchies",
                type: 'GET',
                data: {
                    type_id: typeId,
                    approve_code: approveCode,
                },
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
                url: "{{ url('/') }}/ie/cash-advances/"+cashAdvanceId+"/get_hierarchy_user_lists",
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

