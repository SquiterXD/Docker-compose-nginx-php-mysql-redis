@extends('layouts.app')
@section('title', 'PMP0028')
@section('page-title')
  <h2>รายการจัดเตรียมวัตถุดิบ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.ingredient-preparation.index') }}">รายการจัดเตรียมวัตถุดิบ</a>
    </li>
  </ol>
@stop


@section('content')
    <ingredient-preparation
        inline-template>
        <div>
            @include('pm.ingredient-preparation._form')
        </div>
    </ingredient-preparation>
@endsection
