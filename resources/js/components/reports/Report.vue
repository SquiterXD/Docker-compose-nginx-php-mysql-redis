<template>
    <div>
        <el-select
            v-model="value"
            @change="getInfos"
            filterable
            remote
            reserve-keyword
            placeholder="Please enter a report "
            :remote-method="remoteMethod"
            @input="remoteMethod(' ')"
            clearable 
            class="col-11"
        >
            <el-option
                v-for="item in options"
                :key="item.program_code"
                :label="item.program_code + ' ' +item.description"
                :value="item.program_code"
            >
            </el-option>
        </el-select>

        <div v-if="irReport && functionName == 'IRR0005_3'">
            <IRR0005_3 
                :url="this.url"
                :trans-btn="this.transBtn"
                :trans-date="this.transDate"
                :default-program-code="this.value"
                :info-attributes="this.infoAttributes"
                :function-name="this.functionName"
            ></IRR0005_3>
        </div>
        <div v-if="irReport && functionName == 'IRR0009_1'">
            <IRR0009_1 
                :url="this.url"
                :trans-btn="this.transBtn"
                :trans-date="this.transDate"
                :default-program-code="this.value"
                :info-attributes="this.infoAttributes"
                :function-name="this.functionName"
            ></IRR0009_1>
        </div>
        <div v-if="irReport && functionName == 'IRR0009_2'">
            <IRR0009_2 
                :url="this.url"
                :trans-btn="this.transBtn"
                :trans-date="this.transDate"
                :default-program-code="this.value"
                :info-attributes="this.infoAttributes"
                :function-name="this.functionName"
            ></IRR0009_2>
        </div>
        <div v-if="irReport && functionName == 'IRR0081_1'">
            <IRR0081_1 
                :url="this.url"
                :trans-btn="this.transBtn"
                :trans-date="this.transDate"
                :default-program-code="this.value"
                :info-attributes="this.infoAttributes"
                :function-name="this.functionName"
            ></IRR0081_1>
        </div>
        <div v-if="irReport && functionName == 'IRR0009_3'">
            <IRR0009_3 
                :url="this.url"
                :trans-btn="this.transBtn"
                :trans-date="this.transDate"
                :default-program-code="this.value"
                :info-attributes="this.infoAttributes"
                :function-name="this.functionName"
            ></IRR0009_3>
        </div>
        <div v-if="irReport && functionName == 'IRR0081_3'">
            <IRR0081_3 
                :url="this.url"
                :trans-btn="this.transBtn"
                :trans-date="this.transDate"
                :default-program-code="this.value"
                :info-attributes="this.infoAttributes"
                :function-name="this.functionName"
            ></IRR0081_3>
        </div>

        <!-- <button class="btn btn-primary" @click="getInfos">Search </button> -->
        <form :action="url.getParam" method="get" target="_blank" @submit="checkForm" v-if="!irReport">
            <hr class="m-3">
            <div v-if="infoAttributes.length > 0" class="form-group">
                <div v-for="(infoAttribute, index) in infoAttributes" :key="index">
                    <div v-if="infoAttribute.form_type == 'text'"  class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>  {{ infoAttribute.display_value }} <span v-if="infoAttribute.required =='1'" class="tw-text-red-400">* </span></div>
                        </div>
                        <div class="col-6">
                            <input type="text" :name="infoAttribute.attribute_name" class="form-control w-100 ">
                        </div>
                    </div>

                    <div v-if="infoAttribute.form_type == 'date'" class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>
                                {{ infoAttribute.display_value }}  <span v-if="infoAttribute.required =='1'" class="tw-text-red-400">* </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <datepicker-th
                                v-model="infoAttribute.attribute_name[infoAttribute.id]"
                                    style="width: 100%; border-radius:3px;"
                                    class="form-control col-lg-12"
                                    id="input_date"
                                    :pType="infoAttribute.date_type"
                                    :format="infoAttribute.format_date"
                                    @dateWasSelected="getYear(...arguments, infoAttribute)"
                                />
                                <input type="hidden" :name="infoAttribute.attribute_name" v-model="infoAttribute.form_value">
                        </div>
                    </div>

                    <div v-if="infoAttribute.form_type == 'select'" class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>{{ infoAttribute.display_value }} <span v-if="infoAttribute.required =='1'" class="tw-text-red-400">* </span></div>
                        </div>
                        <div class="col-6" v-loading="infoAttribute.loading">
                            <el-select v-model="infoAttribute.form_value" filterable clearable
                                class="w-100 text-left"
                                @change="action(infoAttribute)"
                                :popper-append-to-body='false'
                                :disabled="infoAttribute.disable"
                            >
                                <el-option
                                    v-for="(list , listIndex) in infoAttribute.lists"
                                    :key="listIndex"
                                    :label="list.label"
                                    :value="list.value">
                                </el-option>
                            <input type="hidden" :name="infoAttribute.attribute_name" :value="infoAttribute.form_value">
                            </el-select>

                        </div>
                    </div>

                    <div v-if="infoAttribute.form_type == 'options'" class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>{{ infoAttribute.display_value }} <span v-if="infoAttribute.required =='1'" class="tw-text-red-400">* </span></div>
                        </div>
                        <div class="col-6">
                            <el-select v-model="infoAttribute.form_value" filterable clearable
                                :popper-append-to-body='false'
                                class="w-100 text-left"
                            >
                            <el-option
                                v-for="list in infoAttribute.lists"
                                    :key="list.value"
                                    :label="list.label"
                                    :value="list.value">
                                </el-option>
                                <input type="hidden" :name="infoAttribute.attribute_name" :value="infoAttribute.form_value">
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="row m-2" v-if="functionReport.attribute_9 == 'Y'">
                    <div class="m-1 col-3 text-right">
                        <div> ประเภทรายงาน <span class="tw-text-red-400">* </span> </div>
                    </div>
                    <div class="col-6">
                        <el-radio v-model="reportType" label="pdf"> PDF </el-radio>
                        <el-radio v-model="reportType" label="excel"> Excel </el-radio>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-12 text-center">
                        <p v-if="errorLists.length > 0">
                            <div :key="index" v-for="(errorList, index) in errorLists" class="font-weight-bold text-danger">
                                {{ errorList }}
                            </div>
                        </p>
                    </div>
                </div>
                <input type="hidden" :value="value" name="program_code">
                <input type="hidden" :value="functionName" name="function_name">
                <input type="hidden" name='output' :value="reportType">
                <input type="hidden" name="month_value"  :value="month_value">
                <div class="text-center">
                    <button :class="transBtn.printReport.class" type="submit"> <i :class="transBtn.printReport.icon"></i> {{ transBtn.printReport.text }}</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import moment from "moment";
