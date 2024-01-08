@extends('layouts.app')

@section('title', 'แผนการจ่ายยาเส้นรายปักษ์')

@section('page-title')
<h2>แผนการจ่ายยาเส้นรายปักษ์</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>แผนการจ่ายยาเส้นรายปักษ์</strong>
    </li>
</ol>
@stop

@section('page-title-action')
@stop

@section('content')
    <pm-planning-jobs :default-search="{{ json_encode($defaultSearch) }}"></pm-planning-jobs>
@endsection
