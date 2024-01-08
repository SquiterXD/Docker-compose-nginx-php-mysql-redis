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
            {{ btn_trans.search.text }}
          </button>
          <button
            type="button"
            :class="btn_trans.createJob.class"
            @click.prevent="confirm"
          >
            <i :class="btn_trans.createJob.icon"></i>
            เบิกวัตถุดิบ
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
                <h4>แจ้งเตือนปริมาณคงคลังวัตถุดิบ</h4>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div class="row">
              <div class="col-lg-6 col-sm-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >รหัสวัตถุดิบ:</label
                  >
                  <div class="col-lg-9">
                    <v-select
                      v-model="prodSelect.prodId"
                      :options="prodsId"
                      @search="fetchOptions"
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
                      v-model="prodSelect.desc"
                      disabled
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
              <div class="col-lg-6 col-sm-12 tw-hidden">
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
              <div class="col-lg-6 col-sm-12 tw-hidden">
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-4 col-form-label"
                    >สถานที่จัดเก็บ:</label
                  >
                  <div class="col-lg-9">
                    <input
                      type="text"
                      class="form-control"
                      disabled="true"
                      value="ZONE01 : วัตถุดิบ"
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
                      <div class="check-center">
                        <label class="label-input">
                          <input
                            class="align-middle"
                            type="checkbox"
                            value=""
                            @change="changeSelectedAll"
                          />
                        </label>
                      </div>
                    </th>
                    <th style="min-width: 150px">รหัสวัตถุดิบ</th>
                    <th style="min-width: 250px">รายละเอียด</th>
                    <th style="min-width: 70px">คงคลัง</th>
                    <th style="min-width: 130px">ค่าเฝ้าระวังต่ำสุด</th>
                    <th style="min-width: 130px">ค่าเฝ้าระวังสูงสุด</th>
                    <th style="min-width: 100px" class="tw-hidden">
                      ปริมาณเบิก
                    </th>
                    <th style="min-width: 100px" class="tw-hidden">หน่วยนับ</th>
                    <th style="min-width: 100px">ปริมาณเบิก</th>
                    <th style="min-width: 100px">หน่วยนับ</th>
                    <th style="min-width: 150px">ใบเบิกวัตถุดิบ</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in data" :key="index">
                    <td>
                      <div class="check-center">
                        <label class="label-input">
                          <input
                            class="align-middle"
                            type="checkbox"
                            :disabled="checkHasReportNum(item.report_num)"
                            :value="index"
                            v-model="selected[index]"
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
                    <td class="tw-hidden">
                      <label class="label-input col-lg-12 pl-0 pr-0">
                        <input
                          type="text"
                          class="form-control input-field"
                          :value="item.require_qty | formatNumber"
                          readonly="true"
                          @input="(value) => item.require_qty"
                        />
                      </label>
                    </td>
                    <td class="col-readonly tw-hidden">
                      {{
                        item.uom_v_p != null ? item.uom_v_p.unit_of_measure : ""
                      }}
                    </td>
                    <td>
                      <!-- <input
                        type="text"
                        class="form-control input-field"
                        :disabled="checkHasReportNum(item.report_num)"
                        :value="
                          item.report_num != null
                            ? item.qty2
                            : amount[index] | formatNumber
                        "
                        :data-index="index"
                        @input="inputAmount"
                        @keyup="exchangeUnit(index)"
                      /> -->
                      <input
                        v-if="item.report_num != null"
                        type="text"
                        class="form-control input-field tw-text-right"
                        :disabled="checkHasReportNum(item.report_num)"
                        :value="item.qty2 | formatNumber"
                        :data-index="index"
                        @input="inputAmount"
                        @keyup="exchangeUnit(index)"
                      />
                      <input
                        v-if="item.report_num == null"
                        type="text"
                        class="form-control input-field tw-text-right"
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
                        :options="[
                          { from_unit_of_measure: item.uom_v.unit_of_measure },
                        ]"
                        :disabled="true"
                        label="from_unit_of_measure"
                      />
                    </td>
                    <td class="col-readonly">
                      <a @click="showModal(item)">{{ item.report_num }}</a>
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
            <h3>เบิกวัตถุดิบ</h3>
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
                :date_trans="date_trans"
                :reset_filter="resetFilter"
                :getProductLists="getProductLists"
                :auth="auth"
                :btn_trans="btn_trans"
                :url_ajax="url_ajax"
                :isConfirm="isConfirm"
                :array="isConfirm ? array : arrayView"
                :item="
                  isConfirm ? data[selectedIndex] : data[selectedIndexView]
                "
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
var numeral = require("numeral");
import axios from "axios";
import vSelect from "vue-select";
import popUp from "./popupItem.vue";
import popupItem from "./popupItem.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

