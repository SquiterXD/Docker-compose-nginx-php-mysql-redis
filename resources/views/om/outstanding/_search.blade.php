<div class="ibox float-e-margins mb-2">
    <div class="ibox-content tw-border-b">
        <h5>หนี้ค้างชำระ</h5>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-lg-2"></div>
                    <label class="col-lg-2 col-sm-4 col-form-label text-right">รหัสลูกค้า</label>
                    <div class="col-lg-5">
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
                    {{-- <div class="col-lg-2">
                        <input type="hidden" name="customer_id" :value="customer_id">
                        <el-select class="required" v-model="customer_id" placeholder="รหัสลูกค้า" @change="getCustomerName()">
                            <el-option
                                v-for="customer in customers"
                                :key="customer.customer_id"
                                :label="customer.customer_number"
                                :value="customer.customer_id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-lg-4">
                        <el-input name="customer_name" v-model="customer_name" autocomplete="off" disabled></el-input>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-lg-2"></div>
                    <label class="col-lg-2 col-sm-4 col-form-label text-right">วันที่ครบกำหนดชำระ</label>
                    <div class="col-lg-5">
                        {{-- <el-date-picker 
                            v-model="date_selected"
                            style="width: 100%;"
                            type="date"
                            name="date_selected"
                            format="dd-MM-yyyy">
                        </el-date-picker> --}}
                        <datepicker-th
                            style="width: 100%;"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="date_selected"
                            placeholder="วันที่ครบกำหนดชำระ"
                            v-model="date_selected"
                            format="DD-MM-YYYY"
                            @dateWasSelected="fromDateWasSelected"
                            >
                        </datepicker-th>
                        {{-- <datepicker-th
                            style="width: 100%;"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="date_selected"
                            placeholder="โปรดเลือกวันที่"
                            v-model="date_selected"
                            format="DD-MM-YYYY"
                            @dateWasSelected="fromDateWasSelected">
                        </datepicker-th> --}}

                        {{-- <datepicker-th style="width: 100%" class="form-control md:tw-mb-0 tw-mb-2" name="date_selected" 
                                        id="date_selected" placeholder="โปรดเลือกวันที่" v-model="date_selected" 
                                        format="{{ trans('date.js-format') }}"> --}}
    
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align: center;">
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-lg-5"></div>
                    <div class="form-group pl-2 pr-2 mb-0 mt-2">
                        {{-- <button type="submit" class="btn btn-light btn-sm">
                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                        </button> --}}
        
                        {{-- <button class="btn btn-danger btn-sm" @click.prevent="getData"> <i class="fa fa-undo"></i> </button> --}}
                        <button class="btn btn-primary btn-sm" @click.prevent="getData"> <i class="fa fa-search"></i> ค้นหา </button>
                        <a href="{{ route('om.outstanding.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-undo"></i> ล้างข้อมูล </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ibox float-e-margins mb-2">
    <div class="ibox-content">
        @include('om.outstanding._table')
    </div>
</div>
