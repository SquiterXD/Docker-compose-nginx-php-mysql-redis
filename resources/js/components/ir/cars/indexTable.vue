<template>
  <div class="margin_top_20">
    <div class="table-responsive table_style_scroll"> 

      <table class="table table-striped table_style">
        <thead>
          <tr class="text-center">
            <th class="text-nowrap" v-show="tableTotal.length > 0"></th>
            <th class='text-right'>Total Premium<br>ค่าเบี้ยประกันรวม</th>
            <th class='text-right'>Total Discount<br>ส่วนลดรวม</th>
            <th class='text-right'>Total Duty Fee<br>อากรรวม</th>
            <th class='text-right'>Total Vat<br>ภาษีมูลค่าเพิ่มรวม</th>
            <th class='text-right'>Total Net Amount<br>ค่าเบี้ยประกันสุทธิรวม</th>
            <th class='text-right'>ค่าเบี้ยประกันเรียกเก็บสุทธิรวม</th>
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
              <td>{{formatCurrency(data.rec_insu)}}</td>
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
    </div>
    <div class='row my-3'>
      <div class="col-md-6">
        <!-- <a type="button" class="btn btn-sm btn-info" target="_bank"  @click='ClickExport()'> <i class="fa fa-print"></i> Export </a> -->
        <form :action="urlExport"  target="_bank">
            <!-- <input type="hidden" name="data_table[]" value="dataTable" v-model="dataExport"> -->
            <input type="hidden" name="data_table" :value="dataExport">
            <button class="btn btn-sm btn-info" target="_bank"><i class="fa fa-print"></i> Export</button>
        </form>
      </div>
      <div class="col-md-6 text-right">
        <button type="danger" class='btn btn-success m-1' @click='ClickAddRow()'><i class="fa fa-plus"></i> เพิ่ม</button>
      </div>
    </div>

    <div class="">
      <div>
        <el-form  :model="dataTable"
                  ref="save_table_line"
                  label-width="120px"
                  :rules="rules"
                  class="demo-dynamic form_table_line">

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
                  :name="`cars_select_all`"
                  style='position: inherit;'
                  :disabled="!locked"
                >
              </div>
            </template>
            <template #head(status)="header">
              <div>
                IR Status<br>สถานะ
              </div>
            </template>
            <template #head(year)="header">
              <div>
                Year<br>ปี *
              </div>
            </template>
            <template #head(license_plate)="header">
              <div>
                License plate<br>ทะเบียนรถยนต์ *
              </div>
            </template>
            <template #head(receivable_name)="header">
              <div>
                เรียกเก็บ
              </div>
            </template>
            <template #head(renew_typex)="header">
              <div>
                Renew type<br>ประเภทการต่ออายุ *
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
                Tax recoverable<br>ภาษีขอคืนได้
              </div>
            </template>
            <template #head(insurance_expense)="header">
              <div>
                Insurance Expense<br> ค่าเบี้ยประกันตัดค่าใช้จ่าย
              </div>
            </template>
            <template #head(car_type)="header">
              <div>
                Car type<br>ประเภทรถยนต์
              </div>
            </template>
            <template #head(policy_number)="header">
              <div>
                Policy no.<br>เลขที่กรมธรรม์
              </div>
            </template>
            <template #head(company_id)="header">
              <div>
                Company code<br>รหัสผู้รับประกันภัย
              </div>
            </template>
            <template #head(company_name)="header">
              <div>
                Company name<br>ผู้รับประกันภัย
              </div>
            </template>
            <template #head(asset_number)="header">
              <div>
                Asset number<br>เลขที่สินทรัพย์
              </div>
            </template>
            <template #head(group_name)="header">
              <div>
                Group<br>กลุ่ม *
              </div>
            </template>
            <template #head(location_code)="header">
              <div>
                Location Code<br>รหัสสถานที่ *
              </div>
            </template>
            <template #head(location_description)="header">
              <div>
                Location<br>สถานที่
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
            <template #head(car_brand)="header">
              <div>
                Brand<br>ยี่ห้อ
              </div>
            </template>
            <template #head(car_cc)="header">
              <div>
                CC.<br>ซีซี รถ
              </div>
            </template>
            <template #head(engine_number)="header">
              <div>
                Engine number<br>หมายเลขเครื่องยนต์
              </div>
            </template>
            <template #head(tank_number)="header">
              <div>
                Vehicle identification Number<br>หมายเลขตัวถัง
              </div>
            </template>
            <template #head(expense_flag)="header">
              <div>
                สถานะการตัดค่าใช้จ่าย
              </div>
            </template>
            <template #head(document_number)="header">
              <div>
                Document number<br>เลขที่เอกสาร
              </div>
            </template>
            <template #head(action)="header">
              <div>
                Action
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
                  :name="`cars_select${row.item.row_id}`" 
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
            <template #cell(license_plate)="row">
              <el-form-item 
                :prop="'rows.' + row.index + '.license_plate'"
                :rules="rules.license_plate"
                :class='row.item.isDuplicated ? "el-input--small is-error" : "el-input--small"'>
              <lov-vehicle  
                v-model='row.item.license_plate'
                :value='row.item.license_plate'
                name='license_plate'
                placeholder='ทะเบียนรถยนต์'
                :sizeSmall='true'
                @vehicle='receivedLicensePlate(...arguments, row.index, row.item)'
                :disabled="isDisabled(row.item)"
                :paramsQuery='paramsQueryLicensePlate'/>
              </el-form-item>
            </template>
            <template #cell(receivable_name)="row">
              <el-form-item
                :class='row.item.isDuplicated ? "el-input--small is-error" : "el-input--small"'>
                <lov-receivable 
                  :name="`receivable_name${row.index}`"
                  v-model="row.item.receivable_name"
                  @change-lov="getValueReceivable(...arguments, row.index, row.item)"
                  :disabled="isDisabled(row.item)"
                  placeholder="เรียกเก็บ"
                  size="small"
                  :popperBody="true" />
              </el-form-item>
            </template>
            <template #cell(renew_typex)="row">
              <el-form-item 
                :prop="'rows.' + row.index + '.renew_type_code'"
                :rules="rules.renew_type_code"
                :class='row.item.isDuplicated ? "el-input--small is-error" : "el-input--small"'>
                <lov-renew-type 
                  v-model="row.item.renew_type"
                  :value='row.item.renew_type'
                  name='renew_type_code'
                  placeholder='ประเภทการต่ออายุ'
                  :sizeSmall='true'
                  :disabled="isDisabled(row.item)"
                  @renewType='receivedRenewType(...arguments, row.index, row.item)'/>
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
              <div>{{row.item.total_days ? row.item.total_days : '0'}}</div>
            </template>
            <template #cell(insurance_amount)="row">
              <el-form-item 
                :prop="'rows.' + row.index + '.insurance_amount'"
                :rules="rules.insurance_amount"
                class="currency_right">
                <div class="el-input el-input--small">
                  <vue-numeric class="form-control el-input__inner input-currency text-right" 
                    style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                    placeholder="ค่าเบี้ยประกัน" :empty-value="0" @change='insuranceChange(...arguments, row.index, row.item)'
                    :min="0" :minus="false" :precision="2" separator="," v-model="row.item.insurance_amount"></vue-numeric>
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
                  <vue-numeric class="form-control el-input__inner input-currency text-right" 
                    style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                    placeholder="ส่วนลด" :empty-value="0" @change="discountChange(...arguments, row.index, row.item)"
                    :min="0" :minus="false" :precision="2" separator="," v-model="row.item.discount"></vue-numeric>
                </div>
                <!-- <currency-input 
                  v-model="row.item.discount"
                  placeholder="ส่วนลด"
                  :sizeSmall='true'
                  @input='discountChange(...arguments, row.index)'
                  :disabled="isDisabled(row.item)"/> -->
              </el-form-item>
            </template>
            <template #cell(duty_amount)="row">
              <!-- <div>
                {{ formatCurrency(dutyAmount(row.item)) }}
              </div> -->
              <div class="el-input el-input--small">
                <vue-numeric class="form-control el-input__inner input-currency text-right" 
                  style="min-width: 100px;" :disabled="isDisabled(row.item)" 
                  placeholder="อากร" :empty-value="0" @change="dutyChange(...arguments, row.index, row.item)"
                  :min="0" :minus="false" :precision="2" separator="," v-model="row.item.duty_amount"></vue-numeric>
              </div>
            </template>
            <template #cell(vat_amount)="row">
              <div>
                {{ formatCurrency(vatAmount(row.item)) }}
              </div>
            </template>
            <template #cell(net_amount)="row">
              <div>
                {{ formatCurrency(netAmount(row.item)) }}
              </div>
            </template>
            <template #cell(vat_refund)="row">
              <div>
                {{ row.item.vat_refund ? row.item.vat_refund : '' }}
              </div>
            </template>
            <template #cell(insurance_expense)="row">
              <div>
                {{ formatCurrency(insuranceExpense(row.item)) }}
              </div>
            </template>
            <template #cell(car_type)="row">
              <div>
                {{ row.item.car_type ? row.item.car_type : '' }}
              </div>
            </template>
            <template #cell(policy_number)="row">
              <el-form-item>
                <el-input 
                  v-model='row.item.policy_number'
                  :disabled="isDisabled(row.item)"
                  placeholder="เลขที่กรมธรรม์"
                  class='el-input--small'/>
              </el-form-item>
            </template>
            <template #cell(company_id)="row">
              <el-form-item 
                :prop="'rows.' + row.index + '.company_id'"
                :rules="rules.company_id"
                class="currency_right">
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
            <template #cell(asset_number)="row">
              <div>
                {{ row.item.asset_number ? row.item.asset_number : '' }}
              </div>
            </template>
            <template #cell(group_name)="row">
              <el-form-item 
                :prop="'rows.' + row.index + '.group_name'"
                :rules="rules.group_name">
                <div>
                  {{row.item.group_name ? row.item.group_name : ''}}
                </div>
              </el-form-item>
            </template>
            <template #cell(location_code)="row">
              <el-form-item 
                :prop="'rows.' + row.index + '.location_code'"
                :rules="rules.location_code">
                <lov-location 
                  v-model="row.item.location_code"
                  set-name="FA_LOCATION"
                  :set-data="row.item.location_code"
                  placeholder="รหัสสถานที่"
                  @getLocation="getLocation(...arguments, row.index, row.item)"
                  :disabled="isDisabled(row.item)"/>
              </el-form-item>
            </template>
            <template #cell(location_description)="row">
              <div>
                {{ row.item.location_description ? row.item.location_description : '' }}
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
                  disabled>
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
            <template #cell(car_brand)="row">
              <div>
                {{ row.item.car_brand ? row.item.car_brand : '' }}
              </div>
            </template>
            <template #cell(car_cc)="row">
              <div>
                {{ row.item.car_cc ? row.item.car_cc : '' }}
              </div>
            </template>
            <template #cell(engine_number)="row">
              <div>
                {{ row.item.engine_number ? row.item.engine_number : '' }}
              </div>
            </template>
            <template #cell(tank_number)="row">
              <div>
                {{ row.item.tank_number ? row.item.tank_number : '' }}
              </div>
            </template>
            <template #cell(expense_flag)="row">
              <div>
                {{ setLabelExpenseFlag(row.item.expense_flag) }}
              </div>
            </template>
            <template #cell(document_number)="row">
              <div>
                {{ row.item.document_number ? row.item.document_number : '' }}
              </div>
            </template>
            <template #cell(action)="row">
              <el-form-item v-show="checkCopy(row.item)">
                <button type="button" class="btn btn-sm btn-success" @click="copyRow(row.item)">
                  <i class="fa fa-files-o" aria-hidden="true"></i>
                  คัดลอก
                </button>
              </el-form-item>
            </template>
            <template #cell(remove)="row">
              <el-form-item v-show="row.item.status == 'NEW' && !isDisabled(row.item)">
                <button type="button" class="btn btn-sm btn-danger" @click="removeRow(row.item)">
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

                <button type="button" v-show="!locked"
                  class="btn btn-danger cursor-pointer"
                  :disabled='dataTable.rows.length === 0'
                  @click="clickIncomplete()">
                  <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
                </button>

                <!-- <input type="checkbox" v-model="locked">x{{locked}}x -->
                <!-- <button  class='btn btn-primary' @click='clickComplete()' v-show="complete"><i class='fa fa-check-square-o'></i> Completed</button>
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

    <modal-account-code :index="indexTable"
                        :rows="dataTable.rows"
                        @select-accounts="getDataRowSelectAccount"
                        :accounts="accountCars"
                        :descriptions="descriptionCars"
                        :disabled="true"
                        :accountId="accountId"
                        :type_cost="type_cost" />
                        <!-- :disabled="dataTable.rows[indexTable] ? isDisabled(dataTable.rows[indexTable]) : false" -->
  </div>
