<div class="ibox float-e-margins mb-2">
    <div class="ibox-title">
        <div class="row">
            <div class="col-6">
                <h3 class="no-margins"> ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ </h3>
            </div>
        </div>
    </div>
    <div class="ibox-content tw-border-b">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุดการคำนวณ </label>
                <el-date-picker 
                    v-model="total_fine_due"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุดการคำนวณ"
                    name="total_fine_due"
                    format="DD/MM/yyyy"
                    >
                </el-date-picker>
            </div>
            <div class="col-md-4">
                <label> เลขที่ใบสั่งซื้อ </label>
                
                <div v-if="this.orderNumberList.length > 0">
                    <input type="hidden" name="order_number" :value="order_number">
                    <el-select class="required w-100" v-model="order_number" placeholder="เลขที่ใบสั่งซื้อ"
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        :disabled="this.checkCustomer">
                        <el-option
                            v-for="order in sortArrays(orderNumberList)"
                            :key="order.value"
                            :label="order.value"
                            :value="order.value">
                        </el-option>
                    </el-select>
                </div>
                <div v-else>
                    <input type="hidden" name="order_number" :value="order_number">
                    <el-select class="required w-100" v-model="order_number" placeholder="เลขที่ใบสั่งซื้อ"
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        :disabled="this.checkCustomer">
                        <el-option
                            v-for="order in sortArrays(orderNumbers)"
                            :key="order.value"
                            :label="order.value"
                            :value="order.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="col-md-3">
                <label> แสดงเฉพาะรายการที่มีค่าปรับ เท่านั้น </label><br>
                <input type="checkbox" name="fine_flag" v-model="fine_flag">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> เลขที่ใบ SA </label>
                <div v-if="this.saNumberList.length > 0">
                    <input type="hidden" name="sa_number" :value="sa_number">
                    <el-select class="required w-100" v-model="sa_number" placeholder="เลขที่ใบ SA"
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        :disabled="this.checkCustomer">
                        <el-option
                            v-for="sa in sortArrays(saNumberList)"
                            :key="sa.value"
                            :label="sa.value"
                            :value="sa.value">
                        </el-option>
                    </el-select>
                </div>
                <div v-else>
                    <input type="hidden" name="sa_number" :value="sa_number">
                    <el-select class="required w-100" v-model="sa_number" placeholder="เลขที่ใบ SA"
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        :disabled="this.checkCustomer">
                        <el-option
                            v-for="sa in sortArrays(saNumbers)"
                            :key="sa.value"
                            :label="sa.value"
                            :value="sa.value">
                        </el-option>
                    </el-select>
                </div>
                
            </div>
            <div class="col-md-4">
                <label> วันครบกำหนดชำระ </label>
                <el-date-picker 
                    v-model="due_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันครบกำหนดชำระ"
                    name="due_date"
                    format="DD/MM/yyyy"
                    >
                </el-date-picker>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> เลขที่ใบ PI </label>
                <input type="hidden" name="pi_number" :value="pi_number">
                <el-select class="required w-100" v-model="pi_number" placeholder="เลขที่ใบ PI"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :disabled="this.checkCustomer">
                    <el-option
                        v-for="pi in sortArrays(piNumbers)"
                        :key="pi.value"
                        :label="pi.value"
                        :value="pi.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> เลขที่ Invoice </label>
                <input type="hidden" name="invoice_no" :value="invoice_no">
                <el-select class="required w-100" v-model="invoice_no" placeholder="เลขที่ Invoice"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :disabled="this.checkCustomer">
                    <el-option
                        v-for="invoice in sortArrays(invoices)"
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
                <input type="hidden" name="customer_id" :value="customer_id">
                <el-select class="required w-100" v-model="customer_id" placeholder="ลูกค้า"  @change="getCustomerDetail(); getDataFilter();"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :disabled="this.checkCustomer">
                    <el-option
                        v-for="customer in customers"
                        :key="customer.customer_id"
                        :label="customer.customer_number + ' : ' + customer.customer_name"
                        :value="customer.customer_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ประเทศ </label>
                <el-input v-model="country_name" disabled></el-input>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <input type="hidden" name="check_search" :value="check_search">
                <button class="btn btn-sm btn-default" type="submit"> คำนวณค่าปรับ </button>
            </div>
        </div>
    </div>
</div>