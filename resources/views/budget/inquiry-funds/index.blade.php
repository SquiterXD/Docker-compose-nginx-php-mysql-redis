@extends('layouts.app')

@section('title', 'Inquiry Fund')

@section('page-title')
    {{-- <h2>Inquiry Fund</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>Inquiry Fund</strong>
        </li>
    <ol> --}}
    @section('page-title')
        <x-get-page-title menu="" url="/inquiry-funds" />
    @stop
@stop

@section('content')
    <inquiry-funds-component
        :ledgers="{{ json_encode($ledgers) }}"
        :budget-lists="{{ json_encode($budgetLists) }}" 
        :amount-lists="{{ json_encode($amountLists) }}"
        :encumbrance-lists="{{ json_encode($encumbranceLists) }}"
        :account-level-lists="{{ json_encode($accountLevelLists) }}"
        :inquiry-funds="{{ json_encode($inquiryFunds) }}"
        :search="{{ json_encode($search) }}"
        :default-input="{{ json_encode($defaultInput) }}"
        :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
        inline-template>
        <div v-loading="loading">
            @include('budget.inquiry-funds._search', ['actionUrl' => route('funds.index')])
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    @include('budget.inquiry-funds._table')
                </div>
            </div>
        </div>
    </inquiry-funds-component>
@endsection

@section('scripts')
    <script type="text/javascript">
        @include('budget.inquiry-funds._script')
        // setTimeout( function() {
        //     var body = $('body');
        //     if (body.hasClass('fixed-sidebar')) {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     } else {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     }
        // }, 500)

        $(document).ready(function () {
            var dataTableFund = $('.funds_tb');
            var dataTableTransactions = $('.transactions_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';

            dataTableFund.DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                    {
                        extend: 'csv',
                        title: "Account_details_CSV"
                    },
                    {
                        extend: 'excel',
                        title: "Account_details_EXCEL"
                    },
                ],
            });

            dataTableTransactions.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop