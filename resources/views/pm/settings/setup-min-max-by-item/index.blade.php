@extends('layouts.app')

@section('title', 'กำหนดค่าเฝ้าระวัง')

{{-- @section('page-title')
    <h2><strong><x-get-program-code url='/pm/settings/setup-min-max-by-item'/> : กำหนดค่าเฝ้าระวัง</strong></h2>
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
            <strong><x-get-program-code url='/pm/settings/setup-min-max-by-item'/> : กำหนดค่าเฝ้าระวัง </strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/pm/settings/setup-min-max-by-item" />
@stop

@section('content')

    {!! Form::open(['route' => ['pm.settings.setup-min-max-by-item.updateOrCreate'] , "method" => "get" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
        <setup-min-max-by-item-search   :tobacco-itemcat-list = "{{ json_encode($tobaccoItemcatList) }}"
                                        :search-old = "{{ json_encode($searchOld) }}"
                                        :btn-trans = "{{ json_encode($btnTrans) }}">
        </setup-min-max-by-item-search>     
    {!! Form::close() !!}                       
    {{-- <setup-min-max-by-item-table    :organizations = "{{ json_encode($organizations) }}"
                                    :list-setup-min-max = "{{ json_encode($listSetupMinMax) }}">
    </setup-min-max-by-item-table> --}}

    {{-- <div class="d-flex justify-content-end md:tw-my-6 tw-my-2 lg:tw-px-0 tw-px-2">
        {{ $listSetupMinMax->appends(Request::all())->links('shared._pagination') }}
    </div> --}}

    {{-- <div class="col-lg-12">
        <div class="text-center m-t-lg">
            <h1 class="tw-mt-0"></h1>
            <div class="ibox-content">
                <setup-min-max-by-item-table :organizations = "{{ json_encode($organizations) }}">
                </setup-min-max-by-item-table>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script>


    </script>
@stop
