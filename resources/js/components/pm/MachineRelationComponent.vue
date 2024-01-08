<template>
  <form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm">
    <input type="hidden" name="_token" :value="csrf" />
    <div v-if="this.defaultValue">
      <input type="hidden" name="_method" value="PUT" />
    </div>
    <div>
      <div class="container">
        <div class="row">
          <!-- <div class="col-md-4">
                    <label> ขั้นตอนการทำงานของ <span class="text-danger">*</span></label>
                    <el-input name="routing_no" v-model="routing_no" maxlength="9" :disabled="this.disableEdit"></el-input>
                </div> -->
          <div class="col">
            <label> กลุ่มชุดเครื่องจักร <span class="text-danger">*</span></label>
            <input
              type="hidden"
              name="machine_group"
              :value="machine_group"
              autocomplete="off"
            />
            <el-select
              v-model="machine_group"
              filterable
              remote
              reserve-keyword
              clearable
              class="w-100"
            >
              <el-option
                v-for="group in machineGroups"
                :key="group.lookup_code"
                :label="group.meaning"
                :value="group.lookup_code"
              >
              </el-option>
            </el-select>
          </div>
          <div class="col">
            <label> เซ็ตเครื่องจักร <span class="text-danger">*</span></label>
            <el-input
              name="machine_set"
              v-model="machine_set"
              @input="onlyNumeric()"
            ></el-input>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <label> รหัสเครื่องจักร <span class="text-danger">*</span></label>
            <input
              type="hidden"
              name="machine_name"
              :value="machine_name"
              autocomplete="off"
            />
            <el-select
              v-model="machine_name"
              :remote-method="getAsset"
              filterable
              remote
              reserve-keyword
              clearable
              class="w-100"
              @change="getData()"
            >
              <el-option
                v-for="asset in assetList"
                :key="asset.asset_number"
                :label="asset.asset_number + ' : ' + asset.asset_description"
                :value="asset.asset_number"
              >
              </el-option>
            </el-select>
          </div>
          <div class="col">
            <label> ประเภทเครื่องจักร </label>
            <el-input name="machine_type" v-model="machine_type" disabled></el-input>
          </div>
        </div>
        <div class="row mt-3">
          <!-- <div class="col-md-4">
                    <label> คำอธิบาย </label>
                    <el-input name="machine_description" v-model="machine_description" disabled></el-input>
                </div> -->

          <!-- <div class="col-md-4">
                    <label> ลำดับขั้นตอน </label>
                    <el-input name="step_num" v-model="step_num" disabled></el-input>
                </div> -->
          <div class="col">
            <label> ขั้นตอนการทำงาน </label>
            <el-input
              name="step_description"
              v-model="step_description"
              disabled
            ></el-input>
          </div>

          <div class="col">
            <!-- <label> ความเร็วเครื่องจักร (หน่วยขั้นตอน/นาที) </label> -->
            <label> ความเร็วเครื่องจักร ({{ machine_speed_unit }}) </label>
            <el-input name="machine_speed" v-model="machine_speed" disabled></el-input>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <label> % ประสิทธิภาพของ EAM </label>
            <el-input
              name="machine_eamperformance"
              v-model="machine_eamperformance"
              disabled
            ></el-input>
          </div>
          <div class="col">
            <label> สถานะการใช้งาน </label>
            <div>
              <input type="checkbox" name="pm_enable_flag" v-model="pm_enable_flag" />
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="row mt-2">
                <div class="col-md-4">
                    <label> วันที่เริ่มต้นการใช้งาน </label>
                    <el-input name="start_date" v-model="start_date" disabled></el-input>
                </div>
                <div class="col-md-4">
                    <label> วันที่สิ้นสุดการใช้งาน </label>
                    <el-date-picker 
                        v-model="end_date"
                        style="width: 100%;"
                        type="date"
                        placeholder="วันที่สิ้นสุดการใช้งาน"
                        name="end_date"
                        format="dd-MM-yyyy"
                        >
                    </el-date-picker> 
                </div>
            </div> -->
    </div>
    <div class="col-12 mt-3">
      <hr />
      <div class="row clearfix m-t-lg text-right">
        <div class="col-sm-12">
          <button class="btn btn-sm btn-primary" type="submit">
            <i class="fa fa-save"></i> บันทึก
          </button>
          <a :href="this.urlReset" type="button" class="btn btn-sm btn-warning">
            <i class="fa fa-times"></i> ยกเลิก
          </a>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import moment from "moment";
