<div class="ibox float-e-margins mb-2">
    <div class="ibox-content tw-border-b">
        <h5>หนี้ค้างชำระ</h5>
        <hr>
        <div class="row">
            {{-- <div class="col-lg-1"></div> --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">รหัสลูกค้า</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="customer_id" :value="customer_id">
                        <el-select class="required w-100" v-model="customer_id" placeholder="รหัสลูกค้า" @change="getCustomerName()"
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
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">วันที่ครบกำหนดชำระ</label>
                    <div class="col-sm-8">
                        <datepicker-th
                            style="width: 100%;"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="date_selected"
                            placeholder="วันที่ครบกำหนดชำระ"
                            v-model="date_selected"
                            format="DD/MM/YYYY"
                            >
                        </datepicker-th>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">ประเภทลูกค้า</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="customer_type" :value="customer_type">
                        <el-select class="required w-100" v-model="customer_type" placeholder="ประเภทลูกค้า"
                            filterable
                            remote
                            reserve-keyword
                            clearable>
                            <el-option
                                v-for="(customerType, key) in customerTypes"
                                :key="key"
                                :label="customerType.meaning"
                                :value="customerType.customer_type">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">วันส่งประจำสัปดาห์</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="weekly_delivery_day" :value="weekly_delivery_day">
                        <el-select class="required w-100" v-model="weekly_delivery_day" placeholder="วันส่งประจำสัปดาห์"
                            filterable
                            remote
                            reserve-keyword
                            clearable>
                            <el-option
                                v-for="day in days"
                                :key="day.meaning"
                                :label="day.meaning"
                                :value="day.meaning">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">กลุ่มเงินเชื่อ</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="credit_group_code" :value="credit_group_code">
                        <el-select class="required w-100" v-model="credit_group_code" placeholder="กลุ่มเงินเชื่อ"
                            filterable
                            remote
                            reserve-keyword
                            clearable>
                            <el-option
                                v-for="(creditGroup, key) in creditGroups"
                                :key="key"
                                :label="creditGroup.description"
                                :value="creditGroup.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="check_search" v-model="check_search">
        </div>
        <div class="row" style="text-align: center;">
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-lg-5"></div>
                    <div class="form-group pl-2 pr-2 mb-0 mt-2">
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                        </button>
        
                        {{-- <button class="btn btn-danger btn-sm" @click.prevent="getData"> <i class="fa fa-undo"></i> </button> --}}
                        {{-- <button class="btn btn-primary btn-sm" @click.prevent="getData"> <i class="fa fa-search"></i> ค้นหา </button> --}}
                        <a href="{{ route('om.outstanding.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-undo"></i> ล้างข้อมูล </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('om.outstanding._table') --}}
    </div>
</div>
