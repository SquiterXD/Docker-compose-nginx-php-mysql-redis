@extends('layouts.app')

@section('title', 'ต้นทุนวัตถุดิบมาตรฐาน')

@section('page-title')
    <h2>ต้นทุนวัตถุดิบมาตรฐาน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ต้นทุนวัตถุดิบมาตรฐาน</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('ct.std_raw_material_cost.create') }}" class="btn btn-primary">
        สร้างรายการ
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <std-raw-material-cost-component :is_create="false"></std-raw-material-cost-component>
                </div>
            </div>
        </div>
    </div>
@endsection
