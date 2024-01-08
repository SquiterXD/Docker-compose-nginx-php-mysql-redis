@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/qm/moth-outbreaks/create" /> สร้างตัวอย่างการตรวจสอบ : การระบาดของมอดยาสูบ </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('qm.moth-outbreaks.result') }}"> การระบาดของมอดยาสูบ </a>
        </li>
        <li class="breadcrumb-item">
            สร้างตัวอย่างการตรวจสอบ
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> สร้างตัวอย่างการตรวจสอบ : การระบาดของมอดยาสูบ </h5>
        </div>

        <div class="ibox-content qm-content">

            {!! Form::open(['route' => ['qm.moth-outbreaks.store'], 'method' => 'post', 'autocomplete' => 'off', 'class' => 'form-horizontal', 'onsubmit' => 'submitForm(this);']) !!}

            @include('qm.moth-outbreaks._form')

            <hr>

            <div class="row justify-content-center clearfix m-t-lg text-right">
                <div class="col-lg-6 col-md-8">
                    <button class="btn btn-sm btn-success" type="submit" name="submitButton">
                        <i class="fa fa-plus"></i> สร้างเลขที่การตรวจสอบ
                    </button>
                    <a type="button" href="{{ route('qm.tobaccos.result') }}" class="btn btn-sm btn-danger tw-ml-4">
                        <i class="fa fa-times"></i> ยกเลิก
                    </a>
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        function submitForm(form){
            form.submitButton.disabled = true;
            return true;
        }

    </script>
    
@stop