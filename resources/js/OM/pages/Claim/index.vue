<template>
  <div>
    <div class="row">
      <!-- Content -->
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <div class="row align-items-center">
              <div class="col-sm-12 col-lg-4 align-middle">
                <h4>อนุมัติการเคลมสินค้า</h4>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div class="col-xl-6 m-auto">
              <div class="form-group">
                <h4 class="black mb-3">ค้นหารายการที่ต้องการ</h4>
              </div>
              <!--form-group-->

              <div
                class="form-group row"
                style="margin-bottom: 1rem !important"
              >
                <div class="col-md-6">
                  <label class="d-block">รหัสร้านค้า</label>
                  <div class="input-icon">
                    <el-select
                      v-model="filter.customer_number"
                      filterable
                      class="form-control"
                      @change="handleChangeSearchCustomerNumber"
                    >
                      <el-option value="" label="Select Customer" />
                      <el-option
                        v-for="customer in customer_list"
                        :key="customer.customer_id"
                        :value="customer.customer_id"
                        :label="
                          customer.customer_number +
                          ' : ' +
                          customer.customer_name
                        "
                      />
                    </el-select>
                    <i class="fa fa-search"></i>
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="d-block">ชื่อร้านค้า</label>
                  <div class="input-icon">
                    <input
                      v-model="filter.customer_name"
                      type="text"
                      class="form-control"
                      name=""
                      placeholder=""
                      value=""
                      disabled
                    />
                  </div>
                </div>
              </div>
              <!--form-group-->

              <div
                class="form-group row"
                style="margin-bottom: 1rem !important"
              >
                <div class="col-md-12">
                  <label class="d-block">เลขที่ใบแจ้งเคลมสินค้า</label>
                  <div class="input-icon">
                    <el-select
                      v-model="filter.claim_number"
                      filterable
                      @change="handleChangeClaimNumber"
                      class="form-control"
                    >
                      <el-option value="" label="เลขที่ใบแจ้งเคลมสินค้า" />
                      <el-option
                        v-for="claim in claim_number_list"
                        :key="claim.claim_header_id"
                        :value="claim.claim_number"
                        :label="claim.claim_number"
                      />
                    </el-select>
                    <i class="fa fa-search"></i>
                  </div>
                </div>
              </div>

              <div
                class="form-group row"
                style="margin-bottom: 1rem !important"
              >
                <div class="col-md-12">
                  <label class="d-block">วันที่แจ้งแคลมสินค้า</label>
                  <el-date-picker
                    v-model="filter.claim_date"
                    style="width: 100%"
                    name="end_date"
                    id="end_date"
                    placeholder="วันที่แจ้งแคลมสินค้า"
                    :value="end_date"
                    :disabled="fix_data"
                    format="dd-MM-yyyy"
                  ></el-date-picker>
                </div>
              </div>

              <div class="form-group">
                <label class="d-block">สถานะ</label>
                <select
                  class="custom-select"
                  id="status"
                  name="status"
                  v-model="filter.status_claim"
                  :disabled="fix_data"
                >
                  <option
                    v-for="status in status_list"
                    :key="status.lookup_code"
                    :value="status.lookup_code"
                  >
                    {{ status.meaning }}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <div class="col-md-12 text-center">
                  <button
                    @click="handleFilter"
                    class="btn btn-md btn-white"
                    style="width: 250px"
                    type="button"
                  >
                    <i class="fa fa-search"></i> ค้นหา
                  </button>
                  <!-- <button
                    @click="handleReset"
                    class="btn btn-md btn-white"
                    type="button"
                  >
                     ยกเลิก
                  </button> -->
                </div>
              </div>
            </div>

            <hr class="lg" />

            <div class="col-xl-12 tw-mb-3 tw-text-right">
              <button
                @click="handleSubmitForm"
                class="btn btn-md btn-primary"
                type="button"
              >
                <i class="fa fa-save"></i> บันทึก</button
              ><br />
            </div>
            <div class="col-xl-12">
              <div class="table-responsive">
                <table
                  id="datatable"
                  class="table items-list table-bordered text-center f13"
                >
                  <thead>
                    <tr class="align-middle">
                      <th class="claim-status">สถานะ</th>
                      <th>รายละเอียด</th>
                      <th>อนุมัติการเคลมสินค้า</th>
                      <th class="claim-order">ใบแจ้งเคลม</th>
                      <th class="claim-type-order">วิธีการเคลม</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="item in claim_list"
                      :key="item.claim_header_id"
                      class="align-middle"
                    >
                      <td>
                        <div
                          v-if="item.status_claim_code == 2"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #f90;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                        <div
                          v-if="item.status_claim_code == 5"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #f00;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                        <div
                          v-if="item.status_claim_code == 8"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #676a6c;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                        <div
                          v-if="item.status_claim_code == 9"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #f00;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px"
                            >9</span
                          >
                        </div>
                        <div
                          v-if="item.status_claim_code == 3"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #00f;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                        <div
                          v-if="item.status_claim_code == 6"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #00b050;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                        <div
                          v-if="item.status_claim_code == 4"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #f0f;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                        <div
                          v-if="item.status_claim_code == 7"
                          class="
                            tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4
                          "
                          style="
                            color: rgb(255, 255, 255);
                            font-weight: bold;
                            background-color: #f1c232;
                          "
                        >
                          {{ item.status_claim_label }}
                          <br data-v-4a57d4a9="" />
                          <span data-v-4a57d4a9="" style="font-size: 16px">{{
                            item.status_claim_code
                          }}</span>
                        </div>
                      </td>
                      <td class="text-left">
                        รหัสลูกค้า : {{ item.customer.customer_number || "" }} -
                        {{ item.customer.customer_name || "" }}<br />
                        เลขที่ใบแจ้งเคลมสินค้า : {{ item.claim_number }}<br />
                        อ้างอิง Invoice เลขที่ : {{ item.invoice_id_number
                        }}<br />
                        วันที่ Invoice : {{ item.invoice_date_label }}<br />
                        อาการเสีย : {{ item.symptom_description }}<br />
                        จำนวนส่งเคลม :
                        <ul>
                          <li v-for="list in item.lines" :key="list.item_id">
                            {{ list.item_description }} :
                            <span v-if="list.claim_quantity_carton > 0"
                              >{{ list.claim_quantity_carton }} ห่อ
                              (บุหรี่)</span
                            >
                            <span v-if="list.claim_quantity_cbb > 0"
                              >{{ list.claim_quantity_cbb }} หีบ (บุหรี่)</span
                            >
                            <span v-if="list.claim_quantity_pack > 0"
                              >{{ list.claim_quantity_pack }} ซอง (บุหรี่)</span
                            >
                          </li>
                        </ul>
                        <br />
                        <div v-if="item.credit_note_number != null">
                        ใบลดหนี้เลขที่: {{ item.credit_note_number }}
                      </div>
                      <div v-if="item.rma_number != null">
                        ใบคืนสินค้าเลขที่: {{ item.rma_number}} 
                      </div>
                        <button
                          class="btn btn-primary"
                          @click="
                            showAttachment('attachment-' + item.claim_header_id)
                          "
                        >
                          ดูไฟล์แนบ
                        </button>
                        <ul
                          :id="'attachment-' + item.claim_header_id"
                          style="display: none"
                        >
                          <li
                            v-for="attach in item.attachment"
                            :key="attach.attachment_id"
                          >
                            <a
                              target="_blank"
                              :href="
                                '/' +
                                attach.path_name.replace('public', 'storage')
                              "
                              >Line {{ attach.line_id }} :
                              {{ attachmentBind(attach.attribute1) }}</a
                            >
                          </li>
                        </ul>
                      </td>

                      <td class="text-left" style="vertical-align: text-top">
                        <div class="form-group m-0">
                          <div class="row space-5">
                            <div class="col-4">
                              <label
                                ><input
                                  v-model="item.approve_type"
                                  type="radio"
                                  :disabled="
                                    item.status_approve_claim ||
                                    item.status_claim_code == 9
                                      ? true
                                      : false
                                  "
                                  class="red"
                                  :name="'Confirm-' + item.claim_header_id"
                                  placeholder=""
                                  data-waschecked="true"
                                  @click="toggleRadioApprove"
                                  value="Y"
                                />
                                อนุมัติ
                              </label>
                            </div>
                            <div class="col-4">
                              <label>
                                <input
                                  v-model="item.approve_type"
                                  class="red"
                                  type="radio"
                                  :disabled="
                                    item.status_approve_claim ||
                                    item.status_claim_code == 9
                                      ? true
                                      : false
                                  "
                                  :name="'Confirm-' + item.claim_header_id"
                                  placeholder=""
                                  @click="toggleRadioApprove"
                                  value="N"
                                />
                                ไม่อนุมัติ
                              </label>
                            </div>
                          </div>
                          <!--row-->
                          <div class="row">
                            <div class="col-md-12">
                              <label>เนื่องจาก</label>
                            </div>
                          </div>
                          <!--row-->
                          <div class="row">
                            <div class="col-md-12">
                              <textarea
                                v-model="item.approve_text"
                                :disabled="
                                  item.status_approve_claim ||
                                  item.status_claim_code == 9
                                    ? true
                                    : false
                                "
                                :class="
                                  'form-control ' +
                                  (item.validate.approve_text
                                    ? 'is-invalid'
                                    : '')
                                "
                              ></textarea>
                            </div>
                          </div>
                          <!--row-->
                          <div class="row"></div>
                          <!--row-->
                          <div class="row">
                            <div
                              class="
                                col-md-5
                                tw-flex tw-items-center tw-whitespace-normal
                              "
                            >
                              จำนวนที่สามารถ Rework ได้ :
                            </div>
                            <div class="col-md-2">
                              <div class="col-md-12">หีบ</div>
                              <div class="col-md-12 in-block">
                                <input
                                  type="number"
                                  v-model="item.cardboard_box_quantity"
                                  :disabled="
                                    item.status_approve_claim ||
                                    item.status_claim_code == 9
                                      ? true
                                      : false
                                  "
                                  class="form-control"
                                  name=""
                                  placeholder=""
                                  value=""
                                />
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="col-md-12">ห่อ</div>
                              <div class="col-md-12 in-block">
                                <input
                                  v-model="item.cartons_quantity"
                                  type="number"
                                  :disabled="
                                    item.status_approve_claim ||
                                    item.status_claim_code == 9
                                      ? true
                                      : false
                                  "
                                  class="form-control"
                                  name=""
                                  placeholder=""
                                  value=""
                                />
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="col-md-12">ซอง</div>
                              <div class="col-md-12 in-block">
                                <input
                                  type="number"
                                  v-model="item.pack_quantity"
                                  :disabled="
                                    item.status_approve_claim ||
                                    item.status_claim_code == 9
                                      ? true
                                      : false
                                  "
                                  class="form-control"
                                  name=""
                                  placeholder=""
                                  value=""
                                />
                              </div>
                            </div>
                          </div>
                          <!--row-->
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="row space-8">
                          <button
                            @click="handlePrintBtn(item)"
                            :class="
                              btn_trans.print.class +
                              ' btn-md tw-m-auto tw-mb-3'
                            "
                            type="button"
                          >
                            <i class="fa fa-print"></i>
                          </button>
                        </div>
                        <!--row-->
                        <div class="row space-8">
                          <button
                            :class="
                              btn_trans.cancel.class + ' btn-md  tw-m-auto'
                            "
                            @click="handleCloseClaim(item)"
                            :disabled="chackCloseClaim(item)"
                            type="button"
                          >
                            <i class="fa fa-print"></i> ปิดการเคลม
                          </button>
                        </div>
                        <!--row-->
                      </td>
                      <td class="tw-text-left">
                        <div class="row space-8">
                          <div class="col-md-12">
                            <label>
                              <input
                                type="radio"
                                v-model="item.type_claim"
                                :disabled="
                                  item.check_type_claim ||
                                  item.status_claim_code != 2
                                "
                                placeholder=""
                                value="send_now"
                              />
                              ส่งสินค้าทดแทน
                            </label>
                          </div>
                        </div>
                        <!--row-->
                        <div class="row space-8">
                          <div class="col-md-12">
                            <label>
                              <input
                                type="radio"
                                v-model="item.type_claim"
                                :disabled="
                                  item.check_type_claim ||
                                  item.status_claim_code != 2
                                "
                                placeholder=""
                                value="issue_credit_note"
                              />
                              ออกใบลดหนี้
                            </label>
                          </div>
                        </div>
                        <!--row-->
                        <div class="row space-8">
                          <div class="col-md-12">
                            <label>
                              <input
                                type="checkbox"
                                v-model="item.no_product_claim"
                                :disabled="
                                  item.check_type_claim ||
                                  item.status_claim_code != 2
                                "
                                name=""
                                placeholder=""
                                value="not_send_product_back"
                              />
                              รับสินค้าคืนจากลูกค้า
                            </label>
                          </div>
                        </div>
                        <!--row-->
                        <div class="row space-5">
                          <div class="col-md-12">
                            <label>หมายเหตุ </label>
                          </div>
                        </div>
                        <!--row-->
                        <div class="row space-5">
                          <div class="col-md-12">
                            <textarea
                              :disabled="
                                item.check_type_claim ||
                                item.status_claim_code != 2
                              "
                              v-model="item.input_memo"
                              :class="
                                'form-control ' +
                                (item.validate.input_memo ? 'is-invalid' : '')
                              "
                            ></textarea>
                          </div>
                        </div>
                        <!--row-->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--table-responsive-->
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
@font-face {
  font-family: element-icons;
  src: url(/fonts/element-icons.woff) format("woff"),
    url(/fonts/element-icons.ttf) format("truetype");
  font-weight: 400;
  font-display: "auto";
  font-style: normal;
}
.in-block {
  padding: 0px;
}
textarea {
  font-size: 12px;
}
.input-icon {
  position: relative;
}
.input-icon i.fa-search {
  pointer-events: auto;
  cursor: pointer;
}
.input-icon i {
  position: absolute;
  top: 50%;
  right: 10px;
  opacity: 0.4;
  margin-top: -7px;
  pointer-events: none;
  font-size: 13px;
}
.items-list td:nth-child(2) {
  vertical-align: top;
}
.items-list th:nth-child(2),
.items-list th:nth-child(3) {
  min-width: 450px;
}

