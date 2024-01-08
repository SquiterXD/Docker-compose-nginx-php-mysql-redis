@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนด Price List {{ $header->attribute1 == 'DOMESTIC' ? '(สำหรับขายในประเทศ)' : '(สำหรับขายต่างประเทศ)' }}</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.price-list._header')

                    @include('om.settings.price-list._line')
                </div>
            </div>
        </div>
    </div>
@endsection