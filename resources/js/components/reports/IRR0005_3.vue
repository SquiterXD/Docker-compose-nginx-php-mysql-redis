<template>
    <div>
        <form :action="url.getParam" method="get" target="_blank" @submit="checkForm">
            <hr class="m-3">
            <div class="row mb-2">
                <div class="m-1 col-3 text-right">
                    <div>
                        เดือน <span class="tw-text-red-400">* </span>
                    </div>
                </div>
                <div class="col-6">
                    <datepicker-th
                        v-model="month"
                        style="width: 100%; border-radius:3px;"
                        class="form-control col-lg-12"
                        id="input_date"
                        pType="month"
                        format="MM/YYYY"
                        @dateWasSelected="getYear(...arguments, 'month')"
                    />
                    <!-- <input type="hidden" :name="month" v-model="month"> -->
                    <input type="hidden" name="month"  :value="month">
                    <input type="hidden" name="month_value"  :value="month_value">
                </div>
            </div>
            <div class="row">
                <div class="m-1 col-3 text-right">
                    <div>
                        กลุ่ม
                    </div>
                </div>
                <div class="col-6">
                    <el-select 
                        v-model="group_code" 
                        filterable 
                        clearable
                        class="w-100 text-left"
                        @change="getCarInsurance()"
                        :popper-append-to-body='false'
                        :disabled="!this.month"
                    >
                        <el-option
                            v-for="list in groupCodeList"
                            :key="list.value"
                            :label="list.label"
                            :value="list.value">
                        </el-option>
                        <input type="hidden" name="group_code" :value="group_code">
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="m-1 col-3 text-right">
                    <div>
                        ประเภทประกันภัย
                    </div>
                </div>
                <div class="col-6">
                    <el-select v-model="car_insurance" filterable clearable
                        class="w-100 text-left"
                        @change="getDepartment()"
                        :popper-append-to-body='false'
                        :disabled="!this.group_code"
                    >
                        <el-option
                            v-for="(list, index) in carInsuranceeList"
                            :key="index"
                            :label="list.label"
                            :value="list.value">
                        </el-option>
                        <input type="hidden" name="car_insurance" :value="car_insurance">
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="m-1 col-3 text-right">
                    <div>
                        หน่วยงานตั้งแต่
                    </div>
                </div>
                <div class="col-6">
                    <el-select v-model="department_code_from" filterable clearable
                        class="w-100 text-left"
                        :popper-append-to-body='false'
                        :disabled="!this.car_insurance"
                    >
                        <el-option
                            v-for="(list, index) in departmentList"
                            :key="index"
                            :label="list.label"
                            :value="list.value">
                        </el-option>
                        <input type="hidden" name="department_code_from" :value="department_code_from">
                    </el-select>
                </div>
            </div>
            <div class="row mt-2 mb-2">
                <div class="m-1 col-3 text-right">
                    <div>
                        หน่วยงานถึง
                    </div>
                </div>
                <div class="col-6">
                    <el-select v-model="department_code_to" filterable clearable
                        class="w-100 text-left"
                        :popper-append-to-body='false'
                        :disabled="!this.car_insurance"
                    >
                        <el-option
                            v-for="list in departmentList"
                            :key="list.value"
                            :label="list.label"
                            :value="list.value">
                        </el-option>
                        <input type="hidden" name="department_code_to" :value="department_code_to">
                    </el-select>
                </div>
            </div>
            <input type="hidden" :value="value" name="program_code">
            <input type="hidden" :value="functionName" name="function_name">
            <input type="hidden" name='output' :value="reportType">
            <div class="text-center">
                <button :class="transBtn.printReport.class" type="submit"> <i :class="transBtn.printReport.icon"></i> {{ transBtn.printReport.text }}</button>
            </div>
        </form>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: [
        'url',
        'trans-date',
        'trans-btn',
        // 'module',
        // 'url-ger-param',
        'default-program-code',
        'infoAttributes',
        'functionName'

    ],
    data() {
        return {
            options: [],
            value: this.defaultProgramCode ?this.defaultProgramCode:  [],
            list: [],
            loading: false,
            states: [
            ],
            infos:[],
            programs:[],
            // infoAttributes:[],
            date:{},
            // functionName : "",
            // functionReport: "",
            reportType: 'pdf',
            errorLists:[],
            

            groupCodeList: [],
            carInsuranceeList: [],
            departmentList: [],
            departmentListTo: [],
            
            month:                '',
            group_code:           '',
            car_insurance:        '',
            department_code_from: '',
            department_code_to:   '',

            seq_1: true,
            seq_2: true,
            seq_3: true,
            month_value: '',
        };
    },
    methods: {
        async getData(query){
            axios.get(this.url.getInfor)
            .then((res) => {
                this.programs = res.data.programs;

            })
            .then(() =>{
                this.list = this.infos.map(item => {
                    return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                });
            })
            .catch((error) => {
            })
        },
        async getInfos(){
            this.infoAttributes = [];
            this.functionName = "";
            this.errorLists =[];
            // this.value = [];
            axios.get(
                this.url.getInfoAttribute+
                        '?program_code='+
                            this.value
                // this.urlTest
                        )
                .then((res) => {
                    // console.log(res);
                    this.infoAttributes = res.data.reportInfor;
                    this.functionName = res.data.functionName;
                    this.functionReport = res.data.functionReport;
                    this.programs = res.data.programs;
                    this.options = res.data.programs;

                })
                .then(() =>{
                    // this.list = this.infos.map(item => {
                    //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                    // });
                })
                .catch((error) => {
                    // swal("Error", error, "error");
                });
        },
        getYear(value, month){
            this.group_code_value = 'x111';
            // this.infoAttributes.find(data => {
            //     if (data.attribute_name == month) {
            //         data.form_value = value;
            //     }
            // });
            this.month = value;
            console.log('value', value);
            console.log('month', month);
            // this.month = moment(value)
            //                 .add(+543, "years")
            //                 .format(this.transDate["js-datatime-format"]);
            // this.month = moment(value).format(this.transDate["js-datatime-format"]);
            if (value) {
                this.getGroupCode();
            }

            
            this.month_value = moment(value)
                            .add(-543, "years")
                            .format("MM/DD/YYYY");
        
        },
        exportReport(){

        },

        checkForm: function (e) {
            if(!this.month){
                swal({
                    title: "Warning",
                    text:  'กรุณาระบุเดือน',
                    type: "warning",
                })
            }else {
                return true;
            }

            e.preventDefault();
        },

        getGroupCode(){
            console.log('func getGroupCode');
            axios.get("/ir/reports/get-group-code", {
                params: {
                    month: this.month,
                }
            })
            .then(res => {
                this.groupCodeList  = res.data.data;
            })
            .catch((error) => {
            })
        },
        getCarInsurance(){
            // console.log('func getCarInsurance', this.group_code);
            axios.get("/ir/reports/get-car-insurance", {
                params: {
                    month:      this.month,
                    group_code: this.group_code,
                }
            })
            .then(res => {
                this.carInsuranceeList  = res.data.data;
            })
            .catch((error) => {
            })
        },
        getDepartment(){
            if (this.car_insurance) {
                axios.get("/ir/reports/get-department", {
                    params: {
                        month:      this.month,
                        group_code: this.group_code,
                        car_insurance: this.car_insurance,
                    }
                })
                .then(res => {
                    this.departmentList  = res.data.data;
                })
                .catch((error) => {
                })
            }
        },
        getDepartmentTo(){
            if (this.car_insurance) {
                axios.get("/ir/reports/get-department-to", {
                    params: {
                        month:                this.month,
                        group_code:           this.group_code,
                        car_insurance:        this.car_insurance,
                        department_code_from: this.department_code_from,
                    }
                })
                .then(res => {
                    this.departmentListTo  = res.data.data;
                })
                .catch((error) => {
                })
            }
        },
    },
    // watch: {
    //     componentDetail : async function () {
    //         this.$emit('componentDetail', this.componentDetail)           
    //     },
    // }
};
</script>
