{!! Form::open(['route' => ['ie.settings.hierarchy-position.user.store', $positionId],'class' => 'form-horizontal', 'id' => 'form_create_hierarchy_position_user']) !!}
    <div class="row m-b-sm">
        <label class="col-md-2">
            <div class="text-right">User <span class="text-danger">*</span></div>
        </label>
        <div class="col-md-5">
            <select class="form-control select2" name="user_id" id="user_id">
                <option value="">-</option>
                @foreach ($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="checkbox" name="default_flag" id="default_flag" value="true" {{$setDefault ? 'checked' : ''}}>
            <label for="default_flag">
                <div>Default ?</div>
            </label>
        </div>
    </div>
    <hr class="m-t-sm m-b-sm">
    <div class="row">
        <div class="col-sm-12 text-right">
            <button type="submit" class="btn btn-primary" id="btn_create_hierarchy_position_user">
                Add
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
{!! Form::close()!!}

<script type="text/javascript">
    $(document).ready(function() {

        $('#form_create_hierarchy_position_user').submit(function() {
            $('#btn_create_hierarchy_position_user').attr('disabled', 'disabled');
        });

    });
</script>