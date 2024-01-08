<template>
    <div class="row">
        <div class="col-sm-4" style="text-align:left;">
            <label> รหัส - ชื่อลูกค้า </label>
                <input type="hidden" name="customer_id"  :value="customer_id" autocomplete="off">
                <el-select  v-model="customer_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="customer in customers"
                                :key="customer.customer_id"
                                :label="customer.customer_number ? customer.customer_number + ' : ' + customer.customer_name : customer.customer_name"
                                :value="customer.customer_id">
                    </el-option>
                </el-select>
        </div>
        <div class="col-sm-4" style="text-align:left;">
            <label>วันที่อนุญาติให้สั่งซื้อได้</label>
            <datepicker-th
                style="width: 100%;"
                class="form-control md:tw-mb-0 tw-mb-2"
                name="allowed_order_date"
                placeholder="โปรดเลือกวันที่อนุญาติให้สั่งซื้อได้"
                v-model="allowed_order_date"
                format="DD-MM-YYYY"
                >
            </datepicker-th>
        </div>
        <div class="col-sm-2">
            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
            <div class="text-right">
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                </button>
                <a :href="this.actionUrl" class="btn btn-danger btn-sm">ล้าง</a>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: ['customers', 'actionUrl', 'defaultCustomer', 'defaultDate'],
        data() {
            return {
                customer_id: this.defaultCustomer ? Number(this.defaultCustomer) : '',
                allowed_order_date:  this.defaultDate ? this.defaultDate : '',
            }
        },
        mounted(){
            this.showDate();
        },
        methods: {
            async showDate() {
                if (this.allowed_order_date) {
                    // console.log('start_date -->' + this.start_date);
                    // console.log(moment(String(this.start_date)).format('yyyy-MM-DD'));
                    var date1 = await helperDate.parseToDateTh(this.allowed_order_date, 'yyyy-MM-DD');
                    this.allowed_order_date = date1;
                }
            },
        },
    }
</script>
