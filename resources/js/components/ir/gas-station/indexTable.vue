<template>
  <div class="margin_top_20">
    <div>
      <table class="table table-striped table_style">
        <thead>
          <tr class="text-center">
            <th class="text-nowrap" v-show="tableTotal.length > 0"></th>
            <th class='text-center'>Total Premium<br>ค่าเบี้ยประกันรวม</th>
            <th class='text-center'>Total Discount<br>ส่วนลดรวม</th>
            <th class='text-center'>Total Duty Fee<br>อากรรวม</th>
            <th class='text-center'>Total Vat<br>ภาษีมูลค่าเพิ่มรวม</th>
            <th class='text-center'>Total Net Amount<br>ค่าเบี้ยประกันสุทธิรวม</th>
          </tr>
        </thead>
        <tbody id="table_search">
          <template v-for="(data, index) in tableTotal">
            <tr class="text-center" :key="index">
              <td class="text-nowrap" style="font-weight: bold;">{{ data.group_name }}</td>
              <td>{{ formatCurrency(data.insurance_amount) }}</td>
              <td>{{ formatCurrency(data.discount) }}</td>
              <td>{{ formatCurrency(data.duty_amount) }}</td>
              <td>{{ formatCurrency(data.vat_amount) }}</td>
              <td>{{ formatCurrency(data.net_amount) }}</td>
            </tr>
          </template>
          <tr class="text-center" v-show="tableTotal.length === 0"><td colspan="99">ไม่มีข้อมูล</td></tr>
        </tbody>
      </table>

      <div class='my-5'>
        <div class="row">
          <div class="col-md-6 text-left">
            <form :action="urlExport"  target="_bank">
              <!-- <input type="hidden" name="data_table[]" value="dataTable" v-model="dataExport"> -->
              <input type="hidden" name="data_table" :value="dataExport">
              <button class="btn btn-sm btn-info" target="_bank"><i class="fa fa-print"></i> Export</button>
            </form>
            <!-- <a :href="`/ir/gas-stations/gas-station/export?program_code=IRP0008`" type="button" class="btn btn-sm btn-info" target="_bank"> <i class="fa fa-print"></i> Export </a> -->
          </div>
          <div class="col-md-6 text-right">
            <button type="danger" class='btn btn-success m-1' @click='ClickAddRow()'><i class="fa fa-plus"></i> เพิ่ม</button>
          </div>
        </div>
      </div>

      <div>
        <div>
          
          <el-form  
            :model="dataTable"
            ref="save_table_line"
            :rules='rules'
            class="demo-dynamic form_table_line">
              <!-- table_style table_index_year -->
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
                @row-selected="onRowSelected">

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
                      :name="`gas_station_select_all`"
                      style='position: inherit;'
                      :disabled="complete"
                    >
                  </div>
                </template>
                <template #head(status)="header">
                  <div>
                    IR Status<br>สถานะ
                  </div>
                </template>
                <template #head(document_number)="header">
                  <div>
                    Document Number<br>เลขที่เอกสาร
                  </div>
                </template>
                <template #head(reference_document_number)="header">
                  <div>
                    Reference <br>Document
                  </div>
                </template>
                <template #head(year)="header">
                  <div>
                    Year<br>ปี *
                  </div>
                </template>
                <template #head(type_code)="header">
                  <div>
                    ประเภทสถานีน้ำมัน*
                  </div>
                </template>
                <template #head(group_name)="header">
                  <div>
                    Group<br>กลุ่ม*
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
                <template #head(coverage_amount)="header">
                  <div>
                    Coverage Amount<br>ทุนประกัน
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
                <template #head(vat_refund)="header">
                  <div>
                    Tax Recoverable<br>ภาษีขอคืนได้
                  </div>
                </template>
                <template #head(policy_number)="header">
                  <div>
                    Policy No.<br>เลขที่กรมธรรม์
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
                <template #head(expense_flag)="header">
                  <div>
                    สถานะการตัดค่าใช้จ่าย
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
                      :name="`gas_station_select${row.item.row_id}`" 
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
                <template #cell(type_code)="row">
                  <el-form-item 
                    :prop="'rows.' + row.index + '.type_code'"
                    :rules="rules.type_code"
                    class="currency_right">
                    <lov-oil-type v-model='row.item.type_code'
                      placeholder='ประเภทสถานีน้ำมัน'
                      :sizeSmall='true'
                      @oilType='receivedOilType(...arguments, row.index, row.item), setDefaultDate(...arguments, row.index, row.item)'
                      :disabled="isDisabled(row.item)"/>
                  </el-form-item>
                </template>
                <template #cell(group_name)="row">
                  <el-form-item 
                    :prop="'rows.' + row.index + '.group_code'"
                    :rules="rules.group_name">
                    {{row.item.group_name ? row.item.group_name : ''}}
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
                <template #cell(coverage_amount)="row">
                  <!-- <div>{{row.item.coverage_amount ? row.item.coverage_amount : ''}}</div> -->
                  <el-form-item class="currency_right">
                    <div class="el-input el-input--small">
                      <vue-numeric class="form-control el-input__inner input-currency text-right" 
                        style="min-width: 100px;" :disabled="isDisabled(row.item)" placeholder="ทุนประกัน" 
                        :empty-value="0" :min="0" :minus="false" :precision="2" separator="," v-model="row.item.coverage_amount">
                      </vue-numeric>
                    </div>
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
                        placeholder="ค่าเบี้ยประกัน" :empty-value="0" @change='insuranceChange(...arguments, row.index, row.item)'
                        :min="0" :minus="false" :precision="2" separator="," v-model="row.item.insurance_amount">
                      </vue-numeric>
                    </div>
                  </el-form-item>
                </template>
                <template #cell(discount)="row">
                  <el-form-item class="currency_right">
                    <div class="el-input el-input--small">
                      <vue-numeric class="form-control el-input__inner input-currency text-right" 
                        style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                        placeholder="ส่วนลด" :empty-value="0" @change="discountChange(...arguments, row.index, row.item)"
                        :min="0" :minus="false" :precision="2" separator="," v-model="row.item.discount"></vue-numeric>
                    </div>
                  </el-form-item>
                </template>
                <template #cell(duty_amount)="row">
                  <el-form-item class="currency_right">
                    <div class="el-input el-input--small">
                      <vue-numeric class="form-control el-input__inner input-currency text-right" 
                        style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                        placeholder="อากร" :empty-value="0" @change="discountChange(...arguments, row.index, row.item)"
                        :min="0" :minus="false" :precision="2" separator="," v-model="row.item.duty_amount"></vue-numeric>
                    </div>
                  </el-form-item>
                </template>
                <template #cell(vat_amount)="row">
                  <div class="padding_top_10">
                    {{vatAmount(row.item)}}
                  </div>
                </template>
                <template #cell(net_amount)="row">
                  <div class="padding_top_10">
                    {{netAmount(row.item)}}
                  </div>
                </template>
                <template #cell(vat_refund)="row">
                  <div class="padding_top_10">
                    {{setLabelVatRefund(row.item.vat_refund)}}
                  </div>
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
                      :disabled="true">
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
                <template #cell(expense_flag)="row">
                  <div>
                    {{setLabelExpenseFlag(row.item.expense_flag)}}
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
                    <button type="button" v-show="locked"
                            class="btn btn-primary"
                            @click="clickSave()"
                            :disabled='dataTable.rows.length === 0'>
                      <i class="fa fa-save"></i> บันทึก (ล็อค)
                    </button>

                    <button type="button" v-if="!locked"
                            class="btn btn-danger cursor-pointer"
                            @click="clickIncomplete()"
                            :disabled='dataTable.rows.length === 0'>
                            <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
                    </button>

                    <!-- <button  class='btn btn-primary' @click='clickComplete()'  v-show="complete"><i class='fa fa-check-square-o'></i> Completed</button>
                    <button type="button" class="btn btn-danger" v-if="!complete"
                      @click="clickIncomplete()">
                      <i class="fa fa-minus-square-o"></i> Incompleted
                    </button> -->
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
                        :accounts="accountGasStations"
                        :descriptions="descriptionGasStations"
                        :disabled='true'
                        :accountId="accountId"
                        :type_cost="type_cost" />
                        <!-- :disabled='dataTable.rows[indexTable] ? isDisabled(dataTable.rows[indexTable]) : false' -->
  </div>
