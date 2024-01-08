<template>
  <div>
    <div class="row">
      <div class="col-sm-4 el_select padding_12">
          <el-select  v-model="policyGroup_id"
                      filterable
                      placeholder="ระบุข้อมูลกลุ่มกรมธรรม์"
                      name="policyGroup_id"
                      :remote-method="remoteMethod"
                      :loading="loading"
                      :clearable="true"
                      remote
                      :disabled="disabled"
                      @focus="focusPolicyGroup">
              <el-option  v-for="policy in policyGroup"
                          :key="policy.group_header_id"
                          :label="`${policy.group_code} : ${policy.group_description}`"
                          :value="policy.group_header_id">
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
        <button type="button" :class="btnTrans.create.class+' btn-lg tw-w-25'" @click.prevent="addPolicy()">
          <i :class="btnTrans.create.icon"></i>
          {{ btnTrans.create.text }}
        </button>
      </div>
    </div>

    <policy-group-list  :policies='policyGroupList'
                        :search-url='search'
                        :saveUrl="saveUrl"
                        @edit-policy='clickEdit'
                        @removeRow='removeLine'
                        :btn-trans="btnTrans" 
                        :policy-group="policyGroup"/>
  </div>
</template>

<script>
  import uuidv1 from 'uuid/v1';
  import policyGroupList from './policyGroupList.vue'
  export default {
    components: { policyGroupList },
    name: 'ir-search-policy-group',
    data() {
        return {
            policyGroup: [],
            policyGroupList: [],
            policyGroup_id: '',
            loading: false,
            disabled: false,
            status: '',
            options: [],
            company_name: ''
        }
    },
    props: [
      'search',
      'saveUrl',
      'btnTrans'
    ],
    mounted() {
      this.getPolicyGroupLov({ group_header_id: this.policyGroup_id })
      this.getPolicyGroupList()
      this.getStatus()
    },
    methods: {
      remoteMethod(query) {
        if (query !== "") {
            if (parseInt(query)) {
                this.getPolicyGroupLov({ group_header_id: this.policyGroup_id, keyword: query })
            } else {
                this.getPolicyGroupLov({ group_header_id: this.policyGroup_id, keyword: query })
            }
        } else {
            this.policyGroup = []
        }
      },
      getPolicyGroupLov(params) {
          this.loading = true
          axios.get(`/ir/ajax/lov/policy-group-header`, { params })
          .then(({data: response}) => {
            this.loading = false
            this.policyGroup = response.data
          })
      },
      getPolicyGroupList(params) {
        this.loading = true
        axios.get(`/ir/ajax/policy-group`, {params})
        .then(({data: response}) => {
          this.loading = false
          this.policyGroupList = response.data.map(res => {
            res.active_flag === 'Y' ? res.active_flag = true : res.active_flag = false
            return res
          })
        })
      },
      clickSearch () {
        let params = {
            group_header_id: this.policyGroup_id,
            active_flag: this.status
        }
        this.getPolicyGroupList(params)
      },
      clickClear () {
        this.policyGroup_id = ''
        this.status = ''
        location.replace('/ir/settings/policy-group')
      },
      addPolicy () {
        this.policyGroupList.push({
          group_code: '',
          group_description: '',
          active_flag: true,
          uid: uuidv1() //uid
        })
        this.$nextTick(() => {
          const el = this.$el.getElementsByClassName('endTable')[0];
          if (el) {
            el.scrollIntoView();
          }
        });
      },
      focusPolicyGroup () {
        this.getPolicyGroupLov({group_header_id: ''})
      },
      clickEdit(value) {
        this.$emit('editValue', value)
      },
      getStatus() {
        this.loading = true
        axios.get(`/ir/ajax/lov/status`)
        .then(({data: response}) => {
          this.loading = false
          this.options = response
        })
      },
      removeLine(line) {
         
        this.policyGroupList = this.policyGroupList.filter(item => {
          return item.uid != line.uid
        });
      },
    }
  }
</script>

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
