<template>
  <div>
    <el-form :model="form"
      ref="save_table_line"
      label-width="120px"
      class="demo-dynamic form_table_line">
      <div class="table-responsive margin_top_20">
        <div style="font-size: 18px">
          &nbsp; กรมธรรม์ชุดที่ {{ poli }} : {{ polides }} &nbsp; ปี : {{ showYearBE("year", yearr) }} &nbsp; วัน เดือน ปี ที่ดึงข้อมูล : {{ startt }} - {{ endd }}
        </div>
        <br>
        <table class="table table-bordered" style="display: block; overflow: auto; max-height: 500px">
          <thead>
            <tr>
              <th style="min-width: 110px" class="text-center">
                IR Status<br>สถานะ
              </th>
              <th style="min-width: 110px" class="text-center">
                Count<br>จำนวนรายการ
              </th>
              <th style="min-width: 200px" class="text-center">
                Total Amount <br>มูลค่าสินค้าทั้งหมด
              </th>
              <th style="min-width: 200px" class="text-center">
                Total Coverage Amount <br>มูลค่าทุนประกันทั้งหมด
              </th>
            </tr>
          </thead>
          <tbody id="table_search">
            <tr>
              <td>New</td>
              <td class="text-center">{{ countNewList }}</td>
              <td class="text-right">{{ formatCurrency(sumNewTotalAmount) }}</td>
              <td class="text-right">{{ formatCurrency(sumNewTotalCoverageAmount) }}</td>
            </tr>
            <tr>
              <td>Confirmed</td>
              <td class="text-center">{{ countConfirmedList }}</td>
              <td class="text-right">{{ formatCurrency(sumConfirmedTotalAmount) }}</td>
              <td class="text-right">{{ formatCurrency(sumConfirmedTotalCoverageAmount) }}</td>
            </tr>
            <tr>
              <td>Cancelled</td>
              <td class="text-center">{{ countCancelledList }}</td>
              <td class="text-right">{{ formatCurrency(sumCancelledTotalAmount) }}</td>
              <td class="text-right">{{ formatCurrency(sumCancelledTotalCoverageAmount) }}</td>
            </tr>
            <tr>
              <td>Interface</td>
              <td class="text-center">{{ countInterfaceList }}</td>
              <td class="text-right">{{ formatCurrency(sumInterfaceTotalAmount) }}</td>
              <td class="text-right">{{ formatCurrency(sumInterfaceTotalCoverageAmount) }}</td>
            </tr>
            <tr>
              <td>Total</td>
              <td class="text-center">{{ countNewList + countConfirmedList + countCancelledList + countInterfaceList }}</td>
              <td class="text-right">
                {{ formatCurrency(sumNewTotalAmount + sumConfirmedTotalAmount + sumCancelledTotalAmount + sumInterfaceTotalAmount) }}
              </td>
              <td class="text-right">
                {{ formatCurrency(sumNewTotalCoverageAmount + sumConfirmedTotalCoverageAmount + sumCancelledTotalCoverageAmount + sumInterfaceTotalCoverageAmount) }}
              </td>
            </tr>
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>

      <div class="mt-2 mb-2">
        <a :href="`/ir/stocks/yearly/export?id=${headerRow.header_id}&program_code=IRP0001`" type="button" class="btn btn-sm btn-info" target="_bank"> <i class="fa fa-print"></i> Export </a>
      </div>

      <div class="table-responsive">
        <b-table
          table-class="table table-bordered"
          style="display: block; overflow: auto; max-height: 500px;"
          :busy.sync="isBusy"
          :items="form.tableLine"
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
                :name="`stock_year_select_all`"
                style='position: inherit;'
                :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
              >
            </div>
          </template>
          <template #head(line_number)="header">
            <div>
              Line No
            </div>
          </template> 
          <template #head(status)="header">
            <div>
              IR Status<br>สถานะ
            </div>
          </template>
          <template #head(line_type)="header">
            <div>
              Line Type<br>ประเภท
            </div>
          </template>
          <template #head(period_from)="header">
            <div>
              Period From <br>ตั้งแต่เดือน *
            </div>
          </template>
          <template #head(period_to)="header">
            <div>
              Period To <br> ถึงเดือน *
            </div>
          </template>
          <template #head(organization_code)="header">
            <div>
              Organization
            </div>
          </template>
          <template #head(sub_inventory_code)="header">
            <div>
              Sub Inventory Code <br>รหัสคลังสินค้า
            </div>
          </template>
          <template #head(sub_inventory_desc)="header">
            <div>
              Sub Inventory <br>คลังสินค้า
            </div>
          </template>
          <template #head(location_code)="header">
            <div>
              Sub Group Code <br> รหัสกลุ่มสินค้าย่อย *
            </div>
          </template>
          <template #head(location_desc)="header">
            <div>
              Sub Group Description <br>กลุ่มสินค้าย่อย *
            </div>
          </template>
          <template #head(asset_group_code)="header">
            <div>
              กลุ่มของทรัพย์สิน *
            </div>
          </template>
          <template #head(stock_list_description)="header">
            <div>
              รายการ *
            </div>
          </template>
          <template #head(item_code)="header">
            <div>
              Item Code <br>รหัสพัสดุ *
            </div>
          </template>
          <template #head(item_description)="header">
            <div>
              Item Description <br>พัสดุ *
            </div>
          </template>
          <template #head(uom_description)="header">
            <div>
              UOM <br>หน่วย *
            </div>
          </template>
          <template #head(original_quantity)="header">
            <div>
              Original Quantity <br>ปริมาณเดิม
            </div>
          </template>
          <template #head(unit_price)="header">
            <div>
              Price per unit <br>ราคาต่อหน่วย * (บาท)
            </div>
          </template>
          <template #head(line_amount)="header">
            <div>
              Amount <br>มูลค่าสินค้า * (บาท)
            </div>
          </template>
          <template #head(coverage_amount)="header">
            <div>
              Coverage Amount <br>มูลค่าทุนประกัน *
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
            <div class="form-check el-form-item__content" style="position: inherit;">
              <input
                :class="`form-check-input ${
                  checkStatusInterface(row.item.status) || checkExpenseFlag
                    ? 'checkbox_edit_disabled'
                    : ''
                }`"
                type="checkbox"
                @click="clickSelectRow(row.item.row_id, row.item)"
                :name="`stock_year_select${row.item.row_id}`"
                :value="`${row.item.row_id}`"
                :checked="rowSelectedId.includes(row.item.row_id)"
                :disabled="
                  checkStatusInterface(row.item.status) || !complete || checkExpenseFlag
                    ? true
                    : false
                "
                style="position: inherit">
            </div>
          </template>
          <template #cell(line_number)="row">
            <div>
              {{ row.item.line_number ? row.item.line_number : '' }}
            </div>
          </template>
          <template #cell(status)="row">
            <div>
              {{ setFirstLetterUpperCase(row.item.status) }}
            </div>
          </template>
          <template #cell(line_type)="row">
            <div>
              {{ setFirstLetterUpperCase(row.item.line_type) }}
            </div>
          </template>
          <template #cell(period_from)="row">
            <div v-if="row.item.flag === 'update'">
              {{ showYearBE("month", row.item.period_from) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.period_from'"
              :rules="rules.period_from"
              class="el-input--small"
            >
              <datepicker-th
                style="width: 100%; line-height: 32px"
                class="el-input__inner style_icon_calendar"
                :name="`period_from${row.item.row_id}`"
                p-type="month"
                placeholder="ตั้งแต่เดือน"
                v-model="row.item.period_from"
                :format="vars.formatMonth"
                @dateWasSelected="getValuePeriodFrom(...arguments, row.index, row.item)"
                v-if="complete"
                inputClass="input_date_small"
              />
              <div v-else>
                {{ isNullOrUndefined(row.item.period_from) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(period_to)="row">
            <div v-if="row.item.flag === 'update'">
              {{ showYearBE("month", row.item.period_to) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.period_to'"
              :rules="rules.period_to"
              class="el-input--small"
            >
              <datepicker-th
                style="width: 100%; line-height: 30px"
                class="el-input__inner"
                :name="`period_to${row.item.row_id}`"
                p-type="month"
                placeholder="ถึงเดือน"
                v-model="row.item.period_to"
                :format="vars.formatMonth"
                @dateWasSelected="getValuePeriodTo(...arguments, row.index, row.item)"
                v-if="complete"
                inputClass="input_date_small"
                :disabledDateTo="row.item.period_from"
              />
              <div v-else>
                {{ isNullOrUndefined(row.item.period_to) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(organization_code)="row">
            <div v-if="row.item.flag === 'update'">
              {{ isNullOrUndefined(row.item.organization_code) ? isNullOrUndefined(row.item.organization_code) + " : " + isNullOrUndefined(row.item.organization_name) : '' }}
            </div>
            <el-form-item v-else>
              <lov-org
                v-model="row.item.organization_code"
                :name="`organization_code${row.item.row_id}`"
                @change-lov="getDataOrg(...arguments, row.index, row.item.index, row.item)"
                v-show="complete"
              />
              <div v-show="!complete">
                {{ isNullOrUndefined(row.item.organization_code) + " : " + isNullOrUndefined(row.item.organization_name) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(sub_inventory_code)="row">
            <div v-if="row.item.flag === 'update'">
              {{ isNullOrUndefined(row.item.sub_inventory_code) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.sub_inventory_code'"
              :rules="rules.sub_inventory_code"
            >
              <lov-inventory
                v-model="row.item.sub_inventory_code"
                :name="`inventory_code${row.item.row_id}`"
                :index="row.item.row_id"
                @change-lov="getDataInventory(...arguments, row.index, row.item)"
                :org_id="org_id"
                v-show="complete"
                :org_desc="row.item.organization_name"
              />
              <div v-show="!complete">
                {{ isNullOrUndefined(row.item.sub_inventory_code) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(sub_inventory_desc)="row">
            <div>
              {{ isNullOrUndefined(row.item.sub_inventory_desc) }}
            </div>
          </template>
          <template #cell(location_code)="row">
            <div v-if="row.item.flag === 'update'">
              {{ isNullOrUndefined(row.item.location_code) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.location_code'"
              :rules="rules.location_code"
            >
              <lov-location
                v-model="row.item.location_code"
                :name="`location_code${row.item.row_id}`"
                :isTable="true"
                :index="row.item.row_id"
                placeholder="รหัสกลุ่มสินค้าย่อย"
                :headerRow="headerRow"
                @change-lov-location="getDataLocation(...arguments, row.index, row.item)"
                v-show="complete"
              />
              <div v-show="!complete">
                {{ isNullOrUndefined(row.item.location_code) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(location_desc)="row">
            <div>
              {{ isNullOrUndefined(row.item.location_desc) }}
            </div>
          </template>
          <template #cell(asset_group_code)="row">
            <div v-if="row.item.flag === 'update'">
              {{ isNullOrUndefined(row.item.asset_group_code) + " : " + isNullOrUndefined(row.item.asset_group_name) }}
            </div>
            <el-form-item v-else
              :prop="'tableLine.' + row.index + '.asset_group_code'"
              :rules="rules.asset_group_code"
            >
              <lov-asset-group
                v-show="complete"
                :attrName="`asset_group_code${row.item.row_id}`"
                v-model="row.item.asset_group_code"
                @change-value-asset-group="getDataAssetGroupTable(...arguments, row.index, row.item)"
                :index="row.item.row_id"
                :headerRow="headerRow"
                :isTable="true"
                size="small"
              />
              <div v-show="!complete">
                {{ isNullOrUndefined(row.item.asset_group_code) + " : " + isNullOrUndefined(row.item.asset_group_name) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(stock_list_description)="row">
            <div v-if="row.item.flag === 'update'">
              {{ isNullOrUndefined(row.item.stock_list_description) }}
            </div>
            <el-form-item v-else
              :prop="'tableLine.' + row.index + '.stock_list_description'"
              :rules="rules.stock_list_description"
            >
              <lov-group-products
                v-model="row.item.stock_list_description"
                :name="`stock_list_description${row.item.row_id}`"
                :assetGroupCode="row.item.asset_group_code"
                :index="row.item.row_id"
                :isTable="true"
                @change-lov="getDataGroupProducts(...arguments, row.index, row.item)"
                :headerRow="headerRow"
                v-show="complete"
              />
              <div v-show="!complete">
                {{ isNullOrUndefined(row.item.stock_list_description) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(item_code)="row">
            <div v-if="row.item.flag === 'update'">
              {{ isNullOrUndefined(row.item.item_code) }}
            </div>
              <el-form-item v-else 
                :prop="'tableLine.' + row.index + '.item_code'"
                :rules="rules.item_code">
              <lov-items 
                v-model="row.item.item_code"
                :name="`item_code${row.item.row_id}`"
                :index="row.item.row_id"
                @change-lov="getItems(...arguments, row.index, row.item)"
                v-show="complete" />
              <div v-show="!complete">
                {{ isNullOrUndefined(row.item.item_code) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(item_description)="row">
            <div>
              {{ isNullOrUndefined(row.item.item_description) }}
            </div>
          </template>
          <template #cell(uom_description)="row">
            <div>
              {{ isNullOrUndefined(row.item.uom_description) }}
            </div>
          </template>
          <template #cell(original_quantity)="row">
            <div v-if="row.item.flag === 'update' || !complete">
              {{ isNullOrUndefined(row.item.original_quantity) ? formatCurrency(row.item.original_quantity) : isNullOrUndefined(row.item.original_quantity) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.original_quantity'"
              :rules="rules.original_quantity"
              class="currency_right"
            >
              <currency-input
                v-model="row.item.original_quantity"
                :name="`original_quantity${row.item.row_id}`"
                :sizeSmall="true"
                placeholder="ปริมาณเดิม"
                :disabled="false"
                @input="getDataOriginalQuantity(...arguments, row.index, row.item)"
                @blur-currency="blurOriginalQty(...arguments, row.index)"
              />
            </el-form-item>
          </template>
          <template #cell(unit_price)="row">
            <div v-if="row.item.flag === 'update' || !complete">
              {{ isNullOrUndefined(row.item.unit_price) ? formatCurrency(row.item.unit_price) : isNullOrUndefined(row.item.unit_price) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.unit_price'"
              :rules="rules.unit_price"
              class="currency_right"
            >
              <currency-input
                v-model="row.item.unit_price"
                :name="`unit_price${row.item.row_id}`"
                :sizeSmall="true"
                placeholder="ราคาต่อหน่วย"
                :disabled="false"
                @input="getDataUnitPrice(...arguments, row.index, row.item)"
                @blur-currency="blurUnitPrice(...arguments, row.index)"
              />
            </el-form-item>
          </template>
          <template #cell(line_amount)="row">
            <div v-if="row.item.flag === 'update' || !complete">
              {{ isNullOrUndefined(row.item.line_amount) ? formatCurrency(row.item.line_amount) : isNullOrUndefined(row.item.line_amount) }}
            </div>
            <el-form-item
              v-else
              :prop="'tableLine.' + row.index + '.line_amount'"
              :rules="rules.line_amount"
            >
              <div>
                {{ isNullOrUndefined(row.item.line_amount) || isNullOrUndefined(row.item.line_amount) === 0 ? formatCurrency(row.item.line_amount) : isNullOrUndefined(row.item.line_amount) }}
              </div>
            </el-form-item>
          </template>
          <template #cell(coverage_amount)="row">
            <div v-if="checkStatusInterface(row.item.status) || !complete || checkExpenseFlag">
              {{ isNullOrUndefined(row.item.coverage_amount) ? formatCurrency(row.item.coverage_amount) : isNullOrUndefined(row.item.coverage_amount) }}
            </div>
            <el-form-item
              :prop="'tableLine.' + row.index + '.coverage_amount'"
              :rules="rules.coverage_amount"
              v-else
            >
              <ceil-ten-currency-input
                v-model="row.item.coverage_amount"
                :isChangeCeli="true"
                :isBlurCeli="false"
                v-if="complete"
                :sizeSmall="true"
                placeholder="มูลค่าทุนประกัน"
                :name="`coverage_amount${row.item.row_id}`"
                @ceil-rows="getDataCoverageAmount(...arguments, row.index, row.item)"
                :line_amount="row.item.line_amount"
                :flag="row.item.flag"
              />
            </el-form-item>
          </template>
          <template #cell(action)="row">
            <el-form-item
              :prop="'tableLine.' + row.index + '.calculate_days'"
              :rules="rules.calculate_days"
              v-if="row.item.line_type === 'MANUAL'"
            >
              <button
                type="button"
                class="btn btn-success btn-sm"
                data-toggle="modal"
                :data-target="`#modal_cal_date${row.item.row_id}`"
                @click="modalCalDate(row.index, row.item.row_id, row.item)"
                :disabled="!complete || checkStatusInterface(row.item.status) || checkExpenseFlag"
                :value="row.item.calculate_days"
                :name="`calculate_days${row.item.row_id}`"
              >
                <i class="fa fa-edit m-r-xs"></i>Calculation Date
              </button>
            </el-form-item>
          </template>
          <template #cell(remove)="row">
            <el-form-item v-if="row.item.flag === 'add' && !row.item.line_id">
              <button
                type="button"
                class="btn btn-danger btn-sm"
                @click="clickRemove(row.item, row.index)"
                :name="`line_remove${row.item.row_id}`"
              >
                <i class="fa fa-times m-r-xs"></i>ลบ
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
              <button
                type="button"
                class="btn btn-primary"
                :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
                @click="clickConfirm()"
              >
                <i class="fa fa-check"></i>
                ยืนยัน
              </button>
              <button
                type="button"
                class="btn btn-danger"
                :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
                @click="clickCancel()"
              >
                <i class="fa fa-times"></i>
                ยกเลิก
              </button>
              <button
                type="button"
                class="btn btn-warning"
                :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
                @click="clickClear()"
              >
                <i class="fa fa-repeat"></i>
                รีเซต
              </button>
            </el-form-item>
          </div>
        </div>
        <div class="col-md-6 lable_align">
          <div class="form-group el_field">
            <el-form-item>
              <button
                type="button"
                v-show="complete"
                class="btn btn-primary"
                @click="clickComplete()"
                :disabled="checkStatusInterface(headerRow.status) || checkExpenseFlag"
              >
                <i class="fa fa-check-square-o"></i> บันทึก (ล็อค)
              </button>
              <button
                type="button"
                v-show="!complete"
                class="btn btn-danger"
                @click="clickIncomplete()"
                :disabled="checkStatusInterface(headerRow.status) || checkExpenseFlag"
              >
                <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
              </button>
            </el-form-item>
          </div>
        </div>
      </div>
    </el-form>
    <modal-calculation-date
      :modalId="modalId"
      :modalVal="modalVal"
      :modalDataRow="modalDataRow"
      @calculation-date="getCalculateDate"
      ref="editTableLineModalCalculationDate"
      :vars="vars"
      :showYearBE="showYearBE"
      :setYearCE="setYearCE"
      :setBudgetYearFromFieldStCalendar="setBudgetYearFromFieldStCalendar"
      :setFullDateIsDateCE="setFullDateIsDateCE"
      :covertFomatDateMoment="covertFomatDateMoment"
    />
  </div>