Vue.component("v-select", vSelect);
Vue.component("pop-up", popUp);
Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0[.]00"); // displaying other groupings/separators is possible, look at the docs
});
export default {
  components: { popupItem, Loading },
  props: {
    date_trans: {},
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
      selectedIndex: [],
      selectedIndexView: [],
      exchangeRateData: [],
      selected: [],
      array: [],
      arrayView: [],
      amount: [],
      isConfirm: true,
      prodSelect: {
        prodId: "",
        desc: "",
        storeAs: "",
      },
    };
  },
  mounted() {
    this.getMaster();
    this.fetchOptions();
    console.log(this.on_hand_notices, "1111");
  },

  computed: {},
  methods: {
    showModal(item) {
      this.arrayView = [];
      this.arrayView.push(item);
      console.log(this.isConfirm ? this.array : this.arrayView);
      this.confirm(false);
    },
    inputAmount(e) {
      let value = e.target.value;
      let index = e.target.getAttribute("data-index");
      this.amount[index] = numeral(value).format("0,0[.]00");
      e.target.value = numeral(value).format("0,0[.]00");
    },
    changeSelectedAll(e) {
      let item = this.data;
      this.selectedIndex = [];
      this.selected = [];
      if (e.target.checked) {
        for (let index = 0; index < item.length; index++) {
          if (item[index].report_num != null) {
            this.selected.push(false);
          } else {
            this.selected.push(true);
            this.selectedIndex.push(index);
          }
        }
      } else {
        for (let index = 0; index < item.length; index++) {
          this.selected.push(false);
        }
      }
    },
    changeSelectId(e) {
      if (e.target.checked) {
        this.selectedIndex.push(e.target.value);
      } else {
        this.selectedIndex = this.selectedIndex.filter((item) => {
          return item.toString() != e.target.value;
        });
      }
    },
    checkHasReportNum(i) {
      return i;
    },
    exchangeRate(e, index) {
      let value = e.conversion_rate;
      this.exchangeRateData[index] = value;
    },
    exchangeUnit(index) {
      try {
        let rate = _.toNumber(this.exchangeRateData[index].replaceAll(",", ""));
        let amount = _.toNumber(this.amount[index].replaceAll(",", ""));
        let calc = rate * amount;

        if (!isNaN(calc)) {
          this.data[index].require_qty = numeral(calc).format("0,0[.]00");
          this.data[index].require_qty_calc = numeral(calc).format("0,0[.]00");
        }
      } catch (error) {}
    },
    async getMaster() {
      console.log("init item master");
      // this.getProdListsId();
      this.getProductLists();
    },
    async fetchOptions(search, loading) {
      this.getProdListsId(search);
    },
    async getProdListsId(filter = null) {
      let ajaxUrl = this.url_ajax.selectProductId;
      let filters = {
        organization_code: this.auth.organization_code,
        subinventory_code: this.auth.subinventory_code,
        locator_code: this.auth.locator_code,
      };
      if (filter != null) {
        filters = { ...filters, ...{ q: filter } };
      }
      this.isLoading = true;
      await axios
        .post(ajaxUrl, { filters })
        .then((result) => {
          if (result.status === 200) {
            // this.data = [];
            this.prodsId = result.data;
          }
        })
        .catch((err) => {});
      this.isLoading = false;
    },
    async resetFilter() {
      this.prodSelect.prodId = "";
      this.prodSelect.desc = "";
      this.prodSelect.storeAs = "";
      this.selected = [];
      this.selectedIndex = [];
      this.data = [];
      console.log("reset filter");
      await this.getProductLists();
    },
    async getProductLists() {
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

      // if (this.prodSelect.prodId != "") {
      //   filter = { segment1: this.prodSelect.prodId };
      // }
      this.isLoading = true;

      await axios
        .post(ajaxUrl, filter)
        .then((result) => {
          if (result.status === 200) {
            this.data = result.data;
            _.forEach(this.data, (o) => {
              o.exchangeUnit = _.find(o.uom_master, {
                from_uom_code: o.primary_uom_code,
              });
            });
          }
        })
        .catch((err) => {});
      this.isLoading = false;
    },
    async changeLabel() {
      let label = this.prodSelect.prodId.split(" : ");

      this.prodSelect.prodId = label[0];
      this.prodSelect.desc = label[1];
    },
    async confirmLot() {
      let selectItem = this.selectedIndex;
      let items = [];

      for (let index = 0; index < selectItem.length; index++) {
        items.push(this.data[selectItem[index]]);
      }
      this.isLoading = true;

      await axios.post(this.url_ajax.productStore, items).then((result) => {
        if (result.status == 200) {
          let report_num = result.data.result;
          swal("Infomation", "ทำรายการเรียบร้อย", "success");
          this.getProductLists();
        } else {
          swal("Warning", "ไม่สามารถทำรายการได้", "warning");
        }
      });
      this.isLoading = false;
    },
    confirm(isConfirm = true) {
      this.isConfirm = isConfirm;
      let selectItem = this.selectedIndex;
      let rows = "";
      if (this.selectedIndex.length == 0 && isConfirm === true) {
        return false;
      }
      this.array = [];
      for (let index = 0; index < selectItem.length; index++) {
        this.array.push(this.data[selectItem[index]]);
      }
      $(".bd-search-modal-lg").modal("show");
      return false;

      swal(
        {
          html: true,
          title: "เบิกวัตถุดิบ",
          text:
            "<table class='table' style='font-size:12px'><tr><th>รหัสสินค้า</th><th>รายละเอียด</th><th>จำนวน</th><th>หน่วยนับ</th></tr>" +
            rows +
            "</table>",
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
    },
  },
};
</script>

<style scoped>
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
