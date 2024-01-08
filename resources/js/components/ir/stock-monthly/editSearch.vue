<template>
  <div class="row">
    <div class="col-xl-3 col-md-6 el_select padding_12">
      <el-select
        v-model="search.status"
        placeholder="สถานะ"
        :remote-method="remoteMethodStatus"
        :loading="loadingStatus"
        :clearable="true"
        @focus="focus"
        @change="changeStatus"
      >
        <el-option
          v-for="(data, index) in statusIR"
          :key="index"
          :label="data.description"
          :value="data.lookup_code"
        />
      </el-select>
    </div>
    <div class="col-xl-3 col-md-6 el_select padding_12">
      <el-select
        v-model="search.sub_group_code"
        filterable
        remote
        placeholder="กลุ่มสินค้าย่อย"
        :remote-method="remoteMethod"
        :loading="loadingSubgroup"
        :clearable="true"
        @change="change"
        @focus="focus"
        name="sub_group_code"
      >
        <el-option
          v-for="(data, index) in locations"
          :key="index"
          :label="data.sub_group_code + ': ' + data.sub_group_description"
          :value="data.sub_group_code"
        />
      </el-select>
    </div>
    <div class="col-xl-3 col-md-6 el_select padding_12">
      <el-select
        v-model="search.item_code"
        filterable
        remote
        placeholder="ชื่อรหัสพัสดุ"
        :remote-method="remoteMethodItems"
        :loading="loadingItem"
        :clearable="true"
        @focus="focus"
        name="item_code"
      >
        <el-option
          v-for="(data, index) in items"
          :key="index"
          :label="data.item_code + ': ' + data.item_description"
          :value="data.item_code"
        />
      </el-select>
    </div>
    <div class="col-xl-3 padding_12 margin_auto_btn_search">
      <button type="button" class="btn btn-default" @click="clickSearch()">
        <i class="fa fa-search"></i> ค้นหา
      </button>
      <button type="button" class="btn btn-warning" @click="clickCancel()">
        <i class="fa fa-repeat"></i> รีเซต
      </button>
      <button
        type="button"
        class="btn btn-success"
        @click="clickCreate"
        :disabled="disabled"
      >
        <i class="fa fa-plus"></i> เพิ่ม
      </button>
    </div>
    <!-- <div style="font-size: 10px; color: blue;">tableLineAll {{tableLineAll}}</div> -->
  </div>
</template>

