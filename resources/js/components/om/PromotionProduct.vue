<template>
  <div
    class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4"
    v-loading="loading"
  >
    <!--justify-content-md-center-->
    <div class="col-xl-12">
      <div class="form-header-buttons">
        <div class="buttons d-flex">
          <button
            type="button"
            v-on:click="clearData()"
            class="btn btn-lg btn-default"
          >
            <i class="fa fa-repeat"></i> เคลียร์
          </button>
          <button
            class="btn btn-lg btn-white"
            type="button"
            v-on:click="searchPromotion()"
          >
            <i class="fa fa-search"></i> ค้นหา
          </button>
          <button
            class="btn btn-lg btn-success"
            type="button"
            :disabled="type == 'copy'"
            v-on:click="runNumber()"
          >
            <i class="fa fa-plus"></i> สร้าง
          </button>
          <!-- <button
            class="btn btn-lg btn-danger"
            type="button" :disabled="type == 'copy'"
            v-on:click="removePromotion()"
          >
            <i class="fa fa-times"></i> ลบ
          </button> -->
          <!-- <button
                class="btn btn-lg btn-info"
                type="button" :disabled="type == 'copy'"
                v-on:click="copyPromotion()"
            >
                <i class="fa fa-copy"></i> คัดลอก
            </button> -->
          <button
            class="btn btn-lg btn-primary"
            type="button"
            v-on:click="savePromotion()"
            :disabled="fix_data"
          >
            <i class="fa fa-save"></i> บันทึก
          </button>
        </div>
      </div>

      <div class="hr-line-dashed"></div>
    </div>
    <div class="col-xl-6 m-auto">
      <div class="form-group">
        <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
        <label class="d-block">รหัสโปรโมชั่น</label>
        <el-select
          v-model="run_number"
          filterable
          style="width: 100%"
          :disabled="created"
          placeholder=""
        >
          <el-option
            v-for="(item, i) in promotions"
            :key="i"
            :value="item.promotion_code"
          >
          </el-option>
        </el-select>
        <!-- <div class="input-icon">
          <input
            type="text"
            class="form-control"
            placeholder=""
            id="promotion_code" autocomplete="off"
            v-model="run_number"
          />
          <i class="fa fa-search"></i>
        </div> -->
      </div>
      <!--form-group-->

      <div class="form-group">
        <label class="d-block">รายละเอียด</label>
        <el-input
          type="textarea"
          :rows="2"
          placeholder="รายละเอียด"
          autocomplete="off"
          v-model="detail"
        >
        </el-input>
      </div>
      <!-- <div class="input-icon">

          <i class="fa fa-search"></i>
        </div> -->
      <div class="form-group row" style="margin-bottom: 1rem !important">
        <div class="col-md-6">
          <label class="d-block">วันที่เริ่มใช้งาน</label>
          <datepicker-th
            style="width: 100%"
            class="form-control"
            v-model="start_date"
            id="start_date"
            placeholder="วันที่เริ่มใช้งาน"
            :value="start_date"
            :disabled="fix_data"
            @dateWasSelected="changeSDate($event)"
            disabled-date="2021-07-15"
            format="DD/MM/Y"
          ></datepicker-th>
        </div>

        <div class="col-md-6">
          <label class="d-block">วันที่สิ้นสุด</label>
          <datepicker-th
            style="width: 100%"
            class="form-control"
            name="end_date"
            id="end_date"
            v-model="end_date"
            placeholder="วันที่สิ้นสุด"
            :value="end_date"
            @dateWasSelected="changeEDate($event)"
            format="DD/MM/Y"
          ></datepicker-th>
        </div>
        <!--row-->
      </div>
      <!--form-group-->

      <div class="form-group">
        <label class="d-block">สถานะ</label>
        <select
          class="custom-select"
          id="status"
          name="status"
          v-model="status"
        >
          <option :value="'Active'" selected="selected">Active</option>
          <option :value="'Inactive'">Inactive</option>
        </select>
      </div>

      <!-- v-if="!created" -->
      <!-- <div class="form-buttons no-border">
        <button
          class="btn btn-lg btn-white"
          type="button"
          v-on:click="searchPromotion()"
        >
          <i class="fa fa-search"></i> ค้นหา
        </button>
      </div> -->
    </div>
    <div
      class="col-xl-8 m-auto mt-10 mb-10"
      style="margin-top: 20px !important"
      v-if="search"
    >
      <table class="table table-bordered table-hover text-center custom-tb">
        <thead>
          <tr class="align-middle text-center">
            <th>รหัสโปรโมชั่น</th>
            <th>วันที่เริ่ม</th>
            <th>วันสิ้นสุด</th>
            <th>สถานะ</th>
            <th>รายละเอียด</th>
          </tr>
        </thead>
        <tbody
          style="
            max-height: calc(80vh - 7rem);
            height: auto;
            overflow-y: scroll;
          "
        >
          <tr v-for="item in searchDataPromotion" :key="item.promotion_id">
            <td>{{ item.promotion_code }}</td>
            <td>{{ item.start_date }}</td>
            <td>{{ item.end_date != null ? item.end_date : "-" }}</td>
            <td>{{ item.status }}</td>
            <td>
              <a
                href="javascript:void(0)"
                @click="viewPromotionDetail(item.promotion_code)"
              >
                <i class="fa fa-newspaper-o"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--col-xl-6-->

    <div class="col-xl-12 m-auto" v-if="created">
      <hr class="lg" />

      <div class="form-header-buttons">
        <h3
          class="title black m-md-0 mb-2"
          data-toggle="collapse"
          data-target="#collapse_01"
          aria-expanded="true"
        >
          <span class="icon-collapse"><span class="icon"></span></span>
          กลุ่มผลิตภัณฑ์
        </h3>
        <div class="buttons d-flex">
          <button
            class="btn btn-md btn-success"
            type="button"
            v-on:click="addGroupProduct()"
          >
            <i class="fa fa-plus"></i> สร้าง
          </button>
          <button
            class="btn btn-md btn-danger"
            type="button"
            v-on:click="removeGroupProduct()"
          >
            <i class="fa fa-times"></i> ลบ
          </button>
        </div>
      </div>

      <div class="hr-line-dashed"></div>

      <div
        id="collapse_01"
        :class="'table-responsive-md collapse ' + active_collapse + ''"
      >
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr class="align-middle text-center">
              <th class="w-90">Select</th>
              <th class="w-160">กลุ่มผลิตภัณฑ์</th>
              <th class="w-250">รหัสผลิตภัณฑ์</th>
              <th>ชื่อผลิตภัณฑ์</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="align-middle"
              v-for="(sItem, sIndex) in seleted_products"
              :key="sIndex"
            >
              <td class="w-90">
                <input
                  type="checkbox"
                  :value="sIndex"
                  :checked="sItem.selected"
                  v-on:change="changeGroupChecked(sIndex)"
                  :disabled="fix_data"
                />
              </td>
              <td class="w-160">
                <el-input
                  v-model="sItem.group"
                  @change="changeGroupProductId($event, sIndex)"
                  :disabled="fix_data"
                ></el-input>
                <!-- <input
                  type="text"
                  class="form-control text-center"
                  :value="sItem.group"
                  v-on:keyup="changeGroupProductId($event, sIndex)"
                /> -->
              </td>
              <td class="td-relative w-250">
                <el-select
                  v-model="sItem.item_code"
                  filterable
                  remote
                  reserve-keyword
                  :remote-method="remoteMethod"
                  placeholder="Select"
                  @change="groupProductChanged($event, sIndex)"
                  :disabled="fix_data"
                >
                  <el-option
                    v-for="(item, i) in product_options"
                    v-if="!sourceCheckDupChanged(item.item_code)"
                    :key="i"
                    :value="item.item_code"
                  >
                    {{ item.item_code + " : " + item.ecom_item_description }}
                  </el-option>
                </el-select>
              </td>
              <td class="text-left">{{ sItem.ecom_item_description }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--table-responsive-md-->
      <div class="form-header-buttons">
        <h3
          class="title black m-md-0 mb-2"
          data-toggle="collapse"
          data-target="#collapse_02"
          aria-expanded="true"
        >
          <span class="icon-collapse"><span class="icon"></span></span>
          กลุ่มรายการซื้อ
        </h3>
        <div class="buttons d-flex">
          <button
            class="btn btn-md btn-success"
            type="button"
            v-on:click="addProduct()"
            :disabled="created_group"
          >
            <i class="fa fa-plus"></i> สร้าง
          </button>
          <button
            class="btn btn-md btn-danger"
            type="button"
            v-on:click="removeProduct()"
            :disabled="created_group"
          >
            <i class="fa fa-times"></i> ลบ
          </button>
        </div>
      </div>

      <div class="hr-line-dashed"></div>

      <div
        id="collapse_02"
        :class="'table-responsive-md collapse ' + active_collapse + ''"
      >
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr class="align-middle text-center">
              <th class="w-90" rowspan="2">Select</th>
              <th class="w-160" rowspan="2">กลุ่มรายการซื้อ</th>
              <th class="w-160" rowspan="2">กลุ่มผลิตภัณฑ์</th>
              <th colspan="2">จำนวนสั่งซื้อรวม</th>
              <th colspan="2">ต้องไม่เกิน</th>
              <!-- <th class="w-160" rowspan="2">Condition</th> -->
            </tr>
            <tr class="align-middle text-center">
              <!--จำนวนสั่งซื้อรวม-->
              <th class="w-120">จำนวน</th>
              <th class="w-120">หน่วย</th>

              <!--ต้องไม่เกิน-->
              <th class="w-120">จำนวน</th>
              <th class="w-120">หน่วย</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="align-middle"
              v-for="(item, index) in seleted_orders"
              v-bind:key="'tr' + index"
            >
              <td>
                <input
                  type="checkbox"
                  :value="index"
                  :checked="item.selected"
                  v-on:change="changeOrderChecked(index)"
                  :disabled="fix_data"
                />
              </td>
              <td>
                <el-input v-model="item.group" :disabled="fix_data"></el-input>
              </td>
              <td>
                <el-select
                  v-model="item.group_product"
                  filterable
                  placeholder="Select"
                  @change="sourceGropChanged($event, index)"
                  :disabled="fix_data"
                >
                  <el-option
                    v-for="(iprod, ip) in unit_group_products"
                    v-if="!sourceGropCheckDupChanged(iprod)"
                    :key="ip"
                    :value="iprod"
                  >
                  </el-option>
                </el-select>
                <!-- <div class="input-icon">
                  <input
                    type="text"
                    class="form-control"
                    :id="'group_product_' + index"
                    placeholder=""
                    :value="item.group_product"
                    v-on:input="sourceGropChanged($event, index)"
                    list="group-product-list"
                  />
                  <i class="fa fa-search"></i>
                  <datalist id="group-product-list">
                    <option
                      v-for="(iprod, i) in seleted_products"
                      v-if="!sourceGropCheckDupChanged(iprod.group)"
                      v-bind:key="i"
                      :value="iprod.group"
                    ></option>
                  </datalist>
                </div> -->
              </td>

              <td>
                <el-input
                  v-model="item.order_amount"
                  @input="changeOrderAmount(index)"
                  :disabled="fix_data"
                ></el-input>
              </td>
              <td>
                <el-select
                  v-model="item.order_unit"
                  filterable
                  placeholder="Select"
                  @change="changeOrderUnit($event, index)"
                  :disabled="fix_data"
                >
                  <el-option
                    v-for="iu in uom"
                    :key="iu.uom_id"
                    :label="iu.unit_of_measure"
                    :value="iu.uom_code"
                  >
                  </el-option>
                </el-select>
                <!-- <select class="form-control select2" placeholder="Select" @change="changeOrderUnit($event, index)">
                    <option
                    v-for="iu in uom"
                    :key="iu.uom_id"
                    :selected="iu.uom_code == item.order_unit"
                    :value="iu.uom_code">
                      {{ iu.unit_of_measure }}
                    </option>
                </select> -->
              </td>

              <td>
                <el-input
                  v-model="item.max_amount"
                  @input="changeOrderMaxAmount(index)"
                  :disabled="fix_data"
                ></el-input>
              </td>
              <td>
                <el-select
                  v-model="item.max_unit"
                  filterable
                  placeholder="Select"
                  @change="changeMaxUnit($event, index)"
                  :disabled="fix_data"
                >
                  <el-option
                    v-for="iu in uom"
                    :key="iu.uom_id"
                    :label="iu.unit_of_measure"
                    :value="iu.uom_code"
                  >
                  </el-option>
                </el-select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--table-responsive-md-->
      <div class="form-header-buttons">
        <h3
          class="title black m-md-0 mb-2"
          data-toggle="collapse"
          data-target="#collapse_03"
          aria-expanded="true"
        >
          <span class="icon-collapse"><span class="icon"></span></span>
          รายการส่งเสริมการตลาด
        </h3>
        <div class="buttons d-flex">
          <button
            class="btn btn-md btn-success"
            type="button"
            v-on:click="addProductGift()"
          >
            <i class="fa fa-plus"></i> สร้าง
          </button>
          <button
            class="btn btn-md btn-danger"
            type="button"
            v-on:click="removeProductGift()"
          >
            <i class="fa fa-times"></i> ลบ
          </button>
        </div>
      </div>

      <div class="hr-line-dashed"></div>

      <div
        id="collapse_03"
        :class="'table-responsive-md collapse ' + active_collapse + ''"
      >
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr class="align-middle text-center">
              <th class="w-90" rowspan="2">Select</th>
              <th rowspan="2" class="w-160">กลุ่มรายการ<br />ส่งเสริมซื้อ</th>
              <th rowspan="2" class="w-160">รหัสผลิตภัณฑ์</th>
              <th rowspan="2" class="w-160">ชื่อผลิตภัณฑ์</th>
              <th colspan="2">จำนวนของแถม</th>
            </tr>
            <tr class="align-middle text-center">
              <!--ต้องไม่เกิน-->
              <th class="w-120">จำนวนแถม</th>
              <th class="w-120">หน่วย</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="align-middle"
              v-for="(gItem, gIndex) in seleted_gift"
              v-bind:key="gIndex"
            >
              <td>
                <input
                  type="checkbox"
                  :value="gIndex"
                  :checked="gItem.selected"
                  v-on:change="changeGiftChecked(gIndex)"
                  :disabled="fix_data"
                />
              </td>
              <td>
                <el-input
                  v-model="gItem.group"
                  @change="changeGroupGift($event, gIndex)"
                  :disabled="fix_data"
                ></el-input>
              </td>
              <td class="td-relative">
                <el-select
                  v-model="gItem.item_code"
                  filterable
                  remote
                  reserve-keyword
                  :remote-method="remoteMethod"
                  placeholder="Select"
                  @change="sourceGiftChanged($event, gIndex, gItem.group)"
                  :disabled="fix_data"
                >
                  <el-option
                    v-for="(item, i) in product_options"
                    v-if="
                      !sourceGifCheckDupChanged(
                        item.item_code,
                        gIndex,
                        gItem.group
                      )
                    "
                    :key="i"
                    :value="item.item_code"
                  >
                    {{ item.item_code + " : " + item.ecom_item_description }}
                  </el-option>
                </el-select>
                <!-- <div class="input-icon">
                  <input
                    type="text"
                    class="form-control"
                    :id="'gift_item_id_' + gIndex"
                    :value="gItem.item_code"
                    v-on:input="sourceGiftChanged($event, gIndex)"
                    list="customer-gift-list"
                  />
                  <i class="fa fa-search"></i>
                  <datalist id="customer-gift-list">
                    <option
                      v-for="(item, i) in products"
                      :data-name="item.ecom_item_description"
                      :data-value="item.item_code"
                      v-bind:key="i + '_' + gIndex"
                    >
                      {{
                        item.item_code + " : " + item.ecom_item_description
                      }}
                    </option>
                  </datalist>
                </div> -->
              </td>
              <td>{{ gItem.ecom_item_description }}</td>
              <td>
                <el-input
                  v-model="gItem.amount"
                  :disabled="fix_data"
                ></el-input>
              </td>
              <td>
                <el-select
                  v-model="gItem.unit"
                  filterable
                  placeholder="Select"
                  :disabled="fix_data"
                >
                  <el-option
                    v-for="iu in uom"
                    :key="iu.uom_id"
                    :label="iu.unit_of_measure"
                    :value="iu.uom_code"
                  >
                  </el-option>
                </el-select>
                <!-- <select class="form-control" placeholder="Select" @change="changeGiftUnit($event, gIndex)">
                    <option
                    v-for="iu in uom"
                    :key="iu.uom_id"
                    :selected="iu.uom_code == gItem.unit"
                    :value="iu.uom_code">
                      {{ iu.unit_of_measure }}
                    </option>
                </select> -->
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="form-header-buttons">
        <h3
          class="title black m-md-0 mb-2"
          data-toggle="collapse"
          data-target="#collapse_04"
          aria-expanded="true"
        >
          <span class="icon-collapse"><span class="icon"></span></span>
          ร้านค้าที่ร่วมรายการส่งเสริมการตลาด
        </h3>
        <!-- <div class="buttons d-flex">
              <button class="btn btn-md btn-success" type="button"><i class="fa fa-plus"></i> เพิ่มร้านค้า</button>
              <button class="btn btn-md btn-danger" type="button"><i class="fa fa-times"></i> ลบ</button>
          </div> -->
      </div>

      <div class="hr-line-dashed"></div>

      <div id="collapse_04" :class="'collapse ' + active_collapse + ''">
        <div>
          <label
            ><input
              type="radio"
              v-model="isCheckAll"
              value="all"
              v-on:click="checkAllCustomer()"
              :disabled="fix_data"
            />&nbsp;ทุกร้าน</label
          >
        </div>

        <div>
          <label>
            <input
              type="radio"
              v-model="isCheckAll"
              value="by"
              v-on:click="checkByCustomer()"
              :disabled="fix_data"
            />
            <span>เฉพาะร้าน</span>
          </label>
        </div>

        <div
          class="table-responsive-md mt-3"
          v-bind:style="[
            customers_all ? { display: 'none' } : { display: 'block' },
          ]"
        >
          <table class="table table-bordered table-hover text-center custom-tb">
            <thead>
              <tr class="align-middle text-center">
                <th class="w-90">Select</th>
                <th class="w-90">ลำดับ</th>
                <th>รหัสร้านค้า</th>
                <th>ชื่อร้านค้า</th>
                <th>เริ่มโปรโมชั่นหน่วยที่</th>
                <th>หน่วย</th>
              </tr>
            </thead>
            <tbody    style="
                    max-height: calc(100vh - 7rem);
                    overflow-y: scroll;
                    overflow-y: auto;
                  ">
              <tr
                class="align-middle"
                v-for="(item, index) in customerSelected"
                v-bind:key="index"
              >
                <td class="w-90">
                  <el-checkbox
                    v-model="item.checked"
                    @change="upcheckCustomer(index)"
                  ></el-checkbox>
                  <!-- <div class="i-checks wihtout-text m-auto">
                    <label>
                      <input
                        type="checkbox"
                        v-bind:value="item"
                        checked
                        v-model="customerSelected"
                      />
                    </label>
                  </div> -->
                </td>
                <td class="w-90">{{ index + 1 }}</td>
                <td>{{ item.customer_number }}</td>
                <td>{{ item.customer_name }}</td>
                <td>
                  <el-input
                    v-model="item.amount"
                    :disabled="fix_data"
                  ></el-input>
                  <!-- <input
                    type="text"
                    class="form-control text-center"
                    v-model="item.amount"
                  /> -->
                </td>
                <td>
                  <el-select
                    v-model="item.uom"
                    filterable
                    placeholder="Select"
                    :disabled="fix_data"
                  >
                    <el-option
                      v-for="iu in uom"
                      :key="iu.uom_id"
                      :label="iu.unit_of_measure"
                      :value="iu.uom_code"
                    >
                    </el-option>
                  </el-select>
                  <!-- <select class="form-control" placeholder="Select" v-model="item.uom">
                    <option
                    v-for="iu in uom"
                    :key="iu.uom_id"
                    :selected="iu.uom_code == item.uom"
                    :value="iu.uom_code">
                      {{ iu.uom_code }}
                    </option>
                  </select> -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!--table-responsive-md-->

      <div
        class="modal fade"
        id="shopModal"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span
              ><span class="sr-only">Close</span>
            </button>
            <div class="modal-body text-center">
              <div class="mb-3">
                  <div class="row">
                      <div class="col-12 text-left">
                            <h3 class="black m-md-0 mb-2">เลือกร้านค้าที่ร่วมรายการ</h3>
                            <div class="form-group">
                              <label for="">ภาค: </label>
                              <input
                                  type="text"
                                  class="form-control"
                                  placeholder=""
                                  v-on:keyup="searchCustomer($event, 'Region')"
                                  style=""
                              />
                            </div>
                            <div class="form-group">
                              <label for="">จังหวัด:</label>
                              <input
                                  type="text"
                                  class="form-control"
                                  placeholder=""
                                  v-on:keyup="searchCustomer($event, 'Province')"
                                  style=""
                              />
                            </div>
                            <div class="form-group">
                              <label for="">ชื่อร้านค้า: </label>
                              <input
                                  type="text"
                                  class="form-control"
                                  placeholder=""
                                  v-on:keyup="searchCustomer($event, 'Name')"
                                  style=""
                              />
                            </div>
                            <div class="form-group">
                              <label for="">ประเภทร้านค้า: </label>
                              <input
                                  type="text"
                                  class="form-control"
                                  placeholder=""
                                  v-on:keyup="searchCustomer($event, 'Type')"
                                  style=""
                              />
                            </div>
                            
                      </div>
                  <!-- </div>
                  <div class="row" style="margin-top: 10px;"> -->
                    <div class="col-6 text-left">
                        <div class="buttons">
                         <button
                                class="btn btn-md btn-white"
                                type="button"
                                v-on:click="checkModalAllCustomer()"
                            >
                                เลือกทั้งหมด
                            </button>
                            <button
                                class="btn btn-md btn-white"
                                type="button"
                                v-on:click="removeAllCustomer()"
                            >
                                เอาออกทั้งหมด
                            </button>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="buttons">
                            <input type="file" name="file-upload" @change="onFileChange">
                            <button
                                class="btn btn-md btn-primary"
                                type="button"
                                v-on:click="importCustomer()"
                            >
                                <i class="fa fa-save"></i> Import File
                            </button>

                            <button
                                class="btn btn-md btn-primary"
                                type="button"
                                v-on:click="saveSelectByCustomer()"
                            >
                                <i class="fa fa-save"></i> บันทึก
                            </button>
                        </div>
                    </div>
                </div>

              </div>
              <table
                class="table table-bordered table-hover text-center custom-tb"
              >
                <thead>
                  <tr class="align-middle text-center">
                    <th>เลือก</th>
                    <th>รหัสร้านค้า</th>
                    <th>ชื่อร้านค้า</th>
                    <th>เริ่มโปรโมชั่นหน่วยที่</th>
                    <th>หน่วย</th>
                  </tr>
                </thead>
                <tbody
                  style="
                    max-height: calc(100vh - 22rem);
                    overflow-y: scroll;
                    overflow-y: auto;
                  "
                >
                  <!-- <tr
                    class="align-middle"
                    v-for="(mitem, index) in customerModalList"
                    v-bind:key="index" v-if="mitem.checked"
                  >
                    <td>
                      <el-checkbox v-model="mitem.checked"></el-checkbox>
                    </td>
                    <td>{{ mitem.customer_number }}</td>
                    <td>{{ mitem.customer_name }}</td>
                    <td>
                      <el-input v-model="mitem.amount"></el-input>
                    </td>
                    <td>
                      <el-select v-model="mitem.uom" filterable placeholder="Select">
                          <el-option v-for="(mu,im) in muom" :key="im" :label="mu.unit_of_measure" :value="mu.uom_code"></el-option>
                      </el-select>
                    </td>
                  </tr> -->
                  <tr
                    class="align-middle"
                    v-for="(mitem, mindex) in customerSetStore"
                    v-bind:key="'m' + mindex"
                    v-if="mitem.checked"
                  >
                    <td>
                      <el-checkbox v-model="mitem.checked"></el-checkbox>
                      <!-- <input
                        type="checkbox"
                        v-bind:value="mitem"
                        v-on:click="checkedCustomerModal(mitem,mindex)"
                      /> -->
                    </td>
                    <td>{{ mitem.customer_number }}</td>
                    <td>{{ mitem.customer_name }} <br> <small>{{ mitem.region_code }}/ {{ mitem.province_name }}</small></td>
                    <td>
                      <el-input v-model="mitem.amount"></el-input>
                      <!-- <input
                        type="text"
                        v-model="mitem.amount"
                        class="form-control text-center"
                      /> -->
                    </td>
                    <td>
                      <el-select
                        v-model="mitem.uom"
                        filterable
                        placeholder="Select"
                      >
                        <el-option
                          v-for="(mu, im) in muom"
                          :key="im"
                          :label="mu.unit_of_measure"
                          :value="mu.uom_code"
                        ></el-option>
                      </el-select>
                      <!-- <select class="form-control" placeholder="Select" v-model="mitem.uom">
                        <option
                        v-for="iu in uom"
                        :key="iu.uom_id"
                        :selected="iu.uom_code == mitem.uom"
                        :value="iu.uom_code">
                          {{ iu.uom_code }}
                        </option>
                      </select> -->
                    </td>
                  </tr>
                  <tr
                    class="align-middle"
                    v-for="(mitem, mindex) in customerSetStore"
                    v-bind:key="'m' + mindex"
                    v-if="!mitem.checked"
                  >
                    <td>
                      <el-checkbox v-model="mitem.checked"></el-checkbox>
                      <!-- <input
                        type="checkbox"
                        v-bind:value="mitem"
                        v-on:click="checkedCustomerModal(mitem,mindex)"
                      /> -->
                    </td>
                    <td>{{ mitem.customer_number }}</td>
                    <td>{{ mitem.customer_name }}</td>
                    <td>
                      <el-input v-model="mitem.amount" class="text-center"></el-input>
                      <!-- <input
                        type="text"
                        v-model="mitem.amount"
                        class="form-control text-center"
                      /> -->
                    </td>
                    <td>
                      <el-select
                        v-model="mitem.uom"
                        filterable
                        placeholder="Select"
                      >
                        <el-option
                          v-for="(mu, im) in muom"
                          :key="im"
                          :label="mu.unit_of_measure"
                          :value="mu.uom_code"
                        ></el-option>
                      </el-select>
                      <!-- <select class="form-control" placeholder="Select" v-model="mitem.uom">
                        <option
                        v-for="iu in uom"
                        :key="iu.uom_id"
                        :selected="iu.uom_code == mitem.uom"
                        :value="iu.uom_code">
                          {{ iu.uom_code }}
                        </option>
                      </select> -->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--col-xl-12-->
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      selectFiles:null,
      timmer:null,
      loading:false,
      active_collapse: "show",
      created: false,
      search: false,
      modalSearch: {
        region: '',
        province: '',
        name: '',
        type: '',
      },
      search_cus: "",
      searchDataPromotion: [],
      type_save: "store",
      all_customer: true,
      run_number: "",
      start_date: "",
      end_date: "",
      detail: "",
      fix_data: false,
      status: "Active",
      promotions: [],
      product_options: [],
      products: [],
      products_selected: [],
      products_gif_selected: [],
      customers: [],
      created_group: true,
      uom: [],
      muom: [],
      type: "",
      condition: ["AND", "OR"],
      customers_all: true,
      customers_selected: [],
      customers_modal_selected: [],
      isCheckAll: "all",
      customerSetStore: [],
      customerAllSelected: false,
      customerSelected: [],
      customerModalAll: [],
      customerModalList: [],
      customerModalListSelected: [],
      customerModalSelected: [],
      seleted_group_products: [],
      unit_group_products: [],
      seleted_products: [
        // {
        //   selected: 1,
        //   group: "1",
        //   item_id: "",
        //   item_code: "",
        //   item_description: "",
        // },
      ],
      seleted_orders: [
        // {
        //   selected: 1,
        //   group: "1",
        //   group_product: "1",
        //   order_amount: "1",
        //   order_unit: "หีบ",
        //   max_amount: "1",
        //   max_unit: "หีบ",
        //   condition: "AND",
        // },
      ],
      seleted_gift: [
        // {
        //   selected: 1,
        //   group: "1",
        //   item_id: "",
        //   item_code: "",
        //   item_description: "",
        //   amount: "1",
        //   unit: "หีบ",
        // },
      ],
    };
  },
  mounted() {
    this.getAllPromotion();
    this.getAllProduct();
    this.allCustomer();
    this.allUom();
    this.getParams();
    this.setCustomerModal();
  },
  methods: {
    clearData() {
      var vm = this;

      $("#promotion_code").prop("readonly", false);
      $("#collapse_01").collapse("hide");
      $("#collapse_02").collapse("hide");
      $("#collapse_03").collapse("hide");
      $("#collapse_04").collapse("hide");
      vm.type_save = "store";
      vm.run_number = "";
      vm.isCheckAll = "all";
      vm.created = false;
      vm.search = false;
      vm.customers_all = true;
      vm.searchDataPromotion = [];
      vm.seleted_products = [];
      vm.seleted_orders = [];
      vm.seleted_gift = [];
      vm.customerSelected = [];
      vm.seleted_group_products = [];
      vm.customerSelected = [];
      vm.detail = "";
      vm.start_date = "";
      vm.end_date = "";
      vm.fix_data = false;
      vm.selectFiles = '';
      vm.created_group = true;
      vm.removeAllCustomer();
    },
    importCustomer() {
      const form = new FormData();
      form.append('file', this.selectFiles[0]);
      form.append('_token', $("meta[name='csrf-token']").attr('content'));
      // submit the image
      $.ajax({
          url: '',
          type: "POST",
          processData: false, 
          data: form,
          contentType: false 
        })
        .done((result) => {
          let number_missing = [];
          _.each(result.customer_number, (i) => {
            let c = _.filter(this.customerSetStore, v => {
              return v.customer_number === i
            })
            if(c.length > 0) {
              c[0].checked = true
            }else {
              number_missing.push(i);
            }
          })

          if(number_missing.length > 0) {
            swal('แจ้งเตือน', 'ค้นหา Customer number '+ number_missing.join(', ') + 'ไม่พบ', 'info')
          }
          this.detail = result.note;
        })
        .catch(function() {

        });
    },
    onFileChange(e) {
      this.selectFiles = e.target.files || e.dataTransfer.files;
    },
    searchCustomer(e, type = '') {
        let type_search = '';
        if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
        }
        switch (type) {
          case 'Name':
            type_search = 'customer_name'
            this.modalSearch.name = e.target.value.toLowerCase()
            break;
          case 'Type':
            type_search = 'meaning'
            this.modalSearch.type = e.target.value.toLowerCase()
            break;
          case 'Region':
            type_search = 'region_code'
            this.modalSearch.region = e.target.value.toLowerCase()
            break;
          case 'Province':
            type_search = 'province_name'
            this.modalSearch.province = e.target.value.toLowerCase()
            break;
          default:
            type_search = 'customer_name'
            this.modalSearch.name = e.target.value.toLowerCase()
            break;
        }
        this.timer = setTimeout(() => {
          this.customerSetStore = this.customerModalAll.filter((item) => {
            let condition1 = true;
            let condition2 = true;
            let condition3 = true;
            let condition4 = true;
            if(this.modalSearch.region != '') {
              condition1 = (
                            (item.customer_number
                              .toLowerCase()
                              .indexOf(this.modalSearch.region)) > -1 || (item['region_code']
                              .toLowerCase()
                              .indexOf(this.modalSearch.region)) > -1
                          )
            }
            if(this.modalSearch.province != '') {
              condition2 = (
                            (item.customer_number
                              .toLowerCase()
                              .indexOf(this.modalSearch.province)) > -1 || (item['province_name']
                              .toLowerCase()
                              .indexOf(this.modalSearch.province)) > -1
                          )
            }

            if(this.modalSearch.name != '') {
              condition3 = (
                            (item.customer_number
                              .toLowerCase()
                              .indexOf(this.modalSearch.name.toLowerCase())) > -1 || (item['customer_name']
                              .toLowerCase()
                              .indexOf(this.modalSearch.name.toLowerCase())) > -1
                          )
            }

            if(this.modalSearch.type != '') {
              condition4 = (
                            (item.customer_number
                              .toLowerCase()
                              .indexOf(this.modalSearch.type.toLowerCase())) > -1 || (item['meaning']
                              .toLowerCase()
                              .indexOf(this.modalSearch.type.toLowerCase())) > -1
                          )
            }
            return condition1 && condition2 && condition3 && condition4;
          });
        }, 500);
       
    },

    remoteMethod(query) {
      if (query !== "") {
        this.loading = true;
        setTimeout(() => {
          this.loading = false;
          this.product_options = this.products.filter((item) => {
            return (
              item.item_code.toLowerCase().indexOf(query.toLowerCase()) > -1 ||
              item.ecom_item_description
                .toLowerCase()
                .indexOf(query.toLowerCase()) > -1
            );
          });
        }, 200);
      } else {
        // this.product_options = [];
        this.product_options = this.products;
      }
    },
    getParams: function () {
      var vm = this;
      let urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has("code") && urlParams.get("code") != "") {
        vm.created = true;
        console.log(urlParams.get("code"));
        vm.run_number = urlParams.get("code");
        vm.type = urlParams.get("type");

        vm.type_save = "update";
        let dataPost = [
          {
            code: vm.run_number,
            detail: vm.attribute1,
            start_date: vm.start_date,
            end_date: vm.end_date,
            status: vm.status,
          },
        ];

        axios
          .post("/om/ajax/promotions/search/", dataPost)
          .then((res) => {
            vm.seleted_products = res.data.data.group;
            vm.seleted_orders = res.data.data.dtl;
            vm.seleted_gift = res.data.data.product;
            // vm.customerModalList = res.data.data.customer;
            vm.customerSelected = res.data.data.customer;
            if (vm.type == "copy") {
              vm.run_number = "";
              vm.type_save = "store";
              $("#promotion_code").prop("readonly", true);
            } else {
              vm.start_date = res.data.data.header.start_date;
              vm.end_date = res.data.data.header.end_date;
            }
          })
          .catch((error) => {
            // error.response.status Check status code
          })
          .finally(() => {
            //Perform action in always
          });
      }
    },
    changeSDate(e) {
      this.start_date = moment(e).format("DD/MM/Y");
    },
    changeEDate(e) {
      this.end_date = moment(e).format("DD/MM/Y");
    },
    searchPromotion: function () {
      var vm = this;
      vm.created = false;
      vm.search = true;
      vm.searchDataPromotion = [];
      vm.seleted_products = [];
      vm.seleted_orders = [];
      vm.seleted_gift = [];

      let dataPost = [
        {
          code: vm.run_number,
          start_date: vm.start_date,
          end_date: vm.end_date != null ? vm.end_date : "",
          status: vm.status,
        },
      ];

      axios
        .post("/om/ajax/promotions/search-promotion/", dataPost)
        .then((res) => {
          vm.searchDataPromotion = res.data.data;
          console.log(res.data.data);
        })
        .catch((error) => {
          // error.response.status Check status code
        })
        .finally(() => {
          //Perform action in always
        });
      //   window.location.href =
      //     "/om/promotions/sear ch?code=" +
      //     this.run_number +
      //     "&start=" +
      //     this.start_date +
      //     "&end=" +
      //     this.end_date +
      //     "&status=" +
      //     this.status;
    },
    viewPromotionDetail: function (code) {
      console.log(code);

      var vm = this;
      vm.active_collapse = "show";
      vm.run_number = code;
      vm.type_save = "update";
      let dataPost = [
        {
          code: code,
        },
      ];

      axios
        .post("/om/ajax/promotions/search/", dataPost)
        .then((res) => {
          vm.customers_all =
            res.data.data.header.all_cust_flag == "N" ? false : true;
          vm.isCheckAll =
            res.data.data.header.all_cust_flag == "N" ? "by" : "all";
          vm.seleted_products = res.data.data.group;
          vm.seleted_orders = res.data.data.dtl;
          vm.seleted_gift = res.data.data.product;
          vm.customerModalList = res.data.data.customer;
          vm.customerSelected = res.data.data.customer;

          vm.detail = res.data.data.header.attribute1;
          vm.start_date = res.data.data.header.start_date;
          vm.end_date =
            res.data.data.header.end_date != null
              ? res.data.data.header.end_date
              : "";
          vm.fix_data = res.data.data.header.fix_data;
          vm.created = true;

          vm.setCustomerModal();

        })
        .catch((error) => {
          // error.response.status Check status code
        })
        .finally(() => {
          //Perform action in always
        });
    },
    checkAllCustomer: function () {
      // this.customerSelected = this.customerSetStore;
      // console.log(this.customerSetStore)
      this.customers_all = true;
      this.isCheckAll = "all";
      this.customerModalList = this.customers;
      this.customers_selected = this.customers; // เลือกทั้่งหมด save master to selected
      // for (var key in this.customers) {
      //   this.customerSelected.push(this.customers[key]);
      // }
    },
    checkByCustomer: function () {
      var vm = this;
      // vm.customerSelected = [];
      vm.customers_all = false;
      vm.isCheckAll = "by";
        // console.log(vm.customerSetStore)
      // vm.customerModalList = vm.customers;
      // vm.customerModalSelected = vm.customerSelected;
      // vm.customerModalListSelected = vm.customerSelected;
        // for (var key in vm.customerSetStore) {
        //   if(vm.customerSetStore[key].checked == true){
        //     vm.customerSelected.push(vm.customerSetStore[key]);
        //   }
        // }
      $("#shopModal").modal("show");
    },
    checkModalAllCustomer: function () {
      var vm = this;
      vm.customerModalSelected = [];
      for (var key in vm.customers) {
        vm.customerModalSelected.push(vm.customerSetStore[key]);
        vm.customerModalListSelected.push(vm.customerSetStore[key]);
      }

      for (var key in vm.customerModalList) {
        vm.customerModalList[key].checked = true;
      }

      for (var key in vm.customerSetStore) {
        vm.customerSetStore[key].checked = true;
      }

      vm.customerSelected = [];
    },
    removeAllCustomer: function () {
      var vm = this;
      vm.customerModalSelected = [];
      for (var key in vm.customerModalList) {
        vm.customerModalList[key].checked = false;
      }

      for (var key in vm.customerSetStore) {
        vm.customerSetStore[key].checked = false;
      }
      vm.customerSelected = [];
    },
    saveSelectByCustomer: function () {
      var vm = this;
      vm.customerSelected = [];
      for (var key in vm.customerSetStore) {
        // console.log(vm.customerModalList[key].checked)
        if (vm.customerSetStore[key].checked == true) {
          vm.customerSelected.push(vm.customerSetStore[key]);
        }
      }
      //   this.customerSelected = this.customerModalList;
      $("#shopModal").modal("hide");
    },
    runNumber() {
      var vm = this;
      //   axios.get("/om/ajax/promotions/runnumber").then((res) => {
      //     // vm.run_number = res.data.data;
      //     $('#promotion_code').prop('readonly', true);
      //     vm.created = true;
      //   });
      $("#promotion_code").prop("readonly", true);
      $("#collapse_01").collapse("hide");
      $("#collapse_02").collapse("hide");
      $("#collapse_03").collapse("hide");
      $("#collapse_04").collapse("hide");
      vm.type_save = "store";
      vm.run_number = "";
      vm.isCheckAll = "all";
      vm.created = true;
      vm.search = false;
      vm.customers_all = true;
      vm.searchDataPromotion = [];
      vm.seleted_products = [];
      vm.seleted_orders = [];
      vm.seleted_gift = [];
      vm.customerSelected = [];
      vm.seleted_group_products = [];
      vm.customerSelected = [];
      vm.detail = "";
      vm.start_date = "";
      vm.end_date = "";
      vm.created_group = true;
      vm.removeAllCustomer();
    },
    allCustomer: function () {
      var vm = this;
      axios.get("/om/ajax/promotions/all-customers").then((res) => {
        vm.customers = res.data.data;
        vm.customers_selected = res.data.data;
        vm.customers_modal_selected = res.data.data;
        vm.customerSelected = res.data.data;
        // vm.customerModalSelected = res.data.data;
      });
    },
    setCustomerModal: function () {
      var vm = this;
      console.log(vm.type_save)
      if(vm.type_save == 'update'){
        axios.get("/om/ajax/promotions/set-customer-modal/promo/"+vm.run_number).then((res) => {
                vm.customerSetStore = res.data.data;
                vm.customerModalList = res.data.data;
                vm.customerModalAll = res.data.data;
              });
      }else{
        axios.get("/om/ajax/promotions/set-customer-modal").then((res) => {
                vm.customerSetStore = res.data.data;
                vm.customerModalList = res.data.data;
                vm.customerModalAll = res.data.data;
              });
      }

    },
    allUom: function () {
      var vm = this;
      axios.get("/om/ajax/promotions/all-uom").then((res) => {
        vm.uom = res.data.data;
        vm.muom = res.data.data;
        console.log(vm.uom);
        // vm.customerModalSelected = res.data.data;
      });
    },
    getAllPromotion() {
      var vm = this;
      axios.get("/om/ajax/promotions/all-promotion").then((res) => {
        vm.promotions = res.data.data;
      });
    },
    getAllProduct() {
      var vm = this;
      axios.get("/om/ajax/promotions/all-products").then((res) => {
        vm.products = res.data.data;
        vm.product_options = res.data.data;
      });
    },
    addGroupProduct: function () {
      let vm = this;
      vm.created_group = false;
      vm.seleted_products.push({
        selected: 0,
        group: "1",
        item_id: "",
        item_code: "",
        item_description: "",
      });
    },
    removeGroupProduct: async function () {
      let vm = this;
      var products = [];
      //   console.log(vm.products_selected)
      var run = 0;
      await vm.seleted_products.filter(async function (v, index) {
        if (v.selected == 0) {
          products.push(v);
        } else {
          await vm.products_selected.filter(function (vs, i) {
            if (v.item_code != vs) {
              vm.products_selected[run] = vs;
              run += 1;
            } else {
              delete vm.products_selected[i];
            }
          });
        }
      });
      vm.seleted_products = products;
      if (vm.seleted_products.length == 0) {
        vm.seleted_orders = [];
        vm.created_group = true;
      } else {
        vm.created_group = false;
      }

      if (vm.seleted_products.length == 0) {
        vm.seleted_group_products = [];
      }
    },
    addProduct: async function () {
      let vm = this;
      vm.seleted_orders.push({
        selected: 0,
        group: "1",
        group_product: "",
        order_amount: "1",
        order_unit: "CGK",
        max_amount: "1",
        max_unit: "CGK",
        condition: "AND",
      });
      this.updateUnitGroup();
    },
    updateUnitGroup: async function () {
      let vm = this;
      vm.unit_group_products = [];
      console.log(vm.seleted_products);

      await vm.seleted_products.filter(function (v, i) {
        vm.unit_group_products.push(v.group);
      });
      // console.log(this.seleted_group_products);
      // console.log(this.unit_group_products);
      this.unit_group_products = [...new Set(this.unit_group_products)];
      // console.log(this.unit_group_products)
    },
    removeProduct: async function () {
      let vm = this;
      var orders = [];
      var run = 0;
      await vm.seleted_orders.filter(async function (v, index) {
        if (v.selected == 0) {
          orders.push(v);
        } else {
          // console.log(vm.seleted_group_products)
          // console.log(v.group)
          await vm.seleted_group_products.filter(function (vs, i) {
            if (v.group_product != vs) {
              vm.seleted_group_products[run] = vs;
              run += 1;
            } else {
              delete vm.seleted_group_products[i];
            }
          });
        }
      });
      vm.seleted_orders = orders;
      this.updateUnitGroup();
    },
    addProductGift: function () {
      let vm = this;
      vm.seleted_gift.push({
        selected: 0,
        group: "1",
        item_id: "",
        item_code: "",
        item_description: "",
        amount: "1",
        unit: "CGK",
      });

      if (vm.products_gif_selected[1] == undefined) {
        vm.products_gif_selected[1] = [];
      }
    },
    removeProductGift: async function () {
      let vm = this;
      var gift = [];
      var run = 0;
      await vm.seleted_gift.filter(async function (v, index) {
        if (v.selected == 0) {
          gift.push(v);
        } else {
          await vm.products_gif_selected[v.group].filter(function (vs, i) {
            if (v.item_code != vs) {
              vm.products_gif_selected[v.group][run] = vs;
              run += 1;
            } else {
              delete vm.products_gif_selected[v.group][i];
            }
          });
        }
      });
      vm.seleted_gift = gift;
    },
    upcheckCustomer: async function (index) {
      var vm = this;
      var customerSelected = [];
      customerSelected = vm.customerSelected;
      vm.customerSelected = [];
      await customerSelected.filter(function (v, i) {
        if (i != index) {
          vm.customerSelected.push(v);
        }
      });
    },
    uncheckedCustomerModal: async function (val, index) {
      var vm = this;
      vm.customerModalList[index].checked = false;
      vm.customerSetStore[index].checked = false;
    },
    checkedCustomerModal: async function (val, index) {
      var vm = this;
      vm.customerModalList[index].checked = true;
      vm.customerSetStore[index].checked = true;
    },
    groupProductChanged: function (val, i) {
      // console.log(val, i)
      this.getProductName(val, i);
      this.product_options = this.products;
    },
    sourceCheckDupChanged: function (v) {
      // console.log(v)
      //   console.log(this.products_selected.includes(v))
      return this.products_selected.includes(v);
    },
    sourceGifCheckDupChanged: function (v, i, group) {
      var vm = this;
      if (vm.products_gif_selected[group] == undefined) {
        return false;
      } else {
        return vm.products_gif_selected[group].includes(v);
      }
      // console.log(this.products_selected)
    },
    sourceGropChanged: function (val, i) {
      this.seleted_group_products[i] = val;
      // console.log(this.seleted_group_products)
      this.seleted_orders[i].group_product = val;
    },
    sourceGropCheckDupChanged: function (v) {
      // console.log(this.seleted_group_products,v)
      // console.log(this.seleted_group_products.includes(v))
      //   return this.seleted_group_products.includes(v)

      return this.seleted_group_products.includes(v);
    },
    getProductName: function (val, i) {
      var vm = this;
      vm.products.filter(function (v) {
        if (v.item_code == val) {
          vm.products_selected[i] = v.item_code;
          vm.seleted_products[i].item_id = v.item_id;
          vm.seleted_products[i].item_code = v.item_code;
          vm.seleted_products[i].ecom_item_description =
            v.ecom_item_description;
        }
      });
    },
    sourceGiftChanged: function (val, i, group) {
      this.getGiftProductName(val, i, group);
      this.product_options = this.products;
    },
    getGiftProductName: function (val, i, group) {
      var vm = this;
      //   console.log(vm.products_gif_selected[group][i])
      if (vm.products_gif_selected[group] == undefined) {
        vm.products_gif_selected[group] = [];
      }

      if (vm.products_gif_selected[group][i] == undefined) {
        vm.products_gif_selected[group][i] = [];
      }

      // vm.products_gif_selected.filter(function (v) {
      //     if (v == val) {

      //       vm.products_gif_selected[i] = v.item_code;
      //         vm.seleted_gift[i].item_id = v.item_id;
      //         vm.seleted_gift[i].item_code = v.item_code;
      //         vm.seleted_gift[i].ecom_item_description = v.ecom_item_description;
      //         //   vm.products_gif_selected[group] = []
      //         vm.products_gif_selected[group].push(v.item_code);
      //         console.log(vm.products_gif_selected[group])
      //     }
      // });
      // delete vm.products_gif_selected[group][i]

      vm.products.filter(function (v) {
        if (v.item_code == val) {
          //   vm.products_gif_selected[i] = v.item_code;
          vm.seleted_gift[i].item_id = v.item_id;
          vm.seleted_gift[i].item_code = v.item_code;
          vm.seleted_gift[i].ecom_item_description = v.ecom_item_description;
          //   vm.products_gif_selected[group] = []
          vm.products_gif_selected[group][i] = v.item_code;
          console.log(vm.products_gif_selected[group][i]);
        }
      });
    },
    changeGroupChecked: function (sIndex) {
      if (this.seleted_products[sIndex].selected == 1) {
        this.seleted_products[sIndex].selected = 0;
      } else {
        this.seleted_products[sIndex].selected = 1;
      }
    },
    changeOrderChecked: function (index) {
      if (this.seleted_orders[index].selected == 1) {
        this.seleted_orders[index].selected = 0;
      } else {
        this.seleted_orders[index].selected = 1;
      }
      console.log(this.seleted_orders[index].selected);
    },
    changeGiftChecked: function (index) {
      if (this.seleted_gift[index].selected == 1) {
        this.seleted_gift[index].selected = 0;
      } else {
        this.seleted_gift[index].selected = 1;
      }
      console.log(this.seleted_gift[index].selected);
    },
    changeGroupProductId: function (e, sIndex) {
      this.updateUnitGroup();
    },
    changeOrderAmount: function (index) {
      if (
        parseInt(this.seleted_orders[index].order_amount) >
        parseInt(this.seleted_orders[index].max_amount)
      ) {
           this.seleted_orders[index].max_amount =
            this.seleted_orders[index].order_amount;
      }
    //   console.log(this.seleted_orders[index].order_amount);
    //   console.log(this.seleted_orders[index].max_amount);
      // this.seleted_orders[index].order_amount = e.target.value;
    },
    changeOrderMaxAmount: function (index) {
        setTimeout(() => {
            if (
                parseInt(this.seleted_orders[index].max_amount) <
                parseInt(this.seleted_orders[index].order_amount)
            ) {
                this.seleted_orders[index].max_amount =
                this.seleted_orders[index].order_amount;
            }
        }, 1500);
      // this.seleted_orders[index].order_amount = e.target.value;
    },
    changeOrderUnit: function (e, index) {
      this.seleted_orders[index].order_unit = e.target.value;
    },
    changeMaxUnit: function (e, index) {
      this.seleted_orders[index].max_unit = e.target.value;
    },
    changeGroupGift: function (e, gIndex) {
      this.seleted_gift[gIndex].item_id = "";
      this.seleted_gift[gIndex].item_code = "";
      this.seleted_gift[gIndex].ecom_item_description = "";
    },
    changeGiftUnit: function (e, gIndex) {
      this.seleted_gift[gIndex].unit = e.target.value;
    },
    changeSearchCustomer: function (e) {
      console.log(e.target.value);
    },
    removePromotion: function () {
      let vm = this;
      swal(
        {
          title: "ต้องการลบข้อมูล ใช่หรือไม่",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ยกเลิก",
          closeOnConfirm: false,
          closeOnCancel: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            let dataPost = [
              {
                promotion: {
                  number: vm.run_number,
                },
              },
            ];

            axios
              .post("/om/ajax/promotions/remove/", dataPost)
              .then((res) => {
                if (res.data.status) {
                  swal("Success", "ลบข้อมูลสำเร็จ", "success");
                  setTimeout(function () {
                    location.reload();
                  }, 3000);
                } else {
                  swal("Warning!", "เกิดข้อผิดพลาด", "error");
                }
              })
              .catch((error) => {
                // error.response.status Check status code
              })
              .finally(() => {
                //Perform action in always
              });
          } else {
            swal.close();
          }
        }
      );
    },
    copyPromotion: function () {
      let vm = this;
      swal(
        {
          title: "Are you sure?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No, cancel",
          closeOnConfirm: false,
          closeOnCancel: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            let dataPost = [
              {
                promotion: {
                  number: vm.run_number,
                },
              },
            ];

            // axios
            //   .post("/om/ajax/promotions/copy/", dataPost)
            //   .then((res) => {
            //     console.log(res.data);
            //     if (res.data.status) {
            //       swal("Success", "คัดลอกข้อมูลสำเร็จ", "success");
            //       setTimeout(function () {
            window.location.href =
              "/om/promotions/copy?type=copy&code=" + vm.run_number;
            //       }, 3000);
            //     } else {
            //       swal("Warning!", "เกิดข้อผิดพลาด", "error");
            //     }
            //   })
            //   .catch((error) => {
            //     // error.response.status Check status code
            //   })
            //   .finally(() => {
            //     //Perform action in always
            //   });
          } else {
            swal.close();
          }
        }
      );
    },
    savePromotion: function () {
      let vm = this;

      if ($("#start_date").val() == "") {
        $("#start_date").focus();
        return false;
      }

      if ($("#status").val() == "") {
        $("#status").focus();
        return false;
      }

      swal(
        {
          title: "ต้องการบันทึกข้อมูล ใช่หรือไม่",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ยกเลิก",
          closeOnConfirm: false,
          closeOnCancel: false,
        },
        async function (isConfirm) {
          if (isConfirm) {
          swal.close();

          vm.loading = true;

            var isSave = false;
            await vm.seleted_products.filter(function (v) {
              if (v.selected == 1) {
                isSave = true;
              }
            });

            // if(isSave){
            let dataPost = [
              {
                promotion: {
                  number: vm.run_number,
                  start_date: vm.start_date,
                  end_date: vm.end_date == "Invalid date" ? "" : vm.end_date,
                  detail: vm.detail,
                  status: vm.status,
                },
                product: vm.seleted_products,
                order: vm.seleted_orders,
                gift: vm.seleted_gift,
                customer: vm.customerSelected,
                customer_all: vm.customers_all,
              },
            ];

            // console.log(dataPost)

            // console.log(dataPost)

            axios
              .post("/om/ajax/promotions/" + vm.type_save + "/", dataPost)
              .then((res) => {
                if (res.data.status) {
                  swal("Success", "บันทึกข้อมูลสำเร็จ", "success");
                  vm.type_save = "update";
                  vm.run_number = res.data.data.promotion_code;
                  vm.getAllPromotion();
                  setTimeout(function () {
                    //   vm.searchDataPromotion = res.data.data
                    vm.searchPromotion();
                    vm.viewPromotionDetail(res.data.data.promotion_code);
                    vm.loading = false;

                    //   window.location.href =
                    //   "/om/promotions/search?&code=" +
                    //   res.data.data.promotion_code+'&start_date=&end_date=&status=';
                    // location.reload();
                  }, 3000);
                } else {
                  swal("Warning!", "เกิดข้อผิดพลาด", "error");
                  swal.close();
                }
              })
              .catch((error) => {
                // error.response.status Check status code
              })
              .finally(() => {
                //Perform action in always
              });
            // }else{
            //     swal("Warning!", "กรุณาเลือกอย่างน้อย 1 รายการ", "error");
            // }
          } else {
            swal.close();
          }
        }
      );
    },
  },
};
</script>
