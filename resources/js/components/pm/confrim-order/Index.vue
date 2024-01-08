<template>
  <div class="row">
    <div class="col-lg-12">
      <!--            Header-->
      <div class="ibox" ref="div1" v-loading="loading.wipStep">
        <div class="ibox-title" style="padding-right: 20px">
          <div class="row">
            <div class="col-lg-8">
              <h3>บันทึกผลผลิตประจำวัน</h3>
            </div>
            <div class="col-lg-4" style="text-align: right">
              <!--                            <button type="button" @click.prevent="updateattribute2" class="btn btn-default">-->
              <!--                                <i class="fa fa-refresh"></i>-->
              <!--                                test-->
              <!--                            </button>-->
              <button type="button" @click.prevent="onClearForm" class="btn btn-default">
                <i class="fa fa-refresh"></i>
                ล้างค่า
              </button>
              <!-- <button
                type="button"
                class="btn btn-default"
                data-toggle="modal"
                data-target="#modalLines"
              >
                <i class="fa fa-search"></i>
                ค้นหา
              </button> -->
              <button type="button" @click.prevent="onClickSave" class="btn btn-primary">
                <i class="fa fa-save"></i>
                บันทึก
              </button>
            </div>
          </div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group row" v-if="false">
                <label class="col-lg-3 col-sm-4 col-form-label">
                  หน่วยงาน :<span style="color: white">test exite more</span>
                </label>
                <div class="col-lg-9">
                  <input class="form-control" v-model="department.description" disabled />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-sm-4 col-form-label"
                  >วันที่เริ่ม <span style="color: red">*</span>:</label
                >
                <div class="col-md-9">
                  <div class="row">
                   <div class="col-lg-6">
                  <datepicker-th
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="startDate"
                    id="startDate"
                    :disabled="false"
                    placeholder="โปรดเลือกวันที่เริ่มต้น"
                    :value="wipSelectStartDate"
                    @dateWasSelected="setDate(...arguments, 'startDate')"
                    :format="transDate['js-format']"
                  />
                </div>
                <!-- <label class="col-lg-1 col-sm-4 col-form-label"
                  >ถึงวันที่ <span style="color: red">*</span>:</label
                > -->
                <div class="col-lg-6">
                  <datepicker-th
                    style="width: 100%"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="endDate"
                    id="endDate"
                    :disabled="false"
                    placeholder="โปรดเลือกวันที่สิ้นสุด"
                    :value="wipSelectEndDate"
                    @dateWasSelected="setDate(...arguments, 'endDate')"
                    :format="transDate['js-format']"
                  />
                </div>
                  </div>
                </div>
               
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-sm-4 col-form-label">
                  เลขที่คำสั่งผลิต<span style="color: red">*</span>:
                </label>
                <div class="col-lg-9">
                  <el-select
                    class="col-lg-12"
                    v-model="selValue.batch_id"
                    filterable
                    remote
                    placeholder="ระบุเลขที่คำสั่งผลิต"
                    :disabled="!(startDate != '' && endDate != '')"
                    @change="onLoadWipStep"
                  >
                    <el-option
                      v-for="lookupHeader in ptmesHeaders"
                      :key="lookupHeader.batch_id"
                      :label="lookupHeader.batch_no + ', ' + lookupHeader.description"
                      :value="lookupHeader.batch_id"
                    >
                    </el-option>
                  </el-select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-sm-4 col-form-label">สินค้าที่จะผลิต:</label>
                <div class="col-lg-9">
                  <div class="row">
                    <div class="col-lg-12">
                      <input
                        type="text"
                        class="form-control"
                        v-model="selValue.item_code"
                        disabled
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12">
            <div class="form-group row">
                <label class="col-lg-2 col-sm-4 col-form-label"
                  ><span style="color: red"></span></label
                >
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-lg-6">
                      
                    </div>
                    <div class="col-lg-6">
                      
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-3 col-sm-4 col-form-label"
                  >ขั้นตอนการทำงาน<span style="color: red">*</span>:</label
                >
                <div class="col-lg-9">
                  <div class="row">
                    <div class="col-lg-6">
                      <el-select
                        v-model="selWipStep.wip_step"
                        filterable
                        remote
                        placeholder="ระบุขั้นตอนการทำงาน"
                        @change="onSelWipStep"
                        :disabled="disWip == true"
                      >
                       <el-option
                            v-for="step in wipStep"
                            :key="step.oprn_class_desc"
                            :label="step.oprn_class_desc + ' ' + step.oprn_desc"
                            :value="step.oprn_class_desc"
                        >
                        </el-option>
                      </el-select>
                    </div>
                    <div class="col-lg-6">
                      <input
                        type="text"
                        class="form-control"
                        v-model="selWipStep.wip_step_desc"
                        disabled
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-3 col-sm-4 col-form-label">รายละเอียดสินค้าที่จะผลิต:</label>
                <div class="col-lg-9">
                  
                  <div class="row">
                    <div class="col-lg-12">
                      <!--                                            <input type="text" class="form-control" v-model="selValue.item_desc"-->
                      <!--                                                   disabled>-->
                      <input
                        class="form-control pt-2"
                        v-model="selValue.item_desc"
                        disabled
                      ></input>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row" v-if="false">
                <label class="col-lg-2 col-sm-4 col-form-label">Blend No.:</label>
                <div class="col-lg-10">
                  <input class="form-control" v-model="selValue.blend_no" disabled />
                </div>
              </div>
              <div class="form-group row">
                <div class="col-lg-12">
                  <button
                    type="button"
                    @click.prevent="onLoadLines"
                    class="btn btn-default"
                    style="float: right"
                  >
                    แสดงข้อมูล
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--            Lines-->
      <div class="ibox" ref="div2" v-loading="loading.line">
        <div class="ibox-title">
          <h3>บันทึกผลผลิตรายวัน</h3>
          <button type="button" class="pull-right btn btn-primary" @click="addNewLine()">เพิ่มรายการ</button>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-bordered" id="item-lines">
              <thead>
                <tr>
                  <th class="text-center">วันที่ได้ผลผลิต</th>
                  <th class="text-center">คงคลังเช้า</th>
                  <th class="text-center">ผลผลิตที่ได้</th>
                  <th class="text-center">สูญเสีย</th>
                  <th class="text-center">จ่ายออก<span style="color: red">*</span></th>
                  <th class="text-center">คงคลังเย็น</th>
                  <th class="text-center" v-if="!isMG6">บุหรี่ต้วอย่าง</th>
                  <th class="text-center">หน่วยนับ</th>
                  <th class="text-center">สถานะการบันทึกผล</th>
                  <th class="text-center">ตัดใช้วัตถุดิบ</th>
                  <th class="text-center">บันทึกเข้าคลัง</th>
                  <th class="text-center">รายละเอียด</th>
                </tr>
              </thead>
              <tbody v-if="ptmesLines.length">
                <template
                  v-for="(item, itemKey) in ptmesLines"
                  :class="{ disable: item.transaction_flag }"
                >
                  <tr :data="itemKey">
                    <!-- Lines -->
                    <td class="g">
                      <!-- <a @click.prevent="onLoadDistribution(item.product_date_original)">{{ item.product_date_format}}</a> -->
                     <template v-if="item.is_new === true">
                      <datepicker-th
                        style="width: 100%"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        :name="'product_date_format_'+itemKey"
                        :disabled="false"
                        placeholder=""
                        @dateWasSelected="setProductDate(...arguments, item, itemKey)"
                        :value="item.product_date_format"
                        :format="transDate['js-format']"
                      />
                     </template>
                     <template v-else>
                      {{ item.product_date_format }}
                     </template>
                    </td>
                    <td class="g text-right">
                      {{ parseFloat(item.receive_wip).toLocaleString() }}
                    </td>
                    <td class="g text-right">
                      {{ parseFloat(item.product_qty).toLocaleString() }}
                    </td>
                    <td class="g text-right">
                      {{ parseFloat(item.loss_qty).toLocaleString() }}
                    </td>
                    <td>
                      <vue-numeric
                        style="text-align: right"
                        v-bind:precision="2"
                        class="form-control"
                        separator=","
                        v-model="item.transfer_qty"
                      ></vue-numeric>
                    </td>
                    <td class="g text-right">{{ transWip(itemKey).toLocaleString() }}</td>
                    <td class="g text-right" v-if="!isMG6">
                      {{ parseFloat(item.example_qty).toLocaleString() }}
                    </td>
                    <td class="g">{{ item.unit_of_measure }}</td>
                    <td class="g text-center">
                      <button
                        type="button"
                        class="btn btn-primary btn-block"
                        v-if="item.attribute2 == 'Y'"
                        disabled
                      >
                        ยืนยันยอดผลผลิตแล้ว
                      </button>
                      <button type="button" class="btn btn-danger btn-block" v-else disabled>
                        ยังไม่ยืนยันยอดผลผลิต
                      </button>
                    </td>
                    <!-- ตัดใช้วัตถุดิบ -->
                    <td class="g" style="text-align: center">
                      <input type="checkbox" v-model="item.transaction_flag" disabled />
                    </td>
                    <!-- บันทึกเข้าคลัง -->
                    <td class="g" style="text-align: center">
                      <input type="checkbox" v-model="item.attribute3" disabled />
                    </td>
                    <td class="g text-center">
                      <!-- <a
                        :class="item.product_line_id ? 'btn btn-default btn-block' : 'btn btn-default'"
                        @click.prevent="
                          onLoadDistribution(
                            item.product_line_id,
                            item.product_date_original,
                            item.transaction_flag,
                            itemKey
                          )
                        "
                        >รายละเอียด</a
                      > -->


                      <button
                        :disabled="(!item.product_line_id && !item.has_distribution) ? true : false"
                        :class="item.product_line_id ? 'btn btn-default btn-block' : 'btn btn-default'"
                        @click.prevent="
                          onLoadDistribution(
                            item.product_line_id,
                            item.product_date_original,
                            item.transaction_flag,
                            itemKey
                          )
                        "
                        >รายละเอียด
                        </button>
                        <button v-if="!item.product_line_id" class="btn btn-danger" @click="removeRow(itemKey)">
                            <i aria-hidden="true" class="fa fa-times"></i>
                        </button>
                    </td>
                  </tr>
                  <tr v-if="showDistribID == item.product_line_id">
                    <!-- Distributions -->
                    <td colspan="13">
                      <div
                        class="ibox"
                        :id="'distribution-' + itemKey"
                        ref="div3"
                        v-loading="loading.loadDist"
                      >
                        <div class="ibox-title">
                          <h3 ref="distributeFocus">
                            บันทึกผลผลิตรายวันรายเครื่อง {{ dateRef }}
                          </h3>
                        </div>
                        <div class="ibox-content line-container">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr align="center">
                                  <th rowspan="2" class="sticky-col first-col">
                                    ชุดเครื่องจักร
                                  </th>
                                  <th rowspan="2" class="sticky-col second-col">
                                    หมายเลขเครื่องจักร
                                  </th>
                                  <!-- <th colspan="2">ช่วงเวลา 07.30-11.30</th>
                                                            <th colspan="2">ช่วงเวลา 11.30-12.30</th>
                                                            <th colspan="2">ช่วงเวลา 12.30-16.30</th>
                                                            <th colspan="2">ช่วงเวลา 16.30เป็นต้นไป</th> -->
                                  <!-- period -->
                                  <th
                                    colspan="2"
                                    v-for="(period, i) in productPeriod"
                                    :key="i"
                                  >
                                    {{ period.description }}
                                  </th>

                                  <th rowspan="2" style="min-width: 150px">ยอดสูญเสีย</th>
                                  <th rowspan="2" style="min-width: 150px">
                                    ยืนยันยอดสูญเสีย<span style="color: red">*</span>
                                  </th>
                                  <th rowspan="2" style="min-width: 150px">
                                    ยอดผลิตรวมทั้งวัน
                                  </th>
                                  <th rowspan="2" style="min-width: 80px" v-if="!isMG6">
                                    จำนวนบุหรี่ตัวอย่าง
                                  </th>
                                  <th rowspan="2" style="min-width: 50px">หน่วยนับ</th>
                                </tr>
                                <tr align="center">
                                  <template v-for="period in productPeriod">
                                    <th style="min-width: 150px">ผลผลิตที่ได้</th>
                                    <th style="min-width: 150px">
                                      ยืนยันยอดผลผลิต<span style="color: red">*</span>
                                    </th>
                                  </template>
                                </tr>
                              </thead>
                              <tbody v-if="ptmesDistribution.length">
                                <tr
                                  v-for="(
                                    distribution, distributionIdx
                                  ) in ptmesDistribution"
                                  :key="distributionIdx"
                                  :class="{ disable: trFlag == 'Y' }"
                                >
                                  <td class="g sticky-col first-col">
                                    {{ distribution.machine_set }}
                                  </td>
                                  <td class="g sticky-col second-col">
                                    {{ distribution.machine_number }}
                                  </td>

                                  <!-- <td class="g">{{ parseFloat(distribution.qty_01).toLocaleString() }}</td>
                                                            <td>
                                                                <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_01" :disabled="trFlag == 'Y'"></vue-numeric>
                                                            </td>
                                                            <td class="g">{{ parseFloat(distribution.qty_02).toLocaleString() }}</td>
                                                            <td>
                                                                <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_02" :disabled="trFlag == 'Y'"></vue-numeric>
                                                            </td>
                                                            <td class="g">{{ parseFloat(distribution.qty_03).toLocaleString() }}</td>
                                                            <td>
                                                                <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_03" :disabled="trFlag == 'Y'"></vue-numeric>
                                                            </td>
                                                            <td class="g">{{ parseFloat(distribution.qty_04).toLocaleString() }}</td>
                                                            <td>
                                                                <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_04" :disabled="trFlag == 'Y'"></vue-numeric>
                                                            </td> -->
                                  <template v-for="period in productPeriod">
                                    <td
                                      class="g text-right"
                                      :data-period="'qty_0' + period.seq"
                                    >
                                      {{
                                        parseFloat(
                                          distribution["qty_0" + period.seq] != null
                                            ? distribution["qty_0" + period.seq]
                                            : "0"
                                        ).toLocaleString()
                                      }}
                                    </td>
                                    <td
                                      class="text-right"
                                      :data-period="'result_qty' + period.seq"
                                    >
                                      <vue-numeric
                                        v-bind:precision="2"
                                        class="form-control text-right"
                                        separator=","
                                        v-model="
                                          distribution['result_qty_0' + period.seq]
                                        "
                                        :disabled="trFlag == 'Y'"
                                      ></vue-numeric>
                                    </td>
                                  </template>

                                  <td class="g text-right">
                                    {{
                                      parseFloat(distribution.loss_qty).toLocaleString()
                                    }}
                                  </td>
                                  <td>
                                    <vue-numeric
                                      v-bind:precision="2"
                                      class="form-control  text-right"
                                      separator=","
                                      v-model="distribution.result_loss_qty"
                                      :disabled="trFlag == 'Y'"
                                    ></vue-numeric>
                                  </td>
                                  <td class="g text-right">
                                    {{ sumMfg(distributionIdx).toLocaleString() }}
                                  </td>
                                  <td v-if="!isMG6">
                                    <vue-numeric
                                      v-bind:precision="2"
                                      class="form-control  text-right"
                                      separator=","
                                      v-model="distribution.sample_qty"
                                      :disabled="trFlag == 'Y'"
                                    ></vue-numeric>
                                  </td>
                                  <td class="g">{{ distribution.unit_of_measure }}</td>
                                </tr>
                              </tbody>
                              <tbody v-else>
                                <tr>
                                  <td colspan="15" style="text-align: center">
                                    ไม่มีข้อมูล
                                  </td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <td class="g text-right" colspan="11">
                                    ยอดรวมทุกเครื่อง
                                  </td>
                                  <td class="g  text-right">{{ totalLoss.toLocaleString() }}</td>
                                  <td class="g  text-right">{{ totalMfg.toLocaleString() }}</td>
                                  <td class="g  text-right">{{ totalSample.toLocaleString() }}</td>
                                  <td></td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </template>
              </tbody>
              <tbody v-else>
                <tr>
                  <td colspan="13" style="text-align: center">ไม่มีข้อมูล</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!--            Distribution-->
      <!--            <div class="ibox" ref="div3" v-loading="loading.loadDist">-->
      <!--                <div class="ibox-title">-->
      <!--                    <h3 ref="distributeFocus">บันทึกผลผลิตรายวันรายเครื่อง {{ dateRef }}</h3>-->
      <!--                </div>-->
      <!--                <div class="ibox-content">-->
      <!--                    <div class="table-responsive">-->
      <!--                        <table class="table">-->
      <!--                            <thead>-->
      <!--                            <tr align="center">-->
      <!--                                <th rowspan="2" class="sticky-col first-col">ชุดเครื่องจักร</th>-->
      <!--                                <th rowspan="2" class="sticky-col second-col">หมายเลขเครื่องจักร</th>-->
      <!--                                <th colspan="2">ช่วงเวลา 07.30-11.30</th>-->
      <!--                                <th colspan="2">ช่วงเวลา 11.30-12.30</th>-->
      <!--                                <th colspan="2">ช่วงเวลา 12.30-16.30</th>-->
      <!--                                <th colspan="2">ช่วงเวลา 16.30เป็นต้นไป</th>-->
      <!--                                <th rowspan="2" style="min-width: 150px;">ยอดสูญเสีย EMS</th>-->
      <!--                                <th rowspan="2" style="min-width: 150px;">ยืนยันยอดสูญเสีย<span style="color: red;">*</span></th>-->
      <!--                                <th rowspan="2" style="min-width: 150px;">ยอดผลิตรวมทั้งวัน</th>-->
      <!--                                <th rowspan="2" style="min-width: 80px;" v-if="!isMG6">จำนวนบุหรี่ตัวอย่าง</th>-->
      <!--                                <th rowspan="2" style="min-width: 50px;">หน่วยนับ</th>-->
      <!--                            </tr>-->
      <!--                            <tr align="center">-->
      <!--                                <th style="min-width: 150px;">ผลผลิตที่ได้</th>-->
      <!--                                <th style="min-width: 150px;">ยืนยันยอดผลผลิต<span style="color: red;">*</span></th>-->
      <!--                                <th style="min-width: 150px;">ผลผลิตที่ได้</th>-->
      <!--                                <th style="min-width: 150px;">ยืนยันยอดผลผลิต<span style="color: red;">*</span></th>-->
      <!--                                <th style="min-width: 150px;">ผลผลิตที่ได้</th>-->
      <!--                                <th style="min-width: 150px;">ยืนยันยอดผลผลิต<span style="color: red;">*</span></th>-->
      <!--                                <th style="min-width: 150px;">ผลผลิตที่ได้</th>-->
      <!--                                <th style="min-width: 150px;">ยืนยันยอดผลผลิต<span style="color: red;">*</span></th>-->
      <!--                            </tr>-->
      <!--                            </thead>-->
      <!--                            <tbody v-if="ptmesDistribution.length">-->
      <!--                            <tr v-for="(distribution, distributionIdx) in ptmesDistribution" :key="distributionIdx"-->
      <!--                                :class="{ disable :trFlag == 'Y' }">-->
      <!--                                <td class="g sticky-col first-col">{{ distribution.machine_set }}</td>-->
      <!--                                <td class="g sticky-col second-col">{{ distribution.machine_number }}</td>-->
      <!--                                <td class="g">{{ parseFloat(distribution.qty_01).toLocaleString() }}</td>-->
      <!--                                <td>-->
      <!--                                    <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_01" :disabled="trFlag == 'Y'"></vue-numeric>-->
      <!--                                </td>-->
      <!--                                <td class="g">{{ parseFloat(distribution.qty_02).toLocaleString() }}</td>-->
      <!--                                <td>-->
      <!--                                    <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_02" :disabled="trFlag == 'Y'"></vue-numeric>-->
      <!--                                </td>-->
      <!--                                <td class="g">{{ parseFloat(distribution.qty_03).toLocaleString() }}</td>-->
      <!--                                <td>-->
      <!--                                    <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_03" :disabled="trFlag == 'Y'"></vue-numeric>-->
      <!--                                </td>-->
      <!--                                <td class="g">{{ parseFloat(distribution.qty_04).toLocaleString() }}</td>-->
      <!--                                <td>-->
      <!--                                    <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_qty_04" :disabled="trFlag == 'Y'"></vue-numeric>-->
      <!--                                </td>-->
      <!--                                <td class="g">{{ parseFloat(distribution.loss_qty).toLocaleString() }}</td>-->
      <!--                                <td>-->
      <!--                                    <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.result_loss_qty" :disabled="trFlag == 'Y'"></vue-numeric>-->
      <!--                                </td>-->
      <!--                                <td class="g">{{ sumMfg(distributionIdx).toLocaleString() }}</td>-->
      <!--                                <td v-if="!isMG6">-->
      <!--                                    <vue-numeric  v-bind:precision="2" class="form-control" separator="," v-model="distribution.sample_qty" :disabled="trFlag == 'Y'"></vue-numeric>-->
      <!--                                </td>-->
      <!--                                <td class="g">{{ distribution.unit_of_measure }}</td>-->
      <!--                            </tr>-->
      <!--                            </tbody>-->
      <!--                            <tbody v-else>-->
      <!--                            <tr>-->
      <!--                                <td colspan="15" style="text-align: center">ไม่มีข้อมูล</td>-->
      <!--                            </tr>-->
      <!--                            </tbody>-->
      <!--                            <tfoot>-->
      <!--                                <tr>-->
      <!--                                    <td class="g text-right" colspan="11">ยอดรวมทุกเครื่อง</td>-->
      <!--                                    <td class="g">{{ totalLoss.toLocaleString() }}</td>-->
      <!--                                    <td class="g">{{ totalMfg.toLocaleString() }}</td>-->
      <!--                                    <td class="g">{{ totalSample.toLocaleString() }}</td>-->
      <!--                                    <td></td>-->
      <!--                                </tr>-->
      <!--                            </tfoot>-->
      <!--                        </table>-->
      <!--                    </div>-->
      <!--                </div>-->
      <!--            </div>-->
    </div>
    <!--        Modal-->
    <div
      class="modal inmodal fade"
      id="modalLines"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      style="display: none"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span><span class="sr-only">Close</span>
            </button>
            <h5 class="modal-title m-0 p-0">บันทึกผลผลิตประจำวัน</h5>
            <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-2">
                <datepicker-th
                  style="width: 100%"
                  class="form-control md:tw-mb-0 tw-mb-2"
                  name="startDate"
                  id="startDateM"
                  :popper-append-to-body="false"
                  placeholder="วันที่เริ่มผลิต"
                  :value="wipStartDate"
                  @dateWasSelected="setDate(...arguments, 'startDate')"
                  :format="transDate['js-format']"
                />
              </div>
              <div class="col-md-2">
                <datepicker-th
                  style="width: 100%"
                  class="form-control md:tw-mb-0 tw-mb-2"
                  name="endDate"
                  id="endDateM"
                  :disabled="disModal1"
                  :popper-append-to-body="false"
                  placeholder="ถึงวันที่"
                  :value="wipEndDate"
                  @dateWasSelected="onLoadHeaders(...arguments)"
                  :format="transDate['js-format']"
                />
              </div>
              <div class="col-md-3">
                <el-select
                  class="col-lg-12"
                  v-model="selValue.batch_id"
                  filterable
                  remote
                  placeholder="เลขที่คำสั่งการผลิค"
                  :popper-append-to-body="false"
                  :disabled="disModal2"
                  @change="onLoadWipStepM"
                >
                  <el-option
                    v-for="lookupHeader in ptmesHeaders"
                    :key="lookupHeader.batch_id"
                    :label="lookupHeader.description"
                    :value="lookupHeader.batch_id"
                  >
                  </el-option>
                </el-select>
              </div>
              <div class="col-md-3">
                <el-select
                  v-model="selWipStep.wip_step"
                  filterable
                  remote
                  placeholder="ขั้นตอนการผลิต"
                  :popper-append-to-body="false"
                  :disabled="disModal3"
                  @change="onSelWipStep"
                >
                  <el-option
                    v-for="step in wipStep"
                    :key="step.wip_step"
                    :label="step.wip_step + ' ' + step.wip_step_desc"
                    :value="step.wip_step"
                  >
                  </el-option>
                </el-select>
              </div>
              <div class="col-md-2">
                <button
                  type="button"
                  @click.prevent="onLoadModalResult"
                  class="btn btn-default pt-1 form-control"
                >
                  <i class="fa fa-search"></i>
                  ค้นหา
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 pt-4">
                <table class="table table-bordered">
                  <thead>
                    <tr style="text-align: center">
                      <th>สถานะ</th>
                      <th>เลขที่คำสั่งผลิต</th>
                      <th>สินค้าที่ผลิต</th>
                      <th>ขั้นตอนการทำงาน</th>
                      <th>วันที่ได้ผลผลิต</th>
                      <th>การจัดการ</th>
                    </tr>
                  </thead>
                  <tbody v-if="modalSearchResult.length">
                    <tr
                      v-for="(item, itemKey) in modalSearchResult"
                      :key="itemKey"
                      :class="{ disable: item.transaction_flag }"
                      style="text-align: center"
                    >
                      <td class="g">
                        <button
                          type="button"
                          class="btn btn-primary"
                          v-if="item.attribute2 == 'Y'"
                          disabled
                        >
                          ยืนยันยอดผลผลิตแล้ว
                        </button>
                        <button type="button" class="btn btn-danger" v-else disabled>
                          ยังไม่ยืนยันยอดผลผลิต
                        </button>
                      </td>
                      <td class="g">{{ item.batch_no }}</td>
                      <td class="g">{{ item.item_code }} | {{ item.item_desc }}</td>
                      <td class="g">{{ item.wip_step }}</td>
                      <td class="g">
                        <!-- <a @click.prevent="onLoadDistribution(item.product_date_original)">{{ item.product_date_format}}</a> -->
                        {{ dateTh(itemKey) }}
                      </td>
                      <td class="g">
                        <a
                          class="btn btn-warning"
                          @click.prevent="
                            onLoadDistribution(
                              item.product_line_id,
                              item.product_date,
                              item.transaction_flag,
                              itemKey
                            )
                          "
                          data-toggle="modal"
                          data-target="#modalLines"
                        >
                          <i class="fa fa-edit"></i>
                          แก้ไข
                        </a>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="6" style="text-align: center">
                        <div v-if="loading.searchModal">
                          <div class="sk-spinner sk-spinner-wave mb-4">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                          </div>
                        </div>
                        <div v-else>ไม่มีข้อมูล</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

