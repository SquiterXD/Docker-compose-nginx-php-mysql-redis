<div id="modal-flexfield" class="modal fade" aria-hidden="true" data-backdrop="static" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pb-0" style="">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="text-left mb-3 tw-text-grey-darknes"> Segment Override </h3>
                <table class="table" id="tb-segment-override">
                    <tbody>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> COMPANY </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-COMPANY_CODE"
                                    :set-data="segment1"
                                    placeholder="Company"
                                >
                                </coa-component>
                                <div id="el_explode_acc_1" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> EVM </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaFrom" 
                                    set-name="TTM_GL_ACCT_CODE-EVM" 
                                    :set-data="segment2" 
                                    placeholder="EVM" 
                                >
                                </coa-component>
                                <div id="el_explode_acc_2" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> DEPARTMENT </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-DEPT_CODE"
                                    :set-data="segment3"
                                    placeholder="Department"
                                >
                                </coa-component>
                                <div id="el_explode_acc_3" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> COST CENTER </td>
                            <td>
                                <template v-if="!segment3">
                                    <el-select
                                        v-model="value"
                                        filterable
                                        remote
                                        clearable 
                                        placeholder="Please enter a value"
                                        size="small"
                                        class="w-100"
                                        style="width: 100%;"
                                        disabled
                                    ></el-select>
                                </template>
                                <coa-component v-else
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-COST_CENTER"
                                    :set-data="segment4"
                                    :set-parent="segment3"
                                    placeholder="Cost Center"
                                >
                                </coa-component>
                                <div id="el_explode_acc_4" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> BUDGET YEAR </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-BUDGET_YEAR"
                                    :set-data="segment5"
                                    placeholder="BUDGET YEAR"
                                >
                                </coa-component>
                                <div id="el_explode_acc_5" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> BUDGET TYPE </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-BUDGET_TYPE"
                                    :set-data="segment6"
                                    placeholder="BUDGET TYPE"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> BUDGET DETAIL </td>
                            <td>
                                <template v-if="!segment6">
                                    <el-select
                                        v-model="value"
                                        filterable
                                        remote
                                        clearable 
                                        placeholder="Please enter a value"
                                        size="small"
                                        class="w-100"
                                        style="width: 100%;"
                                        disabled
                                    ></el-select>
                                </template>
                                <coa-component v-else
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-BUDGET_DETAIL"
                                    :set-data="segment7"
                                    :set-parent="segment6"
                                    placeholder="BUDGET DETAIL"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> BUDGET REASON </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-BUDGET_REASON"
                                    :set-data="segment8"
                                    placeholder="BUDGET REASON"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> MAIN ACCOUNT </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-MAIN_ACCOUNT"
                                    :set-data="segment9"
                                    placeholder="MAIN ACCOUNT"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> SUB ACCOUNT </td>
                            <td>
                                <template v-if="!segment9">
                                    <el-select
                                        v-model="value"
                                        filterable
                                        remote
                                        clearable 
                                        placeholder="Please enter a value"
                                        size="small"
                                        class="w-100"
                                        style="width: 100%;"
                                        disabled
                                    ></el-select>
                                </template>
                                <coa-component v-else
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-SUB_ACCOUNT"
                                    :set-data="segment10"
                                    :set-parent="segment9"
                                    placeholder="SUB ACCOUNT"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> RESERVED1 </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-RESERVED1"
                                    :set-data="segment11"
                                    placeholder="RESERVED 1"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> RESERVED2 </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    set-name="TTM_GL_ACCT_CODE-RESERVED2"
                                    :set-data="segment12"
                                    placeholder="RESERVED 2"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer pt-2">
                <button type="button" class="btn btn-white btn-sm" style="border-color: #3C327B;" @click.private="accountConfirm">
                    ตกลง
                </button>
            </div>
        </div>
    </div>
</div>