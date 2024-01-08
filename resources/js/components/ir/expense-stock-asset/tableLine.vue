<template>
  <div class="margin_top_20">
    <el-form  class="demo-dynamic">

      <div class="table-responsive">
        <b-table
          table-class="table table-bordered"
          style="display: block; overflow: auto; max-height: 500px;"
          :items="form.tableLine"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :sort-direction="sortDirection"
          :tbody-tr-class="rowClass"
          primary-key="expense_id"
          show-empty
          small
          hover
          select-mode="single"
          selectable
          @row-selected="onRowSelected"
        >
          <template #head(selected)="header">
            Select All <br>
            <div  class="form-check"
                  style="position: inherit;">
              <input  class="form-check-input"
                      type="checkbox"
                      @click="clickSelectAll()"
                      :name="`expense_stock_asset_select_all`"
                      style="position: inherit;"
                      :disabled="!complete || checkAllInterface ? true : false">
            </div>
          </template>
          <template #head(status)="header">
            <div>
              IR Status<br>สถานะ
            </div>
          </template>
          <template #head(period_name)="header">
            <div>
              Period <br>เดือนปิดบัญชี
            </div>
          </template>
          <template #head(expense_type_desc)="header">
            <div>
              ประเภทของประกันภัย
            </div>
          </template>
          <template #head(policy_set_number)="header">
            <div>
              Policy No.<br>กรมธรรม์ชุดที่
            </div>
          </template>
          <template #head(department_code)="header">
            <div>
              Department Code<br>รหัสหน่วยงาน
            </div>
          </template>
          <template #head(department_name)="header">
            <div>
              Department<br>หน่วยงาน
            </div>
          </template>
          <template #head(group_name)="header">
            <div>
              Group<br>กลุ่ม
            </div>
          </template>
          <template #head(sector_code)="header">
            <div>
              รหัสสังกัด
            </div>
          </template>
          <template #head(sector_name)="header">
            <div>
              สังกัด
            </div>
          </template>
          <template #head(asset_number)="header">
            <div>
              Asset Number<br>เลขที่สินทรัพย์
            </div>
          </template>
          <template #head(insurance_premium)="header">
            <div>
              อัตราเบี้ยประกันภัย (%)
            </div>
          </template>
          <template #head(expense_account)="header">
            <div>
              Expense Account Code<br>รหัสบัญชีค่าใช้จ่าย
            </div>
          </template>
          <template #head(expense_account_desc)="header">
            <div>
              Expense Account Description<br>บัญชีค่าใช้จ่าย
            </div>
          </template>
          <template #head(prepaid_account)="header">
            <div>
              Prepaid Account Code<br>รหัสบัญชีจ่ายล่วงหน้า
            </div>
          </template>
          <template #head(prepaid_account_desc)="header">
            <div>
              Prepaid Account Description<br>บัญชีจ่ายล่วงหน้า
            </div>
          </template>
          <template #head(coverage_amount)="header">
            <div>
              Coverage Amount<br>มูลค่าทุนประกัน
            </div>
          </template>
          <template #head(insurance_amount)="header">
            <div>
              Premium<br>ค่าเบี้ยประกัน
            </div>
          </template>
          <template #head(coverage_amount_cal)="header">
            <div>
              มูลค่าทุนประกัน เพิ่ม/ลด
            </div>
          </template>
          <template #head(insurance_amount_cal)="header">
            <div>
              ค่าเบี้ย เพิ่ม/ลด
            </div>
          </template>
          <template #head(net_amount)="header">
            <div>
              Net Amount<br>ค่าเบี้ยประกันสุทธิต่อเดือน
            </div>
          </template>


          <template #cell(selected)="row">
            <div class="form-check" style="position: inherit;">
              <input 
                :class="`form-check-input ${checkStatusInterface(row.item.status) ? 'checkbox_edit_disabled' : ''}`"
                type="checkbox"
                @click="clickSelectRow(row.item.expense_id, row.item)"
                :name="`expense_stock_asset_select${row.item.expense_id}`"
                :value="`${row.item.expense_id}`"
                :disabled="checkStatusInterface(row.item.status) || !complete ? true : false || checkStatusCancelled(row.item.status)"
                :checked="columnSelectedId.includes(row.item.expense_id)"
                style="position: inherit;">
            </div>
          </template>
          <template #cell(status)="row">
            {{ setFirstLetterUpperCase(row.item.status) }}
          </template>
          <template #cell(coverage_amount)="row">
            {{ formatCurrency(row.item.coverage_amount) }}
          </template>
          <template #cell(insurance_premium)="row">
            {{ formatCurrency(row.item.insurance_premium) }}
          </template>
          <template #cell(insurance_amount)="row">
            {{ formatCurrency(row.item.insurance_amount) }}
          </template>
          <template #cell(coverage_amount_cal)="row">
            {{ formatCurrency(row.item.coverage_amount_cal) }}
          </template>
          <template #cell(insurance_amount_cal)="row">
            {{ formatCurrency(row.item.insurance_amount_cal) }}
          </template>
          <template #cell(net_amount)="row">
            {{ formatCurrency(row.item.net_amount) }}
          </template>
          
        </b-table>
      </div>
      <div class="row" v-if="totalRows > perPage">
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
              <button type="button" class="btn btn-primary" :disabled="!complete || checkAllInterface" @click="clickConfirm()">
                <i class="fa fa-check"></i>
                ยืนยัน
              </button>
              <!-- <button type="button" class="btn btn-danger" :disabled="!complete" @click="clickCancel()">
                <i class="fa fa-times"></i>
                ยกเลิก
              </button> -->
              <button type="button" class="btn btn-warning" :disabled="!complete || checkAllInterface" @click="clickClear()">
                <i class="fa fa-repeat"></i>
                รีเซต
              </button>
            </el-form-item>
          </div>
        </div>
        <div class="col-md-6 lable_align">
          <div class="form-group el_field">
            <el-form-item>
              <button type="button" v-show="complete" :disabled="checkCancelAll || checkAllInterface"
                class="btn btn-primary" @click="clickComplete()">
                <i class="fa fa-check-square-o"></i> บันทึก (ล็อค)
              </button>
              <button type="button" v-if="!complete" :disabled="checkCancelAll || checkAllInterface"
                class="btn btn-danger btn_incomplete" @click="clickIncomplete()">
                <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
              </button>
            </el-form-item>
          </div>
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: 'ir-expense-stock-asset-table-line',
  data () {
    return {
      columnSelected: [],
      columnSelectedId: [],
      setDataRowsNotInterface: [],
      complete: true,
      res_rows_id: [],
      disabled_change_page: false,
      current_page: 1,
      fields: [
        { key: 'selected', sortable: false, class:'text-center text-nowrap', },
        { key: 'status', sortable: true, class:'text-center text-nowrap', },
        { key: 'period_name', sortable: true, class:'text-center text-nowrap', },
        { key: 'expense_type_desc', sortable: true, class:'text-center text-nowrap', },
        { key: 'policy_set_number', sortable: true, class:'text-center text-nowrap', },
        { key: 'department_code', sortable: true, class:'text-center text-nowrap', },
        { key: 'department_name', sortable: true, class:'text-center text-nowrap text-nowrap', },
        { key: 'group_name', sortable: true, class:'text-center text-nowrap', },
        { key: 'sector_code', sortable: true, class:'text-center text-nowrap', },
        { key: 'sector_name', sortable: true, class:'text-center text-nowrap', },
        { key: 'asset_number', sortable: true, class:'text-center text-nowrap', },
        { key: 'net_amount', sortable: true, class:'text-center text-nowrap', },
        { key: 'insurance_premium', sortable: true, class:'text-center text-nowrap', },
        { key: 'expense_account', sortable: true, class:'text-center text-nowrap', },
        { key: 'expense_account_desc', sortable: true, class:'text-center text-nowrap', },
        { key: 'prepaid_account', sortable: true, class:'text-center text-nowrap', },
        { key: 'prepaid_account_desc', sortable: true, class:'text-center text-nowrap', },
        { key: 'coverage_amount', sortable: true, class:'text-center text-nowrap', },
        { key: 'insurance_amount', sortable: true, class:'text-center text-nowrap', },
        { key: 'coverage_amount_cal', sortable: true, class:'text-center text-nowrap', },
        { key: 'insurance_amount_cal', sortable: true, class:'text-center text-nowrap', },
        { key: 'net_amount', sortable: true, class:'text-center text-nowrap', },
      ],
      totalRows: 0,
      currentPage: 1,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
    }
  },
  props: [
    'setFirstLetterUpperCase',
    'isNullOrUndefined',
    'formatCurrency',
    'form',
    'expense_id',
    'checkStatusInterface',
    'vars',
    'setValuePeriodNameFormat',
    'checkStatusCancelled',
    'tableLineAll',
    'perPage',
  ],
  methods: {
    onRowSelected(items) {
      this.selected = items
    },
    rowClass(item, type) {
      if (!item || type !== 'row') return
      // if (item.expense_id === this.selectRowId) return 'mouse-over highlight'
      // return 'mouse-over';
    },
    clickConfirm () {
      if (this.columnSelected.length === 0) {
        swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยืนยัน!', 'warning')
        return
      } else {
        this.columnSelected.filter((row) => {
          row.status = 'CONFIRMED'
          return row
        })
      }
    },
    clickCancel () {
      if (this.columnSelected.length === 0) {
        swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยกเลิก!', 'warning')
      } else {
        this.columnSelected.filter((row) => {
          row.status = 'CANCELLED'
          return row
        })
      }
    },
    clickClear () {
      if (this.columnSelected.length === 0) {
        swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการรีเซต!', 'warning')
        return
      } else {
        this.columnSelected.filter((row) => {
          row.status = 'NEW'
          return row
        })
      }
    },
    clickSelectAll () {
      const vm = this;
      vm.columnSelected = [];
      vm.columnSelectedId = [];
      let checked = $(`input[name="expense_stock_asset_select_all"]`).is(':checked')
      vm.form.tableLine.forEach((row, index) => {
        if (checked && !vm.checkStatusInterface(row.status)) {
          vm.setSelectedColumn(row);
        }
      })
    },
    setSelectedColumn (data) {
      this.columnSelected.push(data);
      this.columnSelectedId.push(data.expense_id);
    },
    clickSelectRow (expense_id, obj) {
      const vm = this;
      let checked = $(`input[name="expense_stock_asset_select${expense_id}"]`).is(':checked')
      if (checked) {
        vm.setSelectedColumn(obj)
        vm.setDataRowsNotInterface = vm.form.tableLine.filter((row, i) => {
          return !vm.checkStatusCancelled(row.status);
        })
        if(vm.setDataRowsNotInterface.length === vm.columnSelected.length){
          $(`input[name="expense_stock_asset_select_all"]`).prop('checked', true)
        }
      } else {
        const index = vm.columnSelected.indexOf(obj);
        if (index > -1) {
          vm.columnSelected.splice(index, 1);
          vm.columnSelectedId.splice(index, 1);
        }
        $(`input[name="expense_stock_asset_select_all"]`).prop('checked', false)
      }
    },
    clickIncomplete () {
      this.complete = !this.complete
      this.$emit('complete', this.complete)
    },
    clickComplete () {
      this.$emit('toggle-loading', true);
      let rows = [];
      this.form.tableLine.filter((row) => {
        rows.push({
          ...row,
          period_name: this.setValuePeriodNameFormat(moment(row.period_name, this.vars.formatMonth).toDate())
        })
      })
      let params = {
        data: rows,
      }
      axios.post(`/ir/ajax/expense-asset-stock`, params)
      .then(({data}) => {
        this.$emit('toggle-loading', false);
        let res = data.data;
        this.complete = !this.complete
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          showConfirmButton: true,
          closeOnConfirm: true
        });
        this.$emit('complete', this.complete)
        this.res_rows_id = res.rows;
        this.form.tableLine = this.setDocumentNumber();
      })
      .catch((error) => {
        this.$emit('toggle-loading', false);
        swal("Error", error, "error");
      })
    },
    clickRow (row) {
      let obj = {
        status: this.isNullOrUndefined(row.status),
        expense_type_code: this.isNullOrUndefined(row.expense_type_code),
        policy_set_header_id: this.isNullOrUndefined(row.policy_set_header_id),
        department_code: this.isNullOrUndefined(row.department_code),
        department_name: this.isNullOrUndefined(row.department_name),
        group_name: this.isNullOrUndefined(row.group_name),
        sector_code: this.isNullOrUndefined(row.sector_code),
        sector_name: this.isNullOrUndefined(row.sector_name),
        asset_number: this.isNullOrUndefined(row.asset_number),
        insurance_premium: this.isNullOrUndefined(row.insurance_premium),
        expense_account: this.isNullOrUndefined(row.expense_account),
        expense_account_desc: this.isNullOrUndefined(row.expense_account_desc),
        prepaid_account: this.isNullOrUndefined(row.prepaid_account),
        prepaid_account_desc: this.isNullOrUndefined(row.prepaid_account_desc),
        coverage_amount: this.isNullOrUndefined(row.coverage_amount),
        insurance_amount: this.isNullOrUndefined(row.insurance_amount),
        coverage_amount_cal: this.isNullOrUndefined(row.coverage_amount_cal),
        insurance_amount_cal: this.isNullOrUndefined(row.insurance_amount_cal),
        net_amount: this.isNullOrUndefined(row.net_amount)
      }
      this.$emit('click-row', obj)
    },
    setDocumentNumber () {
      return this.form.tableLine.filter((form) => {
        this.res_rows_id.filter((res) => {
          form.document_number = form.rowId == res.row_id ? res.document_number : form.document_number;
          form.expense_id = form.rowId == res.row_id ? res.expense_id : form.expense_id;
        })
        return form;
      })
    },
    sortArrays(arrays) {
      // return _.orderBy(arrays, 'document_number', 'asc');
      return _.orderBy(arrays, ['status', 'document_number'], ['desc', 'asc'])
    },
  },
  computed: {
    checkCancelAll(){
      return this.tableLineAll.every((row)=>{
        return row.status.toLowerCase() === "cancelled";
      })
    },
    checkAllInterface(){
      return this.tableLineAll.every((row) => {
        return row.status.toUpperCase() === 'INTERFACE';
      });
    },
  },
  watch: {
    'complete' (newVal, oldVal) {
      this.$emit('complete', newVal)
      if (!newVal) {
        $("#table_line").find("input").prop("disabled", true);
        $(`input[name="expense_stock_asset_select_all"]`).prop('checked', false)
        $(`input[name="expense_stock_asset_select_all"]`).prop('disabled', true)
        $("#table_line").find('input[type="checkbox"]').prop('checked', false)
        this.columnSelected = []
        this.columnSelectedId = [];
      } else {
        $("#table_line").find("input").prop("disabled", false)
        $(`input[name="expense_stock_asset_select_all"]`).prop('disabled', false)
      }
      $('.checkbox_edit_disabled').prop("disabled", true);
    },
    'document_number' (newVal, oldVal) {
      if (this.form.tableLine.length > 0) {
        if (newVal) {
          this.complete = false
        } else {
          this.complete = true
        }
      } else {
        this.complete = true
      }
    },
    'form.tableLine' (newVal, oldVal) {
      $(`input[name="expense_stock_asset_select_all"]`).prop('checked', false)
      this.columnSelected = [];
      this.columnSelectedId = [];
      this.totalRows = this.form.tableLine.length;
    }
  }
}
</script>

<style scoped>
  th, td {
    padding: 0.25rem;
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
