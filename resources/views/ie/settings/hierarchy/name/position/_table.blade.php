<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="100px;">Seq</th>
                <th>
                    Position
                </th>
                <th width="160px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hierarchy->namePositions as $index => $namePosition)
                <tr>
                    <td>
                        {{ $namePosition->seq }}
                    </td>
                    <td>
                        {{ optional($namePosition->position)->name }}
                    </td>
                    <td class="text-right">
                        <button title="Edit" id="btn_edit_hierarchy_name_position_{{$namePosition->hierarchy_name_position_id}}" 
                            class="btn btn-xs btn-warning btn-outline" data-hierarchy-name-position-id="{{$namePosition->hierarchy_name_position_id}}"> 
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        {!! Form::open(['route' => ['ie.settings.hierarchy-name.position.destroy', $hierarchy->hierarchy_name_id, $namePosition->hierarchy_name_position_id], 
                            'id' => 'form_remove_hierarchy_name_position_'.$namePosition->hierarchy_name_position_id, 'class' => 'inline']) !!}
                            @method('DELETE')
                            <button class="btn btn-xs btn-danger btn-outline" title="Delete" id="btn_remove_hierarchy_name_position_{{$namePosition->hierarchy_name_position_id}}"
                                data-hierarchy-name-position-id="{{$namePosition->hierarchy_name_position_id}}">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        {!! Form::close()!!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>