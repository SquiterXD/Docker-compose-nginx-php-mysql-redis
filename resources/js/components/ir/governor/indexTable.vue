<template>
    <div class="margin_top_20">
        
        <div>
            <table class="table table-striped table_style">
                <thead>
                <tr class="text-center">
                    <th class="text-nowrap" v-show="tableTotal.length > 0"></th>
                    <th class='text-right'>Total Premium<br>ค่าเบี้ยประกันรวม</th>
                    <th class='text-right'>Total Discount<br>ส่วนลดรวม</th>
                    <th class='text-right'>Total Duty Fee<br>อากรรวม</th>
                    <th class='text-right'>Total Vat<br>ภาษีมูลค่าเพิ่มรวม</th>
                    <th class='text-right'>Total Net Amount<br>ค่าเบี้ยประกันสุทธิรวม</th>
                    <!-- <th class='text-right'>ค่าเบี้ยประกันเรียกเก็บสุทธิรวม</th> -->
                </tr>
                </thead>
                <tbody id="table_search">
                <template v-for="(data, index) in tableTotal">
                    <tr class="text-right" :key="index">
                    <td class="text-nowrap" style="font-weight: bold;">{{ data.group_name }}</td>
                    <td>{{formatCurrency(data.premium)}}</td>
                    <td>{{formatCurrency(data.discount)}}</td>
                    <td>{{formatCurrency(data.duty_fee)}}</td>
                    <td>{{formatCurrency(data.vat)}}</td>
                    <td>{{formatCurrency(data.net_amount)}}</td>
                    <!-- <td>{{formatCurrency(data.rec_insu)}}</td> -->
                    </tr>
                    <tr class="text-right"
                    v-for="(data_rec, index_rec) in data.result_receivable"
                    :key="`rec_${index}_${index_rec}`">
                    <td colspan="6">
                        {{isNullOrUndefined(data_rec.receivable_name)}}
                    </td>
                    <td>{{isNullOrUndefined(data_rec.net_amount) || isNullOrUndefined(data_rec.net_amount) === 0 ?
                        formatCurrency(data_rec.net_amount) : isNullOrUndefined(data.net_amount)}}</td>
                    </tr>
                </template>
                <tr class="text-center" v-show="tableTotal.length === 0"><td colspan="99">ไม่มีข้อมูล</td></tr>
                </tbody>
                <tfoot></tfoot>
            </table>

            <div class='my-5'>
                <div class="col justify-content-end  padding_12 d-flex">
                    <button type="danger" class='btn btn-success m-1' @click='ClickAddRow()'><i
                        class="fa fa-plus"></i>
                        เพิ่ม
                    </button>
                </div>
            </div>

            <div>
                <div>
                    <el-form :model="dataTable"
                            ref="save_table_line_governor"
                            class="demo-dynamic form_table_line"
                            :rules='rules'>

                        <div class="table-responsive">
                            <b-table
                                table-class="table table-bordered"
                                style="display: block; overflow: auto; max-height: 500px;"
                                :busy.sync="isBusy"
                                :items="dataTable.rows"
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                :tbody-tr-class="rowClass"
                                primary-key="row_id"
                                show-empty
                                small
                                hover
                                select-mode="single"
                                selectable
                                @row-selected="onRowSelected"
                            >

                                <template #table-busy>
                                <div class="text-center text-danger my-2">
                                    <strong>Loading...</strong>
                                </div>
                                </template>

                                <template #head(selected)="header">
                                    Select All <br>
                                    <div class="form-check" style="position: inherit;">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            @click="clickSelectAll()"
                                            :name="`governor_select_all`"
                                            style='position: inherit;'
                                            :disabled="complete"
                                        >
                                    </div>
                                </template>
                                <template #head(status)="header">
                                    <div>
                                        IR status<br>สถานะ
                                    </div>
                                </template>
                                <template #head(year)="header">
                                    <div>
                                        Year<br>ปี *
                                    </div>
                                </template>
                                <template #head(policy_set_header_id)="header">
                                    <div>
                                        Policy No.<br>กรมธรรม์ชุดที่ *
                                    </div>
                                </template>
                                <template #head(invoice_number)="header">
                                    <div>
                                        Invoice number<br>เลขที่ใบแจ้งหนี้ *
                                    </div>
                                </template>
                                <template #head(policy_number)="header">
                                    <div>
                                        Policy Number<br>เลขที่กรมธรรม์
                                    </div>
                                </template>
                                <template #head(start_date)="header">
                                    <div>
                                        Start date<br>วันที่เริ่มต้นการคิดเบี้ยประกัน *
                                    </div>
                                </template>
                                <template #head(end_date)="header">
                                    <div>
                                        End date<br>วันที่สิ้นสุดการคิดเบี้ยประกัน *
                                    </div>
                                </template>
                                <template #head(total_days)="header">
                                    <div>
                                        Days<br>จำนวนวัน
                                    </div>
                                </template>
                                <template #head(person_name)="header">
                                    <div>
                                        Name<br>ชื่อ-สกุล ผู้ว่าการ *
                                    </div>
                                </template>
                                <template #head(policy_type_code)="header">
                                    <div>
                                        Governor policy type<br>ประเภทกรมธรรม์(ผู้ว่าการยาสูบ) *
                                    </div>
                                </template>
                                <template #head(insurance_amount)="header">
                                    <div>
                                        Premium<br>ค่าเบี้ยประกัน *
                                    </div>
                                </template>
                                <template #head(discount)="header">
                                    <div>
                                        Discount<br>ส่วนลด
                                    </div>
                                </template>
                                <template #head(duty_amount)="header">
                                    <div>
                                        Duty fee<br>อากร
                                    </div>
                                </template>
                                <template #head(vat_amount)="header">
                                    <div>
                                        Vat<br>ภาษีมูลค่าเพิ่ม
                                    </div>
                                </template>
                                <template #head(net_amount)="header">
                                    <div>
                                        Net amount<br>ค่าเบี้ยประกันสุทธิ
                                    </div>
                                </template>
                                <template #head(company_id)="header">
                                    <div>
                                        Company code<br>รหัสผู้รับประกันภัย *
                                    </div>
                                </template>
                                <template #head(company_name)="header">
                                    <div>
                                        Company name<br>ผู้รับประกันภัย
                                    </div>
                                </template>
                                <template #head(expense_account)="header">
                                    <div>
                                        Expense account<br>รหัสบัญชีค่าใช้จ่าย *
                                    </div>
                                </template>
                                <template #head(expense_account_desc)="header">
                                    <div>
                                        Expense account description<br>บัญชีค่าใช้จ่าย
                                    </div>
                                </template>
                                <template #head(payment_status)="header">
                                    <div>
                                        Payment status<br>สถานะการจ่ายเงิน
                                    </div>
                                </template>
                                <template #head(voucher_number)="header">
                                    <div>
                                        Voucher number<br>เลขที่ใบสำคัญ
                                    </div>
                                </template>
                                <template #head(document_number)="header">
                                    <div>
                                        Document number<br>เลขที่เอกสาร
                                    </div>
                                </template>
                                <template #head(reference_document_number)="header">
                                    <div>
                                        Reference <br>Document
                                    </div>
                                </template>
                                <template #head(remove)="header">
                                    <div>
                                        ลบ
                                    </div>
                                </template>


                                <template #cell(selected)="row">
                                    <div class="form-check" style="position: inherit;">
                                        <input  
                                        :class="`form-check-input ${isDisabled(row.item) ? 'checkbox_edit_disabled' : ''}`"
                                        type="checkbox" @click="clickSelectRow(row.item.row_id, row.item)"
                                        :name="`governor_select${row.item.row_id}`" 
                                        :value="`${row.item.row_id}`"
                                        style='position: inherit;'
                                        :checked="columnSelectedId.includes(row.item.row_id)"
                                        :disabled='isDisabled(row.item)'>
                                    </div>
                                </template>
                                <template #cell(status)="row">
                                    <div>
                                        {{ row.item.status ? row.item.status : '' }}
                                    </div>
                                </template>
                                <template #cell(year)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.year'"
                                        :rules="rules.year"
                                        :class='row.item.isDuplicated ? "el-input--small is-error" : "el-input--small"'>
                                        <datepicker-th  
                                            :value='row.item.year'
                                            v-model="row.item.year"
                                            style="width: 100%; line-height: 32px;"
                                            class="el-input__inner md:tw-mb-0 tw-mb-2"
                                            name="input_date"
                                            id="input_date"
                                            placeholder="โปรดเลือกปี"
                                            @dateWasSelected='receivedYear(...arguments, row.index, row.item)'
                                            :disabled="isDisabled(row.item)"
                                            pType='year'/>
                                    </el-form-item>
                                </template>
                                <template #cell(policy_set_header_id)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.policy_set_header_id'"
                                        :rules="rules.policy_set_header_id"
                                        :class='row.item.isDuplicated ? "el-input--small is-error" : "el-input--small"'>
                                        <lov-policy-set-header-id 
                                            v-model="row.item.policy_set_header_id"
                                            :name="`policy_set_header_id${row.index}`"
                                            size="small"
                                            placeholder="กรมธรรม์ชุดที่"
                                            :popperBody="true"
                                            fixTypeFr="50"
                                            fixTypeSc=""
                                            :disabled="isDisabled2(row.item)"
                                            @change-lov="getValuePolicy(...arguments, row.index, row.item)"/>
                                    </el-form-item>
                                </template>
                                <template #cell(invoice_number)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.invoice_number'"
                                        :rules="rules.invoice_number">
                                        <el-input 
                                            v-model='row.item.invoice_number'
                                            :disabled="isDisabled(row.item)"
                                            placeholder="เลขที่ใบแจ้งหนี้"
                                            @change="duplicatedCheckInvoiceNumber(row.index, row.item)"
                                            class='el-input--small'/>
                                    </el-form-item>
                                </template>
                                <template #cell(policy_number)="row">
                                    <el-form-item>
                                        <el-input 
                                            v-model='row.item.policy_number'
                                            placeholder="เลขที่กรมธรรม์"
                                            :disabled="isDisabled(row.item)"
                                            class='el-input--small'/>
                                    </el-form-item>
                                </template>
                                <template #cell(start_date)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.start_date'"
                                        :rules="rules.start_date"
                                        class='el-input--small'>
                                        <datepicker-th  
                                        :value='row.item.start_date'
                                        v-model="row.item.start_date"
                                        style="width: 100%; line-height: 32px;"
                                        class="el-input__inner md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="input_date"
                                        format='DD/MM/YYYY'
                                        placeholder="โปรดเลือกวันที่เริ่มต้น"
                                        @dateWasSelected='getAdjustmentDateStart(...arguments, row.index, row.item)'
                                        :disabled="isDisabled(row.item)"/>
                                    </el-form-item>
                                </template>
                                <template #cell(end_date)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.end_date'"
                                        :rules="rules.end_date"
                                        class='el-input--small'>
                                        <datepicker-th  
                                        :value='row.item.end_date'
                                        v-model="row.item.end_date"
                                        style="width: 100%; line-height: 32px;"
                                        class="el-input__inner md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="input_date"
                                        format='DD/MM/YYYY'
                                        placeholder="โปรดเลือกวันที่สิ้นสุด"
                                        @dateWasSelected='getAdjustmentDateEnd(...arguments, row.index, row.item.start_date, row.item)'
                                        :disabled="isDisabled(row.item)"/>
                                    </el-form-item>
                                </template>
                                <template #cell(total_days)="row">
                                    <div>{{row.item.total_days ? row.item.total_days : ''}}</div>
                                </template>
                                <template #cell(person_name)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.person_name'"
                                        :rules="rules.person_name">
                                        <el-input 
                                            v-model='row.item.person_name'
                                            :disabled="isDisabled(row.item)"
                                            class='el-input--small'
                                            placeholder="ชื่อ-สกุล ผู้ว่าการ"/>
                                    </el-form-item>
                                </template>
                                <template #cell(policy_type_code)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.policy_type_code'"
                                        :rules="rules.policy_type_code">
                                        <lov-policy-type 
                                            v-model='row.item.policy_type_code'
                                            placeholder='ประเภทกรมธรรม์'
                                            :sizeSmall='true'
                                            @policyType='receivedPolicyType(...arguments, row.index, row.item)'
                                            :disabled="isDisabled(row.item)"/>
                                    </el-form-item>
                                </template>
                                <template #cell(insurance_amount)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.insurance_amount'"
                                        :rules="rules.insurance_amount"
                                        class="currency_right">
                                        <div class="el-input el-input--small">
                                            <vue-numeric 
                                                class="form-control el-input__inner input-currency text-right" 
                                                style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                                                placeholder="ค่าเบี้ยประกัน" :empty-value="0" @change='insuranceChange(row.item.insurance_amount, row.index, row.item)'
                                                :min="0" :minus="false" :precision="2" separator="," v-model="row.item.insurance_amount">
                                            </vue-numeric>
                                        </div>
                                        <!-- <currency-input 
                                        v-model="row.item.insurance_amount"
                                        style="min-width: 100px;"
                                        @input='insuranceChange(...arguments, row.index)'
                                        placeholder="ค่าเบี้ยประกัน"
                                        :sizeSmall='true'
                                        :disabled="isDisabled(row.item)"/> -->
                                    </el-form-item>
                                </template>
                                <template #cell(discount)="row">
                                    <el-form-item class="currency_right">
                                        <div class="el-input el-input--small">
                                            <vue-numeric 
                                                class="form-control el-input__inner input-currency text-right" 
                                                style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                                                placeholder="ส่วนลด" :empty-value="0" @change='discountChange(row.item.discount, row.index, row.item)'
                                                :min="0" :minus="false" :precision="2" separator="," v-model="row.item.discount">
                                            </vue-numeric>
                                        </div>
                                    </el-form-item>
                                </template>
                                <template #cell(duty_amount)="row">
                                    <el-form-item class="currency_right">

                                        {{isNullOrUndefined(row.item.duty_amount) || isNullOrUndefined(row.item.duty_amount) ===
                                        0 ?
                                        formatCurrency(row.item.duty_amount) :
                                        isNullOrUndefined(row.item.duty_amount)}}
                                        <!-- <currency-input v-model="data.duty_amount"
                                                      placeholder="อากร"
                                                      :sizeSmall='true'
                                                      @input='dutyFeeChage(...arguments, index)'
                                                      :disabled="isDisabled(data)"/> -->
                                    </el-form-item>
                                <!-- <div>
                                    {{ formatCurrency(dutyAmount(row.item)) }}
                                </div> -->
                                <!-- <div class="el-input el-input--small">
                                    <vue-numeric class="form-control el-input__inner input-currency text-right" 
                                    style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                                    placeholder="อากร" :empty-value="0" @change="dutyChange(...arguments, row.index, row.item)"
                                    :min="0" :minus="false" :precision="2" separator="," v-model="row.item.duty_amount"></vue-numeric>
                                </div> -->
                                </template>
                                <template #cell(vat_amount)="row">
                                    <el-form-item class="currency_right">
                                        {{isNullOrUndefined(row.item.vat_amount) || isNullOrUndefined(row.item.vat_amount) === 0
                                        ?
                                        formatCurrency(row.item.vat_amount) :
                                        isNullOrUndefined(row.item.vat_amount)}}
                                        <!-- <currency-input v-model="data.vat_amount"
                                                        placeholder="ภาษีมูลค่าเพิ่ม"
                                                        :sizeSmall='true'
                                                        @input='vatChage(...arguments, index)'
                                                        :disabled="isDisabled(data)"/> -->
                                    </el-form-item>
                                </template>
                                <template #cell(net_amount)="row">
                                    <el-form-item class="currency_right">
                                        {{isNullOrUndefined(row.item.net_amount) || isNullOrUndefined(row.item.net_amount) === 0
                                        ?
                                        formatCurrency(row.item.net_amount) :
                                        isNullOrUndefined(row.item.net_amount)}}
                                        <!-- <currency-input v-model="data.net_amount"
                                                        placeholder="ค่าเบี้ยประกันสุทธิ"
                                                        :sizeSmall='true'
                                                        @input='netAmountChage(...arguments, index)'
                                                        :disabled="isDisabled(data)"/> -->
                                    </el-form-item>
                                </template>
                                <template #cell(company_id)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.company_id'"
                                        :rules="rules.company_id">
                                        <lov-company  
                                            v-model='row.item.company_id'
                                            :value='row.item.company_id'
                                            placeholder='รหัสผู้รับประกันภัย'
                                            @company='receivedCompany(...arguments, row.index, row.item)'
                                            :disabled="isDisabled(row.item)"
                                            :isSave='!complete'/>
                                    </el-form-item>
                                </template>
                                <template #cell(company_name)="row">
                                    <div>
                                        {{ row.item.company_name ? row.item.company_name : '' }}
                                    </div>
                                </template>
                                <template #cell(expense_account)="row">
                                    <el-form-item 
                                        :prop="'rows.' + row.index + '.expense_account'"
                                        :rules="rules.expense_account"
                                        class='el-input--small'>
                                        <el-input 
                                            placeholder="รหัสบัญชี"
                                            v-model="row.item.expense_account"
                                            :value='row.item.expense_account'
                                            class="readonly el-input--small"
                                            :disabled="isDisabled(row.item)">
                                            <el-button  
                                                slot="append"
                                                data-toggle="modal"
                                                @click="clickModalAccount(row.item, row.index)"
                                                :data-target="`#modal_account${row.index}`">
                                                <i class="fa fa-search"></i>
                                            </el-button>
                                        </el-input>
                                    </el-form-item>
                                </template>
                                <template #cell(expense_account_desc)="row">
                                    <div>
                                        {{ row.item.expense_account_desc ? row.item.expense_account_desc : '' }}
                                    </div>
                                </template>
                                <template #cell(payment_status)="row">
                                    <div>
                                        {{ row.item.payment_status ? row.item.payment_status : '' }}
                                    </div>
                                </template>
                                <template #cell(voucher_number)="row">
                                    <div>
                                        {{ row.item.voucher_number ? row.item.voucher_number : '' }}
                                    </div>
                                </template>
                                <template #cell(document_number)="row">
                                    <div>
                                        {{ row.item.document_number ? row.item.document_number : '' }}
                                    </div>
                                </template>
                                <template #cell(reference_document_number)="row">
                                    <div>
                                        {{ row.item.reference_document_number ? row.item.reference_document_number : '' }}
                                    </div>
                                </template>
                                <template #cell(remove)="row">
                                    <el-form-item v-show="row.item.status == 'New' && !isDisabled(row.item)">
                                        <button type="button" class="btn btn-sm btn-danger" @click="clickRemoveFlgAdd(row.item, row.index)">
                                        <i class="fa fa-times"></i>
                                            ลบ
                                        </button>
                                    </el-form-item>
                                </template>

                            </b-table>
                        </div>
                        <div class="row" v-show="totalRows > perPage">
                            <div class="col-md-12">
                                <b-pagination
                                v-model="currentPage"
                                :total-rows="totalRows"
                                :per-page="perPage"
                                align="right"
                                ></b-pagination>
                            </div>
                        </div>

                        <div class="row margin_top_20">
                            <div class="col-md-6">
                                <div class="form-group el_field">
                                    <el-form-item>
                                        <button type="button"
                                                class='btn btn-primary'
                                                @click='clickConfirm()'>
                                            <i class='fa fa-check'></i> ยืนยัน
                                        </button>
                                        <button type="button"
                                                class='btn btn-danger'
                                                @click='clickCancel()'>
                                            <i class="fa fa-times"></i> ยกเลิก
                                        </button>
                                        <button type="button"
                                                class='btn btn-warning'
                                                @click='clickClear()'>
                                            <i class="fa fa-repeat"></i> รีเซต
                                        </button>
                                    </el-form-item>
                                </div>
                            </div>

                            <div class="col-md-6 lable_align">
                                <div class="form-group el_field">
                                    <el-form-item>
                                        <button type="button"
                                                class="btn btn-primary"
                                                v-show="!complete"
                                                @click="clickSave()">
                                            <i class="fa fa-check-square-o"></i> บันทึก (ล็อค)
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger"
                                                v-show="complete"
                                                @click="clickIncomplete()">
                                            <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
                                        </button>
                                    </el-form-item>
                                </div>
                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
        </div>


        <modal-account-code :index="indexTable"
                            :rows="dataTable.rows"
                            @select-accounts="getDataRowSelectAccount"
                            :accounts="accountGovernor"
                            :descriptions="descriptionAccount"
                            :disabled="dataTable.rows[indexTable] ? isDisabled(dataTable.rows[indexTable]) : false"
                            :accountId="accountId"
                            :type_cost="type_cost"/>

    </div>
