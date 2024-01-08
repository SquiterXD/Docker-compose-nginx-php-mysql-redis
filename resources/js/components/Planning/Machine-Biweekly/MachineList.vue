<template>
    <tr>
        <td class="text-center"> {{ index + 1 }} </td>
        <td width="100px" style="padding-bottom: 2px; padding-top: 2px;">
            <div>
                <el-select class="w-100" name="machine_group[]" v-model="machineGroup" @change="selMachineGroup" size="large" placeholder="ขอบเขตเครื่องจักร" clearable filterable remote ref="machine_group" :disabled="enable" :popper-append-to-body="false">
                    <el-option
                        v-for="group in machineGroups"
                        :key="group.machine_group"
                        :label="group.machine_group_description"
                        :value="group.machine_group"
                    >
                    </el-option>
                </el-select>
            </div>
            <div :id="'el_explode_machine_group'+index" class="error_msg text-left"></div>
        </td>
        <td width="100px" style="padding-bottom: 2px; padding-top: 2px;">
            <div>
                <el-select v-if="!attribute.machine_group" class="w-100" name="machine_desc[]" v-model="machineDescription" size="large" placeholder="รายละเอียดเครื่องจักร" ref="machine_desc" disabled>
                    <el-option
                        v-for="(desc, index) in machineDescLists"
                        :key="index"
                        :label="desc.machine_description"
                        :value="desc.machine_description"
                    >
                    </el-option>
                </el-select>
                <el-select v-else class="w-100" name="machine_desc[]" v-model="machineDescription" @change="selMachineDesc" size="large" placeholder="รายละเอียดเครื่องจักร" clearable filterable remote ref="machine_desc" :disabled="enable" :popper-append-to-body="false">
                    <el-option
                        v-for="(desc, index) in machineDescLists"
                        :key="index"
                        :label="desc.machine_description"
                        :value="desc.machine_description"
                    >
                    </el-option>
                </el-select>
            </div>
            <div :id="'el_explode_machine_desc'+index" class="error_msg text-left"></div>
        </td>
        <td>
            <div class="input-group">
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="start_date"
                    id="start_date"
                    placeholder="โปรดเลือกวันที่"
                    :value="inputDateFrom"
                    v-model="inputDateFrom"
                    format="DD-MMM-YYYY"
                    :disabled="isDisableSelDate"
                    @dateWasSelected="dateWasSelectedFrom"
                />
            </div>
            <div :id="'el_explode_start_date'+index" class="error_msg text-left"></div>
        </td>
        <td class="text-right">
            <div class="input-group">
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="end_date"
                    id="end_date"
                    placeholder="โปรดเลือกวันที่"
                    :value="inputDateTo"
                    v-model="inputDateTo"
                    format="DD-MMM-YYYY"
                    :disabled="isDisableSelDate"
                    :disabled-date-to="inputDateFrom"
                    @dateWasSelected="dateWasSelectedTo"
                />
            </div>
            <div :id="'el_explode_end_date'+index" class="error_msg text-left"></div>
        </td>
        <td style="text-align: center;">
            <button class="btn btn-md btn-danger" @click.prevent="remove(machineLine)">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    </tr>
</template>

