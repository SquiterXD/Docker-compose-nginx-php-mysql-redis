<template>
    <div class="ibox-content">
        <div class="text-right" style="padding-top: 15px;padding-bottom: 15px;" v-if="lineList.length != 0">
            <button :class="btnTrans.save.class" type="submit" @click="getStore()">
                <i :class="btnTrans.save.icon" aria-hidden="true"></i> {{ btnTrans.save.text }}
            </button>
        </div>
        <table class="table table-bordered text-center" v-loading="loadingTable">
            <thead>
                <tr>
                    <th class="text-center">
                        <div>เลขที่</div>
                    </th>
                    <th class="text-center">
                        <div>วันที่</div>
                    </th>
                    <th class="text-center">
                        <div>รายการ</div>
                    </th>
                    <th class="text-right">
                        <div>มูลค่าสินค้า</div>
                    </th>   
                    <th class="text-right">
                        <div>จำนวนเงินภาษี</div>
                    </th>
                    <th class="text-right">
                        <div>ภาษีที่ Adjust</div>
                    </th>
                    <th class="text-center">
                        <div>Post</div>
                        <div><el-checkbox :disabled="disableCheckAll" v-model="checkAll" @change="setAll()"></el-checkbox></div>
                    </th>
                </tr>
            </thead>

            <tbody v-if="lineList.length == 0">
                <tr>
                    <td class="text-center" style="font-size:18px; vertical-align:middle;" colspan="7"> {{ text.notInformation }}</td>
                </tr>            
            </tbody>
            <tbody v-else>
                <tr v-for="(data, index) in lineList" :key="index">
                    <td style="vertical-align: middle;">
                        {{ data.consignment_no }}
                    </td>
                    <td style="vertical-align: middle;">
                        {{ data.consignment_date_th }}
                    </td>
                    <td class="text-left" style="vertical-align: middle;">
                        {{ text.listFix }}
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        {{ data.total_amount_decimal_point }}
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        {{ data.vat_amount_decimal_point }}
                    </td>
                    <td style="vertical-align: middle;">
                        <div v-if="data.use_tax_adjustments">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                :disabled="true"
                                v-model="data.use_tax_adjustments.tax_adjust_amount"
                            ></vue-numeric>
                        </div>
                        <div v-else>
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.tax_adjust_amount"
                                @change="totalAdjustAmount(data, data.tax_adjust_amount)"
                            ></vue-numeric>
                        </div>
                        <!-- <el-input 
                            style="text-align:right;"
                            placeholder="ภาษีที่ Adjust" 
                            v-model="data.tax_adjust_amount_decimal_point"
                            @change="totalAdjustAmount(data, data.tax_adjust_amount_decimal_point)"
                        ></el-input> -->
                    </td>
                    <td style="vertical-align: middle;">
                        <el-checkbox @change="checkPost()" v-model="data.checked" :disabled="data.use_tax_adjustments ? data.use_tax_adjustments.post_flag == 'Y' : false"></el-checkbox>
                    </td>
                </tr> 
                <tr>
                    <td colspan="3">
                        {{ text.total }}
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        {{ totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2 }) }}
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        {{ totalVatAmount.toLocaleString(undefined, { minimumFractionDigits: 2 }) }}
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        <!-- {{ this.totalAdjust.toLocaleString(undefined, { minimumFractionDigits: 2 }) }} -->
                        {{ this.totalAdjust.toLocaleString(undefined, { minimumFractionDigits: 2 }) }}
                    </td>
                    <td>

                    </td>
                </tr>     
            </tbody>
        </table>
    </div>
</template>

