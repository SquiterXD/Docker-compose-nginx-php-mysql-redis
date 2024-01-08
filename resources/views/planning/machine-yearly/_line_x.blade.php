<div class="row col-lg-12 m-2 pl-1" v-if="show_flag && header">
    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
        <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
        <div>
            <el-select v-model="month" size="medium" placeholder="เดือน" filterable ref="month" @change="selMonth" :disabled="valid_action">
                <el-option
                   v-for="(month, index) in monthLists"
                    :key="index"
                    :label="month.thai_month"
                    :value="month.period_num"
                >
                </el-option>
            </el-select>
        </div>
    </div>
    <div v-if="month_detail" class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
        <label class=" tw-font-bold tw-uppercase mb-1" > ประจำวันที่ </label>
        <div style="font-size: 14px;" class="p-1">
            <date-range-detail :date-range-detail="month_detail"> </date-range-detail>
        </div>
    </div>
</div>
<div v-if="show_flag" v-loading="loading">
    <div class="hr-line-dashed"></div>
    <template v-if="loadingHtml != ''">
        <div v-html="loadingHtml"></div>
    </template>
    <template v-else-if="Object.values(lines).length">
        <div class="row m-2">
            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 mt-2 pl-2">
                <div class="tw-font-bold tw-uppercase mb-1">
                    <h2 class="tw-font-bold"> 
                        กำลังการผลิตรวมทั้งเดือน : @{{ totalProductAll.toFixed(3) }} @{{ unit }}
                    </h2>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 mt-2 text-right">
                <div class="col-12">
                    <om-sales-forecast v-if="header.product_type != 'KK'"
                        :header="header"
                        :html="html"
                    ></om-sales-forecast>
                    <button class="btn btn-warning btn-md" style="padding-left: 7px;" @click.prevent="updatePlanPM"> 
                        <i class="fa fa-calendar"></i> อัปเดตแผนซ่อมบำรุง
                    </button>
                    <machine-downtime
                        :header = "header"
                        :machine-groups = "machineGroups"
                        :machine-desc = "machineDesc"
                        :btn-trans = "btnTrans"
                        :date-format = "pDateFormat"
                        :machine-dt-lines = "machineDtLines"
                        :pp-monthly = "ppMonthly"
                        :url = "url"
                        :valid-action="valid_action"
                    ></machine-downtime>
                </div>
            </div>
        </div>
        <div class="row m-2">
            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-4 col-xs-4 mt-2">
                <label class=" tw-font-bold tw-uppercase mb-1" > ประสิทธิภาพเครื่องจักร(%) </label>
                <div class="">
                    <el-input-number style="width: 100%" name="search[efficiency_machine]" v-model="efficiency_machine" :min="0" :max="100" size="small"></el-input-number>
                </div>
            </div>
            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-top: 32px;">
                <button class="btn btn-success btn-sm text-left" @click.prevent="updateDataEfficiencyMachine">
                    ยืนยันเปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)
                </button>
            </div>
            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2">
                <label class=" tw-font-bold tw-uppercase mb-1" > สั่งผลิต(%) </label>
                <div class="">
                    <el-input-number style="width: 100%" name="search[efficiency_product]" v-model="efficiency_product" :min="0" :max="100" size="small"></el-input-number>
                </div>
            </div>
            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-4 col-xs-4" style="margin-top: 32px;">
                <button class="btn btn-success btn-sm" @click.prevent="updateDataEfficiencyProduct"> 
                    ยืนยันเปลี่ยนแปลงสั่งผลิต (%)
                </button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <h2 class="tw-font-bold"> Machine Detail </h2>
            </div>
            <div v-if="header" class="col-md-4 text-right">
                <button v-if="!edit_flag" :class="btnTrans.edit.class + ' btn-lg tw-w-25'" @click="valid_action = edit_flag = !edit_flag">
                    <i :class="btnTrans.edit.icon"></i> @{{ btnTrans.edit.text }}
                </button>
                <button v-if="edit_flag" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="updateDataEfficiencyMachineByLine()">
                    <i :class="btnTrans.save.icon"></i> @{{ btnTrans.save.text }}
                </button>
                <button v-if="edit_flag" :class="btnTrans.cancel.class + ' btn-lg tw-w-25'" @click="valid_action = edit_flag = !edit_flag">
                    <i :class="btnTrans.cancel.icon"></i> @{{ btnTrans.cancel.text }}
                </button>
            </div>
        </div>
        <div class="hr-line-dashed m-1"></div>
        <div class="row col-12">
            <div class="offset-md-7"> </div>
            <div class="col-md-2 p-1">
                <div> <i class="fa fa-square fa-2x" style="color: #ffc107"></i> &nbsp; แผนซ่อมบำรุงเครื่องจักร </div>
            </div>
            <div class="col-md-2 p-1">
                <div> <i class="fa fa-square fa-2x" style="color: #e02b1e"></i> &nbsp; ปรับลดกำลังการผลิต </div>
            </div>
            <div class="col-md-1 p-1">
                <div> <i class="fa fa-square fa-2x" style="color: #cccccc"></i> &nbsp; วันหยุด </div>
            </div>
        </div>
        <div class="hr-line-dashed m-1"></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="vertical-align: middle;">
                           <div> ขอบเขตเครื่องจักร </div> 
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                           <div> รายละเอียดเครื่องจักร </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ความเร็วเครื่องจักรต่อนาที(มวน) </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ประสิทธิภาพเครื่องจักร(%) </div>
                        </th>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> ผลผลิตตามประสิทธิภาพต่อนาที(มวน) </div>
                        </th>
                        <template v-for="(planDate, index) in resPlanDate">
                            <th class="text-center" style="vertical-align: middle;">
                                <div class="mb-2">
                                    <small style="color: #000" class="mb-2 tw-font-bold">
                                        <span class="label" style="padding-bottom: 1px; padding-top: 1px; font-size: 10px;">
                                            @{{ index+1 }}
                                        </span> <br>
                                        @{{ planDate.res_plan_date_display }} <br>
                                    </small>
                                </div>
                                <working-hour-component
                                    :p-plan-date="planDate"
                                    :p-working-hour="working_hour" 
                                    :p-working-hour-edit="workingHourEdit"
                                    :p-edit-flag="edit_flag">
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
                                <td :rowspan="lineLists.length+1" class="text-left">
                                    <div style="width: 100px;"> @{{ covertName(machineGroup) }} </div>
                                </td>
                                <tr v-for="(line, indexLine) in lineLists">
                                    <td class="text-left" :style="sel_machine == line.machine_description? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selMachine(line.machine_description)">
                                        <div style="width: 150px;"> @{{ line.machine_description }} </div>
                                    </td>
                                    <td class="text-right" :style="sel_machine == line.machine_description? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selMachine(line.machine_description)">
                                       <div style="width: 80px;"> @{{ decimal(line.machine_speed) }} </div>
                                    </td>
                                    <td class="text-center" :style="sel_machine == line.machine_description? 'background-color: #9AD9DB;' : ''" @click="selMachine(line.machine_description)">
                                        <eff-machine
                                            :edit-flag = "edit_flag"
                                            :line = "line"
                                            :line-machine-edit = "lineMachineEdit"
                                        ></eff-machine>
                                    </td>
                                    <td class="text-right" :style="sel_machine == line.machine_description? 'background-color: #9AD9DB; vertical-align: middle;' : 'vertical-align: middle;'" @click="selMachine(line.machine_description)">
                                        <div style="width: 80px;"> @{{ decimal(line.efficiency_machine_per_min) }} </div>
                                    </td>
                                    <template v-for="(plan, index) in resPlanDate">
                                        <template v-for="(efficiencyProduct, index) in efficiencyProducts">
                                            <template v-if="machineDowntimes[plan.res_plan_date_display][line.machine_description] == 'Y' && plan.res_plan_date_display == index">
                                                <td class="text-right" style="background-color: #e02b1e;" :title="covertName(machineGroup)" @click="selMachine(line.machine_description)">
                                                    <div style="width: 70px;"> 0.000 </div>
                                                </td>
                                            </template>
                                            <template v-else-if="machineMaintenances[plan.res_plan_date_display][line.machine_description] == 'Y' && plan.res_plan_date_display == index">
                                                <td class="text-right" style="background-color: #ffc107;" :title="covertName(machineGroup)" @click="selMachine(line.machine_description)">
                                                    <div style="width: 70px;"> 0.000 </div>
                                                </td>
                                            </template>
                                            <template v-else-if="plan.holiday_flag == 'Y' && plan.res_plan_date_display == index">
                                                <td class="text-right" style="background-color: #cccccc;" :title="covertName(machineGroup)" @click="selMachine(line.machine_description)">
                                                    <div style="width: 70px;"> 
                                                        @{{ efficiencyProduct[line.machine_description].toFixed(3) }}
                                                    </div>
                                                </td>
                                            </template>
                                            <template v-else-if="plan.holiday_flag != 'Y'
                                                && plan.res_plan_date_display == index
                                                && machineDowntimes[plan.res_plan_date_display][line.machine_description] != 'Y'
                                                && machineMaintenances[plan.res_plan_date_display][line.machine_description] != 'Y'">
                                                <td class="text-right" :title="covertName(machineGroup)" :style="sel_machine == line.machine_description? 'background-color: #9AD9DB;' : ''" @click="selMachine(line.machine_description)">
                                                    <div style="width: 70px;"> 
                                                        @{{ efficiencyProduct[line.machine_description].toFixed(3) }}
                                                    </div>
                                                </td>
                                            </template>
                                        </template>
                                    </template>
                                    <td :style="sel_machine == line.machine_description? 'background-color: #9AD9DB;' : ''" @click="selMachine(line.machine_description)"> </td>
                                </tr>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="4" style="vertical-align: middle;"> <strong> รวม </strong> </td>
                                <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                    <template v-for="res in summary">
                                        <template v-if="machineGroup == res.machine_group">
                                            <span class="tw-font-bold"> @{{ decimal(res.efficiency_machine_per_min) }} </span>
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
                            <td class="text-right" colspan="5" style="vertical-align: middle;"> <strong> รวมกำลังผลิตแต่ละวัน </strong> </td>
                            <template v-for="(plan, index) in resPlanDate">
                                <template v-for="res in summaryProduct">
                                    <template v-if="plan.working_hour == 0 && res.plan_date == plan.res_plan_date_display">
                                        <td class="tw-font-bold text-right" style="vertical-align: middle; background-color: #70d200;">
                                            <div style="width: 70px;"> 0.000 </div>
                                        </td>
                                    </template>
                                    <template v-if="plan.working_hour != 0 && res.plan_date == plan.res_plan_date_display">
                                        <td class="tw-font-bold text-right" style="vertical-align: middle; background-color: #70d200;">
                                            <div style="width: 70px; "> 
                                                @{{ res.total.toFixed(3) }}
                                            </div>
                                        </td>
                                    </template>
                                </template>
                            </template>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 70px;"> @{{ totalProductAll.toFixed(3) }} </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>
    <template v-else>
        <div class="text-center">
            <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
        </div>
    </template>
</div>