function initialData() {
  return {
    showDistribID: "",
    dept: "",
    widthTable: 0,
    // orgId: this.orgId,
    ptmesHeaders: "",
    selValue: {
      batch_id: "",
      batch_no: "",
      product_type: "",
      item_code: "",
      item_desc: "",
      request_qty: "",
      uom: "",
      unit_of_measure: "",
      blend_no: "",
      start_date_original: "",
      product_qty: "",
    },
    loading: {
      line: false,
      loadDist: false,
      searchModal: false,
      wipStep: false,
    },
    ptmesLines: [],
    modalSearchResult: [],
    ptmesDistribution: [],
    firstData: [{ productQty: "" }],
    dateRef: "",
    wipDateRef: [],
    urlDateLink: "",
    wipStep: [],
    selWipStep: {
      wip_step: "",
      wip_step_desc: "",
    },
    wip: "",
    startDate: "",
    endDate: "",
    trFlag: "",
    pIdx: "",
    wipDateRange: {
      start_date: "",
      end_date: "",
    },
    wipStartDate: "",
    wipSelectStartDate: "",
    wipSelectEndDate: "",
    wipEndDate: "",
    distbChange: false,
    disBatch: false,
    disWip: true,
    disWipStart: true,
    disWipEnd: true,
    disModal1: true,
    disModal2: true,
    disModal3: true,
    disModal4: true,
    isMG6: false,
    price: 0,
  };
}

