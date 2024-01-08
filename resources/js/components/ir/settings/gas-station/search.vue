<template>
  <div class="row">
    <div class="col-xl-3 col-md-4 padding_12 el_field">
      <el-select  v-model="search.type_code"
                  filterable
                  remote
                  placeholder="ระบุประเภทสถานีน้ำมัน"
                  :remote-method="remoteMethod"
                  :loading="loading"
                  :clearable="true"
                  @change="change"
                  @focus="focus">
        <el-option  v-for="(data, index) in gas_stations"
                    :key="index"
                    :label="data.description"
                    :value="data.description" />
    </el-select>
    </div>
    <div class="col-xl-3 col-md-4 padding_12 el_field">
      <dropdown-return-vat-flag v-model="search.return_vat_flag"
                                placeholder="ขอคืนภาษี"
                                name="return_vat_flag"
                                :disabled="false"
                                size=""
                                :popperBody="true"
                                @change-dropdown="getValueReturnVatFlag" />
      <!--<el-select  v-model="search.return_vat_flag"
                  placeholder="ขอคืนภาษี"
                  name="return_vat_flag"
                  :clearable="true">
        <el-option label="ขอคืนภาษีได้" value="Y"></el-option>
        <el-option label="ขอคืนภาษีไม่ได้" value="N"></el-option>
      </el-select> -->
    </div>
    <div class="col-xl-3 col-md-4 padding_12 el_field">
      <dropdown-active-flag v-model="search.active_flag"
                            placeholder="Status"
                            name="active_flag"
                            :disabled="false"
                            size=""
                            :popperBody="true"
                            @change-dropdown="getValueActiveFlag" />
      <!-- <el-select  v-model="search.active_flag"
                  placeholder="Status"
                  name="active_flag"
                  :clearable="true">
        <el-option label="Active" value="Y"></el-option>
        <el-option label="Inactive" value="N"></el-option>
      </el-select> -->
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
</template>

<script>
import dropdownReturnVatFlag from '../../components/dropdown/returnVatFlag'
import dropdownActiveFlag from '../../components/dropdown/activeFlag'
export default {
  name: 'ir-settings-gas-station-search',
  data () {
    return {
      gas_stations: [],
      loading: false,
      create: {
        gas_station_id: '',
        type_code: '',
        group_code: '',
        group_name: '',
        return_vat_flag: false,
        vat_percent: '',
        revenue_stamp_percent: '',
        type_cost: '',
        account_combine: '',
        active_flag: true,
        account_id: '',
        policy_set_header_id: ''
      }
    }
  },
  props: [
    'search', 'btnTrans'
  ],
  methods: {
    clickSearch () {
      this.$emit('click-search', this.search)
    },
    clickCancel () {
      window.location.href = '/ir/settings/gas-station'
    },
    remoteMethod(query) {
      this.getDataRows({ keyword: query })
    },
    focus () {
      this.getDataRows({ keyword: '' })
    },
    change (value) {
      this.$emit('change-lov', value)
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/gas-stations-type`, { params })
      .then(({data}) => {
        this.loading = false;
        this.gas_stations = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    clickCreate () {
      let data = {
        showIndex: false,
        create: this.create
      }
      this.$emit('click-create', data)
    },
    getValueReturnVatFlag (value) {
      this.search.return_vat_flag = value;
    },
    getValueActiveFlag (value) {
      this.search.active_flag = value;
    }
  },
  components: {
    dropdownReturnVatFlag,
    dropdownActiveFlag
  },
  mounted () {
    this.getDataRows({ keyword: '' })
  }
}
</script>

