<div id="modal-flexfield" class="modal fade" aria-hidden="true" data-backdrop="static" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body pb-0" style="">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
                <h3 class="text-left mb-3 tw-text-grey-darknes"> Segment Override </h3>
                <table class="table" id="tb-segment-override">
                    <tbody>
                        <br>
                        <div class="row text-center">
                            <div class="form-group pl-2 pr-2 mb-0 ml-5 col-lg-8 col-md-8 col-sm-6 col-xs-6 mt-2">
                                <el-input name="search[segment_override]" placeholder="Chart of Accounts" v-model="coaEnter" 
                                    size="small" autocomplete="off" 
                                    style="width: 100%"
                                    ref="segmentOverride"
                                > </el-input>
                                <div id="el_explode_segment" class="error_msg text-left"></div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-2 col-xs-2 mt-2">
                                <button class="btn btn-primary btn-sm" @click.prevent="enterAccSegment"> ดำเนินการ </button>
                                <button class="btn btn-danger btn-sm" @click.prevent="clearAccSegment">
                                    <i class="fa fa-undo"></i> รีเซ็ต
                                </button>
                            </div>
                        </div>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> COMPANY </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment1"
                                    :set-data="segment1From"
                                    placeholder="Company"
                                    ref="segment1"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment1"
                                    :set-options="option1"
                                >
                                </coa-component>
                                <div id="el_explode_acc_1" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment1"
                                    :set-data="segment1To"
                                    placeholder="Company"
                                    ref="segment1"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment1"
                                    :set-options="option1"
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
                                    :set-name="defaultValueSetName.segment2"
                                    :set-data="segment2From"
                                    placeholder="EVM"
                                    ref="segment2"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment2"
                                    :set-options="option2"
                                >
                                </coa-component>
                                <div id="el_explode_acc_2" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaTo" 
                                    :set-name="defaultValueSetName.segment2"
                                    :set-data="segment2To"
                                    placeholder="EVM"
                                    ref="segment2"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment2"
                                    :set-options="option2"
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
                                    :set-name="defaultValueSetName.segment3"
                                    :set-data="segment3From"
                                    placeholder="Department"
                                    ref="segment3"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment3"
                                    :set-options="option3"
                                >
                                </coa-component>
                                <div id="el_explode_acc_3" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment3"
                                    :set-data="segment3To"
                                    placeholder="Department"
                                    ref="segment3"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment3"
                                    :set-options="option3"
                                >
                                </coa-component>
                                <div id="el_explode_acc_3" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> COST CENTER </td>
                            <td>
                                {{-- <template v-if="!segment3From">
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
                                </template> --}}
                                {{-- v-else --}}
                                <coa-component
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment4"
                                    :set-data="segment4From"
                                    :set-parent="segment3From"
                                    placeholder="Cost Center"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment4"
                                    :error="errors.segment4"
                                    :set-options="option4"
                                >
                                </coa-component>
                                <div id="el_explode_acc_4" class="error_msg text-left"></div>
                            </td>
                            <td>
                                {{-- <template v-if="!segment3To">
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
                                </template> --}}
                                <coa-component
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment4"
                                    :set-data="segment4To"
                                    :set-parent="segment3To"
                                    placeholder="Cost Center"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment4"
                                    :error="errors.segment4"
                                    :set-options="option4"
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
                                    :set-name="defaultValueSetName.segment5"
                                    :set-data="segment5From"
                                    placeholder="BUDGET YEAR"
                                    ref="segment5"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment5"
                                    :set-options="option5"
                                >
                                </coa-component>
                                <div id="el_explode_acc_5" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment5"
                                    :set-data="segment5To"
                                    placeholder="BUDGET YEAR"
                                    ref="segment5"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment5"
                                    :set-options="option5"
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
                                    :set-name="defaultValueSetName.segment6"
                                    :set-data="segment6From"
                                    placeholder="BUDGET TYPE"
                                    ref="segment6"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment6"
                                    :set-options="option6"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment6"
                                    :set-data="segment6To"
                                    placeholder="BUDGET TYPE"
                                    ref="segment6"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment6"
                                    :set-options="option6"
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> BUDGET DETAIL </td>
                            <td>
                                {{-- <template v-if="!segment6From">
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
                                </template> --}}
                                <coa-component
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment7"
                                    :set-data="segment7From"
                                    :set-parent="segment6From"
                                    placeholder="BUDGET DETAIL"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment7"
                                    :error="errors.segment7"
                                    :set-options="option7"
                                >
                                </coa-component>
                                <div id="el_explode_acc_7" class="error_msg text-left"></div>
                            </td>
                            <td>
                                {{-- <template v-if="!segment6To">
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
                                </template> --}}
                                <coa-component
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment7"
                                    :set-data="segment7To"
                                    :set-parent="segment6To"
                                    placeholder="BUDGET DETAIL"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment7"
                                    :error="errors.segment7"
                                    :set-options="option7"
                                >
                                </coa-component>
                                <div id="el_explode_acc_7" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> BUDGET REASON </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment8"
                                    :set-data="segment8From"
                                    placeholder="BUDGET REASON"
                                    ref="segment8"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment8"
                                    :set-options="option8"
                                >
                                </coa-component>
                                <div id="el_explode_acc_8" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment8"
                                    :set-data="segment8To"
                                    placeholder="BUDGET REASON"
                                    ref="segment8"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment8"
                                    :set-options="option8"
                                >
                                </coa-component>
                                <div id="el_explode_acc_8" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> MAIN ACCOUNT </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment9"
                                    :set-data="segment9From"
                                    placeholder="MAIN ACCOUNT"
                                    ref="segment9"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment9"
                                    :set-options="option9"
                                >
                                </coa-component>
                                <div id="el_explode_acc_9" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment9"
                                    :set-data="segment9To"
                                    placeholder="MAIN ACCOUNT"
                                    ref="segment9"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment9"
                                    :set-options="option9"
                                >
                                </coa-component>
                                <div id="el_explode_acc_9" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> SUB ACCOUNT </td>
                            <td>
                                {{-- <template v-if="!segment9From">
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
                                        :set-name="defaultValueSetName.segment10"
                                        :set-data="segment10From"
                                        :set-parent="segment9To"
                                    ></el-select>
                                </template> --}}
                                <coa-component
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment10"
                                    :set-data="segment10From"
                                    :set-parent="segment9From"
                                    placeholder="SUB ACCOUNT"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment10"
                                    :error="errors.segment10"
                                    :set-options="option10"
                                >
                                </coa-component>
                                <div id="el_explode_acc_10" class="error_msg text-left"></div>
                            </td>
                            <td>
                               {{--  <template v-if="!segment9To">
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
                                        :set-name="defaultValueSetName.segment10"
                                        :set-data="segment10To"
                                        :set-parent="segment9To"
                                    ></el-select>
                                </template> --}}
                                <coa-component
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment10"
                                    :set-data="segment10To"
                                    :set-parent="segment9To"
                                    placeholder="SUB ACCOUNT"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment10"
                                    :error="errors.segment10"
                                    :set-options="option10"
                                >
                                </coa-component>
                                <div id="el_explode_acc_10" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> RESERVED1 </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment11"
                                    :set-data="segment11From"
                                    placeholder="RESERVED 1"
                                    ref="segment11"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment11"
                                    :set-options="option11"
                                >
                                </coa-component>
                                <div id="el_explode_acc_11" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment11"
                                    :set-data="segment11To"
                                    placeholder="RESERVED 1"
                                    ref="segment11"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment11"
                                    :set-options="option11"
                                >
                                </coa-component>
                                <div id="el_explode_acc_11" class="error_msg text-left"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" style="vertical-align: middle;"> RESERVED2 </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaFrom"
                                    :set-name="defaultValueSetName.segment12"
                                    :set-data="segment12From"
                                    placeholder="RESERVED 2"
                                    ref="segment12"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment12"
                                    :set-options="option12"
                                >
                                </coa-component>
                                <div id="el_explode_acc_12" class="error_msg text-left"></div>
                            </td>
                            <td>
                                <coa-component 
                                    @coa="updateCoaTo"
                                    :set-name="defaultValueSetName.segment12"
                                    :set-data="segment12To"
                                    placeholder="RESERVED 2"
                                    ref="segment12"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment12"
                                    :set-options="option12"
                                >
                                </coa-component>
                                <div id="el_explode_acc_12" class="error_msg text-left"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer pt-2">
                <button type="button" class="btn btn-primary btn-sm" @click.private="accountConfirm">
                    <i class="fa fa-check"></i> ตกลง
                </button>
                 <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i> ยกเลิก
                </button>
            </div>
        </div>
    </div>
</div>