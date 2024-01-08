<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="40px;">#</th>
                <th>
                    Name
                </th>
                <th width="240px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hierarchies as $index => $hierarchy)
                <tr>
                    <td>
                        {{ $index+1 }}
                    </td>
                    <td>
                        {{ $hierarchy->name }}
                    </td>
                    <td class="text-right">
                        <a type="button" class="btn btn-xs btn-success btn-outline" 
                            href="{{route('ie.settings.hierarchy-name.position.index', $hierarchy->hierarchy_name_id)}}">
                            <i class="fa fa-plus"></i> Position
                        </a>
                        <button title="Edit" id="btn_edit_hierarchy_name_{{$hierarchy->hierarchy_name_id}}" 
                            class="btn btn-xs btn-warning btn-outline" data-hierarchy-name-id="{{$hierarchy->hierarchy_name_id}}"> 
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        {!! Form::open(['route' => ['ie.settings.hierarchy-name.destroy', $hierarchy->hierarchy_name_id], 
                            'id' => 'form_remove_hierarchy_name_'.$hierarchy->hierarchy_name_id, 'class' => 'inline']) !!}
                            @method('DELETE')
                            <button class="btn btn-xs btn-danger btn-outline" title="Delete" id="btn_remove_hierarchy_name_{{$hierarchy->hierarchy_name_id}}"
                                data-hierarchy-name-id="{{$hierarchy->hierarchy_name_id}}">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        {!! Form::close()!!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>