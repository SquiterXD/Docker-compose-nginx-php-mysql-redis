@if ($position->positionUsers->count())
    <table class="table table-mini-padding m-b-xs" style="font-size: 0.95em;">
        <thead>
            <tr>
                <th>
                    User Name
                </th>
                <th width="80px" class="text-center"></th>
                <th width="50%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($position->positionUsers as $positionUser)
                <tr>
                    <td>
                        {{ $positionUser->user ? $positionUser->user->name : '-' }} &nbsp;
                        @if ($positionUser->default_flag)
                            <i class="fa fa-check-circle" style="color: green"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if (!$positionUser->default_flag)
                            {!! Form::open(['route' => ['ie.settings.hierarchy-position.user.set_default', $positionUser->hierarchy_position_id, $positionUser->hierarchy_position_user_id], 
                                'id' => 'form_set_default_hierarchy_position_user_'.$positionUser->hierarchy_position_user_id, 'class' => 'inline']) !!}
                                <a title="Set Default" id="btn_set_default_hierarchy_position_user_{{$positionUser->hierarchy_position_user_id}}"
                                    data-hierarchy-position-user-id="{{$positionUser->hierarchy_position_user_id}}">
                                    <i class="fa fa-check" style="color: green"></i>
                                </a>
                            {!! Form::close()!!}
                        @endif
                        {!! Form::open(['route' => ['ie.settings.hierarchy-position.user.destroy', $positionUser->hierarchy_position_id, $positionUser->hierarchy_position_user_id], 
                            'id' => 'form_remove_hierarchy_position_user_'.$positionUser->hierarchy_position_user_id, 'class' => 'inline']) !!}
                            @method('DELETE')
                            <a title="Delete" id="btn_remove_hierarchy_position_user_{{$positionUser->hierarchy_position_user_id}}"
                                data-hierarchy-position-user-id="{{$positionUser->hierarchy_position_user_id}}">
                                <i class="fa fa-trash" style="color: red"></i>
                            </a>
                        {!! Form::close()!!}
                    </td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <h5> No User </h5>
    </div>
@endif