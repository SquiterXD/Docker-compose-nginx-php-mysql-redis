<div class="row pt-2" style="color: #c32323;">
    <div class="col-md-2 text-right"> <h3> <strong> Period Balance </strong> </h3> </div>
    <div class="col-md-10 pl-0"> <hr style="border-color: #c32323 !important;"> </div>
</div>
<table class="table table-hover period_tb">
    <thead>
        <tr>
            <th width="10%" class="text-center">
                <div> Period </div>
            </th>
            <th width="10%" class="text-right">
                <div> Budget </div>
            </th>
            <th width="10%" class="text-right">
                <div> Encumbrance </div>
            </th>
            <th width="10%" class="text-right">
                <div> Actual </div>
            </th>
            <th width="10%" class="text-right">
                <div> Funds Available </div>
            </th>
        </tr>
    </thead>
    <tbody>
        {{-- ปรับการดึงค่าจำนวนเงิน ตามที่พี่นัททำไว้ที่ SME --}}
        <template v-if="periodBalances.length">
            <template v-for="balance in periodBalances">
                {{-- <template v-if="is_summary == 'Y'">
                    <tr>
                </template>
                <template v-else> --}}
                <tr :style="sel_period == balance.period_name? 'cursor: pointer; background-color: #9AD9DB;' : 'cursor: pointer;'" @click="getTransactionGL(balance.period_name, sel_concate_segment)">
                {{-- </template> --}}
                    <td class="text-center">
                        @{{ balance.period_name }}
                    <td class="text-right">
                        @{{ decimal(balance.budget) }}
                    </td>
                    <td class="text-right">
                        @{{ calEncumbrance(balance.encumbrance, balance.period_name) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(balance.actual, balance.period_name) }}
                    </td>
                    <td class="text-right">
                        @{{ calAvaliable(balance.available, balance.period_name) }}
                    </td>
                </tr>
            </template>
            <tr style="background-color: #f1f1f1;">
                <td class="text-center">
                    <strong> Total Budget </strong>
                <td class="text-right">
                    @{{ decimal(budgetTotal) }}
                </td>
                <td class="text-right">
                    @{{ encumbranceTotal(encumbrancePeriodTotal, encumbranceBcTotal) }}
                </td>
                <td class="text-right">
                    @{{ decimal(actualTotal) }}
                </td>
                <td class="text-right">
                    @{{ avaliableTotal(availableTotal, encumbranceBcTotal) }}
                </td>
            </tr>
        </template>
        <template v-else>
            <tr>
                <td colspan="5" class="text-center" style="width=100%"><h2> No data period balance </h2></td>
            </tr>
        </template>
    </tbody>
</table>
<form id="transaction-form">
    <div id="_content_transaction" v-if="get_data_flag"> 
        {{-- RENDER --}}
    </div>
</form>