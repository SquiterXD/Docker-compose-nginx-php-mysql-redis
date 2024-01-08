<template>
    <div class="table-responsive">
        <!-- {{ canAddData }} -->
        <!-- <pre>{{ form }}</pre> -->
        <div class="text-right" style="padding-bottom: 15px;padding-top: 15px;padding-right: 15px;">
            <button :disabled="!form.can_add_line"
                class="btn btn-sm btn-primary"
                type="submit"
                @click.prevent="addLine">
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="font-size: small;">
                            <div>วันที่เริ่มต้นการใช้งาน</div>
                        </th>
                        <th class="text-center" style="font-size: small;">
                            <div>วันที่เลิกใช้งาน</div>
                        </th>
                        <th class="text-center" style="font-size: small;">
                            <div>จำนวน Layout <span class="text-danger"> *</span></div>
                        </th>
                        <th colspan="2" width="25%" class="text-center" style="font-size: small;">
                            <div>หน่วย</div>
                        </th>
                        <th colspan="2" width="25%" class="text-center" style="font-size: small;">
                            <div>หน่วยใหม่</div>
                        </th>
                        <th>
                            <div></div>
                        </th>
                    </tr>
                </thead>
                <tbody  v-loading="is_loading">
                    <tr v-if="lines.filter(o => !o.is_del_row).length == 0">
                        <td colspan="8" v-if="checkText">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                    <tr v-for="(data, index) in lines" :key="index" v-if="!data.is_del_row && lines.filter(o => !o.is_del_row).length > 0">
                        <td>
                                <!-- class="my-1 form-control form-control col-12" -->
                            <ct-datepicker
                            :class="'my-1 form-control form-control col-12 ' + (!data.start_date_valid ? 'is-invalid' : '')"
                                style="width: 100%;"
                                placeholder="โปรดเลือกวันที่"
                                :value="toJSDate(data.start_date, 'yyyy-MM-dd')"
                                :enableDate="date => isInRange(date, data.max_end_date ? data.max_end_date : null, data.end_date, true)"
                                @change="(date) => {
                                    data.start_date = jsDateToString(date)
                                    canAddData()
                                    validateDate(data, index, 'start_date')
                                }"/>
                        </td>
                        <td>
                                <!-- class="my-1 form-control form-control col-12" -->
                            <ct-datepicker
                                :class="'my-1 form-control form-control col-12 ' + (!data.end_date_valid ? 'is-invalid' : '')"
                                style="width: 100%;"
                                placeholder="โปรดเลือกวันที่"
                                :enableDate="date => isInRange(date, data.start_date, null, true)"
                                :value="toJSDate(data.end_date, 'yyyy-MM-dd')"
                                @change="(date) => {
                                    data.end_date = jsDateToString(date)
                                    canAddData()
                                    validateDate(data, index, 'end_date')
                                }"/>
                        </td>
                        <td>
                            <vue-numeric
                                placeholder="จำนวน Layout"
                                separator=","
                                v-bind:precision="0"
                                v-bind:minus="false"
                                :class="'form-control w-100 text-right ' + (data.validateRemark ? 'is-invalid' : '')"
                                v-model="data.numberLayout"
                            ></vue-numeric>
                        </td>
                        <td>
                            <el-input :disabled="true" v-model="data.unit"></el-input>
                        </td>
                        <td>
                            <el-input :disabled="true" v-model="data.unitMeasure"></el-input>
                        </td>
                        <td>
                            <el-select style="width: 100%" v-model="data.custom_uom_code" placeholder="Select" clearable filterable @change="(value)=>{
                                    if (value && customUomList.length > 0) {
                                        let query = customUomList.findIndex(o => o.value == value);
                                            query = customUomList[query];
                                            data.custom_uom_name = query.label;
                                    } else {
                                        data.custom_uom_name = ''
                                    }
                                }">
                                <el-option
                                  v-for="item in customUomListData"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value"
                                  >
                                  <span style="float: left">{{ item.label }}</span>
                                </el-option>
                            </el-select>
                        </td>
                        <td>
                            <el-input :disabled="true" v-model="data.custom_uom_name"></el-input>
                        </td>

                        <td class="text-center">

                            <button @click.prevent="delDataToTable(data)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div
                                class="row justify-content-center clearfix tw-my-4"
                            >
                                <div class="col text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success"
                                        v-on:click="saveDataToTable()"
                                    >
                                        <i class="fa fa-plus"></i> บันทึก
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import uuidv1 from 'uuid/v1';
import moment from 'moment';
import VueNumeric from 'vue-numeric';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../../dateUtils'

