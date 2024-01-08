<template>
  <div>
    <div class="ibox">
      <div class="ibox-content">
        <div class="row">
          <div class="col-3">
            <label class="w-100 text-left">
              <strong> ประเภทวัตถุดิบ</strong>
            </label>
            <input
              type="hidden"
              name="search[itemcat]"
              v-model="itemcat"
              autocomplete="off"
            />
            <input type="hidden" name="itemcat" v-model="itemcat" autocomplete="off" />
            <el-select
              v-model="itemcat"
              placeholder="โปรดเลือกประเภทวัตถุดิบ"
              class="w-100"
              clearable
              filterable
              remote
              reserve-keyword
              @change="getOrganization(itemcat)"
            >
              <el-option
                v-for="(itemcat, index) in tobaccoItemcatList"
                :key="index"
                :label="itemcat.tobacco_group_code + ' : ' + itemcat.tobacco_group"
                :value="itemcat.tobacco_group_code"
              >
              </el-option>
            </el-select>
          </div>
          <div class="col-3">
            <label class="w-100 text-left">
              <strong> Organization</strong>
            </label>
            <input
              type="hidden"
              name="search[organization]"
              v-model="organizationSearch"
              autocomplete="off"
            />
            <input
              type="hidden"
              name="organization"
              v-model="organizationSearch"
              autocomplete="off"
            />
            <el-input
              placeholder="organization"
              v-model="organizationShow"
              v-loading="loading.organizationShow"
              :disabled="true"
            >
            </el-input>
          </div>
          <div class="col-3">
            <label class="w-100 text-left">
              <strong> คลังจัดเก็บ/สถานที่จัดเก็บ</strong>
            </label>
            <input
              type="hidden"
              name="search[location]"
              v-model="locationSearch"
              autocomplete="off"
            />
            <input
              type="hidden"
              name="location"
              v-model="locationSearch"
              autocomplete="off"
            />
            <el-input
              placeholder="คลังจัดเก็บ/สถานที่จัดเก็บ"
              v-model="locationShow"
              v-loading="loading.locationShow"
              :disabled="true"
            >
            </el-input>
          </div>
          <div class="col-3">
            <label class="w-100 text-left">
              <strong> รหัสวัตถุดิบ </strong>
            </label>
            <input
              type="hidden"
              name="search[itemNumber]"
              v-model="itemNumber"
              autocomplete="off"
            />
            <input
              type="hidden"
              name="itemNumber"
              v-model="itemNumber"
              autocomplete="off"
            />
            <el-select
              v-model="itemNumber"
              filterable
              remote
              reserve-keyword
              clearable
              placeholder="โปรดเลือกรหัสวัตถุดิบ"
              class="w-100"
              :disabled="isDisabledItemNumber"
              v-loading="loading.itemNumber"
            >
              <el-option
                v-for="(itemNumber, index) in itemNumberList"
                :key="index"
                :label="itemNumber.item_number + ' : ' + itemNumber.item_desc"
                :value="itemNumber.inventory_item_id"
              >
              </el-option>
            </el-select>
          </div>
        </div>
        <div class="text-right" style="padding-top: 15px">
          <button
            class="btn btn-light"
            :disabled="!organizationSearch || !locationSearch"
            @click.prevent="
              search(organizationSearch, locationSearch, itemcat, itemNumber)
            "
          >
            <i class="fa fa-search" aria-hidden="true"></i> แสดงข้อมูล
          </button>
          <a
            type="button"
            :href="'/pm/settings/setup-min-max-by-item'"
            class="btn btn-danger"
          >
            ล้างค่า
          </a>
        </div>
      </div>
    </div>

    <div v-loading="loading.tableData">
      <setup-min-max-by-item-table
        :organizationSearch="organizationSearch"
        :itemNumberSearch="itemNumber"
        :listSetupMinMax="listSetupMinMax"
        :listSearchItemNumber="listSearchItemNumber"
        :btnTrans="btnTrans"
        :searched="searched"
      >
      </setup-min-max-by-item-table>
    </div>
  </div>
</template>

