<template>
  <div>
    <el-form  :model="company"
              :rules="rules"
              ref="company"
              label-width="120px"
              class="demo-ruleForm">
      <div class="col-lg-11">
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>รหัส (Code) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="company_number">
              <el-input placeholder="รหัส"
                        v-model="company.company_number"
                        disabled
                        maxlength="50" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>ชื่อ (Name) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="company_name"
                          ref="company_name">
              <el-input placeholder="ชื่อ"
                        v-model="company.company_name"
                        disabled />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>ที่อยู่ (Address) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="company_address"
                          ref="company_address">
              <el-input placeholder="ที่อยู่"
                        v-model="company.company_address"
                        disabled />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>โทรศัพท์ (Telephone)</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <el-input placeholder="โทรศัพท์" 
                        v-model="company.company_telephone"
                        disabled />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>รหัสเจ้าหนี้ (Supplier Number) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="vendor_id">
              <!-- <lov-search url="vendor"
                          v-model="company.vendor_id"
                          placeholder="รหัสเจ้าหนี้"
                          attrName="vendor"
                          propCode="vendor_id"
                          propDesc="keyword"
                          @change-lov="getDataVendor"
                          propCodeDisp="vendor_number"
                          propDescDisp="vendor_name"
                          @id-not-match="notVendorId" /> -->
              <lov-supplier v-model="company.vendor_id"
                            name="vendor"
                            placeholder="รหัสเจ้าหนี้"
                            size=""
                            :popperBody="true"
                            @change-lov="getValueSupplier" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>รหัสสาขา (Branch Number) *</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="vendor_site_id"
                          ref="vendor_site_id">
              <el-select  v-model="company.vendor_site_id" 
                          placeholder="รหัสสาขา"
                          clearable
                          @change="changeBranch">
                          <!-- :disabled="disabledBranch" -->
                <el-option  v-for="(data, index) in branches"
                            :key="index"
                            :label="data.vendor_site_code"
                            :value="data.vendor_site_id">
                            <!-- branch_code -->
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>รหัสลูกหนี้ (Customer Number) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="customer_id">
              <!-- <lov-search url="customer-number"
                          v-model="company.customer_id"
                          placeholder="รหัสลูกหนี้"
                          attrName="customer"
                          propCode="customer_id"
                          propDesc="keyword"
                          @change-lov="getDataCustomer"
                          propCodeDisp="customer_number"
                          propDescDisp="customer_name"
                          @id-not-match="notCustomerId" /> -->
              <lov-customer v-model="company.customer_id"
                            name="customer"
                            placeholder="รหัสลูกหนี้"
                            size=""
                            :popperBody="true"
                            @change-lov="getValueCustomer" />
            </el-form-item>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-5"></label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item style="margin-bottom: 0px;">
              <input v-if="action === 'add'" type="checkbox"
                      id="active_flag"
                      name="active_flag"
                      v-model="company.active_flag">
              <input v-else type="checkbox"
                      id="active_flag"
                      name="active_flag"
                      v-model="company.active_flag"
                      class="form_company_active" >
                      <!-- @change="changeActiveFlag()" -->
              Active
            </el-form-item>
          </div>
        </div>
      </div>
      <div class="text-right">
        <!-- <el-form-item> -->
          <button type="button" :class="btnTrans.save.class+' btn-lg tw-w-25'" @click.prevent="clickSave()">
            <i :class="btnTrans.save.icon"></i>
            {{ btnTrans.save.text }}
          </button>
          <button type="button" :class="btnTrans.cancel.class+' btn-lg tw-w-25'" @click.prevent="clickCancel()">
            <i :class="btnTrans.cancel.icon"></i>
            {{ btnTrans.cancel.text }}
          </button>
        <!-- </el-form-item> -->
      </div>
    </el-form>
  </div>
</template>

<script>
import lovSearch from './lovSearch'
import lovSupplier from './lovSupplier'
import lovCustomer from './lovCustomer'
import * as scripts from '../../scripts'

