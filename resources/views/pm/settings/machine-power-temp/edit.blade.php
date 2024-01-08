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
            <a href="{{ route('pm.settings.machine-power-temp.index') }}">บันทึกกำลังผลิตรายเครื่อง</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>แก้ไข</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <machine-power-temp-edit    :product-period = "{{ json_encode($productPeriod) }}"
                                        :data-machine-power-temp = "{{ json_encode($dataMachinePowerTemp) }}"
                                        :btn-trans = "{{ json_encode($btnTrans) }}"
                                        :uom-list = "{{ json_encode($uomList) }}">
        
            </machine-power-temp-edit>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@stop
