<template>
  <div>
    <label>ค้นหา</label>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">ระหว่างวันที่:</label>
      <div class="col-md-2">
        <el-date-picker
          v-model="searchForm.from_date"
          type="date"
          format="dd/MM/yyyy"
          placeholder="Pick a day"
        >
        </el-date-picker>
      </div>
      <label class="col-form-label">ถึง</label>
      <div class="col ml-3">
        <el-date-picker
          v-model="searchForm.to_date"
          type="date"
          format="dd/MM/yyyy"
          placeholder="Pick a day"
        >
        </el-date-picker>
      </div>
    </div>

    <div class="form-group row">
      <label for="" class="col-2 col-form-label">ค้นหาตามหน่วยงาน</label>
      <div class="col-md-6">
        <el-select
          v-model="searchForm.default_dept_code"
          filterable
          remote
          :debounce="2000"
          :remote-method="getCOAs"
          placeholder="หน่วยงานผู้ขอเบิก"
          :loading="loadingInput.coaDeptCode"
          style="width: 100%"
        >
          <el-option
            v-for="item in coaDeptCodes"
            :key="item.department_code"
            :label="`${item.department_code} ${item.description}`"
            :value="item.department_code"
          >
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="form-group row">
      <label for="" class="col-2 col-form-label">ค้นหาตามคลังสินค้าย่อย</label>
      <div class="col-md-6">
        <el-select
          
          filterable
          remote
          :debounce="2000"
          placeholder="คลังสินค้าย่อย"
          style="width: 100%"
        >
          <el-option
          >
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="form-group row">
      <label for="" class="col-2 col-form-label">ค้นหาตามประเภทน้ำมัน</label>
      <div class="col-md-6">
        <el-select
          
          filterable
          remote
          :debounce="2000"
          placeholder="ประเภทน้ำมัน"
          style="width: 100%"
        >
          <el-option
          >
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="form-group row">
      <label for="" class="col-2 col-form-label">ค้นหาตามทะเบียนรถ</label>
      <div class="col-md-6">
        <el-select
          v-model="searchForm.car_license_plate"
          filterable
          remote
          :debounce="2000"
          :remote-method="getCarInfos"
          placeholder="ทะเบียนรถ"
          :loading="loadingInput.carInfos"
          style="width: 100%"
          :clearable="true"
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

    <div class="offset-2 form-group row p-0">
      <div id="searchData" class="">
        <el-button class="btn-success" type="primary" @click="getWebFuel()"
          >ค้นหา</el-button
        >
      </div>
      <div id="clearData" class="ml-3">
        <el-button class="text-refresh" type="text" @click.prevent="refresh()"
          >ล้างข้อมูล</el-button
        >
      </div>
      <!-- <div id="allLists" class="mr-3 ml-auto">
        <el-button class="btn-success" type="primary">รายการทั้งหมด</el-button>
      </div> -->
    </div>

    <div class="col-md-12 mt-5 p-0">
      <el-table border :data="tableData" style="width: 100%">
        <el-table-column prop="transaction_date" label="วันที่" align="center">
        </el-table-column>
        <el-table-column
          prop="car_license_plate"
          label="ทะเบียนรถที่นำมาเติม"
          width="180"
          align="center"
        ></el-table-column>
        <el-table-column
          prop="car_group_desc"
          label="ประเภทรถ"
          align="center"
        ></el-table-column>
        <el-table-column
          prop="default_dept_code"
          label="หน่วยงานของเจ้าของรถ"
          width="180"
          align="center"
        ></el-table-column>
        <el-table-column
          prop="car_user"
          label="หน่วยงานที่ใช้"
          align="center"
        ></el-table-column>
        <el-table-column
          prop="item_description"
          label="ประเภทน้ำมัน"
          align="center"
        ></el-table-column>
        <el-table-column
          prop="unit_price"
          label="ราคาน้ำมัน"
          align="right"
        ></el-table-column>
        <el-table-column
          prop="transaction_quantity"
          label="จำนวนที่เติม"
          align="right"
        ></el-table-column>
        <el-table-column
          prop="transaction_amount"
          label="ราคารวม"
          align="right"
        ></el-table-column>
      </el-table>
    </div>
  </div>
</template>