.input-group .form-control:hover,
.input-group .form-control:focus {
  border: none;
}
.el-select .el-input .el-select__caret {
  display: none;
}
.el-select.form-control {
  border: none;
  padding: 0px;
}
.claim-order {
  min-width: 145px;
}

.claim-status {
  min-width: 170px;
}
.claim-type-order {
  min-width: 240px;
}
#filter-btn {
  margin: auto;
}
.input-group .form-control {
  border-right: none;
}
.input-group .form-control:hover,
.input-group .form-control:focus {
  border: 1px solid #e5e6e7;
  border-right: none;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  /* display: none; <- Crashes Chrome on hover */
  -webkit-appearance: none;
  margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type="number"] {
  -moz-appearance: textfield; /* Firefox */
}
.table-responsive {
  padding:8px;
}
</style>
<script>
import { MessageBox, Message } from "element-ui";

function convert(str) {
  console.log({str, 'message' : 'แปลงวันที่'})
  
  if(str == null) return null;

  var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
  return [date.getFullYear(), mnth, day].join("-");
}



Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$confirm = MessageBox.confirm;
Vue.prototype.$message = Message;

export default {
  props: {
    btn_trans: Object,
    url_ajax: Object,
    customer_list: Array,
  },
  data() {
    return {
      status: "Procress",
      claim_list: [],
      status_list: [],
      fix_data: false,
      end_date: "",
      filter: {},
      datatable: "",
      isLoading: false,
      claim_number_list: [],
    };
  },
  async mounted() {
    this.getClaimNumber();
    const loading = this.loading();
    await this.getStatusList();
    loading.close();

    this.removeCursurSelectblock();

    this.datatable = $("#datatable").dataTable({
      searching: false,
      ordering: false,
    });
    $('[name="datatable_length"]').css("width", "120px");
  },

  methods: {
    showAttachment(id) {
      $("#" + id).toggle();
    },

    // handleDatepickerFocus() {
    //   setTimeout(() => {
    //     _.each($(".el-date-picker__header-label"), i => {
    //       console.log($(i).html(),'focus element')
    //       switch ($(i).html()) {
    //         case 'February':
    //             $(i).after('กุมภาพันธ์')
    //           break;
    //         case 'March':
    //             $(i).after('มีนาคม')
    //           break;
    //         case 'January':
    //             $(i).after('มกราคม')
    //           break;
    //         case 'April':
    //             $(i).after('เมษายน')
    //           break;
    //         case 'May':
    //             $(i).after('พฤษภาคม')
    //           break;
    //         case 'June':
    //             $(i).after('มิถุนายน')
    //           break;
    //         case 'July':
    //             $(i).after('กรกฎาคม')
    //           break;
    //         case 'August':
    //             $(i).after('สิงหาคม')
    //           break;
    //         case 'September':
    //             $(i).after('กันยายน')
    //           break;
    //         case 'October':
    //             $(i).after('ตุลาคม')
    //           break;
    //         case 'November':
    //             $(i).after('พฤศจิกายน')
    //           break;
    //         case 'December':
    //             $(i).after('ธันวาคม')
    //           break;
    //         default:
    //           break;
    //       }
    //     })
    //   },50)
    // },

    removeCursurSelectblock() {
      _.forEach(document.getElementsByClassName("el-select__caret"), (k) => {
        setTimeout(() => {
          k.remove();
        }, 100);
      });
    },
    toggleRadioApprove(el) {
      var $radio = $(el.target);
      // if this was previously checked
      if ($radio.data("waschecked") == true) {
        $radio.prop("checked", false);
        $radio.data("waschecked", false);
      } else $radio.data("waschecked", true);

      // remove was checked from other radios
      $radio.siblings('input[class="rad"]').data("waschecked", false);
    },
    handleReset() {
      this.end_date = "";
      this.filter = {
        claim_date: "",
      };
      delete this.filter.claim_date;
      this.claim_list = [];
      this.datatable = $("#datatable").dataTable({
        searching: false,
        ordering: false,
      });
      $('[name="datatable_length"]').css("width", "120px");
    },
    handlePrintBtn(item) {
      window.open(
        this.url_ajax.claim_print + "?claim_header_id=" + item.claim_header_id
      );
      // location.href = this.url_ajax.claim_print + "?claim_header_id=" + item.claim_header_id;
    },
    chackCloseClaim(item) {
      if (
        (item.status_approve_claim == "Y" ||
          item.status_approve_claim == "N") &&
        item.status_claim_code != 8
      ) {
        return false;
      }
      return true;
    },
    checkTypeClaim(item) {
      if (item.status_approve_claim == "Y") {
        return false;
      }
      return true;
    },
    loading() {
      const loading = this.$loading({
        lock: true,
        text: "Loading",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)",
      });
      return loading;
    },
    validateConfirm() {
      let not_approve = _.filter(
        this.claim_list,
        (o) =>
          o.approve_type == "N" &&
          !(o.status_approve_claim == "Y" || o.status_approve_claim == "N")
      );
      let approve = _.filter(
        this.claim_list,
        (o) =>
          (o.approve_type == "Y" && o.status_claim_code == 2 && o.type_claim) ||
          (o.status_claim_code == 2 &&
            o.approve_type == "Y" &&
            o.status_approve_claim == null)
      );

      let invalid = false;
      // validate not approve
      _.forEach(not_approve, (o) => {
        o.validate.approve_text = false;

        if (
          o.approve_text == null ||
          o.approve_text == "" ||
          typeof o.approve_text == "undefined"
        ) {
          invalid = true;
          o.validate.approve_text = true;
        }
      });

      // validate  approve
      _.forEach(approve, (o) => {
        o.validate.approve_text = false;
        o.validate.input_memo = false;
        if (
          o.approve_text == null ||
          o.approve_text == "" ||
          typeof o.approve_text == "undefined"
        ) {
          invalid = true;
          o.validate.approve_text = true;
        }

        if (
          o.approve_type == "Y" &&
          (o.type_claim == "send_now" || o.type_claim == "issue_credit_note") &&
          !o.input_memo
        ) {
          invalid = true;
          o.validate.input_memo = true;
        }
      });

      return invalid;
    },
    async handleCloseClaim(item) {
      await swal(
        {
          title: "แจ้งเตือน",
          text: "ยืนยันการทำรายการปิดการเคลมหรือไม่?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "ตกลง",
          closeOnConfirm: false,
        },
        async () => {
          swal.close();
          const loading = this.loading();
          await this.callData(this.url_ajax.close_header, item)
            .then(async (res) => {
              await this.handleFilter();
              this.notic("success", "ทำรายการเรียบร้อย");
            })
            .catch((ex) => {});
          loading.close();
        }
      );
    },
    async handleSubmitForm() {
      console.log("##### handle Submit Form ######");
      if (this.validateConfirm() == true) {
        this.notic("error", "กรอกข้อมูลให้ครบถ่วน");
        return false;
      }

      await swal(
        {
          title: "แจ้งเตือน",
          text: "ยืนยันการทำรายการนี้หรือไม่?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "ตกลง",
          closeOnConfirm: false,
        },
        async () => {
          swal.close();
          await this.confirmSubmit();
          return false;
        }
      );
    },
    async confirmSubmit() {
      const loading = this.loading();
      let data = _.filter(
        this.claim_list,
        (o) =>
          (o.approve_type == "N" &&
            !(
              o.status_approve_claim == "Y" || o.status_approve_claim == "N"
            )) ||
          (o.approve_type == "Y" && o.status_claim_code == 2 && o.type_claim) ||
          (o.status_claim_code == 2 &&
            o.approve_type == "Y" &&
            o.status_approve_claim == null)
      );
      console.log("call handleSubmitForm", data);
      if (data.length == 0) {
        this.notic("warning", "กรุณาเลือกข้อมูลที่ต้องการทำรายการ");
        loading.close();
        return false;
      }

      await this.callData(this.url_ajax.update_header, data)
        .then(async (res) => {
          await this.handleFilter();
          this.$message({
            message: "ทำรายการเรียบร้อย",
            type: "success",
          });
        })
        .catch((ex) => {});
      loading.close();
    },
    notic(type, mes) {
      this.$message({
        title: "แจ้งเตือน",
        message: mes,
        type: type,
      });
    },
    async changeEDate($event) {
      this.filter.claim_date = this.dateFormat($event);
    },
    async callData(url, data = []) {
      const promis = axios.post(url, data);
      promis.catch((ex) => this.notic("error", "ไม่สามารถทำรายการได้"));
      return promis;
    },
    async dateFormat(date) {
      let d = new Date(date);
      return d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
    },
    async handleChangeSearchCustomerNumber(value, $event) {
      const loading = this.loading();
      console.log("loader progress", loading, value);
      this.filter.customer_id = value;
      await _.forEach(this.customer_list, (item) => {
        if (item.customer_id == value) {
          this.filter.customer_name = item.customer_name;
          this.filter.customer_number = item.customer_number;
        }
      });
      if(value == '') {
        this.filter.customer_name = '';
        this.filter.customer_number = '';
      }

      await this.getClaimNumber();
      setTimeout(() => {
        loading.close();
      },500)
    },

    handleChangeClaimNumber() {
      let customer_id = _.filter(this.claim_number_list, (item) => {
        return item.claim_number === this.filter.claim_number;
      });
      let customer = _.filter(this.customer_list, (cus) => {
        return cus.customer_id == customer_id[0].customer_id;
      });
      if (customer[0]) {
        this.filter.customer_id = customer_id[0].customer_id;
        this.filter.customer_name = customer[0].customer_name;
        this.filter.customer_number = customer[0].customer_number;
      } else {
        this.filter.customer_id = "";
        this.filter.customer_name = "";
        this.filter.customer_number = "";
      }
    },
    async getClaimNumber() {
      await axios
        .post(this.url_ajax.take_claim_number, {
          customer_number: this.filter.customer_id,
        })
        .then((res) => {
          this.claim_number_list = res.data;
        });
    },
    attachmentBind(att) {
      switch (att) {
        case "1":
          return "Attach Photo Cardbox boxes (Front Side)";
          break;
        case "2":
          return "Attach Photo MFG Date (Beside)";
          break;
        case "3":
          return "Attach Photo Good Damaged";
          break;
        default:
          break;
      }
    },
    async getStatusList() {
      await this.callData(this.url_ajax.list_status)
        .then((res) => {
          if (res.status == 200) this.status_list = res.data;
        })
        .catch((ex) => {});
    },
    async handleFilter($event) {
      this.datatable.fnDestroy();
      const loading = this.loading();
      this.filter.claim_date = convert(this.filter.claim_date)
      await this.callData(this.url_ajax.list_claim, this.filter)
        .then((res) => {
          if (res.status == 200) {
            this.claim_list = res.data;
            _.map(this.claim_list, (o) => {
              this.$set(o, "validate", {
                approve_text: false,
                input_memo: false,
              });
              this.$set(o, "type_claim", "");
              o.no_product_claim =
                o.cancle_deliver_flag == "Y" ? "not_send_product_back" : null;
              o.type_claim =
                o.replacement_flag == "Y"
                  ? "send_now"
                  : o.replacement_flag == "N"
                  ? "issue_credit_note"
                  : null;
              o.input_memo = o.cancle_deliver_remark;
              o.approve_text = o.remark_approve;
              o.approve_type = o.status_approve_claim;
              o.check_type_claim = this.checkTypeClaim(o);
            });
          }
        })
        .catch((ex) => {});
      this.datatable = $("#datatable").dataTable({
        searching: false,
        ordering: false,
      });
      $('[name="datatable_length"]').css("width", "120px");
      loading.close();
    },
  },
};
</script>