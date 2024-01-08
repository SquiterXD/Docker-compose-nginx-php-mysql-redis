<template>
  <div v-loading="loading">
    <edit-search
      :search="search"
      :clickCreate="clickCreate"
      :headerRow="headerRow"
      @search-table-line="getDataTableLine"
      :disabled="!complete || searching || checkExpenseFlag"
      :tableLineAll="tableLineAll"
      @change-status="getDataStatus"
      @change-lov="getDataLocation"
    />
    <edit-table-line
      :isNullOrUndefined="funcs.isNullOrUndefined"
      :formatCurrency="funcs.formatCurrency"
      :headerRow="headerRow"
      :premium_rate="premium_rate"
      :form="form"
      :showYearBE="funcs.showYearBE"
      :perPage="per_page"
      ref="editEditTableLine"
      @complete="getValueComplete"
      :showPeriodNameFormat="funcs.showPeriodNameFormat"
      :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
      :setYearCE="funcs.setYearCE"
      :setYearBE="funcs.setYearBE"
      :tableLineAll="tableLineAll"
      :vars="vars"
      :setValuePeriodNameFormat="funcs.setValuePeriodNameFormat"
      :checkStatusInterface="funcs.checkStatusInterface"
      :setBudgetYearFromFieldStCalendar="funcs.setBudgetYearFromFieldStCalendar"
      :setLabelExpenseFlag="funcs.setLabelExpenseFlag"
      :covertFomatDateMoment="funcs.covertFomatDateMoment"
      :setDefaultEndDateIsLastDateOfMonth="funcs.setDefaultEndDateIsLastDateOfMonth"
      :checkExpenseFlag="checkExpenseFlag"
      :lastRowId="lastRowId"
      @click-row="getDataRowShowTableTotal"
      @call-ajax="callAjax"
    />
  </div>
</template>