</template>

<script>
import lovOrg from "./lovOrg";
import lovInventory from "./lovInventory";
import lovItems from "./lovItems";
import lovLocation from "./lovLocation";
import lovAssetGroup from "./lovAssetGroup";
import lovUom from "./lovUom";
import lovGroupProducts from "./lovGroupProducts";
import modalCalculationDate from "./modalCalculationDate";
import monthYearInput from "../components/calendar/monthYearInput";
import currencyInput from "../components/currencyInput";
import ceilTenCurrencyInput from "./ceilTenCurrencyInput";
import moment from "moment";

export default {

  data() {
    return {
      rowSelected: [],
      rowSelectedId: [],
      manual_cover_amounts: [],
      complete: true,
      rules: {
        period_from: [
          { required: true, message: "กรุณาระบุตั้งแต่เดือน", trigger: "blur" },
        ],
        period_to: [
          { required: true, message: "กรุณาระบุถึงเดือน", trigger: "blur" },
        ],
        // sub_inventory_code: [
        //   {required: true, message: 'กรุณาระบุรหัสคลังสินค้า', trigger: "change"}
        // ],
        asset_group_code: [
          { required: true, message: "กรุณาระบุกลุ่มของทรัพย์สิน", trigger: "change" },
        ],
        stock_list_description: [
          { required: true, message: "กรุณาระบุรายการ", trigger: "change" },
        ],
        location_code: [
          { required: true, message: "กรุณาระบุรหัสกลุ่มสินค้าย่อย", trigger: "change" },
        ],
        item_code: [
          { required: true, message: "กรุณาระบุรหัสพัสดุ", trigger: "change" },
        ],
        item_description: [
          { required: true, message: "กรุณาระบุพัสดุ", trigger: "blur" },
        ],
        uom_code: [
          { required: true, message: "กรุณาระบุหน่วย", trigger: "change" },
        ],
        // original_quantity: [
        //   {required: true, message: 'กรุณาระบุปริมาณเดิม', trigger: "blur"}
        // ],
        unit_price: [
          { required: true, message: "กรุณาระบุราคาต่อหน่วย", trigger: "blur" },
        ],
        line_amount: [
          // {required: true, message: 'กรุณาระบุมูลค่าสินค้า', trigger: "blur"}
        ],
        coverage_amount: [
          {
            required: true,
            message: "กรุณาระบุมูลค่าทุนประกัน",
            trigger: "blur",
          },
        ],
        calculate_days: [
          { required: true, message: "กรุณาระบุจำนวนวัน", trigger: "blur" },
        ],
      },
      modalDataRow: {},
      modalVal: {
        start_date: "",
        end_date: "",
        days: "",
      },
      modalIndex: "",
      modalId: "",
      setDataRowsNotInterface: [],
      org_id: "",
      period_from: "",
      period_to: "",
      tableLineConcat: [],
      res_header_id: "",
      res_rows_id: [],
      activeIndex: "",
      fields: [
        { key: 'selected', sortable: false, class:'text-center text-nowrap', },
        { key: 'line_number', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 100px;', tdClass:'align-middle' },
        { key: 'status', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 110px;', tdClass:'align-middle' },
        { key: 'line_type', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 110px;', tdClass:'align-middle' },
        { key: 'period_from', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass:'align-middle' },
        { key: 'period_to', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 140px;', tdClass:'align-middle' },
        { key: 'organization_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 155px;', tdClass:'align-middle' },
        { key: 'sub_inventory_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 180px;', tdClass:'align-middle' },
        { key: 'sub_inventory_desc', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 145px;', tdClass:'align-middle' },
        { key: 'location_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'location_desc', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 195px;', tdClass:'align-middle' },
        { key: 'asset_group_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'stock_list_description', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'item_code', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'item_description', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'uom_description', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 100px;', tdClass:'align-middle' },
        { key: 'original_quantity', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'unit_price', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 180px;', tdClass:'align-middle' },
        { key: 'line_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'coverage_amount', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass:'align-middle' },
        { key: 'action', sortable: false, class:'text-center text-nowrap', thStyle: 'min-width: 145px;', tdClass:'align-middle' },
        { key: 'remove', sortable: false, class:'text-center text-nowrap', thStyle: 'min-width: 80px;', tdClass:'align-middle' },
      ],
      totalRows: 0,
      currentPage: 1,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
      isBusy: false,
    };
  },
  props: [
    "tableLine",
    "headerRow",
    "formatCurrency",
    "form",
    "isNullOrUndefined",
    "premium_rate",
    "setFirstLetterUpperCase",
    "showYearBE",
    "setYearBE",
    "setYearCE",
    "tableLineAll",
    "header_id",
    "vars",
    "checkStatusInterface",
    "checkStatusNew",
    "setBudgetYearFromFieldStCalendar",
    "setFullDateIsDateCE",
    "covertFomatDateMoment",
    "perPage",
    "checkExpenseFlag",
    "lastRowId"
  ],
  computed: {
    countNewList() {
      let aa = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "NEW") {
          aa += 1;
        }
      });
      return aa;
    },
    countConfirmedList() {
      let bb = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "CONFIRMED") {
          bb += 1;
        }
      });
      return bb;
    },
    countCancelledList() {
      let cc = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "CANCELLED") {
          cc += 1;
        }
      });
      return cc;
    },
    countInterfaceList() {
      let dd = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "INTERFACE") {
          dd += 1;
        }
      });
      return dd;
    },
    sumNewTotalAmount() {
      let ee = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "NEW") {
          ee += +row.line_amount;
        }
      });
      return ee;
    },
    sumConfirmedTotalAmount() {
      let ee = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "CONFIRMED") {
          ee += +row.line_amount;
        }
      });
      return ee;
    },
    sumCancelledTotalAmount() {
      let ee = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "CANCELLED") {
          ee += +row.line_amount;
        }
      });
      return ee;
    },
    sumInterfaceTotalAmount() {
      let ee = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "INTERFACE") {
          ee += +row.line_amount;
        }
      });
      return ee;
    },
    sumNewTotalCoverageAmount() {
      let ee = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "NEW") {
          ee += +row.coverage_amount;
        }
      });
      return ee;
    },
    sumConfirmedTotalCoverageAmount() {
      let ff = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "CONFIRMED") {
          ff += +row.coverage_amount;
        }
      });
      return ff;
    },
    sumCancelledTotalCoverageAmount() {
      let gg = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "CANCELLED") {
          gg += +row.coverage_amount;
        }
      });
      return gg;
    },
    sumInterfaceTotalCoverageAmount() {
      let hh = 0;
      this.tableLineAll.filter((row) => {
        if (row.status === "INTERFACE") {
          hh += +row.coverage_amount;
        }
      });
      return hh;
    },
    poli() {
      let pp = this.headerRow.policy_set_number;
      return pp;
    },
    polides() {
      let pp = this.headerRow.policy_set_description;
      return pp;
    },
    startt() {
      let pp = this.headerRow.period_from.split("/");
      let day = new Date(pp[1], pp[0], 1).getDate();
      let month = pp[0];
      let year = +pp[1] + 543;
       
      return day + "/" + month + "/" + year;
    },
    endd() {
      let pp = this.headerRow.period_to.split("/");
      let day = new Date(pp[1], pp[0], 0).getDate();
      let month = pp[0];
      let year = +pp[1] + 543;
       
      return day + "/" + month + "/" + year;
    },
    yearr() {
      let pp = this.headerRow.period_year;
      return pp;
    },
    checkStatus() {
      let someNew = this.tableLineAll.some(this.someStatusNew);
      let everyNew = this.tableLineAll.every(this.everyStatusNew);
      let everyConfirmed = this.tableLineAll.every(this.everyStatusConfirmed);
      let everyCancelled = this.tableLineAll.every(this.everyStatusCancelled);
      let someConfirmedCancelled = this.tableLineAll.some(
        this.someStatusConfirmedCancelled
      );
      let everyInterface = this.tableLineAll.every(this.everyStatusInterface);
      let someInterface = this.tableLineAll.some(this.someStatusInterface);

      if (everyNew && !someInterface) {
        return "NEW";
      } else if (
        someConfirmedCancelled &&
        !everyConfirmed &&
        !everyCancelled &&
        !someNew &&
        !someInterface
      ) {
        return "CONFIRMED";
      } else if (everyConfirmed && !someInterface) {
        return "CONFIRMED";
      } else if (everyCancelled && !someInterface) {
        return "CANCELLED";
      } else if (someNew && !everyNew) {
        // && !someInterface
        return "PENDING";
      } else if (everyInterface) {
        return "INTERFACE";
      } else if (someInterface && !someNew) {
        return "INTERFACE";
      }
      return "";
    },
  },

  methods: {
    onRowSelected(items) {
      this.selected = items
    },
    rowClass(item, type) {
      if (!item || type !== 'row') return
      if (item.row_id === this.lastRowId) return 'newLine'
    },
    getDataInventory(obj, dataIndex, row) {
      const vm = this
      vm.form.tableLine[dataIndex].sub_inventory_code = obj.code;
      vm.form.tableLine[dataIndex].sub_inventory_desc = obj.desc;
    },
    getDataLocation(obj, dataIndex, row) {
      const vm = this
      vm.form.tableLine[dataIndex].location_code = obj.code;
      vm.form.tableLine[dataIndex].location_desc = obj.desc;
    },
    clickComplete() {
      const vm = this;
      vm.$emit("call-ajax", true);
       
      vm.$refs.save_table_line.validate((valid) => {
        if (valid && vm.checkPeriodRangeManualTable()) {
          let rowsManualYearCE = [];
          let data = {};
          vm.tableLineAll.filter((all, index) => {

            if(all.line_type.toUpperCase() === "Manual".toUpperCase()){
              data = {
                ...all,
                line_number: index + 1,
                period_from:
                  all.flag === "add"
                    ? vm.setYearCE("month", all.period_from)
                    : all.period_from,
                period_to:
                  all.flag === "add"
                    ? vm.setYearCE("month", all.period_to)
                    : all.period_to,
              };
            }else {
              data = {
                row_id: all.row_id,
                line_id: all.line_id,
                line_number: index + 1,
                line_type: all.line_type,
                status: all.status,
                year: all.year,
                period_name: all.period_name,
                line_amount: all.line_amount,
                coverage_amount: all.coverage_amount,
                premium_rate: all.premium_rate,
                revenue_stamp: all.revenue_stamp,
                tax: all.tax,
                flag: all.flag,
                expense_flag: all.expense_flag,
                program_code: all.program_code,
              };
            }
            rowsManualYearCE.push(data);
          });
          let params = {
            data: {
              ...vm.headerRow,
              header_id: vm.headerRow.header_id,
              document_number: vm.headerRow.document_number,
              status: vm.checkStatus
                ? vm.checkStatus
                : vm.headerRow.status,
              year: vm.headerRow.period_year,
              period_name: vm.headerRow.period_name,
              period_from: vm.headerRow.period_from,
              period_to: vm.headerRow.period_to,
              policy_set_header_id: vm.headerRow.policy_set_header_id,
              policy_set_description: vm.headerRow.policy_set_description,
              department_code: vm.headerRow.department_code,
              department_desc: vm.headerRow.department_desc,
              asset_group_code: vm.headerRow.asset_group_code,
              stock_list_description: vm.headerRow.stock_list_description,
              total_amount: vm.headerRow.total_amount,
              total_cover_amount: vm.headerRow.total_cover_amount,
              total_insu_amount: vm.headerRow.total_insu_amount,
              manual_amount: vm.headerRow.manual_amount,
              manual_cover_amount: vm.headerRow.manual_cover_amount,
              manual_insu_amount: vm.headerRow.manual_insu_amount,
              inventory_amount: vm.headerRow.inventory_amount,
              inventory_cover_amount: vm.headerRow.inventory_cover_amount,
              inventory_insu_amount: vm.headerRow.inventory_insu_amount,
              program_code: "IRP0001",
              rows: rowsManualYearCE,
            },
          };
          if (vm.headerRow.header_id) {
            if (vm.checkStatus == "PENDING" || vm.checkStatus == "NEW") {
              swal(
                {
                  title: "Warning",
                  text: "มีรายการที่ยังไม่ถูกยืนยัน!",
                  type: "warning",
                  showCancelButton: true,
                  showConfirmButton: true,
                  closeOnConfirm: true,
                },
                function (isConfirm) {
                  if (isConfirm) {
                    vm.receivedCompleted(params);
                  }else {
                    vm.$emit("call-ajax", false);
                  }
                }
              );
            } else {
              vm.receivedCompleted(params);
            }
          } else {
            swal("Warning", "ไม่มีรหัสนี้ในระดับ Header!", "warning");
          }
        } else {
           
          vm.$emit("call-ajax", false);
          return false;
        }
      });
    },
    modalCalDate(dataIndex, dataId, row) {
      const vm = this;
      vm.modalId = dataId;
      vm.modalIndex = dataIndex;
      vm.modalVal = {
        start_date: row.calculate_start_date,
        end_date: row.calculate_end_date,
        days: row.calculate_days,
      };
      vm.modalDataRow = row;
      vm.$refs.editTableLineModalCalculationDate.$refs.form_calculate_date.clearValidate();
    },
    getCalculateDate(obj) {
      const vm = this;
      vm.modalVal.start_date = obj.start_date;
      vm.modalVal.end_date = obj.end_date;
      vm.modalVal.days = obj.days;
      if (vm.form.tableLine.length > 0) {
        vm.form.tableLine[vm.modalIndex].calculate_start_date = obj.start_date;
        vm.form.tableLine[vm.modalIndex].calculate_end_date = obj.end_date;
        vm.form.tableLine[vm.modalIndex].calculate_days = obj.days;
        vm.form.tableLine[vm.modalIndex].changeDate = true;
        vm.form.tableLine[vm.modalIndex].calculate_start_date_BE =
        vm.setYearBE("date", obj.start_date);
        vm.form.tableLine[vm.modalIndex].calculate_end_date_BE =
        vm.setYearBE("date", obj.end_date);
      }

      if (obj.days) {
        vm.$refs.save_table_line.fields
          .find(
            (f) => f.prop == "tableLine." + vm.modalIndex + ".calculate_days"
          )
          .clearValidate();
      } else {
        vm.$refs.save_table_line.validateField(
          "tableLine." + vm.modalIndex + ".calculate_days"
        );
      }
    },
    clickSelectAll() {
      let vm = this;
      vm.rowSelected = [];
      vm.rowSelectedId = [];
      let checked = $(`input[name="stock_year_select_all"]`).is(':checked')
      vm.form.tableLine.forEach((row, index) => {
        if (checked && !(vm.checkStatusInterface(row.status) || !vm.complete || vm.checkExpenseFlag)) {
          vm.setSelectedRow(row);
        }
      })
    },
    clickSelectRow(row_id, obj) {
      const vm = this;
      let checked = $(`input[name="stock_year_select${row_id}"]`).is(':checked')
      if (checked) {
        vm.setSelectedRow(obj)
        let setDataRowsNotInterface = vm.form.tableLine.filter((row, i) => {
          return !(vm.checkStatusInterface(row.status) || !vm.complete || vm.checkExpenseFlag);
        })
        if(setDataRowsNotInterface.length === vm.rowSelected.length){
          $(`input[name="stock_year_select_all"]`).prop('checked', true)
        }
      } else {
        const index = vm.rowSelected.indexOf(obj);
        if (index > -1) {
          vm.rowSelected.splice(index, 1);
          vm.rowSelectedId.splice(index, 1);
        }
        $(`input[name="stock_year_select_all"]`).prop('checked', false)
      }
    },
    setSelectedRow(data) {
      this.rowSelected.push(data)
      this.rowSelectedId.push(data.row_id);
    },
    clickConfirm() {
      this.$refs.save_table_line.validate((valid) => {
        if (valid) {
          this.rowSelected.filter((row) => {
            row.status = "CONFIRMED";
            return row;
          });
        } else {
          return false;
        }
      });
      if (this.rowSelected.length === 0) {
        swal("Warning", "กรุณาเลือกข้อมูลที่ต้องการยืนยัน!", "warning");
        return;
      }
    },
    clickCancel() {
      this.$refs.save_table_line.validate((valid) => {
        if (valid) {
          this.rowSelected.filter((row) => {
            row.status = "CANCELLED";
            return row;
          });
        } else {
          return false;
        }
      });
      if (this.rowSelected.length === 0) {
        swal("Warning", "กรุณาเลือกข้อมูลที่ต้องการยกเลิก!", "warning");
      }
    },
    clickClear() {
      this.$refs.save_table_line.validate((valid) => {
        if (valid) {
          this.rowSelected.filter((row) => {
             
            row.status = "NEW";
            return row;
          });
        } else {
          return false;
        }
      });
      if (this.rowSelected.length === 0) {
        swal("Warning", "กรุณาเลือกข้อมูลที่ต้องการรีเซต!", "warning");
        return;
      }
    },
    getDataOrg(obj, dataIndex, row) {
      const vm = this;
      vm.form.tableLine[dataIndex].organization_code = obj.code;
      vm.form.tableLine[dataIndex].organization_name = obj.desc;
      vm.form.tableLine[dataIndex].organization_id = obj.id;
      vm.form.tableLine[dataIndex].org_id = obj.id;
      vm.org_id = obj.id;
      if (!obj.code) {
        vm.form.tableLine[dataIndex].sub_inventory_code = "";
        vm.form.tableLine[dataIndex].sub_inventory_desc = "";
      }
    },
    getDataGroupProducts(obj, dataIndex, row) {
      const vm = this;
      vm.form.tableLine[dataIndex].stock_list_id = obj.code;
      vm.form.tableLine[dataIndex].stock_list_description = obj.desc;
    },
    getItems(obj, dataIndex, row) {
      const vm = this;
      vm.form.tableLine[dataIndex].item_code = obj.code;
      vm.form.tableLine[dataIndex].item_description = obj.desc;
      vm.form.tableLine[dataIndex].uom_code = obj.uom;
      vm.form.tableLine[dataIndex].uom_description = obj.uom_desc;
    },
    clickIncomplete() {
       
      this.complete = !this.complete;
      this.$emit("complete", this.complete);
    },
    someStatusNew(row) {
      if (row.status && row.status.toLowerCase() === "new") {
        return true;
      }
      return false;
    },
    everyStatusNew(row) {
      if (row.status && row.status.toLowerCase() === "new") {
        return true;
      }
      return false;
    },
    everyStatusConfirmed(row) {
      if (row.status && row.status.toLowerCase() === "confirmed") {
        return true;
      }
      return false;
    },
    everyStatusCancelled(row) {
      if (row.status && row.status.toLowerCase() === "cancelled") {
        return true;
      }
      return false;
    },
    someStatusConfirmedCancelled(row) {
      if (
        (row.status && row.status.toLowerCase() === "confirmed") ||
        row.status.toLowerCase() === "cancelled"
      ) {
        return true;
      }
      return false;
    },
    everyStatusInterface(row) {
      if (row.status && row.status.toLowerCase() === "interface") {
        return true;
      }
      return false;
    },
    someStatusInterface(row) {
      if (row.status && row.status.toLowerCase() === "interface") {
        return true;
      }
      return false;
    },
    getDataCoverageAmount(obj, dataIndex, row) {
      const vm = this;
      vm.form.tableLine[dataIndex].coverage_amount = obj.coverage_amount;
      if (obj.coverage_amount) {
        vm.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".coverage_amount")
          .clearValidate();
      } else {
        vm.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".coverage_amount"
        );
      }
    },
    showCalLineAmount(row, dataIndex) {
      const vm = this
      let original_quantity = row.original_quantity;
      let unit_price = row.unit_price;
      if (
        original_quantity &&
        original_quantity !== null &&
        original_quantity !== undefined
      ) {
        original_quantity = parseFloat(original_quantity);
      } else {
        original_quantity = 1;
      }
      if (unit_price && unit_price !== null && unit_price !== undefined) {
        unit_price = parseFloat(unit_price);
      } else {
        unit_price = 0;
      }
      vm.form.tableLine[dataIndex].line_amount = original_quantity * unit_price;
    },
    getDataOriginalQuantity(value, dataIndex, row) {
      this.showCalLineAmount(row, dataIndex);
    },
    getDataUnitPrice(value, dataIndex, row) {
      this.showCalLineAmount(row, dataIndex);
    },
    blurOriginalQty(value, dataIndex) {
      if (value) {
        this.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".original_quantity")
          .clearValidate();
      } else {
        this.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".original_quantity"
        );
      }
    },
    blurUnitPrice(value, dataIndex) {
      if (value) {
        this.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".unit_price")
          .clearValidate();
      } else {
        this.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".unit_price"
        );
      }
    },
    getValuePeriodFrom(date, dataIndex, row) {
      const vm = this
      let formatMonth = vm.vars.formatMonth;
      if (date) {
        vm.form.tableLine[dataIndex].period_from = moment(date).format(formatMonth);
        let twelveMonths = moment(date).add(11, "months"); // 12 month != 1 year
        vm.form.tableLine[dataIndex].period_to =
          moment(twelveMonths).format(formatMonth);
        vm.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".period_from")
          .clearValidate();
        vm.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".period_to")
          .clearValidate();
      } else {
        vm.form.tableLine[dataIndex].period_from = "";
        vm.form.tableLine[dataIndex].period_to = "";
        vm.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".period_from"
        );
        vm.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".period_to"
        );
      }
    },
    getValuePeriodTo(date, dataIndex, row) {
      const vm = this
      let formatMonth = this.vars.formatMonth;
      if (date) {
        this.form.tableLine[dataIndex].period_to = moment(date).format(formatMonth);
        let minusTwelveMonths = moment(date).add(-11, "months");
        this.form.tableLine[dataIndex].period_from =
          moment(minusTwelveMonths).format(formatMonth);
        this.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".period_to")
          .clearValidate();
        this.$refs.save_table_line.fields
          .find((f) => f.prop == "tableLine." + dataIndex + ".period_from")
          .clearValidate();
      } else {
        this.form.tableLine[dataIndex].period_to = "";
        this.form.tableLine[dataIndex].period_from = "";
        this.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".period_to"
        );
        this.$refs.save_table_line.validateField(
          "tableLine." + dataIndex + ".period_from"
        );
      }
    },
    getDataAssetGroupTable(obj, dataIndex, row)  {
      const vm = this
      vm.form.tableLine[dataIndex].asset_group_code = obj.code;
      vm.form.tableLine[dataIndex].asset_group_name = obj.desc;
    },
    checkPeriodRangeManualTable() {
      let validate = [];
      let i = "";
      let _this = this;
      validate = this.form.tableLine.filter((row, index) => {
         
        if (row.period_from_get_time > row.period_to_get_time) {
          i = index;
          return row;
        }
      });
       

      if (validate.length > 0) {
        swal(
          {
            title: "Warning",
            text: "ฟิลด์ตั้งแต่เดือนต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงเดือน!",
            type: "warning",
          },
          function (isConfirm) {
             
            if (isConfirm) {
              _this.form.tableLine[i].period_from = "";
              _this.form.tableLine[i].period_from_get_time = "";
              _this.form.tableLine[i].period_to = "";
              _this.form.tableLine[i].period_to_get_time = "";
              _this.$refs.save_table_line.validateField(
                "tableLine." + i + ".period_from"
              );
              _this.$refs.save_table_line.validateField(
                "tableLine." + i + ".period_to"
              );
            }
          }
        );
        return false;
      }
      return true;
    },
    receivedCompleted(params) {
       
      axios
        .post(`/ir/ajax/stocks`, params)
        .then(({ data }) => {
          let res = data.data;
           
          this.complete = !this.complete;
          this.res_header_id = res.header_id;
          swal({
            title: "Success",
            text: data.message,
            type: "success",
            showConfirmButton: true,
            closeOnConfirm: true,
          });
          this.$emit("complete", this.complete);
          this.$emit("header_id", this.res_header_id);
          this.$emit("call-ajax", false);
          this.res_rows_id = res.rows;
          this.setDisplayBtnRemove();
          this.$emit("call-ajax", false);
        })
        .catch((error) => {
          swal("Error", error, "error");
          this.$emit("call-ajax", false);
        });
    },
    clickRemove(row, dataIndex) {
      const vm = this;
      swal(
        {
          title: "Warning",
          text: "ต้องการลบหรือไม่?",
          type: "warning",
          showCancelButton: true,
          showConfirmButton: true,
          closeOnConfirm: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            vm.form.tableLine.splice(dataIndex, 1);
            const index = vm.tableLineAll.indexOf(row);
            vm.tableLineAll.splice(index, 1);
            swal({
              title: "Success",
              text: "",
              type: "success",
              showConfirmButton: true,
            });
          }
        }
      );
    },
    setDisplayBtnRemove() {
      const vm = this;
      let formatMonth = vm.vars.formatMonth;
      if (vm.res_rows_id.length > 0) {
        vm.tableLineAll.filter((all) => {
          all.period_from = all.flag == 'add' ? moment(all.period_from, formatMonth).subtract(543, "years").format(formatMonth) : all.period_from;
          all.period_to = all.flag == 'add' ? moment(all.period_to, formatMonth).subtract(543, "years").format(formatMonth) : all.period_to;
          vm.res_rows_id.filter((res) => {
            all.line_id = all.row_id == res.row_id ? res.line_id : all.line_id;
            all.flag = all.row_id == res.row_id ? 'update' : all.flag;
          })
          return all
        })
         
      }
    },
  },
  components: {
    lovOrg,
    lovInventory,
    lovLocation,
    lovUom,
    lovGroupProducts,
    modalCalculationDate,
    monthYearInput,
    currencyInput,
    ceilTenCurrencyInput,
    lovAssetGroup,
    lovItems,
  },
  watch: {
    complete(newVal, oldVal) {
      this.$emit("complete", newVal);
      if (!newVal) {
        $("#table_edit").find("input").prop("disabled", true);
        $(`input[name="stock_year_select_all"]`).prop("checked", false);
        $(`input[name="stock_year_select_all"]`).prop("disabled", true);
        $("#table_edit").find('input[type="checkbox"]').prop("checked", false);
        this.rowSelected = [];
        this.rowSelectedId = [];
      } else {
        $("#table_edit").find("input").prop("disabled", false);
        $(`input[name="stock_year_select_all"]`).prop("disabled", false);
      }
      $(".checkbox_edit_disabled").prop("disabled", true);
    },
    "headerRow.document_number"(newVal, oldVal) {
      if (newVal) {
        this.complete = false;
      } else {
        this.complete = true;
      }
    },
    "form.tableLine"(newVal, oldVal) {
      $(`input[name="stock_year_select_all"]`).prop('checked', false)
      this.rowSelected = [];
      this.rowSelectedId = [];
      this.totalRows = this.form.tableLine.length;
    },
  },
};
</script>

<style scoped>
  th,td {
    padding: 0.25rem;
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
