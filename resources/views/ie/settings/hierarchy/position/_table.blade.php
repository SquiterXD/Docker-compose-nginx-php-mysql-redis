<div class="table-responsive" id="table_hierarchy_positions">
    <table class="table">
        <thead>
            <tr>
                <th width="40px;"></th>
                <th>
                    Name
                </th>
                <th width="240px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($positions as $index => $position)
                <tr>
                    <td>
                        <a style="margin-right: 5px"
                            class="hierarchy-position-collapse-row"
                            data-hierarchy-position-id="{{ $position->hierarchy_position_id }}">
                            <i class="fa fa-caret-down"></i>
                        </a>
                    </td>
                    <td>
                        {{ $position->name }}
                    </td>
                    <td class="text-right">
                        <button title="Add User" id="btn_add_hierarchy_position_user_{{$position->hierarchy_position_id}}"
                            class="btn btn-xs btn-success btn-outline" data-hierarchy-position-id="{{$position->hierarchy_position_id}}">
                            <i class="fa fa-plus"></i> User
                        </button>
                        <button title="Edit" id="btn_edit_hierarchy_position_{{$position->hierarchy_position_id}}" 
                            class="btn btn-xs btn-warning btn-outline" data-hierarchy-position-id="{{$position->hierarchy_position_id}}"> 
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        {!! Form::open(['route' => ['ie.settings.hierarchy-position.destroy', $position->hierarchy_position_id], 
                            'id' => 'form_remove_hierarchy_position_'.$position->hierarchy_position_id, 'class' => 'inline']) !!}
                            @method('DELETE')
                            <button class="btn btn-xs btn-danger btn-outline" title="Delete" id="btn_remove_hierarchy_position_{{$position->hierarchy_position_id}}"
                                data-hierarchy-position-id="{{$position->hierarchy_position_id}}">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        {!! Form::close()!!}
                    </td>
                </tr>
                <tr style="border-style: none;" id="tr_{{ $position->hierarchy_position_id }}">
                    <td colspan="1" style="font-size: 0.9em;padding-top: 0px;"></td>
                    <td colspan="3" style="font-size: 0.9em;padding-top: 0px;">
                        @include('ie.settings.hierarchy.position.user._table')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>