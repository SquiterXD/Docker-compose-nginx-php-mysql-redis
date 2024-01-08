<template>

    <div>

        <div class="table-responsive" style="max-height: 720px;">

            <table class="table table-bordered table-sticky mb-0" style="min-width: 4300px;">
                <thead>
                    <tr>
                        <th class="text-center freeze-col" style="min-width: 200px;">
                            <div class="freeze-col-content" style="padding: 0px;"> &nbsp; </div> 
                        </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> จันทร์ </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> อังคาร </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> พุธ </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> พฤหัส </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> ศุกร์ </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> เสาร์ </th>
                        <th class="text-center tw-text-lg" style="min-width: 700px;"> อาทิตย์ </th>
                    </tr>
                    <tr>
                        <th class="text-center freeze-col" style="top: 40px;"> 
                            <div class="freeze-col-content" style="padding: 0px;"> &nbsp; </div> 
                        </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Mon') }} </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Tue') }} </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Wed') }} </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Thu') }} </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Fri') }} </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Sat') }} </th>
                        <th class="text-center tw-text-lg" style="top: 40px;"> {{ getDateByDay(weekDates, 'Sun') }} </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(machineItem, index) in machineLineItems">

                        <tr class="tw-text-xs" :key="`${index}`">
                            
                            <td class="freeze-col tw-text-xxl tw-font-bold" style="min-width: 200px; vertical-align: top !important;"> 

                                <div class="freeze-col-content" v-if="planHeaderData.status == '1'">

                                    <div class="pull-right tw-w-full tw-mb-10">
                                        <button type="button" class="btn btn-sm btn-danger" @click="onDeleteMachineLine(machineItem.machine_name)">
                                            <i class="fa fa-trash"></i> ลบเครื่อง 
                                        </button>
                                    </div>
                                    
                                    <pm-el-select :name="`machine_name_${index}`" 
                                        :id="`input_machine_name_${index}`" 
                                        :select-options="machineItems"
                                        option-key="machine_name"
                                        option-value="machine_name" 
                                        option-label="machine_name" 
                                        :value="machineItem.machine_name"
                                        :filterable="true"
                                        @onSelected="onMachineNameChanged($event, machineItem)"
                                    />
                                    <a class="btn btn-block btn-sm btn-white mt-2" v-if="machineItem.print_pdf"
                                        :href="machineItem.print_pdf" target="_blank">
                                        <i class="fa fa-print tw-mr-1"></i> รายงานประจำเครื่อง
                                    </a>

                                </div>
                                <div class="freeze-col-content" v-else>
                                    {{ machineItem.machine_name }}
                                    <a class="btn btn-block btn-sm btn-white mt-2" v-if="machineItem.print_pdf"
                                        :href="machineItem.print_pdf" target="_blank">
                                        <i class="fa fa-print tw-mr-1"></i> รายงานประจำเครื่อง
                                    </a>
                                </div>

                            </td>
                            
                            <!-- MON -->
                            <template v-if="isDayEnabled(weekDates, 'Mon')">

                                <td style="min-width: 700px; vertical-align: top !important;">

                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_mon_${index}`" 
                                                    :id="`input_plan_time_mon_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.mon.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.mon)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.mon.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineMonItem, monIndex) in machineItem.mon.items">
                                        <tr :key="`mon_${index}_${monIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_mon_${index}_${monIndex}`" 
                                                        :id="`input_request_number_mon_${index}_${monIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineMonItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineMonItem, 'mon')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineMonItem.request_number) }} </div> -->
                                                <div v-else> {{ machineMonItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineMonItem.colors ? machineMonItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineMonItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineMonItem.product_colors ? machineMonItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineMonItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_mon_${index}_${monIndex}`"
                                                        :id="`input_qty_mon_${index}_${monIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineMonItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineMonItem, 'mon')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineMonItem.qty ? Number(machineMonItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineMonItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineMonItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.mon.items, machineMonItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`mon_${index}_${monIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineMonItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`mon_${index}_${monIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${monIndex}`" :id="`input_starttime_${index}_${monIndex}`" :value="machineMonItem.starttime" @close="onMachineItemStartTimeClosed($event, machineMonItem)" @change="onMachineItemStartTimeChanged($event, machineMonItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineMonItem.starttime ? machineMonItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${monIndex}`" :id="`input_endtime_${index}_${monIndex}`" :value="machineMonItem.endtime" @close="onMachineItemEndTimeClosed($event, machineMonItem)" @change="onMachineItemEndTimeChanged($event, machineMonItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineMonItem.endtime ? machineMonItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`mon_${index}_${monIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_mon_${index}_${monIndex}`"
                                                            :id="`input_remark_mon_${index}_${monIndex}`"
                                                            v-model="machineMonItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineMonItem, 'mon')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineMonItem.remark ? machineMonItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'mon',machineItem.mon.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>
                                    
                                </td>

                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                            <!-- TUE -->
                            <template v-if="isDayEnabled(weekDates, 'Tue')">
                                
                                <td style="min-width: 700px; vertical-align: top !important;">
                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_tue_${index}`" 
                                                    :id="`input_plan_time_tue_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.tue.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.tue)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.tue.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineTueItem, tueIndex) in machineItem.tue.items">
                                        <tr :key="`tue_${index}_${tueIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_tue_${index}_${tueIndex}`" 
                                                        :id="`input_request_number_tue_${index}_${tueIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineTueItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineTueItem, 'tue')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineTueItem.request_number) }} </div> -->
                                                <div v-else> {{ machineTueItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineTueItem.colors ? machineTueItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineTueItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineTueItem.product_colors ? machineTueItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineTueItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_tue_${index}_${tueIndex}`"
                                                        :id="`input_qty_tue_${index}_${tueIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineTueItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineTueItem, 'tue')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineTueItem.qty ? Number(machineTueItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineTueItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineTueItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.tue.items, machineTueItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`tue_${index}_${tueIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineTueItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`tue_${index}_${tueIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${tueIndex}`" :id="`input_starttime_${index}_${tueIndex}`" :value="machineTueItem.starttime" @close="onMachineItemStartTimeClosed($event, machineTueItem)" @change="onMachineItemStartTimeChanged($event, machineTueItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineTueItem.starttime ? machineTueItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${tueIndex}`" :id="`input_endtime_${index}_${tueIndex}`" :value="machineTueItem.endtime" @close="onMachineItemEndTimeClosed($event, machineTueItem)" @change="onMachineItemEndTimeChanged($event, machineTueItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineTueItem.endtime ? machineTueItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`tue_${index}_${tueIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_tue_${index}_${tueIndex}`"
                                                            :id="`input_remark_tue_${index}_${tueIndex}`"
                                                            v-model="machineTueItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineTueItem, 'tue')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineTueItem.remark ? machineTueItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'tue',machineItem.tue.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>

                                </td>

                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                            <!-- WED -->
                            <template v-if="isDayEnabled(weekDates, 'Wed')">

                                <td style="min-width: 700px; vertical-align: top !important;">

                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_wed_${index}`" 
                                                    :id="`input_plan_time_wed_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.wed.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.wed)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.wed.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineWedItem, wedIndex) in machineItem.wed.items">
                                        <tr :key="`wed_${index}_${wedIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_wed_${index}_${wedIndex}`" 
                                                        :id="`input_request_number_wed_${index}_${wedIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineWedItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineWedItem, 'wed')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineWedItem.request_number) }} </div> -->
                                                <div v-else> {{ machineWedItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineWedItem.colors ? machineWedItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineWedItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineWedItem.product_colors ? machineWedItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineWedItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_wed_${index}_${wedIndex}`"
                                                        :id="`input_qty_wed_${index}_${wedIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineWedItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineWedItem, 'wed')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineWedItem.qty ? Number(machineWedItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineWedItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineWedItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.wed.items, machineWedItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`wed_${index}_${wedIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineWedItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`wed_${index}_${wedIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${wedIndex}`" :id="`input_starttime_${index}_${wedIndex}`" :value="machineWedItem.starttime" @close="onMachineItemStartTimeClosed($event, machineWedItem)" @change="onMachineItemStartTimeChanged($event, machineWedItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineWedItem.starttime ? machineWedItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${wedIndex}`" :id="`input_endtime_${index}_${wedIndex}`" :value="machineWedItem.endtime" @close="onMachineItemEndTimeClosed($event, machineWedItem)" @change="onMachineItemEndTimeChanged($event, machineWedItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineWedItem.endtime ? machineWedItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`wed_${index}_${wedIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_wed_${index}_${wedIndex}`"
                                                            :id="`input_remark_wed_${index}_${wedIndex}`"
                                                            v-model="machineWedItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineWedItem, 'wed')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineWedItem.remark ? machineWedItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'wed',machineItem.wed.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>

                                </td>

                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                            <!-- THU -->
                            <template v-if="isDayEnabled(weekDates, 'Thu')">

                                <td style="min-width: 700px; vertical-align: top !important;">

                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_thu_${index}`" 
                                                    :id="`input_plan_time_thu_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.thu.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.thu)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.thu.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineThuItem, thuIndex) in machineItem.thu.items">
                                        <tr :key="`thu_${index}_${thuIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_thu_${index}_${thuIndex}`" 
                                                        :id="`input_request_number_thu_${index}_${thuIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineThuItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineThuItem, 'thu')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineThuItem.request_number) }} </div> -->
                                                <div v-else> {{ machineThuItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineThuItem.colors ? machineThuItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineThuItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineThuItem.product_colors ? machineThuItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineThuItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_thu_${index}_${thuIndex}`"
                                                        :id="`input_qty_thu_${index}_${thuIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineThuItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineThuItem, 'thu')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineThuItem.qty ? Number(machineThuItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineThuItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineThuItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.thu.items, machineThuItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`thu_${index}_${thuIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineThuItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`thu_${index}_${thuIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${thuIndex}`" :id="`input_starttime_${index}_${thuIndex}`" :value="machineThuItem.starttime" @close="onMachineItemStartTimeClosed($event, machineThuItem)" @change="onMachineItemStartTimeChanged($event, machineThuItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineThuItem.starttime ? machineThuItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${thuIndex}`" :id="`input_endtime_${index}_${thuIndex}`" :value="machineThuItem.endtime" @close="onMachineItemEndTimeClosed($event, machineThuItem)" @change="onMachineItemEndTimeChanged($event, machineThuItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineThuItem.endtime ? machineThuItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`thu_${index}_${thuIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_thu_${index}_${thuIndex}`"
                                                            :id="`input_remark_thu_${index}_${thuIndex}`"
                                                            v-model="machineThuItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineThuItem, 'thu')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineThuItem.remark ? machineThuItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'thu',machineItem.thu.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>

                                </td>

                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                            <!-- FRI -->
                            <template v-if="isDayEnabled(weekDates, 'Fri')">

                                <td style="min-width: 700px; vertical-align: top !important;">

                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_fri_${index}`" 
                                                    :id="`input_plan_time_fri_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.fri.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.fri)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.fri.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineFriItem, friIndex) in machineItem.fri.items">
                                        <tr :key="`fri_${index}_${friIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_fri_${index}_${friIndex}`" 
                                                        :id="`input_request_number_fri_${index}_${friIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineFriItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineFriItem, 'fri')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineFriItem.request_number) }} </div> -->
                                                <div v-else> {{ machineFriItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineFriItem.colors ? machineFriItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineFriItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineFriItem.product_colors ? machineFriItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineFriItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_fri_${index}_${friIndex}`"
                                                        :id="`input_qty_fri_${index}_${friIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineFriItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineFriItem, 'fri')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineFriItem.qty ? Number(machineFriItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineFriItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineFriItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.fri.items, machineFriItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`fri_${index}_${friIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineFriItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`fri_${index}_${friIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${friIndex}`" :id="`input_starttime_${index}_${friIndex}`" :value="machineFriItem.starttime" @close="onMachineItemStartTimeClosed($event, machineFriItem)" @change="onMachineItemStartTimeChanged($event, machineFriItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineFriItem.starttime ? machineFriItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${friIndex}`" :id="`input_endtime_${index}_${friIndex}`" :value="machineFriItem.endtime" @close="onMachineItemEndTimeClosed($event, machineFriItem)" @change="onMachineItemEndTimeChanged($event, machineFriItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineFriItem.endtime ? machineFriItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`fri_${index}_${friIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_fri_${index}_${friIndex}`"
                                                            :id="`input_remark_fri_${index}_${friIndex}`"
                                                            v-model="machineFriItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineFriItem, 'fri')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineFriItem.remark ? machineFriItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'fri',machineItem.fri.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>

                                </td>
                                
                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                            <!-- SAT -->
                            <template v-if="isDayEnabled(weekDates, 'Sat')">

                                <td style="min-width: 700px; vertical-align: top !important;">

                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_sat_${index}`" 
                                                    :id="`input_plan_time_sat_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.sat.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.sat)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.sat.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineSatItem, satIndex) in machineItem.sat.items">
                                        <tr :key="`sat_${index}_${satIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_sat_${index}_${satIndex}`" 
                                                        :id="`input_request_number_sat_${index}_${satIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineSatItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineSatItem, 'sat')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineSatItem.request_number) }} </div> -->
                                                <div v-else> {{ machineSatItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineSatItem.colors ? machineSatItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineSatItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineSatItem.product_colors ? machineSatItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineSatItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_sat_${index}_${satIndex}`"
                                                        :id="`input_qty_sat_${index}_${satIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineSatItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineSatItem, 'sat')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineSatItem.qty ? Number(machineSatItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineSatItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineSatItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.sat.items, machineSatItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`sat_${index}_${satIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineSatItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`sat_${index}_${satIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${satIndex}`" :id="`input_starttime_${index}_${satIndex}`" :value="machineSatItem.starttime" @close="onMachineItemStartTimeClosed($event, machineSatItem)" @change="onMachineItemStartTimeChanged($event, machineSatItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineSatItem.starttime ? machineSatItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${satIndex}`" :id="`input_endtime_${index}_${satIndex}`" :value="machineSatItem.endtime" @close="onMachineItemEndTimeClosed($event, machineSatItem)" @change="onMachineItemEndTimeChanged($event, machineSatItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineSatItem.endtime ? machineSatItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`sat_${index}_${satIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_sat_${index}_${satIndex}`"
                                                            :id="`input_remark_sat_${index}_${satIndex}`"
                                                            v-model="machineSatItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineSatItem, 'sat')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineSatItem.remark ? machineSatItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'sat',machineItem.sat.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>

                                </td>

                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                            <!-- SUN -->
                            <template v-if="isDayEnabled(weekDates, 'Sun')">

                                <td style="min-width: 700px; vertical-align: top !important;">

                                    <tr>
                                        <td class="text-center" colspan="7"> 
                                            <div v-if="planHeaderData.status == '1'">
                                                <pm-el-select :name="`plan_time_sun_${index}`" 
                                                    :id="`input_plan_time_sun_${index}`" 
                                                    :select-options="machineTimes"
                                                    option-key="lookup_code"
                                                    option-value="lookup_code" 
                                                    option-label="description" 
                                                    :value="machineItem.sun.plan_time"
                                                    :filterable="true"
                                                    @onSelected="onMachinePlanTimeChanged($event, machineItem.sun)"
                                                />
                                            </div>
                                            <div v-else> {{ getMachinePlanTimeDesc(machineTimes, machineItem.sun.plan_time) }} </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="min-width: 280px;"> Item </td>
                                        <td class="text-center" style="min-width: 50px;"> Brand </td>
                                        <td class="text-center" style="min-width: 50px;"> Product </td>
                                        <td class="text-center" style="min-width: 100px;"> Quantity </td>
                                        <td class="text-center" style="min-width: 60px;"> UOM </td>
                                        <td class="text-center" style="min-width: 100px;"> Job Number</td>
                                        <td v-if="planHeaderData.status == '1'" class="text-center" style="min-width: 60px;"> Delete </td>
                                    </tr>

                                    <template v-for="(machineSunItem, sunIndex) in machineItem.sun.items">
                                        <tr :key="`sun_${index}_${sunIndex}_1`">
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <pm-el-select :name="`request_number_sun_${index}_${sunIndex}`" 
                                                        :id="`input_request_number_sun_${index}_${sunIndex}`" 
                                                        :select-options="remainingItems"
                                                        option-key="request_number"
                                                        option-value="request_number" 
                                                        option-label="full_item_desc" 
                                                        :value="machineSunItem.request_number"
                                                        :filterable="true"
                                                        @onSelected="onMachineItemChanged($event, machineItem, machineSunItem, 'sun')"
                                                    />
                                                </div>
                                                <!-- <div v-else> {{ getItemFullDesc(remainingItems, machineSunItem.request_number) }} </div> -->
                                                <div v-else> {{ machineSunItem.inv_item_number  }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineSunItem.colors ? machineSunItem.colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineSunItem.brand }} </div>
                                            </td>
                                            <td class="text-center" v-bind:style="{ backgroundColor: machineSunItem.product_colors ? machineSunItem.product_colors : '#FFF'  }">
                                                <div class="tw-font-bold"> {{ machineSunItem.product }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="planHeaderData.status == '1'">
                                                    <vue-numeric 
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :name="`qty_sun_${index}_${sunIndex}`"
                                                        :id="`input_qty_sun_${index}_${sunIndex}`"
                                                        class="form-control input-sm text-right"
                                                        v-model="machineSunItem.qty"
                                                        @blur="onMachineItemQtyChanged(machineItem, machineSunItem, 'sun')"
                                                        :disabled="isLoading"
                                                        ></vue-numeric>
                                                </div>
                                                <div v-else> {{ machineSunItem.qty ? Number(machineSunItem.qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 4}) : "" }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ getUomCodeDescription(uomCodes, machineSunItem.uom) }} </div>
                                            </td>
                                            <td class="text-center">
                                                <div> {{ machineSunItem.request_number }} </div>
                                            </td>
                                            <td v-if="planHeaderData.status == '1'" class="text-center">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    @click="onDeleteLine(machineItem.sun.items, machineSunItem)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr :key="`sun_${index}_${sunIndex}_2`">
                                            <td class="text-left" colspan="7"> 
                                                <div> {{ machineSunItem.inv_item_desc }} </div> 
                                            </td>
                                        </tr>
                                        <tr :key="`sun_${index}_${sunIndex}_3`">
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="2"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาเริ่ม : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`starttime_${index}_${sunIndex}`" :id="`input_starttime_${index}_${sunIndex}`" :value="machineSunItem.starttime" @close="onMachineItemStartTimeClosed($event, machineSunItem)" @change="onMachineItemStartTimeChanged($event, machineSunItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาเริ่ม : {{ machineSunItem.starttime ? machineSunItem.starttime : "-" }} </div> 
                                                </div>
                                            </td>
                                            <td class="text-left tw-p-2" style="padding-top: 5px; padding-bottom: 5px;" colspan="5"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> เวลาสิ้นสุด : </span>
                                                        </div>
                                                        <div class="tw-pt-1">
                                                            <pm-timepicker :name="`endtime_${index}_${sunIndex}`" :id="`input_endtime_${index}_${sunIndex}`" :value="machineSunItem.endtime" @close="onMachineItemEndTimeClosed($event, machineSunItem)" @change="onMachineItemEndTimeChanged($event, machineSunItem)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> เวลาสิ้นสุด : {{ machineSunItem.endtime ? machineSunItem.endtime : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr :key="`sun_${index}_${sunIndex}_4`">
                                            <td class="text-left" colspan="7"> 
                                                <div v-if="planHeaderData.status == '1'">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon input-sm tw-border-white" style="min-width: 90px;"> หมายเหตุ : </span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-sm"
                                                            :name="`remark_sun_${index}_${sunIndex}`"
                                                            :id="`input_remark_sun_${index}_${sunIndex}`"
                                                            v-model="machineSunItem.remark"
                                                            :disabled="isLoading"
                                                            @blur="onMachineItemRemarkChanged(machineItem, machineSunItem, 'sun')"
                                                        />
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div> หมายเหตุ : {{ machineSunItem.remark ? machineSunItem.remark : "-" }} </div> 
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-if="planHeaderData.status == '1'">
                                        <td class="text-left" colspan="7"> 
                                            <button class="btn btn-inline-block btn-xs btn-success tw-w-16"
                                                @click="onAddNewLine(index,'sun',machineItem.sun.items)"
                                            > 
                                                <i class="fa fa-plus tw-mr-1"></i> เพิ่ม
                                            </button>
                                        </td>
                                    </tr>

                                </td>

                            </template>
                            <template v-else>
                                <td class="text-center" style="min-width: 700px; vertical-align: top !important;"> <div>  </div> </td>
                            </template>

                        </tr>
                    </template>
                </tbody>

            </table>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {

    components: { 
        Loading,
        VueNumeric
    },
    
    props: ["planHeader", "planLines", "weeklys", "uomCodes", "machines", "availableMachines", "machinePowers", "machineTimes", "dailyRemainingItems"],

    watch: {

        planHeader : function (dataPlanHeader) {
            this.planHeaderData = dataPlanHeader;
            this.weekDates = this.getWeekDates(this.weeklys, this.planHeaderData.week_number);
        },

        machines: function (items) {
            this.machineItems = items;
        },

        availableMachines: function (items) {
            this.availableMachineItems = items;
        },

        dailyRemainingItems : function (items) {
            this.remainingItems = items;
        },

        planLines : function (dataPlanLines) {
            this.machineLineItems = this.mapMachineLineItems(this.weeklys, this.machineItems, this.planHeaderData, this.dailyRemainingItems, dataPlanLines)
        },

    },

    data() {

        return {

            planHeaderData: this.planHeader,
            remainingItems: this.dailyRemainingItems ? this.dailyRemainingItems : [],
            machineItems: this.machines,
            availableMachineItems: this.availableMachines,
            machineLineItems: this.mapMachineLineItems(this.weeklys, this.machines, this.planHeader, this.dailyRemainingItems, this.planLines),
            weekDates: this.getWeekDates(this.weeklys, this.planHeader.week_number),
            isLoading: false

        }

    },

    mounted() {

    },

    computed: {

    },
    methods: {

        mapMachineLineItems(weeklys, machineItems, planHeader, remainingItems, planLines) {

            const mappedMachineItems = machineItems.filter(mItem => {
                mItem.print_pdf = false;
                return planHeader.print_type == mItem.print_type && (planLines.find(lineItem => {
                    mItem.print_pdf = '/pm/plans/daily?print_pdf=1&daily_plan_line_id=' + lineItem.daily_plan_line_id;
                    return mItem.machine_name == lineItem.machine_name;
                }));
            }).map(item => {
                const foundMachineLine = planLines.find(plItem => plItem.machine_name == item.machine_name);
                return {
                    ...item,
                    "created_at": foundMachineLine ? foundMachineLine.created_at : null,
                    "mon": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Mon"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Mon"),
                    },
                    "tue": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Tue"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Tue"),
                    },
                    "wed": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Wed"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Wed"),
                    },
                    "thu": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Thu"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Thu"),
                    },
                    "fri": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Fri"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Fri"),
                    },
                    "sat": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Sat"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Sat"),
                    },
                    "sun": {
                        "plan_time": this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Sun"),
                        "items": this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Sun"),
                    },
                }
            }).sort((a, b) => {
                return moment(a.created_at) - moment(b.created_at);
            });

            return mappedMachineItems;

        },

        getWeekDates(weeklys, weekly) {

            const foundWeekly = weeklys.find(item => {
                return item.weekly_value == weekly;
            });
            const weekDates = foundWeekly ? foundWeekly.dates : [];

            return weekDates;

        },

        isDayEnabled(weekDates, day) {

            const foundItem = weekDates.find(item => {
                return day == item.day;
            });
            return !!foundItem;

        },

        getDateByDay(weekDates, day) {

            const foundItem = weekDates.find(item => {
                return day == item.day;
            });
            return foundItem ? this.formatDateTh(foundItem.date) : "-";

        },

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        getMachinePlanTimeByDay(weeklys, planLines, weekly, machineName, day) {

            let planTime = this.machineTimes.length > 0 ? this.machineTimes[0].lookup_code : "";

            const weekDates = this.getWeekDates(weeklys, weekly);

            const foundDayInfo = weekDates.find(item => {
                return day == item.day;
            });
            const foundDate = foundDayInfo ? foundDayInfo.date : null;

            if(foundDate) {
                const foundItem = planLines.find(item => {
                    return item.machine_name == machineName && moment(item.plan_date).format('YYYY-MM-DD') == moment(foundDate).format('YYYY-MM-DD');
                });
                planTime = foundItem.plan_time;
            }

            return planTime;

        },

        getMachinePlanTimeDesc(machineTimes, planTime) {
            
            let result = null;
            if(planTime) {
                const foundItem = machineTimes.find(item => {
                    return item.lookup_code == planTime;
                });
                result = foundItem ? foundItem.description : null
            }
            return result;

        },

        getMachineLineItemCreatedAt(planLines, machineName) {
            const machineLineCreatedAt = planLines.find(item => {
                return item.machine_name == machineName;
            });
            return machineLineCreatedAt;
        },

        getMachineLineItemsByDay(weeklys, remainingItems, planLines, weekly, machineName, day) {

            let machineLineByDayItems = [];

            const weekDates = this.getWeekDates(weeklys, weekly);

            const foundDayInfo = weekDates.find(item => {
                return day == item.day;
            });
            const foundDate = foundDayInfo ? foundDayInfo.date : null;

            if(foundDate) {
                const filteredItems = planLines.filter(item => {
                    return item.machine_name == machineName && moment(item.plan_date).format('YYYY-MM-DD') == moment(foundDate).format('YYYY-MM-DD');
                });
                machineLineByDayItems = filteredItems.map(item => {
                    const itemInfo = this.getItemInfo(remainingItems, item.request_number);
                    return {
                        ...item,
                        uom: itemInfo ? itemInfo.uom : null,
                        product_colors: item.attribute12, // product_colors == attribute12
                        qty: item.qty ? item.qty : 0,
                        starttime: item.mes_starttime ? moment(item.mes_starttime).format('HH:mm') : "",
                        endtime: item.mes_endtime ? moment(item.mes_endtime).format('HH:mm') : "",
                        remark: item.remark ? item.remark : '',
                    }
                // }).sort((a, b) => {
                //     return moment(a.created_at) - moment(b.created_at);
                });
            }
            return machineLineByDayItems;

        },

        onMachinePlanTimeChanged(planTime, machineData) {

            let defaultStarttime = "";
            let defaultEndtime = "";

            machineData.plan_time = planTime;
            if(planTime) {
                const foundItem = this.machineTimes.find(item => {
                    return item.lookup_code == planTime;
                });
                if(foundItem) {
                    defaultStarttime = foundItem.attribute3 ? foundItem.attribute3.replace(".", ":") : "";
                    defaultEndtime = foundItem.attribute4 ? foundItem.attribute4.replace(".", ":") : "";
                }
            }
            const machineDataItems = machineData.items.map(item => {
                return {
                    ...item,
                    qty: 0,
                    starttime: defaultStarttime ? defaultStarttime : item.starttime,
                    endtime: defaultEndtime ? defaultEndtime : item.endtime,
                    remark: item.remark,
                    plan_time: planTime
                }
            });
            machineData.items = machineDataItems;

            // SAVE PLAN_TIME
            machineDataItems.map(machineLineItem => {
                this.onSaveDailyPlanLine(machineLineItem);
            });

        },

        async onMachineNameChanged(machineName, machineItem) {

            // VALIDATE BEFORE CHANGED

            const previousMachineNName = machineItem.machine_name;
            const isAvailable = this.availableMachineItems.find(availableMachine => {
                return machineName == availableMachine.machine_name;
            });
            
            machineItem.machine_name = machineName;

            if(!isAvailable) {
                swal("เกิดข้อผิดพลาด", `ไม่สามารถใช้ เครื่องจักร ซ้ำกันได้ ( ชื่อเครื่อง : ${machineName})`, "error");
                this.$nextTick(() => {
                    machineItem.machine_name = previousMachineNName == null ? "" : (previousMachineNName == "" ? null : previousMachineNName);
                    this.emitMachineLineItemsChanged();
                });
            } else {

                const newMachine = this.machineItems.find(machine => {
                    return machineName == machine.machine_name;
                });

                if(newMachine) {

                    // SAVE MON MACHINE ITEMS
                    const machineMonItems = machineItem.mon.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.mon.items = machineMonItems;

                    await Promise.all(machineMonItems.map(async (machineMonLineItem) => {
                        return await this.onSaveDailyPlanLine(machineMonLineItem);
                    }));

                    // SAVE TUE MACHINE ITEMS
                    const machineTueItems = machineItem.tue.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.tue.items = machineTueItems;

                    await Promise.all(machineTueItems.map(async (machineTueLineItem) => {
                        return await this.onSaveDailyPlanLine(machineTueLineItem);
                    }));

                    // SAVE WED MACHINE ITEMS
                    const machineWedItems = machineItem.wed.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.wed.items = machineWedItems;

                    await Promise.all(machineWedItems.map(async (machineWedLineItem) => {
                        return await this.onSaveDailyPlanLine(machineWedLineItem);
                    }));

                    // SAVE THU MACHINE ITEMS
                    const machineThuItems = machineItem.thu.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.thu.items = machineThuItems;

                    await Promise.all(machineThuItems.map(async (machineThuLineItem) => {
                        return await this.onSaveDailyPlanLine(machineThuLineItem);
                    }));

                    // SAVE FRI MACHINE ITEMS
                    const machineFriItems = machineItem.fri.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.fri.items = machineFriItems;

                    await Promise.all(machineFriItems.map(async (machineFriLineItem) => {
                        return await this.onSaveDailyPlanLine(machineFriLineItem);
                    }));

                    // SAVE SAT MACHINE ITEMS
                    const machineSatItems = machineItem.sat.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.sat.items = machineSatItems;

                    await Promise.all(machineSatItems.map(async (machineSatLineItem) => {
                        return await this.onSaveDailyPlanLine(machineSatLineItem);
                    }));

                    // SAVE SUNN MACHINE ITEMS
                    const machineSunItems = machineItem.sun.items.map(item => {
                        return {
                            ...item,
                            qty: 0,
                            starttime: item.starttime,
                            endtime: item.endtime,
                            remark: item.remark,
                            machine_name: newMachine.machine_name,
                            machine_group: newMachine.machine_group,
                        }
                    });
                    machineItem.sun.items = machineSunItems;

                    await Promise.all(machineSunItems.map(async (machineSunLineItem) => {
                        return await this.onSaveDailyPlanLine(machineSunLineItem);
                    }));

                }

                this.emitMachineLineItemsChanged();

            }

        },

        onMachineItemChanged(requestNumber, machineItem, machineLineItem, day) {

            const itemInfo = this.getItemInfo(this.remainingItems, requestNumber);
            if(itemInfo) {

                const previousInvItemId = machineLineItem.inventory_item_id;
                const previousRequestNumber = machineLineItem.request_number;
                machineLineItem.inventory_item_id = itemInfo.inventory_item_id;
                machineLineItem.request_number = requestNumber;

                if(this.validateMachineItem(machineItem, machineLineItem, day)) {
                    // VALIDATE => PASSED
                    machineLineItem.inv_item_number = itemInfo.segment1;
                    machineLineItem.inv_item_desc = itemInfo.description;
                    machineLineItem.colors = itemInfo.colors;
                    machineLineItem.product_colors = itemInfo.product_colors;
                    machineLineItem.brand = itemInfo.brand;
                    machineLineItem.product = itemInfo.product;
                    machineLineItem.source_plan_line_id = itemInfo.plan_line_id;
                    machineLineItem.uom = itemInfo.uom;
                    this.onSaveDailyPlanLine(machineLineItem);
                } else {
                    // VALIDATE => FAILED
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึก ใช้ job ซ้ำกันได้ ในเครื่องเดียวกัน ( job number : ${machineLineItem.request_number})`, "error");
                    this.$nextTick(() => {
                        machineLineItem.inventory_item_id = previousInvItemId == null ? "" : (previousInvItemId == "" ? null : previousInvItemId);
                        machineLineItem.request_number = previousRequestNumber;
                    });
                }

            }
            
        },

        validateMachineItem(machineItem, machineLineItem, day) {

            let valid = true;

            const machineLineItems = machineItem[day].items;
            
            let duplicates = []
            const requestNumbers = machineLineItems.map(item => item.request_number).sort()

            for (let i = 0; i < requestNumbers.length; i++) {
                if(requestNumbers[i]) {
                    if (requestNumbers[i + 1] === requestNumbers[i]) {
                        duplicates.push(requestNumbers[i])
                    }
                }
            }

            if(duplicates.length > 0) {
                valid = false;
            }

            return valid;

        },

        onMachineItemQtyChanged(machineItem, machineLineItem, day) {

            if(this.validateMachineItemQty(machineItem, machineLineItem, day)) {
                // VALIDATE => PASSED
                this.onSaveDailyPlanLine(machineLineItem);
            } else {
                // VALIDATE => FAILED
                machineLineItem.qty = 0;
            }

        },

        validateMachineItemQty(machineItem, machineLineItem, day) {

            let valid = true;

            const machineName = machineItem.machine_name;
            const machineProductTime = machineItem[day].plan_time;
            const machinePower = this.machinePowers.find(item => {
                return item.product_time == machineProductTime && item.machine_name == machineName;
            });
            const machineLineItems = machineItem[day].items;
            const machineTotalQty = machineLineItems.reduce((ac, cur) => {
                return ac + (cur.qty ? parseFloat(cur.qty) : 0);
            }, 0);

            if(parseFloat(machinePower.power) < machineTotalQty) {
                valid = false;
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึก จำนวนผลิต ได้เกิน Machine Cap ใน 1 วัน (จำนวนผลิตรวม : ${machineTotalQty}, Machine Cap : ${machinePower.power} )`, "error");
            }

            return valid;

        },

        onMachineItemRemarkChanged(machineItem, machineLineItem, day) {
            this.onSaveDailyPlanLine(machineLineItem);
        },

        onMachineItemStartTimeChanged(value, machineLineItem){            
            machineLineItem.starttime = value;
        },

        onMachineItemEndTimeChanged(value, machineLineItem){            
            machineLineItem.endtime = value;
        },

        onMachineItemStartTimeClosed(value, machineLineItem) {
            this.onSaveDailyPlanLine(machineLineItem);
        },

        onMachineItemEndTimeClosed(value, machineLineItem) {
            this.onSaveDailyPlanLine(machineLineItem);
        },

        getItemInfo(remainingItems, requestNumber) {
            
            let result = null;
            if(requestNumber) {
                result = remainingItems.find(item => {
                    return item.request_number == requestNumber;
                });
            }
            return result;

        },

        getItemFullDesc(remainingItems, requestNumber) {
            
            let result = null;
            if(requestNumber) {
                const foundItem = remainingItems.find(item => {
                    return item.request_number == requestNumber;
                });
                result = foundItem ? foundItem.full_item_desc : null
            }
            return result;

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

        async onSaveDailyPlanLine(planLine) {

            const reqBody = {
                plan_header: JSON.stringify(this.planHeaderData),
                plan_line: JSON.stringify(planLine)
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            const resStoreLine = await axios.post(`/ajax/pm/plans/daily/store-line`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                // const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                if(resData.status == "success") {
                    // swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `${resMsg}`, "error");
                    planLine.qty = 0;
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            return resStoreLine;

        },

        async onAddNewLine(machineIndex, day, planLines) {

            const cloneLastPlanLineItem = {
                ...(planLines.find((item, index) => {
                    return index == (planLines.length - 1);
                }))
            }

            const planTime = cloneLastPlanLineItem.plan_time;
            let defaultStarttime = "";
            let defaultEndtime = "";
            if(planTime) {
                const foundItem = this.machineTimes.find(item => {
                    return item.lookup_code == planTime;
                });
                if(foundItem) {
                    defaultStarttime = foundItem.attribute3 ? foundItem.attribute3.replace(".", ":") : "";
                    defaultEndtime = foundItem.attribute4 ? foundItem.attribute4.replace(".", ":") : "";
                }
            }

            const newplanLine = {
                ...cloneLastPlanLineItem,
                qty: 0,
                starttime: defaultStarttime,
                endtime: defaultEndtime,
                remark: "",
                daily_plan_line_id: null,
                inventory_item_id: null,
                inv_item_number: null,
                inv_item_desc: null,
                colors: null,
                product_colors: null,
                brand: null,
                product: null,
                request_number: null,
                source_plan_line_id: null,
            };

            const reqBody = {
                plan_header: JSON.stringify(this.planHeaderData),
                plan_line: JSON.stringify(newplanLine)
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/pm/plans/daily/add-new-line`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                const resPlanLine = resData.plan_line ? JSON.parse(resData.plan_line) : null;

                if(resPlanLine) {
                    resPlanLine.starttime = resPlanLine.mes_starttime;
                    resPlanLine.endtime = resPlanLine.mes_endtime;
                    planLines = [
                        ...planLines,
                        resPlanLine
                    ];
                    this.machineLineItems[machineIndex][day].items = planLines;
                }

                if(resData.status == "success") {
                    // swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถเพิ่มข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถเพิ่มข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            this.emitMachineLineItemsChanged();

        },

        async onDeleteMachineLine(machineName) {

            const reqBody = {
                plan_header: JSON.stringify(this.planHeaderData),
                machine_name: machineName
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/pm/plans/daily/delete-machine-line`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                                        
                    const dataPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.machineLineItems = this.mapMachineLineItems(this.weeklys, this.machineItems, this.planHeaderData, this.remainingItems, dataPlanLines)

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถลบข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถลบข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            this.emitMachineLineItemsChanged();

        },

        async onDeleteLine(planLineItems, planLineItem) {

            if(planLineItems.length <= 1) {

                // IF LINES (ON THAT DAY) <= 1
                // => CLEAR DATA OF THAT LINE

                planLineItem.inventory_item_id = null;
                planLineItem.inv_item_number = null;
                planLineItem.inv_item_desc = null;
                planLineItem.colors = null;
                planLineItem.product_colors = null;
                planLineItem.brand = null;
                planLineItem.product = null;
                planLineItem.request_number = null;
                planLineItem.source_plan_line_id = null;

                await this.onSaveDailyPlanLine(planLineItem);

            } else {

                // IF LINES (ON THAT DAY) > 1
                // => DELETE THAT LINE FROM TABLE

                const reqBody = {
                    plan_header: JSON.stringify(this.planHeaderData),
                    plan_line: JSON.stringify(planLineItem)
                };

                // SHOW LOADING
                this.isLoading = true;

                // call store sample result
                await axios.post(`/ajax/pm/plans/daily/delete-line`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        
                        // Remove deleted item from 'planLineItems'
                        const foundIndex = planLineItems.findIndex((item) => {
                            return item.daily_plan_line_id == planLineItem.daily_plan_line_id;
                        });
                        planLineItems.splice(foundIndex, 1);

                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถลบข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถลบข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน | ${error.message}`, "error");
                });

                // HIDE LOADING
                this.isLoading = false;

            }

        },

        emitMachineLineItemsChanged() {
            this.$emit("onMachineLineItemsChanged", {
                machineLineItems: this.machineLineItems
            });
        },

    }

}

</script>