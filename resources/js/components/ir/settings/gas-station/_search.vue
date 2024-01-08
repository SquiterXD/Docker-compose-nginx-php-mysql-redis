<template>
    <form :action="search_url" id="searchForm">
        <div class="row">
            <div class="col-xl-3 col-md-4 padding_12 el_field">
                <input type="hidden" name="type_code" :value="type_code">
                <el-select  v-model="type_code"
                            filterable
                            placeholder="ระบุประเภทสถานีน้ำมัน"
                            :remote-method="getStations"
                            :loading="loading"
                            remote
                            clearable
                            class="w-100">
                    <el-option  v-for="(data, index) in gas_stations"
                                :key="index"
                                :label="data.description"
                                :value="data.description">
                    </el-option>
                </el-select>
            </div>
            <div class="col-xl-3 col-md-4 padding_12 el_field">
                <input type="hidden" name="return_vat_flag" :value="return_vat_flag">
                    <el-select  v-model="return_vat_flag"
                                filterable
                                clearable
                                remote
                                placeholder="ขอคืนภาษี"
                                class="w-100">
                        <el-option  v-for="(data, index) in returnLists"
                                    :key="index"
                                    :label="data.label"
                                    :value="data.value" />
                </el-select>
            </div>
            <div class="col-xl-3 col-md-4 padding_12 el_field">
                <input type="hidden" name="active_flag" :value="active_flag">
                <el-select  v-model="active_flag"
                            filterable
                            clearable
                            remote
                            placeholder="Status"
                            class="w-100">
                    <el-option  v-for="(data, index) in activeLists"
                                :key="index"
                                :label="data.label"
                                :value="data.value" />
                </el-select>
            </div>
            <div class="col-xl-3 padding_12" style="margin-top: auto; margin-bottom: auto;">
            <button type="button" :class="btnTrans.search.class+' btn-lg tw-w-25'" @click.prevent="clickSearch()">
                <i :class="btnTrans.search.icon"></i>
                {{ btnTrans.search.text }}
            </button>
            <button type="button" :class="btnTrans.reset.class+' btn-lg tw-w-25'" @click.prevent="clickCancel()">
                <i :class="btnTrans.reset.icon"></i>
                {{ btnTrans.reset.text }}
            </button>
            </div>
        </div>
    </form>
</template>

<script>

export default {
    name: 'ir-settings-gas-station-search',
    props: ['btnTrans', 'dataSearch'],
    data () {
      return {
        gas_stations: [],

        loading: false,

        type_code: '',
        return_vat_flag: '',
        active_flag: '',
        search_url: this.dataSearch.search_url,

        returnLists: [{
            label: 'ขอคืนภาษีได้',
            value: 'Y'
        }, {
            label: 'ขอคืนภาษีไม่ได้',
            value: 'N'
        }],

        activeLists: [{
          label: 'Active',
          value: 'Y'
        }, {
          label: 'Inactive',
          value: 'N'
        }],
      }
    },
    mounted () {
      if (this.dataSearch) {
        this.type_code       = this.dataSearch.type_code;
        this.return_vat_flag = this.dataSearch.return_vat_flag;
        this.active_flag     = this.dataSearch.active_flag;
      }

      this.getStations();
      
    },
    methods: {
      getStations(query) {
        this.loading = true;
        this.policiesLov = [];
        axios.get(`/ir/ajax/lov/gas-stations-type`, { 
            params: {
              keyword: query,
            }
        })
        .then(({data}) => {
            this.loading = false;
            this.gas_stations = data.data
        })
        .catch((error) => {
            swal("Error", error, "error");
        })
      },
      clickCancel () {
        window.location.href = '/ir/settings/gas-station'
      },
      clickSearch () {
        $( "#searchForm" ).submit();
      },
    }
}
</script>