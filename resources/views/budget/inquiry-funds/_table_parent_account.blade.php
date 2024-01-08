<table class="table m-b-xs m-0">
    <tbody>
        <template v-for="f in fund.parent">
            <tr :style="sel_fund == f.code_combination_id? 'cursor: pointer; background-color: #9AD9DB;' : 'cursor: pointer; '" @click="getDataFund(f.code_combination_id, f.concatenated_segments, f.summary_flag)">
                <td class="text-left" width="20%" style="font-size: 0.75rem;">
                    @{{ f.concatenated_segments }}
                </td>
                <td class="text-left" width="30%">
                    <small>
                        <strong> Description: </strong> @{{ f.description_segments }}
                    </small> 
                </td>
                <td class="text-right" width="12%">
                    @{{ decimal(f.budget_amount) }}
                </td>
                <td class="text-right" width="12%">
                    @{{ decimal(f.encumbrance_amount) }}
                </td>
                <td class="text-right" width="12%">
                    @{{ decimal(f.actual_amount) }}
                </td>
                <td class="text-right" width="12%">
                    @{{ decimal(f.funds_available_amount) }}
                </td>
            </tr>
        </template>
    </tbody>
</table>