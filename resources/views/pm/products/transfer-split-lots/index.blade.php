
@extends('layouts.app')

@section('title', 'บันทึกส่งสินค้าไปจัดหา (กองพิมพ์)')

@section('page-title')

    <h2><x-get-program-code url="/pm/products/transfer-split-lots"/> บันทึกส่งสินค้าไปจัดหา (กองพิมพ์)</h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a> บันทึกส่งสินค้าไปจัดหา (กองพิมพ์) </a>
        </li>
    </ol>

@stop

@section('page-title-action')


@stop

@section('content')

    <pm-products-transfer-split-lots-index 
        :p-url="{{ json_encode($url) }}"
        organization-code="{{ $organizationCode }}"
        transfer-number-value="{{ isset($searchInputs['transfer_number']) ? $searchInputs['transfer_number'] : '' }}"
        product-date-value="{{ isset($searchInputs['product_date']) ? $searchInputs['product_date'] : '' }}"
        transfer-date-value="{{ isset($searchInputs['transfer_date']) ? $searchInputs['transfer_date'] : '' }}"
        to-locator-id-value="{{ isset($searchInputs['to_locator_id']) ? $searchInputs['to_locator_id'] : '' }}"
        transfer-objective-value="{{ request()->transfer_objective ?? '' }}"
        :profile="{{ json_encode($profile) }}"
        :trans-btn="{{ json_encode($transBtn) }}"
        :transfer-objectives="{{ json_encode($objectiveCodes) }}"
        :request-statuses="{{ json_encode($requestStatuses) }}"
        :locators="{{ json_encode($locators) }}"
        :dept-codes="{{ json_encode($deptCodes) }}"
        />

@endsection

@section('scripts')

    <script type="text/javascript">

        setTimeout( function() {
            var body = $('body');
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            }
        },500)

    </script>

@stop