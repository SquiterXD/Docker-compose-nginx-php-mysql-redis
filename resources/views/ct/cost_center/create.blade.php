@extends('layouts.app')

@section('title', 'สร้างกำหนดศูนย์ต้นทุน')

@section('page-title')
    <h2>กำหนดศูนย์ต้นทุน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item">
            กำหนดศูนย์ต้นทุน
        </li>
        <li class="breadcrumb-item active">
          <strong>สร้าง</strong>
      </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <cost-center-new-create-component></cost-center-new-create-component>
                </div>
            </div>
        </div>
    </div>
@endsection
