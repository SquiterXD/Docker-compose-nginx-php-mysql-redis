@extends('layouts.app')
@section('title', 'PMS0030')
@section('page-title')
  <h2>PMS0030: กำหนดพื้นที่วางของหน้าเครื่องจักร</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.max-storage.index') }}">กำหนดพื้นที่วางของหน้าเครื่องจักร</a>
    </li>
  </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดพื้นที่วางของหน้าเครื่องจักร</h5>
                </div>
                <div class="ibox-content">
                    <max-storage-form 
                        :item-groups="{{ json_encode($itemGroups) }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                        :default-value="{{ json_encode($maxStorage)}}"
                        :url-save="{{ json_encode(route('pm.settings.max-storage.update', $maxStorage->id)) }}"
                        :url-reset="{{ json_encode(route('pm.settings.max-storage.index')) }}"> 
                    </max-storage-form>
                </div>
            </div>
        </div>
    </div>
@endsection
