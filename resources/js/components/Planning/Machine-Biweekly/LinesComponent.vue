<template>
    <div v-loading="loading">
        <template v-if="!header">
            <div class="col-12 text-center">
                <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
            </div>
        </template>
        <div v-if="show_flag && header">
            <div class="row m-2">
                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 mt-2">
                    <div class="tw-font-bold tw-uppercase mb-1">
                        <h2 class="tw-font-bold"> 
                            <efficiency-detail :total="totalProductAll" :unit="unit"> </efficiency-detail>
                        </h2>
                        <div class="tw-font-bold tw-uppercase mt-3">
                            <h3 style="color: #898686;">
                                ประมาณกำลังผลิตหักประมาณการจำหน่าย : {{ totalProductAll - totalOmSalesForecast | number2Digit }} {{ unit }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 mt-2 text-right">
                    <div class="col-12 p-0">
                        <template v-if="header">
                            <div class="text-right">
                                <ModalHol
                                    :holidaysHtml="holidaysHtml"
                                    :lastUpdate="lastUpdate"
                                    :budgetYear="header.budget_year"
                                    :url="url"
                                > </ModalHol>
                                <OMSalesForecast v-if="header.product_type != 'KK'"
                                    :omSalesForecast="pSaleForecastsHtml"
                                    :pSaleForecasts="pSaleForecasts"
                                    :versionLists="versionLists"
                                    :url="url"
                                ></OMSalesForecast>
                            </div>
                            <div class="text-right">
                                <button v-if="!isControlDisable && isCurrBiweekly" class="btn btn-warning btn-md" style="padding-left: 7px;" @click.prevent="checkUpdateMachine">
                                    <i class="fa fa-calendar"></i> อัพเดตรายละเอียดเครื่องจักร
                                </button>
                                <button v-if="!isControlDisable && isCurrBiweekly" class="btn btn-warning btn-md" style="padding-left: 7px;" @click.prevent="checkUpdatePlanPM">
                                    <i class="fa fa-calendar"></i> อัพเดตแผนซ่อมบำรุง
                                </button>
                                <machine-downtime
                                    v-if="!isControlDisable && isCurrBiweekly"
                                    :header = "header"
                                    :machine-groups = "pMachineGroups"
                                    :machine-desc = "pMachineDesc"
                                    :btn-trans = "btnTrans"
                                    :date-format = "pDateFormat"
                                    :machine-dt-lines = "pMachineDtLines"
                                    :url = "url"
                                    :valid-action="valid_action"
                                ></machine-downtime>
                            </div>
                            <div v-if="messageCheckMachineHtml && !isControlDisable && isCurrBiweekly">
                                <h4 class="text-danger mt-3">
                                    <div v-html="messageCheckMachineHtml"></div>
                                </h4>
                            </div>
                            <div v-if="messageCheckPMHtml && !isControlDisable && isCurrBiweekly">
                                <h4 class="text-danger mt-3">
                                    <div v-html="messageCheckPMHtml"></div>
                                </h4>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <template v-if="!messageCheckMachineHtml">
                <div class="row m-2" v-if="header">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-4 col-xs-4 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ประสิทธิภาพเครื่องจักร(%) </label>
                        <div class="">
                            <vue-numeric style="width: 100%" name="search[efficiency_machine]"
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                :min="0"
                                :max="100"
                                class="form-control input-sm text-right"
                                v-model="efficiency_machine"
                                :disabled="isControlDisable || !isCurrBiweekly"
                            ></vue-numeric>
                            <!-- :disabled="isControlDisable" -->
                        </div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-4 col-xs-4" style="margin-top: 30px;">
                        <button v-if="!isControlDisable && isCurrBiweekly" class="btn btn-success btn-md text-left" @click.prevent="updateDataEfficiencyMachine">
                            ยืนยันเปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)
                        </button>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > สั่งผลิต(%) </label>
                        <div class="">
                            <!-- <el-input-number style="width: 100%" name="search[efficiency_product]" v-model="efficiency_product" :min="0" :max="100" size="small" :disabled="isControlDisable"></el-input-number> -->
                            <vue-numeric style="width: 100%" name="search[efficiency_product]"
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                :min="0"
                                :max="100"
                                class="form-control input-sm text-right"
                                v-model="efficiency_product"
                                :disabled="isControlDisable || !isCurrBiweekly"
                            ></vue-numeric>
                            <!-- :disabled="isControlDisable" -->
                        </div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin-top: 30px;">
                        <button v-if="!isControlDisable && isCurrBiweekly" class="btn btn-success btn-md" style="padding-left: 7px;" @click.prevent="updateDataEfficiencyProduct">
                            ยืนยันเปลี่ยนแปลงสั่งผลิต (%)
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row" v-if="header">
                    <div class="col-md-8">
                        <h2 class="tw-font-bold"> Machine Detail </h2>
                    </div>
                    <div class="col-md-4 text-right" v-if="header">
                        <button v-if="!edit_flag && !isControlDisable && isCurrBiweekly" :class="btnTrans.edit.class + ' btn-lg tw-w-25'" @click="editProcess(edit_flag = !edit_flag)">
                            <i :class="btnTrans.edit.icon"></i> {{ btnTrans.edit.text }}
                        </button>
                        <button v-if="edit_flag" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="updateDataEfficiencyMachineByLine()">
                            <i :class="btnTrans.save.icon"></i> {{ btnTrans.save.text }}
                        </button>
                        <button v-if="edit_flag" :class="btnTrans.cancel.class + ' btn-lg tw-w-25'" @click="editProcess(edit_flag = !edit_flag)">
                            <i :class="btnTrans.cancel.icon"></i> {{ btnTrans.cancel.text }}
                        </button>
                    </div>
                </div>
                <div class="hr-line-dashed m-1"></div>
                <div class="row col-12">
                    <div class="col-md-7">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
                            <label class=" tw-font-bold tw-uppercase mb-1"> หมายเหตุ </label>
                            <div class="input-group">
                                <el-input
                                    type="textarea"
                                    :rows="2"
                                    placeholder="หมายเหตุ"
                                    v-model="note_description"
                                    maxlength="250"
                                    show-word-limit
                                    :disabled="!edit_flag">
                                </el-input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-1">
                        <span> &nbsp; <br> </span>
                        <div> <i class="fa fa-square fa-2x" style="color: #ffc107"></i> &nbsp; แผนซ่อมบำรุงเครื่องจักร </div>
                    </div>
                    <div class="col-md-2 p-1">
                        <span> &nbsp; <br> </span>
                        <div> <i class="fa fa-square fa-2x" style="color: #e02b1e"></i> &nbsp; ปรับลดกำลังการผลิต </div>
                    </div>
                    <div class="col-md-1 p-1">
                        <span> &nbsp; <br> </span>
                        <div> <i class="fa fa-square fa-2x" style="color: #cccccc"></i> &nbsp; วันหยุด </div>
                    </div>
                </div>
                <div class="hr-line-dashed m-1"></div>
                <div class="table-responsive"> <!-- style="max-height: 500px;" -->
                    <table class="table table-hover" style="position: sticky;"> <!-- style="position: sticky;" -->
                        <thead>
                            <tr>
                                <th class="text-center sticky-col first-col" style="vertical-align: middle; width: 100px; border-bottom: 0px;">
                                   <div> ขอบเขตเครื่องจักร </div>
                                </th>
                                <th class="text-center sticky-col second-col" style="vertical-align: middle;">
                                   <div> รายละเอียดเครื่องจักร </div>
                                </th>
                                <th class="text-center sticky-col th-col" style="vertical-align: middle;">
                                    <div> ความเร็วเครื่องจักรต่อนาที ({{ per_unit }}) </div>
                                </th>
                                <th class="text-center sticky-col fo-col" style="vertical-align: middle;">
                                    <div> ประสิทธิภาพเครื่องจักร(%) </div>
                                </th>
                                <th class="text-center sticky-col fi-col" style="vertical-align: middle;" :title="efficiencyMachineFormula">
                                    <div> ผลผลิตตามประสิทธิภาพต่อนาที <br> ({{ per_unit }}) </div>
                                </th>
                                <template v-for="(planDate, index) in resPlanDate">
                                    <th class="text-center" style="vertical-align: middle;">
                                        <div class="mb-2">
                                            <small style="color: #000" class="mb-2 tw-font-bold">
                                                <span class="label" style="padding-bottom: 1px; padding-top: 1px; font-size: 10px;">
                                                    {{ index+1 }} {{ planDate.day_of_week }}
                                                </span> <br>
                                                {{ planDate.res_plan_date_display }} <br>
                                            </small>
                                        </div>
                                        <working-hour-component
                                            :p-plan-date="planDate"
                                            :p-working-hour="working_holiday" 
                                            :p-working-hour-edit="workingHourEdit"
                                            :p-edit-flag="edit_flag"
                                            :p-check-date="checkDate">
                                        </working-hour-component>
                                    </th>
                                </template>
                                <th class="text-center" style="vertical-align: middle;">
                                    <div> รวมกำลังผลิต </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="lines.length <= 0">
                                <tr>
                                    <td colspan="6" class="text-center" style="vertical-align: middle;">
                                        <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <template v-for="(lineLists, machineGroup) in lines">
                                    <tr>
                                        <td :rowspan="lineLists.length+1" class="text-left sticky-col first-col">
                                            <div style="width: 100px;"> {{ covertName(machineGroup) }} </div>
                                        </td>
                                        <tr v-for="(line, indexLine) in lineLists">
                                            <td class="text-left sticky-col second-col" :style="sel_machine == line.machine_name? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selMachine(line.machine_name)">
                                                <div style="width: 150px;"> {{ line.machine_description }} </div>
                                            </td>
                                            <td class="text-right sticky-col th-col" :style="sel_machine == line.machine_name? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selMachine(line.machine_name)">
                                               <span style="width: 100%;"> {{ decimal(line.machine_speed) }} </span>
                                            </td>
                                            <td class="text-center sticky-col fo-col" :style="sel_machine == line.machine_name? 'background-color: #9AD9DB;' : ''" @click="selMachine(line.machine_name)">
                                                <eff-machine
                                                    :edit-flag = "edit_flag"
                                                    :line = "line"
                                                    :line-machine-edit = "lineMachineEdit"
                                                ></eff-machine>
                                            </td>
                                            <td class="text-right sticky-col fi-col" :style="sel_machine == line.machine_name? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selMachine(line.machine_name)">
                                                <div style="width: 100%;"> {{ decimal(line.efficiency_machine_per_min) }} </div>
                                            </td>
                                            <template v-for="(plan, index) in resPlanDate">
                                                <template v-for="(efficiencyProduct, index) in efficiencyFullProducts">
                                                    <template v-if="machineDowntimes[plan.res_plan_date_display][line.machine_name] == 'Y' && plan.res_plan_date_display == index">
                                                        <td class="text-right" style="background-color: #e02b1e;"
                                                            :title="efficiencyDayFormula"
                                                            @click="selMachine(line.machine_name)">
                                                            <div style="width: 70px;"> 0.00 </div>
                                                        </td>
                                                    </template>
                                                    <template v-else-if="machineMaintenances[plan.res_plan_date_display][line.machine_name] == 'Y' && plan.res_plan_date_display == index">
                                                        <td class="text-right" style="background-color: #ffc107;"
                                                            :title="efficiencyDayFormula"
                                                            @click="selMachine(line.machine_name)">
                                                            <div style="width: 70px;"> 0.00 </div>
                                                        </td>
                                                    </template>
                                                    <template v-else-if="plan.holiday_flag == 'Y' && plan.res_plan_date_display == index">
                                                        <td class="text-right" style="background-color: #cccccc;"
                                                            :title="efficiencyDayFormula"
                                                            @click="selMachine(line.machine_name)">
                                                            {{ efficiencyProduct[line.machine_name] | number2Digit }}
                                                        </td>
                                                    </template>
                                                    <template v-else-if="plan.holiday_flag == 'P' && plan.res_plan_date_display == index">
                                                        <td class="text-right" style="background-color: #878788;"
                                                            :title="efficiencyDayFormula"
                                                            @click="selMachine(line.machine_name)">
                                                            {{ efficiencyProduct[line.machine_name] | number2Digit }}
                                                        </td>
                                                    </template>
                                                    <template v-else-if="plan.holiday_flag != 'Y'
                                                        && plan.res_plan_date_display == index
                                                        && machineDowntimes[plan.res_plan_date_display][line.machine_name] != 'Y'
                                                        && machineMaintenances[plan.res_plan_date_display][line.machine_name] != 'Y'">
                                                        <td class="text-right"
                                                            :title="efficiencyDayFormula" 
                                                            :style="sel_machine == line.machine_name? 'background-color: #9AD9DB;' : ''"
                                                            @click="selMachine(line.machine_name)">
                                                            <div style="width: 70px;"> 
                                                                {{ efficiencyProduct[line.machine_name] | number2Digit }}
                                                            </div>
                                                        </td>
                                                    </template>
                                                </template>
                                            </template>
                                            <td :style="sel_machine == line.machine_name? 'background-color: #9AD9DB;' : ''" 
                                                @click="selMachine(line.machine_name)">
                                            </td>
                                        </tr>
                                    </tr>
                                    <!-- เพิ่ม efficiency : 100% สั่งผลิต 20112021-->
                                    <tr>
                                        <td class="text-right sticky-col t1-col" colspan="4" style="vertical-align: middle;"> <strong> รวม </strong> </td>
                                        <td class="text-right sticky-col t2-col" style="vertical-align: middle; background-color: #70d200;">
                                            <template v-for="res in summary">
                                                <template v-if="machineGroup == res.machine_group">
                                                    <span class="tw-font-bold"> {{ decimal(res.efficiency_machine_per_min) }} </span>
                                                </template>
                                            </template>
                                        </td>
                                        <template v-for="(plan, index) in resPlanDate">
                                            <td v-if="plan.holiday_flag == 'Y'" class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                                <div class="tw-font-bold" style="width: 70px;">
                                                    <efficiency-product-component :p-efficiency-products="efficiencyFullProducts"
                                                        :p-lines="lines"
                                                        :p-plan-date="plan"
                                                        :p-machine-group="machineGroup"
                                                        :p-total-product-arr="totalFullProductArr"
                                                        :p-machine-maintenances="machineMaintenances"
                                                        :p-machine-downtimes="machineDowntimes"
                                                    >
                                                    </efficiency-product-component>
                                                </div>
                                            </td>
                                            <td v-else class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                                <div class="tw-font-bold" style="width: 70px;">
                                                    <efficiency-product-component :p-efficiency-products="efficiencyFullProducts"
                                                        :p-lines="lines"
                                                        :p-plan-date="plan"
                                                        :p-machine-group="machineGroup"
                                                        :p-total-product-arr="totalFullProductArr"
                                                        :p-machine-maintenances="machineMaintenances"
                                                        :p-machine-downtimes="machineDowntimes"
                                                    >
                                                    </efficiency-product-component>
                                                </div>
                                            </td>
                                        </template>
                                        <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                            <div class="tw-font-bold text-right" style="width: 70px;">
                                                <summary-efficiency-product-by-group :p-machine-group="machineGroup"
                                                    :p-total-product-arr="totalFullProductArr"
                                                    :p-res-plan-date="resPlanDate">
                                                </summary-efficiency-product-by-group>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- efficiency ตาม % สั่งผลิตตามค่าที่กำหนดไว้ที่ Header -->
                                    <tr>
                                        <td class="text-right sticky-col t1-col" colspan="4" style="vertical-align: middle;">
                                            <strong> รวมผลผลิตที่คาดว่าจะได้ </strong>
                                        </td>
                                        <td class="text-right sticky-col t2-col" style="vertical-align: middle; background-color: #70d200;">
                                            <template v-for="res in summary">
                                                <template v-if="machineGroup == res.machine_group">
                                                    <span class="tw-font-bold"> {{ decimal(res.efficiency_machine_per_min) }} </span>
                                                </template>
                                            </template>
                                        </td>
                                        <template v-for="(plan, index) in resPlanDate">
                                            <td v-if="plan.holiday_flag == 'Y'" class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                                <div class="tw-font-bold" style="width: 70px;">
                                                    <efficiency-product-component :p-efficiency-products="efficiencyProducts"
                                                        :p-lines="lines"
                                                        :p-plan-date="plan"
                                                        :p-machine-group="machineGroup"
                                                        :p-total-product-arr="totalProductArr"
                                                        :p-machine-maintenances="machineMaintenances"
                                                        :p-machine-downtimes="machineDowntimes"
                                                    >
                                                    </efficiency-product-component>
                                                </div>
                                            </td>
                                            <td v-else class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                                <div class="tw-font-bold" style="width: 70px;">
                                                    <efficiency-product-component :p-efficiency-products="efficiencyProducts"
                                                        :p-lines="lines"
                                                        :p-plan-date="plan"
                                                        :p-machine-group="machineGroup"
                                                        :p-total-product-arr="totalProductArr"
                                                        :p-machine-maintenances="machineMaintenances"
                                                        :p-machine-downtimes="machineDowntimes"
                                                    >
                                                    </efficiency-product-component>
                                                </div>
                                            </td>
                                        </template>
                                        <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                            <div class="tw-font-bold text-right" style="width: 70px;">
                                                <summary-efficiency-product-by-group :p-machine-group="machineGroup"
                                                    :p-total-product-arr="totalProductArr"
                                                    :p-res-plan-date="resPlanDate">
                                                </summary-efficiency-product-by-group>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <tr>
                                    <td class="text-right sticky-col t1-col" colspan="4" style="vertical-align: middle;">
                                        <strong> รวมกำลังผลิตแต่ละวัน </strong>
                                    </td>
                                    <td class="text-right sticky-col t2-col" style="vertical-align: middle; background-color: #70d200;">
                                        <div class="tw-font-bold text-right"> {{ decimal(totalMachineAll) }} </div>
                                    </td>
                                    <template v-for="(plan, index) in resPlanDate">
                                        <template v-for="res in summaryProduct">
                                            <template v-if="plan.working_hour == 0 && res.plan_date == plan.res_plan_date_display">
                                                <td class="tw-font-bold text-right" style="vertical-align: middle; background-color: #70d200;">
                                                    <div style="width: 70px;"> 0.00 </div>
                                                </td>
                                            </template>
                                            <template v-if="plan.working_hour != 0 && res.plan_date == plan.res_plan_date_display">
                                                <td class="tw-font-bold text-right" style="vertical-align: middle; background-color: #70d200;">
                                                    <div style="width: 70px; "> 
                                                        {{ res.total | number2Digit }}
                                                    </div>
                                                </td>
                                            </template>
                                        </template>
                                    </template>
                                    <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                        <div class="tw-font-bold text-right" style="width: 70px;"> {{ totalProductAll | number2Digit }} </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import MachineDowntime from './ModalMachineDowntime.vue';
    import EffMachine from '../Commons/Machine/EfficiencyMachineComponent.vue';
    import DateRangeDetail from '../Commons/Machine/DateRangeDetail.vue';
    import EfficiencyDetail from '../Commons/Machine/EfficiencyDetail.vue';
    import OMSalesForecast  from './OMSalesForecast.vue';
    import ModalHol  from './ModalHoliday.vue';
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            MachineDowntime, EffMachine, DateRangeDetail, EfficiencyDetail, OMSalesForecast, ModalHol, VueNumeric
        },
        props:['pLines', 'pResPlanDate', 'pEfficiencyMachinePercent', 'pEfficiencyProductPercent', 'pWorkingHour', 'pWorkingHoliday', 'pEamperformanceMachines', 'pEfficiencyMachines', 'pEfficiencyProducts', 'pHeader', 'pMachineMaintenances', 'pMachineDowntimes', 'pHolidays', 'updateEditFlag', 'pShowFlag', 'pMachineGroups', 'pMachineDesc', 'btnTrans', 'pDateFormat', 'url', 'search', 'pMachineDtLines', 'pSaleForecastsHtml', 'pEfficiencyFullProducts', 'pSaleForecasts', 'versionLists', 'holidaysHtml', 'lastUpdate'],
        data() {
            return {
                header: this.pHeader,
                lines: this.pLines,
                resPlanDate: this.pResPlanDate,
                efficiency_machine: this.pEfficiencyMachinePercent,
                efficiency_product: this.pEfficiencyProductPercent,
                working_hour: this.pWorkingHour,
                working_holiday: [],
                efficiencyProducts: this.pEfficiencyProducts,
                machineMaintenances: this.pMachineMaintenances,
                machineDowntimes: this.pMachineDowntimes,
                holidays: this.pHolidays,
                edit_flag: false,
                show_flag: this.pShowFlag,
                loading: false,
                valid_action: false,
                summary: [],
                summaryProduct: [],
                totalMachineAll: 0,
                totalProductAll: 0,
                totalOmSalesForecast: 0,
                totalProductArr: {},
                //Edit transacyion by line: Efficiency Machines/Res plan date
                lineMachineEdit: {},
                workingHourEdit: {},
                unit: '',
                machineLines: [],
                sel_machine: '',
                // Piyawut A. 20211102--Issue
                checkDate: {
                    current_date: '',
                    start_date: '',
                    end_date: '',
                },
                isControlDisable: false,
                isCurrBiweekly: false,
                efficiencyDayFormula: '',
                efficiencyMachineFormula: '',
                note_description: this.pHeader.note_description,
                per_unit: '',
                // Full efficiency: 100%
                efficiencyFullProducts: this.pEfficiencyFullProducts,
                totalFullProductArr: {},
                // New Requirement : แจ้งเตือน PM Confirm to text
                messageCheckPMHtml: '',
                messageCheckMachineHtml: '',
            }
        },
        mounted() {
            this.loading = true;
            this.getUnitProductType();
            this.getWorkingHour();
            this.getDateByBiWeekly();
            // this.checkPMConfirm();
            // this.checkMachineDetail();
        },
        computed: {
            //คำนวณ total EffMachine แต่ละกรุ๊ป
            summaryEfficiencyMachineGroup(){
                //BY GROUP
                var result = [];
                Object.values(this.lines).reduce(function(res, value) {
                    value.filter(function(val) {
                        if (!res[val.machine_group]) {
                            res[val.machine_group] = { machine_group: val.machine_group, efficiency_machine_per_min: 0 };
                            result.push(res[val.machine_group]);
                        }
                        res[val.machine_group].efficiency_machine_per_min += Number(val.efficiency_machine_per_min);
                    });
                    return res;
                }, {});
                this.summary = result;
            },
            //เมื่อมีการแก้ไขข้อมูล planDate--คำนวณแต่ละวันของ Machine
            totalEfficiencyProduct() {
                var vue = this;
                //efficiency_product
                Object.values(vue.lines).filter(function(lines) {
                    Object.values(lines).filter(function(line) {
                        vue.resPlanDate.filter(function(planDate){
                            let f = (Number(line.efficiency_machine_per_min) * (Number(planDate.working_hour)-1)*60) ;
                            let r = (Number(f)*(Number(vue.efficiency_product)/100))/1000000;
                            let t = r <= 0? 0: r;
                            let resT = 0;
                            let resFT = 0;
                            if (vue.machineDowntimes[planDate.res_plan_date_display][line.machine_name] == 'Y'
                                || vue.machineMaintenances[planDate.res_plan_date_display][line.machine_name] == 'Y') {
                                t = t*0;
                            }
                            // resT = Number(parseFloat(t)).toFixed(2);
                            // resT = parseFloat(Number(t).toFixed(2));
                            resT = Math.floor(Number(t) * 100) / 100;
                            vue.efficiencyProducts[planDate.res_plan_date_display][line.machine_name] = resT;

                            // เพิ่ม efficiency full product 100% -- 20112021
                            let fr = (Number(f)*(100/100))/1000000;
                            let ft = fr <= 0? 0: fr;
                            if (vue.machineDowntimes[planDate.res_plan_date_display][line.machine_name] == 'Y'
                                || vue.machineMaintenances[planDate.res_plan_date_display][line.machine_name] == 'Y') {
                                ft = ft*0;
                            }
                            // resFT = Number(parseFloat(ft)).toFixed(2);
                            // resFT = parseFloat(Number(ft).toFixed(2));
                            resFT = Math.floor(Number(ft) * 100) / 100;
                            vue.efficiencyFullProducts[planDate.res_plan_date_display][line.machine_name] = resFT;
                        });
                    });
                });
            },
            summaryEfficiencyProduct(){
                var vue = this;
                var result = [];
                Object.keys(vue.efficiencyProducts).reduce(function(res, planDate) {
                    Object.values(vue.lines).filter(function(lines) {
                        Object.values(lines).filter(function(line) {
                            if (!res[planDate]) {
                                res[planDate] = { plan_date: planDate, total: 0 };
                                result.push(res[planDate]);
                            }
                            if (vue.machineMaintenances[planDate][line.machine_name] == 'Y'
                                || vue.machineDowntimes[planDate][line.machine_name] == 'Y'
                                ) {
                                // || vue.holidays[planDate][line.machine_name] == 'Y'
                                // || vue.holidays[planDate][line.machine_name] == 'P'
                               res[planDate].total += 0;
                            }else{
                                res[planDate].total += Number(vue.efficiencyProducts[planDate][line.machine_name]);
                            }
                            // res[planDate].total += Number(vue.efficiencyProducts[planDate][line.machine_name]);
                        });
                    });
                    return res;
                }, {});
                vue.summaryProduct = result;
            },
            summaryTotalEfficiencyProductAll(){
                var vue = this;
                var total = 0;
                vue.summaryProduct.filter(function(line) {
                    total += Number(line.total);
                });
                vue.totalProductAll = total;
            },
            summaryTotalEfficiencyMachineAll(){
                var vue = this;
                var total = 0;
                vue.summary.filter(function(line) {
                    total += Number(line.efficiency_machine_per_min);
                });
                vue.totalMachineAll = total;
            },
            summaryOmSaleForcastTotal(){
                var vue = this;
                var total = 0;
                vue.pSaleForecasts.filter(function(line) {
                    total += Number(line.forecast_million_qty);
                });
                vue.totalOmSalesForecast = total;
            },
        },
        watch:{
            summaryEfficiencyMachineGroup(newValue){
                return newValue;
            },
            totalEfficiencyProduct(newValue){
                return newValue;
            },
            summaryEfficiencyProduct(newValue){
                return newValue;
            },
            summaryTotalEfficiencyProductAll(newValue){
                return newValue;
            },
            summaryTotalEfficiencyMachineAll(newValue){
                return newValue;
            },
            summaryOmSaleForcastTotal(newValue){
                return newValue;
            },
            pShowFlag: async function (newValue) {
                this.show_flag = newValue;
            },
        },
        methods: {
            decimal(number) {
                return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            covertName(machineGroup){
                return this.lines[machineGroup][0].machine_group_description;
            },
            changeEfficiencyMachineByLine(machineGroup, index){
                console.log(machineGroup);
                var vue = this;
                //efficiency_machine_per_min
                let d = Number(vue.lines[machineGroup][index].machine_speed) * (Number(vue.lines[machineGroup][index].machine_eamperformance) / 100);
                //efficiency_product
                vue.resPlanDate.filter(function(planDate){
                    let f = (Number(d) * (Number(planDate.working_hour)-1)*60) ;
                    let r = (Number(f)*(Number(vue.efficiency_product)/100))/1000000;
                    let t = r <= 0? 0: r;
                    Object.values(vue.efficiencyProducts[planDate.res_plan_date_display]).filter(function(res, value) {
                        // vue.efficiencyProducts[planDate.res_plan_date_display][vue.lines[machineGroup][index].machine_name] = Number(t.toFixed(3));
                        vue.efficiencyProducts[planDate.res_plan_date_display][vue.lines[machineGroup][index].machine_name] = Math.floor(Number(t) * 100) / 100;
                    });
                });
                //result
                vue.lines[machineGroup][index].efficiency_machine_per_min = d;
                //Stamp line ที่มีการแก้ไขจำนวน Efficiency
                Vue.set(vue.lineMachineEdit, vue.lines[machineGroup][index].machine_name, Number(vue.lines[machineGroup][index].machine_eamperformance));
            },
            // FOR G -- PTPP_MACHINE_BIWEEKLY_HEADERS
            async updateDataEfficiencyProduct(){
                if(this.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                this.loading = true;
                let res = await this.updateMachineHeaderTransactions({
                    //update All
                    efficiency_product: this.efficiency_product,
                    machine_eamperformance: null,
                    //update By Line
                    res_plan_date: null,
                    working_hour: null,
                    machine_name: null
                });
                if(res.status == 'S'){
                    swal({
                        title: 'เปลี่ยนแปลงสั่งผลิต (%)',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงสั่งผลิตเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    this.loading = false;
                    //redirect
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                }
            },
            // FOR C -- PTPP_MACHINE_BIWEEKLY_HEADERS
            async updateDataEfficiencyMachine(){
                if(this.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                this.loading = true;
                let res = await this.updateMachineHeaderTransactions({
                    //update All
                    efficiency_product: null,
                    machine_eamperformance: this.efficiency_machine,
                    //update By Line
                    res_plan_date: null,
                    working_hour: null,
                    machine_name: null
                });
                if(res.status == 'S'){
                    swal({
                        title: 'เปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงประสิทธิภาพเครื่องจักรเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    this.loading = false;
                    //redirect
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                }
            },
            async  updateMachineHeaderTransactions(value) {
                let data = [];
                await axios
                    .post(`/planning/machine-biweekly/`+this.header.res_plan_h_id+`/update`, value)
                    .then(res => {
                        data = res.data;
                    })
                    .catch(err => {
                        let msg = err.response.data;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg.message,
                            type: "error",
                        });
                    })
                    .then(() => {
                        this.loading = false;
                    });

                return data;
            },
            // FOR C/E -- PTPP_MACHINE_BIWEEKLY_LINES อัพเดตทั้งสองค่าของระดับไลน์
            async updateDataEfficiencyMachineByLine(){
                this.loading = true;
                let res = await this.updateMachineTransactions();
                if(res.status == 'S'){
                    swal({
                        title: 'เปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงวันที่แพลนและประสิทธิภาพเครื่องจักรเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    this.loading = false;
                    //redirect
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }else if (res.status == 'W') {
                    this.edit_flag = false;
                    swal({
                        title: 'เปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่มีการเปลี่ยนแปลงข้อมูล </span>',
                        type: "info",
                        html: true
                    });
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                }
            },
            async  updateMachineTransactions() {
                let data = [];
                await axios
                    .post(`/planning/machine-biweekly/`+this.header.res_plan_h_id+`/update-lines`, {
                        lineMachines: this.lineMachineEdit,
                        workingHours: this.workingHourEdit,
                        note: this.note_description
                    })
                    .then(res => {
                        data = res.data;
                    })
                    .catch(err => {
                        let msg = err.response.data;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg.message,
                            type: "error",
                        });
                    })
                    .then(() => {
                        this.loading = false;
                    });

                return data;
            },
            getUnitProductType(){
                if (this.header) {
                    if (this.header.product_type == '71' || this.header.product_type == '78') {
                        this.unit = 'ล้านมวน';
                        this.per_unit = 'มวน';
                    }else{
                        this.unit = 'ล้านชิ้น';
                        this.per_unit = 'ชิ้น';
                    }
                    this.efficiencyDayFormula = 'กำลังผลิตเครื่องจักรรายวัน = ผลผลิตตามประสิทธิภาพต่อนาที('+ this.per_unit +')*[(จำนวนชั่วโมงการทำงานแต่ละวัน - 1 ชั่วโมงเซตอัพเครื่องจักร) * 60 นาที]';
                    this.efficiencyMachineFormula = 'ความเร็วเครื่องจักรต่อนาที('+ this.per_unit +') * ประสิทธิภาพเครื่องจักร(%)';
                }
            },
            getWorkingHour(){
                this.pWorkingHoliday.filter(item => {
                    this.working_holiday.push({
                        attribute1 : Number(item.attribute1),
                        lookup_code : item.lookup_code,
                        meaning : item.meaning
                    });
                });
                this.loading = false;
            },
            async checkUpdatePlanPM() {
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                swal({
                    html: true,
                    title: 'เปลี่ยนแปลงแผนซ่อมบำรุง',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดตการเปลี่ยนแปลงแผนซ่อมบำรุง ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        vm.updatePlanPM();
                    }
                    vm.loading = false;
                });
            },
            async updatePlanPM() {
                let vm = this;
                vm.loading = false;
                await axios.post(vm.url.update_plan_pm, {
                    product_type: vm.header.product_type,
                    biweekly_id: vm.header.biweekly_id
                })
                .then(res => {
                    swal({
                        title: 'เปลี่ยนแปลงแผนซ่อมบำรุง',
                        text: '<span style="font-size: 16px; text-align: left;"> อัพเดตการเปลี่ยนแปลงแผนซ่อมบำรุงภายในปักษ์ที่ '+vm.search.bi_weekly+' เรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 500);
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+data.message+'</span>',
                        type: "error",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = true;
                });
            },
            async checkUpdateMachine() {
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                vm.loading = true;
                swal({
                    html: true,
                    title: 'อัพเดตรายละเอียดเครื่องจักร',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดตรายละเอียดเครื่องจักร ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        vm.updateMachine();
                    }
                    vm.loading = false;
                });
            },
            async updateMachine() {
                let vm = this;
                let params = {
                    budget_year: vm.header.budget_year,
                    month: vm.header.period_num,
                    bi_weekly: vm.header.biweekly
                };
                await axios
                .post(vm.url.update_machine_p03, {params})
                .then(res => {
                    var valid = true;
                    if (res.data.status == 'S') {
                        vm.loading = false;
                        swal({
                            title: 'อัพเดตรายละเอียดเครื่องจักร',
                            text: '<span style="font-size: 16px; text-align: left;"> อัพเดตรายละเอียดเครื่องจักรเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        //redirect
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    }else{
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            getDateByBiWeekly() {
                var vm = this;
                let date_from = vm.header.pp_bi_weekly.start_date;
                let date_to = vm.header.pp_bi_weekly.end_date;
                let curr_date = moment().format('YYYY-MM-DD');
                // วันที่ที่ใช้ในการเช็คเงื่อนไข
                vm.checkDate.current_date = curr_date;
                vm.checkDate.start_date = moment(date_from).format('YYYY-MM-DD');
                vm.checkDate.end_date = moment(date_to).format('YYYY-MM-DD');
                //check disable process
                if(vm.checkDate.current_date > vm.checkDate.start_date && vm.checkDate.current_date > vm.checkDate.end_date){
                    vm.isControlDisable = true;
                }
                // check current biweekly
                // if(vm.checkDate.current_date >= vm.checkDate.start_date && vm.checkDate.current_date <= vm.checkDate.end_date){
                // 05102022 เปลี่ยนการทำงานให้สามารถสร้างและแก้ไขได้ล่วงหน้า และภายในปักษ์
                if((vm.checkDate.current_date >= vm.checkDate.start_date && vm.checkDate.current_date <= vm.checkDate.end_date) || (vm.checkDate.current_date < vm.checkDate.start_date && vm.checkDate.current_date < vm.checkDate.end_date)){
                    vm.isCurrBiweekly = true;
                }

                // get check PM/Machine
                if (!vm.isControlDisable && vm.isCurrBiweekly) {
                    this.checkPMConfirm();
                    this.checkMachineDetail();
                }
            },
            selMachine(machineName){
                // this.sel_machine = machineName;
            },
            editProcess(editFlag){
                var vm = this;
                vm.valid_action = editFlag;
                vm.note_description = this.header.note_description;
                vm.$emit('updateEditFlag', editFlag);
            },
            async checkPMConfirm() {
                let vm = this;
                await axios.get(vm.url.check_pm_confirm_p03)
                .then(res => {
                    vm.loading = false;
                    if (res.data.status == 'S') {
                        vm.messageCheckPMHtml = res.data.msg;
                    }else{
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    vm.loading = false;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            async checkMachineDetail() {
                let vm = this;
                await axios.get(vm.url.check_machine_detail_p03)
                .then(res => {
                    vm.loading = false;
                    if (res.data.status == 'S') {
                        vm.messageCheckMachineHtml = res.data.msg;
                    }else{
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    vm.loading = false;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
        }
    }
</script>
<style scope>
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 116px;
        /*left: 150px;*/
    }

    .th-col {
        width: 250px;
        min-width: 150px;
        max-width: 250px;
        left: 266px;
        /*left: 250px;*/
    }

    .fo-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 416px;
        /*left: 400px;*/
    }

    .fi-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
        /*left: 550px;*/
    }

    .t1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 0px;
    }

    .t2-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
    }
</style>