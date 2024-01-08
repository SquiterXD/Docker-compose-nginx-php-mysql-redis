@extends('layouts.app')
@section('title', 'PMS0033')
@section('page-title')
  <h2>อนุมัติสูตรการผลิต</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="#">อนุมัติสูตรการผลิต</a>
    </li>
  </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content" style="border-bottom: 0px;">
                    <div class="col-12 text-right pr-0" >
                        <button class=" {{ trans('btn.approve.class') }} btn-lg tw-w-25">
                            <i class="{{ trans('btn.approve.icon') }}"></i>
                            {{ trans('btn.approve.text') }}
                        </button>

                        <button class=" {{ trans('btn.reject.class') }} btn-lg tw-w-25">
                            <i class="{{ trans('btn.reject.icon') }}"></i>
                            {{ trans('btn.reject.text') }}
                        </button>
                    </div>
                </div>
                <div class="ibox-content">
                    @include('pm.appr-formulas._table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@stop