<script>
import uuid from 'uuid/v1';
import * as scripts from "../scripts";
import editSearch from "./editSearch";
import editTableLine from "./editTableLine";
import moment from "moment";
export default {
  name: "ir-stock-monthly-edit",
  data() {
    return {
      search: {
        status: "",
        sub_group_code: "",
        item_code: "",
      },
      vars: scripts.vars,
      headerRow: {
        header_id: "",
        document_number: "",
        status: "",
        period_year: "",
        period_from: "",
        period_to: "",
        policy_set_header_id: "",
        policy_set_description: "",
        department_code: "",
        department_desc: "",
        asset_group_code: "",
        inventory_amount: "",
        inventory_cover_amount: "",
        inventory_insu_amount: "",
        manual_amount: "",
        manual_cover_amount: "",
        manual_insu_amount: "",
        total_amount: "",
        total_cover_amount: "",
        total_insu_amount: "",
      },
      funcs: scripts.funcs,
      rowsLength: 0,
      form: {
        tableLine: [],
      },
      complete: true,
      tableLineAll: [],
      premium_rate: 0,
      mocks: scripts.mocks,
      prepaid_insurance: 0,
      revenue_stamp: 0,
      tax: 0,
      manual_insu_amount: "",
      old_manual_insu_amount: "",
      loading: false,
      searching: false,
      per_page: 500,
      lastRowId: '',
    };
  },
  props: ["headerId"],
  methods: {
    getDataRowShowTableTotal(dataRow) {
      if (dataRow.old_manual_insu_amount) {
        this.old_manual_insu_amount = +dataRow.old_manual_insu_amount;
      }
      this.form.tableLineAll = dataRow;
    },
    getTableHeader() {
      let params = {
        period_year: "",
        policy_set_header_id: "",
        status: "",
        period_from: "",
        period_to: "",
        department_from: "",
        department_to: "",
        insurance_start_date: "",
        insurance_end_date: "",
        period_name: "",
        data_month: "",
        program_code: "IRP0002",
      };
      axios
        .get(`/ir/ajax/stocks`, { params })
        .then(({ data }) => {
          this.headerRow =
            this.setHeaderRow(data.data) === undefined
              ? this.headerRow
              : this.setHeaderRow(data.data);
          this.getDataPremiumRate();
        })
        .catch((error) => {
          swal("Error", error, "error");
        });
    },
    setHeaderRow(array) {
      // 
      let data = array.find((row) => {
        return row.header_id == this.headerId;
      });
      // 
      return data;
    },
    clickCreate() {
      const vm = this;
      vm.$refs.editEditTableLine.$refs.save_table_line.validate((valid) => {
        if (valid) {
          let period_name = new Date(`01 ${vm.headerRow.period_name}`);
          let startOf = moment(period_name).startOf("month");
          let endOf = moment(period_name).endOf("month");
          let start_period = moment(startOf).format(vm.vars.formatDate);
          let end_period = moment(endOf).format(vm.vars.formatDate);
          let full_start = moment(start_period, vm.vars.formatDate);
          let full_end = moment(end_period, vm.vars.formatDate);
          let days = full_end.diff(full_start, "days") + 1;
           
          vm.rowsLength = vm.tableLineAll.length;
          vm.lastRowId = uuid();
          let row = {
            index: vm.rowsLength,
            row_id: vm.lastRowId,
            line_number: ++vm.rowsLength,
            status: "NEW",
            period_from: "",
            period_to: "",
            org_id: "",
            sub_inventory_code: "",
            sub_inventory_desc: "",
            location_code: "",
            location_desc: "",
            item_code: "",
            item_description: "",
            uom_code: "",
            original_quantity: 1.0,
            unit_price: "",
            line_amount: "",
            coverage_amount: "",
            year: vm.headerRow.period_year,
            period_name: vm.headerRow.period_name,
            policy_set_header_id: vm.headerRow.policy_set_header_id,
            organization_id: "",
            organization_code: "",
            item_id: "",
            line_type: "MANUAL",
            flag: "add",
            line_id: "",
            header_id: vm.headerRow.header_id,
            calculate_start_date: start_period,
            calculate_end_date: end_period,
            calculate_days: days,
            premium_rate: vm.premium_rate,
            calculate_start_date_BE: vm.funcs.showYearBE("date",start_period),
            calculate_end_date_BE: vm.funcs.showYearBE("date", end_period),
            expense_flag: "N",
            prepaid_insurance: vm.prepaid_insurance,
            revenue_stamp: vm.revenue_stamp,
            asset_group_code: '', // vm.headerRow.asset_group_code,
            stock_list_description: '',
            tax: vm.tax,
          };
          vm.form.tableLine.push(row);
          vm.tableLineAll.push(row);
          let page = Math.ceil(vm.form.tableLine.length / vm.per_page);
          vm.$nextTick(() => {
            vm.$refs.editEditTableLine.currentPage = page;
            vm.$nextTick(() => {
              const el = vm.$el.getElementsByClassName('newLine')[0];
              if (el) {
                el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
              }
            });
          });
        } else {
          return false;
        }
      });
    },
    getTableLine() {
      this.loading = true;
      // 
      let params = {
        header_id: this.headerId,
        period_year: this.headerId ? "" : this.headerRow.period_year,
        period_from: this.headerId ? "" : this.headerRow.period_from,
        period_to: this.headerId ? "" : this.headerRow.period_to,
        status: this.headerId ? "" : this.search.status,
        sub_group_code: this.search.sub_group_code,
        program_code: "IRP0002",
      };
      axios
        .get(`/ir/ajax/stocks/show`, { params })
        .then(({ data }) => {
          this.form.tableLine = this.setPropertyTableLine(data.data);
          this.tableLineAll = this.setPropertyTableLine(data.data);
          this.rowsLength = this.tableLineAll.length;
          this.loading = false;
        })
        .catch((error) => {
          swal("Error", error, "error");
          this.loading = false;
        });
    },
    getDataTableLine(obj) {
      this.form.tableLine = obj.table;
      if(obj.status != '' || obj.sub_group_code != '' || obj.item_code){
        this.searching = true;
      }else {
        this.searching = false;
      }
      // this.rowsLength = obj.table.length;
    },
    getDataLocation(value) {
      this.search.sub_group_code = value;
    },
    getDataStatus(value) {
      this.search.status = value;
    },
    callAjax(value) {
      this.loading = value;
    },
    setPropertyTableLine(array) {
      return array.rows.filter((rows, index) => {

        rows.index = index;
        rows.row_id = uuid();
        rows.sub_inventory_code = rows.subinventory_code;
        rows.sub_inventory_desc = rows.subinventory_desc;
        rows.location_code = rows.sub_group_code;
        rows.location_desc = rows.sub_group_desc;
        rows.uom_code = rows.uom_code;
        rows.uom_description = rows.uom;
        rows.original_quantity = rows.original_qty;
        rows.flag = rows.flag === "add" ? rows.flag : "update";
        rows.year = this.headerRow.period_year;
        rows.premium_rate = rows.premium_rate === null ? 0 : rows.premium_rate;
        rows.calculate_start_date_BE =
          rows.flag === "update"
            ? this.funcs.showYearBE("date", rows.calculate_start_date)
            : rows.calculate_start_date;
        rows.calculate_end_date_BE =
          rows.flag === "update"
            ? this.funcs.showYearBE("date", rows.calculate_end_date)
            : rows.calculate_end_date;
        rows.prepaid_insurance =
          rows.prepaid_insurance === null ? 0 : rows.prepaid_insurance;
        rows.revenue_stamp =
          rows.revenue_stamp === null ? 0 : rows.revenue_stamp;
        rows.tax = rows.tax === null ? 0 : rows.tax;
        return rows;
      });
    },
    getDataPremiumRate() {
      // 
      let params = {
        policy_set_header_id: this.headerRow.policy_set_header_id,
        date_from: this.funcs.setFotmatPeriodNameIsFullDate(
          this.headerRow.period_name
        ),
        date_to: this.funcs.setFotmatPeriodNameIsFullDate(
          this.headerRow.period_name
        ),
        year: this.headerRow.period_year,
      };
      axios
        .get(`/ir/ajax/lov/premium-rate`, { params })
        .then(({ data }) => {
          if (
            data.data === "" ||
            data.data === null ||
            data.data === undefined
          ) {
            this.premium_rate = 0;
          } else {
            if (
              data.data.premium_rate === "" ||
              data.data.premium_rate === null ||
              data.data.premium_rate === undefined
            ) {
              this.premium_rate = 0;
              this.prepaid_insurance = 0;
              this.revenue_stamp = 0;
              this.tax = 0;
            } else {
              this.premium_rate = parseFloat(data.data.premium_rate);
              this.prepaid_insurance = parseFloat(data.data.prepaid_insurance);
              this.revenue_stamp = parseFloat(data.data.revenue_stamp);
              this.tax = parseFloat(data.data.tax);
            }
          }
          this.getTableLine();
        })
        .catch((error) => {
          swal("Error", error, "error");
        });
    },
    getValueComplete(value) {
      this.complete = value;
    },
  },
  components: {
    editSearch,
    editTableLine,
  },
  computed: {
    checkExpenseFlag (){
      return this.headerRow.expense_flag === 'Y';
    }
  },
  watch: {

  },
  created() {
    this.getTableHeader();
  },
}
</script>
