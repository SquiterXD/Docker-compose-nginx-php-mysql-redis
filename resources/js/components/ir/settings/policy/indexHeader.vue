<template>
  <div>
    <div class="row">
      <div class="col-sm-4 el_select padding_12">
        <el-select  v-model="policy.id"
                    filterable
                    placeholder="ระบุชุดกรมธรรม์"
                    name="policy_desc"
                    :remote-method="remoteMethod"
                    :loading="loading"
                    remote
                    :disabled="disabled"
                    @focus="focusPolicies"
                    :clearable="true">
          <el-option  v-for="policy in policiesLov"
                      :key="policy.policy_set_header_id"
                      :label="`${policy.policy_set_number} : ${policy.policy_set_description}`"
                      :value="policy.policy_set_header_id">
          </el-option>
        </el-select>
      </div>
      <div class="col-sm-4 el_select padding_12">
          <el-select  v-model="status"
                    placeholder="Status"
                    name="active_flag"
                    :clearable="true">
            <el-option label="Active" value="Y"></el-option>
            <el-option label="Inactive" value="N"></el-option>
          </el-select>
      </div>

      <div class="col-sm-4 padding_12 margin_auto">
        <button type="button" :class="btnTrans.search.class+' btn-lg tw-w-25'" @click.prevent="clickSearch()">
          <i :class="btnTrans.search.icon"></i>
          {{ btnTrans.search.text }}
        </button>
        <button type="button" :class="btnTrans.reset.class+' btn-lg tw-w-25'" @click.prevent="clickClear()">
          <i :class="btnTrans.reset.icon"></i>
          {{ btnTrans.reset.text }}
        </button>
      </div>
    </div>

    <div class="table-responsive margin_top_20" style="max-height: 500px;">
      <table class="table table-bordered" style="position: sticky;">
        <thead>
          <tr class="text-center">
            <th class="text-center sticky-col th-row" style="width: 150px;">กรมธรรม์ชุดที่<br>(Policy No)</th>
            <th class="text-center sticky-col th-row" style="width: 450px;">คำอธิบาย<br>(Description)</th>
            <th class="text-center sticky-col th-row" style="width: 300px;">แบบของการประกัน<br>(Policy Type)</th>
            <th class="text-center sticky-col th-row" style="width: 80px; vertical-align: middle;">Active</th>
            <th class="text-center sticky-col th-row" style="width: 50px; vertical-align: middle;">Action</th>
          </tr>
        </thead>
        <tbody id="table_total">
          <tr v-show="policiesList.length > 0" v-for="(data, index) in policiesList" :key="index">
            <td class="text-center">{{data.policy_set_number}}</td>
            <td>{{data.policy_set_description}}</td>
            <td class="text-center">{{data.policy_type_description}}</td>
            <td class="text-center">
                <input  :class="`table_company_active${index}`"
                        type="checkbox"
                        id="active_flag"
                        name="active_flag"
                        v-model="data.active_flag"
                        @change="changeChecked(data, index)">
            </td>
            <td class="width_table text-center">
              <button type="button" :class="btnTrans.edit.class+' btn-sm tw-w-25'" @click.prevent="clickEdit(index, data)">
                <i :class="btnTrans.edit.icon"></i>
                {{ btnTrans.edit.text }}
              </button>
            </td>
          </tr>
          <tr class="text-center" v-show="policiesList.length === 0"><td colspan="6">ไม่มีข้อมูล</td></tr>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'ir-index-header-policy',
    data() {
      return {
        policiesLov: [],
        policy: {
          id: '',
          desc: ''
        },
        loading: false,
        disabled: false,
        status: '',
        options: [],
        tableLoading: false,
        policiesList: []
      }
    },
    props: [
      'setDefaultActive', 'btnTrans'
    ],
    mounted() {
      this.getPoliciesLov({ policy_set_header_id: '', keyword: '' })
      this.getPolicy({policy_set_header_id: '', active_flag: ''})
      // this.getStatus()
    },
    methods: {
      remoteMethod(desc) {
        if (desc !== "") {
                this.getPoliciesLov({ policy_set_header_id: '', keyword: desc })
        } else {
            this.policiesLov = []
        }
      },
      getPoliciesLov(params) {
        this.tableLoading = true
        axios.get(`/ir/ajax/lov/policy-set-header`, { params })
        .then(({data: response}) => {
          this.tableLoading = false
          this.policiesLov = response.data
        })
      },
      clickSearch () {
        const vm = this
        let params = {
          policy_set_header_id: vm.policy.id,
          active_flag: vm.status
        }
        this.getPolicy(params)
      },
      getPolicy(params) {
        const vm = this
        vm.tableLoading = true
        axios.get(`/ir/ajax/policy`, { params })
        .then(({data: response}) => {
          vm.tableLoading = false
          vm.policiesList = response.data.map(data => {
            if (data.active_flag == 'Y') data.active_flag = true
            else if (data.active_flag == 'N') data.active_flag = false
            return data
          })
        })
      },
      clickClear () {
        this.policy_id = ''
        this.status = ''
        location.replace('/ir/settings/policy')
      },
      focusPolicies (param) {
        this.getPoliciesLov({policy_set_header_id: ''})
      },
      addPolicy() {
        window.location.replace('/ir/settings/policy/create')
        // this.$emit('changeMode')
      },
      clickEdit(index, dataRow) {
        let data = {
          showIndex: false,
          row: dataRow
        }
        window.location.href = `/ir/settings/policy/edit/${dataRow.policy_set_header_id}`
      },
      changeChecked(dataRow, index) {
        let _this = this;
        let data = {
          ...dataRow,
          active_flag: dataRow.active_flag ? 'Y' : 'N'
        }
        axios.put(`/ir/ajax/policy/active-flag`, { data })
        .then(({data}) => {
          swal({
            title: "Success",
            text: data.message,
            // timer: 3000,
            type: "success",
            // showCancelButton: false,
            // showConfirmButton: false
          })
        })
        .catch((error) => {
          if (error.response.data.status === 400) {
            swal({
              title: "Warning",
              text: error.response.data.message,
              type: "warning",
            },
            function(isConfirm) {
              if (isConfirm) {
              _this.setDefaultActive(`table_company_active${index}`);
              }
            });
            // swal({
            //   title: "Warning",
            //   text:  error.response.data.message,
            //   timer: 3000,
            //   type: "warning",
            // })
          } else {
            swal({
              title: "Error",
              text:  error.response.data.message,
              // timer: 3000,
              type: "error",
            })
          }
        })
      },
      isChecked(value) {
        if (value === 'Y') {
          return true
        }
        return false
      },
      getStatus() {
        this.loading = true
        axios.get(`/ir/ajax/lov/status`)
        .then(({data: response}) => {
          this.loading = false
          this.options = response
        })
      }
    }
  }
</script>
<style scope>
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 116px;
    }

    .th-row {
        top: 0;
    }

    .mouse-over:hover {
      background-color: #d4edda !important;
    }
</style>
<style>
    .el_select .el-select {
        width: 100%
    }
    .padding_12 {
        padding: 12px
    }
    .margin_auto {
        margin: auto
    }
</style>