const delay = millis => new Promise((resolve, reject) => {
  setTimeout(_ => resolve(), millis)
});

export default {
    props: ['resultsTable', 'primaryUomCode' ,'primaryUnitOfMeasure', 'itemNumber', 'customUomList'],
    data() {
        return {
            isInRange, jsDateToString, toJSDate, toThDateString,
            // lines: [],
            lines: this.resultsTable ? JSON.parse(JSON.stringify(this.resultsTable)) : [],
            inputs: [],
            customUomListData: this.customUomList,
            is_loading: false,
            checkText: true,
            form: {
                can_add_line: false,
                max_end_date: null,
                // def_end_date: null,
            }
        };
    },
    computed: {

    },
    async mounted() {
        this.canAddData();
        if (this.lines.length == 0) {
            this.addLine()
        }
    },
    watch:{
        resultsTable : async function (value, oldValue) {
            this.lines = this.resultsTable ? JSON.parse(JSON.stringify(this.resultsTable)) : [];
            this.canAddData();
        },
    },
    components: {
       VueNumeric
    },
    methods: {
        addLine() {
            this.checkText = false;
            this.lines.push({
                id              : uuidv1(),
                // start_date      : this.value ? moment(this.value, "DD/MM/YYYY").toDate() : moment().add(543, 'years').toDate(),
                // start_date      : moment().format('YYYY-MM-DD'),
                def_start_date  : this.form.max_end_date,
                start_date      : this.form.max_end_date,
                end_date        : '',
                numberLayout    : '',
                unit            : this.primaryUomCode,
                unitMeasure     : this.primaryUnitOfMeasure,
                custom_uom_code     : this.primaryUomCode,
                custom_uom_name     : this.primaryUnitOfMeasure,
                start_date_valid  : true,
                end_date_valid  : true,
                validateRemark  : false,
                is_new_row      : true,
                is_del_row      : false,
            });

            this.canAddData();
        },
        removeRow: function(index) {
            this.lines.splice(index, 1);
            if(this.lines.length == 0){
                this.checkText = true;
            }else{
                this.checkText = false;
            }
        },
        async saveDataToTable() {
            let vm = this;
            let checkStatus = false
            let msg = await vm.validateSaveDataToTable();
            console.log('saveDataToTable', msg);
            if (msg) {
                swal({
                    title: "",
                    text:  msg,
                    type: "warning",
                })
                return;
            }

            var params = {...this.lines};
            var params1 = this.itemNumber;
            this.is_loading = true;
            return axios
                .post('/pm/ajax/save-publication-layout/store',{ params,params1 })
                .then(async res => {
                    if(res.data.data == "succeed"){
                        swal({
                            title: "Success !",
                            text: "บันทึกสำเร็จ",
                            type: "success",
                            showConfirmButton: true
                        });
                        await vm.$emit("reload", vm.itemNumber);
                        await vm.canAddData();
                    }
                    this.is_loading = false;
                });
            return;
        },
        async validateSaveDataToTable() {
            let vm = this;
            let checkStatus = false
            let isSaveForm = true
            let checkEndDateIsNullManyRows = vm.lines.filter(o => ((o.end_date == '') || (o.end_date == null)) && !o.is_del_row);

            if (checkEndDateIsNullManyRows.length > 1) {
                return 'ไม่สามารถบันทึกได้ เนื่องจากไม่ระบุวันที่เลิกใช้งานมากกว่า 1 รายการ';
            }
            let msg = ''
            let valid = true;
            let inputs = await _.sortBy(vm.lines, [function(o) { return o.start_date; }]);
                // inputs = await _.sortBy(JSON.parse(JSON.stringify(vm.lines)), [function(o) { return moment(o.start_date).format("YYYYMMDD"); }], 'desc');

                console.log('zzz', inputs, vm.lines);
            // let xxxx = await vm.lines.forEach(async (element, index) => {
            for(let index = 0; index < inputs.length; index++){
                let element = inputs[index];
                console.log('element', element.start_date, element.end_date);

                msg = await vm.validateList(element, index, 'start_date', isSaveForm);
                if (msg) {
                    console.log('----> 1', msg);
                    break;
                }
                msg = await vm.validateList(element, index, 'end_date', isSaveForm);
                if (msg) {
                    console.log('----> 2');
                    break;
                }

                if(!element.numberLayout){
                    valid = false;
                    console.log('----> 3');
                    element.validateRemark = true;
                    checkStatus = true;
                    break;
                }else{
                    element.validateRemark = false;
                }
            }
            if (checkStatus) {
                return 'ไม่สามารถบันทึกได้ เนื่องจากยังไม่ได้ระบุจำนวน Layout';
            }
            if (msg) {
                console.log('----> 5');
                return msg;
            }
            return false;
        },
        async delDataToTable(line) {
            let vm = this;
            let confirm = true;
            // confirm = await new helperAlert.showProgressConfirm('กรุณายืนยันลบรายการ');
            if (confirm) {
                let vm = this;
                let checkStatus = false
                let msg = await vm.validateSaveDataToTable();
                console.log('delDataToTable', msg);
                if (msg) {
                    await delay(100);
                    await helperAlert.showGenericFailureDialog(msg);
                    return;
                }

                var params = {...this.lines};
                var params1 = this.itemNumber;
                line.is_del_row = true;
                this.is_loading = true;
                return axios
                    .post('/pm/ajax/save-publication-layout/store',{ params,params1 })
                    .then(async res => {
                        if(res.data.data == "succeed"){
                            swal({
                                title: "Success !",
                                text: "ลบข้อมูลสำเร็จ",
                                type: "success",
                                showConfirmButton: true
                            });
                            await vm.$emit("reload", vm.itemNumber);
                            await vm.canAddData();
                        }
                        this.is_loading = false;
                    });
            }
            await vm.canAddData();
        },
        getValueStartDate(date, index) {
            let vm = this;
            if (date) {
                vm.lines[index].start_date = moment(date).format("DD-MM-YYYY");;
            } else {
                vm.lines[index].start_date = '';
            }
        },
        getValueEndDate(date, index){
            let vm = this;
            if (date) {
                vm.lines[index].end_date = moment(date).format("DD-MM-YYYY");;
            } else {
                vm.lines[index].end_date = '';
            }
        },
        canAddData() {
            let vm = this;
            if (vm.lines.filter(o => (!o.is_del_row)).length == 0 ) {
                vm.form.can_add_line = true;
                return;
            }


            vm.form.can_add_line = true;
            vm.form.max_end_date = null;
            vm.form.def_start_date = null;
            // vm.form.def_end_date = null;
            vm.lines.forEach((o) => {
                if (o.end_date == '' || o.end_date == null) {
                    vm.form.can_add_line = false;
                }
            });


            let moments = vm.lines.map(o => moment(o.end_date)),
                maxDate = moment.max(moments);
            let maxDateFm = maxDate.format('YYYY-MM-DD');
            if (maxDateFm != 'Invalid date' && maxDateFm != '' &&  maxDateFm != null) {
                vm.form.max_end_date = maxDate.add(1, 'days').format('YYYY-MM-DD');
                vm.form.def_start_date = vm.form.max_end_date;
            }
        },
        async validateDate(line, index, inputName) {
            let vm = this;
            let msg = await vm.validateList(line, index, inputName);
            if (msg) {
                swal({
                    title: "",
                    text:  msg,
                    type: "warning",
                })
            }
        },
        async validateList(line, index, inputName, isSaveForm = false) {
            let vm = this;
            let msg = false;

            line.start_date_valid = true;
            line.end_date_valid = true;

            console.log(' validateList index', index);
            // vm.lines.forEach( (o, idx) => {
            for(let idx = 0; idx < vm.lines.length; idx++) {
                msg = false;
                let o = vm.lines[idx]
                if (line.id != o.id) {
                    let startDate   = moment(o.start_date)
                        , endDate   = o.end_date ? moment(o.end_date) : moment().add(1, 'years')
                        , date      = ''
                        , inputStartDate    = moment(line.start_date)
                        , inputEndDate      = line.end_date ? moment(line.end_date) : moment().add(1, 'years')
                        , dateTh      = ''
                    console.log('loop', idx);

                    date = '';
                    if (inputName == 'start_date' && inputStartDate) {
                        date = inputStartDate;
                    }

                    if (inputName == 'end_date' && inputEndDate) {
                        date = inputEndDate;
                    }

                    var month = date.format('MM');
                    var day   = date.format('DD');
                    var year  = parseInt(date.format('YYYY')) + 543;
                    dateTh = day + '/' + month + '/' + year;

                    if (date) {
                        console.log('startDate', startDate.format("YYYY-MM-DD"));
                        console.log('endDate', endDate.format("YYYY-MM-DD"));
                        console.log('inputStartDate', inputStartDate.format("YYYY-MM-DD"));
                        console.log('inputEndDate', inputEndDate.format("YYYY-MM-DD"));
                        console.log('================================================');
                        console.log('===========> startDate'
                            , parseInt(date.format("YYYYMMDD")),  parseInt(startDate.format("YYYYMMDD"))
                            , parseInt(date.format("YYYYMMDD")) >= parseInt(startDate.format("YYYYMMDD"))
                        );

                        console.log('===========> endDate'
                            , parseInt(date.format("YYYYMMDD")), parseInt(endDate.format("YYYYMMDD"))
                            , parseInt(date.format("YYYYMMDD")) <= parseInt(endDate.format("YYYYMMDD"))
                        );

                        // เช็คช่วงวันที่ห้ามอยู่ในช่วงวันที่ ที่เลืกแล้ว
                        let valid = ( parseInt(date.format("YYYYMMDD")) >= parseInt(startDate.format("YYYYMMDD")) ) &&
                                    ( parseInt(date.format("YYYYMMDD")) <= parseInt(endDate.format("YYYYMMDD")) );
                        // let valid = await _.inRange(
                        //                 parseInt(date.format("YYYYMMDD"))
                        //                 , parseInt(startDate.format("YYYYMMDD"))
                        //                 , parseInt(endDate.format("YYYYMMDD"))
                        //             );
                        if (valid) {
                            if (inputName == 'start_date') {
                                msg = 'ไม่สามารถเลือกวันที่เริ่มต้น ' + dateTh + ' ได้เนื้องจาก มีการกำหนดในระบบแล้ว';
                                // line.start_date = line.def_start_date;
                                line.start_date_valid = false;
                                break;
                            }

                            if (inputName == 'end_date') {
                                msg = 'ไม่สามารถเลือกวันที่เลิกใช้งาน ' + dateTh + ' ได้เนื้องจาก มีการกำหนดในระบบแล้ว';
                                line.end_date = '';
                                line.end_date_valid = false;
                                break;
                            }
                        }
                    }
                    // คร่อมวันที่
                    let valid2 = (parseInt(inputStartDate.format("YYYYMMDD")) < parseInt(startDate.format("YYYYMMDD"))) &&
                                (parseInt(inputEndDate.format("YYYYMMDD")) > parseInt(endDate.format("YYYYMMDD")));
                    if (valid2 && ((line.end_date != '' && line.end_date != null)  ||  isSaveForm) ) {
                        msg = 'ไม่สามารถเลือกช่วงวันที่ได้เนื้องจาก มีการกำหนดในระบบแล้ว';
                        msg = 'ไม่สามารถเลือกช่วงวันที่ได้เนื้องจาก ('+ dateTh +') มีการกำหนดในระบบแล้ว';
                        // line.start_date = line.def_start_date;
                        line.end_date = '';
                        line.start_date_valid = false;
                        line.end_date_valid = false;
                        break;
                    }

                    if (isSaveForm) {
                        if ((line.start_date == '' || line.start_date == null) && (line.end_date == '' || line.end_date == null)) {
                            msg = 'โปรดเลือกวันที่เริ่มต้น';
                            line.start_date_valid = false;
                            line.end_date_valid = false;
                            break;
                        }
                    }


                }
            };

            return msg;
        }
    }
};
</script>