</template>

<script>
    import uuid from 'uuid/v1';
    import lovPolicyType from './lovPolicyType'
    import lovInvoice from './lovInvoice'
    import currencyInput from '../components/currencyInput'
    import lovCompany from './lovCompany'
    import modalAccountCode from './modalAccountCode'
    import moment from 'moment'
    import lovPolicySetHeaderId from '../components/lov/policySetHeaderId'

    export default {
        name: 'index-table-governor',
        components: {
            lovPolicyType,
            lovInvoice,
            currencyInput,
            lovCompany,
            modalAccountCode,
            lovPolicySetHeaderId
        },
        props: [
            'dataTable',
            'yearHeader',
            'setLabelExpenseFlag',
            'isNullOrUndefined',
            'formatCurrency',
            'setYearCE'
        ],
        data() {
            return {
                lastRowId: -1,
                setDataRowsNotInterface: [],
                sessionShow: false,
                dateFormat: 'DD/MM/YYYY',
                tableData: [],
                complete: true,
                columnSelected: [],
                columnSelectedId: [],
                indexTable: 0,
                accountGovernor: {
                    company: '',
                    branch: '',
                    department: '',
                    product: '',
                    source: '',
                    account: '',
                    subAccount: '',
                    projectActivity: '',
                    interCompany: '',
                    allocation: '',
                    futureUsed1: '',
                    futureUsed2: ''
                },
                descriptionGovernor: {
                    company: '',
                    branch: '',
                    department: '',
                    product: '',
                    source: '',
                    account: '',
                    subAccount: '',
                    projectActivity: '',
                    interCompany: '',
                    allocation: '',
                    futureUsed1: '',
                    futureUsed2: ''
                },
                descriptionAccount: {
                    company: '',
                    branch: '',
                    department: '',
                    product: '',
                    source: '',
                    account: '',
                    subAccount: '',
                    projectActivity: '',
                    interCompany: '',
                    allocation: '',
                    futureUsed1: '',
                    futureUsed2: ''
                },
                rules: {
                    year: [
                        {required: true, message: 'กรุณาระบุวันปี', trigger: 'change'},
                    ],
                    start_date: [
                        {required: true, message: 'กรุณาระบุวันที่เริ่มต้น', trigger: 'change'},
                    ],
                    end_date: [
                        {required: true, message: 'กรุณาระบุวันที่สิ้นสุด', trigger: 'change'},
                    ],
                    // department_code: [
                    //   {required: true, message: 'กรุณาระบุรหัสหน่วยงาน', trigger: 'change'},
                    // ],
                    // group_code: [
                    //   {required: true, message: 'กรุณาระบุกลุ่ม', trigger: 'change'},
                    // ],
                    insurance_amount: [
                        {required: true, message: 'กรุณาระบุค่าเบี้ยประกัน', trigger: 'change'},
                    ],
                    expense_account: [
                        {required: true, message: 'กรุณาระบุรหัสค่าใช้จ่าย', trigger: 'change'},
                    ],
                    company_id: [
                        {required: true, message: 'กรุณาระบุรหัสผู้รับประกันภัย', trigger: 'change'},
                    ],
                    invoice_type: [
                        {required: true, message: 'กรุณาระบุประเภทใบแจ้งหนี้', trigger: 'change'},
                    ],
                    invoice_number: [
                        {required: true, message: 'กรุณาระบุรหัสใบแจ้งหนี้', trigger: 'change'},
                    ],
                    person_name: [
                        {required: true, message: 'กรุณาระบุชื่อผู้ว่าการ', trigger: 'change'}
                    ],
                    policy_type_code: [
                        {required: true, message: 'กรุณาระบุประเภทกรมธรรม์', trigger: 'change'}
                    ],
                    policy_set_header_id: [
                      {required: true, message: 'กรุณาระบุกรมธรรม์ชุดที่', trigger: 'change'}
                    ]
                },
                headerTable: {
                    total: '',
                    discount: '',
                    duty_fee: '',
                    vat: '',
                    net_amount: ''
                },
                accountId: '',
                type_cost: '',

                fields: [
                    { key: 'selected', sortable: false, class:'text-center text-nowrap', },
                    { key: 'status', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
                    { key: 'year', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 120px;', tdClass: 'el_field' },
                    { key: 'policy_set_header_id', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 200px;', tdClass: 'el_field' },
                    { key: 'invoice_number', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 180px;', tdClass: 'el_field' },
                    { key: 'policy_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 150px;', tdClass: 'el_field' },
                    { key: 'start_date', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
                    { key: 'end_date', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
                    { key: 'total_days', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
                    { key: 'person_name', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 200px;', tdClass:'align-middle' },
                    { key: 'policy_type_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 230px;', tdClass:'align-middle' },
                    { key: 'insurance_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass: 'el_field' },
                    { key: 'discount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass: 'el_field' },
                    { key: 'duty_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 90px;', tdClass:'align-middle' },
                    { key: 'vat_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 120px;', tdClass:'align-middle' },
                    { key: 'net_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass:'align-middle' },
                    { key: 'company_id', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 200px;', tdClass: 'el_field' },
                    { key: 'company_name', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'text-nowrap', },
                    { key: 'expense_account', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 420px;', tdClass: 'el_field'  },
                    { key: 'expense_account_desc', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
                    { key: 'payment_status', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
                    { key: 'voucher_number', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
                    { key: 'document_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 180px;', tdClass:'align-middle' },
                    { key: 'reference_document_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 180px;', tdClass:'align-middle' },
                    { key: 'remove', sortable: false, class:'text-center text-nowrap', thStyle: 'min-width: 80px;', },
                ],
                totalRows: 0,
                currentPage: 1,
                perPage: 100,
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                isBusy: false,

                dataExport: [],
            }
        },
        methods: {
            onRowSelected(items) {
                this.selected = items
            },
            rowClass(item, type, test) {
                if (!item || type !== 'row') return
                if (item.row_id === this.lastRowId) return 'newLine'
                // if (item.expense_id === this.selectRowId) return 'mouse-over highlight'
                // return 'mouse-over';
            },
            clickSelectRow (row_id, obj) {
                let vm = this;
                let checked = $(`input[name="governor_select${row_id}"]`).is(':checked')
                if (checked) {
                    vm.setSelectedColumn(obj)
                    let setDataRowsNotInterface = vm.dataTable.rows.filter((row, i) => {
                        return !vm.isDisabled(row);
                    })
                if(setDataRowsNotInterface.length === vm.columnSelected.length){
                    $(`input[name="governor_select_all"]`).prop('checked', true)
                }
                } else {
                    const index = vm.columnSelected.indexOf(obj);
                    if (index > -1) {
                        vm.columnSelected.splice(index, 1);
                        vm.columnSelectedId.splice(index, 1);
                    }
                    $(`input[name="governor_select_all"]`).prop('checked', false)
                }
            },
            receivedPolicyType(policy, i, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);
                if (policy) {
                    this.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.policy_type_code`).clearValidate();
                    vm.dataTable.rows[index].policy_type_code = policy.code;
                    vm.dataTable.rows[index].tag = policy.tag;
                    this.calAmount(index);
                } else {
                    vm.dataTable.rows[index].policy_type_code = ''
                    vm.dataTable.rows[index].tag = '';
                    this.$refs.save_table_line_governor.validateField(`rows.${i}.policy_type_code`)
                }
            },
            ClickAddRow() {
                const vm = this;
                vm.lastRowId = uuid();
                axios.get('/ir/ajax/lov/defaultirp0007')
                    .then((response) => {
                        let rs = response.data.datas;
                         
                        let obj = {
                            row_id: vm.lastRowId,
                            person_id: null,
                            company_id: rs?.company_code,
                            company_name: rs?.company_name,
                            discount_amount: 0,
                            document_number: null,
                            discount: 0,
                            duty_amount: 0,
                            expense_account:  rs?.account_combine, //"01.6.11000000.00.64.291.000000.9.651000.138.0.0",
                            expense_account_desc: rs?.account_code_desc, //"งบกลาง.ค่าใช้จ่ายในการบริหาร.ค่าตอบแทนผู้ว่าการและอื่นๆ",
                            expense_account_id: rs?.gl_expense_account_id,
                            insurance_amount: 0,
                            invoice_number: null,
                            invoice_type: null,
                            net_amount: 0,
                            payment_date: null,
                            payment_status: null,

                            person_id: null,
                            person_name: null,
                            policy_number: rs?.user_policy_number,
                            policy_type_code: null,
                            policy_type_name: null,
                            start_date: null,
                            end_date: null,
                            status: 'New',
                            total_days: null,
                            vat_amount: 0,
                            vat_percent: +rs?.tax, //'7',
                            voucher_number: null,
                            year: rs.thai_year,
                            flgAdd: true,
                            company_number: null,
                            isDuplicated: false,
                            isDuplicatedInvoice: false,
                            // expense_flag: 'N',
                            type_cost: rs?.gl_expense_account_code, //p870
                            policy_set_header_id: rs?.policy_set_header_id,
                            revenue_stamp: rs?.revenue_stamp, //0,
                            tag: rs?.include_tax_flag, // ''
                        }
                        let index = vm.dataTable.rows.push(obj)-1;
                        this.$nextTick(() => {
                            this.complete = false;
                            this.calAmount(index);
                             
                            // if( rs?.policycount > 1 || rs?.policycount < 1 ){
                            //     swal('จำนวน Policy Set มีมากกว่า 1 ไม่สามารถ Default Data ได้!');
                            // }
                            const el = this.$el.getElementsByClassName('endTable')[0];
                            if (el) {
                                el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                            }
                        });
                    })

            },
            clickSelectAll () {
                let _this = this;
                _this.columnSelected = [];
                _this.columnSelectedId = [];
                let checked = $(`input[name="governor_select_all"]`).is(':checked')
                _this.dataTable.rows.forEach((row, index) => {
                    if (checked && !_this.isDisabled(row)) {
                        _this.setSelectedColumn(row);
                    }
                })
            },
            clickModalAccount(obj, i) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(obj);
                vm.indexTable = index
                if (obj.expense_account === null || obj.expense_account === undefined) {
                    return;
                }
                let accountSplit = obj.expense_account?.split('.')
                let descSplit = obj.expense_account_desc?.split('.')
                let indexAccount = 0
                let indexDesc = 0

                console.log('accountSplit <---> ', accountSplit);
                if (obj.expense_account) {
                    let coaEnter = obj.expense_account;
                    var coa = coaEnter.split('.');
                    
                    this.accountGovernor['company']         =  coa[0];
                    this.accountGovernor['branch']          =  coa[1];
                    this.accountGovernor['department']      =  coa[2];
                    this.accountGovernor['product']         =  coa[3];
                    this.accountGovernor['source']          =  coa[4];
                    this.accountGovernor['account']         =  coa[5];
                    this.accountGovernor['subAccount']      =  coa[6];
                    this.accountGovernor['projectActivity'] =  coa[7];
                    this.accountGovernor['interCompany']    =  coa[8];
                    this.accountGovernor['allocation']      =  coa[9];
                    this.accountGovernor['futureUsed1']     =  coa[10];
                    this.accountGovernor['futureUsed2']     =  coa[11];

                    axios.get("/ir/ajax/asset/validate-account", {
                        params: {
                            segmentAlls: coa,
                            type: 'all',
                            coaEnter: coaEnter
                        }
                    }).then(res => {
                        if (res.data.status != 'E') {
                            var desc = res.data.data.split('.');
                            this.descriptionAccount['company']         =  desc[0];
                            this.descriptionAccount['branch']          =  desc[1];
                            this.descriptionAccount['department']      =  desc[2];
                            this.descriptionAccount['product']         =  desc[3];
                            this.descriptionAccount['source']          =  desc[4];
                            this.descriptionAccount['account']         =  desc[5];
                            this.descriptionAccount['subAccount']      =  desc[6];
                            this.descriptionAccount['projectActivity'] =  desc[7];
                            this.descriptionAccount['interCompany']    =  desc[8];
                            this.descriptionAccount['allocation']      =  desc[9];
                            this.descriptionAccount['futureUsed1']     =  desc[10];
                            this.descriptionAccount['futureUsed2']     =  desc[11];
                        
                        }
                    });

                }

                if (obj.expense_account_desc) {
                    for (let code in vm.accountGovernor) {
                        vm.accountGovernor[code] = accountSplit[indexAccount]
                        indexAccount++
                    }
                } else {
                    for (let code in vm.accountGovernor) {
                        vm.accountGovernor[code] = ''
                        indexAccount++
                    }
                }

                if (obj.expense_account_desc) {
                    for (let code in vm.descriptionGovernor) {
                        vm.descriptionGovernor[code] = descSplit[indexDesc]
                        indexDesc++
                    }
                } else {
                    for (let code in vm.descriptionGovernor) {
                        vm.descriptionGovernor[code] = ''
                        indexDesc++
                    }
                }
                this.accountId = obj.expense_account_id;
                this.type_cost = obj.type_cost;
            },
            clickRemoveFlgAdd(dataRow, index) {
                const vm = this
                swal({
                    title: "Warning",
                    text: "ต้องการลบหรือไม่?",
                    type: "warning",
                    showCancelButton: true,
                    showConfirmButton: true,
                    closeOnConfirm: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        if (dataRow.person_id) {
                            axios.post(`/ir/ajax/persons/delete`, dataRow).then(({data}) => {
                                vm.dataTable.rows.splice(index, 1)
                                
                                let res = data.data;
                                swal({
                                    title: "Success",
                                    text: "",
                                    type: "success",
                                    showConfirmButton: true,
                                    closeOnConfirm: true
                                });
                            });
                        } else { 
                            vm.dataTable.rows.splice(index, 1)
                            // _this.tableLineAll.splice(i, 1);
                            swal({
                                title: "Success",
                                text: "",
                                type: "success",
                                showConfirmButton: true,
                                closeOnConfirm: true
                            });
                        }
                    }
                });
            },
            setSelectedColumn (data) {
                this.columnSelected.push(data)
                this.columnSelectedId.push(data.row_id);
            },
            receivedInvoice(invoice, index) {
                 
                if (invoice) {
                    this.dataTable.rows[index].invoice_type = invoice
                    this.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${index}.invoice_type`).clearValidate()
                } else {
                    this.dataTable.rows[index].invoice_type = ''
                    this.$refs.save_table_line_governor.validateField(`rows.${index}.invoice_type`)
                }
            },
            receivedCompany(company, i, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);
                if (company) {
                    this.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.company_id`).clearValidate()
                    vm.dataTable.rows[index].company_id = company.id
                    vm.dataTable.rows[index].company_name = company.desc
                    vm.dataTable.rows[index].company_number = company.code
                } else {
                    this.$refs.save_table_line_governor.validateField(`rows.${i}.company_id`)
                    vm.dataTable.rows[index].company_id = ''
                    vm.dataTable.rows[index].company_name = ''
                    vm.dataTable.rows[index].company_number = ''
                }
            },
            focusNotKey() {
                $(".readonly").on("keydown paste focus mousedown", function (e) {
                    if (e.keyCode != 9) {
                        e.preventDefault();
                    }
                })
            },
            clickConfirm() {
                if (this.columnSelected.length === 0) {
                    swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยืนยัน!', 'warning');
                    return
                }
                this.$refs.save_table_line_governor.validate((valid) => {
                    if (valid) {
                        this.columnSelected.filter((row, index) => {
                            row.status = 'Confirmed'
                            return row
                        })
                        $(`input[name="governor_select_all"]`).prop('checked', false)
                        this.columnSelected = []
                        this.columnSelectedId = []
                        return
                    } else {
                        return false;
                    }
                })
            },
            clickClear() {
                if (this.columnSelected.length === 0) {
                    swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการรีเซต!', 'warning');
                    return
                }
                this.$refs.save_table_line_governor.validate((valid) => {
                    if (valid) {
                        this.columnSelected.filter((row, index) => {
                            row.status = 'New'
                            return row
                        })
                        $(`input[name="governor_select_all"]`).prop('checked', false)
                        this.columnSelected = []
                        this.columnSelectedId = []
                        return
                    } else {
                        return false;
                    }
                })
            },
            clickCancel() {
                if (this.columnSelected.length === 0) {
                    swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยกเลิก!', 'warning');
                    return
                }
                this.$refs.save_table_line_governor.validate((valid) => {
                    if (valid) {
                        this.columnSelected.filter((row, index) => {
                            row.status = 'Cancelled'
                            return row
                        })
                        $(`input[name="governor_select_all"]`).prop('checked', false)
                        this.columnSelected = []
                        this.columnSelectedId = []
                        return
                    } else {
                        return false;
                    }
                })
            },
            clickComplete() {
                this.$refs.save_table_line_governor.validate((valid) => {
                    if (valid) {
                        this.setComplete()
                    } else {
                        return true
                    }
                })
            },
            setComplete() {
                const isFlgAdd = (row) => row.flgAdd
                if (this.dataTable.rows.every(isFlgAdd)) {
                    if (this.checkDuplicateField() || this.checkDuplicateInvoice()) {
                        swal({
                            title: "Warning",
                            text: 'ไม่สามารถบันทึก รายการซ้ำได้',
                            type: "warning",
                        })
                    } else {
                        this.dataTable.rows.forEach(row => {
                            row.isDuplicated = false
                            row.isDuplicatedInvoice = false
                        })
                        this.saveGovernor()
                    }
                } else if (this.dataTable.rows.find(row => row.isDuplicated || row.isDuplicatedInvoice)) {
                    swal({
                        title: "Warning",
                        text: 'ไม่สามารถบันทึก รายการซ้ำได้',
                        type: "warning",
                    })
                } else {
                    this.dataTable.rows.forEach(row => {
                        row.isDuplicated = false
                        row.isDuplicatedInvoice = false
                    })
                    this.saveGovernor()
                }
            },
            saveGovernor() {
                let params = {
                    data: this.dataTable.rows.map((data, index) => {
                        if (!data.row_id) data.row_id = index
                        return data
                    })
                }
                axios.post(`/ir/ajax/persons`, params)
                    .then(response => {
                        this.complete = true;
                        this.dataTable.rows.map((row, index) => {
                            delete row.flgAdd
                            $(`input[name="governor_select${index}"]`).prop('checked', false)
                            response.data.data.rows.map((data, indexData) => {
                                if (data.row_id == row.row_id) {
                                    row.person_id = data.person_id
                                    row.document_number = data.document_number
                                }
                            })
                            return row
                        })
                        this.columnSelected = []
                        this.$emit('fetchPerson', true)
                        swal({
                            title: "Success",
                            text: 'บันทึกสำเร็จ',
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: true
                        })
                    })
                    .catch((error) => {
                        if (error.response.data.status === 400) {
                            swal({
                                title: "Warning",
                                text: error.response.data.message,
                                type: "warning",
                            })
                        } else {
                            swal({
                                title: "Error",
                                text: error.response.data.message,
                                type: "error",
                            })
                        }
                    })
            },
            validateinsurance_amount(index){
                const vm = this
                if(vm.dataTable.rows[index].insurance_amount < vm.dataTable.rows[index].discount){
                    swal({
                        title: "Warning",
                        text:  'ส่วนลดเบี้ยประกัน ต้องน้อยกว่าเท่ากับ เบี้ยประกัน',
                        type: "warning",
                    })
                    vm.$nextTick(()=>{
                        vm.dataTable.rows[index].discount = 0;
                    });
                }
            },
            insuranceChange(value, i, data) {
                const vm = this;
                let index = vm.dataTable.rows.indexOf(data);
                if (value) {
                    vm.dataTable.rows[index].insurance_amount = value
                    this.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.insurance_amount`).clearValidate()
                } else {
                    vm.dataTable.rows[index].insurance_amount = ''
                    this.$refs.save_table_line_governor.validateField(`rows.${i}.insurance_amount`)
                }
                vm.validateinsurance_amount(index);
                this.calAmount(index)
                // vm.dataTable.rows[index].duty_amount = parseFloat(((value - +vm.dataTable.rows[index].discount) * +vm.dataTable.rows[index].revenue_stamp_percent) / 100).toFixed(2)
                // vm.dataTable.rows[index].vat_amount = parseFloat(((value - +vm.dataTable.rows[index].discount + +vm.dataTable.rows[index].duty_amount) * +vm.dataTable.rows[index].vat_percent) / 100).toFixed(2)
                // vm.dataTable.rows[index].net_amount = parseFloat(value - +vm.dataTable.rows[index].discount + +vm.dataTable.rows[index].duty_amount +  +vm.dataTable.rows[index].vat_amount).toFixed(2)
            },
            discountChange(value, i, data) {
                const vm = this;
                let index = vm.dataTable.rows.indexOf(data);
                if (value) {
                    vm.dataTable.rows[index].discount = value
                } else {
                    vm.dataTable.rows[index].discount = 0;
                    vm.dataTable.rows[index].net_amount = 0;
                }
                vm.validateinsurance_amount(index);
                this.calAmount(index)
                // vm.dataTable.rows[index].duty_amount = parseFloat(((+vm.dataTable.rows[index].insurance_amount - value) * +vm.dataTable.rows[index].revenue_stamp_percent) / 100).toFixed(2)
                // vm.dataTable.rows[index].vat_amount = parseFloat(((+vm.dataTable.rows[index].insurance_amount - value + +vm.dataTable.rows[index].duty_amount) * +vm.dataTable.rows[index].vat_percent) / 100).toFixed(2)
                // vm.dataTable.rows[index].net_amount = parseFloat(+vm.dataTable.rows[index].insurance_amount - value + +vm.dataTable.rows[index].duty_amount +  +vm.dataTable.rows[index].vat_amount).toFixed(2)
            },
            dutyFeeChage(value, index) {
                const vm = this
                if (value) vm.dataTable.rows[index].duty_amount = value
                else vm.dataTable.rows[index].duty_amount = ''
            },
            vatChage(value, index) {
                const vm = this
                if (value) vm.dataTable.rows[index].vat_amount = value
                else vm.dataTable.rows[index].vat_amount = ''
            },
            netAmountChage(value, index) {
                const vm = this
                if (value) vm.dataTable.rows[index].net_amount = value
                else vm.dataTable.rows[index].net_amount = ''
            },
            clickIncomplete() {
                this.complete = false;
            },
            getDataRowSelectAccount(dataRows) {
                this.dataTable.rows = dataRows
            },
            headerTotalChange(value) {
                this.headerTable.total = value
            },
            headerDiscountChange(value) {
                this.headerTable.discount = value
            },
            headerDutyFeeChange(value) {
                this.headerTable.duty_fee = value
            },
            headerVatChange(value) {
                this.headerTable.vat = value
            },
            headerNetAmountChange(value) {
                this.headerTable.net_amount = value
            },
            receivedYear(year, i, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);
                vm.dataTable.rows[index].year = moment(year).format('YYYY') != 'Invalid date' ? moment(year).format('YYYY') : ''
                if (year) {
                    // vm.duplicatedCheck(vm.dataTable.rows[index], index)
                    this.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.year`).clearValidate()
                } else {
                    this.$refs.save_table_line_governor.validateField(`rows.${i}.year`)
                }
                let policy_set_header_id = this.dataTable.rows[index].policy_set_header_id;
                if (year && policy_set_header_id) {
                    this.receivedDataMaster({
                        policy_set_header_id: policy_set_header_id,
                        date_from: '',
                        date_to: '',
                        year: this.setYearCE('year', vm.dataTable.rows[index].year)
                    }, index)
                }
            },
            async getAdjustmentDateStart(date, i, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);
                if (date === null) {
                    vm.dataTable.rows[index].start_date = ''
                    vm.dataTable.rows[index].start_timer = ''
                    vm.$refs.save_table_line_governor.validateField(`rows.${i}.start_date`)
                } else {
                    vm.dataTable.rows[index].start_date = moment(date).format(vm.dateFormat)
                    let convertDate = await vm.parseToDate(date)
                    vm.dataTable.rows[index].start_timer = convertDate
                    vm.dataTable.rows[index].end_timer = moment(convertDate, 'DD/MM/YYYY').add(1, 'years').toDate()

                    vm.dataTable.rows[index].end_date = moment(date).add(1, 'years').format(vm.dateFormat)
                    vm.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.start_date`).clearValidate()
                    vm.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate()
                }

                if (vm.dataTable.rows[index].start_timer && vm.dataTable.rows[index].end_timer)
                    vm.dataTable.rows[index].total_days = Math.floor((Math.abs(vm.dataTable.rows[index].start_timer - vm.dataTable.rows[index].end_timer)) / (1000 * 60 * 60 * 24))
            },
            async getAdjustmentDateEnd (date, i, date2, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);
                let newdate2 = new Date(date2.split('/')[1] + '/' + date2.split('/')[0] + '/' + date2.split('/')[2]);
                if (date === null) {
                    vm.dataTable.rows[index].end_date = ''
                    vm.dataTable.rows[index].end_timer = ''
                    this.$refs.save_table_line_governor.validateField(`rows.${i}.end_date`)
                } else {
                    vm.dataTable.rows[index].end_date = moment(date).format(vm.dateFormat)
                    let convertDate = await vm.parseToDate(date)
                    vm.dataTable.rows[index].end_timer = moment(convertDate, 'DD/MM/YYYY').toDate()
                    this.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate()
                }
                if (newdate2 === null) {
                    vm.dataTable.rows[index].start_date = ''
                    vm.dataTable.rows[index].start_timer = ''
                    vm.$refs.save_table_line_governor.validateField(`rows.${i}.start_date`)
                } else {
                    vm.dataTable.rows[index].start_date = moment(newdate2).format(vm.dateFormat)
                    let convertDate = await vm.parseToDate(newdate2)
                    vm.dataTable.rows[index].start_timer = convertDate

                    vm.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.start_date`).clearValidate()
                    vm.$refs.save_table_line_governor.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate()
                }
                if (vm.dataTable.rows[index].start_timer && vm.dataTable.rows[index].end_timer)
                    vm.dataTable.rows[index].total_days = Math.floor((Math.abs(vm.dataTable.rows[index].start_timer - vm.dataTable.rows[index].end_timer)) / (1000 * 60 * 60 * 24))
                if (vm.dataTable.rows[index].total_days < 365 || vm.dataTable.rows[index].total_days > 366) {
                    swal({
                        title: "Warning",
                        text: "วันที่สิ้นสุดที่คิดค่าเบี้ยประกัน มากกว่าหรือน้อยกว่า 1 ปี ต้องการทำรายการต่อหรือไม่ ?",
                        type: "warning",
                    })
                } else {
                     
                }
            },
            async parseToDate(value = null, format = 'DD/MM/YYYY') {
                if (value == null) {
                    return moment().toDate()
                }
                return moment(value, format).subtract(543, 'years').toDate()
            },
            clickSave() {
                this.$refs.save_table_line_governor.validate((valid) => {
                    if (valid) {
                        this.setComplete()
                    }
                })
            },
            checkDuplicateField() {
                const vm = this
                let isDuplicated = false
                // const rows = vm.dataTable.rows
                // if (rows.length > 1) {
                //     rows.forEach((row, index) => {
                //         let findDup = rows.find((row2, index2) => index !== index2 &&
                //             row.year === row2.year && row.policy_type_code === row2.policy_type_code && row.person_name === row2.person_name)
                //         if (findDup) isDuplicated = true
                //     })
                //      
                //     return isDuplicated
                // } else {
                //      
                //     isDuplicated = rows[0].isDuplicated
                //     return isDuplicated
                // }
            return isDuplicated
            },
            checkDuplicateInvoice() {
                const vm = this
                let isDuplicated = false
                const rows = vm.dataTable.rows
                if (rows.length > 1) {
                    rows.forEach((row, index) => {
                        let findDup = rows.find((row2, index2) => index !== index2 && row.invoice_number === row2.invoice_number)
                        if (findDup) isDuplicated = true
                    })
                     
                    return isDuplicated
                } else {
                     
                    isDuplicated = rows[0].isDuplicatedInvoice
                    return isDuplicated
                }
                return isDuplicated
            },
            duplicatedCheckInvoiceNumber(i, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);
                const params = {
                    data: {
                        rows: vm.dataTable.rows,
                        year: data.year,
                        person_name: data.person_name,
                        policy_type_code: data.policy_type_code,
                        invoice_number: data.invoice_number,
                        row_id: data.row_id
                    }
                }
                if (data.invoice_number) {
                    axios.post(`/ir/ajax/persons/duplicate-check/invoice-number`, params)
                        .then(res => {
                            vm.dataTable.rows[index].isDuplicatedInvoice = false
                        })
                        .catch(error => {
                            if (error.response.data.status === 400) {
                                vm.dataTable.rows[index].isDuplicatedInvoice = true
                                swal({
                                    title: "Warning",
                                    text: 'ไม่สามารถเลือกเลขที่ใบแจ้งหนี้ ซ้ำกับรายการที่บันทึกไปแล้วได้',
                                    type: "warning",
                                })
                            } else {
                                swal({
                                    title: "Error",
                                    text: error.response.data.message,
                                    type: "error",
                                })
                            }
                        })
                }
                return
            },
            isDisabled(row) {
                if (this.complete) return true;
                if (row && row.status === 'Interface') return true;
                return false
            },
            isDisabled2(row) {
                if (this.complete == true) {
                    return true;
                } else {
                    return false;
                }
            },
            getValuePolicy(value, i, data) {
                const vm = this
                let index = vm.dataTable.rows.indexOf(data);

                this.dataTable.rows[index].policy_set_header_id = value;
                if (value) {
                    this.receivedDataMaster({
                        policy_set_header_id: value,
                        date_from: '',
                        date_to: '',
                        year: this.setYearCE('year', data.year)
                    }, index);
                }
            },
            receivedDataMaster(params, index) {
                 
                axios.get(`/ir/ajax/lov/premium-rate`, {params})
                    .then(({data}) => {
                         
                        if (data.data === '' || data.data === null || data.data === undefined) {
                            this.dataTable.rows[index].revenue_stamp = 0;
                        } else {
                            if (!data.data.revenue_stamp || data.data.revenue_stamp === null || data.data.revenue_stamp === undefined) {
                                this.dataTable.rows[index].revenue_stamp = 0;
                            } else {
                                this.dataTable.rows[index].revenue_stamp = parseFloat(data.data.revenue_stamp);
                            }
                        }
                    })
                    .catch(error => {
                        swal("Error", error, "error");
                    })
            },
            calAmount(index) {
                 
                let row = this.dataTable.rows[index];
                 
                let insurance_amount = row.insurance_amount || row.insurance_amount === 0 ? +row.insurance_amount : 0;
                let discount = row.discount || row.discount === 0 ? +row.discount : 0;
                let revenue_stamp = row.revenue_stamp;
                let vat = +row.vat_percent;
                let tag = row.tag;
                let duty_amount = (insurance_amount - discount) * revenue_stamp / 100;
                let vat_amount = !tag || tag == 'N' ? 0 : (insurance_amount - discount + duty_amount) * vat / 100;
                 
                row.duty_amount = duty_amount
                row.vat_amount = vat_amount;
                let checkVat = vat_amount;
                row.net_amount = insurance_amount - discount + duty_amount + checkVat;
            },
        },
        computed: {
            totalPremium() {
                let sum = 0
                if (this.dataTable.rows.length > 0)
                    this.dataTable.rows.map(data => {
                        if (data.status == 'Confirmed' || data.status == 'Interface')
                            sum += +data.insurance_amount
                    })
                let fixedDecimal = sum.toFixed(2)
                let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
                let decimal = fixedDecimal.split('.')[1]
                if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
                return `${sum.toLocaleString()}.00`
            },
            discount() {
                let sum = 0
                if (this.dataTable.rows.length > 0)
                    this.dataTable.rows.map(data => {
                        if (data.status == 'Confirmed' || data.status == 'Interface')
                            sum += +data.discount
                    })
                let fixedDecimal = sum.toFixed(2)
                let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
                let decimal = fixedDecimal.split('.')[1]
                if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
                return `${sum.toLocaleString()}.00`
            },
            totalDutyFee() {
                let sum = 0
                if (this.dataTable.rows.length > 0)
                    this.dataTable.rows.map(data => {
                        if (data.status == 'Confirmed' || data.status == 'Interface')
                            sum += +data.duty_amount
                    })
                let fixedDecimal = sum.toFixed(2)
                let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
                let decimal = fixedDecimal.split('.')[1]
                if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
                return `${sum.toLocaleString()}.00`
            },
            vat() {
                let sum = 0
                if (this.dataTable.rows.length > 0)
                    this.dataTable.rows.map(data => {
                        if (data.status == 'Confirmed' || data.status == 'Interface')
                            sum += +data.vat_amount
                    })
                let fixedDecimal = sum.toFixed(2)
                let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
                let decimal = fixedDecimal.split('.')[1]
                if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
                return `${sum.toLocaleString()}.00`
            },
            netAmount() {
                let sum = 0
                if (this.dataTable.rows.length > 0)
                    this.dataTable.rows.map(data => {
                        if (data.status == 'Confirmed' || data.status == 'Interface')
                            sum += +data.net_amount
                    })
                let fixedDecimal = sum.toFixed(2)
                let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
                let decimal = fixedDecimal.split('.')[1]
                if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
                return `${sum.toLocaleString()}.00`
            },
            tableTotal () {
                let vm = this;
                let find = null;
                let rec = null;
                let total_rec = null;
                let total_premium = 0;
                let total_discount = 0;
                let total_duty_fee = 0;
                let total_vat = 0;
                let total_net_amount = 0;
                let total_rec_insu = 0;
                let total_result_receivable = [];
                let dataTableTotal = [];

                if(vm.dataTable.rows.length === 0) return dataTableTotal;


                vm.dataTable.rows.forEach((item) => {
                    // if ( !['CONFIRMED', 'INTERFACE'].includes(item.status) ) return

                    total_rec = rec = find = null;
                    find = dataTableTotal.find((search)=>{
                        return search.group_name == item.group_name;
                    });

                    if(find){
                        find.premium += parseFloat(item.insurance_amount);
                        find.discount += parseFloat(item.discount);
                        find.duty_fee += parseFloat(item.duty_amount);
                        find.vat += parseFloat(item.vat_amount);
                        find.net_amount += parseFloat(item.net_amount);
                        if(item.receivable_code) {
                            find.rec_insu += parseFloat(item.net_amount);
                            rec = find.result_receivable.find((search)=>{
                                return search.receivable_code == item.receivable_code;
                            });
                            if(rec) {rec.net_amount += parseFloat(item.net_amount);}
                        }
                    }else {
                        dataTableTotal.push({
                            group_name: item.group_name,
                            premium: parseFloat(item.insurance_amount),
                            discount: parseFloat(item.discount),
                            duty_fee: parseFloat(item.duty_amount),
                            vat: parseFloat(item.vat_amount),
                            net_amount: parseFloat(item.net_amount),
                            rec_insu : item.receivable_code ? parseFloat(item.net_amount) : 0,
                            result_receivable: item.receivable_code ? [{
                                receivable_code: item.receivable_code, 
                                receivable_name: item.receivable_name,
                                net_amount: parseFloat(item.net_amount),
                            }] : [],
                        });
                    }

                    total_premium += parseFloat(item.insurance_amount);
                    total_discount += parseFloat(item.discount);
                    total_duty_fee += parseFloat(item.duty_amount);
                    total_vat += parseFloat(item.vat_amount);
                    total_net_amount += parseFloat(item.net_amount);
                    if(item.receivable_code) {
                        total_rec_insu += parseFloat(item.net_amount);
                        total_rec = total_result_receivable.find((search)=>{
                            return search.receivable_code == item.receivable_code;
                        });
                        if(total_rec) {
                            total_rec.net_amount += parseFloat(item.net_amount);
                        }else {
                            total_result_receivable.push({
                                receivable_code: item.receivable_code, 
                                receivable_name: item.receivable_name,
                                net_amount: parseFloat(item.net_amount),
                            })
                        }
                    }
                });
                // if(dataTableTotal.length == 1){
                //   dataTableTotal = [{
                //     group_name: 'Total',
                //     premium: total_premium,
                //     discount: total_discount,
                //     duty_fee: total_duty_fee,
                //     vat: total_vat,
                //     net_amount: total_net_amount,
                //     rec_insu: total_rec_insu,
                //     result_receivable: total_result_receivable,
                //   }];
                // }else {
                dataTableTotal.push({
                    group_name: 'Total',
                    premium: total_premium,
                    discount: total_discount,
                    duty_fee: total_duty_fee,
                    vat: total_vat,
                    net_amount: total_net_amount,
                    rec_insu: total_rec_insu,
                    result_receivable: total_result_receivable,
                });
                // }
                return dataTableTotal;
            },
        },
        watch: {
        },
        mounted(){
             
            window.vm = this;
        },
    }
</script>

<style scoped>
    th, td {
        padding: 0.25rem;
    }
    .highlight {
        cursor: pointer;
        background-color: #d4edda;
    }
    .el-form-item{
        margin-bottom: 0px !important;
    }
    .mx-datepicker {
        height: 33px !important;
    }
</style>


<style>

    th {
        z-index: 1;
        background: white;
        position: sticky;
        top: 0; /* Don't forget this, required for the stickiness */
    }

    .el-form-item__content{
        line-height: 40px;
        position: relative;
        font-size: 14px;
        margin-left: 0px !important;
    }

    .table.b-table > thead > tr > [aria-sort] > div {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .table.b-table > thead > tr > [aria-sort] {
        cursor: pointer;
    }

    table.b-table > thead > tr > th[aria-sort="descending"] > div::before,
    table.b-table > tfoot > tr > th[aria-sort="descending"] > div::before {
        content: "";
        padding-left: 15px;
    }

    table.b-table > thead > tr > th[aria-sort="descending"] > div::after,
    table.b-table > tfoot > tr > th[aria-sort="descending"] > div::after {
        opacity: 1;
        content: "\2193";
        padding-left: 10px;
    }

    table.b-table > thead > tr > th[aria-sort="ascending"] > div::before,
    table.b-table > tfoot > tr > th[aria-sort="ascending"] > div::before {
        content: "";
        padding-left: 15px;
    }

    table.b-table > thead > tr > th[aria-sort="ascending"] > div::after,
    table.b-table > tfoot > tr > th[aria-sort="ascending"] > div::after {
        opacity: 1;
        content: "\2191";
        padding-left: 10px;
    }

    table.b-table > thead > tr > th[aria-sort="none"] > div::before,
    table.b-table > tfoot > tr > th[aria-sort="none"] > div::before {
        content: "";
        padding-left: 15px;
    }

    table.b-table > thead > tr > th[aria-sort="none"] > div::after,
    table.b-table > tfoot > tr > th[aria-sort="none"] > div::after {
        opacity: 1;
        content: "\21C5";
        font-weight: normal;
        padding-left: 10px;
    }

    .table-hover > tbody > tr:hover {
        background-color: #d4edda!important;
    }

    .table-active, .table-active>td, .table-active>th {
        background-color: #d4edda!important;
    }

</style>
