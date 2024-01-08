{!! Form::open(['route' => ['ie.settings.hierarchy-position.update', $position->hierarchy_position_id],'class' => 'form-horizontal','id'=>'form_update_hierarchy_position']) !!}
@method('PATCH')
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <label class="col-md-3">
                    <div>Name <span class="text-danger">*</span></div>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="name" id="name" autocomplete="off" value="{{ $position->name }}">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary" id="btn_update_hierarchy_position">
                Update
            </button>
        </div>
    </div>
{!! Form::close()!!}

<script type="text/javascript">
    $(document).ready(function() {

        $('#form_update_hierarchy_position').submit(function() {
            $('#btn_update_hierarchy_position').attr('disabled', 'disabled');
        });

    });
</script>