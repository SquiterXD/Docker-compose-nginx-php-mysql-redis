<template>
  <div>
    <h5>รายละเอียดการเกิดเหตุ</h5>
    <el-form  :model="claim"
              ref="claim_insurance" 
              label-width="120px" 
              :rules="rules"
              class="demo-ruleForm margin_top_20">
      <div class="col-lg-12">
        <!-- ** HEADERS **  -->
        <div class="headers">
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>วันที่เกิดเหตุ *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="headers.accident_date">
                <!-- <date-input attrName="accident_date"
                            v-model="claim.headers.accident_date"
                            @change-date="getAccidentDate"
                            :sizeSmall="false"
                            placeholder="วันที่เกิดเหตุ"
                            :disabled="checkStatusInterface(claim.headers.status)" /> -->
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner"
                              :name="`accident_date`"
                              p-type="date"
                              placeholder="วันที่เกิดเหตุ"
                              v-model="claim.headers.accident_date"
                              :format="vars.formatDate"
                              @dateWasSelected="getValueAccidentDate"
                              :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"  />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>เวลาเกิดเหตุ *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="headers.accident_time">
              <el-time-picker v-model="claim.headers.accident_time" 
                              style="width: 100%;"
                              placeholder="เวลาเกิดเหตุ"
                              :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"
                              value-format="HH:mm" />
                              <!-- value-format="HH:mm:ss" -->
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>สถานที่ *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="headers.location_name">
                <el-input placeholder="สถานที่"
                          name="location_name"
                          v-model="claim.headers.location_name"
                          :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)" />
                <!-- <lov-location placeholder="สถานที่"
                              attrName="location_name"
                              v-model="claim.headers.location_name"
                              :disabled="checkStatusInterface(claim.headers.status)" /> -->
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>หน่วยงาน *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="headers.department_code">
                <lov-department placeholder="หน่วยงาน"
                                attrName="department_code" 
                                v-model="claim.headers.department_code"
                                @change-lov="getDataDepartment"
                                :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ผู้แจ้งเหตุ *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="headers.requestor_name">
                <el-input placeholder="ผู้แจ้งเหตุ" 
                          v-model="claim.headers.requestor_name"
                          :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>เบอร์โทรผู้แจ้งเหตุ *</strong>
            </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="headers.requestor_tel">
                <el-input placeholder="เบอร์โทรผู้แจ้งเหตุ"
                          v-model="claim.headers.requestor_tel"
                          :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>จำนวนเงินเรียกชดใช้รวม</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item>
                <currency-input-group-append  placeholder="จำนวนเงินเรียกชดใช้รวม"
                                              name="claim_amount"
                                              :disabled="true"
                                              v-model="claim.headers.claim_amount"
                                              :sizeSmall="false"
                                              :showAppend="true"
                                              wordingAppend="THB"
                                              inputClass="text-right" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>Attachments (ไฟล์แนบ)</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item class="display_none_el_icon_close_tip">
                <el-upload  class="upload-demo"
                            ref="upload_claim"
                            name="file[]"
                            action=""
                            :on-change="onchange"
                            :file-list="fileList"
                            multiple
                            :on-remove="onRemove"
                            :data="claim" 
                            :auto-upload="false"
                            :before-remove="beforeRemove"
                            :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"> 
                  <!-- 
                            list-type="text"
                            :http-request="UploadImage"
                  list-type="picture-card"
                  :before-upload="onBeforeUploadImage"-->
                  <el-button  size="small" 
                              type="primary"
                              :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)">
                    Click to upload
                  </el-button>
                  <!-- <div slot="tip" class="el-upload__tip">Can only upload jpg/jpeg/png files and no more than 500kb</div> -->
                </el-upload>
              </el-form-item>
            </div>
          </div>
        </div>
        <!-- ** HEADERS **  -->

        <div class="row margin_top_20 text-right">
          <div class="col-md-12">
            <button type="button" 
                    class="btn btn-success" 
                    @click="clickCreateClaimGroup()"
                    :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)">
              <i class="fa fa-plus"></i> เพิ่ม
            </button>
          </div>
        </div>
        <el-form  :model="claim"
                  ref="claim_apply_companies" 
                  label-width="120px" 
                  class="demo-ruleForm"
                  style="padding-top: 30px">
          <div  v-show="claim.group.length > 0"
                v-for="(data, index) in claim.group" 
                :key="index"
                style="margin-bottom: 20px;"
                class="el_field_table">
                   <div style="display: block;
                        width: 100%;
                        overflow-x: auto;
                        height: 135px;">
                  <!-- v-show="claim.group.length > 0"  -->
              <policy-header-form />
               
              <div  class="el_field_table"
                    style="display: flex;">
                <el-form-item :prop="'group.' + index + '.group_description'"
                              :rules="rules.group"
                              style="margin-bottom: 0px; 
                              width: 25%; 
                              padding: 12px;"
                              class="media_claim_col">
                  <lov-policy-group v-model ="data.group_header_id" 
                                    :name="`group_description${index}`"
                                    size=""
                                    placeholder= "กลุ่มกรมธรรม์"
                                    :popperBody="true" 
                                    :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"
                                    @change-lov="getPolicyCode(...arguments, index)" />
                </el-form-item>
                <el-form-item style="margin-bottom: 0px; 
                              width: 25%; 
                              padding: 12px;"
                              class="media_claim_col"
                              :prop="'group.' + index + '.group_description'"
                              :rules="rules.group.group_description">
                <lov-policy-set-header-id v-model="data.policy_set_header_id"
                                          :name="`group_description${index}`"
                                          size=""
                                          placeholder="ชุดกรมธรรม์"
                                          :popperBody="true"
                                          :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"
                                          @change-lov="getPolicySetHeaderId(...arguments, index)"
                                          :group_header_id="data.group_header_id" />
                                          <!-- data.flag === 'edit' || checkStatusInterface(claim.headers.status) ? true : false
                                          @input="getClaimAmountCompany(data.claim_amount, index)"  -->
                </el-form-item>
                <el-form-item :prop="'group.' + index + '.amount'"
                              :rules="rules.group.amount"
                              style="margin-bottom: 0px; 
                              width: 25%; 
                              padding: 12px;"
                              class="media_claim_col">
                   <currency-input v-model="data.amount"
                                  :name="`amount${index}`"
                                  :sizeSmall="false"
                                  @input="getDataAmount(...arguments, index)"
                                  placeholder="จำนวนเงินเรียกชดใช้"
                                  :disabled="checkStatusInterface(claim.headers.status)|| checkStatusConfirmed(claim.headers.status) || checkStatusCancelled(claim.headers.status)"/> 
                                   <!-- @watch-value="watchClaimAmountCompany(...arguments, index)" />  -->
                                  <!-- data.flag === 'edit' || checkStatusInterface(claim.headers.status) ? true : false
                                  @input="getClaimAmountCompany(data.claim_amount, index)"  -->
                </el-form-item>
                <el-form-item  style="margin-bottom: 0px; 
                                    width: 25%; 
                                    padding: 12px;
                                    text-align: center;"
                                    v-if="data.flag === 'add' || data.flag === 'edit'"
                                    class="media_claim_col">
                      <button type="button"
                              class="btn btn-danger"
                              @click="clickRemoveGroup(data, index)"
                              :disabled="checkStatusInterface(claim.headers.status) || checkStatusInterface(claim.headers.status) || checkStatusConfirmed(claim.headers.status) || checkStatusCancelled(claim.headers.status)">
                        <i class="fa fa-times"></i> ลบ
                      </button>
                </el-form-item>
              </div>
            </div>
            <div  class="row margin_top_20 text-right"
                  v-if="claim.group.length > 0">
              <div class="col-md-12">
                <el-form-item :prop="`group.${index}.company`"
                              :rules="rules.companies"
                              style="float: right;">
                  <button type="button" 
                          class="btn btn-success" 
                          @click="clickCreateApplyCompanies(index,data)"
                          :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)">
                    <i class="fa fa-plus"></i> เพิ่มรายการเคลม
                  </button>
                </el-form-item>
              </div>
            </div>
            <el-form  :model="data"
                      ref="companies"
                      label-width="120px" 
                      class="demo-ruleForm">
                      <!-- {{data.company}} -->
              <div  v-for="(comp, index_comp) in data.company"
                    :key="index_comp">

                <div  style="display: block;
                      width: 100%;
                      overflow-x: auto;
                      height: 135px;">
                  <header-form />
                    
                  <div  class="el_field_table"
                        style="display: flex;">
                    <el-form-item style="margin-bottom: 0px; 
                                  width: 25%; 
                                  padding: 12px;"
                                  class="media_claim_col"
                                  :prop="'company.' + index_comp + '.company_id'"
                                  :rules="rules.group.company.company_id">
                      <lov-company  placeholder="บริษัทประกันภัย"
                                    :attrName="`company_id${index_comp}`"
                                    v-model="comp.company_id"
                                    :index="index_comp"
                                    @change-lov="getDataCompany(...arguments, index_comp, index)"
                                    :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"
                                    :resData="resData"
                                    v-if="data.showLovCompany" />
                      <lov-company-policy-group  placeholder="บริษัทประกันภัย"
                                                :attrName="`company_id_policy_group${index_comp}`"
                                                v-model="comp.company_name"
                                                :index="index_comp"
                                                @change-lov="getDataCompanyPolicyGroup(...arguments, index_comp, index)"
                                                :disabled="checkStatusInterface(claim.headers.status) || !data.showLovCompany || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"
                                                :group_header_id="data.group_header_id"
                                                :year="claim.headers.year"
                                                v-if="!data.showLovCompany" 
                                                @response-company-percent="getValueCompaniesPercent(...arguments, index, index_comp)" /> 
                    </el-form-item>
                    <el-form-item style="margin-bottom: 0px; 
                                  width: 25%; 
                                  padding: 12px;"
                                  class="media_claim_col"
                                  :prop="'company.' + index_comp + '.claim_percent'"
                                  :rules="rules.group.company.claim_percent">
                      <el-input placeholder="สัดส่วน (%)"
                                :name="`claim_percent${index_comp}`"
                                v-model.number="comp.claim_percent"
                                @change="changePercent(...arguments, index_comp, index)"
                                class="currency_right"
                                :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)"
                                type="age"
                                autocomplete="off" />
                    </el-form-item>
                    <el-form-item style="margin-bottom: 0px; 
                                  width: 25%; 
                                  padding: 12px;"
                                  class="currency_right media_claim_col"
                                  :prop="'company.' + index_comp + '.claim_amount'"
                                  :rules="rules.group.company.claim_amount">
                      <currency-input v-model="comp.claim_amount"
                                      :name="`claim_amount${index_comp}`"
                                      :sizeSmall="false"
                                      placeholder="จำนวนเงิน"
                                      :disabled="true"
                                      @watch-value="watchClaimAmountCompany(...arguments, index_comp, index)" />
                    </el-form-item>
                    <el-form-item  style="margin-bottom: 0px; 
                                    width: 25%; 
                                    padding: 12px;
                                    text-align: center;"
                                    v-if="data.flag === 'add' || data.flag === 'edit' "
                                    class="media_claim_col">
                      <button type="button"
                              class="btn btn-danger"
                              @click="clickRemove(comp, index_comp, index)"
                              :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status) ">
                        <i class="fa fa-times"></i> ลบ
                      </button>
                    </el-form-item>
                  </div>
                </div>
                <div class="row margin_top_20 text-right">
                  <div class="col-md-12">
                    <button type="button" 
                            class="btn btn-success" 
                            @click="clickAddDetails(comp, index_comp)"
                            :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)">
                      <i class="fa fa-plus"></i> เพิ่มรายการ
                    </button>
                  </div>
                </div>
                <el-form-item >
                  <el-form  :model="comp"
                            ref="claim_apply_details" 
                            label-width="120px" 
                            class="demo-dynamic"
                            v-model="comp.detail">
                    <div class="table-responsive margin_top_20">
                      <table  class="table table-bordered"
                              style="display: block; overflow: auto; max-height: 240px;">
                        <thead>
                          <tr class="text-center">
                            <th style="min-width: 80px; width: 1%;">ลำดับ</th>
                            <th style="min-width: 250px; width: 65%; z-index: 1;">รายละเอียด *</th>
                            <th style="min-width: 150px; width: 25%; z-index: 1;">จำนวนเงิน *</th>
                            <th style="min-width: 130px; width: 10%; z-index: 1;">ลบ</th>
                          </tr>
                        </thead>
                        <tbody  id="table_details">
                          <tr v-show="comp.detail.length > 0"
                              v-for="(detail, index_detail) in comp.detail"
                              :key="index_detail">
                            <td style="text-align: center;
                                vertical-align: middle;">
                              {{isNullOrUndefined(detail.line_number)}}
                            </td>
                            <td class="el_field_table"
                                :style="`${detail.flag === 'edit' ? 'vertical-align: middle;' : ''}`">
                              <span v-if="detail.flag !== 'add'">
                                {{isNullOrUndefined(detail.line_description)}}
                              </span>
                              <el-form-item v-else>
                                <el-input placeholder="รายละเอียด" 
                                          v-model="detail.line_description"
                                          size="small"
                                          :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)" />
                              </el-form-item>
                            </td>
                            <td class="el_field_table">
                              <el-form-item style="margin-bottom: 10px;">
                                <currency-input v-model="detail.line_amount"
                                                :name="`line_amount${index_detail}`"
                                                :sizeSmall="true"
                                                placeholder="จำนวนเงิน"
                                                :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)" />
                              </el-form-item>
                            </td>
                            <td>
                              <el-form-item  class="text-center"
                                              v-if="detail.flag === 'add' ||  data.flag === 'edit'">
                                <button type="button"
                                        class="btn btn-danger btn-sm"
                                        @click="clickRemoveDetails(comp, detail, index_detail)"
                                        :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)">
                                  <i class="fa fa-times"></i> ลบ
                                </button>
                              </el-form-item>
                            </td>
                          </tr>
                          <tr class="text-center" v-if="comp.detail.length === 0"><td colspan="4">ไม่มีข้อมูล</td></tr>
                        </tbody>
                        <tfoot></tfoot>
                      </table>
                    </div>
                  </el-form>
                </el-form-item>
                <div class="row text-right">
                  <div class="col-md-12">
                    <el-form-item style="float: right;
                                  width: 145px;">
                                  <!-- :prop="'company.' + index + '.req_modal'"
                                  :rules="rules.req_modal" -->
                      <button type="button" 
                              class="btn btn-default" 
                              @click="clickModalDetails(comp, index_comp, 0)"
                              data-toggle="modal"
                              :data-target="`#modal_details${index_comp}`"
                              :value="comp.req_modal"
                              :name="`modal_details${index_comp}`">
                        <i class="fa fa-file-text-o"></i> รายละเอียด
                      </button>
                    </el-form-item>
                  </div>
                </div>
              </div>
              <!-- <div class="row margin_top_20 text-right">
              <div class="col-md-12">
                <button type="button" 
                        class="btn btn-success" 
                        @click="clickAddDetails(data, index)"
                        :disabled="checkStatusInterface(claim.headers.status)">
                  <i class="fa fa-plus"></i> เพิ่มรายการ
                </button>
              </div>
            </div>
            <el-form-item >
              <el-form  :model="comp"
                        ref="claim_apply_details" 
                        label-width="120px" 
                        class="demo-dynamic"
                        v-model="comp.detail">
                <div class="table-responsive margin_top_20">
                  <table  class="table table-bordered"
                          style="display: block; overflow: auto; max-height: 240px;">
                    <thead>
                      <tr class="text-center">
                        <th style="min-width: 80px; width: 1%;">ลำดับ</th>
                        <th style="min-width: 250px; width: 65%; z-index: 1;">รายละเอียด *</th>
                        <th style="min-width: 150px; width: 25%; z-index: 1;">จำนวนเงิน *</th>
                        <th style="min-width: 130px; width: 10%; z-index: 1;">ลบ</th>
                      </tr>
                    </thead>
                    <tbody  id="table_details">
                      <tr v-show="comp.detail.length > 0"
                          v-for="(detail, index_detail) in comp.detail"
                          :key="index_detail">
                        <td style="text-align: center;
                            vertical-align: middle;">
                          {{isNullOrUndefined(detail.line_number)}}
                        </td>
                        <td class="el_field_table"
                            :style="`${detail.flag === 'edit' ? 'vertical-align: middle;' : ''}`">
                          <span v-if="detail.flag !== 'add'">
                            {{isNullOrUndefined(detail.line_description)}}
                          </span>
                          <el-form-item v-else>
                            <el-input placeholder="รายละเอียด" 
                                      v-model="detail.line_description"
                                      size="small"
                                      :disabled="checkStatusInterface(claim.headers.status)" />
                          </el-form-item>
                        </td>
                        <td class="el_field_table">
                          <el-form-item style="margin-bottom: 10px;">
                            <currency-input v-model="detail.line_amount"
                                            :name="`line_amount${index_detail}`"
                                            :sizeSmall="true"
                                            placeholder="จำนวนเงิน"
                                            :disabled="checkStatusInterface(claim.headers.status)" />
                          </el-form-item>
                        </td>
                        <td>
                          <el-form-item  class="text-center"
                                          v-if="detail.flag === 'add'">
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    @click="clickRemoveDetails(comp, detail, index_detail)">
                              <i class="fa fa-times"></i> ลบ
                            </button>
                          </el-form-item>
                        </td>
                      </tr>
                      <tr class="text-center" v-if="comp.detail.length === 0"><td colspan="4">ไม่มีข้อมูล</td></tr>
                    </tbody>
                    <tfoot></tfoot>
                  </table>
                </div>
              </el-form>
            </el-form-item>
            <div class="row text-right">
              <div class="col-md-12">
                <el-form-item :prop="'group.' + index + '.req_modal'"
                              :rules="rules.req_modal"
                              style="float: right;
                              width: 145px;">
                  <button type="button" 
                          class="btn btn-default" 
                          @click="clickModalDetails(data, index)"
                          data-toggle="modal"
                          :data-target="`#modal_details${index}`"
                          :value="data.req_modal"
                          :name="`modal_details${index}`">
                    <i class="fa fa-file-text-o"></i> รายละเอียด
                  </button>
                </el-form-item>
              </div>
            </div> -->
            </el-form>
          </div>
          <div  v-if="claim.group.length === 0"
                style="text-align: center;
                display: block;
                width: 100%;
                overflow-x: auto;
                height: 135px;">
            <policy-header-form /> 
           
            <div  style="padding: 20px;"
                  class="media_claim_no_data_align_end">
              ไม่มีข้อมูล
            </div>
          </div>
        </el-form>
        <div class="row margin_top_20">
          <div class="col-md-12 lable_align el_field">
            <el-form-item>
              <button type="button" class="btn btn-primary" @click="clickSave()">
                <i class="fa fa-save"></i> บันทึก
              </button>
              <button type="button" class="btn btn-danger" @click="clickCancel()">
                <i class="fa fa-times"></i> ยกเลิก
              </button>
              <button type="button" 
                      class="btn btn-primary" 
                      @click="clickConfirm()"
                      :disabled="checkStatusInterface(claim.headers.status) || checkStatusConfirmed (claim.headers.status) || checkStatusCancelled(claim.headers.status)">
                <i class="fa fa-check"></i> ยืนยัน
              </button>
            </el-form-item>
          </div>
        </div>
      </div>
    </el-form>
    <modal-details  :details="details"
                    :index="index_comp"
                    :status="claim.headers.status"
                    :checkStatusInterface="checkStatusInterface"
                    :checkStatusConfirmed="checkStatusConfirmed"
                    :checkStatusCancelled="checkStatusCancelled"
                    @modal-details="getDataModalDetails"
                    :vars="vars" />
  </div>