<script>
import SetupMinMaxByItemTable from "./TableComponent.vue";
export default {
  components: { SetupMinMaxByItemTable },
  props: ["tobaccoItemcatList", "searchOld", "btnTrans"],
  data() {
    return {
      organizationSearch: "",
      organizationShow: "",
      locationSearch: "",
      locationShow: "",
      itemNumber: "",
      itemcat: this.searchOld ? this.searchOld.itemcat : "",
      primaryUomCode: "",
      primaryUnitOfMeasure: "",
      searched:false,
      loading: {
        organizationShow: false,
        locationShow: false,
        itemNumber: false,
        primaryUomCode: false,
        primaryUnitOfMeasure: false,
        itemcat: false,
        tableData: false,
      },

      isDisabledItemNumber: true,

      organizationList: [],
      itemLocationsList: [],
      itemNumberList: [],
      listSetupMinMax: [],
      listSearch: [],
      listSearchItemNumber: [],
    };
  },
  
  async mounted() {
    if (this.searchOld) {
    await this.getOrganization(this.searchOld.itemcat);
    await this.search(
      this.searchOld.organization,
      this.searchOld.location,
      this.searchOld.itemcat,
      this.searchOld.itemNumber
    );
    } else {
      const urlParams = new URLSearchParams(window.location.search);
      const organization = urlParams.get('organization')
      const location = urlParams.get('location')
      const itemcat = urlParams.get('itemcat')
      const itemNumber = urlParams.get('itemNumber')
      if(organization != null && location != null && itemcat != null) {
        Vue.set(this,'itemcat', itemcat)
        await this.getOrganization(itemcat);
        console.log({organization,location})
        await this.search(
              organization,
              location,
              itemcat,
              itemNumber
            );
      } else {
        await this.initialTable();

      }
    }

    


    $(function() {
      $("#setup-min-max-by-item-datatable-bk").dataTable()
    })
  },
  methods: {
    async fetchData(params) {
      await axios
        .get("/pm/ajax/setup-min-max-by-item/get-organization", { params })
        .then((res) => {
          if (res.data.organizationSearch == "") {
            this.organizationSearch = "";
            this.organizationShow = "";

            this.loading.organizationShow = false;
            this.loading.locationShow = false;
            this.loading.itemNumber = false;

            this.locationSearch = "";
            this.locationShow = "";

            this.itemNumber = "";

            this.isDisabledItemNumber = true;
          } else {
            if (res.data.organizationList == "noInput") {
              this.organizationSearch = "";
              this.organizationShow = "";

              this.loading.organizationShow = false;
              this.loading.locationShow = false;
              this.loading.itemNumber = false;

              this.locationSearch = "";
              this.locationShow = "";

              this.itemNumber = "";

              this.isDisabledItemNumber = true;
            } else {
              this.organizationSearch = res.data.organization.organization_id;
              this.organizationShow =
                res.data.organization.organization_code +
                " : " +
                res.data.organization.organization_name;

              this.loading.organizationShow = false;
              this.loading.locationShow = false;
              this.loading.itemNumber = false;

              this.locationSearch = res.data.itemLocation.locator_id;
              this.locationShow =
                res.data.itemLocation.locator_code +
                " : " +
                res.data.itemLocation.location_desc;

              this.itemNumberList = res.data.itemNumberList;

              this.isDisabledItemNumber = false;
            }
          }
        });
    },
    async getOrganization(value) {
      var params = {
        itemcat: value,
      };
      this.loading.organizationShow = true;
      this.loading.locationShow = true;
      this.loading.itemNumber = true;
      return this.fetchData(params);
    },

    async search(organization, location, itemcat, itemNumber) {
      var params = {
        organization: organization,
        location: location,
        itemcat: itemcat,
        itemNumber: itemNumber,
      };

      var pageUrl = '?q=q&organization=' + (typeof organization != 'undefined' ? organization : '' ) + "&location=" + (typeof location != 'undefined' ? location : '' ) + "&itemcat="+ (typeof itemcat != 'undefined' ? itemcat : '' ) + "&itemNumber="+ (typeof itemNumber != 'undefined' ? itemNumber : '' );
      window.history.pushState('', '', pageUrl);
      this.loading.tableData = true;
      let vm = this;
      await axios.get("/pm/ajax/setup-min-max-by-item/search", { params }).then((res) => {
        this.listSetupMinMax = res.data.data.listSetupMinMax;
        this.listSearch = res.data.data.listSearch;
        this.listSearchItemNumber = res.data.data.listSearchItemNumber;
        vm.$children[4].isDisabledBtuAdd = false;
        this.loading.tableData = false;
      });
      console.log($("#setup-min-max-by-item-datatable").dataTable({
          searching:false,
          ordering:false
      }));
      this.searched = true
      return true;
    },

    async initialTable(organization, location, itemcat, itemNumber) {
      var params = {
        status: 'init_table',
      };
      this.loading.tableData = true;
      let vm = this;
      await axios.get("/pm/ajax/setup-min-max-by-item/search", { params }).then((res) => {
        this.listSetupMinMax = res.data.data.listSetupMinMax;
        this.listSearch = res.data.data.listSearch;
        this.listSearchItemNumber = res.data.data.listSearchItemNumber;
        vm.$children[4].isDisabledBtuAdd = false;
        this.loading.tableData = false;
      });
      

      return true;
    },
  },
};
</script>
