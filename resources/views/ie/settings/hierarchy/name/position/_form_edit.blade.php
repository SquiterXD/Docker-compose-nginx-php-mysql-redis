{!! Form::open(['route' => ['ie.settings.hierarchy-name.position.update', $hierarchy->hierarchy_name_id, $namePosition->hierarchy_name_position_id],'class' => 'form-horizontal','id'=>'form_update_hierarchy_name_position']) !!}
@method('PATCH')
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <label class="col-md-3">
                    <div>Seq <span class="text-danger">*</span></div>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="seq" id="seq" autocomplete="off" value="{{ $namePosition->seq }}">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <label class="col-md-3">
                    <div>Position <span class="text-danger">*</span></div>
                </label>
                <div class="col-md-9">
                    <select class="form-control select2" name="hierarchy_position_id" id="hierarchy_position_id">
                        <option value="">-</option>
                        @foreach ($positions as $position)
                            <option value="{{$position->hierarchy_position_id}}" 
                                {{$position->hierarchy_position_id == $namePosition->hierarchy_position_id ? 'selected' : ''}}>
                                {{$position->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary" id="btn_update_hierarchy_name_position">
                Update
            </button>
        </div>
    </div>
{!! Form::close()!!}

<script type="text/javascript">
    $(document).ready(function() {

        $('#form_update_hierarchy_name_position').submit(function() {
            $('#btn_update_hierarchy_name_position').attr('disabled', 'disabled');
        });

    });
</script>