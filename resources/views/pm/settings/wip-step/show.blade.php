@extends('layouts.app')
@section('title', 'PMS0004')
@section('page-title')
  <h2>PMS0004: ขั้นตอนการทำงาน</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.wip-step.index') }}">ขั้นตอนการทำงาน</a>
    </li>
  </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ขั้นตอนการทำงาน</h5>
                </div>
                <div class="ibox-content">
                    @include('pm.settings.wip-step._header')

                    @include('pm.settings.wip-step._line')

                    <hr>
                    <div class="text-right">
                      <a href="{{ route('pm.settings.wip-step.index') }}" class="btn btn-warning btn-xs">
                        ย้อนกลับ
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection