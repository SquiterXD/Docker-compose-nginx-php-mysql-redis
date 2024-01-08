<table :class="defaultInput.summary_flag? 'table': 'table'" id="funds_tb">
    <thead>
        <tr>
            <template v-if="funds.length">
                <th width="3%"></th>
            </template>
            <th width="15%" class="text-left">
                <div> Account </div>
            </th>
            <th width="30%" class="text-left">
                <div> Description </div>
            </th>
            <th width="12%" class="text-right">
                <div> Budget </div>
            </th>
            <th width="12%" class="text-right">
                <div> Encumbrance </div>
            </th>
            <th width="12%" class="text-right">
                <div> Actual </div>
            </th>
            <th width="12%" class="text-right">
                <div> Funds Available </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <template v-if="funds.length">
            <template v-for="fund in itemsForList">
                <tr :style="sel_fund == fund.code_combination_id && fund.summary_flag == 'N'
                        ? 'cursor: pointer; background-color: #9AD9DB;'
                        : (fund.summary_flag == 'N'
                        ? 'cursor: pointer;'
                        : '')"
                        @click="getDataFund(fund.code_combination_id, fund.concatenated_segments, fund.summary_flag)">
                    <template v-if="funds.length">
                        <td v-if="fund.summary_flag == 'Y'">
                            <a style="margin-right: 5px; cursor: default;"
                                class="line-collapse-row"
                                :data-receipt="fund.code_combination_id">
                                <i class="fa fa-caret-down"></i>
                            </a>
                        </td>
                        <td v-else> </td>
                    </template>
                    <td class="text-left" :style="fund.summary_flag == 'Y'? 'font-size: 0.75rem; font-weight: bold;': 'font-size: 0.75rem;'">
                        @{{ fund.concatenated_segments }}
                    </td>
                    <td class="text-left">
                        <small>
                            <strong> Description: </strong> @{{ fund.description_segments }}
                        </small> 
                    </td>
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
                <template v-if="fund.summary_flag == 'Y'">
                    <tr style="border-style: none;" :id="'tr_'+fund.code_combination_id">
                        <td colspan="1" style="font-size: 1em; padding-top: 0px;"></td>
                        <td colspan="6" style="font-size: 1em; padding: 0px;">
                            {{-- LINES TABLE --}}
                            @include('budget.inquiry-funds._table_parent_account')
                        </td>
                    </tr>
                </template>
            </template>
        </template>
        <template v-else>
            <tr>
                <td colspan="6" class="text-center" style="width=100%"><h2> No data available in table </h2></td>
            </tr>
        </template>
    </tbody>
</table>
<div v-if="funds.length">
    <div class="d-flex justify-content-end md:tw-my-6 tw-my-2 lg:tw-px-0 tw-px-2">
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            first-number
            last-number
        >
            <template #prev-text><span class="text-primary">Previous</span></template>
            <template #next-text><span class="text-primary">Next</span></template>
        </b-pagination>
    </div>
</div>

<div class="m-t-lg m-b-lg" v-if="get_data_loading">
    <div class="text-center sk-spinner sk-spinner-wave">
        <div class="sk-rect1"></div>
        <div class="sk-rect2"></div>
        <div class="sk-rect3"></div>
        <div class="sk-rect4"></div>
        <div class="sk-rect5"></div>
    </div>
</div>
<template v-if="get_data_flag">
    <br>
    <div style="border: 2px solid #2196f3; padding: 20px;">
        <div class="col-lg-12 row">
            <div class="col-md-3 mt-3"> <h3><strong> Encumbrance Amount </strong></h3></div>
            <div class="col-md-3">
                <label class="">
                    <div><strong> Commitment </strong></div>
                </label>
                <div class="col-sm-12 p-0">
                    <input type="input" name="commitment" class="form-control" :value="decimal(reqEncumbranceAmount)" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <label class="">
                    <div><strong> Obligation </strong></div>
                </label>
                <div class="col-sm-12 p-0">
                    <input type="input" name="obligation" class="form-control" :value="decimal(poEncumbranceAmount)" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <label class="">
                    <div><strong> Other </strong></div>
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