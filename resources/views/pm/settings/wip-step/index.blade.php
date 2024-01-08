@extends('layouts.app')
@section('title', 'PMS0004')
@section('page-title')
  <h2>PMS0004: กำหนดขั้นตอนการทำงาน</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.wip-step.index') }}">กำหนดขั้นตอนการทำงาน</a>
    </li>
  </ol>
@stop
{{-- @if (canEnter('/lookup?programCode='.$program->program_code) && $program->insert_flag == 'Y') --}}
    @section('page-title-action')
        <a href="{{ route('pm.settings.wip-step.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i>  สร้าง
        </a>
    @stop
{{-- @endif --}}

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดขั้นตอนการทำงาน</h5>
                </div>
                <div class="ibox-content">
                    @include('pm.settings.wip-step._table')
                </div>
            </div>
        </div>
    </div>
@endsection
