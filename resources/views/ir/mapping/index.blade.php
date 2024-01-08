@extends('layouts.app')

@section('title', 'Inquiry Fund')

@section('page-title')
    <h2>Inquiry Fund</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <strong>Inquiry Fund</strong>
        </li>
    </ol>
@stop

@section('content')
    <inquiry-funds-component
        :ledgers="{{ json_encode($ledgers) }}"
        :budget-lists="{{ json_encode($budgetLists) }}" 
        :amount-lists="{{ json_encode($amountLists) }}"
        :encumbrance-lists="{{ json_encode($encumbranceLists) }}"
        :account-level-lists="{{ json_encode($accountLevelLists) }}"
        inline-template>
        <div>
            @include('budget.inquiry-funds._search', ['actionUrl' => route('funds.index')])
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    @include('budget.inquiry-funds._table')
                </div>
            </div>
        </div>
    </inquiry-funds-component>
@endsection
