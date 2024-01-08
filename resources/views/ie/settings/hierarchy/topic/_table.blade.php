<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="60px;">
                    #
                </th>
                <th width="30%">
                    Code
                </th>
                <th>
                    Name
                </th>
                <th width="160px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $index => $topic)
                <tr>
                    <td>
                        {{ $index+1 }}
                    </td>
                    <td>
                        {{ $topic->code }}
                    </td>
                    <td>
                        {{ $topic->name }}
                    </td>
                    <td class="text-right">
                        <button title="Edit" id="btn_edit_hierarchy_topic_{{$topic->hierarchy_topic_id}}" 
                            class="btn btn-xs btn-warning btn-outline" data-hierarchy-topic-id="{{$topic->hierarchy_topic_id}}"> 
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        {!! Form::open(['route' => ['ie.settings.hierarchy-topic.destroy', $topic->hierarchy_topic_id], 
                            'id' => 'form_remove_hierarchy_topic_'.$topic->hierarchy_topic_id, 'class' => 'inline']) !!}
                            @method('DELETE')
                            <button class="btn btn-xs btn-danger btn-outline" title="Delete" id="btn_remove_hierarchy_topic_{{$topic->hierarchy_topic_id}}"
                                data-hierarchy-topic-id="{{$topic->hierarchy_topic_id}}">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        {!! Form::close()!!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>