<template>
  <form :action="search_url" id="searchForm">
    <div class="row">
      <div class="col-xl-4 col-md-6 el_select padding_12">
        <input type="hidden" name="company_id" :value="company_id">
        <el-select  v-model="company_id"
                    filterable
                    placeholder="ระบุข้อมูลผู้รับประกัน"
                    :remote-method="getCompanies"
                    :loading="loading"
                    remote
                    clearable>
            <el-option  v-for="company in companies"
                        :key="company.company_id"
                        :label="company.company_number + ': ' + company.company_name"
                        :value="company.company_id">
            </el-option>
        </el-select>
      </div>
      <div class="col-lg-2 col-sm-2 padding_12">
        <input type="hidden" name="active_flag" :value="active_flag">
        <el-select  v-model="active_flag"
                    filterable
                    clearable
                    remote
                    placeholder="Status">
            <el-option  v-for="(data, index) in activeLists"
                        :key="index"
                        :label="data.label"
                        :value="data.value" />
        </el-select>
    </div>
      <div class="col-xl-4 padding_12 margin_auto_btn_search">
        <button type="button" :class="btnTrans.search.class+' btn-lg tw-w-25'" @click.prevent="clickSearch">
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
  name: 'ir-settings-company-search',
  props: ['search', 'btnTrans', 'dataSearch'],
  data () {
    return {
      companies: [],
      loading: false,
      active_flag: '',
      company_id: '',
      search_url: this.dataSearch.search_url,
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
      this.active_flag = this.dataSearch.active_flag;
      this.company_id  = this.dataSearch.company_id ? Number(this.dataSearch.company_id) : '';
    }

    this.getCompanies();
    
  },
  methods: {
    getCompanies(query) {
      this.loading = true;
      this.companies = [];
      axios.get(`/ir/ajax/lov/companies`, { 
          params: {
            company_id: this.company_id,
            query: query,
          }
      })
      .then(({data}) => {
          this.loading = false;
          this.companies = data.data
      })
      .catch((error) => {
          swal("Error", error, "error");
      })
    },
    clickCancel () {
      window.location.href = '/ir/settings/company'
    },
    clickSearch () {
      console.log('clickSearch clickSearch 555');
      $( "#searchForm" ).submit();
    },
  }
}
</script>