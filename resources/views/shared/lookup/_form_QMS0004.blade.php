@foreach ($programColumns as $programColumn)
    @php
        $defaultValue = $lookup->getOriginal((strtolower($programColumn->column_name)));
    @endphp
    <lookup-select-qms0004  :program-column="{{json_encode($programColumn)}}"
                            :data-name="{{json_encode($programColumn->column_name)}}"
                            :data-lists="{{json_encode($lookup->getSqlData($programColumn->sql_text))}}"
                            :default-value="{{json_encode($defaultValue)}}">
    </lookup-select-qms0004>
@endforeach