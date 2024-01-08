<template>
  <div class="row">
    <div class="col-xl-4 col-md-6 el_select padding_12">
      <el-select  v-model="search.company_id"
                  filterable
                  placeholder="ระบุข้อมูลผู้รับประกัน"
                  name="company_id"
                  :remote-method="remoteMethodCompany"
                  :loading="loading"
                  remote
                  clearable
                  @focus="focusCompany">
          <el-option  v-for="company in companies"
                      :key="company.company_id"
                      :label="company.company_number + ': ' + company.company_name"
                      :value="company.company_id">
          </el-option>
      </el-select>
    </div>
    <div class="col-xl-4 col-md-6 el_select padding_12">
      <el-select  v-model="search.active_flag"
                  placeholder="Status"
                  name="active_flag"
                  :clearable="true">
        <el-option label="Active" value="Y"></el-option>
        <el-option label="Inactive" value="N"></el-option>
      </el-select>
    </div>
    <div class="col-xl-4 padding_12 margin_auto_btn_search">
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
export default {
  name: 'ir-settings-company-search',
  data () {
    return {
      companies: [],
      loading: false,
      create: {
        company_number: '',
        company_name: '',
        company_address: '',
        company_telephone: '',
        vendor_id: '',
        vendor_site_id: '', // branch_code: '',
        customer_id: '',
        active_flag: true,
        company_id: ''
      }
    }
  },
  props: [
    'search', 'btnTrans'
  ],
  methods: {
    remoteMethodCompany (query) {
      this.getCompanies({
        company_id: '',
        keyword: query
      })
    },
    getCompanies(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/companies`, { params })
      .then(({data}) => {
        let response = data.data
        this.loading = false;
        this.companies = response;
      })
      .catch((error) => consle.log('error ', error));
    },
    clickSearch () {
      this.$emit('click-search', this.search)
    },
    focusCompany (event) {
      this.getCompanies({
        company_id: '',
        keyword: ''
      })
    },
    clickCancel () {
      window.location.href = '/ir/settings/company'
    }
  },
  mounted () {
    this.getCompanies({
      company_id: '',
      keyword: ''
    })
  }
}
</script>
