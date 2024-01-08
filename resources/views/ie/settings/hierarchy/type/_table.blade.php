<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="60px;">
                    #
                </th>
                <th width="60%">
                    Name
                </th>
                <th class="text-center">
                    Department
                </th>
                <th width="160px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $index => $type)
                <tr>
                    <td>
                        {{ $index+1 }}
                    </td>
                    <td>
                        {{ $type->name }}
                    </td>
                    <td class="text-center">
                        <i class="fa fa-check-circle" style="color: {{ $type->department_flag ? 'green' : 'gray'}};"></i>
                    </td>
                    <td class="text-right">
                        <button title="Edit" id="btn_edit_hierarchy_type_{{$type->hierarchy_type_id}}" 
                            class="btn btn-xs btn-warning btn-outline" data-hierarchy-type-id="{{$type->hierarchy_type_id}}"> 
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        {!! Form::open(['route' => ['ie.settings.hierarchy-type.destroy', $type->hierarchy_type_id], 
                            'id' => 'form_remove_hierarchy_type_'.$type->hierarchy_type_id, 'class' => 'inline']) !!}
                            @method('DELETE')
                            <button class="btn btn-xs btn-danger btn-outline" title="Delete" id="btn_remove_hierarchy_type_{{$type->hierarchy_type_id}}"
                                data-hierarchy-type-id="{{$type->hierarchy_type_id}}">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        {!! Form::close()!!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>