@extends('layouts.app')

@section('title', 'บันทึกกำลังผลิตรายเครื่อง')

@section('page-title')
    <h2>
        <x-get-program-code url="/pm/settings/machine-power-temp" /> : บันทึกกำลังผลิตรายเครื่อง
    </h2>
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
            <strong><a href="{{ route('pm.settings.machine-power-temp.index') }}">บันทึกกำลังผลิตรายเครื่อง</a></strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <machine-power-temp-header  :machine-group-list = "{{ json_encode($machineGroupList) }}"
                                        :route-index = "{{ json_encode(route('pm.settings.machine-power-temp.index')) }}"
                                        :btn-trans = "{{ json_encode($btnTrans) }}"
                                        :product-period = "{{ json_encode($productPeriod) }}">
            </machine-power-temp-header>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@stop
