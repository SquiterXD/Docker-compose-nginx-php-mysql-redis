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
                    <input type="hidden" name="month"  :value="month">
                    <input type="hidden" name="month_value"  :value="month_value">
                </div>
            </div>
            <div class="row">
                <div class="m-1 col-3 text-right">
                    <div>
                        ชุดกรมธรรม์ ตั้งแต่
                    </div>
                </div>
                <div class="col-6">
                    <el-select 
                        v-model="policy_set_header_id_from" 
                        filterable 
                        clearable
                        class="w-100 text-left"
                        :popper-append-to-body='false'
                        :disabled="!this.month"
                    >
                        <el-option
                            v-for="(list, index) in policyList"
                            :key="index"
                            :label="list.label"
                            :value="list.value">
                        </el-option>
                        <input type="hidden" name="policy_set_header_id_from" :value="policy_set_header_id_from">
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="m-1 col-3 text-right">
                    <div>
                        ชุดกรมธรรม์ ถึง
                    </div>
                </div>
                <div class="col-6">
                    <el-select v-model="policy_set_header_id_to" filterable clearable
                        class="w-100 text-left"
                        :popper-append-to-body='false'
                        :disabled="!this.month"
                    >
                        <el-option
                            v-for="(list, index) in policyList"
                            :key="index"
                            :label="list.label"
                            :value="list.value">
                        </el-option>
                        <input type="hidden" name="policy_set_header_id_to" :value="policy_set_header_id_to">
                    </el-select>
                </div>
            </div>
            <input type="hidden" :value="value" name="program_code">
            <input type="hidden" :value="functionName" name="function_name">
            <input type="hidden" name='output' :value="reportType">
            <div class="text-center mt-2">
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
            date:{},
            reportType: 'pdf',
            errorLists:[],
            

            policyList: [],
            
            month:                     '',
            policy_set_header_id_from: '',
            policy_set_header_id_to:   '',
            month_value:               '',
        };
    },
    methods: {
        getYear(value, month){
            this.month = value;

            if (value) {
                this.getPolicySet();
            }
            
            this.month_value = moment(value)
                            .add(-543, "years")
                            .format("MM/DD/YYYY");
        
        },

        checkForm: function (e) {
            if(!this.month){
                swal({
                    title: "Warning",
                    text:  'กรุณาระบุข้อมูลให้ครบถ้วน',
                    type: "warning",
                })
            }else {
                return true;
            }

            e.preventDefault();
        },

        getPolicySet(){
            console.log('func getPolicySet');
            axios.get("/ir/reports/irr0081-3-get-policy-set", {
                params: {
                    month: this.month,
                }
            })
            .then(res => {
                this.policyList  = res.data.data;
            })
            .catch((error) => {
            })
        },
    },
};
</script>
