<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="text-right" style="padding-top: 15px;padding-bottom: 15px;">
                    <!-- <button :class="btnTrans.save.class" type="submit">
                        <i :class="btnTrans.save.icon" aria-hidden="true"></i> {{ btnTrans.save.text }}
                    </button> -->
                    <button :class="btnTrans.search.class" type="submit" @click="getSearchData()">
                        <i :class="btnTrans.search.icon" aria-hidden="true"></i> {{ btnTrans.search.text }}
                    </button>
                    <a type="button" :href="'/om/tax-adjustments-bkk'" class="btn btn-danger">
                        ล้างค่า
                    </a>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> จากวันที่ </strong><span style="color: red;"> * </span>
                        </label>
                        <datepicker-th
                            v-model="form_search.fromDate"
                            :class="'form-control md:tw-mb-0 tw-mb-2 w-100 '+ (validateRemarkFromDate ? 'is-invalid' : '')"
                            name="fromDate"
                            placeholder="โปรดเลือกวันที่"
                            :format="this.formatDate"
                            @dateWasSelected="fromDateSelected"
                        />
                    </div>
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> ถึงวันที่ </strong><span style="color: red;"> * </span>
                        </label>
                        <datepicker-th
                            v-model="form_search.toDate"
                            :class="'form-control md:tw-mb-0 tw-mb-2 w-100 '+ (validateRemarkToDate ? 'is-invalid' : '')"
                            name="toDate"
                            placeholder="โปรดเลือกวันที่"
                            :format="this.formatDate"
                            @dateWasSelected="toDateSelected"
                        />
                    </div>
                </div>

                <div class="row" style="padding-top: 20px;">
                    <!-- <div >
                        <label class="w-100 text-left">
                            <strong> จำนวนรวมภาษีที่ต้อง Adjust GL </strong>
                        </label>
                        <el-input
                            placeholder="จำนวนรวมภาษีที่ต้อง Adjust GL"
                            v-model="totalAmountAdjustGL"
                            :disabled="true">
                        </el-input>
                    </div> -->
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> จำนวนรวมภาษีที่ต้อง Adjust GL </strong>
                        </label>
                        <vue-numeric 
                            separator="," 
                            v-bind:precision="2" 
                            v-bind:minus="false"
                            class="form-control text-right" 
                            v-model="totalAmountAdjustGL"
                            :disabled="true"
                        ></vue-numeric>
                    </div> 
                </div>
            </div>
        </div>
        <div v-loading="loading">
            <tax-adjustments-bkk-table  :lineList = "lineList"
                                        :btnTrans = "btnTrans"
                                        @updateCheckAll="updateChecked">

            </tax-adjustments-bkk-table>
        </div>
    </div>        

</template>

<script>
import moment from 'moment'
import VueNumeric from 'vue-numeric'
export default {
    components: {
        VueNumeric
    },
    props: ['btnTrans', 'formatDate', 'oldInput'],
    data() {
        return {
            form_search:{
                fromDate: '',
                toDate: '',
            },    
            validateRemarkFromDate: false,   
            validateRemarkToDate: false,   
            lineList: [],
            loading: false,
            totalAmountAdjustGL: '',
        };
    },
    mounted() {

    },
    computed:{
        
    },
    methods: {
        fromDateSelected (date) {
            let vm = this;
            if (date) {
                vm.form_search.fromDate = moment(date).format(this.formatDate);
            } else {
                vm.form_search.fromDate = '';
            }
        },
        toDateSelected (date) {
            let vm = this;
            if (date) {
                vm.form_search.toDate = moment(date).format(this.formatDate);
            } else {
                vm.form_search.toDate = '';
            }
        },
        updateChecked(check){
            this.lineList.forEach((item)=>{
                if(item.use_tax_adjustments ){
                    if(item.use_tax_adjustments.post_flag != 'Y'){
                        item.checked = check;
                    }
                }else {
                    item.checked = check;
                }
            });
        },
        async getSearchData(){
            if(this.form_search.fromDate){
                this.validateRemarkFromDate = false;
                if(this.form_search.toDate){
                    this.loading = true;
                    this.RemarkToDate = false;
                    axios
                    .post('ajax/tax-adjustments-bkk/get-search', {
                        ...this.form_search
                    })
                    .then(res => {
                        this.loading = false;
                        this.lineList = res.data.consignmentHeaders;
                    })
                }else{
                    alert('กรุณาเลือกวันที่สิ้นสุด')
                    this.validateRemarkToDate = true;
                    return;
                }
            }else{
                alert('กรุณาเลือกวันที่เริ่มต้น')
                this.validateRemarkFromDate = true;
                return;
            }
        }
    }
};
</script>