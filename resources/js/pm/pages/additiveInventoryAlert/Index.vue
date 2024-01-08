<template>
  <div>
    <div class="row d-flex justify-content-end mb-3">
      <div class="col-lg-10">
        <div class="float-right">
          <button
            type="button"
            :class="btn_trans.reset.class"
            @click="resetFilter"
          >
            <i :class="btn_trans.reset.icon"></i>
            {{ btn_trans.reset.text }}
          </button>
          <button
            type="button"
            :class="btn_trans.search.class"
            @click="getProductLists"
          >
            <i :class="btn_trans.search.icon"></i>
            แสดงข้อมูล
          </button>
          <button
            type="button"
            :class="btn_trans.createJob.class"
            @click.prevent="confirm"
          >
            <i :class="btn_trans.createJob.icon"></i>
            {{ btn_trans.createJob.text }}
          </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <div class="row align-items-center">
              <div class="col-sm-12 col-lg-4 align-middle">
                <h4>แจ้งเตือนปริมาณคงคลังสารปรุง</h4>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div class="row">
              <div class="col-lg-6 col-sm-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >รหัสสินค้าสำเร็จรูป:</label
                  >
                  <div class="col-lg-9">
                    <v-select
                      @search="fetchOptions"
                      v-model="prodSelect.prodId"
                      :options="prodsId"
                      :reduce="(item) => item.label"
                      label="label"
                      @option:selected="changeLabel"
                    />
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >รายละเอียด:</label
                  >
                  <div class="col-lg-9">
                    <input
                      disabled
                      v-model="prodSelect.desc"
                      type="text"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >คลังจัดเก็บ/สถานที่จัดเก็บ:</label
                  >
                  <div class="col-lg-9">
                    <el-select filterable v-model="prodSelect.storeAs">
                      <el-option
                        :value="item.concatenated_segments"
                        v-for="(item) in on_hand_notices"
                        :key="item.concatenated_segments"
                        :label="item.concatenated_segments"
                        />
                    </el-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 tw-hidden" >
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >คลังจัดเก็บ:</label
                  >
                  <div class="col-lg-9">
                    <input
                      type="text"
                      class="form-control"
                      disabled="true"
                      value="RESBKK01 : ฝ่ายวิจัย กรุงเทพฯ โกดังที่ 1"
                    />
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12  tw-hidden"  >
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >สถานที่จัดเก็บ:</label
                  >
                  <div class="col-lg-9">
                    <input
                      type="text"
                      class="form-control"
                      disabled="true"
                      value="ZONE02 : สารปรุง"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="ibox">
          <div class="ibox-content">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr align="center">
                    <th>
                      <div class="check-center"></div>
                    </th>
                    <th style="min-width: 150px">รหัสสินค้าสำเร็จรูป</th>
                    <th style="min-width: 250px">รายละเอียด</th>
                    <th style="min-width: 100px">คงคลัง</th>
                    <th style="min-width: 100px">ค่าเฝ้าระวังต่ำสุด</th>
                    <th style="min-width: 100px">ค่าเฝ้าระวังสูงสุด</th>
                    <th style="min-width: 100px;display:none">จำนวนที่ต้องผลิต</th>
                    <th style="min-width: 100px;display:none">หน่วยนับ</th>
                    <th style="min-width: 100px">จำนวนที่ผลิต</th>
                    <th style="width: 200px">หน่วยนับ</th>
                    <th style="min-width: 150px">เลขคำสั่งผลิต</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in data" :key="index">
                    <td>
                      <div class="check-center">
                        <label class="label-input">
                          <input
                            class="align-middle checkbox-id"
                            :disabled="checkHasReportNum(item.report_num)"
                            type="checkbox"
                            :value="index"
                            @change="changeSelectId"
                          />
                        </label>
                      </div>
                    </td>
                    <td class="col-readonly">{{ item.segment1 }}</td>
                    <td class="col-readonly">{{ item.description }}</td>
                    <td class="col-readonly tw-text-right">
                      {{ item.transaction_quantity | formatNumber }}
                    </td>
                    <td class="col-readonly tw-text-right">
                      {{ item.min_qty | formatNumber }}
                    </td>
                    <td class="col-readonly tw-text-right">
                      {{ item.max_qty | formatNumber }}
                    </td>
                    <td style="display:none">
                      <label class="label-input col-lg-12 pl-0 pr-0">
                        <input
                          type="text"
                          class="form-control input-field tw-text-right"
                          :value="calcQty2(item) | formatNumber"
                          readonly="true"
                          @input="(value) => (item.qty2 = value)"
                        />
                      </label>
                    </td>
                    <td style="display:none" class="col-readonly">
                      {{ item.uom_v != null ? item.uom_v.unit_of_measure : '' }}
                    </td>
                    <td>
                      <input v-if="item.report_num != null"
                        type="text"
                        class="form-control input-field  tw-text-right"
                        :disabled="checkHasReportNum(item.report_num)"
                        :value="item.qty2 | formatNumber"
                        :data-index="index"
                        @input="inputAmount"
                        @keyup="exchangeUnit(index)"
                      />
                      <input v-if="item.report_num == null"
                        type="text"
                        class="form-control input-field  tw-text-right"
                        :disabled="checkHasReportNum(item.report_num)"
                        :data-index="index"
                        v-model="data[index].input_qty"
                        @input="inputAmount"
                        @keyup="exchangeUnit(index)"
                      />
                    </td>
                    <td>
                      <v-select
                        v-if="!checkHasReportNum(item.report_num)"
                        v-model="data[index].exchangeUnit"
                        :options="item.uom_master"
                        :data-index="index"
                        :disabled="
                          checkHasReportNum(item.report_num) !== null
                            ? true
                            : false
                        "
                        @option:selected="exchangeUnit(index)"
                        @input="exchangeRate($event, index)"
                        label="from_unit_of_measure"
                      />
                      <v-select
                        :value="item.uom_v.unit_of_measure"
                        v-if="checkHasReportNum(item.report_num)"
                        :options="[{from_unit_of_measure: item.uom_v.unit_of_measure}]"
                        :disabled="true"
                        label="from_unit_of_measure"
                      />
                      <!-- <div v-if="checkHasReportNum(item.report_num)">
                      {{ item.uom_v != null ? item.uom_v.unit_of_measure : '' }}
                      </div> -->
                    </td>
                    <td class="col-readonly text-center">
                        <!-- <a @click="showModal(index)">{{ item.report_num }}</a> -->
                        <a v-if="item.report_num" :href="item.url_pm_production_order">{{ item.report_num }}</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--        modal search-->
    <div
      class="modal fade bd-search-modal-lg"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3>เปิดคำสั่งผลิต</h3>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="swal" class="hidden">
              <popup-item
                :reset_filter="resetFilter"
                :getProductLists="getProductLists"
                :auth="auth"
                :btn_trans="btn_trans"
                :url_ajax="url_ajax"
                :isConfirm="isConfirm"
                :item="(isConfirm ? data[selectedIndex] : data[selectedIndexView])"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="true"></loading>
  </div>
