<template>
<el-form  :model="data"
          ref="save_table_line"
          class=" form_table_line">
  <div class="row col-12" style="margin: 0px;">
    <div class="table-responsive" style="max-height: 500px;">
      <table class="table table-bordered center" style="margin-top:30px; position: sticky;">
        <thead>
          <tr>
            <th class="text-center sticky-col th-row" style="width: 200px; padding: 15px;"> รหัส (Code) <span class="text-danger"> * </span></th>
            <th class="text-center sticky-col th-row" style="width: 350px; padding: 15px;"> คำอธิบาย (Description) <span class="text-danger"> * </span></th>
            <th class="text-center sticky-col th-row" style="width: 125px; padding: 15px;"> Status </th>
            <th class="text-center sticky-col th-row" style="width: 150px; padding: 15px;"> Action </th>
          </tr>
        </thead>
        <tbody >
          <tr v-for="(policy,index) in data.policies" 
              :key="index" 
              v-bind:class="[index == data.policies.length - 1 ? 'endTable' : '']">
            <td class="el_field">
              <div style="margin-top: 5px">
                  <el-form-item :prop="'policies.' + index + '.group_code'"
                          :rules='rules.group_code' class="el-form-item-irm0003 pb-2">
                  <el-input v-model="policy.group_code"
                            :disabled="(policy.group_header_id ? true : false)"
                            :maxlength="100"
                            @change="checkCodeDuplicate()"/>
                  </el-form-item>
              </div>
            </td>
            <td class="el_field">
              <div style="margin-top: 5px">
                  <el-form-item :prop="'policies.' + index + '.group_description'"
                              :rules='rules.group_description' class="el-form-item-irm0003 pb-2">
                  <el-input name="policy_set_number"
                            v-model="policy.group_description"
                            :disabled="(policy.group_header_id ? true : false)"
                            :maxlength="150"/>
                  </el-form-item>
              </div>
            </td>
            <td class="el_field text-center pb-2">
              <div class="form-check" style="position: inherit;">
                <input  class="form-check-input mt-0"
                        type="checkbox"
                        :id="`active_flag_${index}`"
                        :name="`active_flag_${index}`"
                        v-model="policy.active_flag"
                        @change="changeActiveFlag(policy)"
                        style="position: inherit;">
                <label class="form-check-label" name='active_flag' :for='`active_flag_${index}`'>
                  Active
                </label>
             </div>
            </td>
            <td class='el_field text-center pb-2'>
                <template v-if= "index+1 <= policyGroup.length">
                  <button type="button" :class="btnTrans.edit.class+' btn-sm tw-w-25'" @click.prevent="clickSearch(policy)">
                    <i :class="btnTrans.edit.icon"></i>
                    {{ btnTrans.edit.text }}
                  </button>
                </template>
                <template v-else>
                  <button type="button" :class="btnTrans.save.class+' btn-sm tw-w-25'" @click.prevent="save()">
                    <i :class="btnTrans.save.icon"></i>
                    {{ btnTrans.save.text }}
                  </button>
                  <button type="button" :class="btnTrans.delete.class+' btn-sm tw-w-25'" @click="remove(policy)">
                    <i :class="btnTrans.delete.icon"></i>
                    {{ btnTrans.delete.text }}
                  </button>
                </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</el-form>
</template>

<script>
export default {
  name: 'policy-group-list',
  data() {
    return {
      data: {policies: this.policies},
      rules: {
        group_code: [{
          required: true, message: 'กรุณาระบุรหัส', trigger: 'change'
        }],
        group_description: [{
          required: true, message: 'กรุณาระบุคำอธิบาย', trigger: 'change'
        }],
      },
    }
  },
  props: [
    'policies',
    'searchUrl',
    'saveUrl',
    'btnTrans',
    'policyGroup'
  ],
  methods: {
    changeActiveFlag(policy) {
      let params = {
        data: {
          group_header_id: policy.group_header_id,
          active_flag: policy.active_flag ? 'Y' : 'N'
        }
      }
      axios.put(`/ir/ajax/policy-group/update-active-flag`, params)
      .then(({data: response}) => {
        swal({
          title: "Success",
          text: 'บันทึกสำเร็จ',
          // timer: 3000,
          type: "success",
          // showCancelButton: false,
          // showConfirmButton: false
        })
      })
      .catch((error) => {
        swal({
          title: "Error",
          text: error.response.data.message,
          // timer: 3000,
          type: "error",
          // showCancelButton: false,
          // showConfirmButton: false
        })
      })
    },
    clickSearch(policy) {
      if (policy.group_header_id) {
        let policyGroup = {
          showIndex: false,
          row: policy
        }
        this.$emit('edit-policy', policyGroup)
        window.location.href = `/ir/settings/policy-group/edit/${policy.group_header_id}`
      } else {
        swal({
          title: "Warning",
          text: 'กรุณาบันทึกรหัสกรมธรรม์ก่อนทำการแก้ไข',
          timer: 3000,
          type: "warning",
        })
      }
    },
    save() {
      this.$refs.save_table_line.validate((valid) => {
        if (valid) {
            let params = {
              data: {
                rows: this.policies.filter(policy => {
                  policy.program_code = 'IRM0003'
                  if (policy.group_header_id === undefined) {
                    policy.group_header_id = ''
                    policy.active_flag ? policy.active_flag = 'Y' : 'N'
                  }
                  return policy
                })
              }
            }
            axios.post(`/ir/ajax/policy-group/save-index`, params )
            .then(res => {
              if (res.data.status == 'S') {
                this.loading = false
                swal({
                  title: "Success",
                  text: 'บันทึกสำเร็จ',
                  timer: 3000,
                  type: "success",
                  showCancelButton: false,
                  showConfirmButton: false
                })
                setTimeout(() => {
                  window.location.href = res.data.redirect_page
                }, 1000)
              }
            })
            .catch((error) => {
              swal({
                title: "Error",
                text: error.response.data.message,
                timer: 3000,
                type: "error",
                showCancelButton: false,
                showConfirmButton: false
              })
            }) 
          }
        // }
      })
    },
    clickDel() {
      // window.location.href = '/ir/settings/policy-group'
       
        this.itemLines = this.itemLines.filter( item => {
            return item.id != itemLine.id
        });
    },
    checkCodeDuplicate() {
      const vm = this
      let policy_code = JSON.parse(JSON.stringify(vm.data.policies.map(policy => policy.group_code)))
      let findDuplicates = (arr) => arr.filter((item, index) => arr.indexOf(item) != index)
      if (findDuplicates(policy_code).length > 0) {
        swal({
          title: "Warning",
          text:  'รหัสกรมธรรม์ห้ามซ้ำกับที่มีอยู่',
          timer: 3000,
          type: "warning",
        })
      }
    },
    remove(policy) {
      this.$emit("removeRow", policy);
    },
  },
  watch: {
    policies(newVal) {
      const vm = this
      vm.data.policies = newVal
    }
  }
}
</script>
<style scope>
  .el-form-item-irm0003{
    margin: 5px;
  }

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