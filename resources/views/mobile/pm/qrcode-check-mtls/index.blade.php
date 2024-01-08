
@extends('mobile.layouts.app')
@section('content')
    <div>
        <a href="{{ route('mobiles.index') }}" class="btn btn-dark btn-sm mr-2 pull-left">
            หน้าจอเมนู
        </a>
        <h5 class="mb-0"> &nbsp; </h5>
    </div><br>
    <mb-qrcode-check-mtls-index
        :data="{{ json_encode($data) }}"
        :old-iput="{{ json_encode(count(old()) ? old() : request()->all()) }}"
        :trans-date="{{ json_encode(trans('date')) }}"
        :trans-btn="{{ json_encode(trans('btn')) }}"
        :url="{{ json_encode($url) }}"
        :p-request="{{ json_encode(request()->all()) }}"
    />
@endsection