</template>

<script>
  import uuid from 'uuid/v1';
  import dateInput from '../components/calendar/dateInput'
  import lovDepartment from './lovDepartment'
  import currencyInput from '../components/currencyInput'
  import lovCompany from './lovCompany'
  import modalAccountCode from './modalAccountCode'
  import moment from 'moment'
  import lovOilType from './lovOilType'

  export default {
    name: 'index-table-gas-station',
    data() {
      return {
        lastRowId: -1,
        dateFormat: 'DD/MM/YYYY',
        complete: true,
        locked: false,
        columnSelected: [],
        columnSelectedId: [],
        indexTable: 0,
        selectindex: -1,
        accountGasStations: {
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
        descriptionGasStations: {
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
            {required: true, message: 'กรุณาระบุปี', trigger: 'change'},
          ],
          start_date: [
            {required: true, message: 'กรุณาระบุวันที่เริ่มต้น', trigger: 'change'},
          ],
          end_date: [
            {required: true, message: 'กรุณาระบุวันที่สิ้นสุด', trigger: 'change'},
          ],
          department_code: [
            {required: true, message: 'กรุณาระบุรหัสหน่วยงาน', trigger: 'change'},
          ],
          group_code: [
            {required: true, message: 'กรุณาระบุกลุ่ม', trigger: 'change'},
          ],
          insurance_amount: [
            {required: true, message: 'กรุณาระบุค่าเบี้ยประกัน', trigger: 'change'},
          ],
          expense_account: [
            {required: true, message: 'กรุณาระบุรหัสค่าใช้จ่าย', trigger: 'change'},
          ],
          company_id: [
            {required: true, message: 'กรุณาระบุรหัสผู้รับประกันภัย', trigger: 'change'},
          ],
          type_code: [
             {required: true, message: 'กรุณาระบุประเภทสถานีน้ำมัน', trigger: 'change'},
          ]
        },
        accountId: '',
        type_cost: '',

        fields: [
          { key: 'selected', sortable: false, class:'text-center text-nowrap', },
          { key: 'status', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'document_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass:'align-middle' },
          { key: 'reference_document_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 120px;', tdClass:'align-middle' },
          { key: 'year', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 110px;', tdClass: 'el_field' },
          { key: 'type_code', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 120px;', tdClass: 'el_field' },
          { key: 'group_name', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 100px;', tdClass: 'el_field' },
          { key: 'start_date', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 150px;', tdClass: 'el_field' },
          { key: 'end_date', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 150x;', tdClass: 'el_field' },
          { key: 'total_days', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'coverage_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass: 'el_field' },
          { key: 'insurance_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass: 'el_field' },
          { key: 'discount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass: 'el_field' },
          { key: 'duty_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 90px;', tdClass:'align-middle' },
          { key: 'vat_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 120px;', tdClass:'align-middle' },
          { key: 'net_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass:'align-middle' },
          { key: 'vat_refund', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass:'align-middle' },
          { key: 'policy_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 150px;', tdClass: 'el_field' },
          { key: 'company_id', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 200px;', tdClass: 'el_field' },
          { key: 'company_name', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'text-nowrap', },
          { key: 'expense_account', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 420px;', tdClass: 'el_field'  },
          { key: 'expense_account_desc', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'expense_flag', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
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
        let checked = $(`input[name="gas_station_select${row_id}"]`).is(':checked')
        if (checked) {
            vm.setSelectedColumn(obj)
            let setDataRowsNotInterface = vm.dataTable.rows.filter((row, i) => {
                return !vm.isDisabled(row);
            })
        if(setDataRowsNotInterface.length === vm.columnSelected.length){
            $(`input[name="gas_station_select_all"]`).prop('checked', true)
        }
        } else {
            const index = vm.columnSelected.indexOf(obj);
            if (index > -1) {
                vm.columnSelected.splice(index, 1);
                vm.columnSelectedId.splice(index, 1);
            }
            $(`input[name="gas_station_select_all"]`).prop('checked', false)
        }
      },
      updateselectindex(tf){
        this.selectindex = -1
        this.locked = tf
      },
      selectrow(index){
        this.selectindex = index
      },
      clickConfirm() {
        if (this.columnSelected.length === 0) {
          swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยืนยัน!', 'warning');
          return
        }
        this.$refs.save_table_line.validate((valid) => {
          if (valid) {
            this.columnSelected.filter((row,index) => {
              row.status = 'Confirmed'
              $(`input[name="gas_station_select${index}"]`).prop('checked', false)
              return row
            })
            this.columnSelected = []
            return
          } else {
            return false;
          }
        })
      },
      clickCancel () {
        if (this.columnSelected.length === 0) {
          swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยกเลิก!', 'warning');
          return
        }
        this.$refs.save_table_line.validate((valid) => {
          if (valid) {
            this.columnSelected.filter((row,index) => {
              row.status = 'Cancelled'
              $(`input[name="gas_station_select${index}"]`).prop('checked', false)
              return row
            })
            this.columnSelected = []
            return
          } else {
            return false;
          }
        })
      },
      clickClear () {
        if (this.columnSelected.length === 0) {
          swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการรีเซต!', 'warning');
          return
        }
        this.$refs.save_table_line.validate((valid) => {
          if (valid) {
            this.columnSelected.filter((row, index) => {
              row.status = 'New'
              $(`input[name="gas_station_select${index}"]`).prop('checked', false)
              return row
            })
            this.columnSelected = []
            return
          } else {
            return false;
          }
        })
      },
      clickComplete () {
        this.$refs.save_table_line.validate((valid) => {
          if (valid) {
            this.setComplete()
          }
        })
      },
      setComplete () {
        const isFlgAdd = (row) => row.flgAdd
        if (this.dataTable.rows.every(isFlgAdd)) {
          if (this.checkDuplicateField()) {
            swal({
              title: "Warning",
              text:  'ไม่สามารถ Save รายการซ้ำได้',
              type: "warning",
            })
          } else {
            this.dataTable.rows.forEach(row => {
              row.isDuplicated = false
            })
            // this.saveGasStations()
            var check_day = this.dataTable.rows.find(row => row.total_days == '');

            if (check_day) {
              swal({
                title: "Warning",
                text:  'ไม่สามารถ Save ได้ เนื่องจากจำนวนวัน เป็น 0',
                type: "warning",
              })
            } else {
              this.saveGasStations()
            }
          }
        } else if (this.dataTable.rows.find(row => row.isDuplicated)) {
          swal({
            title: "Warning",
            text:  'ไม่สามารถ Save รายการซ้ำได้',
            type: "warning",
          })
        } else {
          var check_day = this.dataTable.rows.find(row => row.total_days == '');

          if (check_day) {
            swal({
              title: "Warning",
              text:  'ไม่สามารถ Save ได้ เนื่องจากจำนวนวัน เป็น 0',
              type: "warning",
            })
          } else {
            this.saveGasStations()
          }
          // this.saveGasStations()
        }
      },
      saveGasStations() {
        let params = {data: this.dataTable.rows.map((data, index) => {
            if (!data.row_id) data.row_id = index
            return data
        })}
        axios.post(`/ir/ajax/extend-gas-stations`, params)
        .then(response => {
          this.complete = false
          this.dataTable.rows.map((row, index) => {
            delete row.flgAdd
            $(`input[name="gas_station_select${index}"]`).prop('checked', false)
            response.data.data.rows.map(data => {
              if (data.row_id == row.row_id) {
                row.ex_gas_station_id = data.ex_gas_station_id
                row.document_number = data.document_number
              }
            })
            return row
          })
          this.columnSelected = []
          swal({
            title: "Success",
            text: 'บันทึกสำเร็จ',
            // timer: 3000,
            type: "success",
            showCancelButton: false,
            showConfirmButton: true
          })
        })
        .catch((error) => {
          if (error.response.data.status === 400) {
            swal({
              title: "Warning",
              text:  error.response.data.message,
              type: "warning",
            })
          } else {
            swal({
              title: "Error",
              text:  error.response.data.message,
              type: "error",
            })
          }
        })
      },
      clickSelectAll () {
        let _this = this;
        _this.columnSelected = [];
        _this.columnSelectedId = [];
        let checked = $(`input[name="gas_station_select_all"]`).is(':checked')
        _this.dataTable.rows.forEach((row, index) => {
          if (checked && !_this.isDisabled(row)) {
              _this.setSelectedColumn(row);
          }
        })
      },
      setSelectedColumn (data) {
        this.columnSelected.push(data)
        this.columnSelectedId.push(data.row_id);
      },
      receivedOilType(oil, i, data) {
         
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (oil) {
          vm.dataTable.rows[index].type_code = oil.type_code
          vm.dataTable.rows[index].group_code = oil.group_code
          vm.dataTable.rows[index].group_name = oil.group_desc
          // vm.dataTable.rows[index].vat_refund = oil.vat_refund === 'Y' ? "Yes" : "No"
          vm.dataTable.rows[index].vat_refund = oil.vat_refund
          vm.dataTable.rows[index].vat_percent = oil.vat_percent
          vm.dataTable.rows[index].revenue_stamp_percent = oil.revenue_stamp_percent
          vm.dataTable.rows[index].expense_account = oil.account_combine
          // vm.dataTable.rows[index].expense_account_desc = oil.account_combine_desc
          vm.dataTable.rows[index].gas_station_id = oil.gas_station_id
          vm.dataTable.rows[index].policy_set_header_id = oil.policy_set_header_id
          
          // ------------ begin ค้นหา account desc ------------
          var coa = oil.account_combine.split('.');
          axios.get("/ir/ajax/asset/validate-account", {
            params: {
              segmentAlls: coa,
            }
          }).then(res => {
              vm.dataTable.rows[index].expense_account_desc = res.data.desc;
          });
          // ------------ end ค้นหา account desc ------------

          this.duplicatedCheck(vm.dataTable.rows[index], index)
        } else {
          vm.dataTable.rows[index].type_code = ''
          vm.dataTable.rows[index].group_code = ''
          vm.dataTable.rows[index].group_name = ''
          // vm.dataTable.rows[index].vat_refund = "No"
          vm.dataTable.rows[index].vat_refund = 'N'
          vm.dataTable.rows[index].vat_percent = ''
          vm.dataTable.rows[index].revenue_stamp_percent = ''
          vm.dataTable.rows[index].expense_account = ''
          vm.dataTable.rows[index].expense_account_desc = ''
          vm.dataTable.rows[index].gas_station_id = ''
        }
        this.accountId = oil.account_id ? oil.account_id : '';
        vm.dataTable.rows[index].expense_account_id = this.accountId;
      },
      receivedDepartment(department, index) {
        const vm = this
        vm.dataTable.rows[index].department_name = department.description
        vm.dataTable.rows[index].department_code = department.department_code
        if (department) {
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${index}.department_code`).clearValidate()
        } else {
          this.$refs.save_table_line.validateField(`rows.${index}.department_code`)
        }
      },
      receivedCompany(company, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (company) {
          vm.dataTable.rows[index].company_name = company.desc
          vm.dataTable.rows[index].company_id = company.id
          vm.dataTable.rows[index].company_number = company.code
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.company_id`).clearValidate()
        } else {
          vm.dataTable.rows[index].company_name = ''
          vm.dataTable.rows[index].company_id = ''
          vm.dataTable.rows[index].company_number = ''
          this.$refs.save_table_line.validateField(`rows.${i}.company_id`)
        }
      },
      clickModalAccount(obj, i) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(obj);
        vm.indexTable = index
        if (obj.expense_account === null || obj.expense_account === undefined) {
          return;
        }
        let accountSplit = obj.expense_account.split('.')
        let descSplit = obj.expense_account_desc.split('.')
        let indexAccount = 0
        let indexDesc = 0

        if (obj.expense_account_desc) {
          for (let code in vm.accountGasStations) {
            vm.accountGasStations[code] = accountSplit[indexAccount]
            indexAccount++
          }
        }

        if  (obj.expense_account_desc) {
          for (let code in vm.descriptionGasStations) {
            vm.descriptionGasStations[code] = descSplit[indexDesc]
            indexDesc++
          }
        }
        this.accountId = obj.expense_account_id;
        this.type_cost = obj.type_cost;
      },
      getDataRowSelectAccount (dataRows) {
        this.dataTable.rows = dataRows
      },
      clickIncomplete () {
        this.locked = true;
        this.complete = false;
      },
      insuranceChange(value, i, data) {
        const vm = this;
        let index = vm.dataTable.rows.indexOf(data);
        vm.validatediscount(index)
        if (value) {
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.insurance_amount`).clearValidate()
        } else {
          vm.dataTable.rows[index].insurance_amount = ''
          this.$refs.save_table_line.validateField(`rows.${i}.insurance_amount`)
        }
        // vm.dataTable.rows[index].duty_amount = parseFloat(((value - +vm.dataTable.rows[index].discount) * +vm.dataTable.rows[index].revenue_stamp_percent) / 100).toFixed(2)
        // vm.dataTable.rows[index].vat_amount = parseFloat(((value - +vm.dataTable.rows[index].discount + +vm.dataTable.rows[index].duty_amount) * +vm.dataTable.rows[index].vat_percent) / 100).toFixed(2)
        // vm.dataTable.rows[index].net_amount = parseFloat(value - +vm.dataTable.rows[index].discount + +vm.dataTable.rows[index].duty_amount +  +vm.dataTable.rows[index].vat_amount).toFixed(2)
      },
      discountChange(value, i, data) {
        const vm = this;
        let index = vm.dataTable.rows.indexOf(data);
        vm.validatediscount(index)

        // vm.dataTable.rows[index].discount = !value ? 0 : value;
        // vm.dataTable.rows[index].duty_amount = parseFloat(((+vm.dataTable.rows[index].insurance_amount - value) * +vm.dataTable.rows[index].revenue_stamp_percent) / 100).toFixed(2)
        // vm.dataTable.rows[index].vat_amount = parseFloat(((+vm.dataTable.rows[index].insurance_amount - value + +vm.dataTable.rows[index].duty_amount) * +vm.dataTable.rows[index].vat_percent) / 100).toFixed(2)
        // vm.dataTable.rows[index].net_amount = parseFloat(+vm.dataTable.rows[index].insurance_amount - value + +vm.dataTable.rows[index].duty_amount +  +vm.dataTable.rows[index].vat_amount).toFixed(2)
      },
      validatediscount(index){
         const vm = this
          if(vm.dataTable.rows[index].insurance_amount < vm.dataTable.rows[index].discount ){
             vm.dataTable.rows[index].discount = 0;
             swal({
               title: "Warning",
                text: "ส่วนลดเบี้ยประกัน ต้องน้อยกว่าเท่ากับ ส่วนลด",
                type: "warning",
              })
              vm.$nextTick(()=>{
                vm.dataTable.rows[index].discount = 0;
              });
            return false;
          }
          return true;
      },
      receivedYear(year, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        vm.dataTable.rows[index].year = moment(year).format('YYYY') != 'Invalid date' ? moment(year).format('YYYY') : ''
        if (year) {
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.year`).clearValidate()
          this.duplicatedCheck(vm.dataTable.rows[index], index)
        } else {
          this.$refs.save_table_line.validateField(`rows.${i}.year`)
        }
      },
      async getAdjustmentDateStart(date, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (date === null) {
          vm.dataTable.rows[index].start_date = ''
          vm.dataTable.rows[index].start_timer = ''
          this.$refs.save_table_line.validateField(`rows.${i}.start_date`)
        } else {
          // vm.dataTable.rows[index].start_date = moment(date).format(vm.dateFormat)
          // let convertDate = await vm.parseToDate(date)
          // vm.dataTable.rows[index].start_timer = convertDate
          // vm.dataTable.rows[index].end_timer = moment(convertDate, 'DD/MM/YYYY').add(1, 'years').toDate()

          // vm.dataTable.rows[index].end_date = moment(date).add(1, 'years').format(vm.dateFormat)


          vm.dataTable.rows[index].start_date = date
          vm.dataTable.rows[index].start_timer = moment(date, 'DD/MM/YYYY')
          vm.dataTable.rows[index].end_timer = moment(date, 'DD/MM/YYYY').add(1, 'years').toDate()

          vm.dataTable.rows[index].end_date = moment(date, 'DD/MM/YYYY').add(1, 'years').toDate()



          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.start_date`).clearValidate()
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate()
        }

        if (vm.dataTable.rows[index].start_timer && vm.dataTable.rows[index].end_timer)
          vm.dataTable.rows[index].total_days = Math.floor((Math.abs(vm.dataTable.rows[index].start_timer - vm.dataTable.rows[index].end_timer))/(1000*60*60*24))
      },
      async getAdjustmentDateEnd (date, i, date2, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        let newdate2 = new Date(date2.split('/')[1] + '/' + date2.split('/')[0] + '/' + date2.split('/')[2]);
        if (date === null) {
          vm.dataTable.rows[index].end_date = ''
          vm.dataTable.rows[index].end_timer = ''
          this.$refs.save_table_line.validateField(`rows.${i}.end_date`)
        } else {
          vm.dataTable.rows[index].end_date = moment(date).format(vm.dateFormat)
          let convertDate = await vm.parseToDate(date)
          vm.dataTable.rows[index].end_timer = moment(convertDate, 'DD/MM/YYYY').toDate()
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate()
        }
         if (newdate2 === null) {
          vm.dataTable.rows[index].start_date = ''
          vm.dataTable.rows[index].start_timer = ''
          vm.$refs.save_table_line.validateField(`rows.${i}.start_date`)
        } else {
          vm.dataTable.rows[index].start_date = moment(newdate2).format(vm.dateFormat)
          let convertDate = await vm.parseToDate(newdate2)
          vm.dataTable.rows[index].start_timer = convertDate

          vm.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.start_date`).clearValidate()
          vm.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate()
        }
        if (vm.dataTable.rows[index].start_timer && vm.dataTable.rows[index].end_timer) {
          vm.dataTable.rows[index].total_days = Math.floor((Math.abs(vm.dataTable.rows[index].start_timer - vm.dataTable.rows[index].end_timer))/(1000*60*60*24))
        }
        if (vm.dataTable.rows[index].total_days < 365 || vm.dataTable.rows[index].total_days > 366 ) {
             swal({
                title: "Warning",
                text: "วันที่สิ้นสุดที่คิดค่าเบี้ยประกัน มากกว่าหรือน้อยกว่า 1 ปี ต้องการทำรายการต่อหรือไม่ ?",
                type: "warning",
              })
        }else{
           
        }
      },
      async parseToDate(value = null, format = 'DD/MM/YYYY') {
        if (value == null) {
          return moment().toDate()
        }
        return moment(value, format).subtract(543, 'years').toDate()
      },
      clickSave() {
        this.$refs.save_table_line.validate((valid) => {
          if (valid) {
            this.setComplete()
            this.locked = !this.locked;
          }
        })
      },
      ClickAddRow() {
        const vm = this;
        vm.lastRowId = uuid();
        this.locked = true;
        this.complete = false;
        axios.get('/ir/ajax/lov/period-year')
        .then(({data:response}) => {
          let obj = {
            row_id: vm.lastRowId,
            ex_gas_station_id: null,
            gas_station_id: null,
            document_number: null,
            year: (response.data.period_year).toString(),
            start_date: null,
            end_date: null,
            total_days: null,
            department_code: null,
            department_name: null,
            group_code: null,
            group_name: null,
            type_code: null,
            type_name: null,
            insurance_amount: 0,
            discount: 0,
            duty_amount: 0,
            revenue_stamp_percent: null,
            vat_percent: null,
            vat_amount: 0,
            net_amount: 0,
            return_vat_flag: null,
            policy_number: null,
            company_id: null,
            company_name: null,
            company_number: null,
            expense_account_id: null,
            expense_account: null,
            expense_account_desc: null,
            policy_set_header_id: null,
            status: 'New',
            flgAdd: true,
            isDuplicated: false,
            expense_flag: 'N',
            type_cost: '',
            coverage_amount: 0,
          }
          vm.dataTable.rows.push(obj)
          this.$nextTick(() => {
            const el = this.$el.getElementsByClassName('endTable')[0];
            if (el) {
              el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
            }
          });
        })
        .catch((error) => {
          swal("Error", error, "error")
        })

      },
      clickRemoveFlgAdd(dataRow, i) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(dataRow);
        swal({
          title: "Warning",
          text: "ต้องการลบหรือไม่?",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false
        },
        function (isConfirm) {
          if (isConfirm) {
            if (dataRow.ex_gas_station_id) {
              axios.post(`/ir/ajax/extend-gas-stations/delete`, dataRow).then(({data}) => {
                  vm.dataTable.rows.splice(index, 1)
                  // _this.tableLineAll.splice(i, 1);
                   
                  let res = data.data;
                  swal({
                    title: "Success",
                    text: 'ลบสำเร็จ',
                    type: "success",
                    showConfirmButton: true,
                    closeOnConfirm: false
                  });
              });
            } else { 
              vm.dataTable.rows.splice(index, 1)
              // _this.tableLineAll.splice(i, 1);
              swal({
                  title: "Success",
                  text: 'ลบสำเร็จ',
                  type: "success",
                  showCancelButton: false,
                  showConfirmButton: true
              })
            }
          }
        });
      },
      checkDuplicateField() {
        const vm = this
        let isDuplicated = false
        const rows = vm.dataTable.rows
        if (rows.length > 1) {
          rows.forEach((row, index) => {
            let findDup = rows.find((row2, index2) => index !== index2 &&
              row.year === row2.year && row.type_code === row2.type_code &&
              row.status !== 'Cancelled' && row2.status !== 'Cancelled')
            if (findDup) isDuplicated = true
          })
        } else {
          isDuplicated = rows[0].isDuplicated && rows[0].status !== 'Cancelled'
        }
        return isDuplicated
      },
      vatAmount(row) {
        let localString = parseFloat(((row.insurance_amount - +row.discount + row.duty_amount) * +row.vat_percent) / 100).toFixed(2)
        let currency = parseInt(localString.split('.')[0]).toLocaleString()
        let decimal = localString.split('.')[1]
        row.vat_amount = `${currency}.${decimal}`
        return `${currency}.${decimal}`
      },
      netAmount(row) {
        let localString = parseFloat(row.insurance_amount - +row.discount + row.duty_amount +  this.convertCurrenyToNum(row.vat_amount)).toFixed(2)
        let currency = parseInt(localString.split('.')[0]).toLocaleString()
        let decimal = localString.split('.')[1]
        row.net_amount = `${currency}.${decimal}`
        return `${currency}.${decimal}`
      },
      convertCurrenyToNum(currency) {
        return Number(currency.replace(/[^0-9.-]+/g,""))
      },
      duplicatedCheck(row, index) {
        const vm = this
        const params = {
          data: {
            rows: vm.dataTable.rows,
            year: row.year,
            type_code: row.type_code,
            status: row.status,
            row_id: index
          }
        }
        if (row.year && row.type_code) {
          axios.post(`/ir/ajax/extend-gas-stations/duplicate-check`, params)
            .then(res => {
              // let duplicated = vm.checkDuplicateField()
              // vm.dataTable.rows[index].isDuplicated = duplicated
              // if (duplicated) {
              //   swal({
              //     title: "Warning",
              //     text:  'ไม่สามารถเลือกรายการซ้ำได้',
              //     type: "warning",
              //   })
              // }
              vm.dataTable.rows[index].isDuplicated = false
            })
            .catch(error => {
              if (error.response.data.status === 400) {
                vm.dataTable.rows[index].isDuplicated = true
                swal({
                  title: "Warning",
                  text:  'ไม่สามารถเลือกรายการซ้ำ กับรายการที่บันทึกไปแล้วได้',
                  type: "warning",
                })
                  vm.$nextTick(()=>{
                    vm.dataTable.rows[index].type_code = '';
                  });
              } else {
                swal({
                  title: "Error",
                  text:  error.response.data.message,
                  type: "error",
                })
              }
            })
        }
        return
      },
      isDisabled(row) {
        if(!this.locked) return true;
        if (row && row.status === 'Interface') return true;
        if (row && row.re_create_flag == 'Y') return true;
        // if (row.status === 'Confirmed' && !row.flgAdd || row.status === 'Cancelled' && !row.flgAdd ||  row.status === 'Interface' && !row.flgAdd) return true
        // if (row.status === 'Interface' && !row.flgAdd) return true
        return false
      },
      setDefaultDate(oil, i, data){
        if (oil) {
          console.log(oil);
          if (oil.insurance_date) {

            const vm = this
            var index = vm.dataTable.rows.indexOf(data);
            var date_format = moment(String(oil.insurance_date)).format('DD/MM/YYYY');
            var split_date  = date_format.split('/');
            var date        = split_date[0] + '/' + split_date[1] + '/' + vm.dataTable.rows[index].year;

            vm.getAdjustmentDateStart(date, i, data);
          }

          vm.dataTable.rows[index].coverage_amount = oil.coverage_amount;
          vm.dataTable.rows[index].duty_amount = oil.revenue_stamp_percent;
        }
      },
      isCancellDisabled(row) {
        if(!this.locked) return true;

        var check_ref = this.dataTable.rows.find(data => data.reference_document_number == row.row);
        if (row.status === 'Cancelled' && check_ref) return true
        return false
      },
      ClickExport(){
        console.log('ClickExport ClickExport');
        console.log('ClickExport <--> ', this.dataExport);
        axios.get(this.urlExport, {
            params: {
              dataExport:   this.dataExport,
            }
        })
        .then(res => {
        })
        .catch(err => {
            console.log(err)
        });
      }
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
              sum += typeof data.duty_amount === 'string' ? this.convertCurrenyToNum(data.duty_amount) : +data.duty_amount
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
              sum += typeof data.vat_amount === 'string' ? this.convertCurrenyToNum(data.vat_amount) : +data.vat_amount
          })
        let fixedDecimal = sum.toFixed(2)
        let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
        let decimal = fixedDecimal.split('.')[1]
        if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
        return `${sum.toLocaleString()}.00`
      },
      netAmountSum() {
        let sum = 0
        if (this.dataTable.rows.length > 0)
          this.dataTable.rows.map(data => {
            if (data.status == 'Confirmed' || data.status == 'Interface')
              sum += typeof data.net_amount === 'string' ? this.convertCurrenyToNum(data.net_amount) : +data.net_amount
          })
        let fixedDecimal = sum.toFixed(2)
        let currency = Number(fixedDecimal.split('.')[0]).toLocaleString()
        let decimal = fixedDecimal.split('.')[1]
        if (fixedDecimal.split('.').length > 1) return `${currency}.${decimal}`
        return `${sum.toLocaleString()}.00`
      },
      tableTotal () {
        const vm                   = this;
        let find                   = null;
        let total_insurance_amount = 0;
        let total_discount         = 0;
        let total_duty_amount      = 0;
        let total_vat_amount       = 0;
        let total_net_amount       = 0;
        let dataTableTotal         = [];
        let check                  = [];

        if(vm.dataTable.rows.length === 0) return dataTableTotal;

        vm.dataTable.rows.forEach((item) => {

          find = null;
          find = dataTableTotal.find((search)=>{
            return search.policy_number == item.policy_number;
          });

          if(find){

            find.insurance_amount += item.status == 'Confirmed' || item.status == 'Interface' ? item.insurance_amount  ? parseFloat(item.insurance_amount)  : 0 : 0;
            find.discount         += item.status == 'Confirmed' || item.status == 'Interface' ? item.discount          ? parseFloat(item.discount)          : 0 : 0;
            find.duty_amount      += item.status == 'Confirmed' || item.status == 'Interface' ? item.duty_amount       ? parseFloat(item.duty_amount)       : 0 : 0;
            find.vat_amount       += item.status == 'Confirmed' || item.status == 'Interface' ? item.vat_amount        ? typeof item.vat_amount === 'string' ? this.convertCurrenyToNum(item.vat_amount) : item.vat_amount : 0 : 0;
            find.net_amount       += item.status == 'Confirmed' || item.status == 'Interface' ? item.net_amount        ? typeof item.net_amount === 'string' ? this.convertCurrenyToNum(item.net_amount) : item.net_amount : 0 : 0;
            find.status            = item.status;
          }else {

            check = dataTableTotal.find((list)=>{
              return list.group_name == item.group_name;
            });

            if (check) {

              check.insurance_amount += item.status == 'Confirmed' || item.status == 'Interface' ? item.insurance_amount ? parseFloat(item.insurance_amount) : 0 : 0;
              check.discount         += item.status == 'Confirmed' || item.status == 'Interface' ? item.discount         ? parseFloat(item.discount)         : 0 : 0;
              check.duty_amount      += item.status == 'Confirmed' || item.status == 'Interface' ? item.duty_amount      ? parseFloat(item.duty_amount)      : 0 : 0;
              check.vat_amount       += item.status == 'Confirmed' || item.status == 'Interface' ? item.vat_amount       ? typeof item.vat_amount === 'string' ? this.convertCurrenyToNum(item.vat_amount) : item.vat_amount : 0 : 0;
              check.net_amount       += item.status == 'Confirmed' || item.status == 'Interface' ? item.net_amount       ? typeof item.net_amount === 'string' ? this.convertCurrenyToNum(item.net_amount) : item.net_amount : 0 : 0;
              check.status            = item.status;

            } else {

              dataTableTotal.push({
                policy_number: item.policy_number,
                group_name:    item.group_name,
                insurance_amount: item.status == 'Confirmed' || item.status == 'Interface' ? item.insurance_amount ? parseFloat(item.insurance_amount) : 0 : 0,
                discount:         item.status == 'Confirmed' || item.status == 'Interface' ? item.discount         ? parseFloat(item.discount)         : 0 : 0,
                duty_amount:      item.status == 'Confirmed' || item.status == 'Interface' ? item.duty_amount      ? parseFloat(item.duty_amount)      : 0 : 0,
                vat_amount:       item.status == 'Confirmed' || item.status == 'Interface' ? item.vat_amount       ? typeof item.vat_amount === 'string' ? this.convertCurrenyToNum(item.vat_amount) : item.vat_amount : 0 : 0,
                net_amount:       item.status == 'Confirmed' || item.status == 'Interface' ? item.net_amount       ? typeof item.net_amount === 'string' ? this.convertCurrenyToNum(item.net_amount) : item.net_amount : 0 : 0,
                status:           item.status,
              });
            }
          }

          total_insurance_amount += item.status == 'Confirmed' || item.status == 'Interface' ? item.insurance_amount ? parseFloat(item.insurance_amount) : 0 : 0;
          total_discount         += item.status == 'Confirmed' || item.status == 'Interface' ? item.discount         ? parseFloat(item.discount)         : 0 : 0;
          total_duty_amount      += item.status == 'Confirmed' || item.status == 'Interface' ? item.duty_amount      ? parseFloat(item.duty_amount)      : 0 : 0;
          total_vat_amount       += item.status == 'Confirmed' || item.status == 'Interface' ? item.vat_amount       ? typeof item.vat_amount === 'string' ? this.convertCurrenyToNum(item.vat_amount) : item.vat_amount : 0 : 0;
          total_net_amount       += item.status == 'Confirmed' || item.status == 'Interface' ? item.net_amount       ? typeof item.net_amount === 'string' ? this.convertCurrenyToNum(item.net_amount) : item.net_amount : 0 : 0;

        });

        dataTableTotal.push({
          group_name: 'Total',
          insurance_amount:  total_insurance_amount,
          discount:          total_discount,
          duty_amount:       total_duty_amount,
          vat_amount:        total_vat_amount,
          net_amount:        total_net_amount,
        });
        // console.log('dataTableTotal <--> ', dataTableTotal);
        
        return dataTableTotal;
      }
    },
    props: [
      'dataTable',
      'setLabelExpenseFlag',
      'setLabelVatRefund',
      'formatCurrency',
      'urlExport',
      'fetchData'
    ],
    components: {
      lovDepartment,
      dateInput,
      currencyInput,
      lovCompany,
      modalAccountCode,
      lovOilType
    },
    mounted(){
      window.vm = this;
    },
    watch: {
      'dataTable.rows' (newVal, oldVal) {
        this.dataExport = [];
        this.dataTable.rows.forEach(element => {
          this.dataExport.push(element.ex_gas_station_id);
        });
      },
      'fetchData' () {
        if (this.fetchData) {
          this.complete = false;
        }
      }
    }
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