</template>

<script>
  import uuid from 'uuid/v1';
  import modalAccountCode from './modalAccountCode'
  import dateInput from '../components/calendar/dateInput'
  import currencyInput from '../components/currencyInput'
  import lovCompany from './lovCompany'
  import lovDepartment from './lovDepartment'
  import lovRenewType from './lovRenewTypedesc'
  import lovVehicle from './lovVehicle'
  import lovAssetStatus from './lovAssetStatus'
  import lovLocation from './lovLocation'
  import moment from 'moment'
  import lovReceivable from './lovReceivable'
  import dropdownStatusAsset from '../components/dropdown/statusAsset'
import { api_pd_flavorNo_store } from '../../../router';

  export default {
    name: 'index-table-cars',
    data() {
      return {
        dateFormat: 'DD/MM/YYYY',
        complete: true,
        locked: false,
        rowselect: -1,
        columnSelected: [],
        columnSelectedId: [],
        lastRowId: -1,
        indexTable: -1,
        accountCars: {
          company: '',
          evm: '',
          department: '',
          cost_center: '',
          budget_year: '',
          budget_type: '',
          budget_detail: '',
          budget_reason: '',
          main_account: '',
          sub_account: '',
          reserved1: '',
          reserved2: '',
        },
        descriptionCars: {
          company: '',
          evm: '',
          department: '',
          cost_center: '',
          budget_year: '',
          budget_type: '',
          budget_detail: '',
          budget_reason: '',
          main_account: '',
          sub_account: '',
          reserved1: '',
          reserved2: '',
        },
        rules: {
          year: [
            {required: true, message: 'กรุณาระบุปี', trigger: 'blur'},
          ],
          license_plate: [
            {required: true, message: 'กรุณาระบุทะเบียนรถยนต์', trigger: 'blur'},
          ],
          department_code: [
            {required: true, message: 'กรุณาระบุรหัสหน่วยงาน', trigger: 'blur'},
          ],
          location_code: [
            {required: true, message: 'กรุณาระบุรหัสสถานที่', trigger: 'blur'},
          ],
          asset_status: [
             {required: true, message: 'กรุณาระบุประเภทสถานะทรัพย์สิน', trigger: 'blur'},
          ],
          renew_type_code: [
            {required: true, message: 'กรุณาระบุประเภทการต่ออายุ', trigger: 'blur'},
          ],
          start_date: [
            {required: true, message: 'กรุณาระบุวันที่เริ่มต้น', trigger: 'blur'},
          ],
          end_date: [
            {required: true, message: 'กรุณาระบุวันที่สิ้นสุด', trigger: 'blur'},
          ],
          group_code: [
            {required: true, message: 'กรุณาระบุกลุ่ม', trigger: 'blur'},
          ],
          insurance_amount: [
            {required: true, message: 'กรุณาระบุค่าเบี้ยประกัน', trigger: 'blur'},
          ],
          expense_account: [
            {required: true, message: 'กรุณาระบุรหัสค่าใช้จ่าย', trigger: 'blur'},
          ],
        },
        paramsQueryLicensePlate: {
          renew_type: '',
          license_plate: '',
          group: '',
        },
        accountId: '',
        type_cost: '',
        receivables: [],
        net_amount: 0,
        result_receivable: [],
        // tableTotal: [],
        fields: [
          { key: 'selected', sortable: false, class:'text-center text-nowrap', },
          { key: 'status', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'year', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 120px;', tdClass: 'el_field' },
          { key: 'license_plate', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 150px;', tdClass: 'el_field' },
          { key: 'receivable_name', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 110px;', tdClass: 'el_field' },
          { key: 'renew_typex', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
          { key: 'start_date', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
          { key: 'end_date', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
          { key: 'total_days', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'insurance_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 125px;', tdClass: 'el_field' },
          { key: 'discount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 125px;', tdClass: 'el_field' },
          { key: 'duty_amount', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'vat_amount', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'net_amount', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'vat_refund', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'insurance_expense', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'car_type', sortable: true, thClass:'text-center text-nowrap', tdClass: 'align-middle text-nowrap', },
          { key: 'policy_number', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
          { key: 'company_id', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
          { key: 'company_name', sortable: true, thClass:'text-center text-nowrap', tdClass: 'text-nowrap', },
          { key: 'asset_number', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'group_name', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'location_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 145px;', tdClass: 'el_field' },
          { key: 'location_description', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'expense_account', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 420px;', tdClass: 'el_field'  },
          { key: 'expense_account_desc', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'car_brand', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'car_cc', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'engine_number', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'tank_number', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'expense_flag', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'document_number', sortable: true, class:'text-center text-nowrap', tdClass:'align-middle' },
          { key: 'action', sortable: false, class:'text-center text-nowrap', thStyle: 'min-width: 65px;', },
          { key: 'remove', sortable: false, class:'text-center text-nowrap', thStyle: 'min-width: 65px;', },
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
      updateLock(tf){
        this.locked = tf;
      },
      selectRow(idx){
        this.rowselect = idx;
      },
      clickSelectRow (row_id, obj) {
        let vm = this;
        let checked = $(`input[name="cars_select${row_id}"]`).is(':checked')
        if (checked) {
          vm.setSelectedColumn(obj)
          let setDataRowsNotInterface = vm.dataTable.rows.filter((row, i) => {
            return !vm.isDisabled(row);
          })
          if(setDataRowsNotInterface.length === vm.columnSelected.length){
            $(`input[name="cars_select_all"]`).prop('checked', true)
          }
        } else {
          const index = vm.columnSelected.indexOf(obj);
          if (index > -1) {
            vm.columnSelected.splice(index, 1);
            vm.columnSelectedId.splice(index, 1);
          }
          $(`input[name="cars_select_all"]`).prop('checked', false)
        }
      },
      receivedYear(year, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (year) {
          vm.dataTable.rows[index].year = moment(year).format('YYYY') != 'Invalid date' ? moment(year).format('YYYY') : ''
          vm.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.year`).clearValidate()
          vm.duplicatedCheck(vm.dataTable.rows[index], index, 'year')
        } else {
          vm.dataTable.rows[index].year = ''
          this.$refs.save_table_line.validateField(`rows.${i}.year`)
        }
      },
      warningday367(){
        swal({
          title: "Warning",
          text: "วันที่สิ้นสุดที่คิดค่าเบี้ยประกัน มากกว่าหรือน้อยกว่า 1 ปี ต้องการทำรายการต่อหรือไม่ ?",
          type: "warning",
        })
      },
      async getAdjustmentDateStart(date, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (date === null) {
          vm.dataTable.rows[index].start_date = ''
          vm.dataTable.rows[index].start_timer = ''
          vm.$refs.save_table_line.validateField(`rows.${i}.start_date`)
        } else {
          vm.dataTable.rows[index].start_date = moment(date).format(vm.dateFormat);
          vm.dataTable.rows[index].end_date = moment(date).add(1, 'years').format(vm.dateFormat);
          let convertDate = await vm.parseToDate(date);
          vm.dataTable.rows[index].start_timer = convertDate;
          vm.dataTable.rows[index].end_timer = moment(convertDate, 'DD/MM/YYYY').add(1, 'years').toDate();
          vm.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.start_date`).clearValidate();
          vm.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.end_date`).clearValidate();
        }

        if (vm.dataTable.rows[index].start_timer && vm.dataTable.rows[index].end_timer) {
          vm.dataTable.rows[index].total_days = Math.floor((Math.abs(vm.dataTable.rows[index].start_timer - vm.dataTable.rows[index].end_timer))/(1000*60*60*24));
          let  yearday =  vm.getyeardays(vm.dataTable.rows[index].start_date);
          if(vm.dataTable.rows[index].total_days > yearday || vm.dataTable.rows[index].total_days  < yearday ){
            vm.warningday367();
          }
        }
      },
      async setCopyRowDate(row, index) {
        const vm = this
        vm.dataTable.rows[index].start_date = ['NEW', 'CANCEL', 'INTERFACE'].includes(row.status) ? row.start_date : row.end_date;
        vm.dataTable.rows[index].end_date = ['NEW', 'CANCEL', 'INTERFACE'].includes(row.status) ? row.end_date : moment(row.start_date, vm.dateFormat).add(1, 'years').format(vm.dateFormat);

        let jsStartDate = await vm.parseToDate(vm.dataTable.rows[index].start_date);
        let jsEndDate = await vm.parseToDate(vm.dataTable.rows[index].end_date);
        vm.dataTable.rows[index].start_timer = jsStartDate;
        vm.dataTable.rows[index].end_timer = jsEndDate;
        vm.dataTable.rows[index].total_days = Math.floor((Math.abs(vm.dataTable.rows[index].start_timer - vm.dataTable.rows[index].end_timer))/(1000*60*60*24));
      },
      getyeardays(start_date){
         if(start_date) {
            const arr  =  start_date.split('/')  // 01/03/2565  วันเดือนปี
            const day = arr[0]
            const month = arr[1]
            const year = +arr[2]-543
            const date1 = new Date(month +  '/' + day + '/' + year );
            const d = new Date(month+'/'+ day+'/'+year)
            const date2 = new Date(d.setFullYear(d.getFullYear() + 1));
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
         } else  return 0
      },
      async getAdjustmentDateEnd (date, i, date2, data) {
        let newdate2 = new Date(date2.split('/')[1] + '/' + date2.split('/')[0] + '/' + date2.split('/')[2]);
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (date === null) {
          vm.dataTable.rows[index].end_date = ''
          vm.dataTable.rows[index].end_timer = ''
          this.$refs.save_table_line.validateField(`rows.${i}.end_date`)
        } else {
          vm.dataTable.rows[index].end_date = moment(date).format(vm.dateFormat)
          let convertDate = await vm.parseToDate(date)
          vm.dataTable.rows[index].end_timer = moment(convertDate, 'DD/MM/YYYY').toDate()
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${index}.end_date`).clearValidate()
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
            let yearday =  vm.getyeardays(vm.dataTable.rows[index].start_date)
            if(vm.dataTable.rows[index].total_days > yearday || vm.dataTable.rows[index].total_days  < yearday ){
              vm.warningday367();
            }
        }
      },
      getDataRowSelectAccount (dataRows) {
        this.dataTable.rows = dataRows
      },
      clickSelectAll () {
        let vm = this;
        vm.columnSelected = [];
        vm.columnSelectedId = [];
        let checked = $(`input[name="cars_select_all"]`).is(':checked')
        vm.dataTable.rows.forEach((row, index) => {
          if (checked && !vm.isDisabled(row)) {
            vm.setSelectedColumn(row);
          }
        })
      },
      getValueAssetStatus (value, index) {
        this.dataTable.rows[index].asset_status = value
      },
      receivedLicensePlate(license, i, data) {
        const vm = this;
        let index = vm.dataTable.rows.indexOf(data);
        let desc_coa = '';
        var car_type_split = '' ;
        if (license) {
          // Add 15042022 Piyawut A.
          axios.get("/ir/ajax/vehicles/get-coa-desc", {
                    params: {coa: license.account_number}
                  })
          .then(res => {
            vm.dataTable.rows[index].expense_account_desc = res.data.desc_disply;
          });

          if (license.vehicle_type_name) {
            car_type_split = license.vehicle_type_name.split('(');
          }

          vm.dataTable.rows[index].license_plate = license.license_plate;
          vm.dataTable.rows[index].renew_type_code = license.renew_type_code;
          vm.dataTable.rows[index].renew_typex = license.renew_type_code;
          vm.dataTable.rows[index].group_name = license.group_desc;
          vm.dataTable.rows[index].group_code = license.group_code;
          vm.dataTable.rows[index].vat_refund = license.return_vat_flag === 'Y' ? "Yes" : 'No';
          // vm.dataTable.rows[index].car_type = license.vehicle_type_name;
          vm.dataTable.rows[index].car_type = car_type_split[0];
          vm.dataTable.rows[index].car_type_code = license.vehicle_type_code;
          vm.dataTable.rows[index].asset_number = license.asset_number;
          vm.dataTable.rows[index].vat_percent = license.vat_percent;
          vm.dataTable.rows[index].car_brand = license.car_brand;
          vm.dataTable.rows[index].car_cc = license.vehicle_cc;
          vm.dataTable.rows[index].engine_number = license.engine_number;
          vm.dataTable.rows[index].tank_number = license.tank_number;
          vm.dataTable.rows[index].policy_set_header_id = license.policy_set_header_id;
          vm.dataTable.rows[index].department_code = license.department_code;
          vm.dataTable.rows[index].department_name = license.department_desc;
          vm.dataTable.rows[index].revenue_stamp_percent = license.revenue_stamp_percent;

          vm.dataTable.rows[index].expense_account_id = license.account_id;
          // vm.dataTable.rows[index].expense_account_desc = desc_coa //change; 15042022 Piyawut A.
          vm.dataTable.rows[index].expense_account = license.account_number;

          vm.dataTable.rows[index].location_code = license.location_code;
          vm.dataTable.rows[index].location_description = license.location_description;
          vm.dataTable.rows[index].car_brand = license.vehicle_brand_name;
          vm.dataTable.rows[index].car_brand_code = license.vehicle_brand_code;
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.license_plate`).clearValidate()
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.renew_type_code`).clearValidate()

          vm.duplicatedCheck(vm.dataTable.rows[index], index, 'license_plate')
        } else {
          vm.dataTable.rows[index].license_plate = ''
          vm.dataTable.rows[index].renew_type_code = ''
          vm.dataTable.rows[index].renew_typex = ''
          vm.dataTable.rows[index].group_name = ''
          vm.dataTable.rows[index].group_code = ''
          vm.dataTable.rows[index].vat_refund = ''
          vm.dataTable.rows[index].car_type = ''
          vm.dataTable.rows[index].car_type_code = ''
          vm.dataTable.rows[index].asset_number = ''
          vm.dataTable.rows[index].vat_percent = ''
          vm.dataTable.rows[index].car_brand = ''
          vm.dataTable.rows[index].car_cc = ''
          vm.dataTable.rows[index].engine_number = ''
          vm.dataTable.rows[index].tank_number = ''
          vm.dataTable.rows[index].policy_set_header_id = ''
          vm.dataTable.rows[index].department_code = ''
          vm.dataTable.rows[index].department_name = ''
          vm.dataTable.rows[index].revenue_stamp_percent = ''

          vm.dataTable.rows[index].expense_account_id = ''
          vm.dataTable.rows[index].expense_account_desc = ''
          vm.dataTable.rows[index].expense_account = ''
          this.$refs.save_table_line.validateField(`rows.${i}.license_plate`)
          this.$refs.save_table_line.validateField(`rows.${i}.renew_type_code`)
        }
        this.accountId = license ? (license.expense_account_id ? license.expense_account_id : '') : '';
      },
      receivedCompany(company, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        vm.dataTable.rows[index].company_number = company.code
        vm.dataTable.rows[index].company_name = company.desc
        vm.dataTable.rows[index].company_id = company.id

        if (company) {
          vm.dataTable.rows[index].company_number = company.code
          vm.dataTable.rows[index].company_name = company.desc
          vm.dataTable.rows[index].company_id = company.id
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.company_id`).clearValidate()
        } else {
          vm.dataTable.rows[index].company_number = ''
          vm.dataTable.rows[index].company_name = ''
          vm.dataTable.rows[index].company_id = ''
          this.$refs.save_table_line.validateField(`rows.${i}.company_id`)
        }
      },
      receivedRenewType(renew, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        if (renew) {
          vm.dataTable.rows[index].renew_type_code = renew.lookup_code;
          vm.dataTable.rows[index].renew_type = renew.meaning;
          vm.dataTable.rows[index].renew_typex = renew.lookup_code+':'+renew.meaning;
          vm.dataTable.rows[index].vat_flag = renew.tag || 'N';
          // let renews = renew.split(':');
          // vm.dataTable.rows[index].renew_type_code = renews[0];
          // vm.dataTable.rows[index].renew_type = renews[1];
          // vm.dataTable.rows[index].renew_typex = renews[0]+':'+renews[1];
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${i}.renew_type_code`).clearValidate()
          vm.duplicatedCheck(vm.dataTable.rows[index], index, 'renew_type')
        } else {
          vm.dataTable.rows[index].renew_type_code = '';
          vm.dataTable.rows[index].renew_type = '';
          vm.dataTable.rows[index].renew_typex = '';
          vm.dataTable.rows[index].vat_flag = 'N';
          this.$refs.save_table_line.validateField(`rows.${i}.renew_type_code`)
        }
      },
      clickModalAccount (obj, i) {
         
        const vm = this
        let index = vm.dataTable.rows.indexOf(obj);
        vm.indexTable = index
        if (obj.expense_account === null || obj.expense_account === undefined || obj.expense_account === '') {
          return;
        }
        let accountSplit = obj.expense_account.split('.')
        // let descSplit = obj.expense_account_desc.split('.')
        let indexAccount = 0
        // let indexDesc = 0
        vm.accountCars.company = '';
        vm.accountCars.evm = '';
        vm.accountCars.department = '';
        vm.accountCars.cost_center = '';
        vm.accountCars.budget_year = '';
        vm.accountCars.budget_type = '';
        vm.accountCars.budget_detail = '';
        vm.accountCars.budget_reason = '';
        vm.accountCars.main_account = '';
        vm.accountCars.sub_account = '';
        vm.accountCars.reserved1 = '';
        vm.accountCars.reserved2 = '';

        vm.descriptionCars.company = '';
        vm.descriptionCars.evm = '';
        vm.descriptionCars.department = '';
        vm.descriptionCars.cost_center = '';
        vm.descriptionCars.budget_year = '';
        vm.descriptionCars.budget_type = '';
        vm.descriptionCars.budget_detail = '';
        vm.descriptionCars.budget_reason = '';
        vm.descriptionCars.main_account = '';
        vm.descriptionCars.sub_account = '';
        vm.descriptionCars.reserved1 = '';
        vm.descriptionCars.reserved2 = '';

        if (obj.expense_account) {
          for (let code in vm.accountCars) {
            vm.accountCars[code] = accountSplit[indexAccount]
            // vm.descriptionCars[code] = descSplit[indexAccount]
            indexAccount++
          }
        }

        // if  (obj.expense_account_desc) {
        //   for (let code in vm.descriptionCars) {
        //     vm.descriptionCars[code] = descSplit[indexDesc]
        //     indexDesc++
        //   }
        // }
        vm.accountId = obj.expense_account_id;
        vm.type_cost = obj.type_cost;
      },
      setSelectedColumn (data) {
        this.columnSelected.push(data)
        this.columnSelectedId.push(data.row_id);
      },
      receivedDepartment(department, index) {
        const vm = this
        if (department) {
          vm.dataTable.rows[index].department_name = department.description
          vm.dataTable.rows[index].department_code = department.value
          this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${index}.department_code`).clearValidate()
        } else {
          vm.dataTable.rows[index].department_name = ''
          vm.dataTable.rows[index].department_code = ''
          this.$refs.save_table_line.validateField(`rows.${index}.department_code`)
        }
      },
      clickConfirm () {
        if (this.columnSelected.length === 0) {
          swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยืนยัน!', 'warning');
          return
        }
        this.$refs.save_table_line.validate((valid) => {
          if (valid) {
            this.columnSelected.filter((row, index) => {
              row.status = 'CONFIRMED'
              return row
            })
            $(`input[name="cars_select_all"]`).prop('checked', false)
            this.columnSelected = []
            this.columnSelectedId = []
            // this.setReceivables();
            // this.calTableTotal();
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
            this.columnSelected.filter((row, index) => {
              row.status = 'CANCELLED'
              return row
            })
            $(`input[name="cars_select_all"]`).prop('checked', false)
            this.columnSelected = []
            this.columnSelectedId = []
            // this.setReceivables();
            // this.calTableTotal();
            return
          } else {
            return false;
          }
        })
      },
      clickClear () {
        const vm = this;
        if (vm.columnSelected.length === 0) {
          swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการรีเซต!', 'warning')
          return
        }
        vm.$refs.save_table_line.validate((valid) => {
          if (valid) {
            vm.columnSelected.filter((row, index) => {
              row.status = 'NEW'
              return row
            })
            $(`input[name="cars_select_all"]`).prop('checked', false)
            vm.columnSelected = []
            vm.columnSelectedId = []
            // vm.setReceivables();
            // vm.calTableTotal();
            return
          } else {
            return false;
          }
        })
      },
      clickSave() {
        const vm = this;
        vm.$emit('loading', true);
        vm.$refs.save_table_line.validate((valid) => {
          if (valid) {
            vm.setComplete()
          }else {
            vm.$emit('loading', false);
          }
        })
      },
      clickComplete () {
        vm.$emit('loading', true);
        vm.$refs.save_table_line.validate((valid) => {
          if (valid) {
            vm.setComplete()
          }else {
            vm.$emit('loading', false);
          }
        })
      },
      setComplete () {
        const vm = this;
        vm.$emit('loading', true);
        const isFlgAdd = (row) => row.flgAdd
        if (vm.dataTable.rows.every(isFlgAdd)) {
          if (vm.checkDuplicateField()) {
            swal({
              title: "Warning",
              text:  'ไม่สามารถ Save รายการซ้ำได้',
              type: "warning",
            })
            vm.$emit('loading', false);

          } else {
            vm.dataTable.rows.forEach(row => {
              row.isDuplicated = false
            })
            // vm.saveCars()
            var check_day = this.dataTable.rows.find(row => row.total_days == '');

            if (check_day) {
              swal({
                title: "Warning",
                text:  'ไม่สามารถ Save ได้ เนื่องจากจำนวนวัน เป็น 0',
                type: "warning",
              })
              vm.$emit('loading', false);
            } else {
              this.saveCars()
            }
          }
        } else if (vm.dataTable.rows.find(row => row.isDuplicated )) {
          swal({
            title: "Warning",
            text:  'ไม่สามารถ Save รายการซ้ำได้',
            type: "warning",
          })
          vm.$emit('loading', false);
        } else {
          // vm.saveCars()
          var check_day = this.dataTable.rows.find(row => row.total_days == '');

            if (check_day) {
              swal({
                title: "Warning",
                text:  'ไม่สามารถ Save ได้ เนื่องจากจำนวนวัน เป็น 0',
                type: "warning",
              })
              vm.$emit('loading', false);
            } else {
              this.saveCars()
            }
        }
      },
      saveCars() {
        const vm = this;
        vm.$emit('loading', true);
        let params = {data: this.dataTable.rows.map((data, index) => {
          if (!data.row_id) data.row_id = uuid();
          return data
        })}
        axios.post(`/ir/ajax/cars`, params)
        .then(response => {
            vm.complete = false
            vm.dataTable.rows.map((row, index) => {
                delete row.flgAdd
                //   response.data.data.map(data => {
                let find = response.data.data.find((item)=>{
                  return item.row_id == row.row_id
                })
                if (find) {
                  row.car_id = find.car_id
                  row.document_number = find.document_number
                }
                // })
              return row
            })
            $(`input[name="cars_select_all"]`).prop('checked', false)
            vm.columnSelected = []
            vm.columnSelectedId = []
            vm.locked = !vm.locked
            vm.$nextTick(()=>{
              swal({
                title: "Success",
                text: 'บันทึกสำเร็จ',
                type: "success",
                showCancelButton: false,
                showConfirmButton: true
              })
              vm.$emit('loading', false);
            });
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
          vm.$emit('loading', false);
        })
      },
      clickIncomplete () {
        const vm = this
        vm.complete = true
        vm.locked = true;
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
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        vm.validateinsurance_amount(index)
        // if (value) {
        //   this.$refs.save_table_line.fields.find((f) => f.prop == `rows.${index}.insurance_amount`).clearValidate()
        // } else {
        //   // vm.dataTable.rows[index].insurance_amount = 0
        //   this.$refs.save_table_line.validateField(`rows.${index}.insurance_amount`)
        // }
      },
      discountChange(value, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        vm.validateinsurance_amount(index)
        // vm.dataTable.rows[index].discount = !value ? 0 : value;
      },
      dutyChange(value, i, data) {
        const vm = this
        let index = vm.dataTable.rows.indexOf(data);
        vm.validateinsurance_amount(index)
        // vm.dataTable.rows[index].discount = !value ? 0 : value;
      },
      ClickAddRow() {
        const vm = this
        vm.$emit('loading', true);
        vm.lastRowId = uuid();
        axios.get('/ir/ajax/lov/period-year')
        .then(({data:response}) => {
          let obj = {
            policy_set_header_id: null,
            car_type: null,
            car_id: null,
            asset_status: 'Y',
            document_number: null,
            renew_type_code: null,
            renew_type: null,
            start_date: null,
            end_date: null,
            total_days: null,
            department_code: null,
            department_name: null,
            license_plate: null,
            location_code: null,
            group_code: null,
            group_name: null,
            duty_amount: '',
            insurance_amount: '',
            discount: 0,
            revenue_stamp_percent: null,
            vat_amount: null,
            net_amount: null,
            vat_refund: null,
            car_type_code: null,
            status: 'NEW',
            policy_number: null,
            company_id: null,
            company_name: null,
            asset_number: null,
            expense_account: null,
            expense_account_id: null,
            expense_account_desc: null,
            car_brand: null,
            car_brand_code: null,
            car_cc: null,
            engine_number: null,
            tank_number: null,
            line_type: 'ADD',
            year: (response.data.period_year).toString() ,
            vat_percent: null,
            flgAdd: true,
            isDuplicated: false,
            expense_flag: 'N',
            type_cost: '',
            receivable_name: '',
            revenue_stamp_percent: 0,
            vat_flag: 'N',
            //vat_percent: 7,
            row_id: vm.lastRowId,
          }
          vm.locked = true;
          vm.dataTable.rows.push(obj)
          vm.totalRows = vm.dataTable.rows.length;
          vm.$nextTick(() => {
            vm.currentPage = Math.ceil(vm.totalRows / vm.perPage);
            vm.$nextTick(() => {
              const el = this.$el.getElementsByClassName('newLine')[0];
              if (el) {
                el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
              }
              vm.$emit('loading', false);
            });
          });
        })
        .catch((error) => {
          swal("Error", error, "error")
        })
      },
      async copyRow(row){
        const vm = this
        vm.$emit('loading', true);
        vm.lastRowId = uuid();
        await axios.get('/ir/ajax/lov/period-year')
        .then(async ({data:response}) => {
          let obj = { ...row }
          obj.status = 'NEW';
          obj.insurance_amount = '';
          obj.flgAdd = true;
          obj.isDuplicated = true;
          obj.expense_flag = 'N';
          obj.line_type = 'COPY';
          obj.row_id = vm.lastRowId;
          obj.document_number = null;
          obj.car_id = null;

          vm.locked = true;
          let index = (vm.dataTable.rows.indexOf(row)+1);
          vm.dataTable.rows.splice(index, 0, obj);
          vm.setCopyRowDate(row, index);
          vm.totalRows = vm.dataTable.rows.length;
          vm.$nextTick(() => {
            vm.currentPage = Math.ceil((index+1) / vm.perPage);
            vm.$nextTick(() => {
              const el = vm.$el.getElementsByClassName('newLine')[0];
              if (el) {
                el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
              }
              vm.$emit('loading', false);
            });
          });
        })
        .catch((error) => {
          swal("Error", error, "error")
        })
      },
      async removeRow(obj) {
        const vm = this
        await swal({
          title: "Warning",
          text: "ต้องการลบหรือไม่!",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: true
        },
        async function (isConfirm) {
          if (isConfirm) {
            vm.$emit('loading', true);
            if(obj.car_id){
              const params = {
                car_id: obj.car_id
              }
              await axios.post(`/ir/ajax/cars/remove`, params)
              .then(res => {
                vm.$emit('loading', false);
              })
              .catch(error => {
                swal({
                  title: "Error",
                  text: "Remove Error",
                  type: "error",
                })
                vm.$emit('loading', false);
              })
            }
            vm.$emit('loading', false);
            let index = vm.dataTable.rows.indexOf(obj);
            vm.dataTable.rows.splice(index, 1);
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
              row.year === row2.year && row.license_plate === row2.license_plate && 
              row.receivable_name === row2.receivable_name && 
              (row.renew_type_code === row2.renew_type_code && row.renew_type === row2.renew_type) &&
              row.status !== 'Cancelled' && row2.status !== 'Cancelled')
            if (findDup) isDuplicated = true
          })
        } else {
          isDuplicated = rows[0].isDuplicated && rows[0].status !== 'Cancelled'
        }
        return isDuplicated
      },
      dutyAmount(row) {
        row.duty_amount = parseFloat(((row.insurance_amount - + row.discount) * +row.revenue_stamp_percent) / 100);
        return row.duty_amount;
        // let localString = parseFloat(((row.insurance_amount - + row.discount) * +row.revenue_stamp_percent) / 100).toFixed(2)
        // let currency = parseInt(localString.split('.')[0]).toLocaleString()
        // let decimal = localString.split('.')[1]
        // row.duty_amount = `${currency}.${decimal}`
        // return `${currency}.${decimal}`
      },
      vatAmount(row) {
        row.vat_amount = row.vat_flag === 'Y' ? parseFloat(((row.insurance_amount - +row.discount + parseFloat(row.duty_amount)) * +row.vat_percent) / 100) : 0;
        // row.vat_amount = parseFloat(((row.insurance_amount - +row.discount + parseFloat(row.duty_amount)) * +row.vat_percent) / 100);
        return row.vat_amount;
        // let localString = parseFloat(((row.insurance_amount - +row.discount + this.convertCurrenyToNum(row.duty_amount)) * +row.vat_percent) / 100).toFixed(2)
        // let currency = parseInt(localString.split('.')[0]).toLocaleString()
        // let decimal = localString.split('.')[1]
        // row.vat_amount = `${currency}.${decimal}`
        // return `${currency}.${decimal}`
      },
      netAmount(row) {
        row.net_amount = parseFloat(row.insurance_amount - +row.discount + parseFloat(row.duty_amount) +  parseFloat(row.vat_amount));
        return row.net_amount;
        // let localString = parseFloat(row.insurance_amount - +row.discount + this.convertCurrenyToNum(row.duty_amount) +  this.convertCurrenyToNum(row.vat_amount)).toFixed(2)
        // let currency = parseInt(localString.split('.')[0]).toLocaleString()
        // let decimal = localString.split('.')[1]
        // row.net_amount = `${currency}.${decimal}`
        // return `${currency}.${decimal}`
      },
      insuranceExpense(row){
        // if (row.receivable_name) {
        //   row.insurance_expense = 0;
        //   return row.insurance_expense;
        // } else {
          row.insurance_expense = ['Yes', 'Y'].includes(row.vat_refund) ? parseFloat(row.insurance_amount - +row.discount + parseFloat(row.duty_amount)) : parseFloat(row.net_amount);
          return row.insurance_expense;
        // }

        // row.insurance_expense = ['Yes', 'Y'].includes(row.vat_refund) ? parseFloat(row.insurance_amount - +row.discount + parseFloat(row.duty_amount)) : parseFloat(row.net_amount);
        // return row.insurance_expense;
      },
      convertCurrenyToNum(currency) {
        return Number(currency.replace(/[^0-9.-]+/g,""))
      },
      duplicatedCheck(row, index, type = null) {
        const vm = this
        const params = {
          data: {
            rows: vm.dataTable.rows,
            year: row.year,
            renew_type: row.renew_type,
            renew_type_code: row.renew_type_code,
            license_plate: row.license_plate,
            receivable_name: row.receivable_name,
            row_id: index,
            type: type
          }
        }
        if (row.year && row.renew_type_code && row.license_plate) {
          axios.post(`/ir/ajax/cars/duplicate-check`, params)
          .then(res => {
            if (res.data.status == 'E') {
              vm.dataTable.rows[index].isDuplicated = true
              swal({
                title: "Warning",
                text:  'ไม่สามารถเลือกรายการซ้ำได้',
                type: "warning",
              })
                vm.$nextTick(()=>{
                  if(type === 'renew_type'){
                    row.renew_type_code = '';
                    row.renew_type = '';
                    row.renew_typex = '';
                  }
                  if(type === 'year'){
                    row.year = '';
                  }
                  if(type === 'license_plate'){
                    row.license_plate = '';
                  }
                  if(type === 'receivable_name'){
                    row.receivable_name = '';
                    row.receivable_code = '';
                  } 
                });
              
            }else{
              vm.dataTable.rows[index].isDuplicated = false
            }
            // let duplicated = vm.checkDuplicateField()
            // vm.dataTable.rows[index].isDuplicated = duplicated
            // if (duplicated) {
            //   swal({
            //     title: "Warning",
            //     text:  'ไม่สามารถเลือกรายการซ้ำได้',
            //     type: "warning",
            //   })
            // }
            
            // vm.dataTable.rows[index].isDuplicated = false
          })
          .catch(error => {
            if (error.response.data.status === 400) {
              vm.dataTable.rows[index].isDuplicated = true
              swal({
                title: "Warning",
                text:  'ไม่สามารถเลือกรายการซ้ำได้',
                type: "warning",
              })
                vm.$nextTick(()=>{
                  if(type === 'renew_type'){
                    row.renew_type_code = '';
                    row.renew_type = '';
                    row.renew_typex = '';
                  }
                  if(type === 'year'){
                    row.year = '';
                  }
                  if(type === 'license_plate'){
                    row.license_plate = '';
                  }
                  if(type === 'receivable_name'){
                    row.receivable_name = '';
                    row.receivable_code = '';
                  } 
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
        if (row.expense_flag == 'Y') return true;
        if (!this.locked) return true;
        if (row && row.status === 'CONFIRMED' && !row.expense_flag == 'Y' ) return true;
        return false
      },
      checkCopy(row){
        if (row.line_type == 'COPY') return false;
        if (this.locked) return true;
        return false;
      },
      async parseToDate(value = null, format = 'DD/MM/YYYY') {
        if (value == null) {
          return moment().toDate()
        }
        return moment(value, format).subtract(543, 'years').toDate()
      },
      getValueReceivable (obj, i, data) {
        const vm = this;
        let index = vm.dataTable.rows.indexOf(data);
        vm.dataTable.rows[index].receivable_name = obj.desc;
        vm.dataTable.rows[index].receivable_code = obj.code;
        vm.duplicatedCheck(vm.dataTable.rows[index], index, 'receivable_name')
      },
      setReceivables () {
        this.receivables = [];
        this.rows
        this.dataTable.rows.filter((row) => {
          if (this.checkStatusConfirmed(row.status) && row.receivable_name) {
            this.receivables.push({
              ...row
            })
          }
        })
        var result = [];
        let vm = this;
        this.receivables.reduce(function(res, value) {
          if (!res[value.receivable_code]) {
            res[value.receivable_code] = { receivable_code: value.receivable_code, net_amount: 0, receivable_name: value.receivable_name};
            result.push(res[value.receivable_code])
          }
          let net_amount = typeof value.net_amount == 'string' && value.net_amount ? vm.convertCurrenyToNum(value.net_amount) : value.net_amount;
          res[value.receivable_code].net_amount += net_amount;
          return res;
        }, {});
        this.result_receivable = result;
      },
      getLocation(res, i, data){
        let vm = this;
        let index = vm.dataTable.rows.indexOf(data);
        this.dataTable.rows[index].location_code = res.value;
        this.dataTable.rows[index].location_description = res.value_name;
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
    props: [
      'dataTable',
      'defaultValueSetName',
      'setLabelExpenseFlag',
      'formatCurrency',
      'isNullOrUndefined',
      'checkStatusConfirmed',
      'setLabelStatusAsset',
      'policyCarTypes',
      'urlExport'
    ],
    components: {
      modalAccountCode,
      dateInput,
      currencyInput,
      lovCompany,
      lovRenewType,
      lovDepartment,
      lovVehicle,
      lovAssetStatus,
      lovReceivable,
      dropdownStatusAsset,
      lovLocation
    },
    computed: {
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

        vm.policyCarTypes.forEach((item) => {
          dataTableTotal.push({
            group_name: item.meaning,
            premium: 0,
            discount: 0,
            duty_fee: 0,
            vat: 0,
            net_amount: 0,
            rec_insu : 0,
            result_receivable: [],
          });
        });

        vm.dataTable.rows.forEach((item) => {
          if ( !['CONFIRMED', 'INTERFACE'].includes(item.status) ) return

          total_rec = rec = find = null;
          find = dataTableTotal.find((search)=>{
            return search.group_name == item.group_name;
          });

          if(find){
            // find.premium += parseFloat(item.insurance_amount);
            // find.discount += parseFloat(item.discount);
            // find.duty_fee += parseFloat(item.duty_amount);
            // find.vat += item.vat_flag == 'Y' ? parseFloat(item.vat_amount) : 0;
            // find.net_amount += parseFloat(item.net_amount);

            find.premium    += +Number(item.insurance_amount).toFixed(2);
            find.discount   += +Number(item.discount).toFixed(2);
            find.duty_fee   += +Number(item.duty_amount).toFixed(2);
            find.vat        += item.vat_flag == 'Y' ? +Number(item.vat_amount).toFixed(2) : 0;
            find.net_amount += +Number(item.net_amount).toFixed(2);
            if(item.receivable_code) {
              // find.rec_insu += parseFloat(item.net_amount);
              find.rec_insu += +Number(item.net_amount).toFixed(2);
              rec = find.result_receivable.find((search)=>{
                return search.receivable_code == item.receivable_code;
              });
              // if(rec) {rec.net_amount += parseFloat(item.net_amount);}
              if(rec) {rec.net_amount += +Number(item.net_amount).toFixed(2);}
            }
          }else {
            dataTableTotal.push({
              group_name: item.group_name,
              // premium: parseFloat(item.insurance_amount),
              // discount: parseFloat(item.discount),
              // duty_fee: parseFloat(item.duty_amount),
              // vat: item.vat_flag == 'Y' ? parseFloat(item.vat_amount) : 0,
              // net_amount: parseFloat(item.net_amount),
              // rec_insu : item.receivable_code ? parseFloat(item.net_amount) : 0,

              premium:    +Number(item.insurance_amount).toFixed(2),
              discount:   +Number(item.discount).toFixed(2),
              duty_fee:   +Number(item.duty_amount).toFixed(2),
              vat:        item.vat_flag == 'Y' ? +Number(item.vat_amount).toFixed(2) : 0,
              net_amount: +Number(item.net_amount).toFixed(2),
              rec_insu :  item.receivable_code ? +Number(item.net_amount).toFixed(2) : 0,

              result_receivable: item.receivable_code ? [{
                receivable_code: item.receivable_code, 
                receivable_name: item.receivable_name,
                // net_amount: parseFloat(item.net_amount),
                net_amount: +Number(item.net_amount).toFixed(2),
              }] : [],
            });
          }

          // total_premium += parseFloat(item.insurance_amount);
          // total_discount += parseFloat(item.discount);
          // total_duty_fee += parseFloat(item.duty_amount);
          // total_vat += item.vat_flag == 'Y' ? parseFloat(item.vat_amount) : 0;
          // total_net_amount += parseFloat(item.net_amount);
          total_premium    += +Number(item.insurance_amount).toFixed(2);
          total_discount   += +Number(item.discount).toFixed(2);
          total_duty_fee   += +Number(item.duty_amount).toFixed(2);
          total_vat        += item.vat_flag == 'Y' ? +Number(item.vat_amount).toFixed(2) : 0;
          total_net_amount += +Number(item.net_amount).toFixed(2);
          if(item.receivable_code) {
            // total_rec_insu += parseFloat(item.net_amount);
            total_rec_insu += +Number(item.net_amount).toFixed(2);
            total_rec = total_result_receivable.find((search)=>{
              return search.receivable_code == item.receivable_code;
            });
            if(total_rec) {
              // total_rec.net_amount += parseFloat(item.net_amount);
              total_rec.net_amount += +Number(item.net_amount).toFixed(2);
            }else {
              total_result_receivable.push({
                receivable_code: item.receivable_code, 
                receivable_name: item.receivable_name,
                // net_amount: parseFloat(item.net_amount),
                net_amount: +Number(item.net_amount).toFixed(2),
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
          // console.log('1 > ', total_premium);
          // console.log('2 > ', Number(total_premium).toFixed(2));
          dataTableTotal.push({
            group_name: 'Total',
            // premium: total_premium,
            // discount: total_discount,
            // duty_fee: total_duty_fee,
            // vat: total_vat,
            // net_amount: total_net_amount,

            premium:    Number(total_premium).toFixed(2),
            discount:   Number(total_discount).toFixed(2),
            duty_fee:   Number(total_duty_fee).toFixed(2),
            vat:        Number(total_vat).toFixed(2),
            net_amount: Number(total_net_amount).toFixed(2),

            rec_insu: total_rec_insu,
            result_receivable: total_result_receivable,
          });
        // }
        return dataTableTotal;
      },
    },
    watch: {
      'complete' (newVal, oldVal) {
        if (!newVal) {
          $("#table_edit").find("input").prop("disabled", true);
          $(`input[name="cars_select_all"]`).prop('checked', false)
          $(`input[name="cars_select_all"]`).prop('disabled', true)
          $("#table_edit").find('input[type="checkbox"]').prop("checked", false)
          this.columnSelected = []
          this.columnSelectedId = []
        } else {
          $("#table_edit").find("input").prop("disabled", false)
          $(`input[name="cars_select_all"]`).prop('disabled', false)
        }
      },
      'dataTable.rows' (newVal, oldVal) {
        $(`input[name="cars_select_all"]`).prop('checked', false)
        this.columnSelected = []
        this.columnSelectedId = []
        this.totalRows = this.dataTable.rows.length;

        this.dataExport = [];
        this.dataTable.rows.forEach(element => {
          // console.log('element <-->', element);
          this.dataExport.push(element.car_id);
          // console.log('element <-->', element);
        });

        // this.dataExport = this.dataTable.rows;
      }
    },
    mounted(){
      window.vm = this;
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
