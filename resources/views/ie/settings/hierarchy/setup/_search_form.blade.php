<div class="row d-none" id="div-hierarchy-setup-search-form">
    <div class="col-md-10">
        <form id="hierarchy-setup-search-form" action="{{ url()->current() }}">
            <div class="row mb-2">
                <div class="col-md-4">
                    <label>Type</label>
                    <select name="search[type]" id="txt_type" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($hierarchyTypes as $type)
                            <option value="{{$type->hierarchy_type_id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="">Department</label>
                    <select name="search[department]" id="txt_department" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($departmentLists as $key => $description)
                            <option value="{{$key}}">{{$description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="">Hierarchy Name</label>
                    <select name="search[hierarchy]" id="txt_hierarchy" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($nameLists as $key => $name)
                            <option value="{{$name->hierarchy_name_id}}">{{$name->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-2 text-right d-flex align-items-end flex-column">
        <div class="">
            <button type="button" class="close" id="btn_close_search_form">&times;</button>
        </div>
        <div class="mt-auto">
            <button class="btn btn-default" id="btn_submit_search_form">Search</button>
            <a type="button" class="btn btn-danger" href="{{ url()->current() }}">Clear</a>
        </div>
    </div>
</div>
<div class="row" id="div-btn">
    <div class="col-md-12 text-right">
        <button class="btn btn-default" id="btn_open_search_form">Search</button>
        <a class="btn btn-success" href="{{route('ie.settings.hierarchy-setup.create')}}">
            <i class="fa fa-plus"></i> Create
        </a>
    </div>
</div>