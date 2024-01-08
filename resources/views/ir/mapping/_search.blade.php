<div class="ibox float-e-margins mb-2" id="search_form">
    <div class="ibox-content tw-bg-blue-100 tw-border-b">
        <div class="card tw-bg-blue-100" >
            <div class="card-body" >
                <form class="">
                    <div class="row">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class="tw-font-bold tw-uppercase mb-0" for="search[ledger]">
                                Ledger : <span class="text-danger">*</span>
                            </label>
                            <input type="hidden" name="ledger" :value="ledger">
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
                            </label>
                            <input type="hidden" name="budget" :value="budget">
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
                            <input type="hidden" name="amount_type" :value="amountType">
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
                            <el-date-picker
                                class="required"
                                name="period"
                                :value="period"
                                v-model="period"
                                type="month"
                                format="MMM-yy"
                                value-format="MMM-yy"
                                placeholder="Period"
                                size="small"
                                style="width: 100%;"
                                filterable>
                            </el-date-picker>
                            <div id="el_period" class="error_msg text-left"></div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Encumbrance Type : <span class="text-danger">*</span></label>
                            <input type="hidden" name="encum_type" :value="encumType">
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
                            <input type="hidden" name="account_level" :value="accLevel">
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
                            <input type="hidden" name="search[accLevel]" :value="accLevel">
                            <el-select v-model="accLevel" placeholder="Account Level" size="small" style="width: 100%;">
                                <el-option
                                    v-for="(account, index) in accountLevelLists"
                                    :key="index"
                                    :label="account"
                                    :value="index">
                                </el-option>
                            </el-select>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-7 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Segment Override :</label>
                            <el-input name="coa" placeholder="Chart of Accounts" v-model="coa" size="small" autocomplete="off" style="width: 80%"></el-input>
                            <button type="button" class="btn btn-xs btn-danger" 
                                    style="background-color: #F6AE2D; border-color: #F6AE2D;" 
                                    data-toggle="modal" 
                                    :data-target="'#modal-flexfield'">
                                    COA.
                            </button>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-5 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                            <div class="text-right">
                                <a href="{{ $actionUrl }}" class="btn btn-sm">Clear</a>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> ค้นหา
                                </button>
                            </div>
                        </div>
                    </div>
                    @include('budget.inquiry-funds._account_modal')
                </form>
            </div>
        </div>
    </div>
</div>