export default {
  props: [
    "machineGroups",
    "assets",
    "defaultValue",
    "old",
    "organizationCode",
    "org",
    "urlSave",
    "urlReset",
  ],

  data() {
    return {
      // organization_id:        this.old ? this.old.organization_id : this.defaultValue ? this.defaultValue.organization_id : '',
      // machine_group_desc:     '',
      machine_group: this.old.machine_group
        ? this.old.machine_group
        : this.defaultValue
        ? this.defaultValue.machine_group
        : "",
      machine_set: this.old.machine_set
        ? this.old.machine_set
        : this.defaultValue
        ? this.defaultValue.machine_set
        : "",
      machine_name: this.old.machine_name
        ? this.old.machine_name
        : this.defaultValue
        ? this.defaultValue.machine_name
        : "",

      // pm_enable_flag:         this.old ? this.old.pm_enable_flag == 'Y' ? true : false : this.defaultValue ? this.defaultValue.pm_enable_flag == 'Y' ? true : false : true,
      pm_enable_flag: this.old.pm_enable_flag
        ? this.old.pm_enable_flag
          ? true
          : false
        : this.defaultValue
        ? this.defaultValue.pm_enable_flag == "Y"
          ? true
          : false
        : true,
      // start_date:             moment(String(Date())).format('DD-MM-yyyy'),
      // end_date:               '',

      //ดึงจาก asset
      machine_description: "",
      machine_type: "",
      step_num: "",
      step_description: "",
      machine_speed: "",
      machine_eamperformance: "",
      machine_speed_unit: "",

      //
      assetList: [],

      organization_code: this.organizationCode,

      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      loading: false,
      machine_relation_id: this.defaultValue ? this.defaultValue.machine_relation_id : "",
    };
  },
  mounted() {
    if (this.machine_name) {
      this.getAsset(this.machine_name);
    } else {
      this.getAsset();
    }

    (this.machine_description = this.defaultValue
      ? this.defaultValue.machine_description
      : ""),
      (this.machine_type = this.defaultValue
        ? this.defaultValue.machine_type.description
        : ""),
      (this.step_num = this.defaultValue ? this.defaultValue.step_num : ""),
      (this.step_description = this.defaultValue
        ? this.defaultValue.step_description
        : ""),
      (this.machine_speed = this.defaultValue
        ? this.defaultValue.machine_speed.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        : ""),
      (this.machine_eamperformance = this.defaultValue
        ? this.defaultValue.machine_eamperformance
        : ""),
      (this.machine_speed_unit = this.defaultValue
        ? this.defaultValue.machine_speed_unit
        : ""),
      console.log("organizationCode <--> " + this.organizationCode);
    console.log("org <--> " + this.org);
  },
  methods: {
    onlyNumeric() {
      this.machine_set = this.machine_set.replace(/[^0-9 .]/g, "");
    },
    async getAsset(query) {
      this.wip_uom = "";

      this.assetList = [];

      axios
        .get("/pm/ajax/get-asset", {
          params: {
            query: query,
          },
          beforeSend: function (xhr) {
            $("#_content_transaction").html(
              '\
                        <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>'
            );
          },
        })
        .then((res) => {
          this.assetList = res.data;

          // if (this.machine_name) {
          //     if (this.assetList.length > 0) {
          //         this.getData();
          //     }
          // }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getData() {
      this.machine_description = "";
      this.machine_type = "";
      this.step_num = "";
      this.step_description = "";
      this.machine_speed = "";
      this.machine_eamperformance = "";
      this.machine_speed_unit = "";

      if (this.machine_name) {
        this.selected = this.assetList.find((data) => {
          return data.asset_number == this.machine_name;
        });

        if (this.selected) {
          this.machine_description = this.selected.asset_description;
          this.machine_type = this.selected.machine_type_desc;
          this.step_num = this.selected.wip_step;
          this.step_description = this.selected.wip_step_desc;
          this.machine_speed = this.selected.machine_speed;
          this.machine_eamperformance = this.selected.performance_percent;
          this.machine_speed_unit = this.selected.machine_speed_unit;
        }
      }
    },
    async checkForm(e) {
      var form = $("#submitForm");
      var vm = this;

      axios
        .get("/pm/ajax/validate-asset", {
          params: {
            machine_name: this.machine_name,
            pm_enable_flag: this.pm_enable_flag,
            machine_relation_id: this.machine_relation_id,
          },
        })
        .then((res) => {
          if (res.data.data.status == "Y") {
            swal(
              {
                title: "Warning",
                text:
                  "มีข้อมูลเครื่องจักรนี้ เปิดใช้งานอยู่แล้ว ต้องการยืนยันเปิดใช้งานข้อมูลนี้แทนหรือไม่?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
              },
              function (isConfirm) {
                if (isConfirm) {
                  form.submit();
                } else {
                  e.preventDefault();

                  swal({
                    title: "มีข้อผิดพลาด",
                    text: "",
                    timer: 3000,
                    type: "success",
                    showCancelButton: false,
                    showConfirmButton: false,
                  });
                }
              }
            );
          } else if (res.data.data.status == "N") {
            form.submit();
          }
          e.preventDefault();
        });
    },
  },
};
</script>
