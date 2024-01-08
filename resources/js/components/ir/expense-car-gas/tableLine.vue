<template>
  <div class="margin_top_20">
    <el-form  class="demo-dynamic">
      <!-- <div>complete ==>x{{complete}}x
          <input type="checkbox" v-model="complete" > test complete
      </div> -->
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
                      :name="`expense_car_gas_select_all`"
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
          <template #head(renew_type)="header">
            <div>
              Renew Type<br>ประเภทการต่ออายุ
            </div>
          </template>
          <template #head(license_plate)="header">
            <div>
              ทะเบียนรถ
            </div>
          </template>
          <template #head(gas_station_type_name)="header">
            <div>
              Gas Station Type<br>ประเภทสถานีน้ำมัน
            </div>
          </template>
          <template #head(net_amount)="header">
            <div>
              Net Amount<br>ค่าเบี้ยประกันสุทธิต่อเดือน
            </div>
          </template>
          <template #head(start_date)="header">
            <div>
              Start Date<br>วันที่เริ่มต้นการคิดเบี้ยประกัน
            </div>
          </template>
          <template #head(end_date)="header">
            <div>
              End Date<br>วันที่สิ้นสุดการคิดเบี้ยประกัน
            </div>
          </template>
          <template #head(total_days)="header">
            <div>
              Days<br> จำนวนวัน
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

          <template #cell(selected)="row">
            <div class="form-check" style="position: inherit;">
              <input 
                :class="`form-check-input ${chkeckCancelled(row.item.status) ? 'checkbox_edit_disabled' : ''}`"
                type="checkbox"
                @click="clickSelectRow(row.item.expense_id, row.item)"
                :name="`expense_car_gas_select${row.item.expense_id}`"
                :value="`${row.item.expense_id}`"
                :disabled="chkeckCancelled(row.item.status)"
                :checked="columnSelectedId.includes(row.item.expense_id)"
                style="position: inherit;">
            </div>
          </template>
          <template #cell(status)="row">
            {{ setFirstLetterUpperCase(row.item.status) }}
          </template>
          <template #cell(net_amount)="row">
            {{ formatCurrency(row.item.net_amount) }}
          </template>
          <template #cell(start_date)="row">
            {{ row.item.start_date }}
          </template>
          <template #cell(end_date)="row">
            {{ row.item.end_date }}
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
              <button type="button" v-show="complete" :disabled="checkAllInterface"
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
  name: 'ir-expense-car-gas-table-line',
  data () {
    return {
      columnSelected: [],
      columnSelectedId: [],
      selected: [],
      complete: true,
      locked:true,
      setDataRowsNotInterface: [],
      res_rows_id: [],
      fields: [
        { key: 'selected', sortable: false, class:'text-center text-nowrap', },
        { key: 'status', sortable: true, thClass:'text-center text-nowrap', },
        { key: 'period_name', sortable: true, class:'text-center text-nowrap', },
        { key: 'expense_type_desc', sortable: true, thClass:'text-center text-nowrap', },
        { key: 'department_code', sortable: true, class:'text-center text-nowrap', },
        { key: 'department_name', sortable: true, class:'text-center text-nowrap text-nowrap', },
        { key: 'group_name', sortable: true, thClass:'text-center text-nowrap', },
        { key: 'renew_type', sortable: true, thClass:'text-center text-nowrap', },
        { key: 'license_plate', sortable: true, thClass:'text-center text-nowrap', tdClass:'text-nowrap' },
        { key: 'gas_station_type_name', sortable: true, thClass:'text-center text-nowrap', tdClass:'text-nowrap' },
        { key: 'net_amount', sortable: true, thClass:'text-center text-nowrap', tdClass:'text-right' },
        { key: 'start_date', sortable: true, class:'text-center text-nowrap', },
        { key: 'end_date', sortable: true, class:'text-center text-nowrap', },
        { key: 'total_days', sortable: true, class:'text-center text-nowrap', },
        { key: 'expense_account', sortable: true, class:'text-center text-nowrap', },
        { key: 'expense_account_desc', sortable: true, class:'text-center text-nowrap', },
        { key: 'prepaid_account', sortable: true, class:'text-center text-nowrap', },
        { key: 'prepaid_account_desc', sortable: true, class:'text-center text-nowrap', },
      ],
      totalRows: 0,
      currentPage: 1,
      perPage: 100,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
    }
  },
  props: [
    'form',
    'setFirstLetterUpperCase',
    'isNullOrUndefined',
    'showYearBE',
    'formatCurrency',
    'expense_id',
    'checkStatusInterface',
    'checkStatusCancelled',
    'vars',
    'setValuePeriodNameFormat',
    'formatfloat'
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
    chkeckCancelled(status){
      if (status.toUpperCase() === 'CANCELLED') {
          return true
      } else if( this.checkStatusInterface(status) ) {
          return true
      } else {
         return !this.complete
      }
    },
    clickSelectAll () {
      let _this = this;
      _this.columnSelected = [];
      _this.columnSelectedId = [];
      let checked = $(`input[name="expense_car_gas_select_all"]`).is(':checked')
      _this.form.tableLine.forEach((row, index) => {
        if (checked && !_this.chkeckCancelled(row.status)) {
          _this.setSelectedColumn(row);
        }
      })
    },
    setSelectedColumn (data) {
      this.columnSelected.push(data);
      this.columnSelectedId.push(data.expense_id);
    },
    clickSelectRow (expense_id, obj) {
      let _this = this;
      let checked = $(`input[name="expense_car_gas_select${expense_id}"]`).is(':checked')
      if (checked) {
        _this.setSelectedColumn(obj)
        _this.setDataRowsNotInterface = _this.form.tableLine.filter((row, i) => {
          return !_this.chkeckCancelled(row.status);
        })
        if(_this.setDataRowsNotInterface.length === _this.columnSelected.length){
          $(`input[name="expense_car_gas_select_all"]`).prop('checked', true)
        }
      } else {
        const index = _this.columnSelected.indexOf(obj);
        if (index > -1) {
          _this.columnSelected.splice(index, 1);
          _this.columnSelectedId.splice(index, 1);
        }
        $(`input[name="expense_car_gas_select_all"]`).prop('checked', false)
      }
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
    clickIncomplete () {
      this.complete = !this.complete
      this.$emit('complete', this.complete)
    },
    clickComplete () {
      let rows = [];
      let _this = this;
      _this.$emit('show-loading', true)
      this.form.tableLine.filter((row) => {
         
         
        rows.push({
          ...row,
          period_name: this.setValuePeriodNameFormat(moment(row.period_name, this.vars.formatMonth).toDate())
        })
      })
      let params = {
        data: rows
      }
       
      axios.post(`/ir/ajax/expense-car-gas`, params)
      .then(({data}) => {
        let res = data.data;
        this.complete = !this.complete
        this.locked = !this.locked
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
        _this.$emit('show-loading', false)
      })
      .catch((error) => {
        _this.$emit('show-loading', false)
        swal("Error", error, "error");
      })
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
  },
  watch: {
    'complete' (newVal, oldVal) {
       
       
      this.$emit('complete', newVal)
      if (!newVal) {
        $("#table_line").find("input").prop("disabled", true);
        $(`input[name="expense_car_gas_select_all"]`).prop('checked', false)
        $(`input[name="expense_car_gas_select_all"]`).prop('disabled', true)
        $("#table_line").find('input[type="checkbox"]').prop('checked', false)
        this.columnSelected = [];
        this.columnSelectedId = [];
      } else {
        $("#table_line").find("input").prop("disabled", false)
        $(`input[name="expense_car_gas_select_all"]`).prop('disabled', false)
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
      $(`input[name="expense_car_gas_select_all"]`).prop('checked', false)
      this.columnSelected = [];
      this.columnSelectedId = [];
      this.totalRows = this.form.tableLine.length;
    }
  },
  mounted(){
    
  },
  computed: {
    checkCancelAll(){
      return this.form.tableLine.every((row)=>{
        return row.status.toLowerCase() === "cancelled";
      })
    },
    checkAllInterface(){
      return this.form.tableLine.every((row) => {
        return row.status.toUpperCase() === 'INTERFACE';
      });
    },
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