export default {
  name: 'ir-settings-company-form',
  data () {
    return {
      rules: {
        company_number: [
          {required: true, message: 'กรุณาระบุรหัส', trigger: 'blur'}
        ],
        company_name: [
          {required: true, message: 'กรุณาระบุชื่อ', trigger: 'blur'}
        ],
        company_address: [
          {required: true, message: 'กรุณาระบุที่อยู่', trigger: 'blur'}
        ],
        vendor_id: [
          {required: true, message: 'กรุณาระบุรหัสเจ้าหนี้', trigger: 'change'}
        ],
        customer_id: [
          {required: true, message: 'กรุณาระบุรหัสลูกหนี้', trigger: 'change'}
        ],
        vendor_site_id: [
          {required: true, message: 'กรุณาระบุรหัสสาขา', trigger: 'change'}
        ]
      },
      branches: [],
      disabledBranch: true,
      funcs: scripts.funcs
    }
  },
  props: [
    'company',
    'action',
    'btnTrans'
  ],
  methods: {
    getDataVendor (value) {
      this.company.vendor_id = value
    },
    getDataBranch (vendor_id) {
      let params = { vendor_id: vendor_id }
      axios.get(`/ir/ajax/lov/branch-code`, { params })
      .then(({data}) => {
        this.disabledBranch = false
        this.branches = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataCustomer (value) {
      this.company.customer_id = value
    },
    clickSave() {
      this.$refs.company.validate((valid) => {
        if (valid) {
          let params = {
            vendor_id: this.company.vendor_id,
            customer_id: this.company.customer_id,
            vendor_site_id: this.company.vendor_site_id
          }
           
          this.actionSave(this.action)
        } else {
           
          return false;
        }
      })
    },
    clickCancel () {
      window.location.href = '/ir/settings/company'
    },
    actionSave (action) {
      if (action === 'add' || action === 'edit') {
        active_flag = this.company.active_flag === true ? 'Y' : 'N';
      } else {
        let checked = $(`.form_company_active`).is(':checked');
        active_flag = checked ? 'Y' : 'N';
      }
      let active_flag = this.company.active_flag === true ? 'Y' : 'N';
      let params = {
        ...this.company,
        active_flag: this.company.active_flag,
        vendor_id: this.company.vendor_id,
        customer_id: this.company.customer_id,
        company_id:this.company.company_id
        // program_code: 'IRP0001',
        // vendor_site_id: this.company.branch_code
      }
       
      if (action === 'add') {
         axios.get(`/ir/ajax/check-duplicate/company`, {params})
        .then(({params}) => {
          // swal({
          //   title: "Success",
          //   text: data.message,
          //   type: "success",
          //   showConfirmButton: false,
          //   closeOnConfirm: false
          // });
          // window.location.href = '/ir/settings/company'
              let data = {
                ...this.company,
                active_flag: this.company.active_flag,
                program_code: 'IRP0001',
                // vendor_site_id: this.company.branch_code
              }
            axios.post(`/ir/ajax/company`, { data })
            .then(({data}) => {
              // swal({
              //   title: "Success",
              //   text: data.message,
              //   type: "success",
              //   showConfirmButton: false,
              //   closeOnConfirm: false,
              //   timer: 5000
              // })
              // setTimeout(() =>  { 
              //   window.location.href = '/ir/settings/company'
              // }, 5000)
              // // window.location.href = '/ir/settings/company'

              swal({
                  title: "Success",
                  text: data.message,
                  type: "success",
                  showConfirmButton: true,
              }, (isConfirm) => {
                  window.location.href = '/ir/settings/company';
              });
            })
            .catch((error) => {
              if (error.response.data.status === 400) {
                swal("Warning", error.response.data.message, "warning");
              } else {
                swal("Error", error, "error");
              }
            })
            })
        .catch((error) => {
          if (error.response.data.status === 400) {
            swal("Warning", error.response.data.message, "warning");
          } else {
            swal("Error", error, "error");
          }
        })
        // axios.post(`/ir/ajax/company`, { data })
        // .then(({data}) => {
        //   swal({
        //     title: "Success",
        //     text: data.message,
        //     type: "success",
        //     showConfirmButton: false,
        //     closeOnConfirm: false
        //   });
        //   window.location.href = '/ir/settings/company'
        // })
        // .catch((error) => {
        //   if (error.response.data.status === 400) {
        //     swal("Warning", error.response.data.message, "warning");
        //   } else {
        //     swal("Error", error, "error");
        //   }
        // })
      } else {
        // axios.put(`/ir/ajax/company`, { data })
        // .then(({data}) => {
        //   swal({
        //     title: "Success",
        //     text: data.message,
        //     type: "success",
        //     showConfirmButton: false,
        //     closeOnConfirm: false
        //   });
        //   window.location.href = '/ir/settings/company'
        // })
        // .catch((error) => {
        //   swal("Error", error, "error");
        // })
          let data = {
                ...this.company,
                active_flag: this.company.active_flag,
                program_code: 'IRP0001',
                // vendor_site_id: this.company.branch_code
              }
            axios.put(`/ir/ajax/company`, { data })
            .then(({data}) => {
              // swal({
              //   title: "Success",
              //   text: data.message,
              //   type: "success",
              //   showConfirmButton: false,
              //   closeOnConfirm: false,
              //   timer: 5000
              // })
              //  setTimeout(() => { 
              //    window.location.href = '/ir/settings/company'
              //  }, 5000)
              // // window.location.href = '/ir/settings/company'

              swal({
                  title: "Success",
                  text: data.message,
                  type: "success",
                  showConfirmButton: true,
              }, (isConfirm) => {
                  window.location.href = '/ir/settings/company';
              });
            })
            .catch((error) => {
              if (error.response.data.status === 400) {
                swal("Warning", error.response.data.message, "warning");
              } else {
                swal("Error", error, "error");
              }
            })
      }
    },
    notVendorId (value) {
      this.company.vendor_id = value
    },
    notCustomerId (value) {
      this.company.customer_id = value
    },
    changeBranch (value) {
       
      if (value) {
        for (let i in this.branches) {
          let row = this.branches[i];
          // branch_code
          if (row.vendor_site_id == value) {
            this.company.company_name = row.vendor_name
            this.company.company_address = row.vendor_address
            this.company.company_telephone = row.vendor_telephone
            this.$refs.company_name.clearValidate()
            this.$refs.company_address.clearValidate()
          }
        }
      }
    },
    getValueSupplier (obj) {
       
      this.company.vendor_id = obj.id
      if (!obj.id) {
        this.company.vendor_site_id = ''
        this.company.company_name = ''
        this.company.company_address = ''
        this.company.company_telephone = ''
        this.branches = [];
      }
    },
    getValueCustomer (obj) {
       
      this.company.customer_id = obj.id
    },
    changeActiveFlag () {
       
      // let _this = this;
      axios.put(`/ir/ajax/company/check-used-data/${ this.company.company_id}`)
      .then(({data}) => {
         
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
             this.funcs.setDefaultActive(`form_company_active`);
            }
          });
        } else {
          swal("Error", error, "error");
        }
      })
    }
  },
  components: {
    lovSearch,
    lovSupplier,
    lovCustomer
  },
  watch: {
    'company.vendor_id' (newVal, oldVal) {
       
      if (newVal) {
        this.getDataBranch(newVal)
      } else {
        this.disabledBranch = true
        this.company.vendor_site_id = ''
      }
    },
    // 'company.active_flag' (newVal, oldVal) {
    //   if (newVal === 'Y') {
    //     this.company.active_flag = 'Y'
    //   } else {
    //     this.company.active_flag = 'N'
    //   }
    // }
  }
}
</script>
