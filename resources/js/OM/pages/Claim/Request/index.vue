<template>
  <div>
    <div class="row">
      <!-- Content -->
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <div class="row align-items-center">
              <div class="col-sm-12 col-lg-4 align-middle">
                <h4>ใบขอเปลี่ยนบุหรี่ชำรุด/เสียหาย หรือ ขาดบรรจุ</h4>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div class="col-xl-7">
              <!--form-group-->
              <form >
                <div class="form-group">
                  <h4 class="black mb-3">Parameter</h4>
                </div>
                <!-- End Parameter -->

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"
                    >รหัสร้านค้า</label
                  >
                  <div class="col-sm-9">
                    <el-select
                      @change="handleChangCusNumber"
                      filterable=""
                      v-model="filter.customer_number"
                      placeholder="เลือกรหัสร้านค้า"
                    >
                      <el-option
                        v-for="(cus) in customer_list"
                        :key="cus.customer_id"
                        :label="cus.customer_number"
                        :value="cus.customer_id"
                      >
                      </el-option>
                    </el-select>
                  </div>
                </div>
                <!-- End form-group row -->

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label"
                    >เลขที่ใบเคลม<span class="is-invalide">*</span></label
                  >
                  <div class="col-sm-9">
                    <el-select v-model="filter.claim_number" :class="(validate.claim_number ? 'is-valide' : '')" filterable placeholder="เลือกเลขที่ใบเคลม">
                      <el-option
                        v-for="(item, index) in claim_no"
                        :key="index"
                        :label="item.claim_number"
                        :value="item.claim_header_id"
                      ></el-option>
                    </el-select>
                  </div>
                </div>
                <!-- End form-group row -->

                <div class="form-group">
                  <h4 class="black mb-3">โปรดระบุ</h4>
                </div>
                <!-- End Parameter -->

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"
                    >กอง</label
                  >
                  <div class="col-sm-9">กองลูกค้าสัมพันธ์</div>
                </div>
                <!-- End form-group row -->

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"
                    >ฝข.
                  </label>
                  <div class="col-sm-9">
                    <input v-model="filter.fl" type="text" class="form-control" />
                  </div>
                </div>
                <!-- End form-group row -->

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"
                    >ลงวันที่ <span class="is-invalide">*</span></label
                  >
                  <div class="col-sm-9">
                    <datepicker-th
                      v-model="date"
                      @dateWasSelected="handleChangeDate"
                      style="width: 100%"
                      :class="'form-control '+(validate.signIt ? 'is-valide' : '')"
                      placeholder="วันส่งประจำงวด"
                      format="DD/MM/Y"
                    ></datepicker-th>
                  </div>
                </div>
                <!-- End form-group row -->

                <div class="form-group">
                  <h4 class="black mb-3">โปรดเลือกผู้ทำการ</h4>
                </div>
                <!-- End Parameter -->

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"
                    >ลงชื่อรับเรื่อง <span class="is-invalide">*</span></label
                  >
                  <div class="col-sm-9">
                    <el-select 
                    v-model="filter.signIt"
                    :class="(validate.signIt ? 'is-valide' : '')"
                    filterable placeholder="เลือกลงชื่อรับเรื่อง">
                      <el-option
                        v-for="(item, index) in authority_list"
                        :key="index"
                        :label="item.employee_name"
                        :value="item.authority_id"
                      ></el-option>
                    </el-select>
                  </div>
                </div>
                <!-- End form-group row -->
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"
                    >&nbsp;</label
                  >
                  <div class="col-sm-9">
                    <el-select
                    v-model="filter.signDep"
                    filterable>
                      <el-option
                        v-for="(item, index) in acting_pos"
                        :key="index"
                        :label="item.meaning"
                        :value="item.lookup_code"
                      ></el-option>
                    </el-select>
                  </div>
                </div>

                <div class="form-group">
                  <button type="button" @click="handdlePrint" :class="btn_trans.print.class">
                    <i :class="btn_trans.print.icon">&nbsp;</i>
                    {{ btn_trans.print.text }}
                  </button>
                </div>
                <!-- End form-group row -->
              </form>
              <!--form-group-->
            </div>

            <!--col-xl-12-->
          </div>
          <!--ibox-content-->
        </div>
      </div>
      <!-- End Content -->
    </div>
  </div>
</template>
<style scoped>
.form-group {
  margin-bottom: 1rem;
}
.is-valide {
  color: red;
  border:1px solid red;
}


</style>

<script>
import axios from "axios";

export default {
  props: {
    btn_trans     : { type: Object },
    url_ajax      : { type: Object },
    customer_list : { type: Object },
    authority_list: { type: Object },
    acting_pos    : { type: Object }
  },
  mounted() {
  },
  data() {
    return {
      filter: {
        customer_number: "", // รหัสร้านค้า
        claim_number   : "", //เลขที่ใบเคลม *
        fl             : "", // ฝข. 
        date           : "", // ลงวันที่ *
        signIt         : "", // ลงชื่อรับเรื่อง *
        signDep        : "",
      },
      validate : {
        customer_number: false,
        claim_number   : false, //เลขที่ใบเคลม *
        fl             : false, // ฝข. 
        date           : false, // ลงวันที่ *
        signIt         : false, // ลงชื่อรับเรื่อง *
        signDep        : false,
      },
      claim_no: [],
    };
  },
  methods: {
    loading() {
      const loading = this.$loading({
        lock: true,
        text: "Loading",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)",
      });
      return loading;
    },
    handdlePrint() {
      let el = this.filter;
      let invalid = false;

      if(el.claim_number == '') {
        this.validate.claim_number = true
                  invalid = true;
      }else {
        this.validate.claim_number = false
      }

      if(el.date == '') {
        this.validate.date = true
        invalid = true;
      } else {
        this.validate.date = false
      }
      
      if(el.signIt == '') {
        this.validate.signIt = true
        invalid = true;
      } else {
        this.validate.signIt = false
      }

      if(invalid == true) return false;
      window.open(this.url_ajax.link_pdf+ "?" + $.param(this.filter));
    },
    handleChangeDate(el, i) {
      let date = new Date(el)
      this.filter.date =  (date.getFullYear() - 543) +"-"+ (date.getMonth() +1  )+ "-"+ date.getDate()
    },
    async takeDataClaimNo() {
      await axios
        .post(this.url_ajax.take_claim_number, {
          customer_number: this.filter.customer_number,
        })
        .then((result) => {
          // has error
          if (result.status !== 200)
            return this.$notify({
              text: "ไม่สามารถทำรายการได้ในขณะนี้",
              type: "warning",
            });

          // bind claim_number
          this.claim_no= result.data
        })
        .catch((ex) => {
          this.$notify({
            text: "ไม่สามารถทำรายการได้ในขณะนี้",
            type: "warning",
          });
        });
    },
    async handleChangCusNumber(el) {
      console.log(el);
      // set loading
      const loading = this.loading();

      // take data claim_no
      await this.takeDataClaimNo();

      // set close loading
      loading.close();
    },
  },
};
</script>