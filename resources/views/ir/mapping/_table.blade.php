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
                        @{{ segment1From+'.'+segment2From+'.'+segment3From+'.'+segment4From+'.'+segment5From+'.'+segment6From }}
                        <div style="margin-top: 5px;">
                            <strong> Description: </strong> @{{ fund.detail }}
                        </div> 
                    <td class="text-right">
                        @{{ decimal(fund.v_budget) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(fund.v_encumbrance) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(fund.v_actual) }}
                    </td>
                    <td class="text-right">
                        @{{ decimal(fund.v_funds_available) }}
                    </td>
                </tr>
            </template>
        </template>
        <template v-else>
            <tr>
                <td colspan="5" class="text-center" style="width=100%"><h2> No data available in table </h2></td>
            </tr>
        </template> --}}
    </tbody>
</table>