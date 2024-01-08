@extends('layouts.app')

@section('title', 'กำหนดการจัดกลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน ')

@section('page-title')
    <x-get-page-title menu="" url="/ct/grouping_expense" />
    {{-- <h2>CTM0011 : กำหนดการจัดกลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดการจัดกลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน </strong>
        </li>
    </ol> --}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">        
            <grouping-expense-index-component
                :trans_btn="{{ json_encode(trans('btn')) }}"
                :grouping-expenses="{{ json_encode($groupingExpenses) }}"
                :grouping-budgets="{{ json_encode($groupingBudgets) }}"
                :departments="{{ json_encode($departments) }}"
            />
        </div>
    </div>
@endsection
