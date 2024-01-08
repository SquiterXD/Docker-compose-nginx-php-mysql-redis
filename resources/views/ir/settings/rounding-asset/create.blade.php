@extends('layouts.app')

@section('title', 'IRM0012')

@section('page-title')
    <x-get-page-title menu="" url="/ir/settings/rounding-asset" />
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        <form-rounding-asset 
                                :policy-Lists="{{ json_encode($policyLists) }}"
                                :url-save="{{ json_encode(route('ir.settings.rounding-asset.store')) }}"
                                :url-reset="{{ json_encode(route('ir.settings.rounding-asset.index')) }}">
                        </form-rounding-asset>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

