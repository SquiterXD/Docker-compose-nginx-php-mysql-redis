@extends('layouts.app')

@section('title', 'XXXXXXXX Title')

@section('page-title')

    <h2> XXXX </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong> XXXX </strong>
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h3> XXXXX </h3>
        </div>

        <div class="ibox-content">

            <h3 class="mb-4"> XXXX Search </h3>

            <form method="GET">

                <div class="row space-50 justify-content-md-center">

                </div>

            </form>

        </div>

    </div>

    <div class="ibox">

        <div class="ibox-title">
            <button class="btn btn-lg btn-default btn-outline"> <i class="fa fa-repeat"></i> </button>
        </div>

        <div class="ibox-content">


        </div>

    </div>

@endsection

@section('scripts')

    <!-- Page-Level Scripts -->
    <script>


    </script>

@stop
