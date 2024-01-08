<template>
  <div class="container" v-loading="loading">  
    <div class="form-group row">
      <label class="col-md-2 col-form-label">วันที่สร้างเอกสาร</label>
      <div class="col-md-4">
        <el-date-picker
          v-model="transaction_date"
          type="date"
          placeholder="Pick a day"
          format="dd/MM/yyyy"
          size="small"
          :disabled="true"
        >
        </el-date-picker>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label required">วันที่เติมน้ำมัน</label>
      <div class="col-md-4">
        <el-date-picker
          v-model="gl_date"
          type="date"
          format="dd/MM/yyyy"
          size="small"
          placeholder="Pick a day"
        >
        </el-date-picker>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label required">ทะเบียนรถ</label>
      <div class="col-md-4">
        <el-select
          v-model="car_license_plate"
          filterable
          remote
          :debounce="2000"
          :remote-method="getCarInfos"
          placeholder="ทะเบียนรถ"
          :loading="loadingInput.carInfos"
          style="width: 100%"
        >
          <el-option
            v-for="(item, index) in carInfos"
            :key="index"
            :label="item.car_license_plate"
            :value="item.car_license_plate"
          >
          </el-option>
        </el-select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">เลขที่เอกสาร</label>
      <div class="col-md-4">
        <el-input
          :disabled="true"
          placeholder="เลขที่เอกสารจะถูกสร้างหลังการบันทึกโดยอัตโนมัติ"
          v-model="document_number"
          disable
        >
        </el-input>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">รหัสสินทรัพย์</label>
      <div class="col-md-10">
        <input
          type="text"
          readonly
          class="form-control-plaintext"
          :value="selectedCar.asset_number || ''"
        />
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">รายละเอียด</label>
      <div class="col-md-10">
        <input
          type="text"
          readonly
          class="form-control-plaintext"
          id="staticCarDesc"
          :value="selectedCar.car_description || ''"
        />
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">ยี่ห้อรถ</label>
      <div class="col-md-10">
        <input
          type="text"
          readonly
          class="form-control-plaintext"
          id="staticBrandDesc"
          :value="selectedCar.car_brand_desc || ''"
        />
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">ชนิดน้ำมันที่เติม</label>
      <div class="col-md-10">
        <input
          type="text"
          readonly
          class="form-control-plaintext"
          id="staticItemDesc"
          :value="selectedCar.item_description || ''"
        />
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">หน่วยงานเจ้าของรถ</label>
      <div class="col-md-4">
        <input
          type="text"
          readonly
          class="form-control-plaintext"
          id="staticOwner"
          v-if="selectedCar.default_dept_code"
          :value="`${selectedCar.default_dept_code} - ${selectedCar.department.description}` || ''" 
        />
      </div>
    </div>
    <div class="form-group row" hidden>
      <label class="col-md-2 col-form-label">ชื่อผู้ใช้รถ</label>
      <div class="col-md-4">
        <el-input :disabled="true" size="small" v-model="car_user"></el-input>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">ประเภท</label>
      <div class="col-md-4">
        <el-input
          :disabled="true"
          size="small"
          :value="selectedCar.car_group_desc || ''"
        ></el-input>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label required">รหัสบัญชี</label>
      <div class="col-md-4">
        <el-select
          v-model="gl_alias_name"
          filterable
          remote
          :debounce="2000"
          :remote-method="getAliasName"
          placeholder="รหัสบัญชี"
          style="width: 100%"
          :loading="loadingInput.aliasName"
        >
          <el-option
            v-for="(item, index) in aLiasNames"
            :key="index"
            :label="`${item.alias_name} - ${item.description}`"
            :value="item.alias_name"
          >
          </el-option>
        </el-select>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-4 offset-md-2">
        {{ this.acc_segment }}
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-md-2 col-form-label">จำนวนโควต้าทั้งหมด</label>
          <div class="col-md-2">
            <el-input
              :disabled="true"
              size="small"
              v-model="quota_per_month"
            ></el-input>
          </div>
          <label class="col-md-2 col-form-label">ลิตร</label>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label">จำนวนโควต้าคงเหลือ</label>
          <div class="col-md-2">
            <el-input
              :disabled="true"
              size="small"
              v-model="quota_balance"
            ></el-input>
          </div>
          <label class="col-md-2 col-form-label">ลิตร</label>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label required">จำนวนที่เติม</label>
          <div class="col-md-2">
            <el-input
              size="small"
              type="number"
              min="1"
              step="0.01"
              v-model="transaction_quantity"
              placeholder="จำนวนที่เติม"
            ></el-input>
          </div>
          <label class="col-md-2 col-form-label">ลิตร</label>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label required">Subinventory</label>
          <div class="col-md-4">
            <el-select
              v-model="subinventory_code"
              filterable
              remote
              :debounce="2000"
              :remote-method="getSecondaryInventory"
              :loading="loadingInput.subinventory"
              placeholder="คลังสินค้าย่อย"
              style="width: 100%"
            >
              <el-option
                v-for="(item, index) in subinventories"
                :key="index"
                :label="`${item.secondary_inventory_name} - ${item.description}`"
                :value="item.secondary_inventory_name"
                size="small"
              >
              </el-option>
            </el-select>
          </div>
          <label class="col-md-2 col-form-label">
            {{ this.subinventory_desc }}
          </label>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label required">Locator</label>
          <div class="col-md-4">
            <el-select
              v-model="inventory_location_id"
              filterable
              placeholder="ตำแหน่ง"
              style="width: 100%"
            >
              <el-option
                v-for="(item, index) in itemLocationOptions"
                :key="index"
                :label="`${item.segment1}.${item.segment2} - ${item.description}`"
                :value="item.inventory_location_id"
                size="small"
              >
              </el-option>
            </el-select>
          </div>
          <label class="col-md-2 col-form-label">
            {{ this.locator_desc }}
          </label>
        </div>
      </div>

      <div class="col-md-6 card m-3">
        <div class="card-body">
          <div class="form-group">
            <h3>ประมาณการ</h3>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label">ราคาต่อลิตร</label>
            <div class="col-md-4 pl-0">
              <el-input
                :disabled="true"
                size="small"
                :value="price_per_liter"
              ></el-input>
            </div>
            <label class="col-md-4 col-form-label">บาท</label>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label">รวมเงิน</label>
            <div class="col-md-4 pl-0">
              <el-input
                :disabled="true"
                size="small"
                :value="totalAmount.toFixed(2)"
              ></el-input>
            </div>
            <label class="col-md-4 col-form-label">บาท</label>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label">ภาษีมูลค่าเพิ่ม</label>
            <div class="col-md-4 pl-0">
              <el-input 
                :disabled="true" 
                size="small" 
                :value="taxAmount.toFixed(2)">
              </el-input>
            </div>
            <label class="col-md-4 col-form-label">บาท</label>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label">รวมเงินทั้งสิ้น</label>
            <div class="col-md-4 pl-0">
              <el-input
                :disabled="true"
                size="small"
                :value="grandTotalAmount.toFixed(2)"
              ></el-input>
            </div>
            <label class="col-md-4 col-form-label">บาท</label>
          </div>
        </div>
      </div>
      
      
    </div>

    <div class="col-md-12 text-right mt-4 px-0">
      <el-button 
        type="success"
        class="btn-success" 
        @click="store()"
        :disabled="!valid"
        >ยืนยัน</el-button
      >
      <el-button
        class="text-refresh"
        type="text"
        @click.native.prevent="refresh()"
        >ล้างข้อมูล</el-button
      >
    </div>
  </div>
