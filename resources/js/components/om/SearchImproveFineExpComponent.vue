<template>
    <form :action="search_data.search_url" id="searchForm" v-loading="loading">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุดการคำนวณ </label>
                <el-date-picker 
                    v-model="form.total_fine_due"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุดการคำนวณ"
                    name="total_fine_due"
                    format="dd/MM/yyyy"
                    value-format="dd-MM-yyyy"
                    >
                </el-date-picker>
            </div>
            <div class="col-md-4">
                <label> เลขที่ใบสั่งซื้อ </label>
                <el-select class="required w-100" placeholder="เลขที่ใบสั่งซื้อ"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :value="form.order_number"
                    @change="(value)=>{
                        form.order_number = value
                        getParam();
                    }">
                    <el-option
                        v-for="order in sortArrays(inputParams.order_number_list)"
                        :key="order.value"
                        :label="order.value"
                        :value="order.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-3">
                <label> แสดงเฉพาะรายการที่มีค่าปรับ เท่านั้น </label><br>
                <input type="checkbox" name="fine_flag" v-model="form.fine_flag">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> เลขที่ใบ SA </label>
                <el-select class="required w-100" placeholder="เลขที่ใบ SA"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :value="form.sa_number"
                    @change="(value)=>{
                        form.sa_number = value
                        getParam();
                    }">
                    <el-option
                        v-for="sa in sortArrays(inputParams.sa_number_list)"
                        :key="sa.value"
                        :label="sa.value"
                        :value="sa.value">
                    </el-option>
                </el-select>
                
            </div>
            <div class="col-md-4">
                <label> วันครบกำหนดชำระ </label>
                <el-date-picker 
                    v-model="form.due_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันครบกำหนดชำระ"
                    name="due_date"
                    format="dd/MM/yyyy"
                    value-format="dd-MM-yyyy"
                    >
                </el-date-picker>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> เลขที่ใบ PI </label>
                <el-select class="required w-100" placeholder="เลขที่ใบ PI"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :value="form.pi_number"
                    @change="(value)=>{
                        form.pi_number = value
                        getParam();
                    }">
                    <el-option
                        v-for="pi in sortArrays(inputParams.pi_number_list)"
                        :key="pi.value"
                        :label="pi.value"
                        :value="pi.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> เลขที่ Invoice </label>
                <el-select class="required w-100" placeholder="เลขที่ Invoice"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :value="form.invoice_no"
                    @change="(value)=>{
                        form.invoice_no = value
                        getParam();
                    }">
                    <el-option
                        v-for="invoice in sortArrays(inputParams.invoice_no_list)"
                        :key="invoice.value"
                        :label="invoice.value"
                        :value="invoice.value">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> ลูกค้า </label>
                <el-select class="required w-100" placeholder="ลูกค้า"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :value="form.customer_id"
                    @change="(value)=>{
                        form.customer_id = value
                        getParam();
                        getCustomerDetail();
                    }">
                    <el-option
                        v-for="customer in inputParams.customer_list"
                        :key="customer.customer_id"
                        :label="customer.customer_number + ' : ' + customer.customer_name"
                        :value="customer.customer_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ประเทศ </label>
                <el-input v-model="form.country_name" disabled></el-input>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <label>&nbsp;</label>
                <div>
                    <button type="button" class="btn btn-sm btn-default" @click="searchForm" >
                        คำนวณค่าปรับ
                    </button>
                    <a :href="this.search_data.search_url" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-undo"></i> ล้างข้อมูล </a>
                </div>
            </div>
        </div>


        <input type="hidden" name="order_number"   :value="form.order_number">
        <input type="hidden" name="sa_number"      :value="form.sa_number">
        <input type="hidden" name="pi_number"      :value="form.pi_number">
        <input type="hidden" name="invoice_no"     :value="form.invoice_no">
        <input type="hidden" name="customer_id"    :value="form.customer_id">
        <input type="hidden" name="check_search"   :value="check_search">

        <input type="hidden" name="due_date"       :value="form.due_date">
        <input type="hidden" name="total_fine_due" :value="form.total_fine_due">
    </form>
</template>

<script>
import moment from "moment";

export default {
    props:['search_data', 'trans_btn'],
    data() {
        return {
            loading: false,
            inputParams: {
                order_number_list:  [],
                sa_number_list:     [],
                pi_number_list:     [],
                invoice_no_list:    [],
                customer_list:      [],
            },
            form: {
                order_number:    null,
                sa_number:       null,
                pi_number:       null,
                invoice_no:      null,
                customer_id:     null,
                total_fine_due:  null,
                due_date:        null,
                fine_flag:       null,
                country_name:    null,
            },

            check_search:   true,
        }
    },
    mounted() {
        this.autoLoad();
    },
    methods: {
        async autoLoad() {
            let vm                   = this;

            vm.form.order_number     = (vm.search_data.order_number != '') ? vm.search_data.order_number         : null,
            vm.form.sa_number        = (vm.search_data.sa_number != '')    ? vm.search_data.sa_number            : null,
            vm.form.pi_number        = (vm.search_data.pi_number != '')    ? vm.search_data.pi_number            : null,
            vm.form.invoice_no       = (vm.search_data.invoice_no != '')   ? vm.search_data.invoice_no           : null,
            vm.form.customer_id      = vm.search_data.customer_id          ? Number(vm.search_data.customer_id)  : null,

            vm.form.total_fine_due   = vm.search_data.check_search         ? vm.search_data.total_fine_due       : moment(new Date()).format('DD-MM-YYYY'),
            vm.form.due_date         = (vm.search_data.due_date != '')     ? vm.search_data.due_date             : null,
            vm.form.fine_flag        = vm.search_data.fine_flag            ? true                                : false,        

            vm.getParam();
        },
        async searchForm() {
            $( "#searchForm" ).submit();
        },
        async clearForm() {
            this.form.order_number   = null;
            this.form.sa_number      = null;
            this.form.pi_number      = null;
            this.form.invoice_no     = null;
            this.form.customer_id    = null;

            this.getParam();
        },
        async getParam() {
            let vm = this;
            vm.loading = true;

            let params = {
                action:            'search_get_param',
                order_number:       vm.form.order_number,
                sa_number:          vm.form.sa_number,
                pi_number:          vm.form.pi_number,
                invoice_no:         vm.form.invoice_no,
                customer_id:        vm.form.customer_id,
            }

            axios.get(vm.search_data.search_url, { params }).then(res => {
                let response = res.data;
                vm.loading = false;
                vm.inputParams.order_number_list    = response.order_number_list;
                vm.inputParams.sa_number_list       = response.sa_number_list;
                vm.inputParams.pi_number_list       = response.pi_number_list;
                vm.inputParams.invoice_no_list      = response.invoice_no_list;
                vm.inputParams.customer_list        = response.customer_list;
            });
        },
        sortArrays(arrays) {
            return _.orderBy(arrays, 'value', 'asc');
        },
        async getCustomerDetail(){
            
            this.form.country_name = '';

            this.selectedData = this.inputParams.customer_list.find( i => {
                return i.customer_id == this.form.customer_id;
            });

            if (this.selectedData) {
                // ประเทศ
                this.form.country_name = this.selectedData.country_name;
            }
        },
    }
}
</script>