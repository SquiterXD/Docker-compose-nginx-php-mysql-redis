<template>
  <div class="table-responsive margin_top_20">
    <table class="table table-bordered"
            :style="`${tableCompany.length === 0 ? '' : 'display: block; overflow: auto; max-height: 500px;'}`">
      <thead>
        <tr>
          <th style="min-width: 200px; width: 25%;" class="text-center">Code <br>รหัส</th>
          <th style="min-width: 200px; width: 50%;" class="text-center">Name <br>ชื่อ</th>
          <th style="min-width: 150px; width: 25%; vertical-align: middle;" class="text-center">Active</th>
          <th style="min-width: 150px; width: 25%; vertical-align: middle;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-show="tableCompany.length > 0" 
            v-for="(data, index) in tableCompany" 
            :key="index">
          <td class="text-center">{{isNullOrUndefined(data.company_number)}}</td>
          <td>{{isNullOrUndefined(data.company_name)}}</td>
          <td class="text-center">
            <div  class="form-check"
                  style="position: inherit;">
              <input  :class="`form-check-input table_company_active${index}`" 
                      type="checkbox"
                      @change="changeChecked(data, index)"
                      v-model="data.active_flag"
                      style="position: inherit;">
            </div>
          </td>
          <td class="text-center">
            <a  type="button" 
                :href="`/ir/settings/company/edit/${data.company_id}`"
                :class="btnTrans.edit.class+' btn-sm tw-w-25'">
              <i :class="btnTrans.edit.icon"></i> {{ btnTrans.edit.text }}
            </a>
          </td>
        </tr>
        <tr class="text-center" 
            v-if="tableCompany.length === 0">
          <td colspan="4">ไม่มีข้อมูล</td>
        </tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-company-table',
  data () {
    return {}
  },
  props: [
    'isNullOrUndefined',
    'tableCompany',
    'setDefaultActive'
    ,'btnTrans'
  ],
  methods: {
    changeChecked (dataRow, index) {
      let _this = this;
      let data = {
        ...dataRow,
        active_flag: dataRow.active_flag ? 'Y' : 'N'
      }
      axios.put(`/ir/ajax/company/active-flag`, { data })
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          // timer: 3000,
          // showConfirmButton: false,
          // closeOnConfirm: false
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
        } else {
          swal("Error", error, "error");
        }
      })
    }
  }
}
</script>
<style scoped>
  th, td {
    padding: 0.25rem;
  }
  th {
    background: white;
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
  }
</style>
