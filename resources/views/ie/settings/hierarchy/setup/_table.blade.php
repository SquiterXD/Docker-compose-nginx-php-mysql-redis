<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="60px">
                    #
                </th>
                <th width="30%">
                    Topic
                </th>
                <th width="20%">
                    Type
                </th>
                <th>
                    Hierarchy
                </th>
                <th width="160px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupDepartment as $department => $setups)
                <tr>
                    <td colspan="5">
                        {{ $department }}
                    </td>
                </tr>
                @foreach ($setups as $row => $setup)
                    <tr>
                        <td>
                            {{ $row+1 }}
                        </td>
                        <td>
                            {{ optional($setup->topic)->name }}
                        </td>
                        <td>
                            {{ optional($setup->type)->name }}
                        </td>
                        <td>
                            {{ optional($setup->name)->name }}
                        </td>
                        <td class="text-right">
                            <a class="btn btn-xs btn-warning btn-outline" href="{{ route('ie.settings.hierarchy-setup.edit', $setup->hierarchy_setup_id) }}"> <i class="fa fa-edit"></i> Edit</a>
                            {!! Form::open(['route' => ['ie.settings.hierarchy-setup.destroy', $setup->hierarchy_setup_id], 
                                'id' => 'form_remove_hierarchy_setup_'.$setup->hierarchy_setup_id, 'class' => 'inline']) !!}
                                @method('DELETE')
                                <button class="btn btn-xs btn-danger btn-outline" title="Delete" id="btn_remove_hierarchy_setup_{{$setup->hierarchy_setup_id}}"
                                    data-hierarchy-setup-id="{{$setup->hierarchy_setup_id}}">
                                    <i class="fa fa-trash"></i> Remove
                                </button>
                            {!! Form::close()!!}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>