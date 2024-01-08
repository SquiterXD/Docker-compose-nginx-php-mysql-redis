<template>
  <div class="modal inmodal fade" :id="`modal_soldd_car`" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">ขายรถ</p>
        </div>
        <el-form  :model="tableVehicle[tableVehicleindex]"
                  ref="form_soldd" 
                  label-width="120px" 
                  class="demo-dynamic form_table_line"
                  :rules="rules" >
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                วันที่ขายรถ
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="soldd_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`sold_date`"
                                  p-type="date"
                                  placeholder="วันที่ขายรถ"
                                  :value="tableVehicle[tableVehicleindex].sold_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueInsuranceExpireDate" />
                </el-form-item>
              </div>
             </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                    เหตุผล
                </label>
                <div class="col-md-6 el_field">
                     <el-form-item prop="reason">
                    <el-input placeholder="เหตุผล" 
                                v-model="tableVehicle[tableVehicleindex].reason"
                                :disabled="false" />
                    </el-form-item>
          </div>
        </div>
    </div>    
          <div class="modal-footer">
            <button type="button" 
                    class="btn btn-primary" 
                    @click="clickAgree()">
              <i class="fa fa-check-circle-o"></i> ตกลง
            </button>
          </div>
        </el-form>
      
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  export default {
    name: 'ir-settings-vehicle-modal-soldd',
    data () {
      return {
        rules: {
          sold_date: [
            {required: true, message: 'กรุณาระบุวันขาย', trigger: 'change'}
          ],
        //   license_plate_expire_date: [
        //     {required: true, message: 'กรุณาระบุวันสิ้นอายุ ป้ายทะเบียน', trigger: 'change'}
        //   ],
        //   acts_expire_date: [
        //     {required: true, message: 'กรุณาระบุวันสิ้นอายุ พรบ', trigger: 'change'}
        //   ],
        //   car_inspection_expire_date: [
        //     {required: true, message: 'กรุณาระบุวันสิ้นอายุ ตรวจสภาพ', trigger: 'change'}
        //   ]
        },
        // modal: this.expireDate
      }
    },
    props: [
      'vars',
      'soldd',
      'vehicle',
      'tableVehicleindex',
      'tableVehicle'
    ],
    methods: {
      clickAgree () {
            $(`#modal_soldd_car`).modal('hide');
            this.tableVehicle[this.tableVehicleindex].active_flag = false
            let data = {
              ...this.tableVehicle[this.tableVehicleindex],
                return_vat_flag: this.tableVehicle[this.tableVehicleindex].return_vat_flag ? 'Y' : 'N',
                active_flag: this.tableVehicle[this.tableVehicleindex].active_flag ? 'Y' : 'N',
                sold_flag: this.tableVehicle[this.tableVehicleindex].sold_flag ? 'Y' : 'N',
                program_code: 'IRM0007'
              }
              axios.put(`/ir/ajax/vehicles/sold-flag`, { data })
              .then(({data}) => {
                swal({
                  title: "Success",
                  text: data.message,
                  type: "success",
                  timer: 3000,
                  showConfirmButton: false,
                  closeOnConfirm: false
                });
              })
              .catch((error) => {
                swal("Error", error, "error");
              })
      },
      getValueInsuranceExpireDate (date) {
        let formatDate = this.vars.formatDate;
        if (date) {
          this.tableVehicle[this.tableVehicleindex].sold_date = moment(date).format(formatDate);
        } else {
          this.tableVehicle[this.tableVehicleindex].sold_date = '';
        }
      },
     
    }
  }
</script>
