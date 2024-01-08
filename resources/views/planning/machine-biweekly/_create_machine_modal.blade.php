<create-machine-biweekly-component :product-types="{{ json_encode($productTypes) }}"
                        :budget-years="{{ json_encode($budgetYears) }}"
                        :default-input="{{ json_encode($defaultInput) }}"
                        :search-input="{{ json_encode($searchInput) }}"
                        :search="{{ json_encode($search) }}"
                        :working-hour="{{ json_encode($workingHour) }}"
                        inline-template>
    <div id="modal-create" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                        สร้างประมาณการผลิตประจำปักษ์
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" v-loading="loading">
                    <div id="modal_content_create"> 
                        <form id="machine-create-form" action="{{ route('planning.machine-biweekly.store') }}">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
                                        <input type="hidden" name="search[budget_year]" :value="budget_year">
                                        <el-select v-model="budget_year" clearable size="medium" placeholder="ปีงบประมาณ" filterable @change="getMonth" ref="budget_year" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(year, index) in budgetYears"
                                                :key="index"
                                                :label="year.thai_year"
                                                :value="year.thai_year"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > เดือน :</label>
                                    <div class="">
                                        <input type="hidden" name="search[month]" :value="month">
                                        <el-select v-if="!budget_year" v-model="month" clearable size="medium" placeholder="เดือน" ref="month" disabled>
                                            <el-option
                                               v-for="(month, index) in monthLists"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.period_num"
                                            >
                                            </el-option>
                                        </el-select>

                                        <el-select v-else v-model="month" clearable size="medium" placeholder="เดือน" filterable @change="getBiWeeklySeq" v-loading="m_loading" ref="month" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(month, index) in monthLists"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.period_num"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_month" class="error_msg text-left"></div>
                                    </div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > ปักษ์ :</label>
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

                                        <el-select v-else v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" filterable v-loading="b_loading" ref="bi_weekly" :popper-append-to-body="false">
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                    </div>
                                </div>

                                {{-- <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-4 col-xs-4 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > ประสิทธิภาพเครื่องจักร(%) :</label>
                                    <div class="">
                                        <el-input-number style="width: 100%;" name="search[efficiency_machine]" v-model="efficiency_machine" :min="0" :max="99999" size="small" ref="efficiency_machine"></el-input-number>
                                        <div id="el_explode_efficiency_machine" class="error_msg text-left"></div>
                                    </div>
                                </div> --}}

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > สั่งผลิต(%) :</label>
                                    {{-- <div class="">
                                        <el-input-number name="search[efficiency_product]" v-model="efficiency_product" :min="0" :max="100" size="small" ref="efficiency_product"></el-input-number>
                                    </div> --}}

                                    <vue-numeric
                                        :style="'width: 100%; ' + (errors.efficiency_product? 'border: 1px solid red;' : '')"
                                        name="search[efficiency_product]"
                                        v-bind:minus="false"
                                        :min="0"
                                        :max="100"
                                        class="form-control input-sm text-right"
                                        v-model="efficiency_product"
                                        autocomplete="off"
                                    ></vue-numeric>
                                    <div id="el_explode_efficiency_product" class="error_msg text-left"></div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-4 col-xs-4 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > ชั่วโมงทำงานเริ่มต้น :</label>
                                    <input type="hidden" name="search[working_hour]" :value="working_hour">
                                    <el-select v-model="working_hour" size="medium" placeholder="ชั่วโมงทำงานเริ่มต้น" filterable v-loading="b_loading" :popper-append-to-body="false">
                                       <el-option
                                           v-for="(hour, index) in workingHour"
                                            :key="index"
                                            :label="hour.meaning"
                                            :value="hour.lookup_code"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class=" tw-font-bold tw-uppercase mt-1">&nbsp;<br></label>
                                    <div class="text-right">
                                        <button class="btn btn-primary btn-sm" @click.prevent="submit()"> 
                                            <i class="fa fa-plus"></i> สร้าง
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-times"></i> ยกเลิก
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</create-machine-biweekly-component>