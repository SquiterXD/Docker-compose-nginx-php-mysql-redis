@extends('layouts.app')

@section('title', 'Receipt')

@section('page-title')
    <h2>
        @if($receiptType == 'REIMBURSEMENT')
            <x-get-program-code url="/ie/reimbursements" /> 
        @else
            <x-get-program-code url="/ie/cash-advances" /> 
        @endif
        Tax Invoice/Receipt # : {{ $receipt->receipt_number ? $receipt->receipt_number : '-' }} <br/>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
        @if( in_array($receiptType, ['CLEARING', 'CASH-ADVANCE']) )
            <a href="{{ route('ie.cash-advances.index') }}">Cash Advance</a>
		@elseif( in_array($receiptType, ['REIMBURSEMENT']) ) {{-- REIMBURSE --}}
			<a href="{{ route('ie.reimbursements.index') }}">Reimbursement</a>
		@else {{-- INVOICE --}}
            <a href="{{ route('ie.invoices.index') }}">Invoice</a>
        @endif
        </li>
        <li class="breadcrumb-item">
        @if( in_array($receiptType, ['CLEARING']) )
            <a href="{{ route('ie.cash-advances.clear',[$parent->cash_advance_id]) }}">{{ $parent->clearing_document_no }}</a>
        @elseif( in_array($receiptType, ['CASH-ADVANCE']) )
            <a href="{{ route('ie.cash-advances.show',[$parent->cash_advance_id]) }}">{{ $parent->document_no }}</a>
        @elseif( in_array($receiptType, ['REIMBURSEMENT']) ) {{-- REIMBURSE --}}
            <a href="{{ route('ie.reimbursements.show',[$parent->reimbursement_id]) }}">{{ $parent->document_no }}</a>
        @else {{-- INVOICE --}}
            <a href="{{ route('ie.invoices.show',[$parent->id]) }}">{{ $parent->document_no }}</a>
        @endif
        </li>
        <li class="breadcrumb-item active">
        	<strong>Tax Invoice/Receipt # : {{ $receipt->receipt_number ? $receipt->receipt_number : '-' }}</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    {{-- ######### EDIT ######## --}}
    {{-- <div class="text-right m-t-lg">
        <button class="btn btn-warning btn-outline" data-toggle="modal" href="#modal-edit-form">
            <i class="fa fa-edit"></i> Edit
        </button>
    </div> --}}
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-9" style="padding-right: 2px;">
                    <div class="ibox">
                        {{-- MAIN DETAIL --}}
                        @include('ie.commons.receipts.show._main_detail')
                    </div>
                    <div class="ibox">
                        {{-- TABLE RECEIPT LINES --}}
                        <div class="table-responsive m-t" style="font-size: 1em;">
                            @include('ie.commons.receipts.lines._table')
                        </div>
                        @include('ie.commons.receipts.lines._table_total')
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        {{-- OTHER DETAIL --}}
                        @include('ie.commons.receipts.show._other_detail')
                    </div>
                </div>
            </div>

            {{-- MODAL CREATE RECEIPT LINE --}}
            {{-- @include('ie.commons.receipts.lines._modal_create') --}}

            {{-- MODAL SHOW RECEIPT LINE --}}
            @include('ie.commons.receipts.lines._modal_show')

            {{-- MODAL CREATE RECEIPT LINE --}}
            @include('ie.commons.receipts.lines._modal_coa')

            
            {{-- MODAL DFF LINE --}}
            @include('ie.commons.dff._modal_dff_line')
        </div>
    </div>
</div>

@stop

@section('scripts')

    {{-- SCRIPT RECEIPT SHOW PAGE --}}
    @include('ie.commons.receipts.show._script')

    {{-- SCRIPT DFF --}}
    @include('ie.commons.dff._script')

@stop