<script>
export default {
  name: "ir-stock-yearly-edit-search",
  data() {
    return {
      statusIR: [],
      loadingStatus: false,
      loadingSubgroup: false,
      loadingItem: false,
      locations: [],
      header_id: "",
      items: [],
    };
  },
  props: [
    "search",
    "clickCreate",
    "headerRow",
    "disabled",
    "res_header_id",
    "tableLineAll",
  ],
  methods: {
    clickSearch() {
       
      /** FILTER */
      let filterSearch = this.tableLineAll.filter((row, index) => {

        let status = row.status ? row.status.toUpperCase() : row.status;
         
        if (
          status === this.search.status &&
          row.location_code === this.search.sub_group_code &&
          row.item_code === this.search.item_code
        ) {
          //  && row.flag === 'edit'
          return row;
        } else if (
          status === this.search.status &&
          !this.search.sub_group_code &&
          !this.search.item_code
        ) {
          //  && row.flag === 'edit'
          return row;
        } else if (
          row.location_code === this.search.sub_group_code &&
          !this.search.status &&
          !this.search.item_code
        ) {
          //  && row.flag === 'edit'
          return row;
        } else if (row.item_code === this.search.item_code && !this.search.status && !this.search.sub_group_code) {
          return row;

        } else if (row.item_code === this.search.item_code && row.location_code === this.search.sub_group_code && !this.search.status) {
          return row;

        } else if (!this.search.status && !this.search.sub_group_code && !this.search.item_code) {
          //  && row.flag === 'edit'
          return row;
        }
      });
       
      let params = {
        table: filterSearch,
        status: this.search.status,
        sub_group_code: this.search.sub_group_code,
        item_code: this.search.item_code,
      };
      this.$emit("search-table-line", params);
      // this.tableLineAll.filter((row, index) => {
      //   row.rowId = index;
      //   return row;
      // });
      // this.$emit("set-table-line", this.tableLineAll);

      /** API */
      // let params = {
      //   header_id: this.header_id ? this.header_id : this.headerRow.header_id,
      //   // period_year: this.headerRow.period_year,
      //   // period_from: this.headerRow.period_from,
      //   // period_to: this.headerRow.period_to,
      //   // status: this.search.status,
      //   period_year: this.headerRow.header_id ? '' : this.headerRow.period_year,
      //   period_from: this.headerRow.header_id ? '' : this.headerRow.period_from,
      //   period_to: this.headerRow.header_id ? '' : this.headerRow.period_to,
      //   status: this.search.status,
      //   sub_group_code: this.search.sub_group_code,
      //   program_code: 'IRP0001'
      // }
      // axios.get(`/ir/ajax/stocks/show`, { params })
      // .then(({data}) => {
      //   let response = data.data
      //   let params = {
      //     table: response,
      //     status: this.search.status,
      //     sub_group_code: this.search.sub_group_code
      //   }
      //   this.$emit('search-table-line', params)
      // })
      // .catch((error) => {
      //   swal("Error", error, "error");
      // })
      // // let params = {
      // //   mode: 'edit',
      // //   search: this.search
      // // }
      // // this.$emit('click-search', params)
    },
    clickCancel() {
       
      // window.location.href = `/ir/stocks/monthly/edit/${this.headerRow.header_id}`
      this.search.status         = "";
      this.search.sub_group_code = "";
      this.search.item_code      = "";

      let filterSearch = this.tableLineAll.filter((row, index) => {return row;});
      let params = {
        table: filterSearch,
        status: this.search.status,
        sub_group_code: this.search.sub_group_code,
        item_code: this.search.item_code,
      };
      this.$emit("search-table-line", params);
    },
    remoteMethod(query) {
      this.getDataLocations({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: query,
      });
    },
    remoteMethodStatus(query) {
      this.getDataStatus({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: query,
      });
    },
    focus() {
      this.getDataStatus({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: "",
      });

      this.getDataLocations({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: "",
      });

      this.getItems({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: "",
      });
    },
    change(value) {
      this.$emit("change-lov", value);
    },
    getDataStatus(params) {
      this.loadingStatus = true;
      const key = 'lookup_code';
      const list = [...new Map(this.tableLineAll.filter(item => {
        if (item.status === '' || item.status === '') {
          return false; // skip
        }
        return true;
      }).map(item => {
        return { lookup_code: `${item.status}`, description: `${item.status}` };
      }).map(item =>
        [item[key], item])).values()
      ].sort(function(a, b) {
        var nameA = a.lookup_code.toUpperCase(); // ignore upper and lowercase
        var nameB = b.lookup_code.toUpperCase(); // ignore upper and lowercase
        if (nameA < nameB) {
          return -1;
        }
        if (nameA > nameB) {
          return 1;
        }

        // names must be equal
        return 0;
      });
      setTimeout(() => {
        this.loadingStatus = false;
        this.statusIR = list.filter(item => {
        return item.lookup_code.toLowerCase().indexOf(params.keyword.toLowerCase()) > -1 
          || item.description.toLowerCase().indexOf(params.keyword.toLowerCase()) > -1;
        });
      }, 200);
      // axios
      //   .get(`/ir/ajax/lov/status`)
      //   .then(({ data }) => {
      //     this.loadingStatus = false;
      //     this.statusIR = data;
      //   })
      //   .catch((error) => {
      //     swal("Error", error, "error");
      //   });
    },
    getDataLocations(params) {
      this.loadingSubgropu = true;
      const key = 'sub_group_code';
      const list = [...new Map(this.tableLineAll.filter(item => {
        if (item.location_code === '' || item.location_desc === '') {
          return false; // skip
        }
        return true;
      }).map(item => {
        return { sub_group_code: `${item.location_code}`, sub_group_description: `${item.location_desc}` };
      }).map(item =>
        [item[key], item])).values()
      ].sort(function(a, b) {
        var nameA = a.sub_group_code.toUpperCase(); // ignore upper and lowercase
        var nameB = b.sub_group_code.toUpperCase(); // ignore upper and lowercase
        if (nameA < nameB) {
          return -1;
        }
        if (nameA > nameB) {
          return 1;
        }

        // names must be equal
        return 0;
      });
      setTimeout(() => {
        this.loadingSubgropu = false;
        this.locations = list.filter(item => {
        return item.sub_group_code.toLowerCase().indexOf(params.keyword.toLowerCase()) > -1 
          || item.sub_group_description.toLowerCase().indexOf(params.keyword.toLowerCase()) > -1;
        });
      }, 200);
      // axios
      //   .get(`/ir/ajax/lov/sub-group`, { params })
      //   .then(({ data }) => {
      //     this.loadingSubgropu = false;
      //     this.locations = data.data;
      //   })
      //   .catch((error) => {
      //     swal("Error", error, "error");
      //   });
    },
    changeStatus(value) {
      this.$emit("change-status", value);
    },
    remoteMethodItems(query) {
      this.getItems({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: query,
      });
    },
    getItems(params) {
      this.loadingItem = true;
      const key = 'item_code';
      const list = [...new Map(this.tableLineAll.filter(item => {
        if (item.location_code === '' || item.location_desc === '') {
          return false; // skip
        }
        return true;
      }).map(item => {
        return { item_code: `${item.item_code}`, item_description: `${item.item_description}` };
      }).map(item =>
        [item[key], item])).values()
      ].sort(function(a, b) {
        var nameA = a.item_code.toUpperCase(); // ignore upper and lowercase
        var nameB = b.item_code.toUpperCase(); // ignore upper and lowercase
        if (nameA < nameB) {
          return -1;
        }
        if (nameA > nameB) {
          return 1;
        }
        // names must be equal
        return 0;
      });
      setTimeout(() => {
        this.loadingItem = false;
        this.items = list.filter(item => {
          return item.item_code.toLowerCase().indexOf(params.keyword.toLowerCase()) > -1 
            || item.item_description.toLowerCase().indexOf(params.keyword.toLowerCase()) > -1;
        });
      }, 200);
    },
  },
  mounted() {
    this.getDataLocations({
      policy_set_header_id: this.headerRow.policy_set_header_id,
      keyword: "",
    });

    this.getItems({
      policy_set_header_id: this.headerRow.policy_set_header_id,
      keyword: "",
    });
  },
  watch: {
    res_header_id(newVal, oldVal) {
      this.res_header_id = newVal;
    },
  },
  created() {
    this.getDataStatus();
  },
};
</script>