</template>

<style scoped>
.btn-success {
  background-color: #1ab394;
  border-color: #1ab394;
  color: white;
}
.btn-cancle {
  background-color: #ec4958;
  border-color: #ec4958;
  color: white;
}
.text-refresh {
  color: #ec4958;
}
.el-notification__content p {
    margin: 0;
    font-size: 12px;
}
</style>

<script>
import moment from "moment";
import BigNumber from "bignumber.js";

export default {
  props: ["webFuelOils"],
  data() {
    return {
      subinventories: [],
      locators: [],
      locatorCodes: [],
      carInfos: [],
      glCodeCombinations: [],
      aLiasNames: [],
      itemLocationOptions: [],
      selectedCar: {},

      transaction_date: moment(),
      gl_date: moment().format(),
      car_license_plate: "",
      car_user: "",
      user_car_type: "",
      gl_alias_name: "",
      account_code: "",
      quota_per_month: "",
      quota_balance: "",
      transaction_quantity: "",
      subinventory_code: "",
      subinventory_desc: "",
      inventory_location_id: "",
      locator_desc: "",
      document_number: "",
      organization_id: "",
      price_per_liter: "",

      loadingInput: {
        carInfos: false,
        aliasName: false,
        subinventories: false,
        itemLocations: false,
      },

      loading: false,
    };
  },

  watch: {
    gl_date: function(val) {
      this.gl_date = moment(val).format();
    },

    car_license_plate: function (val) {
      this.selectedCar = this.carInfos.find((c) => { return c.car_license_plate == val });
      let quotaBalance = this.selectedCar.quota_per_month - this.selectedCar.quota_balance.total
      if (quotaBalance <= 0) {
        this.loading = false;
        this.selectedCar = [];
        this.quota_per_month = "";
        this.quota_balance = "";
        this.$notify({
          title: 'Warning',
          message: 'น้ำมันคงเหลือไม่พอ (คงเหลือ '+ quotaBalance +' ลิตร)',
          type: 'warning',
          duration: 2000,
        });
        return
      } 
      this.car_user = this.selectedCar.car_user;
      this.user_car_type = this.selectedCar.user_car_type;
      this.quota_per_month = this.selectedCar.quota_per_month;
      this.selectedCar = this.selectedCar;
      this.quota_balance = quotaBalance;
      this.gl_alias_name = this.selectedCar.aliasName.alias_name;
      this.organization_id = this.selectedCar.organization_id;
      this.price_per_liter = parseFloat(this.selectedCar.fuel_price.material_cost).toFixed(2);
    },

    subinventory_code: function (val) {
      this.inventory_location_id = "";
      for (let index = 0; index < this.subinventories.length; index++) {
        if (this.subinventories[index]["subinventory_code"] === val) {
          this.subinventory_desc = this.subinventories[index][
            "subinventory_desc"
          ];
        }
      }

      this.itemLocationOptions =
        this.subinventories.find((s) => {
          return s.secondary_inventory_name == val;
        }).item_locations || [];

      this.inventory_location_id = this.itemLocationOptions[0].inventory_location_id;
    },
  },

  created: function () {
    this.getMasterData();
  },

  methods: {
    getMasterData() {
      this.getCarInfos(this.car_license_plate);
      this.getAliasName(this.gl_alias_name);
      this.getSecondaryInventory(this.subinventory_code);
      this.getGlCodeCombination();
    },
    
    getCarInfos(query) {
      this.loadingInput.carInfos = true;
      axios
        .get("/inv/ajax/car_info", {
          params: { text: query, organization_code: "A32" },
        })
        .then((response) => {
          this.carInfos = response.data;
        })
        .catch((err) => {
          console.log("error get car info");
        })
        .then(() => {
          this.loadingInput.carInfos = false;
        });
    },

    getAliasName(query) {
      this.loadingInput.aliasName = true;
      axios
        .get("/inv/ajax/alias_name", { params: { text: query, prefix: "T21" } })
        .then((response) => {
          this.aLiasNames = response.data;
        })
        .catch((err) => {
          console.log("error get alias name");
        })
        .then(() => {
          this.loadingInput.aliasName = false;
        });
    },
    getSecondaryInventory(query) {
      this.loadingInput.subinventories = true;
      axios
        .get("/inv/ajax/secondary_inventories", { params: { text: query, attribute2: 'Yes' } })
        .then((response) => {
          this.subinventories = response.data;
          this.subinventory_code = 'PURROJ24';
        })
        .catch((err) => {
          console.log("error get secondary Iinventory");
        })
        .then(() => {
          this.loadingInput.subinventories = false;
        });
    },
    getGlCodeCombination() {
        this.loadingInput.glCodeCombinations = true;
        axios
          .get("/inv/ajax/gl_code_combinations")
          .then((response) => {
              this.glCodeCombinations = response.data;
          })
          .catch((err) => {
              console.log("error get glCodeCombinations")
          })
          .then(() => {
              this.loadingInput.glCodeCombinations = false;
          });
    },

    refresh() {
      window.location.replace("/inv/disbursement_fuel/create");
    },

    cancle() {
      window.location.reload();
    },

    store() {
      if (confirm("ยืนยันการเบิกจ่ายน้ำมัน ?")) {
        this.loading = true;

        if (this.transaction_quantity <= 0) {
          this.$notify({
            title: 'Warning',
            message: 'จำนวนน้ำมันที่เติมต้องมากกว่า 0 ลิตร',
            type: 'warning'
          });
          this.loading = false;
          return
        }

        if (this.transaction_quantity > this.quota_balance) {
          this.$notify({
            title: 'Warning',
            message: 'ไม่สามารถเบิกน้ำมันเกินโควต้าได้',
            type: 'warning'
          });
          this.loading = false;
          return
        }

        let existingWebFuelOil = this.webFuelOils.find((val) => {
          let glDateValue = moment(val.gl_date).format('DD/MM/YYYY')
          let glDate = moment(this.gl_date).format('DD/MM/YYYY')

          return val.car_infos?.asset_id === this.selectedCar?.asset_id 
            && glDateValue === glDate
            && val.transaction_quantity === this.transaction_quantity
        });

        let locator = this.itemLocationOptions.find((s) => {
          return s.inventory_location_id = this.inventory_location_id
        });
        locator = locator.segment1 + '.' + locator.segment2

        if(existingWebFuelOil) {
          if (confirm("ทะเบียนที่เลือกมีการเบิกจ่ายน้ำมันในวันนี้แล้ว ต้องการทำรายการต่อหรือไม่ ?")) {
            axios
              .post("/inv/disbursement_fuel", {
                asset_number: this.selectedCar.asset_number,
                gl_alias_name: this.gl_alias_name,
                transaction_quantity: this.transaction_quantity,
                gl_date: this.gl_date,
                subinventory_code: this.subinventory_code,
                inventory_location_id: this.inventory_location_id,
                transaction_date: this.transaction_date,
                document_number: this.document_number,
                locator: locator,
                organization_id: this.organization_id,
                car_license_plate: this.car_license_plate,
              })
              .then((res) => {
                this.$notify({
                  title: 'Success',
                  message: 'Successfully',
                  type: 'success'
                });
                window.location.replace("/inv/disbursement_fuel/create");
              })
              .catch((err) => {
                this.loading = false;
                if (err.response.status == 403) {
                    this.$notify.error({
                    title: 'Error',
                    message: err.response.data.msg,
                    duration: 4500,
                    });
                } else {
                  let errorMessage = this.$formatErrorMessage(err);
                  this.$notify.error({
                    title: 'Error',
                    dangerouslyUseHTMLString: true,
                    message: errorMessage.outerHTML,
                    duration: 0,
                    });
                }
              });
          } else {
            this.loading = false;
          }
        }

        if (!existingWebFuelOil) {
          axios
            .post("/inv/disbursement_fuel", {
              asset_number: this.selectedCar.asset_number,
              gl_alias_name: this.gl_alias_name,
              transaction_quantity: this.transaction_quantity,
              gl_date: this.gl_date,
              subinventory_code: this.subinventory_code,
              inventory_location_id: this.inventory_location_id,
              transaction_date: this.transaction_date,
              document_number: this.document_number,
              locator: locator,
              organization_id: this.organization_id,
              car_license_plate: this.car_license_plate,
            })
            .then((res) => {
              this.$notify({
                title: 'Success',
                message: 'Successfully',
                type: 'success'
              });
              window.location.replace("/inv/disbursement_fuel/create");
            })
            .catch((err) => {
              this.loading = false;
              if (err.response.status == 403) {
                if (err.response.data.error) {
                  this.$notify.error({
                  title: 'Error',
                  message: err.response.data.error,
                  duration: 4500,
                  });
                } else {
                  this.$notify.error({
                  title: 'Error',
                  message: err.response.data.msg,
                  duration: 4500,
                  });
                }
                
              } else {
                let errorMessage = this.$formatErrorMessage(err);
                this.$notify.error({
                  title: 'Error',
                  dangerouslyUseHTMLString: true,
                  message: errorMessage.outerHTML,
                  duration: 0,
                  });
              }

              
            });
        }  
      }
    }
  },

  computed: {
    displayCarGroup: function () {
      if (this.selectedCar) {
        return `${this.selectedCar.car_group} ${this.selectedCar.car_description}`;
      }
    },

    totalAmount: function () {
      let fuelPrice = new BigNumber(
        this.selectedCar?.fuel_price?.material_cost || 0
      );

      return fuelPrice.multipliedBy(this.transaction_quantity || 0).toNumber();
    },

    taxAmount: function () {
      return (new BigNumber(this.totalAmount * 7 / 100)).toNumber();
    },
    grandTotalAmount: function () {
      return this.totalAmount  + this.taxAmount
    },

    acc_segment: function () {
      if (!this.selectedCar) {
        return;
      }

      let selectedAliasName = this.aLiasNames.find((a) => {
        return a.alias_name == this.gl_alias_name;
      })?.template || '';

      if (!selectedAliasName) {
          return
      }

      let coas = selectedAliasName.split(".");
      coas[2] = this.selectedCar.default_dept_code;
      let coaCombine = coas.join(".")

      let selectedGlCodeCombination = this.glCodeCombinations.find((g) => {
        return g.concatenated_segments === coaCombine
      });
      
      if (!selectedGlCodeCombination) {
        this.getCarInfos();
        this.selectedCar = [];
        this.gl_alias_name = "";
        this.quota_per_month = "";
        this.quota_balance = "";

        return alert("ไม่สามารถเพิ่มรายการได้เนื่องจากไม่มีเลขทางบัญชีนี้ในระบบ กรุณาติดต่อฝ่ายบัญชี")
      }

      return coaCombine;
    },
    valid() {
      let valid =
        (this.quota_balance <= 0) ||
        (this.acc_segment === '') ||
        (this.transaction_quantity === '') ;
      return !valid;
    },
  },
};
</script>