<script>
import VueNumeric from 'vue-numeric'
export default {
    components: {
        VueNumeric
    },
    props: ['lineList', 'btnTrans'],
    data() {
        return {
            text:{
                listFix: 'ยอดจำหน่ายบุหรี่ ยาเส้น-สโมสร กทม.',
                total: 'ยอดรวม',
                notInformation: 'ไม่มีข้อมูล',                
            },
            totalAdjust: '',  
            totaVatAmountCalculate: '',
            totalAmountAdjustGLTable: '',
            loadingTable: false,
            checkAll: false,
            disableCheckAll: false,
        }
    }, 
    computed: {
        totalAmount() {
            return this.lineList.reduce((previous, current) => Number(previous) + Number(current.total_amount), 0);
        },
        totalVatAmount() {
            this.totalAdjustAmount()
            return this.lineList.reduce((previous, current) => Number(previous) + Number(current.vat_amount), 0);
        },
    },
    mounted(){

    },
    watch:{
        lineList(newList, oldList) { // watch it
            this.checkAll = newList.every((item) => {
                return item.use_tax_adjustments ? item.use_tax_adjustments.post_flag == 'Y' : false;
            });
            this.disableCheckAll = newList.every((item) => {
                return item.use_tax_adjustments ? true : false;
            });
        }
    },
    methods: {
        setAll(){
            let vm = this;
            this.$emit('updateCheckAll', vm.checkAll);
        },
        checkPost(){
            let test = this.lineList.every((item) => {
                return item.checked;
            });
            this.checkAll = test;
        },
        totalAdjustAmount (data, value) {
            let vm = this;
            if(data){
                this.lineList.forEach(element => {
                    if(data.consignment_header_id == element.consignment_header_id){
                        element.tax_adjust_amount = value
                    }
                });
                this.totalAdjust = this.lineList.reduce((previous, current) => {
                    if (current.use_tax_adjustments) {
                        return Number(previous) + Number(current.use_tax_adjustments.tax_adjust_amount);
                    } else {
                        return Number(previous) + Number(current.tax_adjust_amount);
                    }
                }, 0);

                this.totaVatAmountCalculate = this.lineList.reduce((previous, current) => Number(previous) + Number(current.vat_amount), 0);
                this.totalAmountAdjustGLTable = Number(this.totaVatAmountCalculate) - Number(this.totalAdjust);                
                vm.$parent.totalAmountAdjustGL = this.totalAmountAdjustGLTable;
            }else{
                // console.log(this.lineList)
                this.totalAdjust = this.lineList.reduce((previous, current) => {
                    if (current.use_tax_adjustments) {
                        return Number(previous) + Number(current.use_tax_adjustments.tax_adjust_amount);
                    } else {
                        return Number(previous) + Number(current.tax_adjust_amount);
                    }
                }, 0);

                this.totaVatAmountCalculate = this.lineList.reduce((previous, current) => Number(previous) + Number(current.vat_amount), 0);
                this.totalAmountAdjustGLTable = Number(this.totaVatAmountCalculate) - Number(this.totalAdjust);
                vm.$parent.totalAmountAdjustGL = this.totalAmountAdjustGLTable;
            }
        },
        getStore(){
            let vm = this;
            const lineList =  this.lineList.filter((data) =>{                
                return data.checked == true
            })

            if(lineList.length != 0){
                this.loadingTable = true;
                axios
                .post('ajax/tax-adjustments-bkk/store', {
                    lineList
                })
                .then(res => {
                    if(res.data.status == "ERROR"){
                        swal({
                            title: "error !",
                            text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก "+res.data.err_msg,
                            type: "error",
                            showConfirmButton: true
                        });
                        this.loadingTable = false;
                        return;
                    }else if(res.data.result == "success"){
                        swal({
                            title: "success !",
                            text: "บันทึก สำเร็จ!",
                            type: "success",
                            showConfirmButton: true
                        });
                        this.loadingTable = false;
                        vm.$parent.getSearchData(vm.form_search)
                    }
                })
            }else{
                swal({
                    title: "คำเตือน !",
                    text: "กรุณาเลือกรายการที่ต้องการจะ Post",
                    type: "warning",
                    showConfirmButton: true
                });
                this.loadingTable = false;
                return;
            }      
        },
    },
}
</script>