</template>

<script>
import lovDepartment from './lovDepartment'
import currencyInputGroupAppend from '../components/currencyInputGroupAppend'
import lovCompany from './lovCompany'
import lovLocation from './lovLocation'
import dateInput from '../components/calendar/dateInput'
import modalDetails from './modalDetails'
import currencyInput from '../components/currencyInput'
import headerForm from './headerForm'
import policyHeaderForm from './policyHeaderForm'
import lovPolicyGroup from './lovPolicyGroup'
import lovPolicySetHeaderId from './lovPolicySetHeaderId'
import lovCompanyPolicyGroup from './lovCompanyPolicyGroup'
import moment from 'moment'
export default {
  name: 'ir-claim-insurance-form',
  data () {
    return {
      rules: {
        headers: {
          accident_date: [
            {required: true, message: 'กรุณาระบุวันที่เกิดเหตุ', trigger: 'blur'}
          ],
          accident_time: [
            {required: true, message: 'กรุณาระบุเวลาเกิดเหตุ', trigger: 'blur'}
          ],
          location_name: [
            {required: true, message: 'กรุณาระบุสถานที่', trigger: 'blur'}
          ],
          department_code: [
            {required: true, message: 'กรุณาระบุหน่วยงาน', trigger: 'change'}
          ],
          requestor_name: [
            {required: true, message: 'กรุณาระบุผู้แจ้งเหตุ', trigger: 'change'}
          ],
          requestor_tel: [
            {required: true, message: 'กรุณาระบุเบอร์โทรผู้แจ้งเหตุ', trigger: 'change'}
          ],
          claim_amount: [
            {required: true, message: 'กรุณาระบุจำนวนเงินเรียกชดใช้รวม', trigger: 'change'}
          ]
        },
        group: {
          company: [{
            company_id: [
              {required: true, message: 'กรุณาระบุบริษัทประกันภัย', trigger: 'change'}
            ],
            claim_percent: [
              {required: true, message: 'กรุณาระบุสัดส่วน', trigger: 'change'},
              {type: 'number', message: 'กรุณาระบุเป็นตัวเลขเท่านั้น'}
            ],
            claim_amount: [
              {required: true, message: 'กรุณาระบุจำนวนเงิน', trigger: 'change'}
            ]
          }],
          amount:[
            {required: true, message: 'กรุณาระบุจำนวนเงินชดใช้', trigger: 'change'}
          ],
          detail: [{
            line_description: [
              {required: true, message: 'กรุณาระบุรายละเอียด', trigger: 'change'}
            ],
            line_amount: [
              {required: true, message: 'กรุณาระบุจำนวน', trigger: 'change'}
            ]
          }],
          details: [
            {required: true, message: 'กรุณาระบุรายละเอียดให้ครบ', trigger: 'change'}
          ]
        },
        req_modal: [
          {required: true, message: 'กรุณาระบุ Invoice / GL Date', trigger: 'change'}
        ],
        companies: [
           {required: true, message: 'กรุณาระบุรายการเคลม', trigger: 'change'}
        ]
      },
      index_comp: 0,
      index_group: 0,
      details: {},
      accident_time: '',
      confirm: false,
      fileList: [],
	    btn: '',
      btnConfirm: false,
      files: [],
      resData: [],
      companies_percent: []
    }
  },
  props: [
    'claim',
    'isNullOrUndefined',
    'checkStatusInterface',
    'checkStatusConfirmed',
    'checkStatusCancelled',
    'action',
    'setYearCE',
    'vars',
  ],
  computed: {
    checkColumnPercent () {
      // let claim_percent = this.claim.group.reduce((sum, row) => {
      //   if (row.company.claim_percent === '') {
      //     return sum + 0
      //   }
      //   return sum + parseInt(row.company.claim_percent)
      // }, 0)
      // return claim_percent
      let companies = [];
      this.claim.group.forEach(element => {
        companies = [...element.company.map(item => {
          return {
            claim_percent: item.claim_percent
          };
        })]
      });
       
      let claim_percent = companies.reduce((sum, comp) => {
        if (comp.claim_percent === '') {
          return sum + 0
        }
        return sum + parseInt(comp.claim_percent)
      }, 0)
       
      return claim_percent
    },
    statusHeader () {
      if (this.action === 'add') {
        return 'NEW'
      } else if (this.action === 'edit' && this.checkStatusInterface(this.claim.headers.status)) {
        return 'INTERFACE'
      } else {
        return 'PENDING'
      }
    },
    checkColumnLineAmountDetails () {
       
      let line_amount = 0
      let comds = [];
      let details = [];
      let validDetails = [];
      this.claim.group.forEach(element => {
        comds = [...comds, ...element.company.map(item => {
          return item;
        })]
      });
       
      comds.forEach(element => {
        details = [...details, ...element.detail.map(item => {
          return {
            line_amount: item.line_amount
          };
        })]
      });
       
      line_amount = details.reduce((sum, row) => {
        if (row.line_amount === '') {
          return sum + 0
        }
        return sum + parseFloat(row.line_amount)
      }, 0)
       
      return line_amount
    },
    checkColumnClaimAmountComp () {
       
      let claim_amount = 0
      let comps = []
      this.claim.group.forEach(element => {
         comps = [...comps, ...element.company.map(item => {
          
         return item;
         })]
       });
         
      claim_amount = comps.reduce((sum, row) => {
        if (row.claim_amount === '') {
          return sum + 0
        }
        return sum + parseFloat(row.claim_amount)
      }, 0)
       
      return claim_amount
    }
  },
  methods: {
    getDataDepartment (obj) {
      this.claim.headers.department_code = obj.code
      this.claim.headers.department_name = obj.desc
    },
    clickSave () {
      const formData = new FormData()
      formData.append('file', this.fileList)
       
      let save = 'save'
      this.btn = save
      this.checkBtnSaveOrConfirm(save)
      let _this = this
      this.$refs.claim_insurance.validate((validClaim) => {
        if (validClaim) {
          this.$refs.claim_apply_companies.validate((validApply) => {
            if (validApply) {
              if (this.checkColumnPercent === 100) {
                 
                // // // _this.$refs.claim_apply_details.validate((validDetails) => {
                //   if (_this.checkReqTableDetails()) {
                //   // if (validDetails) {
                    _this.setPropertySaveAndConfirm(_this.claim, save)
                     
                  // }
                // // })
              } else {
                swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
              }
            } else {
               
              return false;
            }
          })
        } else {
           
          return false;
        }
      })
      let companies = [];
      let validCompanies = [];
      this.claim.group.forEach(element => {
       companies = [...companies, ...element.company.map(item => {
          return {
            company_id: item.company_id,
            claim_percent: item.claim_percent
          };
        })]
      });
       
      validCompanies = companies.filter(f => f.company_id == "" || f.claim_percent == "");
       
      
      // let modal = [];
      // let validModal = [];
      // this.claim.group.forEach(element => {
      //   modal = [...modal, ...element.company.map(item => {
      //     return {
      //       invoice_date: item.modal.invoice_date,
      //       gl_date: item.modal.gl_date
      //     };
      //   })]
      // });
       
      // validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
       

      let comds = [];
      let details = [];
      let validDetails = [];
      this.claim.group.forEach(element => {
        comds = [...comds, ...element.company.map(item => {
          return item;
        })]
      });
       
      comds.forEach(element => {
        details = [...details, ...element.detail.map(item => {
          return {
            line_description: item.line_description,
            line_amount: item.line_amount
          };
        })]
      });
       
      validDetails = details.filter(f => f.line_description == "" || f.line_amount == "");
       

      // if (validCompanies.length > 0 && validModal.length === 0) {
          if (validCompanies.length > 0 ) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
        return false;
      } 
      // else if (validModal.length > 0 && validCompanies.length === 0) {
      //   swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
      //   return false;
      // } 
      // else if (validCompanies.length > 0 && validModal.length > 0) {
         else if (validCompanies.length > 0 ) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      } else if (validDetails.length > 0 ){
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
      // } else if (!this.checkColumnClaimAmountComp) {
      //   swal("Warning", 'กรุณาระบุจำนวนเงินให้ถูกต้องตามสัดส่วน!', "warning");
      } else {
        return false
        };
    },
    clickCancel () {
      window.location.href = '/ir/claim-insurance'
    },
    clickConfirm () {
      let confirm = 'confirm'
      this.btn = confirm
      this.checkBtnSaveOrConfirm(confirm)
      let _this = this
      
       
      // if (this.btnConfirm) {
        _this.$refs.claim_insurance.validate((validClaim) => {
          if (validClaim) {
            _this.$refs.claim_apply_companies.validate((validCompany) => {
              if (validCompany) {
                // if (_this.checkColumnPercent === 100) {
                  // // _this.$refs.claim_apply_details.validate((validDetails) => {
                  //   if (_this.checkReqTableDetails()) {
                  //   // if (validDetails) {
                      // _this.setPropertySaveAndConfirm( _this.claim, confirm)
                       
                  //   }
                  // // })
                // } else {
                //   swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
                // }
              } else {
                 
                return false;
              }
            })
            // this.$refs.claim_apply_companies.validate((validCompany) => {
            //   if (validCompany) {
            //     if (this.checkColumnPercent < 100) {
            //       let param = {
            //         status: 'CONFIRMED'
            //       }
            //        
            //     } else {
            //       swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
            //     }
            //   } else {
            //      
            //     return false;
            //   }
            // })
          } else {
             
            return false;
          }
        })
      // }
       let companies = [];
      let validCompanies = [];
      this.claim.group.forEach(element => {
       companies = [...companies, ...element.company.map(item => {
          return {
            company_id: item.company_id,
            claim_percent: item.claim_percent
          };
        })]
      });
       
      validCompanies = companies.filter(f => f.company_id == "" || f.claim_percent == "");
       
      
      let modal = [];
      let validModal = [];
      this.claim.group.forEach(element => {
        modal = [...modal, ...element.company.map(item => {
          return {
            invoice_date: item.modal.invoice_date,
            gl_date: item.modal.gl_date
          };
        })]
      });
       
      validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
       

      let comds = [];
      let details = [];
      let validDetails = [];
      this.claim.group.forEach(element => {
        comds = [...comds, ...element.company.map(item => {
          return item;
        })]
      });
       
      comds.forEach(element => {
        details = [...details, ...element.detail.map(item => {
          return {
            line_description: item.line_description,
            line_amount: item.line_amount
          };
        })]
      });
       
      validDetails = details.filter(f => f.line_description == "" || f.line_amount == "");
       

      if (validCompanies.length > 0 && validModal.length === 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      } else if (validModal.length > 0 && validCompanies.length === 0 ) {
        swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
        return false;
      } else if (validCompanies.length > 0 && validModal.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      } else if (validDetails.length > 0 ) {
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
      } else if (_this.checkColumnPercent !== 100) {
        swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
      } else {
        _this.setPropertySaveAndConfirm( _this.claim, confirm)
                       
      }
    },
    clickCreateClaimGroup () {
       
      // this.btn = '';
      // this.$refs.claim_apply_companies.validate((valid) => {
      //   if (valid) {
      //      
      //     if (this.claim.group.length === 0 || this.checkColumnPercent === 100) {
      //        
            this.claim.group.push({
              group_code: '',
              group_description: '',
              group_header_id: '',
              amount: '',
              group_set_id: '',
              policy_set_description: '',
              policy_set_header_id: '',
              company: [],
              showLovCompany: true,
              flag: 'add'
            })
              // company: {
              //   company_id: '',
              //   company_name:'',
              //   claim_percent: '',
              //   claim_amount: ''
              // },
              // claim_apply_id: '',
              // detail: [{
              //   line_number: '1',
              //   line_description: '',
              //   line_amount: '',
              //   flag: 'add',
              // }],
              // flag: 'add',
              // req_modal: '',
              // modal: {
              //   informant_date: '',
              //   invoice_date: '',
              //   gl_date: '',
              //   ar_invoice_num: '',
              //   policy_number: '',
              //   ar_receipt_date: '',
              //   ar_receipt_number: '',
              //   ar_received_amount: ''
              // },
              // showLovCompany: true
      //       })   
      //     } else {
      //       swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
      //     }
      //   } else {
      //      
      //     return false;
      //   }
      // })
      // let companies = [];
      // let validCompanies = [];
      // this.claim.group.forEach(element => {
      //  companies = [...companies, ...element.company.map(item => {
      //     return {
      //       company_id: item.company_id,
      //       claim_percent: item.claim_percent
      //     };
      //   })]
      // });
       
      // validCompanies = companies.filter(f => f.company_id == "" || f.claim_percent == "");
       
      
      // let modal = [];
      // let validModal = [];
      // this.claim.group.forEach(element => {
      //   modal = [...modal, ...element.company.map(item => {
      //     return {
      //       invoice_date: item.modal.invoice_date,
      //       gl_date: item.modal.gl_date
      //     };
      //   })]
      // });
       
      // validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
       
      
      // let comds = [];
      // let details = [];
      // let validDetails = [];
      // this.claim.group.forEach(element => {
      //   comds = [...comds, ...element.company.map(item => {
      //     return item;
      //   })]
      // });
       
      // comds.forEach(element => {
      //   details = [...details, ...element.detail.map(item => {
      //     return {
      //       line_description: item.line_description,
      //       line_amount: item.line_amount
      //     };
      //   })]
      // });
       
      // validDetails = details.filter(f => f.line_description == "" || f.line_amount == "");
       

      // if (validCompanies.length > 0 && validModal.length === 0) {
      //   swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      //   // return false;
      // } else if (validModal.length > 0 && validCompanies.length === 0) {
      //   swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
      //   // return false;
      // } else if (validCompanies.length > 0 && validModal.length > 0) {
      //   swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      // }else if (validDetails.length > 0 ){
      //   swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
      // } else {
      //   return false;
      // }
      //   this.claim.group[index].company.push({
      //     company_id: '',
      //     company_name:'',
      //     claim_percent: '',
      //     claim_amount: '',
      //     detail: [{
      //       line_number: '1',
      //       line_description: '',
      //       line_amount: '',
      //       flag: 'add',
      //     }],
      //     req_modal: '',
      //     modal: {
      //       informant_date: '',
      //       invoice_date: '',
      //       gl_date: '',
      //       ar_invoice_num: '',
      //       policy_number: '',
      //       ar_receipt_date: '',
      //       ar_receipt_number: '',
      //       ar_received_amount: ''
      //     },
      //     flag: 'add',
      //     claim_apply_id: ''
      //   })
      //   return true;
      // }
    },
    changePercent (value, index, index_group) {
       
      this.claim.group[index_group].company[index].claim_percent = value
      this.claim.group[index_group].company[index].claim_amount = value ? this.claim.group[index_group].amount * value / 100 : value
      let claim_amount = this.claim.group[index_group].company[index].claim_amount
      this.setDefaultLineAmountDetails(claim_amount, index, index_group)
      // if (value) {
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + index + '.company.claim_percent').clearValidate()
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + index + '.company.claim_amount').clearValidate()
      // } else {
      //   this.$refs.claim_apply_companies.validateField('group.' + index + '.company.claim_percent')
      //   this.$refs.claim_apply_companies.validateField('group.' + index + '.company.claim_amount')
      // }
    },
    getDataCompany (obj, index_comp,index_group) {
       
      this.claim.group[index_group].company[index_comp].company_number = obj.code
      this.claim.group[index_group].company[index_comp].company_name = obj.desc
      this.claim.group[index_group].company[index_comp].company_id = obj.id
      
    },
    clickAddDetails (dataRow, index) {
       
      let length = dataRow.detail.length
      //  this.$refs.claim_apply_details.validate((validDetails) => {
        // if (validDetails) {
          dataRow.detail.push({
            line_number: length + 1,
            line_description: '',
            line_amount: '',
            flag: 'add'
          })
        // } else {
        //    
        //   return false;
        // }
      // })
    },
    getDataAmount (value, index) {
       
      this.claim.group[index].amount = value

      // this.claim.group[index].company.claim_amount = value * this.claim.group[index].company.claim_percent / 100
      // if (value) {
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.'+ index + '.amount').clearValidate()
      // } else {
      //   this.$refs.claim_apply_companies.validateField('group.'+ index + '.amount')
      // }
      let amount_group = this.claim.group.reduce((sum, row) => {
        if (row.amount === '') {
          return sum + 0
        }
        return sum + parseFloat(row.amount)
      }, 0)
       
      this.claim.headers.claim_amount = amount_group
    },
    clickRemoveGroup(dataRow, index){
      
      if (dataRow.flag === 'add' ) {
        let index = this.claim.group.indexOf(dataRow)
         
        if (index > -1) {
          this.claim.group.splice(index, 1);
           
          }
          
        }else{
        // let params = {
        //   claim_policy_group_rows: dataRow.claim_group_id,
          // claim_apply_id: dataRow.company_id
        // }
        // axios.delete(`/ir/ajax/claim/${this.claim.headers.claim_header_id}?claim_group_id=${dataRow.claim_group_id}`)
      axios.delete(`/ir/ajax/claim/${dataRow.claim_group_id}`)
        .then(({data}) => {
           
          swal({
            title: "Success",
            text: data.message,
            type: "success",
            timer: 3000,
            showConfirmButton: false,
            closeOnConfirm: false
          });
          let index = this.claim.group.indexOf(dataRow)
           
          if (index > -1) {
            this.claim.group.splice(index, 1);
          }
          let amount_group = this.claim.group.reduce((sum, row) => {
             if (row.amount === '') {
              return sum + 0
         }
             return sum + parseFloat(row.amount)
          }, 0)
       
      this.claim.headers.claim_amount = amount_group
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
        }
        let amount_group = this.claim.group.reduce((sum, row) => {
        if (row.amount === '') {
          return sum + 0
        }
        return sum + parseFloat(row.amount)
      }, 0)
       
      this.claim.headers.claim_amount = amount_group
      },
    getAccidentDate (obj) {
      this.claim.headers.accident_date = obj.value
      if (obj.value) {
        this.$refs.claim_insurance.fields.find((f) => f.prop == 'headers.accident_date').clearValidate()
      } else {
        this.$refs.claim_insurance.validateField('headers.accident_date')
      }
    },
    clickRemove (dataRow, i, index_group) {
       
      if (dataRow.flag === 'add') {
        let index = this.claim.group[index_group].company.indexOf(dataRow)
         
        if (index > -1) {
          this.claim.group[index_group].company.splice(i, 1);
           
        }
      // } else if (dataRow.flag === 'edit' && this.checkColumnPercent === 100) {
      //   swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
      } else {
        axios.delete(`/ir/ajax/claim/company/${this.claim.headers.claim_header_id}?claim_apply_id=${dataRow.company_id}`)
        .then(({data}) => {
           
          swal({
            title: "Success",
            text: data.message,
            type: "success",
            timer: 3000,
            showConfirmButton: false,
            closeOnConfirm: false
          });
          let index =this.claim.group[index_group].company.indexOf(dataRow)
           
          if (index > -1) {
            this.claim.group[index_group].company.splice(i, 1);
              
          }
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
        //  window.location.href = `'/ir/claim-insurance/edit/${this.claim.headers.claim_header_id}'`
      }
        // window.location.href = `'/ir/claim-insurance/edit/${this.claim.headers.claim_header_id}'`
    },
    clickModalDetails (dataRow, index, index_group) {
       
      
      this.index_comp = index
      this.index_group = index_group
      this.details = dataRow.modal
    },
    setPropertySaveAndConfirm (data, btn) {
       
      // this.checkBtnSaveOrConfirm(btn)
      let groups = data.group
      let claim_policy_group_rows = []
      let checkClaimAmountAndLineAmount = false
      // let checkClaimAmountHeaderAndClaimAmountComp = false
      groups.filter((row) => {
        let data = {
          ...row,
          company_rows: row.company
          // line_rows: row.detail, 
          // ar_receipt_date: this.setYearCE('date', row.ar_receipt_date),
          // gl_date: this.setYearCE('date', row.gl_date),
          // informant_date: this.setYearCE('date', row.informant_date),
          // invoice_date: this.setYearCE('date', row.invoice_date)
        }
        row.company.filter((comp) => {
           
          if (this.checkColumnLineAmountDetails === this.checkColumnClaimAmountComp) {
            checkClaimAmountAndLineAmount = true
          } else {
            checkClaimAmountAndLineAmount = false
          }
        })

        // if (this.checkColumnClaimAmountComp === (this.claim.headers.claim_amount ? +this.claim.headers.claim_amount : this.claim.headers.claim_amount)) {
        //   // if(this.checkColumnClaimAmountComp === this.claim.headers.claim.group){
        //   checkClaimAmountHeaderAndClaimAmountComp = true
        // } else {
        //   checkClaimAmountHeaderAndClaimAmountComp = false
        // }
        claim_policy_group_rows.push(data)
      })
      let params = {
        data: {
          // ...data.headers,
          header: {
            ...this.claim.headers,
            file: this.fileList,
            // accident_date: this.setYearCE('date', data.headers.accident_date),
            status: btn === 'save' ? this.statusHeader : btn === 'confirm' ? 'CONFIRMED' : '' 
          },
          claim_policy_group_rows: claim_policy_group_rows,
          program_code: 'IRP0010'
        }
      }
      // let setParams = this.setFormData(params)
      // return params
       
      if (checkClaimAmountAndLineAmount) {
         axios.post(`/ir/ajax/claim`, params)
          .then((response) => {
            let res = response.data.data;
             
            if (response.status === 200) {
              let setParams = this.setFormData(res)
              this.receivedUploadFile(setParams)
            }
            swal({
              title: "Success",
              text: data.message,
              type: "success",
              showConfirmButton: false,
              closeOnConfirm: false
            });
            window.location.href = '/ir/claim-insurance' 
          })
          // .catch((error) => {
          //   swal("Error", error, "error");
          // })
        // if (checkColumnClaimAmountComp) {
          // axios.post(`/ir/ajax/claim`, params)
          // .then((response) => {
          //   let res = response.data.data;
          //    
          //   if (response.status === 200) {
          //     let setParams = this.setFormData(res)
          //     this.receivedUploadFile(setParams)
          //   }
          //   swal({
          //     title: "Success",
          //     text: data.message,
          //     type: "success",
          //     showConfirmButton: false,
          //     closeOnConfirm: false
          //   });
          //   window.location.href = '/ir/claim-insurance'
          // })
          // .catch((error) => {
          //   swal("Error", error, "error");
          // })
        // } else {
        //   swal("Warning", 'คอลัมน์จำนวนเงินต้องมีค่าเท่ากันจำนวนเงินเรียกชดใช้รวม!', "warning");
        // }

      } else {
        swal("Warning", 'กรุณาระบุจำนวนเงินให้ถูกต้องตามสัดส่วน!', "warning");
      }
    },
    getDataModalDetails (obj) {
       
      this.claim.group[this.index_group].company[this.index_comp].modal.informant_date = obj.informant_date
      this.claim.group[this.index_group].company[this.index_comp].modal.invoice_date = obj.invoice_date
      this.claim.group[this.index_group].company[this.index_comp].modal.gl_date = obj.gl_date
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_invoice_num = obj.ar_invoice_num
      this.claim.group[this.index_group].company[this.index_comp].modal.policy_number = obj.policy_number
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_receipt_date = obj.ar_receipt_date
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_receipt_number = obj.ar_receipt_number
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_received_amount = obj.ar_received_amount
      if (this.confirm) {
        this.claim.group[this.index_group].company[this.index_comp].req_modal = obj.invoice_date && obj.gl_date ? '1' : ''
      } else {
        this.claim.group[this.index_group].company[this.index_comp].req_modal = '1'
      }
      // let req_modal = this.claim.group[this.index_group].company[this.index_comp].req_modal
      // if (req_modal) {
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + this.index_comp + '.req_modal').clearValidate()
      // } else {
      //   this.$refs.claim_apply_companies.validateField('group.' + this.index_comp + '.req_modal')
      // }
    },
    getClaimAmountCompany (value, index) {
       
      this.claim.group[index].detail.filter((detail) => {
        detail.line_amount = value
        return detail
      })
      if (value) {
        this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + index + '.company.claim_amount').clearValidate()
      } else {
        this.$refs.claim_apply_companies.validateField('group.' + index + '.company.claim_amount')
      }
    },
    checkBtnSaveOrConfirm (btn) {
      if (btn === 'save') {
        this.confirm = false
        this.claim.group.filter((row) => {
          row.company.filter((comp) => {
            comp.req_modal = '1';
            return comp;
          })
          return row
        })
      } else if (btn === 'confirm') {
        this.confirm = true
        this.claim.group.filter((row) => {
          row.company.filter((comp) => {
            comp.req_modal = comp.modal.invoice_date && comp.modal.gl_date ? '1' : '';
            return comp;
          })
          return row
        })
      }
    },
    clickRemoveDetails (dataRowComp, dataRow, index_detail) {
       
      if (dataRow.flag === 'add' || dataRow.flag === 'edit') {
        let index = dataRowComp.detail.indexOf(dataRow)
         
        if (index > -1) {
          dataRowComp.detail.splice(index, 1);
          dataRowComp.detail.filter((detail, i) => {
            detail.line_number = i + 1
            return detail
          })
           
        }
      }
    },
    checkReqTableDetails () {
      let arr = [];
      let validate = [];
      this.claim.group.forEach(element => {
        arr = [...arr, ...element.detail.map(item => {
          return {
            line_amount: item.line_amount,
            line_description: item.line_description
          };
        })]
      });

      validate = arr.filter(f => f.line_description == "" || f.line_amount == "");

      if(validate.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
        return false;
      }
      else return true;
    },
    showBtnRemoveCompany (dataRow, index) {
       
      if (dataRow.flag === 'add') {
        return true
      } else if (dataRow.flag === 'edit') {
        if (this.checkStatusInterface(this.claim.headers.status) || this.checkStatusConfirmed(this.claim.headers.status) || this.checkColumnPercent <= 100) {
          return false
        }
        return true
      }
    },
    setDefaultLineAmountDetails (claim_amount, index, index_group) {
       
      let details = this.claim.group[index_group].company[index].detail
      if (details.length > 0) {
        details[0].line_amount = claim_amount
      }
      // this.claim.apply.apply_company.filter((company) => {
      //   if (company.apply_details.length > 0) {
      //     company.apply_details[0].line_amount = claim_amount
      //   }
      //   // company.apply_details.filter((detail) => {
      //   //   detail.line_amount = claim_amount
      //   //   return detail
      //   // })
      // })
    },
    watchClaimAmountCompany (value, index, index_group) {
       
      this.setDefaultLineAmountDetails(value, index, index_group)
    },
    getValueAccidentDate (date) {
       
      let formatDate = this.vars.formatDate
      if (date) {
        this.claim.headers.accident_date = moment(date).format(formatDate)
      } else {
        this.claim.headers.accident_date = '';
      }
      this.validateNotElUi(date, 'headers.accident_date')
    },
    validateNotElUi (value, nameProp) {
      if (value) {
        this.$refs.claim_insurance.fields.find((f) => f.prop == nameProp).clearValidate()
      } else {
        this.$refs.claim_insurance.validateField(nameProp)
      }
    },
    onBeforeUploadImage (file) {
      const isIMAGE = file.type === 'image/jpeg' || 'image/jpg' || 'image/png'
      const isLt1M = file.size / 1024 / 1024 < 1
      if (!isIMAGE) {
        this.$message.error('Upload file can only be in image format!')
      }
      if (!isLt1M) {
        this.$message.error('Upload file size cannot exceed 1MB!')
      }
      return isIMAGE && isLt1M
    },
    UploadImage (param){
      const formData = new FormData()
      formData.append('file', param.file)
      formData.append('data', param.data)
       
      // let config = {
      //   header: {
      //     'Content-Type': 'multipart/form-data'
      //   }
      // }
      axios.post('/ir/claim-insurance/create/upload', formData, config)
      .then((res) => {})
      .catch((error) => {
         
      })
      // UploadImageApi(formData).then(response => {
      // 	 
      //   param.onSuccess()  // Upload a successful image will show a green check mark
      //   // But we uploaded the image successfully, but the value in fileList has not changed, but the on-change command can be used.
      // }).catch(response => {
      //    
      //   param.onError()
      // })
    },
    onchange (file, fileList){
       
      this.fileList = fileList;
      // this.$refs.upload.clearFiles() // Clear the file object
      // this.logo = file.raw // Take out the object of the uploaded file, can also be used in other places
      // this.fileList = [{name: file.name, url: file.url}] // Re-assign the filstList manually, so that the custom upload is successful, and the fileList is not dynamically changed, so each time an object is uploaded.
    },
    onRemove (file, fileList){
       
      let _this = this;
      if (this.action === 'add') {
        // swal({
        //   title: "Warning",
        //   text: "ต้องการลบหรือไม่?",
        //   type: "warning",
        //   showCancelButton: true,
        //   closeOnConfirm: false
        // },
        // function(isConfirm) {
        //   if (isConfirm) {
            _this.fileList = fileList;
        //     swal({
        //       title: "Success",
        //       text: '',
        //       timer: 3000,
        //       type: "success",
        //       showCancelButton: false,
        //       showConfirmButton: false
        //     })
        //   }
        // });
      } else {
        let attachment_id = file.attachment_id;
        this.fileList = fileList;
        // swal({
        //   title: "Warning",
        //   text: "ต้องการลบหรือไม่?",
        //   type: "warning",
        //   showCancelButton: true,
        //   closeOnConfirm: false
        // },
        // function(isConfirm) {
        //   if (isConfirm) {
             
            _this.receivedDelete(attachment_id)
        //   }
        // });
      }
    },
    setFormData (params) {
       
      let data = {
        // program_code: 'IRP0010',
        claim_header_id: params.claim_header_id
      };
      const formData = new FormData();
      formData.append('data', JSON.stringify(data));
      // formData.append('accident_date', params.data.accident_date);
      // formData.append('accident_time', params.data.accident_time);
      // formData.append('claim_amount', params.data.claim_amount);
      // formData.append('claim_header_id', params.data.claim_header_id);
      // formData.append('department_code', params.data.department_code);
      // formData.append('department_name', params.data.department_name);
      // formData.append('document_number', params.data.document_number);
      // formData.append('location_code', params.data.location_code);
      // formData.append('location_name', params.data.location_name);
      // formData.append('program_code', params.data.program_code);
      // formData.append('requestor_id', params.data.requestor_id);
      // formData.append('requestor_name', params.data.requestor_name);
      // formData.append('requestor_tel', params.data.requestor_tel);
      // formData.append('status', params.data.status);
      // formData.append('company_rows', JSON.stringify(params.data.company_rows));
      
      let everySuccess = this.fileList.every(this.checkFilesEditSuccessEvery)
       
      if (this.fileList.length > 0 && !everySuccess) {
        for (let i in this.fileList) {
          let file = this.fileList[i];
           
          if (file.status === 'ready') {
            formData.append('file[]', file.raw);
          }
        }
         
      } else {
        formData.append('file[]', []);
      }
      // formData.append('year', params.data.year);
      return formData
    },
    receivedUploadFile (formDataFile) {
      axios.post('/ir/ajax/claim/upload', formDataFile)
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          showConfirmButton: false,
          closeOnConfirm: false
        });
        // window.location.href = '/ir/claim-insurance'
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    receivedDelete (attachment_id) {
      axios.delete(`/ir/ajax/claim/file/${attachment_id}`)
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          showConfirmButton: false,
          closeOnConfirm: false,
          timer: 3000
        });
        this.files = this.fileList;
         
      })
      .catch((error) => {
        if (error.response.data.status === 400) {
          swal("Warning", error.response.data.message, "warning");
        } else {
          swal("Error", error, "error");
        }
        this.fileList = this.files;
         
      })
    },
    beforeRemove(file, fileList) {
       
      return this.$confirm(`ต้องการลบหรือไม่`);
    },
    checkFilesEditSuccessEvery (file) {
       
      if (file.status && file.status.toLowerCase() === 'success') {
        return true
      } 
      return false
    },
    getPolicyCode (obj, index) {
      this.claim.group[index].group_code = obj.code
      this.claim.group[index].group_description = obj.desc
      this.claim.group[index].group_header_id = obj.id
      if (obj.id) {
        this.claim.group[index].showLovCompany = false;
        this.getCompaiesPercent(obj.id);
      } else {
        this.claim.group[index].showLovCompany = true
        this.claim.group[index].company = [];
        //  this.getCompaiesPercent(obj.id);
        // this.claim.group[index].company.filter((comp) => {
        //   comp.company_id = '';
        //   comp.company_name = '';
        //   comp.claim_percent = '';
        //   comp.claim_amount = '';
        //   return comp;
        // })
      }
      // if(obj.id !== ''){
      //   this.getCompanyPercent(obj.id, index);
      // }
    },
    getPolicySetHeaderId (obj, index) {
      this.claim.group[index].policy_set_header_id = obj.id
      this.claim.group[index].policy_set_description = obj.desc
    },
    getDataCompanyPolicyGroup (obj, index_comp, index_group) {
       
      this.claim.group[index_group].company[index_comp].company_id = obj.id
      this.claim.group[index_group].company[index_comp].company_name = obj.desc
      let percent = obj.percent ? +obj.percent : 0;
      this.claim.group[index_group].company[index_comp].claim_percent= percent
      this.claim.group[index_group].company[index_comp].claim_amount = percent ? this.claim.group[index_group].amount * percent / 100 : percent
    },
    clickCreateApplyCompanies (index,data) {
       
      let companies = [];
      let validCompanies = [];
      this.claim.group.forEach(element => {
        
       companies = [...companies, ...element.company.map(item => {
          return {
            company_id: item.company_id,
            claim_percent: item.claim_percent
          };
        })]
      });
       
      validCompanies = companies.filter(f => f.company_id == "" || f.claim_percent == "");
       
      // let modal = [];
      // let validModal = [];
      // this.claim.group.forEach(element => {
      //   modal = [...modal, ...element.company.map(item => {
      //     return {
      //       invoice_date: item.modal.invoice_date,
      //       gl_date: item.modal.gl_date
      //     };
      //   })]
      // });
       
      // validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
       

      let comds = [];
      let details = [];
      let validDetails = [];
      this.claim.group.forEach(element => {
        comds = [...comds, ...element.company.map(item => {
          return item;
        })]
      });
       
      comds.forEach(element => {
        details = [...details, ...element.detail.map(item => {
          return {
            line_description: item.line_description,
            line_amount: item.line_amount
          };
        })]
      });
       
      validDetails = details.filter(f => f.line_description == "" || f.line_amount == "");
       

      // if (validCompanies.length > 0 && validModal.length === 0) {
        if (validCompanies.length > 0 ) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
        return false;
      // } 
      // else if (validModal.length > 0 && validCompanies.length === 0) {
      //   swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
      //   return false;
      // } 
      // else if (validCompanies.length > 0 && validModal.length > 0) {
      //   swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      
      // } else   {
      }else if (validDetails.length > 0 ){
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
       
      }else if (this.checkColumnPercent === 100){
         swal("Warning", 'สัดส่วนได้ครบจำนวน 100 % !', "warning");
      // }else if (this.claim.group.length > 1) { 
      //    this.companies_percent.filter((comp_res, index_comp) => {
      //       let data = {
      //         company_id : '',
      //         company_name : '',
      //         claim_percent : '',
      //         claim_amount : '',
      //         detail: [{
      //           line_number: '1',
      //           line_description: '',
      //           line_amount: '',
      //           flag: 'add',
      //         }],
      //         req_modal: '',
      //         modal: {
      //           informant_date: '',
      //           invoice_date: '',
      //           gl_date: '',
      //           ar_invoice_num: '',
      //           policy_number: '',
      //           ar_receipt_date: '',
      //           ar_receipt_number: '',
      //           ar_received_amount: ''
      //         },
      //         flag: 'add',
      //         claim_apply_id: ''
      //       };
      //         let percent = comp_res.company_percent ? +comp_res.company_percent : 0;
      //         data.company_id = comp_res.company_id
      //         data.company_name = comp_res.company_name
      //         data.claim_percent = comp_res.company_percent 
      //         data.claim_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
      //         data.detail.line_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
      //         this.claim.group[index].company.push(data)
      //          
      //         data.detail.filter((detl) => {
      //           let claim_amount = data.claim_amount ? +data.claim_amount : 0;
      //           detl.line_amount = claim_amount
      //            
      //            
      //         })
      //          
      //     })
      // }
      }else if (data.group_code === '') { 
        this.claim.group[index].company.push({
          company_id: '',
          company_name:'',
          claim_percent: '',
          claim_amount: '',
          detail: [{
            line_number: '1',
            line_description: '',
            line_amount: '',
            flag: 'add',
          }],
          req_modal: '',
          modal: {
            informant_date: '',
            invoice_date: '',
            gl_date: '',
            ar_invoice_num: '',
            policy_number: '',
            ar_receipt_date: '',
            ar_receipt_number: '',
            ar_received_amount: ''
          },
          flag: 'add',
          claim_apply_id: ''
        })
           
        return true;
      
      // }else if (this.claim.group.length > 1) { 
      //    this.companies_percent.filter((comp_res, index_comp) => {
      //       let data = {
      //         company_id : '',
      //         company_name : '',
      //         claim_percent : '',
      //         claim_amount : '',
      //         detail: [{
      //           line_number: '1',
      //           line_description: '',
      //           line_amount: '',
      //           flag: 'add',
      //         }],
      //         req_modal: '',
      //         modal: {
      //           informant_date: '',
      //           invoice_date: '',
      //           gl_date: '',
      //           ar_invoice_num: '',
      //           policy_number: '',
      //           ar_receipt_date: '',
      //           ar_receipt_number: '',
      //           ar_received_amount: ''
      //         },
      //         flag: 'add',
      //         claim_apply_id: ''
      //       };
      //         let percent = comp_res.company_percent ? +comp_res.company_percent : 0;
      //         data.company_id = comp_res.company_id
      //         data.company_name = comp_res.company_name
      //         data.claim_percent = comp_res.company_percent 
      //         data.claim_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
      //         data.detail.line_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
      //         this.claim.group[index].company.push(data)
      //          
      //         data.detail.filter((detl) => {
      //           let claim_amount = data.claim_amount ? +data.claim_amount : 0;
      //           detl.line_amount = claim_amount
      //            
      //            
      //         })
      //          
      //     })
      }else{
           
          this.companies_percent.filter((comp_res, index_comp) => {
            let data = {
              company_id : '',
              company_name : '',
              claim_percent : '',
              claim_amount : '',
              detail: [{
                line_number: '1',
                line_description: '',
                line_amount: '',
                flag: 'add',
              }],
              req_modal: '',
              modal: {
                informant_date: '',
                invoice_date: '',
                gl_date: '',
                ar_invoice_num: '',
                policy_number: '',
                ar_receipt_date: '',
                ar_receipt_number: '',
                ar_received_amount: ''
              },
              flag: 'add',
              claim_apply_id: ''
            };
              let percent = comp_res.company_percent ? +comp_res.company_percent : 0;
              data.company_id = comp_res.company_id
              data.company_name = comp_res.company_name
              data.claim_percent = comp_res.company_percent 
              data.claim_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
              data.detail.line_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
              this.claim.group[index].company.push(data)
               
              data.detail.filter((detl) => {
                let claim_amount = data.claim_amount ? +data.claim_amount : 0;
                detl.line_amount = claim_amount
                 
                 
              })
               
          })
        
        // this.claim.group[index].company =array;
     }
    },
    getValueCompaniesPercent(array, index_group, index_comp) {
      let _this = this;
       
      if (array.length > 0) {
         
        array.filter((comp_res, index) => {
          if (index == index_comp) {
             
            let percent = comp_res.company_percent ? +comp_res.company_percent : 0;
            this.claim.group[index_group].company[index_comp].company_id = comp_res.company_id;
            this.claim.group[index_group].company[index_comp].company_name = comp_res.company_name;
            this.claim.group[index_group].company[index_comp].claim_percent = comp_res.company_percent;
            this.claim.group[index_group].company[index_comp].claim_amount = percent ? _this.claim.group[index_group].amount * percent / 100 : percent;
          }
          
           // this.claim.group[index_group].company[0].company_id ='11';
          //  this.claim.group[index_group].company[1].company_id = '22';
       })
         
      } else {
        this.claim.group[index_group].company[index_comp].company_id = '';
        this.claim.group[index_group].company[index_comp].company_name = '';
        this.claim.group[index_group].company[index_comp].claim_percent = '';
        this.claim.group[index_group].company[index_comp].claim_amount = '';
        this.claim.group[index_group].company[index_comp].detail = [];
      }
    },
    getCompaiesPercent (group_header_id) {
      let params = {
        company_id: '',
        keyword: '',
        group_header_id: group_header_id,
        year: this.claim.headers.year
      }
      axios.get(`/ir/ajax/lov/company-percent`, { params })
      .then(({data}) => {
         
        let response = data.data
        this.companies_percent = response;
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    }
    // getCompanyPercent (group_header_id, index) {
    //   axios.get(`/ir/ajax/lov/company-percent?group_header_id=${group_header_id}&year=${this.claim.headers.year}`)
    //   .then((res) => {
    //      
    //     this.resData = res.data.data;
    //     // this.claim.group[index].company.company_id = res.data.company_id
    //     // this.claim.group[index].company.company_name = res.data.company_name
    //     // this.claim.group[index].company.claim_percent= res.data.company_percent
    //   })
    //   .catch((error) => {
    //     swal("Error", error, "error");
    //   })
    // }
  },
  components: {
    lovDepartment,
    currencyInputGroupAppend,
    currencyInput,
    lovCompany,
    lovLocation,
    dateInput,
    modalDetails,
    headerForm,
    policyHeaderForm,
    lovPolicyGroup,
    lovPolicySetHeaderId,
    lovCompanyPolicyGroup
  },
  watch: {
    'btn' (newVal, oldVal) {
       
      if (newVal === 'confirm') {
        this.btnConfirm = true
      } else {
        this.btnConfirm = false
      }
    },
    'claim.headers.file' (newVal, oldVal) {
       
      this.fileList = newVal
      this.files = newVal
    }
  }
}
</script>

<style scoped>
  th, td {
    padding: 0.25rem;
  }
  th {
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
  }
  .custom-file-label::after {
    background-color: #F5F7FA;
  }
</style>
