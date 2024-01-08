<template>
  <div style="font-size: 12px">
    <table class="table">
      <tr>
        <th>รหัสสินค้า</th>
        <th>รายละเอียดสินค้า</th>
        <th>จำนวน</th>
        <th>หน่วยนับ</th>
      </tr>
      <tr v-for="item in array" :key="item.id">
        <td>{{ item != null ? item.segment1 : "" }}</td>
        <td>{{ item != null ? item.description : "" }}</td>
        <td>
          {{ item != null ? changeQtyCalc(item.require_qty) : "" }}
        </td>
        <td>{{ exchangeUnit(item) }}</td>
      </tr>
    </table>
    <div class="row" style="align-items: center; margin-bottom: 5px"  v-if="isConfirm">
      <div class="col-md-6">วันที่ขอเบิก</div>
      <div class="col-md-6">
        <datepicker-th
          @dateWasSelected="selectDateTime"
          style="width: 100%"
          class="form-control md:tw-mb-0 tw-mb-2"
          :format="date_trans"
          placeholder="โปรดเลือกวันที่"
        />
      </div>
    </div>
    <div class="row" style="align-items: center; margin-bottom: 5px"  v-if="isConfirm">
      <div class="col-md-6">วันที่นำส่ง ยสท.</div>
      <div class="col-md-6">
        <datepicker-th
          @dateWasSelected="selectDateTime"
          style="width: 100%"
          class="form-control md:tw-mb-0 tw-mb-2"
          :format="date_trans"
          placeholder="โปรดเลือกวันที่"
        />
      </div>
    </div>
    <div style="display: flex; justify-content: center; margin-top: 5px" v-if="isConfirm">
      <button
        @click="closeModal"
        :class="btn_trans.search.class"
        style="margin-right: 5px"
      >
        ยกเลิก
      </button>
      <button @click="saveOrder" :class="btn_trans.createJob.class">
        ยืนยัน
      </button>
    </div>
  </div>
</template>
<style>
.style-chooser .vs__dropdown-toggle {
  height: 35px !important;
  border-radius: 2px !important;
  border-color: #cccccc8c !important;
}
</style>
<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import moment from "moment";
var numeral = require("numeral");

export default {
  props: {
    date_trans: {},
    reset_filter: {},
    getProductLists: {},
    isConfirm:{},
    array: {},
    item: { type: Object },
    auth: { type: Object },
    btn_trans: { type: Object },
    url_ajax: { type: Object },
  },
  data() {
    return {
      time1: "",
      time2: "",
      options: [],
      typeOrder: "",
    };
  },
  components: { DatePicker },
  mounted() {
    this.getTypeOrder();
  },
  methods: {
    exchangeUnit(item) {
      try {
        return item != null ? item.exchangeUnit.from_unit_of_measure : ''
      } catch (error) { }
    } ,
    async getTypeOrder() {
      await axios.post(this.url_ajax.getTypeOrder).then((result) => {
        this.options = result.data;
      });
    },
    resetPopUp() {
      console.log("reset filter");
      this.reset_filter();
    },
    closeModal() {
      $(".bd-search-modal-lg").modal("hide");
    },
    async saveOrder() {
      let params = [];
      _.each(this.array, (item) => {
        params.push({
          P_DATE_1: moment(this.time1).format('YYYY-MM-DD'),
          P_DATE_2: moment(this.time2).format('YYYY-MM-DD'),
          P_SOURCE_ID: item.inventory_item_id,
          P_LOCATION: this.auth.locator_code,
          P_USER_ID: this.auth.fnd_user_id,
          P_QTY: item.input_qty,
          P_UOM:  item.exchangeUnit.from_uom_code,
        });
      });
    
      await axios.post(this.url_ajax.productStore, params)
      .then((result) => {
        if (result.status == 200) {
          $(".bd-search-modal-lg").modal("hide");
          this.time1 = "";
          this.time2 = "";
          this.typeOrder = "";
          swal("Infomation", "ทำรายการเรียบร้อย", "success");
          this.resetPopUp();
        } else {
          swal("Warning", "ไม่สามารถทำรายการได้", "warning");
        }
      })
      .catch(ex => {
        swal('แจ้งเตือน!','ระบบไม่สามารถทำรายการได้', 'error')
      });
    },
    selectDateTime($date) {
      this.time1 = $date;
      this.time2 = $date;
    },

    changeQtyCalc(item) {
      console.log(parseFloat(item), "set item");
      return numeral(Math.ceil(parseFloat(item.replaceAll(",", "")))).format(
        "0,0"
      );
    },
  },
};
</script>