</template>
<script>
import axios from "axios";
import vSelect from "vue-select";
import popUp from "./popupItem.vue";
import popupItem from "./popupItem.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0[.]00");
});

Vue.component("v-select", vSelect);
Vue.component("pop-up", popUp);

export default {
  components: { popupItem, Loading },
  props: {
    btn_trans: { type: Object },
    url_ajax: { type: Object },
    auth: { type: Object },
    on_hand_notices: { type: Object },
  },
  data() {
    return {
      isLoading: true,
      fullPage: true,
      prodsId: [],
      data: [],
      selectedIndex: null,
      selectedIndexView: null,
      exchangeRateData: [],
      amount: [],
      isConfirm: true,
      prodSelect: {
        prodId: "",
        desc: "",
      },
    };
  },
  watch: {
    amount: function (newValue) {
      let _this = this;
      _.forEach(this.amount, function (value, key) {
        _this.amount[key] = numeral(value).format("0,0[.]00");
      });
    },
  },
  mounted() {
    this.getMaster();
    this.fetchOptions();
    console.log(this.auth);
  },
  computed: {},
  methods: {
    calcQty2(item) {
      if (item.qty != null) {
        return item.qty;
      } else {
        return item.require_qty;
      }
    },
    showModal(id) {
        this.selectedIndexView = id;
        this.confirm(false);
    },
    onCancel() {
      console.log("User cancelled the loader.");
    },
    exchangeRate(e, index) {
      let value = e.conversion_rate;
      this.exchangeRateData[index] = value;
    },
    inputAmount(e) {
      let value = e.target.value;
      let index = e.target.getAttribute("data-index");
      this.amount[index] = numeral(value).format("0,0[.]00");
      e.target.value = numeral(value).format("0,0[.]00");
    },
    changeSelectId(e) {
      $(".checkbox-id").prop("checked", false);
      $(e.target).prop("checked", true);
      if (e.target.checked) {
        this.selectedIndex = e.target.value;
      } else {
        this.selectedIndex = null;
      }
    },
    async fetchOptions(search, loading) {
      this.getProdListsId(search);
    },
    checkHasReportNum(i) {
      return i;
      if (i != "") {
        return false;
      } else {
        return true;
      }
    },
    exchangeUnit(index) {
      try {
        let num = typeof this.exchangeRateData[index] == 'string' ? this.exchangeRateData[index].replaceAll(',', '') : this.exchangeRateData[index];
        let rate = _.toNumber(
          parseFloat(num)
        );
        let amounts = typeof this.amount[index] == 'string' ? this.amount[index].replaceAll(',', '') : this.amount[index];
        let amount = _.toNumber(
          parseFloat(amounts)
        );
        let calc = rate * amount;
        if (!isNaN(calc)) {
          this.data[index].require_qty = numeral(calc).format("0,0[.]00");
          this.data[index].require_qty_calc = numeral(calc).format("0,0[.]00");
          // let vals = parseInt(unit.replace(',','')) * parseInt(amount.replace(',',''));
          // this.data[index].require_qty_calc = numeral(vals).format("0,0[.]00");
        }
      } catch (error) {
        console.log(error);
      }
    },
    async getMaster() {
      console.log("init item master");
      // this.getProdListsId();
      this.getProductLists();
    },
    async getProdListsId(filter = null) {
      this.isLoading = true;
      console.log(this.isLoading, " this.isLoading");
      let ajaxUrl = this.url_ajax.selectProductId;
      let filters = {
        organization_code: this.auth.organization_code,
        subinventory_code: this.auth.subinventory_code,
        locator_code: this.auth.locator_code,
      };
      if (filter != null) {
        filters = { ...filters, ...{ q: filter } };
      }
      await axios
        .post(ajaxUrl, { filters })
        .then((result) => {
          if (result.status === 200) {
            this.prodsId = result.data;
            _.forEach(this.data, o => {
              o.exchangeUnit = _.find(o.uom_master, {from_uom_code: o.primary_uom_code})
            })
          }
        })
        .catch((err) => {
          console.log(err);
        });
      this.isLoading = false;
    },
    async resetFilter() {
      this.prodSelect.prodId = "";
      this.prodSelect.desc = "";
      this.prodSelect.storeAs = "";
      this.data = [];
      this.selectedIndex = null;
      console.log("reset filter");
      await this.getProductLists();
    },
    async getProductLists() {
      this.isLoading = true;

      let ajaxUrl = this.url_ajax.productLists;
      let filter = {
        organization_code: this.auth.organization_code,
        subinventory_code: this.auth.subinventory_code,
        locator_code: this.auth.locator_code,
        concatenated_segments: this.prodSelect.storeAs,
      };

      this.data = [];

      if (this.prodSelect.prodId != "") {
        filter = { ...filter, ...{ segment1: this.prodSelect.prodId } };
      }
      console.log(filter, "filter");
      await axios
        .post(ajaxUrl, filter)
        .then((result) => {
          if (result.status === 200) {
            this.data = result.data;
          }
        })
        .catch((err) => {
          console.log(err);
        });
      this.isLoading = false;
    },
    async changeLabel() {
      let label = this.prodSelect.prodId.split(" : ");
      this.prodSelect.prodId = label[0];
      this.prodSelect.desc = label[1];
    },
    async confirmLot() {
      let item = this.data[this.selectedIndex];
      let params = {
        inventory_item_id: item.inventory_item_id,
        lot_number: item.lot_number,
        require_qty: item.require_qty_calc,
        location: item.concatenated_segments,
        date: item.concatenated_segments,
        item_type: item.item_type,
        auth: this.auth.fnd_user_id,
      };

      await axios.post(this.url_ajax.productStore, params).then((result) => {
        if (result.status == 200) {
          swal("Infomation", "ทำรายการเรียบร้อย", "success");
          this.getProductLists();
        } else {
          swal("Warning", "ไม่สามารถทำรายการได้", "warning");
        }
      });
    },

    confirm(isConfirm = true) {
      if (this.selectedIndex == null && isConfirm === true) {
        return false;
      }
      this.isConfirm = isConfirm
      $(".bd-search-modal-lg").modal("show");
      return false;
      let item = this.data[this.selectedIndex];
      if (this.selectedIndex == null) {
        return false;
      }
      swal(
        {
          html: true,
          title: "เปิดคำสั่งผลิต",
          text:
            "<table class='table' style='font-size:12px'><tr><th>รหัสสินค้า</th><th>รายละเอียดสินค้า</th><th>จำนวน</th><th>หน่วยนับ</th></tr>" +
            "<tr><td>" +
            item.segment1 +
            "</td><td>" +
            item.description +
            // "</td><td>" +

            // numeral(Math.ceil(parseInt(item.require_qty_calc.replaceAll(',','')))).format("0,0")  +
            "</td><td>" +
            item.uom_v.description +
            "</td></tr></table>",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#1ab394",
          cancelButtonColor: "#ED5565",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ยกเลิก",
          reverseButtons: true,
        },
        (isConfirm) => {
          if (isConfirm) {
            this.confirmLot();
          }
        }
      );
      document.querySelector(".sweet-alert .lead ").innerHTML =
        document.querySelector("#swal").innerHTML;
    },
  },
};
</script>

<style scoped>
.vs__dropdown-toggle {
  height: 35px !important;
  border-radius: 2px !important;
  border-color: #cccccc8c !important;
}
.el-select {
  width: 100%;
}
table .el-input__inner {
  border: none !important;
}
th,
td {
  vertical-align: middle !important;
}

th.header {
  text-align: center;
}

.col-readonly {
  background: #e9ecef42 !important;
}

.check-center {
  text-align: center;
}

input.form-control.input-field {
  border: 0px;
}

input.form-control.input-field:focus {
  outline: 1px solid #1ab394;
}
</style>
