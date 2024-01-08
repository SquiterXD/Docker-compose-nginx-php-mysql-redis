@extends('layouts.app')

@section('title', 'กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน')

@section('page-title')
    <h2> <x-get-program-code url="/pm/settings/print-item-setup" />: กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Setting</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/pm/settings/print-item-setup" />: กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('pm.settings.print-item-setup.create') }}" 
        class="{{$btnTrans['create']['class']}}">
        <i class="{{$btnTrans['create']['icon']}}"></i> 
        {{$btnTrans['create']['text']}}
    </a>
@stop

@section('content')
    {{-- <div class="ibox">
        <div class="ibox-title">
            <h3> XXXXX </h3>
        </div>
        <div class="ibox-content">
            <h3 class="mb-4"> XXXX Search </h3>
            <form method="GET">
                <div class="row space-50 justify-content-md-center">
                </div>
            </form>
        </div>
    </div> --}}

    <div class="ibox">
        <div class="ibox-title">
            <x-get-program-code url="/pm/settings/print-item-setup" />: กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน
        </div>
        {!! Form::open(['route' => ['pm.settings.print-item-setup.index'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}
        <print-item-setup-search    :btn-trans="{{ json_encode($btnTrans) }}"
                                    :item-number-list="{{ json_encode($itemNumberList) }}"
                                    :search="{{ json_encode($search) }}"
                                    :size-list="{{ json_encode($sizeList) }}"
                                    :brand-list="{{ json_encode($brandList) }}"
                                    :product-list="{{ json_encode($productList) }}"
                                    :print-type-list="{{ json_encode($printTypeList) }}"> 

        </print-item-setup-search>
        {!! Form::close() !!}

        <print-item-setup-table :print-item-setup-list = "{{ json_encode($printItemSetupList) }}"
                                :btn-trans="{{ json_encode($btnTrans) }}">
            
        </print-item-setup-table>
    </div>

@endsection

@section('scripts')
    <script>


    </script>
@stop
