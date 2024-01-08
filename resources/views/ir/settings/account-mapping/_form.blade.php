<form id="submitForm" :action="urlSave" method="post" @submit.prevent="submit" onkeydown="return event.key != 'Enter';">
    <input type="hidden" name="_token" :value="csrf">
    <div v-if="this.defaultValue">
        <input type="hidden" name="_method" value="PUT">
    </div>
    <div>
        <label class="pl-2">Segment Override</label>
        <div class="row">
            {{-- <label class=" tw-font-bold tw-uppercase mb-0" >Segment Override :</label> --}}
            <div class="form-group pl-2 pr-2 mb-0 ml-3 col-lg-9 col-md-9 col-sm-6 col-xs-6 mt-2">
                <el-input name="search[segment_override]" placeholder="Chart of Accounts" v-model="coaEnter" 
                    size="small" autocomplete="off" 
                    style="width: 100%"
                    ref="segmentOverride"
                > </el-input>
                <div id="el_explode_segment" class="error_msg text-left"></div>
            </div>
            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-1 col-xs-1 mt-2">
                <button class="btn btn-primary btn-sm" @click.prevent="enterAccSegment"> <i class="fa fa-check-square-o"></i> </button>
                <button class="btn btn-warning btn-sm" @click.prevent="clearAccSegment"> <i class="fa fa-undo"></i> </button>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> Code <span class="text-danger">*</span></label>
                <el-input type="text" name="account_code" v-model="account_code" placeholder="Please enter a value" 
                        autocomplete="off" size="small" maxlength="5" :disabled="this.disableEdit" ref="account_code">
                </el-input>
                <div id="el_explode_account_code" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> Description <span class="text-danger">*</span></label>
                <el-input type="text" name="description" v-model="description" placeholder="Please enter a value" 
                        autocomplete="off" size="small" ref="description">
                </el-input>
                <div id="el_explode_description" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> COMPANY <span class="text-danger">*</span></label>
                <input-segment-coa
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment1"
                    :set-data="segment1"
                    placeholder="Company"
                    ref="segment1"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment1"
                    :set-options="option1"
                    name="segment1"
                >
                </input-segment-coa>
                <div id="el_explode_segment1" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> EVM <span class="text-danger">*</span></label>
                <input-segment-coa
                    @coa="updateCoa" 
                    :set-name="defaultValueSetName.segment2"
                    :set-data="segment2"
                    placeholder="EVM"
                    ref="segment2"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment2"
                    :set-options="option2"
                    name="segment2"
                >
                </input-segment-coa>
                <div id="el_explode_segment2" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> DEPARTMENT <span class="text-danger">*</span></label>
                <input-segment-coa
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment3"
                    :set-data="segment3"
                    placeholder="Department"
                    ref="segment3"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment3"
                    :set-options="option3"
                    name="segment3"
                >
                </input-segment-coa>
                <div id="el_explode_segment3" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> COST CENTER <span class="text-danger">*</span></label>
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
                <input-segment-coa v-else
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment4"
                    :set-data="segment4"
                    :set-parent="segment3"
                    placeholder="Cost Center"
                    :default-value-set-name="defaultValueSetName"
                    ref="segment4"
                    :error="errors.segment4"
                    :set-options="option4"
                    name="segment4"
                >
                </input-segment-coa>
                <div id="el_explode_segment4" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> BUDGET YEAR <span class="text-danger">*</span></label>
                <input-segment-coa 
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment5"
                    :set-data="segment5"
                    placeholder="BUDGET YEAR"
                    ref="segment5"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment5"
                    :set-options="option5"
                    name="segment5"
                >
                </input-segment-coa>
                <div id="el_explode_segment5" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> BUDGET TYPE <span class="text-danger">*</span></label>
                <input-segment-coa 
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment6"
                    :set-data="segment6"
                    placeholder="BUDGET TYPE"
                    ref="segment6"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment6"
                    :set-options="option6"
                    name="segment6"
                >
                </input-segment-coa>
                <div id="el_explode_segment6" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> BUDGET DETAIL <span class="text-danger">*</span></label>
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
                <input-segment-coa v-else
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment7"
                    :set-data="segment7"
                    :set-parent="segment6"
                    placeholder="BUDGET DETAIL"
                    :default-value-set-name="defaultValueSetName"
                    ref="segment7"
                    :error="errors.segment7"
                    :set-options="option7"
                    name="segment7"
                >
                </input-segment-coa>
                <div id="el_explode_segment7" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> BUDGET REASON <span class="text-danger">*</span></label>
                <input-segment-coa 
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment8"
                    :set-data="segment8"
                    placeholder="BUDGET REASON"
                    ref="segment8"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment8"
                    :set-options="option8"
                    name="segment8"
                >
                </input-segment-coa>
                <div id="el_explode_segment8" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> MAIN ACCOUNT <span class="text-danger">*</span></label>
                <input-segment-coa 
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment9"
                    :set-data="segment9"
                    placeholder="MAIN ACCOUNT"
                    ref="segment9"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment9"
                    :set-options="option9"
                    name="segment9"
                >
                </input-segment-coa>
                <div id="el_explode_segment9" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> SUB ACCOUNT <span class="text-danger">*</span></label>
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
                        :set-name="defaultValueSetName.segment10"
                        :set-data="segment10"
                        :set-parent="segment9"
                    ></el-select>
                </template>
                <input-segment-coa v-else
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment10"
                    :set-data="segment10"
                    :set-parent="segment9"
                    placeholder="SUB ACCOUNT"
                    :default-value-set-name="defaultValueSetName"
                    ref="segment10"
                    :error="errors.segment10"
                    :set-options="option10"
                    name="segment10"
                >
                </input-segment-coa>
                <div id="el_explode_segment10" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> RESERVED1 <span class="text-danger">*</span></label>
                <input-segment-coa 
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment11"
                    :set-data="segment11"
                    placeholder="RESERVED 1"
                    ref="segment11"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment11"
                    :set-options="option11"
                    name="segment11"
                >
                </input-segment-coa>
                <div id="el_explode_segment11" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> RESERVED2 <span class="text-danger">*</span></label>
                <input-segment-coa 
                    @coa="updateCoa"
                    :set-name="defaultValueSetName.segment12"
                    :set-data="segment12"
                    placeholder="RESERVED 2"
                    ref="segment12"
                    :default-value-set-name="defaultValueSetName"
                    :error="errors.segment12"
                    :set-options="option12"
                    name="segment12"
                >
                </input-segment-coa>
                <div id="el_explode_segment12" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> Active </label>
                <div>
                    <input type="checkbox" name="active_flag" v-model="active_flag">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right">
                {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                <a :href="this.urlReset" type="button" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i> ยกเลิก </a> --}}

                <button class="{{ $btnTrans['save']['class'] }} btn-sm" type="submit">
                    <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i>  
                    {{ $btnTrans['save']['text'] }} 
                </button>
                <a :href="this.urlReset" type="button" class="{{ $btnTrans['cancel']['class'] }} btn-sm">
                    <i class="{{ $btnTrans['cancel']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['cancel']['text'] }} 
                </a>
            </div>
        </div>
    </div>
</form>