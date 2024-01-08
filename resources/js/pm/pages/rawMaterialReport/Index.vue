<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <!-- <div class="ibox-title">
            <div class="row align-items-center">
              <div class="col-sm-12 col-lg-4 align-middle">
                <h4>แจ้งเตือนปริมาณคงคลังสารปรุง</h4>
              </div>
            </div>
          </div> -->
          <div class="ibox-content">
            <div class="row">
              <div class="col-md-2">วันที่</div>
              <div class="col-md-3">
                <datepicker-th
                  @dateWasSelected="selectDateTime"
                  style="width: 100%"
                  :value="nowDate"
                  class="form-control md:tw-mb-0 tw-mb-2"
                  :format="date_trans"
                  placeholder="โปรดเลือกวันที่"
                />
              </div>
              <div class="col-md-3">
                <datepicker-th
                  @dateWasSelected="selectDateTime2"
                  :value="nowDate"
                  style="width: 100%"
                  class="form-control md:tw-mb-0 tw-mb-2"
                  :format="date_trans"
                  placeholder="โปรดเลือกวันที่"
                />
              </div>
            </div>
            <div class="row" style="align-items: center; margin-top: 5px">
              <div class="col-md-2">ประเภทวัตถุดิบ</div>
              <div class="col-md-3">
                <v-select
                  v-model="el.item_cat"
                  :options="item_cat"
                  label="item_cat_segment2_desc"
                ></v-select>
              </div>
            </div>
            <div
              class="row"
              style="align-items: center; margin-bottom: 15px; margin-top: 5px"
            >
              <div class="col-md-2">หมายเลขเครื่อง</div>
              <div class="col-md-3">
                <v-select
                  v-model="el.machine_relations"
                  :options="machine_relations"
                  label="machine_set"
                  :items="items"
                ></v-select>
              </div>
            </div>
            <div class="row" style="align-items: center; margin-bottom: 15px">
              <button
                @click="handleFilterBtn"
                type="button"
                :class="btn_trans.create.class"
              >
                <i :class="btn_trans.search.icon"></i>
                ค้นหา
              </button>
              &nbsp;
              <button
                @click="resetPopUp"
                type="button"
                :class="btn_trans.reset.class"
              >
                <i :class="btn_trans.reset.icon"></i>
                {{ btn_trans.reset.text }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <div class="row align-items-center">
              <div class="col-sm-12 col-lg-4 align-middle">
                <h4>รายการร้องขอวัตถุดิบ</h4>
              </div>
            </div>
          </div>
          <div class="ibox-content table-responsive">
            <table class="table table-bordered">
              <thead>
                <!-- <tr align="center">
                  <th colspan="5">กระบวนการ : การมวนบุหรี่</th>
                </tr> -->
                <tr align="center">
                  <th style="min-width: 311px">ประเภทวัตถุดิบ</th>
                  <th style="min-width: 150px">หมายเลขเครื่อง</th>
                  <th style="min-width: 150px">ตราบุหรี่</th>
                  <th style="min-width: 150px">วันที่</th>
                  <th style="min-width: 150px">เวลา</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in items"
                  :key="item.ptpm_raw_mtl_id"
                  :class="item.flag == 0 ? 'tw-bg-red-50' : 'tw-bg-green-50'"
                >
                  <td class="col-readonly">
                    {{ item.item_cat }}
                    <a v-if="item.flag == 0" href="#" @click="confirmOrder(item)"
                      ><small>ยืนยัน</small>
                    </a>
                  </td>
                  <td class="col-readonly" align="center">
                    {{ item.machine_set }}
                  </td>
                  <td class="col-readonly" align="center">
                    {{ item.ingradiant }}
                  </td>
                  <td class="col-readonly" align="center">{{ item.date }}</td>
                  <td class="col-readonly" align="center">{{ item.time }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
var numeral = require("numeral");
import moment from "moment";
import axios from "axios";

export default {
  props: {
    date_trans: {},
    reset_filter: {},
    getProductLists: {},
    item: { type: Object },
    auth: { type: Object },
    btn_trans: { type: Object },
    url_ajax: { type: Object },
    machine_relations: {},
    item_cat: {},
  },

  data() {
    return {
      time1: moment().add(543, "years").format(),
      time2: moment().add(543, "years").format(),
      el: {
        machine_relations: {},
        item_cat: {},
      },
      options: [],
      typeOrder: "",
      items: [],
    };
  },
  components: { DatePicker },
  computed: {
    nowDate: function () {
      return moment().add(543, "years").format(this.date_trans);
    },
  },
  mounted() {
    console.log(this.date_trans)
    // this.getTypeOrder();
    this.initialize();
  },
  methods: {
    async getTypeOrder() {
      await axios.post(this.url_ajax.getTypeOrder).then((result) => {
        this.options = result.data;
      });
    },
    async confirmOrder(item) {
      swal(
        {
          title: "แจ้งเตือน",
          text: "ต้องการทำการยืนยันข้อมูลหรือไม่?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "ยืนยัน",
        },
        (e) => {
          // confirm upload
          if (e) {
            console.log(item);
            axios
              .post(this.url_ajax.raw_material_report_update_flag, item)
              .then((result) => result.data)
              .then((result) => {
                console.log(result);
              })
              .catch((ex) => {});
            this.initialize();
          }
        }
      );
    },
    async initialize() {
      let filter = {
        auth: this.auth,
        machine_relations: this.el.machine_relations,
        item_cat: this.el.item_cat,
        time1: this.time1,
        time2: this.time2,
      };

      let url = this.url_ajax.raw_material_report_index;
      await axios
        .post(url, filter)
        .then((result) => result.data)
        .then((result) => {
          this.items = result.data;
        });
    },
    resetPopUp() {
      this.el = {
        machine_relations: {},
        item_cat: {},
      };
      this.time1 = moment().add(543, "years").format();
      this.time2 = moment().add(543, "years").format();
      this.initialize();
    },
    closeModal() {
      $(".bd-search-modal-lg").modal("hide");
    },
    handleFilterBtn() {
      this.initialize();
    },
    selectDateTime($date) {
      this.time1 = moment($date).format();
    },
    selectDateTime2($date) {
      this.time2 = moment($date).format();
    },
    changeQtyCalc(item) {
      return numeral(Math.ceil(parseFloat(item))).format("0,0");
    },
  },
};
</script>