export default {
  props: [
    "now",
    "now_show",
    "headers",
    "url",
    "transDate",
    "department",
    "orgId",
    "organizationCode",
    "productPeriod",
  ],

  data() {
    return initialData();
  },

  mounted() {
    this.initialMethod();
  },

  methods: {
    removeRow: function(idx) {
        this.ptmesLines.splice(idx, 1);
    },
    initialMethod() {
      let vm = this;
      let dept = this.department;
      let ptmesHeaders = this.headers;
      let organizationCode = this.organizationCode;
      Vue.set(vm, 'startDate', vm.now.value)
      Vue.set(vm, 'endDate', vm.now.value)
      vm.wipSelectStartDate = vm.now.show
      vm.wipSelectEndDate = vm.now.show
      console.log("initial methods");
      console.log("Component confirm loss mounted.", "initial data");
      console.log("productPeriod", this.productPeriod);

      this.dept = dept;
      this.ptmesHeaders = ptmesHeaders;
      this.ptmesHeaders = [];

      if (organizationCode == "M05") {
        this.isMG6 = true;
      } else {
        this.isMG6 = false;
      }
      if (this.widthTable == 0) {
        this.widthTable = $("#item-lines").width();
      }
      console.log("init data", { dept, organizationCode });
    },

    goto(refName) {
      var element = this.$refs[refName];
      // var top = element.offsetTop;

      window.scrollTo(0, 0);
    },

    configWidthTable() {
      $(".line-container").css("width", this.widthTable - 50 + "px");
    },

    addNewLine() {
      let obj = {
        receive_wip    : 0,
        product_qty    : 0,
        loss_qty       : 0,
        example_qty    : 0,
        unit_of_measure: 'ชิ้น',
        is_new         : true,
      };
      if (this.organizationCode == "M05") {
        obj.unit_of_measure = "ชิ้น.";
      } else {
        obj.unit_of_measure = "มวน";
      }
      this.firstData.push({productQty:0})
      this.ptmesLines.push(obj);
    },
    setDate(date, inputName) {
      if (inputName == "startDate") {
        this.startDate = moment(date).format("YYYY-MM-DD");
        this.wipSelectStartDate = moment(date).format("DD/MM/YYYY");
        this.disWipEnd = false;
        this.disModal1 = false;
      } else {
        this.endDate = moment(date).format("YYYY-MM-DD");
        this.wipSelectEndDate = moment(date).format("DD/MM/YYYY");
        this.disWipStart = true;
        this.disWipEnd = true;
        this.disModal2 = false;
      }
    },
    setProductDate(date, item, key) {
      let set_date = moment(date).format("DD/MM/YYYY");
      let dates = _.map(this.ptmesLines, item => {
        return { date: item.product_date_format}
      })
      
      let checkValue = _.filter(dates, c => c.date == set_date)
      console.log(dates, checkValue, set_date)

      if(checkValue.length > 0) {
        setTimeout(() => {
          $("[name='product_date_format_"+ key +"']").val('');
        }, 500);
        this.$message({type:"warning", message:"กรุณาตรวจสอบวันที่ใหม่อีกครั้ง"})
        return false;
      }

      item.product_date_format = set_date;
    },

    transWip(idx) {
      let trnsWip = 0;
      // คงคลังเช้า =parseFloat(this.ptmesLines[idx].receive_wip)
      // ผลผลิตที่ได้ =parseFloat(this.ptmesLines[idx].product_qty)
      // จ่ายออก =parseFloat(this.ptmesLines[idx].transfer_qty)
      console.log(
        parseFloat(this.ptmesLines[idx].receive_wip),
        parseFloat(this.ptmesLines[idx].product_qty),
        parseFloat(this.ptmesLines[idx].transfer_qty)
      );
      // trnsWip = parseFloat(this.ptmesLines[idx].receive_wip)+parseFloat(this.ptmesLines[idx].product_qty)-parseFloat(this.ptmesLines[idx].loss_qty)-parseFloat(this.ptmesLines[idx].transfer_qty)-parseFloat(this.ptmesLines[idx].example_qty);
      // trnsWip = parseFloat(this.ptmesLines[idx].receive_wip)+parseFloat(this.ptmesLines[idx].product_qty)-parseFloat(this.ptmesLines[idx].transfer_qty)-parseFloat(this.ptmesLines[idx].example_qty);
      trnsWip =
        parseFloat(this.ptmesLines[idx].receive_wip) +
        parseFloat(this.ptmesLines[idx].product_qty) -
        parseFloat(this.ptmesLines[idx].transfer_qty);
      this.ptmesLines[idx].transfer_wip = trnsWip;

      if (parseFloat(idx + 1) < this.ptmesLines.length) {
        this.ptmesLines[idx + 1].receive_wip = trnsWip;
      }

      return trnsWip;
    },

    sumMfg(idx) {
      let totMfg = 0;
      totMfg =
        parseFloat(this.ptmesDistribution[idx].result_qty_01) +
        parseFloat(this.ptmesDistribution[idx].result_qty_02) +
        parseFloat(this.ptmesDistribution[idx].result_qty_03) +
        parseFloat(this.ptmesDistribution[idx].result_qty_04);
      this.ptmesDistribution[idx].product_qty = totMfg;
      this.distbChange = true;

      return totMfg;
    },

    dateTh(idx) {
      let displayDate = "";
      displayDate = moment(this.modalSearchResult[idx].product_date)
        .add(543, "years")
        .format("DD/MM/YYYY");

      return displayDate;
    },

    onLoadHeaders(date) {
      let vm = this;
      vm.endDate = moment(date).format("YYYY-MM-DD");
      vm.loading.searchModal = true;
      axios
        .get(vm.url.ajax_get_headers_by_date, {
          params: {
            startDate: vm.startDate,
            endDate: vm.endDate,
            departmentCode: vm.dept.department_code,
          },
        })
        .then((response) => {
          vm.ptmesHeaders = response.data.data;
          vm.loading.searchModal = false;
          vm.disModal2 = false;
        })
        .catch((error) => {
          // Error 😨
          Swal.close();
          if (error.response) {
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
          console.log(error.config);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "เกิดข้อผิดพลาด!",
            footer: error.message,
          });
        });
    },

    onLoadLines() {
      let vm = this;
      // vm.loading.line = true;

      if(vm.selValue.batch_id == "") {
        Swal.fire({
          title: "กรุณาเลือกข้อมูลเลขที่คำสั่งผลิต",
        });
        return false;
      }
      if(vm.selWipStep.wip_step == "") {
        Swal.fire({
          title: "กรุณาเลือกข้อมูลขั้นตอนการทำงาน",
        });
        return false;
      }
      Swal.fire({
        title: "กรุณารอสักครู่",
      });
      console.log(vm.ptmesDistribution.length);
      console.log(vm.isMG6);
      Swal.showLoading();
      console.log(
        $.param({
          batch_id: vm.selValue.batch_id,
          wip_step: vm.selWipStep.wip_step,
          startDate: vm.startDate,
          endDate: vm.endDate,
        })
      );
      vm.firstData = [{ productQty: "" }];
      axios
        .get(
          vm.url.ajax_get_lines +
            "?" +
            $.param({
              batch_id: vm.selValue.batch_id,
              wip_step: vm.selWipStep.wip_step,
              startDate: vm.startDate,
              endDate: vm.endDate,
            })
        )
        .then((response) => {
          let data = response.data;
          vm.ptmesLines = data.data;
          if (vm.ptmesLines.length) {
            for (let i = 0; i < vm.ptmesLines.length; i++) {
              vm.firstData.push({ productQty: vm.ptmesLines[i]["product_qty"] });
            }
          }
          if (data.nextWip.length) {
            for (let i = 0; i < data.nextWip.length; i++) {
              let dataNextWip = _.filter(data.nextWip, c => {
                  return c.product_date == vm.ptmesLines[i]?.product_date
              })
              
              let itemDebug = {
                  product_date:vm.ptmesLines[i]?.product_date, 
                  transfer_qty:vm.ptmesLines[i]?.transfer_qty
                }
              let nextitemDebug = {
                  product_date: dataNextWip[0]?.product_date, 
                  transfer_qty: dataNextWip[0]?.product_qty
                }
              console.log(itemDebug, nextitemDebug)
              // vm.ptmesLines[i]['transfer_qty'] = data.nextWip[i]['product_qty'];
              if (typeof vm.ptmesLines[i] != "undefined") {
                if (
                  vm.ptmesLines[i]["attribute2"] == "Y" &&
                  typeof vm.ptmesLines[i] != "undefined"
                ) {
                  vm.ptmesLines[i]["transfer_qty"] = vm.ptmesLines[i]["transfer_qty"];
                } else {
                  // vm.ptmesLines[i]["transfer_qty"] = data.nextWip[i]["product_qty"];
                  vm.ptmesLines[i]["transfer_qty"] = dataNextWip[0]["product_qty"];
                }
              }
            }
          }

          // vm.loading.line = false;
          vm.goto("div2");
          Swal.close();
          this.scrollToLines();
        })
        .catch((error) => {
          // Error 😨
          Swal.close();
          if (error.response) {
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
          console.log(error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "เกิดข้อผิดพลาด!",
            footer: error.message + " [" + error.lineNumber + "]",
          });
        });
    },

    newGoto(id) {
      console.log("new goto id=", id);
      $("html, body").animate(
        {
          scrollTop: $(id).offset().top,
        },
        500
      );
    },

    scrollToLines() {
      $("html, body").animate(
        {
          scrollTop: $("#item-lines").offset().top,
        },
        500
      );
    },

    onLoadModalResult() {
      let vm = this;
      vm.modalSearchResult = [];
      vm.loading.searchModal = true;
      vm.onLoadLines();
      axios
        .get(vm.url.ajax_get_search, {
          params: {
            batch_id: vm.selValue.batch_id,
            wip_step: vm.selWipStep.wip_step,
            startDate: vm.startDate,
            endDate: vm.endDate,
          },
        })
        .then((response) => {
          let data = response.data;
          vm.modalSearchResult = data.data;
          vm.loading.searchModal = false;
        })
        .catch((error) => {
          // Error 😨
          Swal.close();
          if (error.response) {
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
          console.log(error.config);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "เกิดข้อผิดพลาด!",
            footer: error.message,
          });
        });
    },

    updateattribute2() {
      let vm = this;
      let orgProductQty = 0;
      let curProductQty = 0;
      if (vm.firstData.length) {
        console.log("Updating attribute2...");
        for (let i = 0; i < vm.ptmesLines.length; i++) {
          orgProductQty = parseFloat(vm.firstData[i + 1].productQty);
          curProductQty = parseFloat(vm.ptmesLines[i]["product_qty"]);
          console.log("Org" + orgProductQty);
          console.log("Nor" + curProductQty);
          if (orgProductQty != curProductQty) {
            vm.ptmesLines[i]["attribute2"] = "Y";
            console.log("product_qty changed..." + vm.ptmesLines[i]["attribute2"]);
          }
        }
      }
      console.log("Updating finished ...");
    },

    onClearForm() {
      // location.reload()
      Object.assign(this.$data, initialData());
      this.initialMethod();
      // console.log(this.dept)
      // console.log('orgId :'+this.orgId)
      // this.selValue = {
      //         batch_id: '',
      //         batch_no: '',
      //         product_type: '',
      //         item_code: '',
      //         item_desc: '',
      //         request_qty: '',
      //         uom: '',
      //         unit_of_measure: '',
      //         blend_no: '',
      //         start_date: '',
      //         product_qty: '',
      //     },
      //     // this.selValue = [],
      //     this.ptmesHeaders = this.headers,
      //     this.ptmesLines = [],
      //     this.ptmesDistribution = [],
      //     this.modalSearchResult = [],
      //     this.dateRef = '',
      //     this.urlDateLink = '',
      //     this.wipStep = [],
      //     this.selWipStep =[],
      //     this.wip='',
      //     this.startDate = '',
      //     this.endDate = '',
      //     this.trFlag = '',
      //     this.wipDateRange=[],
      //     this.wipDateRef=[]
      //     this.wipStartDate='',
      //     this.wipEndDate='',
      //     this.pIdx='',
      //     this.distbChange=false,
      //     this.disBatch = false,
      //     this.disWip = true,
      //     this.disWipStart = true,
      //     this.disWipEnd = true,
      //     this.disModal1 = true,
      //     this.disModal2 = true,
      //     this.disModal3 = true,
      //     this.disModal4 = true
    },

    onSelWipStep() {
    //   let vm = this;
    //   vm.disWipStart = false;
    //   vm.disWip = true;
    //   vm.ptmesDistribution = [];
    //   vm.ptmesLines = [];
    //   let idx = vm.wipStep.findIndex(
    //     (selWipStep) => selWipStep.wip_step == vm.selWipStep.wip_step
    //   );
    //   vm.selWipStep = vm.wipStep[idx];
    },

    async onLoadDistribution(productLineId, productDateFormat, transactionFlag, passIdx) {
      let vm = this;
      if (vm.showDistribID == productLineId) {
        vm.showDistribID = "";
      } else {
        vm.showDistribID = productLineId;
      }
      console.log("showDistributeID : ", vm.showDistribID);
      // vm.loading.loadDist = true;
      console.log(productLineId, productDateFormat, transactionFlag, passIdx);
      vm.goto("div3");
      vm.dateRef = moment(productDateFormat).add(543, "years").format("DD/MM/YYYY");
      if (vm.distbChange) {
        Swal.fire({
          title: "ข้อมูลมีการเปลี่ยนแปลงและยังไม่ได้บันทึก",
          text: "คุณต้องการดำเนินการต่อหรือไม่",
          icon: "คำเตือน",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "ดำเนินการต่อ",
          cancelButtonText: "ยกเลิก",
        }).then(async (result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "กรุณารอสักครู่",
            });
            Swal.showLoading();
            vm.ptmesDistribution = [];
            // vm.dateRef = productDateFormat;
            vm.trFlag = transactionFlag;
            vm.pIdx = passIdx;
            // url
            await axios
              .get(vm.url.ajax_get_distributions, {
                params: {
                  wip_step: vm.selWipStep.wip_step,
                  batch_id: vm.selValue.batch_id,
                  product_line_id: productLineId,
                },
              })
              .then((resp) => {
                vm.ptmesDistribution = resp.data.data;
              })
              .catch((error) => {
                // Error 😨
                Swal.close();
                if (error.response) {
                  console.log(error.response.data);
                  console.log(error.response.status);
                  console.log(error.response.headers);
                } else if (error.request) {
                  console.log(error.request);
                } else {
                  console.log("Error", error.message);
                }
                console.log(error.config);
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "เกิดข้อผิดพลาด!",
                  footer: error.message,
                });
              });
            vm.distbChange = false;
            Swal.close();
            vm.goto("div3");
          }
        });
      } else {
        Swal.fire({
          title: "กรุณารอสักครู่",
        });
        Swal.showLoading();
        vm.ptmesDistribution = [];
        // vm.dateRef = productDateFormat;
        vm.trFlag = transactionFlag;
        vm.pIdx = passIdx;
        // url
        await axios
          .get(vm.url.ajax_get_distributions, {
            params: {
              wip_step: vm.selWipStep.wip_step,
              batch_id: vm.selValue.batch_id,
              product_line_id: productLineId,
            },
          })
          .then((resp) => {
            let data = resp.data.data;
            data = _.map(data, (i) => {
                  // for(let n = 1; n <=10 ; n ++ ) {
                  //     let padded = (n + "").padStart(2, "0");
                  //     if(i['result_qty_'+padded] == '0') {
                  //       i['result_qty_'+padded] = i['qty_'+padded];
                  //     }
                  //     i['result_qty_'+padded] = 0;
                  // }
                  return i
              })
            vm.ptmesDistribution = data;
          })
          .catch((error) => {
            // Error 😨
            Swal.close();
            if (error.response) {
              console.log(error.response.data);
              console.log(error.response.status);
              console.log(error.response.headers);
            } else if (error.request) {
              console.log(error.request);
            } else {
              console.log("Error", error.message);
            }
            console.log(error.config);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "เกิดข้อผิดพลาด!",
              footer: error.message,
            });
          });
        vm.distbChange = false;
        // vm.loading.loadDist = false
        Swal.close();
        vm.goto("div3");
        vm.newGoto("#distribution-" + passIdx);
      }
      this.configWidthTable();
    },

    onLoadWipStep(option) {
      console.log(option)
      let vm = this;
      Swal.fire({
        title: "กรุณารอสักครู่",
      });
      Swal.showLoading();
    

      let headerDate = "";
      // vm.loading.wipStep = true;
      vm.disWip = false;
      vm.wipStep = [];
      vm.ptmesDistribution = [];
      vm.ptmesLines = [];


      Swal.close();
    
      let idx = vm.ptmesHeaders.findIndex(
        (selValue) => selValue.batch_id == vm.selValue.batch_id
      );
      console.log(vm.selValue);
    //   vm.selValue = vm.ptmesHeaders[idx];
      let selValue = vm.ptmesHeaders[idx]
      
      vm.selValue.item_code = selValue.segment1
      vm.selValue.item_desc = selValue.description
    //   headerDate = moment(vm.selValue.start_date_original).format("YYYY-MM-DD");
      axios
        .get(vm.url.ajax_get_wipstep, {
          params: {
            inventory_item_id: selValue.inventory_item_id,
            // date: headerDate,
          },
        })
        .then((resp) => {
          vm.wipStep = resp.data;
        //   vm.wipDateRange = resp.data.dateRange;
          if (resp.data.currentDate) {
            // vm.wipStartDate = moment(vm.wipDateRange.start_date)
            //   .add(543, "years")
            //   .format("DD/MM/YYYY");
            // vm.wipSelectStartDate = moment().add(543, "years").format("DD/MM/YYYY");
            // vm.wipSelectEndDate = moment().add(543, "years").format("DD/MM/YYYY");
            // vm.wipEndDate = moment(vm.wipDateRange.end_date)
            //   .add(543, "years")
            //   .format("DD/MM/YYYY");
            // vm.startDate = moment().add(543, "years").format("DD/MM/YYYY");
            // vm.endDate = moment().add(543, "years").format("DD/MM/YYYY");
          } else {
            // vm.wipStartDate = moment(vm.wipDateRange.start_date)
            //   .add(543, "years")
            //   .format("DD/MM/YYYY");
            // vm.wipSelectStartDate = moment(vm.wipDateRange.start_date)
            //   .add(543, "years")
            //   .format("DD/MM/YYYY");
            // vm.wipSelectEndDate = moment(vm.wipDateRange.end_date)
            //   .add(543, "years")
            //   .format("DD/MM/YYYY");
            // vm.wipEndDate = moment(vm.wipDateRange.end_date)
            //   .add(543, "years")
            //   .format("DD/MM/YYYY");
            // vm.startDate = moment(vm.wipDateRange.start_date)
            //   .add(543, "years")
            //   .format("YYYY-MM-DD");
            // vm.endDate = moment(vm.wipDateRange.end_date)
            //   .add(543, "years")
            //   .format("YYYY-MM-DD");
          }

        //   vm.disBatch = true;
          // vm.loading.wipStep = false;
          Swal.close();
        })
        .catch((error) => {
          // Error 😨
          Swal.close();
          if (error.response) {
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
          console.log(error.config);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "เกิดข้อผิดพลาด!",
            footer: error.message,
          });
        });
    },

    onLoadWipStepM() {
      let vm = this;
      let headerDate = "";
      vm.loading.searchModal = true;
      // Swal.fire({
      //     title: 'กรุณารอสักครู่',
      // });
      // Swal.showLoading();
      vm.wipStep = [];
      vm.ptmesDistribution = [];
      vm.ptmesLines = [];
      let idx = vm.ptmesHeaders.findIndex(
        (selValue) => selValue.batch_id == vm.selValue.batch_id
      );
      vm.selValue = vm.ptmesHeaders[idx];
      headerDate = moment(vm.selValue.start_date_original).format("YYYY-MM-DD");
      axios
        .get(vm.url.ajax_get_wipstep, {
          params: {
            batch_id: vm.selValue.batch_id,
            date: headerDate,
          },
        })
        .then((resp) => {
          vm.wipStep = resp.data.wip;
          vm.wipDateRange = resp.data.dateRange;
          vm.wipStartDate = moment(vm.wipDateRange.start_date)
            .add(543, "years")
            .format("DD/MM/YYYY");
          vm.wipEndDate = moment(vm.wipDateRange.end_date)
            .add(543, "years")
            .format("DD/MM/YYYY");
          vm.loading.searchModal = false;
          // Swal.close();
          vm.disModal3 = false;
        })
        .catch((error) => {
          // Error 😨
          Swal.close();
          if (error.response) {
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
          console.log(error.config);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "เกิดข้อผิดพลาด!",
            footer: error.message,
          });
        });
    },

    fetchLov() {
      if(this.startDate != ''&& this.endDate != '') {
        axios.post(this.url.ajax_fetch_lov, {startDate:this.startDate, endDate:this.endDate})
        .then(res => {
            console.log(res.data)
            this.ptmesHeaders = res.data
        })
      }
    },
    onClickSave() {
      let vm = this;
      Swal.fire({
        title: "คุณต้องการบันทึกข้อมูล, ใช่หรือไม่?",
        // text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "บันทึก",
        cancelButtonText: "ยกเลิก",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "กำลังบันทึกข้อมูล",
          });
          Swal.showLoading();
          let orgProductQty = 0;
          let curProductQty = 0;
          vm.loading.wipStep = true;
          vm.loading.line = true;
          vm.loading.loadDist = true;
          if (vm.firstData.length) {
            for (let i = 0; i < vm.ptmesLines.length; i++) {
                try {
                  orgProductQty = parseFloat(vm.firstData[i + 1].productQty);
                  curProductQty = parseFloat(vm.ptmesLines[i]["product_qty"]);
                } catch (error) {
                  console.log(vm.ptmesLines[i], {error})
                  vm.loading.wipStep = false;
                  vm.loading.line     = false;
                  vm.loading.loadDist = false;
                }
              if (orgProductQty != curProductQty) {
                vm.ptmesLines[i]["attribute2"] = "Y";
              } else {
                if (vm.ptmesLines[i]["attribute2"] != "Y") {
                  vm.ptmesLines[i]["attribute2"] = null;
                }
              }
            }
          }
          let params = {
            distributions   : vm.ptmesDistribution,
            lines           : vm.ptmesLines,
            wip             : vm.selWipStep,
            val             : vm.selValue,
            orgId           : vm.orgId,
            organizationCode: vm.organizationCode
          };
          axios
            .patch(vm.url.ajax_update_orders, params)
            .then((response) => {
              if (response.status == 200) {
                vm.distbChange = false;
                vm.loading.wipStep = false;
                vm.loading.line = false;
                vm.loading.loadDist = false;
                Swal.close();
                Swal.fire({
                  icon: "success",
                  title: "Ok...",
                  text: "บันทึกข้อมูลสำเร็จ",
                });
              }
            })
            .catch((error) => {
              // Error 😨
              Swal.close();
              if (error.response) {
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
              } else if (error.request) {
                console.log(error.request);
              } else {
                console.log("Error", error.message);
              }
              console.log(error.config);
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "บันทึกข้อมูลไม่สำเร็จ!",
                footer: error.message,
              });
            });
        }
      });
    },

    onCancel() {
      Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, keep it",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire("Deleted!", "Your imaginary file has been deleted.", "success");
          // For more information about handling dismissals please visit
          // https://sweetalert2.github.io/#handling-dismissals
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
        }
      });
    },
  },
  computed: {
    totalMfg() {
      let total = 0;
      let vm = this;
      if (vm.ptmesDistribution.length) {
        for (let i = 0; i < vm.ptmesDistribution.length; i++) {
          total += vm.ptmesDistribution[i]["product_qty"];
        }
        vm.ptmesLines[vm.pIdx].product_qty = total;
      }
      return total;
    },
    totalSample() {
      let total = 0;
      let vm = this;
      if (vm.ptmesDistribution.length) {
        for (let i = 0; i < vm.ptmesDistribution.length; i++) {
          total += parseFloat(vm.ptmesDistribution[i]["sample_qty"]);
        }
        vm.ptmesLines[vm.pIdx].example_qty = total;
      }
      return total;
    },
    totalLoss() {
      let total = 0;
      let vm = this;
      if (vm.ptmesDistribution.length) {
        for (let i = 0; i < vm.ptmesDistribution.length; i++) {
          total += parseFloat(vm.ptmesDistribution[i]["result_loss_qty"]);
        }
        vm.ptmesLines[vm.pIdx].loss_qty = total;
      }
      return total;
    },
    distDate($date) {
      let dispDate = "";
      let vm = this;
      dispDate = helperDate.parseToDateTh($date, "DD/MM/YYYY");
      return dispDate;
    },
   
  },
  watch: {
    price: function (newValue) {
      const result = newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      Vue.nextTick(() => (this.price = result));
    },
    endDate: {
      handler: function(newValue) {
        this.fetchLov();
      },
      deep: true,
    },
    startDate: {
      handler: function(newValue) {
        this.fetchLov();
      },
      deep: true,
    },
  },
};
</script>

<style scoped>
.el-select {
  padding: 0px;
}
.line-container {
  overflow: auto;
}
.sticky-col {
  position: -webkit-sticky;
  position: sticky;
  background-color: rgb(250, 250, 250);
}

.first-col {
  width: 100px;
  min-width: 100px;
  max-width: 100px;
  left: 0px;
}

.second-col {
  width: 150px;
  min-width: 150px;
  max-width: 150px;
  left: 100px;
}
</style>
