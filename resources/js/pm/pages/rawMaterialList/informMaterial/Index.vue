<template>
  <div class="col-lg-12">
    <div class="ibox">
      <div class="ibox-title">
        <div class="row align-items-center">
          <div class="col-sm-12 col-lg-12 align-middle">
            <h4 class="tw-text-lg tw-py-1">
              รายงานวัตถุดิบคงเหลือ : {{ item.name }}
            </h4>
          </div>
        </div>
      </div>
      <div class="ibox-content">
        <form @submit="handleSave">
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group row tw-items-center">
                <label class="col-lg-3 col-sm-5 col-form-label"></label>
                <div class="col-lg-9">
                  <img
                    class="image-box"
                    :src="
                      item.img
                        ? item.img
                        : '/images/no-image.png'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group row">
                <label class="col-lg-3 col-sm-5 col-form-label"
                  >หมายเลขเครื่อง <span style="color:red">*</span>:</label
                >
                <div class="col-lg-9">
                  <el-select
                    filterable
                    clearable
                    remote
                    id="select-box1"
                    required="true"
                    data-toggle="popover"
                    data-placement="bottom"
                    :data-content="validate.machine"
                    placeholder="หมายเลขเครื่อง"
                    @change="changeMachineSet"
                    @focus="popoverHide('select-box1')"
                    v-model="el.machine"
                  >
                    <el-option
                      v-for="(item, k) in machine_relations"
                      :key="k"
                      :label="item.machine_set"
                      :value="item.machine_set"
                    >
                    </el-option>
                  </el-select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group row">
                <label class="col-lg-3 col-sm-5 col-form-label"
                  >ตราบุหรี่ <span style="color:red">*</span>:</label
                >
                <div class="col-lg-9">
                  <el-select
                    filterable
                    clearable
                    remote
                    id="select-box2"
                    placeholder="หมายเลขเครื่อง"
                    data-toggle="popover"
                    data-placement="bottom"
                    :data-content="validate.ingredients"
                    @change="changeIngredients"
                    @focus="popoverHide('select-box2')"
                    v-model="el.ingredients"
                  >
                    <el-option
                      v-for="(item, k) in request_ingredients"
                      :key="k"
                      :label="item.item_desc"
                      :value="item.item_no"
                    >
                    </el-option>
                  </el-select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group row">
                <label class="col-lg-3 col-sm-5 col-form-label"
                  >จำนวนที่คงเหลือ <span style="color:red">*</span>:</label
                >
                <div class="col-lg-9" style="display:flex; gap:5px;
                justify-content: center;
    align-items: center;
    ">
                  <input
                  style="width: 211px;"
                    type="text"
                    required
                    class="form-control"
                    v-model="remaining_amount"
                  />
                  <el-select
                    filterable
                    clearable
                    remote
                    id="select-box2"
                    placeholder="หน่วยนับ"
                    data-toggle="popover"
                    data-placement="bottom"
                    :data-content="validate.uom"
                    @change="changeIngredients"
                    @focus="popoverHide('select-box2')"
                    v-model="el.uom"
                  >
                    <el-option
                      v-for="(item, k) in uom"
                      :key="k"
                      :label="item.uom"
                      :value="item.uom"
                    >
                    </el-option>
                  </el-select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group row">
                <label class="col-lg-3 col-sm-5 col-form-label"></label>
                <div class="col-lg-9">
                  <button type="submit" :class="btn_trans.save.class">
                    <i :class="btn_trans.save.icon"></i>
                    {{ btn_trans.save.text }}
                  </button>
                  <button
                    type="button"
                    @click="resetEl"
                    :class="btn_trans.cancel.class"
                  >
                    <i :class="btn_trans.cancel.icon"></i>
                    {{ btn_trans.cancel.text }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="true"></loading>
  </div>
</template>
<style scoped>
.image-box {
  max-width: 300px;
}
</style>
<style>
.style-chooser .vs__dropdown-menu {
  max-height: 150px;
}
</style>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: { Loading },
  props: {
    item: {},
    auth: {},
    url_ajax: null,
    btn_trans: { type: Object },
    machine_relations: {},
    request_ingredients: {},
    uom:{},
  },
  data() {
    return {
      machine: null,
      ingredients: null,
      remaining_amount: null,
      isLoading: true,
      fullPage: true,
      el: {
        machine: null,
        ingredients: null,
      },
      validate: {
        machine: null,
        ingredients: null,
      },
    };
  },
  mounted() {
    console.log(this);
    this.isLoading = false;
  },
  methods: {
    popoverHide(el) {
      setTimeout(() => {
        console.log($("#"+el).parents('.el-select').popover('hide'))
      }, 500);
    },
    async changeMachineSet($event) {
      this.machine = $event;
    },
    async changeIngredients($event) {
      this.ingredients = $event;
    },
    async resetEl() {
      this.el = {
        machine: null,
        ingredients: null,
      };
    },
    async handleSave(event) {
      event.preventDefault();
      if (this.el.ingredients == null) {
        this.validate.ingredients = "กรุณาเลือกข้อมูลตราบุหรี่";
        setTimeout(() => {
          $("#select-box2").parents('.el-select').popover('show')
        }, 200);
      } else {
        $("#select-box2").parents('.el-select').popover('hide')
        this.validate.ingredients = "";
      }
      if (this.el.machine == null) {
        this.validate.machine = "กรุณาเลือกข้อมูลหมายเลขเครื่อง";
        setTimeout(() => {
          $("#select-box1").parents('.el-select').popover('show')
        }, 200);
      } else {
        $("#select-box1").parents('.el-select').popover('hide')
        this.validate.machine = "";
      }
      if(this.el.machine == null || this.el.ingredients == null) {
        return false;
      }
      let url = this.url_ajax.raw_material_store;
      let params = {
        machine_set: this.el.machine,
        item_no: this.el.ingredients,
        record_type: "in",
        organization_id: this.item.organization_id,
        remaining_amount: this.remaining_amount,
        organization_code: this.item.organization_code,
        item_cat_code: this.item.item_cat_code,
        last_updated_by_id: this.auth.fnd_user_id,
        last_updated_by: this.auth.user_id,
        created_by: this.auth.user_id,
        created_by_id: this.auth.fnd_user_id,
      };
      this.isLoading = true;

      await axios
        .post(url, params)
        .then((result) => {
          swal("แจ้งเตือน", "ทำรายการสำเร็จ", "success");
          this.resetEl();
          setTimeout(() => {
            window.location.href = "/pm/raw_material_list";
          }, 500);
        })
        .catch((ex) => {
          swal("แจ้งเตือน", "กรุณาตรวจสอบข้อมูลใหม่อีกครั้ง", "error");
        });
      this.isLoading = false;
    },
  },
};
</script>