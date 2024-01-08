{!! Form::open(['route' => ['ie.settings.hierarchy-topic.update', $topic->hierarchy_topic_id],'class' => 'form-horizontal','id'=>'form_update_hierarchy_topic']) !!}
@method('PATCH')
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <label class="col-md-3">
                    <div>Code <span class="text-danger">*</span></div>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="code" id="code" autocomplete="off" value="{{$topic->code}}">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <label class="col-md-3">
                    <div>Name <span class="text-danger">*</span></div>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="name" id="name" autocomplete="off" value="{{$topic->name}}">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary" id="btn_update_hierarchy_topic">
                Update
            </button>
        </div>
    </div>
{!! Form::close()!!}

<script type="text/javascript">
    $(document).ready(function() {

        $('#form_update_hierarchy_topic').submit(function() {
            $('#btn_update_hierarchy_topic').attr('disabled', 'disabled');
        });

    });
</script>