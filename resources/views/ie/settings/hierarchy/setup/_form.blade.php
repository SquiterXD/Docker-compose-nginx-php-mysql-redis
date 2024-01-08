<div class="row m-b-sm">
    <label class="col-md-2">
        <div>Hierarchy Type <span class="text-danger">*</span></div>
    </label>
    <div class="col-md-7">
        <input type="hidden" name="hierarchy_type_id" value="{{$setup->hierarchy_type_id}}">
        <select class="form-control select2" name="hierarchy_type_id" id="hierarchy_type_id" {{ $setup->hierarchy_setup_id ? 'disabled' : '' }}>
            @foreach ($hierarchyTypes as $type)
                <option value="{{$type->hierarchy_type_id}}" {{ $setup->hierarchy_type_id == $type->hierarchy_type_id ? 'selected' : '' }}>{{$type->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row m-b-sm">
    <label class="col-md-2">
        <div>Topic <span class="text-danger">*</span></div>
    </label>
    <div class="col-md-7">
        <select class="form-control select2" name="hierarchy_topic_id" id="hierarchy_topic_id">
            <option value="">-</option>
            @foreach ($topicLists as $topic)
                <option value="{{$topic->hierarchy_topic_id}}" {{ $setup->hierarchy_topic_id == $topic->hierarchy_topic_id ? 'selected' : '' }}>{{$topic->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row m-b-sm">
    <label class="col-md-2">
        <div id="div_department">Department Code <span class="text-danger">*</span></div>
    </label>
    <div class="col-md-7">
        <select class="form-control select2" name="department_code" id="department_code">
            <option value="">-</option>
            @foreach ($departmentLists as $key => $description)
                <option value="{{$key}}" {{ $setup->department_code == $key ? 'selected' : '' }}>{{$description}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row m-b-sm">
    <label class="col-md-2">
        <div>Hierarchy Name <span class="text-danger">*</span></div>
    </label>
    <div class="col-md-7">
        <select class="form-control select2" name="hierarchy_name_id" id="hierarchy_name_id">
            <option value="">-</option>
            @foreach ($nameLists as $key => $name)
                <option value="{{$name->hierarchy_name_id}}" {{ $setup->hierarchy_name_id == $name->hierarchy_name_id ? 'selected' : '' }}>{{$name->name}}</option>
            @endforeach
        </select>
    </div>
</div>
