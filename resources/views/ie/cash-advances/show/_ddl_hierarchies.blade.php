@if($setupLists->count())
    <select class="form-control select2" name="hierarchy_name_id" id="txt_hierarchy_name_id">
        @foreach ($setupLists as $setup)
            <option value="{{ optional($setup->name)->hierarchy_name_id }}">{{ optional($setup->name)->name }}</option>
        @endforeach
    </select>
@else
    <div class="text-center">
        <h5>ไม่มีสายอนุมัติ</h5>
    </div>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        var cashAdvanceId = "{{ $cashAdvance->cash_advance_id }}";

        $('#txt_hierarchy_name_id').change(function() {
            getHierarchyUserLists($(this).val());
        });

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