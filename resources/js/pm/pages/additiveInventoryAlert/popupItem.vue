<template>
  <div style="font-size: 12px">
    <table class="table">
      <tr>
        <th>รหัสสินค้า</th>
        <th>รายละเอียดสินค้า</th>
        <th>จำนวน</th>
        <th>หน่วยนับ</th>
      </tr>
      <tr>
        <td>{{ item != null ? item.segment1 : "" }}</td>
        <td>{{ item != null ? item.description : "" }}</td>
        <td>
          {{ item != null ? changeQtyCalc(item.require_qty) : "" }}
        </td>
        <td>
          {{ exchangeUnit }}
          </td>
      </tr>
    </table>
    <!-- <div class="row" style="align-items: center; margin-bottom: 5px">
      <div class="col-md-6">วันที่เริ่มผลิต</div>
      <div class="col-md-6">
        <datepicker-th
          @dateWasSelected="selectDateTime"
          style="width: 100%"
          class="form-control md:tw-mb-0 tw-mb-2"
          format="DD/MM/YYYY"
          placeholder="โปรดเลือกวันที่"
        />
      </div>
    </div> -->
    <!-- <div class="row" style="align-items: center">
      <div class="col-md-6">ประเภทคำสั่งผลิต1</div>
      <div class="col-md-6">
        <v-select class="style-chooser" v-model='typeOrder' :options="options" label="description" />
      </div>
    </div> -->
    <div style="display:flex;justify-content: center;margin-top:5px;" v-if="isConfirm">
      <button @click="closeModal" :class="btn_trans.search.class" style="margin-right:5px">ยกเลิก</button>
      <button @click="saveOrder"  :class="btn_trans.createJob.class" >ยืนยัน</button>
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
var numeral = require("numeral");

export default {
  props: {
    reset_filter: {},
    getProductLists: {},
    item: { type: Object },
    auth: { type: Object },
    btn_trans: { type: Object },
    url_ajax: { type: Object },
    select_uom: {},
    isConfirm:{}
  },
  data() {
    return {
      time1: "",
      options: [],
      typeOrder: ''
    };
  },
  components: { DatePicker },
  mounted() {
    this.getTypeOrder();
  },
  computed : {
    exchangeUnit() {
      try {
        return this.item != null ? this.item.exchangeUnit.from_unit_of_measure : ''
      } catch (error) { }
    }
  },
  methods: {
    async getTypeOrder() {
      await axios.post(this.url_ajax.getTypeOrder).then((result) => {
        this.options = result.data;
      });
    },
    resetPopUp() {
      console.log('reset filter')
      this.reset_filter()
    },
    closeModal() {
      $(".bd-search-modal-lg").modal("hide")
    },
    async saveOrder() {
      
      let params = {
        // P_DATE: this.time1,
        P_SOURCE_ID: this.item.inventory_item_id,
        // P_TYPE : this.typeOrder.lookup_code,
        P_LOCATION: this.auth.locator_code,
        P_USER_ID : this.auth.fnd_user_id,
        P_QTY  : this.item.input_qty,
        P_UOM  : this.item.exchangeUnit.from_uom_code,
      };
      await axios.post(this.url_ajax.productStore, params).then((result) => {
        if (result.status == 200) {
          $(".bd-search-modal-lg").modal("hide");
          this.time1=  ""
          this.typeOrder=  ""
          swal("Infomation", "ทำรายการเรียบร้อย", "success");
          this.resetPopUp()
        } else {
          swal("Warning", "ไม่สามารถทำรายการได้", "warning");
        }
      }).catch(ex => {
        swal('แจ้งเตือน!','ระบบไม่สามารถทำรายการได้', 'error')
      });
    },
    selectDateTime($date) {
      this.time1 = $date;
    },
    changeQtyCalc(item) {
        console.log(typeof item, 'set item')
        let num = typeof item == 'string' ? item.replaceAll(',', '') : item;
      return numeral(Math.ceil(parseFloat(num))).format("0,0");
    },
  },
};
</script>