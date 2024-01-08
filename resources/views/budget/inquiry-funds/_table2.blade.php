<table class="table">
    <thead>
        <tr>
            <th width="20%" class="text-left">
                <div> Account </div>
            </th>
            <th width="20%" class="text-right">
                <div> Budget </div>
            </th>
            <th width="20%" class="text-right">
                <div> Encumbrance </div>
            </th>
            <th width="20%" class="text-right">
                <div> Actual </div>
            </th>
            <th width="20%" class="text-right">
                <div> Funds Available </div>
            </th>
        </tr>
    </thead>
    <tbody>
        {{-- <template v-if="funds.length">
            <template v-for="fund in funds">
                <tr>
                    <td class="text-left">
                        @{{ coa }}
                    <td class="text-right">
                        @{{ decimal(fund.budget_amount) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(fund.encumbrance_amount) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(fund.actual_amount) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(fund.funds_available_amount) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="background: #efefef;">
                        <div style="margin-top: 1px;">
                            <strong> Description: </strong> @{{ fund.description }}
                        </div>
                    </td>
                </tr>
            </template>
        </template>
        <template v-else>
            <tr>
                <td colspan="5" class="text-center" style="width=100%"><h2> No data available in table </h2></td>
            </tr>
        </template> --}}
        @if (count($inquiryFunds))
            @foreach ($inquiryFunds as $fund)
                <tr>
                    <td class="text-left">
                        {{ $fund->concatenated_segments }}
                    <td class="text-right">
                        {{ number_format($fund->budget_amount, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($fund->encumbrance_amount, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($fund->actual_amount, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($fund->funds_available_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="background: #efefef;">
                        <div style="margin-top: 1px;">
                            <strong> Description: </strong> {{ $fund->description_segments }}
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center" style="width=100%"><h2> ไม่พบข้อมูลในระบบ </h2></td>
            </tr>
        @endif
    </tbody>
</table>
<template v-if="funds.length">
    <br>
    <div style="border: 2px solid #2196f3; padding: 20px;">
        <div class="col-lg-12 row">
            <div class="col-md-3 mt-3"> <h3><strong> Encumbrance Amount </strong></h3></div>
            <div class="col-md-3">
                <label class="">
                    <div><strong> Commitment </strong></div>
                    {{-- <div><small> อื่นๆ </small></div> --}}
                </label>
                <div class="col-sm-12 p-0">
                    {{-- {!! Form::text('commitment', @{{ reqEncumbranceAmount }}, ['class'=>'form-control text-right', "autocomplete" => "off", "readonly" => "readonly"]) !!} --}}
                    <input type="input" name="commitment" class="form-control" :value="decimal(reqEncumbranceAmount)" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <label class="">
                    <div><strong> Obligation </strong></div>
                    {{-- <div><small> อื่นๆ </small></div> --}}
                </label>
                <div class="col-sm-12 p-0">
                    <input type="input" name="obligation" class="form-control" :value="decimal(poEncumbranceAmount)" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <label class="">
                    <div><strong> Other </strong></div>
                    {{-- <div><small> อื่นๆ </small></div> --}}
                </label>
                <div class="col-sm-12 p-0">
                    <input type="input" name="other" class="form-control" :value="decimal(otherEncumbranceAmount)" readonly>
                </div>
            </div>
        </div>
    </div>
    <br>
    @include('budget.inquiry-funds._period_balance')
</template>