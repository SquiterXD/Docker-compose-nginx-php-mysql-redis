@extends('layouts.app')

@section('title', 'เคลมประกันภัย')

@section('page-title')
    <x-get-page-title menu="" url="/ir/claim-insurance" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> แจ้งเหตุการเคลมประกันภัย (Claim Insurance) </h5>
                </div>
                <div class="ibox-content pt-1">
                    <claim-insurance-form
                        :claim="{{ json_encode(null) }}"
                        :file-insurance="{{ json_encode(null) }}"
                        :file-approve="{{ json_encode(null) }}"
                        :user="{{ json_encode($user) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :profile="{{ json_encode($profile) }}"
                        :purl="{{ json_encode($url) }}">
                    </claim-insurance-form>
                </div>
            </div>
        </div>
    </div>
@endsection