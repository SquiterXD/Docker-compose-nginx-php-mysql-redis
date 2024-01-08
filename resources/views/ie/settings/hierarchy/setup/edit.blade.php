@extends('layouts.app')

@section('title', 'Hierarchies')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy-setup" /> Edit Hierarchy Setup <br>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.hierarchy-setup.index') }}">
                Hierarchy Setups
            </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Edit</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox-content">
            {!! Form::open(['route' => ['ie.settings.hierarchy-setup.update', $setup->hierarchy_setup_id],'class' => 'form-horizontal', 'id' => 'form_update_hierarchy_setup']) !!}
                @method('PATCH')
                @include('ie.settings.hierarchy.setup._form')
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button id="btn_update_hierarchy_setup" type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <a class="btn btn-danger" href="{{ route('ie.settings.hierarchy-setup.index') }}">
                            Cancel
                        </a>
                    </div>
                </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".select2").select2();

            var hierarchyTypes = jQuery.parseJSON(JSON.stringify({!! $hierarchyTypes->toJson() !!}));

            let type_id = $("select[id='hierarchy_type_id'] option:selected").val();
            checkRequireDepartment(type_id);

            $('#form_update_hierarchy_setup').submit(function() {
                $('#btn_update_hierarchy_setup').attr('disabled', 'disabled');
            });

            $("#form_update_hierarchy_setup").find('#hierarchy_type_id').change(function(e){
                let type_id = this.value;
                let require =  checkRequireDepartment(type_id);

                let html = require ? 'Department Code <span class="text-danger">*</span>' : 'Department Code';
                $("#form_update_hierarchy_setup").find('#div_department').html(html);
            });

            function checkRequireDepartment(type_id) 
            {
                var array = hierarchyTypes;
                if(type_id != ''){
                    for(i in array) {
                        if(array[i].hierarchy_type_id == type_id) {
                            return parseInt(array[i].department_flag);
                        }
                    }
                }
                return 0;
            };
        });
    </script>
@stop