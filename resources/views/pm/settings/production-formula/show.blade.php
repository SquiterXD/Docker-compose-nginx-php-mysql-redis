@extends('layouts.app')
@section('title', 'PMS0033')
@section('page-title')
    <x-get-page-title menu="" url="{{ $url }}" />
  {{-- <h2>สูตรการผลิต</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.production-formula.index') }}">สูตรการผลิต</a>
    </li>
  </ol> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title" align="right">
                  <a href="#" data-toggle="modal" data-target="#copy_{{ $ingredient->ingredient_id }}" title="Edit" class="btn btn-success btn-xs">
                    คัดลอกสูตร
                  </a>
                  @include('pm.settings.production-formula._modal_copy')
                  @if ($ingredient->status == 'สร้างใหม่')
                    <a href="{{ route('pm.settings.production-formula.approve', $ingredient->ingredient_id) }}" class="btn btn-success btn-xs">
                      ส่งอนุมัติสูตร
                    </a>
                  @endif
                </div>
                <div class="ibox-content">
                    @include('pm.settings.production-formula._ingradient')
                    @include('pm.settings.production-formula._ingradient_step')
                    @include('pm.settings.production-formula._ingradient_item')
                </div>
            </div>
        </div>
    </div>
@endsection