import IRR0005_3 from './IRR0005_3.vue'
import IRR0009_1 from './IRR0009_1.vue'
import IRR0009_2 from './IRR0009_2.vue'
import IRR0081_1 from './IRR0081_1.vue'
import IRR0009_3 from './IRR0009_3.vue'
import IRR0081_3 from './IRR0081_3.vue'
export default {
    props: [
        'url',
        'trans-date',
        'trans-btn',
        'module',
        'url-ger-param',
        'default-program-code',
        'url-sub-query'

    ],
    components: {
        IRR0005_3,
        IRR0009_1,
        IRR0009_2,
        IRR0081_1,
        IRR0009_3,
        IRR0081_3,
    },

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
            infoAttributes:[],
            date:{},
            functionName : "",
            functionReport: "",
            reportType: 'pdf',
            errorLists:[],
            loading:{

            },
            irReport: false, 
            month_value: '',
            // urlTest: 'http://offline.test/ir/ajax/ir-report-get-info-attribute?program_code=IRR0001',
        };
    },
    async mounted() {
        if(this.defaultProgramCode){
            this.getInfos();
        }

        // ตัวอย่าง การใช้ async , await
        await this.test().
            then((res) => {
                console.log(res)
            })
            .catch((err) => {
                console.log(err)
            });
   
    },
    methods: {
        async remoteMethod(query) {
            var request = {
                params: {
                    module: [this.module],
                    uQuery: query
                    
                }
            }
            axios.get(this.urlGerParam, request)
            .then((res) => {
                // this.infos = res.data.ptirReportInfos;
                this.programs = res.data.programs;
                this.options = res.data.programs;
            })
            .catch((error) => {
                // swal("Error", error, "error");
            })

        },

        async remote(query){
            if (query !== "") {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.options = this.programs.filter(item => {
                        if(item.program_code){
                            return (
                                item.program_code
                                    .toLowerCase()
                                    .indexOf(query.toLowerCase()) > -1
                            );
                        }
                    });
                }, 200);
            } else {
                this.options = [];
            }
        },
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
                // swal("Error", error, "error");
            })
        },
        async getInfos(){
            this.infoAttributes = [];
            this.functionName = "";
            this.errorLists =[];

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
        getYear(value, infoAttribute){
            if(infoAttribute.date_type == 'month'){
                infoAttribute.form_value = moment(value)
                                .add(-543, "years")
                                .format(this.transDate["js-datatime-format"]);
            }

            if(infoAttribute.date_type == 'year'){
                infoAttribute.form_value = moment(value)
                                .add(-543, "years")
                                .format(this.transDate['js-year-format']);
            }
            if(infoAttribute.date_type =='date'){
                infoAttribute.form_value = moment(value)
                                .add(-543, "years")
                                .format(this.transDate['js-format']);

            }

            this.month_value = moment(value)
                            .add(-543, "years")
                            .format("Y-M-d");

            this.action(infoAttribute);

        },
        exportReport(){

        },

        checkForm: function (e) {
                this.errorLists = [];
                this.infoAttributes.forEach(info => {
                    if(info.required ==1 & info.form_value == null){
                        let msg = 'โปรดระบุ. '+ ' '+ info.display_value;
                        this.errorLists.push(msg);
                    }
                });

                if(this.errorLists.length == 0){
                     return true;
                }

                 e.preventDefault();
        },

        selectedList(selected){
            return selected.value;
        },

        async action(infoAttribute){

            let checkValue =  false;
            
            
            let arr = this.infoAttributes.filter(item => {
                return item.attribute_8 == infoAttribute.attribute_name || item.attribute_5 == infoAttribute.attribute_name  || item.attribute_6 == infoAttribute.attribute_name;
            })

            let arrCheckEnable = this.infoAttributes.filter(item => {
                return item.attribute_4 == infoAttribute.attribute_name;
            })

            if(arrCheckEnable.length > 0){
                arrCheckEnable.forEach(item=> {
                    this.checkDisable(item, false);
                })
            }

            if(arr.length == 0){
                return 
            }
            
            await this.loadingQuery(arr, true);
            // let vBetween = [];
            let start  = "";
            let end  = "";
            let value_start  = "";
            let value_end  = "";

            arr.forEach(item => {
                if(item.attribute_7 == 'whereBetween' ){
                    start = this.infoAttributes.find(value => {
                        return  value.attribute_name == item.attribute_5;
                    })
                    end = this.infoAttributes.find(value => {
                        return  value.attribute_name == item.attribute_6;
                    })
                }
            });

            if(start != ''){
                value_start=start.form_value
            }

            if(end != ''){

                value_end=end.form_value
            }
            // console.log(start, end)
            let ids = arr.map(item => item.report_info_id);

            await this.subQuery(ids, infoAttribute.form_value,arr,infoAttribute.seq, value_start, value_end)

        },

        async subQuery(ids,form_value, arr,seq, start, end){
            var request = {
                params: {
                    ids: ids,
                    value: form_value,
                    value_start: start,
                    value_end: end
                }
            }

            axios.get(this.urlSubQuery, request)
            .then((res) => {
                console.log('then res')
                let  infos =  res.data.reportInfos;
                infos.forEach(item => {
                    console.log(item, 'then');
                    let infoA = this.infoAttributes.find(value =>{
                        return value.report_info_id == item.report_info_id;
                    })
                    this.afterCall(infoA, form_value, seq, item)
                });                
            })
            .then(() => {
                // console.log('loading')
                this.loadingQuery(arr, false);
            })
            .catch((error) => {
                this.loadingQuery(arr, false);
                swal("Error", error, "error !");
                
            })

            console.log('end')
        },

        async loadingQuery(arr,load){

            // await arr.forEach(element => {
            //     element.loading = load;
            // });
        },

        resetValueFormSeq(seq){
            // console.log('resetValueFormSeq')
            this.infoAttributes.forEach(element => {
                if(element.seq > seq & (element.attribute_8 != null || element.attribute_7  != null)){
                    element.form_value = ''
                    this.checkDisable(element, true)
                }

            });
        },
        
        checkDisable(info, disable){
            // console.log('checkDisable')
            info.disable = disable
        },

        afterCall(infoA, form_value, seq, item){
            // console.log('afterCall', infoA, form_value, seq, item)
            if(infoA){
                infoA.form_value = ''
                infoA.lists =  item.new_lists

                if(form_value == '' || form_value== null || form_value=='Invalid date'){
                    infoA.form_value = ''
                    this.resetValueFormSeq(seq)            
                                                        
                } else {
                    this.checkDisable(infoA, false);
                }
            }
        },

        async test() {
            await this.test1()
            await this.test2()
            await this.test3()
            await this.test4()

            return 'Success'
        },

        test1() {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    console.log(1)
                    return resolve('c')
                }, 100);
            })
        },
        test2() {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    console.log(2)
                    return resolve('reject')
                }, 100);
            })
            
        },
        test3() {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    console.log(3)
                    return resolve('c')
                }, 100);
            })
            
        },
        test4() {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    console.log(4)
                    return resolve('c')
                }, 20);
            })
        },
    },
    watch: {
        functionName : async function () {
            if (this.functionName == 'IRR0005_3' || this.functionName == 'IRR0009_1' || this.functionName == 'IRR0009_2' || this.functionName == 'IRR0081_1' || this.functionName == 'IRR0009_3' || this.functionName == 'IRR0081_3') {
                this.irReport = true;
            }
        }
    },
};
</script>
