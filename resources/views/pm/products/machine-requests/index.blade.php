@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/pm/products/machine-requests" /> เบิกวัตถุดิบเข้าหน้าเครื่องจักร </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            เบิกวัตถุดิบเข้าหน้าเครื่องจักร
        </li>
    </ol>

@stop

@section('content')

    <pm-products-machine-requests-index 
        request-number-value="{{ isset($searchInputs['request_number']) ? $searchInputs['request_number'] : '' }}"
        request-date-value="{{ isset($searchInputs['request_date']) ? $searchInputs['request_date'] : '' }}"
        objective-request-value="{{ isset($searchInputs['objective_request']) ? $searchInputs['objective_request'] : '' }}"
        inventory-item-id-value="{{ isset($searchInputs['inventory_item_id']) ? $searchInputs['inventory_item_id'] : '' }}"
        machine-name-value="{{ isset($searchInputs['machine_name']) ? $searchInputs['machine_name'] : '' }}"
        :item-options="{{ json_encode($itemOptions) }}"
        :uom-codes="{{ json_encode($uomCodes) }}"
        :objective-requests="{{ json_encode($objectiveRequests) }}"
    />

@endsection