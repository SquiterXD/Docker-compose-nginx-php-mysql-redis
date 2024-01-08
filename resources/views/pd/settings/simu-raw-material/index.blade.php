@extends('layouts.app')
@section('title', 'PDS0006')
@section('page-title')
  <x-get-page-title menu="" url="/pd/settings/simu-raw-material" />
  {{-- <h2>PDS0006 : กำหนดวัตถุดิบจำลอง</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PD</a>
    </li>
    <li class="breadcrumb-item">
      <a>Setting</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="{{ route('pd.settings.simu-raw-material.index') }}"><strong>กำหนดวัตถุดิบจำลอง</strong></a>
    </li>
  </ol> --}}
@stop
@section('page-title-action')
  <a href="{{ route('pd.settings.simu-raw-material.create') }}" class="btn btn-success">
      <i class="fa fa-plus"></i>  สร้าง
  </a>
@stop

@section('content')
{{-- <div>
  <div class="row">
      <div class="col-12">
          <div class="text-center">
              <h1 class="tw-mt-0"></h1>
              <div class="ibox-content">
                 <form action="" method="GET" autocomplete="off">
                      <simu-search :simulation-types="{{ json_encode($simulationTypes) }}" 
                                      :action-url="{{ json_encode(route('pd.settings.simu-raw-material.index')) }}">
                      </simu-search>
                  </form>                    
              </div>
          </div>
      </div>
      <div class="col-lg-12">
          <div class="m-t-lg">
              <h1 class="tw-mt-0"></h1>
              <div class="ibox-content">
                @include('pd.settings.simu-raw-material._table')
              </div>
          </div>
      </div>
  </div>
</div> --}}
<div class="row">
  <div class="col-lg-12">
      <div class="ibox">
          <div class="ibox-title">
              <div class="ibox-tools"></div>
              <h5>กำหนดวัตถุดิบจำลอง</h5>
          </div>
          <div class="ibox-content">
            <form action="" method="GET" autocomplete="off">
                  <simu-search :simulation-types="{{ json_encode($simulationTypes) }}" 
                                :default-value="{{ json_encode($simuType) }}"
                                :action-url="{{ json_encode(route('pd.settings.simu-raw-material.index')) }}"
                                :search_data="{{ json_encode($searchData) }}">
                  </simu-search>
              </form>                    
          </div>
          <div class="ibox-content mt-3">
              @include('pd.settings.simu-raw-material._table')
          </div>
      </div>
  </div>
</div>

    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดวัตถุดิบจำลอง</h5>
                </div>
                <div class="ibox-content">
                    @include('pd.settings.simu-raw-material._table')
                </div>
            </div>
        </div>
    </div> --}}
@endsection
