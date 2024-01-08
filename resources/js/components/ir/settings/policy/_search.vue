<template>
    <form :action="search_url" id="searchForm">
        <div class="row">
            <div class="col-sm-4 el_select padding_12">
              <input type="hidden" name="policy_set_header_id" :value="policy_set_header_id">
                <el-select  v-model="policy_set_header_id"
                            filterable
                            placeholder="ระบุชุดกรมธรรม์"
                            :remote-method="getPolicies"
                            :loading="loading"
                            remote
                            clearable
                            class="w-100">
                  <el-option  v-for="policy in policiesLov"
                              :key="policy.policy_set_header_id"
                              :label="policy.policy_set_number + ': ' + policy.policy_set_description"
                              :value="policy.policy_set_header_id">
                  </el-option>
                </el-select>
            </div>
            <div class="col-sm-4 el_select padding_12">
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

            <div class="col-sm-4 padding_12 margin_auto">
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
    name: 'ir-settings-policy-search',
    props: ['btnTrans', 'dataSearch'],
    data () {
      return {
        policiesLov: [],

        loading: false,

        active_flag: '',
        policy_set_header_id: '',
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
        this.policy_set_header_id  = this.dataSearch.policy_set_header_id ? Number(this.dataSearch.policy_set_header_id) : '';
      }

      this.getPolicies();
      
    },
    methods: {
      getPolicies(query) {
        console.log('getPolicies -- ', query);
        this.loading = true;
        this.policiesLov = [];
        axios.get(`/ir/ajax/lov/policy-set-header`, { 
            params: {
              policy_set_header_id: this.policy_set_header_id,
              keyword: query,
            }
        })
        .then(({data}) => {
            this.loading = false;
            this.policiesLov = data.data
        })
        .catch((error) => {
            swal("Error", error, "error");
        })
      },
      clickCancel () {
        window.location.href = '/ir/settings/policy'
      },
      clickSearch () {
        $( "#searchForm" ).submit();
      },
    }
  }
</script>