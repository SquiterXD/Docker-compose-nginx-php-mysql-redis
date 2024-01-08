<div class="ibox float-e-margins mb-2" v-loading="loading">
    <div class="row col-12 mb-2">
        <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
            <h3> ประมาณการกำลังผลิตประจำปี </h3>
        </div>
        <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 text-right">
            <button class="btn btn-white btn-lg" @click.prevent="submit">
                <i class="fa fa-search"></i> ค้นหา
            </button>
            <a href="{{ $actionUrl }}" class="btn btn-white btn-lg">ล้าง</a>
        </div>
    </div>
    <div class="card" >
        <div class="card-body" >
            <form id="machine-form" action="{{ $actionUrl }}">
                <div class="row">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                        <div class="input-group ">
                            <input type="hidden" name="search[budget_year]" :value="budget_year">
                            <el-select  v-model="budget_year" size="medium" placeholder="ปีงบประมาณ" filterable @change="changeSearch" ref="budget_year">
                                <el-option
                                   v-for="(year, index) in budgetYears"
                                    :key="index"
                                    :label="year.thai_year"
                                    :value="year.thai_year"
                                >
                                </el-option>
                            </el-select>
                        </div>
                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                    </div>

                    {{-- <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                        <div class="">
                            <input type="hidden" name="search[month]" :value="month">
                            <el-select v-if="!budget_year" v-model="month" clearable size="medium" placeholder="เดือน" disabled ref="month">
                                <el-option
                                   v-for="(month, index) in monthLists"
                                    :key="index"
                                    :label="month.thai_month"
                                    :value="month.period_num"
                                >
                                </el-option>
                            </el-select>

                            <el-select v-else v-model="month" clearable size="medium" placeholder="เดือน" filterable v-loading="m_loading" ref="month">
                                <el-option
                                   v-for="(month, index) in monthLists"
                                    :key="index"
                                    :label="month.thai_month"
                                    :value="month.period_num"
                                >
                                </el-option>
                            </el-select>
                        </div>
                        <div id="el_explode_month" class="error_msg text-left"></div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต </label>
                        <div>
                            <input type="hidden" name="search[product_type]" :value="product_type"> 
                            <el-radio-group v-model="product_type" size="small" @change="changeSearch()">
                                <template v-for="(product, index) in productTypes">
                                    <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                        @{{ product.meaning }}
                                    </el-radio>
                                </template>
                            </el-radio-group>
                        </div>
                    </div>

                    {{-- <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" >&nbsp;</label>
                        <div class="text-right">
                            <button class="btn btn-white btn-sm" @click.prevent="submit">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                            <a href="{{ $actionUrl }}" class="btn btn-white btn-sm">ล้าง</a>
                        </div>
                    </div> --}}
                </div>

                {{-- <div v-if="search && header" class="row mt-2">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-4 col-xs-4 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ประสิทธิภาพเครื่องจักร(%) </label>
                        <div class="">
                            <el-input-number style="width: 100%" name="search[efficiency_machine]" v-model="efficiency_machine" :min="0" :max="99999" size="small"></el-input-number>
                        </div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-top: 30px;">
                        <button class="btn btn-success btn-sm text-left" @click.prevent="updateDataEfficiencyMachine">
                            ยืนยันเปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)
                        </button>
                    </div>
                </div>
                <div class="row mt-2" v-if="search && header">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > สั่งผลิต(%) </label>
                        <div class="">
                            <el-input-number style="width: 100%" name="search[efficiency_product]" v-model="efficiency_product" :min="1" :max="99999" size="small"></el-input-number>
                        </div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-4 col-xs-4" style="margin-top: 30px;">
                        <button class="btn btn-success btn-sm" @click.prevent="updateDataEfficiencyProduct"> 
                            ยืนยันเปลี่ยนแปลงสั่งผลิต (%)
                        </button>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>

    @if ($search)
        <div class="row">
            <div class="col-lg-12">
                <lines-machine-yearly-component 
                    {{-- :p-lines="{{ json_encode($lines) }}"
                    :p-res-plan-date="{{ json_encode($resPlanDate) }}"
                    :p-working-hour="{{ json_encode($workingHour) }}"
                    :p-eamperformance-machines="{{ json_encode($eamperformanceMachines) }}"
                    :p-efficiency-machines="{{ json_encode($efficiencyMachines) }}"
                    :p-efficiency-products="{{ json_encode($efficiencyProducts) }}"
                    :p-machine-maintenances="{{ json_encode($machineMaintenances) }}"
                    :p-machine-downtimes="{{ json_encode($machineDowntimes) }}"
                    :p-holidays="{{ json_encode($holidays) }}" --}}
                    :p-efficiency-machine-percent="efficiency_machine"
                    :p-efficiency-product-percent="efficiency_product"
                    :p-header="{{ json_encode($header) }}"
                    :p-default-input="{{ json_encode($defaultInput) }}"
                    :p-search-input="{{ json_encode($searchInput) }}"
                    :p-edit-flag="edit_flag"
                    :p-show-flag="show_flag"
                    :month-details="{{ json_encode($monthDetails) }}"
                    :budget-year="budget_year"
                    :product-type="product_type"
                    :url="{{ json_encode($url) }}"
                    p-date-format="{{ trans('date.format-month-pp') }}"
                    :btn-trans="{{ json_encode($btnTrans) }}"
                    :search="{{ json_encode($search) }}"
                    inline-template>
                    <div>
                    @include('planning.machine-yearly._line')
                    </div>
                </lines-machine-yearly-component>
            </div>
        </div>
    @endif
</div>