<style scoped>
.btn-success {
  background-color: #1ab394;
  border-color: #1ab394;
}
.btn-cancle {
  background-color: #ec4958;
  border-color: #ec4958;
  color: white;
}
.text-refresh {
  color: #ec4958;
}
</style>

<script>
import moment from "moment";
import BigNumber from "bignumber.js";

export default {
  data() {
    return {
      coaDeptCodes: [],
      carInfos: [],

      searchForm: {
        from_date: "",
        to_date: "",
        default_dept_code: "",
        car_license_plate: "",
      },

      tableData: [
        {
          transaction_date: "",
          car_license_plate: "",
          car_group_desc: "",
          default_dept_code: "",
          car_user: "",
          item_description: "",
          unit_price: "",
          transaction_quantity: "",
          transaction_amount: "",
        },
      ],

      links: [],
      state: "",
      timeout: null,

      loadingInput: {
        coaDeptCode: false,
        carInfos: false,
      },

      loading: false,
    };
  },

  created: function () {
    this.getMasterData();
  },
  mounted() {
    // mounted: Working second
  },
  computed: {
    // computed: ทำงานทุกครั้งที่ input เปลี่ยนค่า
  },
  methods: {
    getMasterData() {
      this.getCOAs(this.default_dept_code);
      this.getWebFuel();
      this.getCarInfos();
    },
    getWebFuel() {
      let params = {
        from_date: this.searchForm.from_date
          ? moment(this.searchForm.from_date).format("YYYY-MM-DD")
          : "",
        to_date: this.searchForm.to_date
          ? moment(this.searchForm.to_date).format("YYYY-MM-DD")
          : "",
        default_dept_code: this.searchForm.default_dept_code,
        car_license_plate: this.searchForm.car_license_plate,
      };
      axios.get("/inv/ajax/web_fuel_oil", { params }).then((response) => {
        let webFuels = response.data;

        this.tableData = webFuels.map((item) => {
          if (item.unit_price == null || item.total_amount == null) {
            (item.unit_price = "-"), (item.total_amount = "-");
          }
          return {
            transaction_date: moment(item.transaction_date)
              .add(543, "years")
              .format("DD/MM/YYYY"),
            car_license_plate: item.car_license_plate,
            car_group_desc: item.car_infos.car_group_desc,
            default_dept_code: item.car_infos.default_dept_code,
            car_user: item.car_infos.car_user,
            item_description: item.car_infos.item_description,
            unit_price:
              new BigNumber(item.web_fuel_dists[0]?.unit_price).toFormat(2) +
              " บาท",
            transaction_quantity:
              new BigNumber(item.web_fuel_dists[0]?.quantity).toFormat(2) +
              " ลิตร",
            transaction_amount:
              new BigNumber(item.web_fuel_dists[0]?.total_amount).toFormat(2) +
              " บาท",
          };
        });
      });
    },
    getWebFuelDist() {
      axios
        .get("/inv/ajax/web_fuel_dist", { params: this.searchForm })
        .then((response) => {
          let web_fuel_dists = response.data;

          this.tableData = web_fuel_dists.map((item) => {
            if (item.unit_price == null || item.total_amount == null) {
              (item.unit_price = "-"), (item.total_amount = "-");
            }
            return {
              transaction_date: item.web_fuel_oils.transaction_date,
              car_license_plate: item.web_fuel_oils.car_license_plate,
              car_group_desc: item.web_fuel_oils.car_infos.car_group_desc,
              default_dept_code: item.web_fuel_oils.car_infos.default_dept_code,
              car_user: item.web_fuel_oils.car_infos.car_user,
              item_description: item.web_fuel_oils.car_infos.item_description,
              unit_price: item.unit_price + " บาท",
              transaction_quantity: item.quantity + " ลิตร",
              transaction_amount: item.total_amount + " บาท",
            };
          });
        });
    },
    getCOAs(query) {
      this.loadingInput.coaDeptCode = true;
      axios
        .get("/inv/ajax/coa_dept_code", { params: { text: query } })
        .then((response) => {
          this.coaDeptCodes = response.data;
        })
        .then(() => {
          this.loadingInput.coaDeptCode = false;
        });
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
    refresh() {
      this.searchForm.from_date = "";
      this.searchForm.to_date = "";
      this.searchForm.car_license_plate = "";
      this.searchForm.default_dept_code = "";
      this.getWebFuel();
    },
  },
};
</script>
