@extends('layouts.app')

@section('title', 'บันทึก Layout สิ่งพิมพ์')

@section('page-title')
    <h2> PMS0023: บันทึก Layout สิ่งพิมพ์ </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><a href="{{ route('pm.settings.save-publication-layout.index') }}"> PMS0023: บันทึก Layout สิ่งพิมพ์ </a></strong>
        </li>
    </ol>
@stop

@section('content')
    {{-- {!! Form::open(['route' => ['pm.settings.save-publication-layout.store'] , 
                            "method" => "post" , 
                            "autocomplete" => "off", 
                            'class' => 'form-horizontal']) !!} --}}
    <save-publication-layout-el-select  :item-number-list = "{{ json_encode($itemNumberList) }}"
                                        :item-cat-list = "{{ json_encode($itemCatList) }}"
                                        :result-search = "{{ json_encode($resultSearch) }}"
                                        :item-number-select-list = "{{ json_encode($itemNumberSelectList) }}"
                                        :url = "{{ json_encode($url) }}"
                                        :new-item = "{{ json_encode($newItem) }}"
                                        >
    </save-publication-layout-el-select>
    {{-- {!! Form::close() !!} --}}

    <div class="d-flex justify-content-end md:tw-my-6 tw-my-2 lg:tw-px-0 tw-px-2">
        {{ $itemNumberList->appends(Request::all())->links('shared._pagination') }}
    </div>

@endsection

@section('scripts')
    <script>

    </script>
@stop
