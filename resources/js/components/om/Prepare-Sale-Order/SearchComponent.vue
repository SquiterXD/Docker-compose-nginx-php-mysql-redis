<template>
    <div v-loading="">
        <div class="card">
            <div class="card-body pt-3 pl-1">
                <form id="search-form" :action="url.search">
                    <div v-if="type=='domestic'" class="row col-12">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> วันที่ส่ง จากวันที่ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" :value="delivery_start_date" name="search[delivery_start_date]">
                                <datepicker-th
                                    :om-type="type"
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    id="order_start_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="delivery_start_date"
                                    v-model="delivery_start_date"
                                    format="DD/MM/YYYY"
                                    :disabled="isDisableSelDate"
                                    @dateWasSelected="dateDeliveryFrom"
                                />
                                <div id="el_explode_month" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> ถึงวันที่ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" :value="delivery_end_date" name="search[delivery_end_date]">
                                <datepicker-th
                                    :om-type="type"
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    id="delivery_end_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="delivery_end_date"
                                    v-model="delivery_end_date"
                                    format="DD/MM/YYYY"
                                    :disabled="isDisableSelDate"
                                    :disabled-date-to="delivery_start_date"
                                    @dateWasSelected="dateDeliveryTo"
                                />
                                <div id="el_explode_month" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div v-if="type == 'domestic'" class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> สถานะใบเตรียมขาย :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[prepare_so_status]" :value="prepare_so_status">
                                <el-select v-model="prepare_so_status" style="width: 100%" size="large" placeholder="สถานะใบเตรียมขาย" clearable filterable>
                                    <el-option
                                       v-for="(val, index) in status"
                                        :key="val"
                                        :label="val"
                                        :value="val"
                                    >
                                    </el-option>
                                </el-select>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div v-if="type=='domestic'" class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> วันส่งประจำสัปดาห์ :</label>
                            <div class="input-icon">
                                <input type="hidden" :value="delivery_date" name="search[delivery_date]">
                                <input type="hidden" name="search[type]" :value="type">
                                <el-select v-model="delivery_date" style="width: 100%" size="large" placeholder="วันส่งประจำสัปดาห์" filterable>
                                    <el-option
                                       v-for="date in deliveryDate"
                                        :key="date"
                                        :label="date"
                                        :value="date"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <!-- show/hide --> 
                        <!-- :class="search != null? 'row collapse show': 'row collapse'" -->
                        <!-- <div class="row collapse" id="search_domestic">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> วันที่สั่ง จากวันที่ :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" :value="order_start_date" name="search[order_start_date]">
                                    <datepicker-th
                                        :om-type="type"
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2 approve_date"
                                        id="order_start_date"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="order_start_date"
                                        v-model="order_start_date"
                                        format="DD/MM/YYYY"
                                        :disabled="isDisableSelDate"
                                        @dateWasSelected="dateOrderFrom"
                                    />
                                    <div id="el_explode_month" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> ถึงวันที่ :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" :value="order_end_date" name="search[order_end_date]">
                                    <datepicker-th
                                        :om-type="type"
                                        style="width: 100%;"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        id="order_end_date"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="order_end_date"
                                        v-model="order_end_date"
                                        format="DD/MM/YYYY"
                                        :disabled="isDisableSelDate"
                                        :disabled-date-to="order_start_date"
                                        @dateWasSelected="dateOrderTo"
                                    />
                                    <div id="el_explode_month" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div v-if="type == 'domestic'" class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> ปีงบ / งวด :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" name="search[period_id]" :value="period_id">
                                    <input type="hidden" name="search[period_name]" :value="period_name">
                                    <InputValue
                                        @def="getDefaultData"
                                        set-name="period"
                                        :set-data="period_name"
                                        placeholder="ปีงบ / งวด"
                                        :set-options="periodLists"
                                        :url="url.ajax_get_period"
                                        :type="type"
                                        :depend-cust="customer_id"
                                    >
                                    </InputValue>

                                    <div id="el_explode_so_no" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> ลูกค้า :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" name="search[customer_id]" :value="customer_id">
                                    <input type="hidden" name="search[customer_no]" :value="customer_no">
                                    <CustInputValue
                                        @def="getDefaultData"
                                        set-name="customer"
                                        :set-data="customer_no"
                                        placeholder="ลูกค้า"
                                        :set-options="customerLists"
                                        :url="url.ajax_get_customer"
                                        :type="type"
                                        :depend-cust="customer_id"
                                    >
                                    </CustInputValue>
                                    <div id="el_explode_so_no" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> เลขที่ใบสั่งซื้อ :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" name="search[type]" :value="type">
                                    <input type="hidden" name="search[so_no]" :value="so_no">
                                    <InputValue
                                        @def="getDefaultData"
                                        set-name="so"
                                        :set-data="so_no"
                                        placeholder="เลขที่ใบสั่งซื้อ"
                                        :set-options="orderLists"
                                        :url="url.ajax_get_so"
                                        :type="type"
                                        :depend-cust="customer_id"
                                    >
                                    </InputValue>
                                    <div id="el_explode_so_no" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div v-if="type == 'domestic'" class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> เลขที่ใบเตรียมขาย :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" name="search[prepare_so_no]" :value="prepare_so_no">
                                    <InputValue
                                        @def="getDefaultData"
                                        set-name="prepare_so"
                                        :set-data="prepare_so_no"
                                        placeholder="เลขที่ใบเตรียมขาย"
                                        :set-options="prepareOrderLists"
                                        :url="url.ajax_get_prepare_so"
                                        :type="type"
                                        :depend-cust="customer_id"
                                    >
                                    </InputValue>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> ประเภทการจ่ายเงิน :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" name="search[payment_type]" :value="payment_type">
                                    <el-select v-model="payment_type" style="width: 100%" size="large" placeholder="สถานะใบเตรียมขาย" clearable filterable>
                                        <el-option
                                           v-for="(type, index) in paymentTypes"
                                            :key="index"
                                            :label="type.meaning"
                                            :value="type.lookup_code"
                                        >
                                        </el-option>
                                    </el-select>
                                    <div id="el_explode_so_no" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> ประเภทคำสั่งซื้อ :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" name="search[order_type_id]" :value="order_type_id">
                                    <input type="hidden" name="search[order_type_name]" :value="order_type_name">
                                    <InputValue
                                        @def="getDefaultData"
                                        set-name="order_type"
                                        :set-data="order_type_name"
                                        placeholder="ประเภทคำสั่งซื้อ"
                                        :set-options="orderTypeLists"
                                        :url="url.ajax_get_order_type"
                                        :type="type"
                                        :depend-cust="customer_id"
                                    >
                                    </InputValue>
                                    <div id="el_explode_so_no" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div v-if="type=='domestic'" class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-uppercase mb-1"> วันส่งประจำสัปดาห์ :</label>
                                <div class="iinput-icon">
                                    <input type="hidden" :value="delivery_date" name="search[delivery_date]">
                                    <el-select v-model="delivery_date" style="width: 100%" size="large" placeholder="วันส่งประจำสัปดาห์" filterable>
                                        <el-option
                                           v-for="date in deliveryDate"
                                            :key="date"
                                            :label="date"
                                            :value="date"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div> -->
                        <!-- end show/hide -->

                        <!-- <div class="form-group text-center pr-2 mb-0 mt-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a v-if="showFlag"
                                data-toggle="collapse" 
                                href="#search_domestic"
                                @click.prevent="showFlag = false"
                            > <i class="fa fa fa-chevron-circle-up mr-0" style="font-size: 25px;"></i> &nbsp; น้อยลง </a>
                            <a v-else
                                data-toggle="collapse"
                                href="#search_domestic"
                                @click.prevent="showFlag = true"
                            > <i class="fa fa-chevron-circle-down mr-0" style="font-size: 25px;"></i> &nbsp; เพิ่มเติม </a>
                        </div> -->

                        <div class="form-group text-center pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label class=" tw-uppercase m-0">&nbsp;</label>
                            <div class="text-center">
                                <button type="button" @click.prevent="searchForm" class="btn btn-primary tw-w-25" >
                                    <i :class="btnTrans.search.icon"></i>
                                    {{ btnTrans.search.text }}
                                </button>
                                <a :href="url.search+'?type='+type" class="btn btn-white tw-w-25">
                                    <i class="fa fa-refresh"></i>
                                    ล้างข้อมูล
                                </a>
                            </div>
                            <small class="font-bold">
                                &nbsp;
                            </small>
                        </div>
                    </div> <!-- end row -->

                    <div v-else class="row col-12">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> เลขที่ใบสั่งซื้อ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[type]" :value="type">
                                <input type="hidden" name="search[so_no]" :value="so_no">
                                <InputValue
                                    @def="getDefaultData"
                                    set-name="so"
                                    :set-data="so_no"
                                    placeholder="เลขที่ใบสั่งซื้อ"
                                    :set-options="orderLists"
                                    :url="url.ajax_get_so"
                                    :type="type"
                                    :depend-cust="customer_id"
                                >
                                </InputValue>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> วันที่สั่ง จากวันที่ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" :value="order_start_date" name="search[order_start_date]">
                                <datepicker-en
                                    :om-type="type"
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2 approve_date"
                                    id="order_start_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="order_start_date"
                                    v-model="order_start_date"
                                    format="DD/MM/YYYY"
                                    :disabled="isDisableSelDate"
                                    @dateWasSelected="dateOrderFrom"
                                />
                                <div id="el_explode_month" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> ถึงวันที่ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" :value="order_end_date" name="search[order_end_date]">
                                <datepicker-en
                                    :om-type="type"
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    id="order_end_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="order_end_date"
                                    v-model="order_end_date"
                                    format="DD/MM/YYYY"
                                    :disabled="isDisableSelDate"
                                    :disabled-date-to="order_start_date"
                                    @dateWasSelected="dateOrderTo"
                                />
                                <div id="el_explode_month" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> เลขที่ใบ SA :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[sa_no]" :value="sa_no">
                                <InputValue
                                    @def="getDefaultData"
                                    set-name="sa"
                                    :set-data="sa_no"
                                    placeholder="เลขที่ใบ SA"
                                    :set-options="prepareOrderLists"
                                    :url="url.ajax_get_prepare_so"
                                    :type="type"
                                    :depend-cust="customer_id"
                                >
                                </InputValue>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> วันที่ส่ง จากวันที่ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" :value="delivery_start_date" name="search[delivery_start_date]">
                                <datepicker-en
                                    :om-type="type"
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    id="order_start_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="delivery_start_date"
                                    v-model="delivery_start_date"
                                    format="DD/MM/YYYY"
                                    :disabled="isDisableSelDate"
                                    @dateWasSelected="dateDeliveryFrom"
                                />
                                <div id="el_explode_month" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> ถึงวันที่ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" :value="delivery_end_date" name="search[delivery_end_date]">
                                <datepicker-en
                                    :om-type="type"
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    id="delivery_end_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :value="delivery_end_date"
                                    v-model="delivery_end_date"
                                    format="DD/MM/YYYY"
                                    :disabled="isDisableSelDate"
                                    :disabled-date-to="delivery_start_date"
                                    @dateWasSelected="dateDeliveryTo"
                                />
                                <div id="el_explode_month" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> เลขที่ใบ PI :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[pi_id]" :value="pi_id">
                                <input type="hidden" name="search[pi_no]" :value="pi_no">
                                <InputValue
                                    @def="getDefaultData"
                                    set-name="pi"
                                    :set-data="pi_no"
                                    placeholder="เลขที่ใบ PI"
                                    :set-options="piLists"
                                    :url="url.ajax_get_pi"
                                    :type="type"
                                    :depend-cust="customer_id"
                                >
                                </InputValue>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> เลขที่ใบ Invoice :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[invoice_no]" :value="invoice_no">
                                <InputValue
                                    @def="getDefaultData"
                                    set-name="invoice"
                                    :set-data="invoice_no"
                                    placeholder="เลขที่ใบ Invoice"
                                    :set-options="invoiceLists"
                                    :url="url.ajax_get_invoice"
                                    :type="type"
                                    :depend-cust="customer_id"
                                >
                                </InputValue>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> ประเภทการจ่ายเงิน :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[payment_type]" :value="payment_type">
                                <el-select v-model="payment_type" style="width: 100%" size="large" placeholder="สถานะใบเตรียมขาย" clearable filterable>
                                    <el-option
                                       v-for="(type, index) in paymentTypes"
                                        :key="index"
                                        :label="type.meaning"
                                        :value="type.lookup_code"
                                    >
                                    </el-option>
                                </el-select>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> ลูกค้า :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[customer_id]" :value="customer_id">
                                <input type="hidden" name="search[customer_no]" :value="customer_no">
                                <CustInputValue
                                    @def="getDefaultData"
                                    set-name="customer"
                                    :set-data="customer_no"
                                    placeholder="ลูกค้า"
                                    :set-options="customerLists"
                                    :url="url.ajax_get_customer"
                                    :type="type"
                                    :depend-cust="customer_id"
                                >
                                </CustInputValue>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <span> &nbsp; <br></span>
                            <div class="iinput-icon p-1">
                                <input type="text" class="form-control" disabled :value="customer_name">
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                            <label class="text-left tw-uppercase mb-1"> ประเภทคำสั่งซื้อ :</label>
                            <div class="iinput-icon">
                                <input type="hidden" name="search[order_type_id]" :value="order_type_id">
                                <input type="hidden" name="search[order_type_name]" :value="order_type_name">
                                <InputValue
                                    @def="getDefaultData"
                                    set-name="order_type"
                                    :set-data="order_type_name"
                                    placeholder="ประเภทคำสั่งซื้อ"
                                    :set-options="orderTypeLists"
                                    :url="url.ajax_get_order_type"
                                    :type="type"
                                    :depend-cust="customer_id"
                                >
                                </InputValue>
                                <div id="el_explode_so_no" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="form-group text-right pr-2 mb-0 col-lg-12 col-md-10 col-sm-12 col-xs-12">
                            <label class=" tw-uppercase mt-2">&nbsp;</label>
                            <div class="text-center">
                                <button type="button" @click.prevent="searchForm" class="btn btn-primary tw-w-25" >
                                    <i :class="btnTrans.search.icon"></i>
                                    {{ btnTrans.search.text }}
                                </button>
                                <a :href="url.search+'?type='+type" class="btn btn-white tw-w-25">
                                    <i class="fa fa-refresh"></i>
                                    ล้างข้อมูล
                                </a>
                            </div>
                            <small class="font-bold">
                                &nbsp;
                            </small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
    import moment from "moment";
    import InputValue  from './InputValueComponent.vue';
    import CustInputValue  from './CustomerInputValueComponent.vue';
    export default {
        components: {
            InputValue, CustInputValue
        },
        props:['type', 'paymentTypes', 'status', 'url', 'search', 'dateFormat', 'btnTrans', 'deliveryDate'],
        data() {
            return {
                // List Data
                orderLists: [],
                prepareOrderLists: [], // prepare no, sa no ใช้ฟังก์ชัน เดียวกัน
                periodLists: [],
                piLists: [],
                invoiceLists: [],
                customerLists: [],
                orderTypeLists: [],
                //----------------------
                // so = sale order
                so_no: this.search && this.search['so_no'] != null? this.search['so_no']: '',
                prepare_so_no: this.search && this.search['prepare_so_no'] != null? this.search['prepare_so_no']: '',
                sa_no: this.search && this.search['sa_no'] != null? this.search['sa_no']: '',
                pi_id: this.search && this.search['pi_id'] != null? this.search['pi_id']: '',
                pi_no: this.search && this.search['pi_no'] != null? this.search['pi_no']: '',
                invoice_no: this.search && this.search['invoice_no'] != null? this.search['invoice_no']: '',
                period_id: this.search && this.search['period_id'] != null? this.search['period_id']: '',
                period_name: this.search && this.search['period_name'] != null? this.search['period_name']: '',
                customer_id: this.search && this.search['customer_id'] != null? this.search['customer_id']: '',
                customer_no: this.search && this.search['customer_no'] != null? this.search['customer_no']: '',
                customer_name: '',
                payment_type: this.search && this.search['payment_type'] != null? this.search['payment_type']: '',
                order_type_id: this.search && this.search['order_type'] != null? this.search['order_type']: '',
                order_type_name: this.search && this.search['order_type_name'] != null? this.search['order_type_name']: '',
                order_start_date: this.search && this.search['order_start_date'] != null? this.search['order_start_date']: '',
                order_end_date: this.search && this.search['order_end_date'] != null? this.search['order_end_date']: '',
                delivery_start_date: this.search && this.search['delivery_start_date'] != null? this.search['delivery_start_date']: '',
                delivery_end_date: this.search && this.search['delivery_end_date'] != null? this.search['delivery_end_date']: '',
                prepare_so_status: this.search && this.search['prepare_so_status'] != null? this.search['prepare_so_status']: (this.search && this.search['prepare_so_status'] == null? '' :'Draft'),
                delivery_date: this.search && this.search['delivery_date'] != null? this.search['delivery_date']: '',
                isDisableSelDate: false,
                loading: {
                    form: false,
                    so: false,
                    prepare_so: false,
                    period: false,
                    pi: false,
                    invoice: false,
                    customer: false,
                    order_type: false
                },
                pickerOptionsOrder: {
                    disabledDate(time) {
                        return time.getTime() > moment(this.disabledDateTo, 'DD-MM-YYYY').toDate();
                    },
                },
                disabledDate: (order_start_date, order_end_date) => {
                    if(!order_start_date){ return }
                    return order_start_date < moment(order_start_date, 'DD-MM-YYYY').toDate();
                },
                // NEW REQUIRE 20220623
                showFlag: false, // this.search? true: false
            }
        },
        mounted() {
            if (this.type == 'domestic' && this.search == null) {
                var currentDate = moment().format('YYYY-MM-DD');
                this.delivery_start_date = this.changeToTh(currentDate);
                this.delivery_end_date = this.changeToTh(currentDate);
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
            orderLists(newValue){
                return  newValue;
            },
            disabledDateTo : async function (value) {
                if(await moment(value, 'DD/MM/YYYY').toDate() > this.order_end_date) {
                    this.order_end_date = null;
                }
            },
        },
        methods: {
            async getSoLists(query) {
                this.loading.so = true;
                await axios.get("/om/prepare-sale-orders/ajax/get-so-lists", {
                    params: {
                        type: this.type,
                        set_data: this.so_no,
                        depend_cust: this.customer_id,
                        query: query,
                    }
                })
                .then(res => {
                console.log(res.data);
                    this.orderLists = res.data;
                })
                .catch(err => {
                    console.log(err)
                })
                .then( () => {
                    this.loading.so = false;
                });
            },
            async getPrepareSOLists(query) {
                this.loading.prepare_so = true;
                await axios.get("/om/prepare-sale-orders/ajax/get-prepare-so-lists", {
                    params: {
                        type: this.type,
                        set_data: this.prepare_so_no ?? this.sa_no,
                        depend_cust: this.customer_id,
                        query: query,
                    }
                })
                .then(res => {
                    this.prepareOrderLists = res.data;
                })
                .catch(err => {
                    console.log(err)
                })
                .then( () => {
                    this.loading.prepare_so = false;
                });
            },
            async searchForm(){
                var form  = $('#search-form');
                let inputs = form.serialize();
                this.loading = true;
                form.submit();
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea 
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            dateOrderFrom(dateFrom){
                this.order_start_date = dateFrom? moment(dateFrom).format(this.dateFormat): '';
                this.order_end_date = dateFrom? moment(dateFrom).format(this.dateFormat): '';
            },
            dateOrderTo(dateTo){
                this.order_end_date = dateTo? moment(dateTo).format(this.dateFormat): '';
            },
            dateDeliveryFrom(dateFrom){
                this.delivery_start_date = dateFrom? moment(dateFrom).format(this.dateFormat): '';
                this.delivery_end_date = dateFrom? moment(dateFrom).format(this.dateFormat): '';
            },
            dateDeliveryTo(dateTo){
                this.delivery_end_date = dateTo? moment(dateTo).format(this.dateFormat): '';
            },
            getDefaultData(res){
                if (res.name == 'period') {
                    this.period_id = res.value_id;
                    this.period_name = res.value;
                    this.periodLists = res.options;
                }
                if (res.name == 'pi') {
                    this.pi_id = res.value_id;
                    this.pi_no = res.value;
                    this.piLists = res.options;
                }
                if (res.name == 'invoice') {
                    this.invoice_no = res.value;
                    this.invoiceLists = res.options;
                }
                if (res.name == 'customer') {
                    this.customer_id = res.value_id;
                    this.customer_no = res.value;
                    this.customer_name = res.value_name;
                    this.customerLists = res.options;
                    this.getSoLists();
                    this.getPrepareSOLists();
                }
                if (res.name == 'order_type') {
                    this.order_type_id = res.value_id;
                    this.order_type_name = res.value;
                    this.orderTypeLists = res.options;
                }
                if (res.name == 'so') {
                    this.so_no = res.value;
                    this.orderLists = res.options;
                }
                if (res.name == 'prepare_so') {
                    this.prepare_so_no = res.value;
                    this.prepareOrderLists = res.options;
                }
                if (res.name == 'sa') {
                    this.sa_no = res.value;
                    this.prepareOrderLists = res.options;
                }
            },
            changeToTh(date){
                var vm = this;
                var dateTh = '';
                if (date) { dateTh = moment(date).add(543, 'year').format('DD-MM-YYYY'); }
                return dateTh;
            },
        }
    }
</script>