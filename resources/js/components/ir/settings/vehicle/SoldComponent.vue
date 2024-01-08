<template>
    <div>
        <el-form-item style="margin-bottom: 15px;">
            <input type="checkbox"
                    v-model="vehicle.sold_flag"
                    @change="clickModalSold"
                    :disabled="sold.reason != '' || disableFix" >
        </el-form-item>

      <!-- ----------------------------------------------------- -->
      <div class="modal inmodal fade" :id="`modal_sold_car`" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
              </button>
              <p class="modal-title text-left">ขายรถ</p>
            </div>
            <el-form  :model="sold"
                      ref="form_sold" 
                      label-width="120px" 
                      class="demo-dynamic form_table_line">
                      <!-- :rules="rules" -->
              <div class="modal-body">
                <div class="row">
                  <label class="col-md-5 col-form-label lable_align">
                    วันที่ขายรถ
                  </label>
                  <div class="col-md-6 el_field">
                    <el-form-item prop="sold_date">
                      <datepicker-th  style="width: 100%;"
                                      class="el-input__inner"
                                      :name="`sold_date`"
                                      p-type="date"
                                      placeholder="วันที่ขายรถ"
                                      :value="sold.sold_date"
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
                                    v-model="sold.reason"
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

    </div>
</template>

<script>

import moment from 'moment';

export default {
    props: ['vars', 'sold', 'vehicle', 'disableFix'],
    data () {
      return {
      }
    },
    methods: {
      clickModalSold() {
         
         
        this.vehicle.sold_flag = false;
        $('#modal_sold_car').modal('show');
         
      },
      clickAgree () {
         
        this.$refs.form_sold.validate((valid) => {
           
          if (valid) {
            this.sold.sold_flag = 'Y';
            this.$emit('sold', this.sold);
            $(`#modal_sold_car`).modal('hide');
          } else {
            return false;
          }
        })
      },
      getValueInsuranceExpireDate (date) {
        let formatDate = this.vars.formatDate;
        if (date) {
          this.sold.sold_date = moment(date).format(formatDate);
        } else {
          this.sold.sold_date = '';
        }
      },
     
    },
}
</script>