{!! Form::open(['route' => ['ie.settings.hierarchy-type.update', $type->hierarchy_type_id],'class' => 'form-horizontal','id'=>'form_update_hierarchy_type']) !!}
@method('PATCH')
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <label class="col-md-3">
                    <div>Name <span class="text-danger">*</span></div>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" maxlength="255" autocomplete="off" value="{{$type->name}}">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <input type="checkbox" name="department_flag" id="department_flag"
                value="true" {{ $type->department_flag ? 'checked' : ''}}
                {{ $type->hierarchy_type_id ? 'disabled' : '' }}
            > <label for="department_flag">require department?</label> 
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary" id="btn_update_hierarchy_type">
                Update
            </button>
        </div>
    </div>
{!! Form::close()!!}

<script type="text/javascript">
    $(document).ready(function() {

        $('#form_update_hierarchy_type').submit(function() {
            $('#btn_update_hierarchy_type').attr('disabled', 'disabled');
        });

    });
</script>