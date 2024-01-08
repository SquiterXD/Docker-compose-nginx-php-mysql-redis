<template>
  <form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm">
    <input type="hidden" name="_token" :value="csrf" />
    <input type="hidden" name="_method" value="PUT" v-if="this.defaultValue" />
    <div>
      <div class="container">
        <div class="row">
          <div class="col">
            <label> ประเภทวัตถุดิบ <span class="text-danger">*</span></label>
            <input
              type="hidden"
              name="item_cat_code"
              :value="item_cat_code"
              autocomplete="off"
            />
            <el-select
              v-model="item_cat_code"
              filterable
              remote
              reserve-keyword
              clearable
              class="w-100"
              @change="getItemData()"
            >
              <el-option
                v-for="group in itemGroups"
                :key="group.item_cat_code"
                :label="group.item_cat_segment2_desc"
                :value="group.item_cat_code"
              >
              </el-option>
            </el-select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <label> จำนวนพัสดุต่อพื้นที่ <span class="text-danger">*</span></label>
            <el-input
              name="max_qty"
              @focus="numbericFocus"
              @blur="numbericBlur"
              v-model="max_qty"
              @input="onlyNumeric()"
            ></el-input>
          </div>
          <div class="col">
            <label> หน่วยนับ <span class="text-danger">*</span></label>
            <el-input
              name="uom_description"
              v-model="uom_description"
              disabled
            ></el-input>
            <input type="hidden" name="uom_code" :value="uom_code" />
            <!-- <input type="hidden" name="uom_code"  :value="uom_code" autocomplete="off">
                    <el-select  v-model="uom_code"
                                    :remote-method="getUom"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" >              
                        <el-option  v-for="uom in uomLists"   
                                    :key="uom.uom_code"
                                    :label="uom.unit_of_measure"
                                    :value="uom.uom_code">
                        </el-option>
                    </el-select> -->
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label> สถานะการใช้งาน </label>
            <div>
              <input type="checkbox" name="enable_flag" v-model="enable_flag" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr />
    <div class="row mt-3 text-right">
      <div class="col-sm-12">
        <button class="btn btn-sm btn-primary" type="submit">
          <i class="fa fa-save"></i> บันทึก
        </button>
        <a :href="this.urlReset" type="button" class="btn btn-sm btn-warning">
          <i class="fa fa-times"></i> ยกเลิก
        </a>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  props: ["old", "defaultValue", "itemGroups", "urlSave", "urlReset"],
  data() {
    return {
      item_cat_code: this.old.item_cat_code
        ? this.old.item_cat_code
        : this.defaultValue
        ? this.defaultValue.item_cat_code
        : "",
      max_qty: this.old.max_qty
        ? this.old.max_qty
        : this.defaultValue
        ? this.defaultValue.max_qty
        : "",
      // uom_code:      this.old.uom_code      ? this.old.uom_code      : this.defaultValue ? this.defaultValue.uom_code : '',
      enable_flag: this.old.enable_flag
        ? this.old.enable_flag
          ? true
          : false
        : this.defaultValue
        ? this.defaultValue.enable_flag == "Y"
          ? true
          : false
        : true,

      // item_cat_code: '',
      // max_qty:       '',
      uom_code: "",
      uom_description: "",

      uomLists: [],
      // uomLoading: true,

      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    };
  },
  mounted() {
    if (this.item_cat_code) {
      this.getItemData();
    }
    this.numbericBlur();
    // this.getUom();

    // this.uom_code  = this.old.uom_code ? this.old.uom_code : this.defaultValue ? this.defaultValue.uom_code : '';
  },
  methods: {
    numbericFocus() {
      this.max_qty = this.max_qty.replaceAll(",", "");
    },

    numbericBlur() {
      this.max_qty = this.max_qty.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },

    onlyNumeric() {
      this.max_qty = this.max_qty.replace(/[^0-9]/g, "");
    },
    async getUom(query) {
      // this.uomLoading = true;

      this.uomLists = [];

      axios
        .get("/pm/ajax/max-storage/get-uom", {
          params: {
            query: query,
          },
        })
        .then((res) => {
          this.uomLists = res.data;
          // this.uomLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async checkForm(e) {
      var form = $("#submitForm");
      let inputs = form.serialize();
      this.errors = [];

      if (!this.item_cat_code) {
        this.errors.push("ประเภทวัตถุดิบ");
        swal({
          title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
          text: this.errors,
          timer: 3000,
          type: "error",
          showCancelButton: false,
          showConfirmButton: false,
        });
      }

      if (!this.max_qty) {
        this.errors.push("จำนวนพัสดุต่อพื้นที่");
        swal({
          title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
          text: this.errors,
          timer: 3000,
          type: "error",
          showCancelButton: false,
          showConfirmButton: false,
        });
      }

      if (!this.uom_code) {
        this.errors.push("หน่วยนับ");
        swal({
          title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
          text: this.errors,
          timer: 3000,
          type: "error",
          showCancelButton: false,
          showConfirmButton: false,
        });
      }
      Vue.set(this, 'max_qty', this.max_qty.replaceAll(',',''))
      if (!this.errors.length) {
        form.submit();
      }

      e.preventDefault();
    },
    getItemData() {
      this.uom_description = "";
      this.uom_code = "";

      if (this.item_cat_code) {
        axios
          .get("/pm/ajax/max-storage/get-uom", {
            params: {
              item_cat_code: this.item_cat_code,
            },
          })
          .then((res) => {
            let uom = res.data;
            this.uom_description = uom.unit_of_measure;
            this.uom_code = uom.uom_code;
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
  },
};
</script>