<script>
import uuidv1 from 'uuid/v1';
import moment from "moment";
export default {
    props: ["index", "attribute", "header", "machineGroups", "machineDesc", "dateFormat", "listMachineLines"],
    data() {
        return {
            loading: false,
            valid: true,
            machineLine: this.attribute,
            machineGroup: this.attribute.machine_group,
            machineDescription: this.attribute.machine_desc,
            enable: this.attribute.is_enable,
            inputDateFrom: '',
            inputDateTo: '',
            currentDate: '', 
            biweeklyDateFrom: '', 
            biweeklyDateTo: '', 
            isDisableSelDate: false,
            disable_flag: false,
            errors: {
                machine_group: false,
                machine_desc: false,
                // input_date_from: false,
                // input_date_to: false
            },
            machineDescLists: [],
        };
    },
    mounted() {
        this.getDateByBiWeekly();
    },
    watch: {
        errors: {
            handler(val){
                val.machine_group? this.setError('machine_group') : this.resetError('machine_group');
                val.machine_desc? this.setError('machine_desc') : this.resetError('machine_desc');
                // val.input_date_from? this.setError('input_date_from') : this.resetError('input_date_from');
                // val.input_date_to? this.setError('input_date_to') : this.resetError('input_date_to');
            },
            deep: true,
        },
    },
    methods: {
        decimal(number) {
            return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
        },
        selMachineGroup(){
            var vm = this;
            vm.machineLine.machine_group = vm.machineGroup;
            vm.machineDescription = '';
            vm.machineDescLists = vm.machineDesc.filter(function(item){
                return item.machine_group == vm.machineGroup;
            });
        },
        selMachineDesc(){
            var vm = this;
            var form = $('#machine-downtime-form');
            vm.valid = true;
            let errorMsg = '';
            vm.errors.machine_desc = false;
            if (vm.machineDescription && vm.inputDateFrom && vm.index >= 1) {
                vm.listMachineLines.filter((item, index) => {
                    console.log(index , vm.index);
                    if (index != vm.index) {
                        if (item.machine_desc == vm.machineDescription){
                            let start_date = moment(vm.listMachineLines[vm.index].start_date).format('YYYY-MM-DD');
                            start_date = vm.changeThToEn(start_date);
                            let end_date = moment(vm.listMachineLines[index].end_date).format('YYYY-MM-DD');
                            end_date = vm.changeThToEn(end_date);
                            if (start_date <= end_date) {
                                vm.inputDateFrom = '';
                                vm.inputDateTo = '';
                            }
                        }
                    }
                });
            }
            if (!vm.valid) {
                return;
            }
            vm.machineLine.machine_desc = vm.machineDescription;
            return;
        },
        async dateWasSelectedFrom(dateFrom){
            var vm = this;
            let form = $('#machine-downtime-form');
            vm.errors.start_date = false;
            $(form).find("div[id='el_explode_start_date"+vm.index+"']").html("");
            vm.inputDateFrom = vm.machineLine.start_date = dateFrom? moment(dateFrom).format(vm.dateFormat): '';
            if (vm.machineDescription && vm.inputDateFrom && vm.index >= 1) {
                vm.listMachineLines.filter((item, index) => {
                    if (index != vm.index) {
                        if (item.machine_desc == vm.machineDescription){
                            let input_date = moment(vm.listMachineLines[vm.index].start_date).format('YYYY-MM-DD');
                            input_date = vm.changeThToEn(input_date);
                            let start_date = moment(vm.listMachineLines[index].start_date).format('YYYY-MM-DD');
                            start_date = vm.changeThToEn(start_date);
                            let end_date =moment(vm.listMachineLines[index].end_date).format('YYYY-MM-DD');
                            end_date = vm.changeThToEn(end_date);
                            console.log(input_date+'---'+start_date+'---'+end_date);
                            if (input_date >= start_date && input_date <= end_date) {
                                vm.inputDateFrom = vm.machineLine.start_date = null;
                                vm.inputDateTo = vm.machineLine.end_date = null;
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 16px; text-align: left;"> รายละเอียดขอบเขต: '+item.machine_desc+' นี้มีการระบุช่วงวันที่นี้แล้ว กรุณาตรวจสอบ </span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        }
                    }
                });
            }
        },
        dateWasSelectedTo(dateTo){
            var vm = this;
            var form = $('#machine-downtime-form');
            vm.errors.end_date = false;
            $(form).find("div[id='el_explode_end_date"+vm.index+"']").html("");
            vm.inputDateTo = vm.machineLine.end_date = dateTo? moment(dateTo).format(vm.dateFormat): '';
            if (vm.machineDescription && vm.inputDateFrom && vm.index >= 1) {
                vm.listMachineLines.filter((item, index) => {
                    if (index != vm.index) {
                        if (item.machine_desc == vm.machineDescription){
                            let input_date = moment(vm.listMachineLines[vm.index].end_date).format('YYYY-MM-DD');
                            input_date = vm.changeThToEn(input_date);
                            let start_date = moment(vm.listMachineLines[index].start_date).format('YYYY-MM-DD');
                            start_date = vm.changeThToEn(start_date);
                            let end_date =moment(vm.listMachineLines[index].end_date).format('YYYY-MM-DD');
                            end_date = vm.changeThToEn(end_date);
                            console.log(input_date+'---'+start_date+'---'+end_date);
                            if (input_date >= start_date && input_date <= end_date) {
                                vm.inputDateTo = vm.machineLine.end_date = null;
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 16px; text-align: left;"> รายละเอียดขอบเขต: '+item.machine_desc+' นี้มีการระบุช่วงวันที่นี้แล้ว กรุณาตรวจสอบ </span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        }
                    }
                });
            }
        },
        remove(machineLine) {
            this.$emit("removeRow", machineLine);
        },
        // ดึงข้อมูลเมื่อกดปรับ
        async getDateByBiWeekly() {
            var vm = this;
            let date_from = vm.header.pp_bi_weekly.start_date;
            let date_to = vm.header.pp_bi_weekly.end_date;
            let dt_date_from = vm.machineLine.start_date != ''? moment(vm.machineLine.start_date).format('YYYY-MM-DD'): vm.header.pp_bi_weekly.start_date;
            let dt_date_to = vm.machineLine.end_date != ''? moment(vm.machineLine.end_date).format('YYYY-MM-DD'): vm.header.pp_bi_weekly.end_date;
            let curr_date = moment().format('YYYY-MM-DD');
            var currentDate = await helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');
            var startDate = await helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');
            var endDate = await helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');
            var dtStartDate = await helperDate.parseToDateTh(dt_date_from, 'YYYY-MM-DD');
            var dtEndDate = await helperDate.parseToDateTh(dt_date_to, 'YYYY-MM-DD');
            // Biweek date
            vm.currentDate = moment(currentDate).format(vm.dateFormat);
            vm.biweeklyDateFrom = moment(startDate).format(vm.dateFormat);
            vm.biweeklyDateTo = moment(endDate).format(vm.dateFormat);
            dtStartDate = moment(dtStartDate).format(vm.dateFormat);
            dtEndDate = moment(dtEndDate).format(vm.dateFormat);
            startDate = moment(startDate).format(vm.dateFormat);
            endDate = moment(endDate).format(vm.dateFormat);
            // Input date from-to
            vm.inputDateTo = vm.machineLine.end_date = endDate;
            if (vm.machineLine.start_date != '' && vm.machineLine.end_date != '') {
                vm.inputDateFrom = vm.machineLine.start_date = dtStartDate;
                vm.inputDateTo = vm.machineLine.end_date = dtEndDate;
            }else if (moment(vm.currentDate).format('YYYY-MM-DD') >= moment(startDate).format('YYYY-MM-DD')
                && moment(vm.currentDate).format('YYYY-MM-DD') >= moment(endDate).format('YYYY-MM-DD')) {
                vm.inputDateFrom = vm.machineLine.start_date = startDate;
            }else if(moment(vm.currentDate).format('YYYY-MM-DD') >= moment(startDate).format('YYYY-MM-DD')){
                vm.inputDateFrom = vm.machineLine.start_date = vm.currentDate;
            }else{
                vm.inputDateFrom = vm.machineLine.start_date = startDate;
            }
        },
        changeThToEn(dateTh){
            // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
            const vm = this;
            let date= moment(dateTh, 'YYYY-MM-DD');
            date.subtract(543, 'years');
            return date.format('YYYY-MM-DD');
        },
        setError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference 
                    ? this.$refs[ref_name].$refs.reference.$refs.input 
                    : (this.$refs[ref_name].$refs.textarea 
                        ? this.$refs[ref_name].$refs.textarea 
                        : (this.$refs[ref_name].$refs.input.$refs 
                            ? this.$refs[ref_name].$refs.input.$refs.input 
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "border: 1px solid red;";
        },
        resetError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference 
                    ? this.$refs[ref_name].$refs.reference.$refs.input 
                    : (this.$refs[ref_name].$refs.textarea 
                        ? this.$refs[ref_name].$refs.textarea
                        : (this.$refs[ref_name].$refs.input.$refs 
                            ? this.$refs[ref_name].$refs.input.$refs.input 
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "";
        },
    },
}
</script>
<style type="text/css" media="screen">
    div.el-dialog__body{
        padding-left: 50px;
        padding-right: 50px;
        padding-top: 5px;
        padding-bottom: 5px;
        color: #000;
        font-size: 15px;
    }
</style>
