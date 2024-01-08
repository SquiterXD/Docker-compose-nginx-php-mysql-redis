<div class="ibox float-e-margins mb-2">
    <div class="ibox-title">
        <div class="row">
            <div class="col-3">
                <h3 class="no-margins"> ปรับปรุงค่าปรับยาสูบ </h3>
            </div>
            {{-- <div class="col-9 text-right">
                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
            </div> --}}
        </div>
    </div>
    <div class="ibox-content tw-border-b">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุดการคำนวณ </label>
                {{-- <el-date-picker 
                    v-model="total_fine_due"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุดการคำนวณ"
                    name="total_fine_due"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker> --}}
                <input type="hidden" name="total_fine_due" :value="total_fine_due">
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="total_fine_due"
                    placeholder="วันที่สิ้นสุดการคำนวณ"
                    v-model="total_fine_due"
                    format="DD/MM/YYYY"
                    value-format="dd-MM-yyyy"
                    >
                </datepicker-th>
            </div>
            <div class="col-md-4">
                <label> วันครบกำหนดชำระ </label>
                {{-- <el-date-picker 
                    v-model="due_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันครบกำหนดชำระ"
                    name="due_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker> --}}
                <input type="hidden" name="due_date" :value="due_date">
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="due_date"
                    placeholder="วันที่ครบกำหนดชำระ"
                    v-model="due_date"
                    format="DD/MM/YYYY"
                    value-format="dd-MM-yyyy"
                    >
                </datepicker-th>
            </div>
            <div class="col-md-3">
                <label> แสดงเฉพาะรายการที่มีค่าปรับ เท่านั้น </label><br>
                <input type="checkbox" name="fine_flag" v-model="fine_flag">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> เลขที่ Invoice </label>
                <input type="hidden" name="invoice_no" :value="invoice_no">
                <el-select class="required w-100" v-model="invoice_no" placeholder="เลขที่ Invoice" @change="getInvoiceDetail()"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :disabled="this.checkCustomer"
                    :remote-method="getInvoiceList">
                    <el-option
                        v-for="invoice in sortArrays(invoiceLists)"
                        :key="invoice.invoice_no"
                        :label="invoice.invoice_no"
                        :value="invoice.invoice_no">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> วันที่ Invoice </label>
                {{-- <el-date-picker 
                    v-model="invoice_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่ Invoice"
                    name="invoice_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker> --}}
                <input type="hidden" name="invoice_date" :value="invoice_date">
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="invoice_date"
                    placeholder="วันที่ Invoice"
                    v-model="invoice_date"
                    format="DD/MM/YYYY"
                    value-format="dd-MM-yyyy"
                    :disabled="this.invoiceDateDisabled"
                    >
                </datepicker-th>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <label> ชื่อลูกค้า <span class="text-danger">*</span></label>
                <input type="hidden" name="customer_id" :value="customer_id">
                <el-select class="required w-100" v-model="customer_id" placeholder="ลูกค้า"  @change="getCustomerDetail()"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :disabled="this.checkCustomer"
                    :remote-method="getCustomerList">
                    <el-option
                        v-for="customer in customerLists"
                        :key="customer.customer_id"
                        :label="customer.customer_number + ' : ' + customer.customer_name"
                        :value="customer.customer_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> จังหวัด </label>
                <el-input v-model="province_name" disabled></el-input>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                {{-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> คำนวณค่าปรับ </button> --}}
                {{-- <button type="button" class="btn btn-w-m btn-default" @click.prevent="onShowDetailClicked">
                    คำนวณค่าปรับ
                </button> --}}
                <button class="btn btn-sm btn-default" type="submit"> คำนวณค่าปรับ </button>
                <a href="{{ route('om.improve-fine.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-undo"></i> ล้างข้อมูล </a>
            </div>
        </div>
    </div>
</div>