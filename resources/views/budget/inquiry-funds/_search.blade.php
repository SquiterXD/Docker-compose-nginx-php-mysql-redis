<div class="ibox float-e-margins mb-2">
    <div class="ibox-content tw-border-b">
        <div class="card" style="border: 2px solid #7ca7dc; border-radius: 3px;">
            <div class="card-body" >
                <form id="fund-form" v-loading="">
                    <div class="row">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class="tw-font-bold tw-uppercase mb-0" for="search[ledger]">
                                Ledger : <span class="text-danger">*</span>
                            </label>
                            <input type="hidden" name="search[ledger]" :value="ledger">
                            <el-select class="required" v-model="ledger" placeholder="Ledger" size="small" style="width: 100%;">
                                <el-option
                                    v-for="ledger in ledgers"
                                    :key="ledger.ledger_id"
                                    :label="ledger.short_name +' : '+ ledger.name"
                                    :value="ledger.ledger_id">
                                </el-option>
                            </el-select>
                            <div id="el_ledger" class="error_msg text-left" style="width: 200px;"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class="tw-font-bold tw-uppercase mb-0" for="search[budget]">
                                Budget : <span class="text-danger">*</span>
                            </label> <br>
                            <input type="hidden" name="search[budget]" :value="budget">
                            <el-select class="required" v-model="budget" placeholder="Budget" size="small">
                                <el-option
                                    v-for="budget in budgetLists"
                                    :key="budget.budget_version_id"
                                    :label="budget.budget_name"
                                    :value="budget.budget_version_id">
                                </el-option>
                            </el-select>
                            <div id="el_Budget" class="error_msg text-left" style="width: 200px;"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Amount Type : <span class="text-danger">*</span></label>
                            <input type="hidden" name="search[amount_type]" :value="amountType">
                            <el-select class="required" v-model="amountType" placeholder="Amount Type" size="small" style="width: 100%;">
                                <el-option
                                    v-for="(type, index) in amountLists"
                                    :key="index"
                                    :label="type"
                                    :value="index">
                                </el-option>
                            </el-select>
                            <div id="el_Amount" class="error_msg text-left" style="width: 200px;"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Period : <span class="text-danger">*</span></label>
                            <input type="hidden" name="search[period]" :value="period">
                            <el-date-picker
                                class="required" 
                                name="search[period]"
                                :value="period"
                                v-model="period"
                                type="month"
                                format="MMM-yy"
                                value-format="MMM-yy"
                                placeholder="Period"
                                size="small"
                                style="width: 100%;"
                                filterable
                                ref="period"
                                :disabled="adj_flag"
                                @change="getPeriodYear"
                                >
                            </el-date-picker>
                            {{-- <datepicker-component
                                style="width: 100%; padding: 0px;"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="search[period]"
                                :value="period"
                                v-model="period"
                                placeholder="Period"
                                p-type='month'
                                value="{{ old("input_date") }}"
                                format="{{ trans("date.js-month-full-format") }}"
                                @period-date="periodWasSelected"
                                ref="period">
                            </datepicker-component> --}}
                            <div id="el_explode_period" class="error_msg text-left"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            <input type="hidden" name="search[adj_flag]" :value="adj_flag">
                            <el-checkbox v-model="adj_flag" style="padding: 1px; margin: 1px;" @change="selAdjPeriod"> </el-checkbox>
                            <span> <strong>ADJ Period</strong> </span>

                            <template v-if="adj_flag">
                                <input type="hidden" name="search[adj_period]" :value="adj_period">
                                <el-date-picker v-model="adj_period" type="year" placeholder="เดือน" size="small" style="width: 100%;" @change="changeAdjPeriod"> </el-date-picker>
                            </template>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Encumbrance Type : <span class="text-danger">*</span></label>
                            <input type="hidden" name="search[encum_type]" :value="encumType">
                            <el-select v-model="encumType" placeholder="Encumbrance Type" size="small" style="width: 100%;">
                                <el-option
                                    v-for="(encum, index) in encumbranceLists"
                                    :key="encum.encumbrance_type_id"
                                    :label="encum.encumbrance_type"
                                    :value="encum.encumbrance_type">
                                </el-option>
                            </el-select>
                            <div id="el_encum" class="error_msg text-left" style="width: 200px;"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Account Level : <span class="text-danger">*</span></label>
                            <input type="hidden" name="search[account_level]" :value="accLevel">
                            <el-select v-model="accLevel" placeholder="Account Level" size="small">
                                <el-option
                                    v-for="(account, index) in accountLevelLists"
                                    :key="index"
                                    :label="account"
                                    :value="index">
                                </el-option>
                            </el-select>
                            <div id="el_encum" class="error_msg text-left" style="width: 200px;"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Account Alias :</label>
                            {{-- <input type="hidden" name="search[accLevel]" :value="alias"> --}}
                            <el-select
                                v-model="alias"
                                filterable
                                remote
                                clearable 
                                reserve-keyword
                                placeholder="Account Alias"
                                :remote-method="getValueSetList"
                                :loading="aliLoad"
                                size="small"
                                @change="chooseAlias"
                                class="w-100"
                                style="width: 100%;"
                            >
                                <el-option
                                    v-for="(alias, key) in aliasLists"
                                    :key="alias.alias_name"
                                    :label="alias.alias_name + ' : ' + alias.description "
                                    :value="alias.template"
                                ></el-option>
                            </el-select>
                           {{--  <coa-component
                                @coa="updateCoaFrom"
                                set-name="TTM_GL_ALIAS"
                                :set-data="alias"
                            >
                            </coa-component> --}}
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-7 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Segment Override From :</label> <br>
                            {{-- :style="'width: 100%; ' + (errors.segmentOverride? 'border: 1px solid red; border-radius: 5px;' : '')" --}}
                            <el-input name="search[segment_override]" placeholder="Chart of Accounts" v-model="account_from" 
                                size="small" autocomplete="off"
                                style="width: 100%"
                                readonly
                                data-toggle="modal" 
                                :data-target="'#modal-flexfield'"
                                data-backdrop="static"
                                data-keyboard="false"
                                ref="segmentOverride"
                            > </el-input>
                            <div id="el_explode_segment" class="error_msg text-left"></div>
                        </div>
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-7 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Segment Override To :</label> <br>
                            <el-input name="search[last_segment_override]" placeholder="Chart of Accounts" v-model="account_to" 
                                size="small" autocomplete="off" 
                                style="width: 100%" account_from
                                readonly
                                data-toggle="modal" 
                                :data-target="'#modal-flexfield'"
                                data-backdrop="static"
                                data-keyboard="false"
                                {{-- ref="segmentOverride" --}}
                            > </el-input>
                            {{-- <div id="el_explode_segment" class="error_msg text-left"></div> --}}
                            <div class="text-danger mt-2"> <b>* กรุณาระบุรหัสบัญชี หรือเลือก Account Aliases</b> </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-5 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                            <div class="text-right">
                                <button class="btn btn-default btn-sm" @click.prevent="findFund()" :disabled="account_from == null || account_from == ''">
                                    <i class="fa fa-search"></i> ค้นหา
                                </button>
                                <a href="{{ $actionUrl }}" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> รีเซ็ต </a>
                            </div>
                        </div>
                    </div>
                    @include('budget.inquiry-funds._account_modal')
                </form>
            </div>
        </div>
    </div>
</div>