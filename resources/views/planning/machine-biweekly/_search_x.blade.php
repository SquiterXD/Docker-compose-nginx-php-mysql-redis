<div class="ibox float-e-margins mb-2" >
    <div class="row col-12 mb-2">
        <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
            <h3> ประมาณการกำลังผลิตประจำปักษ์ </h3>
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
                            <el-select  v-model="budget_year" size="medium" placeholder="ปีงบประมาณ" filterable @change="getMonth" ref="budget_year">
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

                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                        <div class="">
                            <input type="hidden" name="search[month]" :value="month">
                            <el-select v-if="!budget_year" v-model="month" size="medium" placeholder="เดือน" ref="month" disabled>
                                <el-option
                                   v-for="(month, index) in monthLists"
                                    :key="index"
                                    :label="month.thai_month"
                                    :value="month.period_num"
                                >
                                </el-option>
                            </el-select>

                            <el-select v-else v-model="month" size="medium" placeholder="เดือน" filterable @change="getBiWeeklySeq" v-loading="m_loading" ref="month">
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
                    </div>

                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ปักษ์ </label>
                        <div class="">
                            <input type="hidden" name="search[bi_weekly]" :value="bi_weekly">
                            <el-select v-if="!month" v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" ref="bi_weekly" disabled>
                               <el-option
                                   v-for="(biweekly, index) in biWeeklyLists"
                                    :key="index"
                                    :label="biweekly.biweekly"
                                    :value="biweekly.biweekly"
                                >
                                </el-option>
                            </el-select>

                            <el-select v-else v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" filterable @change="getBiWeeklyDetail" v-loading="b_loading" ref="bi_weekly">
                               <el-option
                                   v-for="(biweekly, index) in biWeeklyLists"
                                    :key="index"
                                    :label="biweekly.biweekly"
                                    :value="biweekly.biweekly"
                                >
                                </el-option>
                            </el-select>
                        </div>
                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                    </div>

                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ประจำวันที่ </label>
                        <div v-if="bi_weekly_detail" style="font-size: 14px;" class="p-1">
                            {{-- @{{ bi_weekly_detail }} --}}
                            <date-range-detail :date-range-detail="bi_weekly_detail"> </date-range-detail>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต </label>
                        <div>
                            <input type="hidden" name="search[product_type]" :value="product_type">
                            <el-radio-group v-model="product_type" size="small" @change="changeProductType()">
                                <template v-for="(product, index) in productTypes">
                                    <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                        @{{ product.meaning }}
                                    </el-radio>
                                </template>
                            </el-radio-group>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($search)
        <div class="row">
            <div class="col-lg-12 mt-3">
                <lines-machine-biweekly-component :p-lines="{{ json_encode($lines) }}"
                    :p-res-plan-date="{{ json_encode($resPlanDate) }}"
                    :p-efficiency-machine-percent="efficiencyMachine"
                    :p-efficiency-product-percent="efficiencyProduct"
                    :p-working-hour="{{ json_encode($workingHour) }}"
                    :p-working-holiday="{{ json_encode($workingHoliday) }}"
                    {{-- value mapWithKeys --}}
                    :p-eamperformance-machines="{{ json_encode($eamperformanceMachines) }}"
                    :p-efficiency-machines="{{ json_encode($efficiencyMachines) }}"
                    :p-efficiency-products="{{ json_encode($efficiencyProducts) }}"
                    :p-machine-maintenances="{{ json_encode($machineMaintenances) }}"
                    :p-machine-downtimes="{{ json_encode($machineDowntimes) }}"
                    :p-holidays="{{ json_encode($holidays) }}"
                    :p-header="{{ json_encode($header) }}"
                    :p-machine-groups="{{ json_encode($machineGroups) }}"
                    :p-machine-desc="{{ json_encode($machineDesc) }}"
                    :p-edit-flag="edit_flag"
                    :p-show-flag="show_flag"
                    p-date-format="{{ trans('date.format-month-pp') }}"
                    :btn-trans="{{ json_encode($btnTrans) }}"
                    :url="{{ json_encode($url) }}"
                    :search="{{ json_encode($search) }}"
                    :p-machine-dt-lines="{{ json_encode($machineDtLines) }}"
                    inline-template>
                    <div>
                    @include('planning.machine-biweekly._line')
                    @include('planning.machine-biweekly._om_sales_modal')
                    {{-- @include('planning.machine-biweekly._machine_downtime_modal') --}}
                    </div>
                </lines-machine-biweekly-component>
            </div>
        </div>
    @endif
</div>