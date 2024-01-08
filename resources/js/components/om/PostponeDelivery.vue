<template>
  <div>
    <div class="col-xl-12 m-auto" v-loading="this.data_postpone.loading.postpone">
      <hr class="lg" />
      <div class="row mb-3">
          <label class="d-block mr-3">วันส่งร้านค้า</label>
          <div v-for="(item,index) in deliveryDates" :key="index">
            <label class="pr-3">
                <input  type="radio" :value="item.meaning" 
                        name="delivery_date" :id="item.meaning"
                        style="height:20px; width:20px; vertical-align: middle;"
                        @click="radioClick()">
                <span> {{ item.meaning }} </span>
            </label>
          </div>
      </div>

      <div class="row m-t-sm">
        <div class="form-group col-sm-3">
          <label class="d-block">ปีงบประมาณ</label>
          <el-select  v-model="data_postpone.year" 
                      placeholder="ปีงบประมาณ"
                      :disabled="data_postpone.disabled.year"
                      style="width: 100%;"
                      @change="getPeriodPostPone(data_postpone.year)"
                      clearable>
            <el-option
              v-for="(item,index) in budgetYear"
              :key="index"
              :label="parseInt(item.budget_year) + parseInt(543)"
              :value="item.budget_year">
            </el-option>
          </el-select>
        </div>

        <div class="form-group col-sm-3">
          <label class="d-block">งวด</label>
          <el-select  v-model="data_postpone.period" 
                      placeholder="งวด"
                      :disabled="data_postpone.disabled.period"
                      style="width: 100%;"
                      clearable
                      @change="getPeriodPostPoneByDate()">
            <el-option
              v-for="(item,index) in data_postpone.periodList"
              :key="index"
              :label="item.period_no"
              :value="item.period_line_id">
            </el-option>
          </el-select>
        </div>

        <div class="form-group col-sm-3">
          <label class="d-block">วันส่งประจำงวด</label>
          <datepicker-th
              style="width: 100%;"
              class="form-control md:tw-mb-0 tw-mb-2"
              name="start_date"
              placeholder="โปรดเลือกวันที่"
              v-model="data_postpone.from_date"
              format="DD/MM/YYYY"
              :disabled="data_postpone.disabled.from_date"
              @dateWasSelected="getValueFromDate">
          </datepicker-th>
        </div>

        <div class="form-group col-sm-3">
          <label class="d-block">เลื่อนเป็นวันที่</label>
          <datepicker-th
              style="width: 100%;"
              class="form-control md:tw-mb-0 tw-mb-2"
              name="start_date"
              placeholder="โปรดเลือกวันที่"
              v-model="data_postpone.to_date"
              format="DD/MM/YYYY"
              :disabled="data_postpone.disabled.to_date"
              @dateWasSelected="getValueToDate">
          </datepicker-th>
        </div>
      </div>

      <div class="row m-t-sm">
          <div class="col-sm-12 text-right">
              <button class="btn btn-md btn-success"
                    type="button"
                    @click="applyData()"
                    :disabled="this.data_postpone.customers.length != 0 ? false : true">
                <i class="fa fa-plus"></i> Apply
              </button>
              <button type="button" class="btn btn-md btn-danger" 
                      @click="clearDataPostPone()" 
                      :disabled="this.data_postpone.customers.length != 0 ? false : true">
                <i class="fa fa-refresh"></i> ล้างค่า
              </button>
          </div>
      </div>
    </div>

    <div class="col-xl-12 m-auto">
      <hr class="lg" />

      <div class="form-header-buttons">
        <div class="buttons d-flex">
          <button
            class="btn btn-md btn-success"
            type="button"
            v-on:click="createNewRow()"
          >
            <i class="fa fa-plus"></i> สร้าง
          </button>
          <button
            class="btn btn-md btn-danger"
            type="button"
            v-on:click="removeData()"
          >
            <i class="fa fa-times"></i> ลบ
          </button>
          <button
            class="btn btn-md btn-primary"
            type="button"
            v-on:click="savePostpone()"
          >
            <i class="fa fa-save"></i> บันทึก
          </button>
        </div>
      </div>

      <div class="hr-line-dashed"></div>
      <div class="text-right" style="padding-bottom: 10px;">
        จำนวนบรรทัดของข้อมูล: {{ this.data_list.length }}
      </div>
      <div class="table-responsive-xl">
        <table class="table table-bordered text-center" v-loading="this.data_postpone.loading.table">
          <thead>
            <tr class="text-center">
              <th class="w-40">
                เลือกทั้งหมด 
                <input
                  type="checkbox"
                  style="margin-top: 10px"
                  class="form-control"
                  id="checkboxAll"
                  @click="checkboxAll()"
                />      
              </th>
              <th class="w-150">รหัสร้านค้า</th>
              <th class="min-150">ชื่อร้านค้า</th>
              <th class="w-130">ปีงบประมาณ</th>
              <th class="w-90">งวดที่</th>
              <th class="w-150">วันส่งประจำงวด</th>
              <th class="w-150">เลื่อนเป็นวันที่</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(v, i) in data_list" v-bind:key="i">
              <td>
                <input
                  type="checkbox"
                  style="margin-top: 10px"
                  :value="v.selected"
                  :disabled="!v.fix"
                  class="form-control"
                  :id="'checkbox'+i"
                  @change="changeChecked(i, 'checkbox'+i)"
                />
              </td>
              <td>
                <el-select
                  v-model="v.customer_number"
                  filterable
                  remote
                  reserve-keyword
                  :remote-method="remoteMethod"
                  @change="sourceChanged($event, i)"
                  :loading="loading"
                >
                  <el-option
                    v-for="item in options"
                    :key="item.customer_id"
                    :value="item.customer_number"
                    >{{ item.customer_number + " : " + item.customer_name }}
                  </el-option>
                </el-select>
              </td>
              <td>
                <el-input
                  placeholder="ชื่อร้าน"
                  :value="v.customer_name"
                  disabled
                ></el-input>
              </td>
              <td>
                <el-select
                  v-model="v.year"
                  filterable
                  placeholder="Select"
                  @change="changeYear($event, i)"
                  :disabled="!v.fix"
                >
                  <el-option
                    v-for="item in years"
                    :key="item.budget_year"
                    :label="parseInt(item.budget_year) + parseInt(543)"
                    :value="item.budget_year"
                  >
                  </el-option>
                </el-select>
              </td>
              <td>
                <el-select
                  v-model="v.installment"
                  filterable
                  placeholder="Select"
                  @change="changeInstallment($event, i)"
                  :disabled="!v.fix"
                >
                  <el-option
                    v-for="item in v.period"
                    :key="item.period_line_id"
                    :label="item.period_no"
                    :value="item.period_line_id"
                  >
                  </el-option>
                </el-select>
              </td>
              <td>
                <datepicker-th
                  style="width: 100%"
                  class="form-control"
                  v-model="v.from_date"
                  placeholder="วันส่งประจำงวด"
                  :value="v.from_date"
                  format="DD/MM/Y"
                ></datepicker-th>
              </td>
              <td>
                <datepicker-th
                  style="width: 100%"
                  class="form-control"
                  v-model="v.to_date"
                  placeholder="เลื่อนเป็นวันที่"
                  :value="v.to_date"
                  :disabled="!v.fix"
                  disabledDateTo="[0]"
                  @dateWasSelected="changeToDate($event, i)"
                  format="DD/MM/Y"
                ></datepicker-th>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
  
