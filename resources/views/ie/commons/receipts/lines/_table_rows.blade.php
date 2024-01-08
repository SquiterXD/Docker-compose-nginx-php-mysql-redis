@if(count($receipt->lines) > 0)    
    @foreach($receipt->lines as $line)
    <tr>
        <td>
            <a type="button" id="button_coa_receipt_line_{{ $line->receipt_line_id }}" title="View Combination" 
                data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}"
                data-toggle="modal" data-target="#modal_coa_receipt_line" 
                data-backdrop="static" data-keyboard="false">
                <i class="fa fa-search"></i>
            </a>
        </td>
        <td class="td-break-word"> 
            <i class="fa {{ optional($line->category)->icon }}"></i> : 
            {{ optional($line->subCategory)->name }} <br> {{ $line->description }} 
        </td>
        {{-- <td>
            {{ array_key_exists($line->branch_code, $branchLists) ? $branchLists[$line->branch_code] : '-'  }}
        </td> --}}
        {{-- <td class="hidden-xs">
            {{ array_key_exists($line->department_code, $departmentLists) ? $departmentLists[$line->department_code] : '-' }}
        </td> --}}
        <td class="text-right hidden-sm hidden-xs">
            @if($line->policy)
                @if($line->policy->typeMileage()) {{-- MILEAGE --}}
                    {{ '-' }}
                @else {{-- EXPENSE --}}
                    {{ $line->quantity ? $line->quantity : '-' }}
                    {{-- <span>{{ optional($line->subCategory)->unit }}</span> --}}
                    <span>{{ optional($line)->uom }}</span>
                @endif
            @else {{-- ACTUAL --}}
                {{ $line->quantity ? $line->quantity : '-' }}
                {{-- <span>{{ optional($line->subCategory)->unit }}</span> --}}
                <span>{{ optional($line)->uom }}</span>
            @endif
            @if(optional($line->subCategory)->use_second_unit)
                @if($line->policy)
                    @if($line->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ '-' }}
                    @else {{-- EXPENSE --}}
                        {{ $line->second_quantity ? $line->second_quantity : '-' }}
                        {{-- <span>{{ optional($line->subCategory)->second_unit }}</span> --}}
                        <span>{{ optional($line->subCategory)->second_uom }}</span>
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $line->second_quantity ? $line->second_quantity : '-' }}
                    {{-- <span>{{ optional($line->subCategory)->second_unit }}</span> --}}
                    <span>{{ optional($line->subCategory)->second_uom }}</span>
                @endif
            @endif
        </td>
        <td class="text-right hidden-sm hidden-xs">
            {{ $line->total_amount ? numberFormatDisplay($line->total_amount) : '0.00' }}
        </td>
        <td class="text-right hidden-sm hidden-xs">
            {{ $line->vat_id ?? '-' }}
        </td>
        <td class="text-right hidden-sm hidden-xs">
            {{ $line->vat_amount ? numberFormatDisplay($line->vat_amount) : '0.00' }}
        </td>
        <td class="text-right hidden-sm hidden-xs">
            {{ $line->wht ? $line->wht->wht_name : '-' }}
        </td>
        <td class="text-right" style="padding-right: 2px !important;">
            <div id="td_receipt_line_amount_{{ $line->receipt_line_id }}">
                {{ $line->total_amount_inc_vat ? numberFormatDisplay($line->total_amount_inc_vat) : '0.00' }}
            </div>
            
        </td>
        <td style="padding-left: 2px !important;">
            <small>{{ $parentCurrencyId }}</small>
        </td>
        <td rowspan="2" class="text-center"> 

            @if ($receipt->process_type == 'CASH-ADVANCE')
                @if($receipt->isNotLock() && isset($removable) && $editable)
                    @if($parent->canImportantEditData())
                        <div class="row mx-0 m-t-xs">
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_show_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-block btn-default btn-xs" 
                                    title="View" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_duplicate_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-info" title="Copy" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-copy"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row mx-0 m-t-xs">
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_edit_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-warning" title="Edit" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_remove_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-danger" title="Remove" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row mx-0 m-t-xs">
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_show_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-block btn-default btn-xs" 
                                    title="View" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_edit_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-warning" title="Edit" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <a id="button_show_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-block btn-default btn-xs" 
                        title="View" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                        <i class="fa fa-search"></i>VIEW
                    </a>
                @endif
            @else
                <a id="button_show_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-block btn-default btn-xs" 
                    title="View" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                    <i class="fa fa-search"></i>VIEW
                </a>

                @if($receipt->isNotLock() && isset($removable) && $editable)
                    @if($parent->canImportantEditData())
                        <div class="row mx-0 m-t-xs">
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="btn_open_dff_line_{{ $line->receipt_line_id }}" type="button" 
                                    class="btn btn-xs btn-block btn-outline btn-default" title="DFF" 
                                    data-request-type="RECEIPT-LINE" data-request-id="{{ $line->receipt_line_id }}">
                                    [ ]
                                </a>
                            </div>
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_duplicate_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-info" title="Copy" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-copy"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row mx-0 m-t-xs">
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_edit_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-warning" title="Edit" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_remove_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-danger" title="Remove" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row mx-0 m-t-xs">
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="btn_open_dff_line_{{ $line->receipt_line_id }}" type="button" 
                                    class="btn btn-xs btn-block btn-outline btn-default" title="DFF" 
                                    data-request-type="RECEIPT-LINE" data-request-id="{{ $line->receipt_line_id }}">
                                    [ ]
                                </a>
                            </div>
                            <div class="col-sm-6 padding-btn-receipt-line">
                                <a id="button_edit_receipt_line_{{ $line->receipt_line_id }}" type="button" class="btn btn-xs btn-block btn-outline btn-warning" title="Edit" data-receipt-id="{{ $line->receipt_id }}" data-receipt-line-id="{{ $line->receipt_line_id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <a id="btn_open_dff_line_{{ $line->receipt_line_id }}" type="button" 
                        class="btn btn-xs btn-outline btn-block btn-default" title="View Detail" 
                        data-request-type="RECEIPT-LINE" data-request-id="{{ $line->receipt_line_id }}">
                        [ ]
                    </a>
                @endif
            @endif

        </td>
    </tr>
    <tr>
        <td colspan="3">{{ $line->concatenated_segments }}</td>
        <td class="text-right" colspan="6">
            @if ( $line->budget_status == 'S' )
                <span class="text-bold "> {{ $line->budget_status_msg }} </span>
            @endif
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="12">
            <div style="font-size: 18px;color:#AAA;margin-top: 10px;margin-bottom: 10px;"> 
                Not found receipt line. 
            </div>
        </td>
    </tr>
@endif