@extends('layouts.app')

@section('title', 'IRM0012')

@section('page-title')
    <x-get-page-title menu="" url="/ir/settings/rounding-asset" />
@stop

@section('page-title-action')
    <a href="{{ route('ir.settings.rounding-asset.create') }}" class="{{ trans('btn.create.class') }}">
        <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
    </a>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                       <form action="" method="GET" autocomplete="off">
                            <search-rounding-asset 
                                    :policy-lists="{{ json_encode($policyLists) }}"
                                    :asset-lists="{{ json_encode($assetLists) }}"
                                    :data-search="{{ json_encode($dataSearch) }}"
                                    :action-url="{{ json_encode(route('ir.settings.rounding-asset.index')) }}">
                            </search-rounding-asset>
                        </form>                    
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="m-t-lg">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        @include('ir.settings.rounding-asset._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