</template>

<script>
import moment from "moment";

export default {
  props: ['deliveryDates', 'budgetYear'],
  data() {
    return {
      customers:        [],
      customer_select:  [],
      years:            [],
      installments:     [],
      removed:          [],
      options:          [],
      data_list: [
        {
          postpone_order_id:  0,
          customer_number:    "",
          customer_name:      "",
          year:               "",
          installment:        "",
          from_date:          "",
          to_date:            "",
          budgetYear:         [],
          period:             [],
          fix:                true,
          old:                false,
          selected:           0,
        },
      ],
      loading: false,
      data_postpone:{
        year:         '',
        period:       '',
        from_date:    '',
        to_date:      '',
        disabled:{
          year:       true,
          period:     true,
          from_date:  true,
          to_date:    true
        },
        periodList:   [],
        customers:    [],
        loading:{
          postpone: false,
          table:    false
        }
      },
    };
  },
  mounted() {
    this.customerList();
    this.getParams();
    this.yearsList();
  },
  methods: {
    remoteMethod(query) {
      if (query !== "") {
        this.loading = true;
        setTimeout(() => {
          this.loading = false;
          this.options = this.customers.filter((item) => {
            return (
              item.customer_name.indexOf(query) > -1 ||
              item.customer_number.indexOf(query) > -1
            );
          });
        }, 200);
      } else {
        this.options = [];
      }
    },

    getParams: function () {
      var vm = this;
      let urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has("customer_number")) {
        let dataPost = {
          customer_number: urlParams.get("customer_number"),
          year: urlParams.get("year"),
          installment: urlParams.get("installment"),
          date: urlParams.get("date"),
        };

        axios
          .post("/om/ajax/postpone-delivery/search", dataPost)
          .then((res) => {
            vm.data_list = res.data.data;
          })
          .catch((error) => {
            // error.response.status Check status code
          })
          .finally(() => {
            //Perform action in always
          });
      }
    },

    customerList: function () {
      var vm = this;
      axios.get("/api/v1/customer").then((res) => {
        vm.customers = res.data.data;
        vm.options = res.data.data;
      });
    },

    yearsList: function () {
      var vm = this;
      axios.get("/om/ajax/postpone-delivery/years").then((res) => {
        vm.years = res.data.data;
      });
    },

    changeYear(e, i) {
      var value = e;
      this.data_list[i].year = value;
      this.data_list[i].installment = "";
      this.installmentList(value, i);
    },

    changeChecked: function (i, type) {
      var vm = this;
      // console.log(vm.data_list[i].selected, 'ก่อน')
      if (vm.data_list[i].selected == 1) {
        vm.data_list[i].selected = 0;
      }else{
        if (vm.data_list[i].selected == 0) {
          vm.data_list[i].selected = 1;
        } 
      }
      // console.log(vm.data_list[i].selected, 'หลัง')

      if($("td input:checkbox:checked").length != $("td input:checkbox").length){
        $("#checkboxAll").prop('checked',false);
      }else{
        $("#checkboxAll").prop('checked',true);
      }
    },

    installmentList: function (year, i) {
      var vm = this;
      axios
        .get("/om/ajax/postpone-delivery/installments/" + year)
        .then((res) => {
          vm.data_list[i].period = res.data.data;
        });
    },

    changeInstallment(e, i) {
      var vm = this;
      axios
        .get(
          "/om/ajax/postpone-delivery/date-by-no/" +
            vm.data_list[i].customer_number +
            "/" +
            e
        )
        .then((res) => {
          vm.data_list[i].from_date = res.data.data;
        });

      this.data_list[i].installment = e;
    },

    createNewRow: function () {
      let vm = this;
      vm.data_list.push({
        postpone_order_id:  0,
        customer_number:    "",
        customer_name:      "",
        year:               "",
        installment:        "",
        from_date:          "",
        to_date:            "",
        budgetYear:         [],
        period:             [],
        fix:                true,
        old:                false,
        selected:           0,
      });
    },

    getCustomerName: function (number, i) {
      var vm = this;
      vm.data_list[i].customer_number = number;
      vm.customers.filter(function (v) {
        if (v.customer_number == number) {
          vm.data_list[i].customer_name = v.customer_name;
        }
      });
    },

    sourceChanged: function (e, i) {
      this.getCustomerName(e, i);
      this.getNextDate(e, i);
      this.data_list[i].year = moment().year() + 543;
      this.installmentList(moment().year(), i);
    },

    getNextDate: function (number, i) {
      var vm = this;
      axios
        .get("/om/ajax/postpone-delivery/next-date/" + number)
        .then((res) => {
          vm.data_list[i].from_date = res.data.data;
        });
    },

    changeFromDate(e, i) {
      this.data_list[i].from_date = e;
    },

    changeToDate(e, i) {
      this.data_list[i].to_date = moment(e).format("DD/MM/Y");
    },

    removeData: function () {
      let vm        = this;
      let dataPost  = [];

      dataPost = vm.data_list.filter(
                  (item) => item.selected == 1
                );

      swal(
        {
          title: "แจ้งเตือน",
          text: "ต้องการลบข้อมูลเลื่อนส่งประจำสัปดาห์",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-primary",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ยกเลิก",
          closeOnConfirm: false,
          closeOnCancel: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            axios
              .post("/om/ajax/postpone-delivery/remove", dataPost)
              .then((res) => {
                if (res.data.status) {
                  vm.getParams();
                }
              })
              .catch((error) => {
                // error.response.status Check status code
              })
              .finally(async () => {
                $("input[type=checkbox]").prop("checked", false);
                console.log(vm.data_list, 'www removeData')
                vm.data_list = vm.data_list.filter(
                  (item) => item.selected == 0
                );
                swal.close();
              });
          } else {
            swal.close();
          }
        }
      );

    },

    savePostpone: function () {
      let vm = this;
      let dataPost = [
        {
          postpone: vm.data_list,
        },
      ];

      swal(
        {
          title: "แจ้งเตือน",
          text: "ต้องการบันทึกข้อมูลเลื่อนส่งประจำสัปดาห์",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-primary",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ยกเลิก",
          closeOnConfirm: false,
          closeOnCancel: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            axios
              .post("/om/ajax/postpone-delivery/create", dataPost)
              .then((res) => {
                if (res.data.status) {
                  if (res.data.error) {
                    swal("Warning!", "เกิดข้อผิดพลาดบางรายการ", "error");
                    vm.getParams();
                  } else {
                    swal("Success", "บันทึกข้อมูลสำเร็จ", "success");
                    vm.getParams();
                  }
                }
              })
              .catch((error) => {
                // error.response.status Check status code
              })
              .finally(() => {
                //Perform action in always
              });
          } else {
            swal.close();
          }
        }
      );
    },

    radioClick: function() {
      let vm = this;
      let radioData = $('input[name="delivery_date"]:checked').val();
      vm.data_postpone.customers = [];
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table = true;

      axios
        .get("/om/ajax/postpone-delivery/get-customers/" + radioData)
        .then((res) => {
          if(res.data.data.length != 0){
            vm.data_postpone.customers          = res.data.data
            vm.data_postpone.disabled.year      = false;
            vm.data_postpone.disabled.period    = false;
            vm.data_postpone.disabled.from_date = false;
            vm.data_postpone.disabled.to_date   = false;
            vm.data_postpone.year = new Date().getFullYear().toString();
            this.getPeriodPostPone(new Date().getFullYear().toString());
            vm.data_postpone.loading.postpone   = false;
            vm.data_postpone.loading.table      = false;
          }else{
            vm.data_postpone.disabled.year      = true;
            vm.data_postpone.disabled.period    = true;
            vm.data_postpone.disabled.from_date = true;
            vm.data_postpone.disabled.to_date   = true;
            vm.data_postpone.year               = '';
            vm.data_postpone.loading.postpone   = false;
            vm.data_postpone.loading.table      = false;
          }
        });
    },

    getPeriodPostPone: function (value) {
      var vm = this;
      let radioData = $('input[name="delivery_date"]:checked').val();
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table    = true;
      if(value){
        axios
        .get("/om/ajax/postpone-delivery/get-period-post-pone/" + value,{
            params: {
              days: radioData
            }
        })
        .then((res) => {
          if(res.data.data.length != 0){
            vm.data_postpone.periodList       = res.data.data
            vm.data_postpone.period           = res.data.data2[0].period_line_id;
            vm.data_postpone.from_date        = res.data.data3;
          }else{
            vm.data_postpone.periodList       = [];
            vm.data_postpone.period           = '';
            vm.data_postpone.from_date        = '';
            vm.data_postpone.loading.postpone = false;
            vm.data_postpone.loading.table    = false;
          }

          if(res.data.data4.length != 0){
            vm.data_list = [];
            res.data.data4.forEach(element => {
              vm.data_list.push({
                postpone_order_id:  element.postpone_order_id ? element.postpone_order_id : 0,
                customer_number:    element.customer_number ? element.customer_number : '',
                customer_name:      element.customer_name ? element.customer_name : '',
                year:               vm.data_postpone.year ? vm.data_postpone.year : '',
                installment:        vm.data_postpone.period ? vm.data_postpone.period : '',
                from_date:          vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
                to_date:            element.to_period_date ? element.to_period_date : '',
                budgetYear:         this.budgetYear,
                period:             vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
                fix:                true,
                old:                false,
                selected:           0,
              });
            });
            vm.data_postpone.loading.table    = false;
          }else{
            vm.data_list = [];
          }

          vm.data_postpone.loading.postpone = false;
        });
      }else{
        vm.data_postpone.period       = '';
        vm.data_postpone.periodList   = [];
        vm.data_postpone.from_date    = '';
      }      
    },

    applyData: function () {
      let vm            = this;
      vm.data_list      = [];
      vm.data_postpone.loading.table = true;

      if(vm.data_postpone.customers.length != 0){
        vm.data_postpone.customers.forEach(element => {
          vm.data_list.push({
            postpone_order_id:  element.postpone_order_id ? element.postpone_order_id : 0,
            customer_number:    element.customer_number ? element.customer_number : '',
            customer_name:      element.customer_name ? element.customer_name : '',
            year:               vm.data_postpone.year ? vm.data_postpone.year : '',
            installment:        vm.data_postpone.period ? vm.data_postpone.period : '',
            from_date:          vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
            to_date:            vm.data_postpone.to_date ? vm.data_postpone.to_date : '',
            budgetYear:         this.budgetYear,
            period:             vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
            fix:                true,
            old:                false,
            selected:           0,
          });
        });
      }

      vm.data_postpone.loading.table  = false;
    },

    async getValueFromDate (date) {
      let vm = this;
      vm.data_postpone.from_date = date;
      let dateFormat = date ? moment(date).format("DD/MM/YYYY") : '';
      vm.data_postpone.customers = [];
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table    = true;

      axios
      .get("/om/ajax/postpone-delivery/get-date-by-period-post-pone",{
          params: {
            days: dateFormat
          }
      })
      .then((res) => {
        if(res.data.data.length != 0){
          vm.data_postpone.period = res.data.data[0].period_line_id;
          vm.data_postpone.customers = res.data.data3;
          if(res.data.data2){
            $("#"+res.data.data2).prop("checked", true);
          }
        }        

        if(res.data.data4.length != 0){
          vm.data_list = [];
          res.data.data4.forEach(element => {
            vm.data_list.push({
              postpone_order_id:  element.postpone_order_id ? element.postpone_order_id : 0,
              customer_number:    element.customer_number ? element.customer_number : '',
              customer_name:      element.customer_name ? element.customer_name : '',
              year:               vm.data_postpone.year ? vm.data_postpone.year : '',
              installment:        vm.data_postpone.period ? vm.data_postpone.period : '',
              from_date:          vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
              to_date:            element.to_period_date ? element.to_period_date : '',
              budgetYear:         this.budgetYear,
              period:             vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
              fix:                true,
              old:                false,
              selected:           0,
            });
          });
          vm.data_postpone.loading.table    = false;
        }else{
          vm.data_list = [];
        }

        vm.data_postpone.loading.postpone = false;
        vm.data_postpone.loading.table    = false;
      });
    },

    getValueToDate (date) {
      let vm = this;
      vm.data_postpone.to_date = moment(date).format("DD/MM/YYYY");
    },

    clearDataPostPone: function () {
      var vm = this;

      vm.data_postpone.year                 = '';
      vm.data_postpone.period               = '';
      vm.data_postpone.from_date            = '';
      vm.data_postpone.to_date              = '';
      vm.data_postpone.periodList           = [];
      vm.data_postpone.customers            = [];

      vm.data_postpone.disabled.year        = true;
      vm.data_postpone.disabled.period      = true;
      vm.data_postpone.disabled.from_date   = true;
      vm.data_postpone.disabled.to_date     = true;

      vm.data_list                          = [];
    },

    checkboxAll(){
      let vm = this;
      let valueCheckbox = $("#checkboxAll").prop('checked');
      if(valueCheckbox){
        $('td input:checkbox').prop('checked', $("#checkboxAll").prop('checked'));

        vm.data_list.forEach(element => {
          element.selected = 1;
        });
      }else{
        $('td input:checkbox').prop('checked', false);

        vm.data_list.forEach(element => {
          element.selected = 0;
        });
      }
    },

    getPeriodPostPoneByDate(){
      let vm = this;
      let radioData = $('input[name="delivery_date"]:checked').val();
      vm.data_postpone.from_date = '';
      vm.data_postpone.to_date = '';
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table    = true;

      if(vm.data_postpone.period){
        axios
        .get("/om/ajax/postpone-delivery/get-period-post-pone-by-date",{
            params: {
              period: vm.data_postpone.period,
              days: radioData
            }
        })
        .then((res) => {
          if(res.data.data.length != 0){
            vm.data_postpone.from_date = res.data.data;
          }

          if(res.data.data2.length != 0){
            vm.data_list = [];
            res.data.data2.forEach(element => {
              vm.data_list.push({
                postpone_order_id:  element.postpone_order_id ? element.postpone_order_id : 0,
                customer_number:    element.customer_number ? element.customer_number : '',
                customer_name:      element.customer_name ? element.customer_name : '',
                year:               vm.data_postpone.year ? vm.data_postpone.year : '',
                installment:        vm.data_postpone.period ? vm.data_postpone.period : '',
                from_date:          vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
                to_date:            element.to_period_date ? element.to_period_date : '',
                budgetYear:         this.budgetYear,
                period:             vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
                fix:                true,
                old:                false,
                selected:           0,
              });
            });
            vm.data_postpone.loading.table    = false;
          }else{
            vm.data_list = [];
          }

          vm.data_postpone.loading.postpone = false;
          vm.data_postpone.loading.table    = false;
        });
      } 
    }

  },
};
</script>


<style scoped>
.btn-success {
  color: #fff !important;
  background-color: #1c84c6 !important;
  border-color: #1c84c6 !important;
}
</style>
