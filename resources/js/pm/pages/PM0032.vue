<template>
  <div>
    <form @submit.prevent="mainFormSubmit" ref="mainForm">
      <pre class="debug" style="display: none">{{
        JSON.stringify(
          {
            id,
            search_header,
            header,
            lines: lines.map((l) => {
              return {
                core_code: l.core_code,
                $last_number: l.$last_number,
                last_number: l.last_number,
                current_number: l.current_number,
                empty: l.empty,
                remaining: l.remaining,
                stamp_line_id: l.stamp_line_id,
              };
            }),
            machineGroups,
            user,
            organization,
          },
          null,
          2
        )
      }}</pre>

      <div class="mb-3 text-right">
        <!--            <button class="btn btn-primary" @click.prevent="newHeader">-->
        <!--                <i class="fa fa-plus"></i> สร้าง-->
        <!--            </button>-->
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-plus"></i> บันทึก
        </button>
        <button
          type="button"
          class="btn btn-primary"
          data-toggle="modal"
          data-target="#transferStampModal"
        >
          <i class="fa fa-plus"></i> โอนแสตมป์ค้าง
        </button>
      </div>

      <div class="row">
        <div class="col">
          <div class="ibox">
            <div class="ibox-title">
              <h5>Stamp Using <small>บันทึกใช้แสตมป์</small></h5>
            </div>
            <div class="ibox-content">
              <div class="row">
                <div class="col-sm-6 b-r">
                  <div class="form-group row mb-1">
                    <label class="col-sm-4 col-form-label text-right"
                      >วันที่ใช้แสตมป์</label
                    >
                    <div class="col-sm-6">
                      <ct-datepicker
                        class="my-1 col-sm-12 form-control"
                        name="used_date"
                        onkeydown="return event.key != 'Enter';"
                        style="width: 100%"
                        placeholder="โปรดเลือกวันที่เริ่มต้น"
                        :value="toJSDate(search_header.used_date, 'yyyy-MM-dd')"
                        @change="
                          (date) => {
                            search_header.used_date = jsDateToString(date);
                            getBrands();
                          }
                        "
                      />
                      <input
                        type="hidden"
                        name="used_date"
                        :value="search_header.used_date"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-right"
                      >ชุดเครื่องจักร</label
                    >
                    <div class="col-sm-6">
                      <el-select
                        filterable
                        clearable
                        v-model="search_header.machine_group"
                        style="width: 100%"
                        @change="
                          (val) => onSearchHeaderInput('machine_group', val)
                        "
                        placeholder=""
                      >
                        <el-option
                          v-for="item in machines.data"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                        >
                        </el-option>
                      </el-select>
                    </div>
                  </div>

                  <!-- <div class="form-group">
                                        <label>วันที่ใช้แสตมป์</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            autocomplete="off"
                                            name="used_date"
                                            :value="search_header.used_date"
                                            @input="onSearchHeaderInput('used_date', {key:$event.target.value})">
                                    </div> -->

                  <!-- <div class="form-group">
                                        <label>ชุดเครื่องจักร</label>
                                        <ct-lookup
                                            table="PtpmMachineGroups"
                                            id_field="lookup_code"
                                            lookup_field="lookup_code"
                                            :selected="search_header.machine_group"
                                            @change="(val) => onSearchHeaderInput('machine_group',val)">
                                        </ct-lookup>
                                    </div> -->
                </div>

                <div class="col-sm-6">
                  <div class="form-group row mb-1">
                    <label class="col-sm-2 col-form-label text-right"
                      >ตราบุหรี่</label
                    >
                    <div class="col-sm-6">
                      <el-select
                        filterable
                        clearable
                        v-model="search_header.description1"
                        :loading="brands.loading"
                        :disabled="brands.loading"
                        style="width: 100%"
                        @change="
                          (val) => onSearchHeaderInput('description1', val)
                        "
                        placeholder=""
                      >
                        <el-option
                          v-for="item in brands.data"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                        >
                        </el-option>
                      </el-select>
                    </div>
                  </div>

                  <!-- <div class="form-group">
                                        <label>ตราบุหรี่</label>
                                        <ct-lookup
                                            table="PtpmStampRelation"
                                            id_field="item_description"
                                            lookup_field="item_description"
                                            :selected="search_header.description1"
                                            @change="(val) => onSearchHeaderInput('description1',val)">
                                        </ct-lookup>
                                    </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-3 text-right">
        <button
          class="btn btn-primary"
          @click.prevent="addNewLine"
          :disabled="this.loading"
        >
          <strong>เพิ่มรายการ</strong>
        </button>
        <button
          class="btn btn-danger"
          @click.prevent="removeSelectedLines"
          :disabled="
            this.loading ||
            this.lines.filter((line) => line.isSelected).length === 0
          "
        >
          <strong>ลบรายการ</strong>
        </button>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="ibox">
            <div class="ibox-content">
              <table class="table table-bordered">
                <thead>
                  <tr class="">
                    <th></th>
                    <!-- <th>#</th> -->
                    <th>
                      <div>รหัสแกน</div>
                    </th>
                    <th class="text-center">
                      <div>ม้วนที่</div>
                    </th>
                    <th>
                      <div>เลขปลายม้วน</div>
                    </th>
                    <th>
                      <div>เลขแสตมป์ที่เห็น</div>
                    </th>
                    <th>
                      <div>ใช้เต็มม้วน</div>
                    </th>
                    <th>
                      <div>ไม่ใช้เต็มม้วน</div>
                    </th>
                    <th>
                      <div>อัตราการใช้ (ดวง)</div>
                    </th>
                  </tr>
                </thead>
                <tbody v-if="lines.length > 0">
                  <tr
                    v-for="(line, i) in lines"
                    :class="{
                      'row-new-record': line.newRecord,
                      'row-selected-record': line.isSelected,
                    }"
                    v-bind:key="JSON.stringify(line)"
                  >
                    <td>
                      <input type="checkbox" v-model="line.isSelected" />
                    </td>
                    <!-- <td>{{ i + 1 }}</td> -->

                    <!--รหัสแกน-->
                    <td
                      style="background-color: #ffffff"
                      contenteditable="true"
                      v-html="line.core_code"
                      @focusout="
                        onTableInput(i, 'core_code', {
                          key: $event.target.innerHTML,
                        })
                      "
                    ></td>
                    <!--ม้วนที่-->
                    <!-- <td class="col-readonly"  contenteditable="true" v-html="line.last_number"
                                        @focusout="onTableInput(i,'last_number',{key:$event.target.innerHTML})"> -->
                    <td
                      class="col-readonly text-center"
                      v-html="line.roll_num"
                    ></td>
                    <!--เลขปลายม้วน-->
                    <td class="col-readonly">
                      <!-- {{ line.$last_number }} -->
                      <!-- {{ (parseInt(line.core_code) * 40000) | number2Digit }} -->
                      {{ line.last_number }}
                    </td>
                    <!--เลขแสตมป์ที่เห็น-->
                    <td
                      style="background-color: #ffffff"
                      class="col-readonly"
                      :contenteditable="isCurrentReadOnly(line)"
                      v-html="line.current_number"
                      @focusout="
                        onTableInput(i, 'current_number', {
                          key: $event.target.innerHTML,
                        })
                      "
                    ></td>
                    <!--ใช้เต็มม้วน-->
                    <td>
                      <input
                        type="checkbox"
                        v-model="line.empty"
                        @change="onTableInput(i, 'empty', null)"
                      />
                    </td>
                    <!--ไม่ใช้เต็มม้วน-->
                    <td>
                      <input
                        type="checkbox"
                        v-model="line.not_used"
                        @change="onTableInput(i, 'not_used', null)"
                      />
                    </td>
                    <!--อัตราการใช้ (ดวง)-->
                    <!--  <td contenteditable="true"
                                        @focusout="onTableInput(i,'remaining',{key:$event.target.innerHTML})">
                                        {{ line.remaining | number2Digit }}
                                    </td> -->
                    <td
                      contenteditable="false"
                      @focusout="
                        onTableInput(i, 'remaining', {
                          key: $event.target.innerHTML,
                        })
                      "
                    >
                      {{ line.remaining | number2Digit }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="text-center" v-if="lines.length === 0">
                <span class="lead">No Data.</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="ibox">
            <div class="ibox-title">
              <h5>
                Stamp Using Edit new
                <small>คืนแสตมป์ไปกองจัดเตรียม แก้ใหม่</small>
              </h5>
            </div>
            <div class="ibox-content">
              <div class="row mb-15">
                <div class="col-sm-12"><h5>คืนแสตมป์ค้างประจำเครื่อง</h5></div>
              </div>
              <div class="row">
                <div class="col-sm-4 b-r">
                  <div class="form-group flex">
                    <label>ซอง</label>
                    <input
                      type="number"
                      class="form-control"
                      autocomplete="off"
                      name="return_stamp_cgp"
                      :value="header.return_stamp_cgp"
                      :disabled="this.loading"
                      @input="
                        onHeaderInput('return_stamp_cgp', {
                          key: $event.target.value,
                        })
                      "
                    />
                  </div>
                  <div class="form-group flex">
                    <label>ห่อ</label>
                    <input
                      type="number"
                      class="form-control"
                      autocomplete="off"
                      name="return_stamp_cgc"
                      :value="header.return_stamp_cgc"
                      :disabled="this.loading"
                      @input="
                        onHeaderInput('return_stamp_cgc', {
                          key: $event.target.value,
                        })
                      "
                    />
                  </div>
                  <div class="form-group flex">
                    <label>ดวง</label>
                    <input
                      type="number"
                      class="form-control"
                      autocomplete="off"
                      name="return_stamp_st"
                      :value="header.return_stamp_st"
                      :disabled="this.loading"
                      @input="
                        onHeaderInput('return_stamp_st', {
                          key: $event.target.value,
                        })
                      "
                    />
                  </div>
                </div>

                <div class="col-sm-4 b-r">
                  <div class="form-group">
                    <label>คืนแสตมป์รับโอนจากเครื่องอื่น</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="receive_t"
                          disabled="disabled"
                          :value="header.receive_t"
                          @input="
                            onHeaderInput('receive_t', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>รวม</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="return_stamp"
                          disabled="disabled"
                          :value="header.return_stamp"
                          @input="
                            onHeaderInput('return_stamp', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mb-15">
                <div class="col-sm-12"><h5>คงคลังแสตมป์เครื่องจักร</h5></div>
              </div>
              <div class="row">
                <div class="col-sm-4 b-r">
                  <!-- ไม่คืนแสตมป์ค้างประจำเครื่อง -->
                  <div class="form-group">
                    <label>ไม่คืนแสตมป์ค้างประจำเครื่อง</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="repair_t"
                          :value="header.repair_t"
                          @input="
                            onHeaderInput('repair_t', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 b-r">
                  <!-- ไม่คืนแสตมป์รับโอนจากเครื่องอื่น -->
                  <div class="form-group">
                    <label>ไม่คืนแสตมป์รับโอนจากเครื่องอื่น</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="receive_f"
                          disabled="disabled"
                          :value="header.receive_f"
                          @input="
                            onHeaderInput('receive_f', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <!-- รวม -->
                  <div class="form-group">
                    <label>รวม</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="repair"
                          disabled="disabled"
                          :value="header.repair"
                          @input="
                            onHeaderInput('repair', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4 b-r">
                  <!-- แสตมป์ชำรุด -->
                  <div class="form-group">
                    <label>แสตมป์ชำรุด</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="broken"
                          :value="header.broken"
                          @input="
                            onHeaderInput('broken', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 b-r"></div>
                <div class="col-sm-4"></div>
              </div>
              <div class="row align-items-end">
                <div class="col-sm-4 b-r">
                  <!-- โอนแสตมป์ค้าง -->
                  <div class="form-group">
                    <label>โอนแสตมป์ค้าง</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="transfer"
                          disabled="disabled"
                          :value="header.transfer"
                          @input="
                            onHeaderInput('transfer', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 b-r">
                  <!-- รับแสตมป์ค้าง -->
                  <div class="form-group">
                    <label>รับแสตมป์ค้าง</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="receive"
                          disabled="disabled"
                          :value="header.receive"
                          @input="
                            onHeaderInput('receive', {
                              key: $event.target.value,
                            })
                          "
                        />
                        <div
                          style="display: flex; justify-content: space-between"
                        >
                          <a href="#" @click="handleConfirmTransfer()"
                            >ยืนยัน</a
                          >
                          <a href="#" @click="handleDetailTransfer()"
                            >ดูรายละเอียด</a
                          >
                        </div>
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-plus"></i> บันทึก
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="row">
        <div class="col">
          <div class="ibox">
            <div class="ibox-title">
              <h5>Stamp Using <small>บันทึกใช้แสตมป์</small></h5>
            </div>
            <div class="ibox-content">
              <div class="row">
                <div class="col-sm-6 b-r">
                  <div class="form-group">
                    <label>คืนแสตมป์ค้าง</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="return_stamp"
                          :value="header.return_stamp"
                          :disabled="this.loading"
                          @input="
                            onHeaderInput('return_stamp', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>คืนแสตมป์ซ่อม</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="repair"
                          :value="header.repair"
                          :disabled="this.loading"
                          @input="
                            onHeaderInput('repair', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>ชำรุด</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="broken"
                          :value="header.broken"
                          :disabled="this.loading"
                          @input="
                            onHeaderInput('broken', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>โอนแสตมป์ค้าง</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="transfer"
                          disabled="disabled"
                          :value="header.transfer"
                          @input="
                            onHeaderInput('transfer', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>รับแสตมป์ค้าง</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="number"
                          class="form-control"
                          autocomplete="off"
                          name="receive"
                          disabled="disabled"
                          :value="header.receive"
                          @input="
                            onHeaderInput('receive', {
                              key: $event.target.value,
                            })
                          "
                        />
                      </div>
                      <div class="col-2">ดวง</div>
                    </div>
                  </div>
                  <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-plus"></i> บันทึก
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </form>
    <!-- modal รายละเอียดรับโอน -->
    <div class="modal" id="modal-detail-transfer" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">รายละเอียดรับแสตมป์ค้าง</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-hover table-bordered">
              <thead>
                <tr>
                  <th>ชุดเครื่องจักร</th>
                  <th>จำนวน</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in header.log_receive"
                  :key="item.machine_group"
                >
                  <td>{{ item.machine_group }}</td>
                  <td>{{ item.transfer }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal รายละเอียดรับโอน -->

    <!-- modal รายละเอียดรับโอน -->
    <div class="modal" id="modal-confirm-transfer" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">ยืนยันรับแสตมป์ค้าง</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="flex form-group">
              <label style="width: 200px">คืนแสตมป์รับโอน</label>
              <div>
                <input
                  type="number"
                  class="form-control"
                  v-model="header.receive_t_draft"
                />
              </div>
              <div>ดวง</div>
            </div>
            <div class="flex form-group">
              <label style="width: 200px">ไม่คืนแสตมป์รับโอน</label>
              <div>
                <input
                  type="number"
                  class="form-control"
                  v-model="header.receive_f_draft"
                />
              </div>
              <div>ดวง</div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              @click="handleClickConfirmModal"
            >
              ยืนยัน
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              ออก
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal รายละเอียดรับโอน -->

    <!-- Modal -->
    <div class="modal fade" id="transferStampModal" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <form class="modal-content" @submit.prevent="transferStampFormSubmit">
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <div class="ibox">
                  <div class="ibox-title">
                    <h2>โอนแสตมป์ค้าง</h2>
                  </div>
                  <div class="ibox-content">
                    <div class="row">
                      <div class="col-sm-6 b-r">
                        <div class="form-group">
                          <label>วันที่ใช้แสตมป์</label>
                          <input
                            type="date"
                            class="form-control"
                            autocomplete="off"
                            name="used_date"
                            disabled="disabled"
                            :value="search_header.used_date"
                          />
                        </div>

                        <div class="form-group">
                          <label>ชุดเครื่องจักร</label>
                          <input
                            type="text"
                            class="form-control"
                            autocomplete="off"
                            name="machine_group"
                            disabled="disabled"
                            :value="search_header.machine_group"
                          />
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>ตราบุหรี่</label>
                          <input
                            type="text"
                            class="form-control"
                            autocomplete="off"
                            name="description1"
                            disabled="disabled"
                            :value="search_header.description1"
                          />
                        </div>

                        <div class="form-group">
                          <label>โอนไปเครื่อง</label>
                          <!--                                                    <ct-lookup-->
                          <!--                                                        name="targetMachineGroup"-->
                          <!--                                                        table="PtpmStampRelation"-->
                          <!--                                                        id_field="item_description"-->
                          <!--                                                        lookup_field="item_description"-->
                          <!--                                                        disabled="disabled">-->
                          <!--                                                    </ct-lookup>-->
                          <!-- <el-select v-model="targetMachineGroup" placeholder="เครื่องจักร">
                                                        <el-option
                                                            name="targetMachineGroup"
                                                            v-for="machineGroup in machineGroups"
                                                            :key="machineGroup.machine_group"
                                                            :label="machineGroup.machine_group"
                                                            :value="machineGroup.machine_group">
                                                        </el-option>
                                                    </el-select> -->

                          <el-select
                            filterable
                            clearable
                            v-model="targetMachineGroup"
                            @change="handleChangeTargetMachineGroup($event)"
                            style="width: 100%"
                            name="targetMachineGroup"
                            placeholder="เครื่องจักร"
                          >
                            <el-option
                              v-for="item in machines.data"
                              :key="item.value"
                              :label="item.label"
                              :value="item.value"
                            >
                            </el-option>
                          </el-select>
                        </div>

                        <div class="form-group">
                          <label>จำนวนโอน</label>
                          <div class="row">
                            <div class="col-5">
                              <input
                                type="number"
                                class="form-control"
                                autocomplete="off"
                                name="transferAmount"
                                :value="search_header.transferAmount"
                              />
                            </div>
                            <div class="col-2">ดวง</div>
                          </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                          บันทึก
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { extractDataFormEvent } from "../helpers";
import { instance as http } from "../httpClient";
import { $route } from "../../router";
import { get as _get } from "lodash";
//import swal from "sweetalert";

function searchHeaderLines(used_date, machine_group, description1) {
  return http.get($route("api.pm.stamp-using.search"), {
    params: { used_date, machine_group, description1 },
  });
}

function searchBrand(used_date) {
  let params = {
    used_date: used_date,
    action: "get-brands",
  };
  return http.get($route("api.pm.stamp-using.search"), { params });
}

function createOrUpdateHeaderLines(header_id, header, lines) {
  console.log(
    "createOrUpdateHeaderLines",
    $route("api.pm.stamp-using.update", { stampHeaderId: header_id })
  );
  return http.put(
    $route("api.pm.stamp-using.update", { stampHeaderId: header_id }),
    { header, lines }
  );
}

function deleteLines(pk, lineIds) {
  console.log({ pk, lineIds });
  return http.delete($route("api.pm.stamp-using.deleteLines", pk), {
    params: { ids: lineIds },
  });
}

function transferStamp(
  used_date,
  machine_group,
  description1,
  targetMachineGroup,
  transferAmount
) {
  console.log("transfer", {
    used_date,
    machine_group,
    description1,
    targetMachineGroup,
    transferAmount,
  });
  return http.post($route("api.pm.stamp-using.transferStamp"), {
    used_date,
    machine_group,
    description1,
    targetMachineGroup,
    transferAmount,
  });
}

function askBeforeLeave(flag = true) {
  window.onbeforeunload = flag
    ? function () {
        return "มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?";
      }
    : null;
}

function initLineCalculate(line) {
  //step 1
  line = {
    ...line,
    newRecord: _get(line, "newRecord", false),
    isSelected: _get(line, "isSelected", false),
  };
  //step 2
  line = {
    ...line,
    $last_number: line.last_number,
    empty: line.empty === true || line.empty === "Y",
    not_used: line.not_used === true || line.not_used === "Y",
  };
  return line;
}

import {
  isInRange,
  jsDateToString,
  toJSDate,
  toThDateString,
} from "../../dateUtils";

export default {
  created: function () {
    console.log("!! created !!");
  },
  mounted() {
    this.getBrands();
    console.log("!! mounted !!");
    console.log("conversion_rate_master", this.conversion_rate_master);
  },
  data() {
    return {
      toJSDate,
      jsDateToString,
      isInRange,
      toThDateString,
      firstLoad: true,

      id: this.header_id,
      search_header: {
        used_date: _get(this.init_header, "used_date", null),
        machine_group: _get(this.init_header, "machine_group", null),
        description1: _get(this.init_header, "description1", null),
        // brand: _get(this.init_header, 'brand', null),
      },
      header: { ...this.init_header, receive_t_draft: "", receive_f_draft: "" },
      lines: this.init_lines.map((line) => ({
        ...line,
        empty: line.empty === "Y",
        not_used: line.not_used === "Y",
        newRecord: false,
        isSelected: false,
        $last_number: line.current_number,
      })),
      machineGroups: [...this.init_machine_groups],
      targetMachineGroup: null,
      loading: false,
      brands: {
        loading: false,
        data: [],
      },
      machines: {
        data: _get(this.init_header, "machines", []),
      },
    };
  },
  props: {
    header_id: null,
    init_header: { type: Object },
    init_lines: { type: Array, default: [] },
    init_machine_groups: { type: Array, default: () => [] },
    core_codes: { type: Array, default: [] },
    user: { type: Object },
    organization: { type: Object },
    conversion_rate_master: { type: Object },
  },
  methods: {
    $getData($event) {
      let header = {
        ...this.header,
        ...this.search_header,
        ...extractDataFormEvent($event),
      };
      let lines = [...this.lines].map((line) => {
        return {
          ...line,
          empty: line.empty ? "Y" : "N",
          not_used: line.not_used ? "Y" : "N",
          stamp_line_id: this.id,
        };
      });
      return { header, lines };
    },

    async handleChangeTargetMachineGroup(value) {
      this.loading = true;
      let filter = _.filter(this.header.log_transfer, i => 
        i.machine_group === value
      );
      if(filter.length > 0) {
        filter = filter[0]
        this.search_header.transferAmount = filter.transfer
      } else {
        this.search_header.transferAmount = 0
      }
    },

    isCurrentReadOnly(line) {
      let con = true;
      if (line.empty === true) {
        con = false;
      } else if (line.not_used === true) {
        con = false;
      } else {
        con = true;
      }
      console.log("isCurrentReadOnly", line, con);

      return con;
    },

    handleDetailTransfer() {
      $("#modal-detail-transfer").modal("show");
    },

    handleConfirmTransfer() {
      $("#modal-confirm-transfer").modal("show");
    },

    refreshUi(header, lines) {
      this.id = _get(header, "stamp_header_id", null);
      // console.log('refreshUi'
      //     , header
      //     , 'xxxx1'
      //     , $route('pm.stamp-using.show', {stampHeaderId: this.id})
      //     , 'xxxx2'
      // );

      if (this.id)
        history.pushState(
          { header_id: this.id },
          null,
          $route("pm.stamp-using.show", { stampHeaderId: this.id })
        );
      else
        history.pushState(
          { header_id: null },
          null,
          $route("pm.stamp-using.index")
        );
      header.transfer = header.sum_transfer;
      header.receive = header.sum_receive;
      if (header != null) this.header = header;
      this.lines = lines.map((line) => {
        return {
          ...line,
          $last_number: line.last_number,
          empty: line.empty === true || line.empty === "Y",
          not_used: line.not_used === true || line.not_used === "Y",
        };
      });
    },
    mainFormSubmit($event) {
      let { header, lines } = this.$getData($event);
      console.log({ header, lines }, JSON.stringify({ header, lines }));
      createOrUpdateHeaderLines(this.id, header, lines)
        .then(async ({ data }) => {
          this.refreshUi(data.header, data.lines);
          await swal({
            title: "สำเร็จ",
            text: "บันทึกข้อมูลเรียบร้อย",
            icon: "success",
            button: "ตกลง",
          });
          askBeforeLeave(false);
        })
        .catch(async (err) => {
          console.error(err);
          await swal({
            title: "มีข้อผิดพลาด",
            text: err.toString(),
            icon: "error",
            button: "ตกลง",
          });
        });
    },
    newHeader() {
      window.location = $route("pm.stamp-using.create");
    },
    async addNewLine() {
      // let maxRollNum = await _.maxBy(this.lines, 'roll_num');
      // let maxRollNum = await _.maxBy(this.lines, async function(o) { return parseInt(o.roll_num); });
      // let maxRollNum = await _.maxBy(this.lines, async function(o) { return (o.roll_num); });
      let maxRollNum = this.lines.reduce(
        (acc, shot) =>
          (acc = acc > parseInt(shot.roll_num) ? acc : parseInt(shot.roll_num)),
        0
      );
      if (maxRollNum == undefined) {
        maxRollNum = 1;
      } else {
        console.log("else addNewLine", maxRollNum);
        maxRollNum = parseInt(maxRollNum) + 1;
      }

      // console.log('addNewLine ',maxRollNum);

      this.lines.push({
        roll_num: maxRollNum,
        newRecord: true,
        isSelected: false,
      });

      askBeforeLeave(true);
    },
    removeSelectedLines() {
      let selectedIndexes = this.lines
        .map((line, i) => (line.isSelected ? i : null))
        .filter((i) => i != null);

      if (!confirm(`remove ${selectedIndexes.length} lines?`)) return;

      function removeIndexes(arr, indexes) {
        let newArr = [];
        for (let i = 0; i < arr.length; i++) {
          if (indexes.indexOf(i) === -1) newArr.push(arr[i]);
        }
        return newArr;
      }

      let idsToRemove = this.lines
        .filter((line) => line.isSelected && !line.newRecord)
        .map((line) => line.stamp_line_id);

      if (idsToRemove.length > 0) {
        deleteLines(this.pk, idsToRemove)
          .then(({ data }) => {
            alert("Delete Success!");
            this.lines = removeIndexes(this.lines, selectedIndexes);
          })
          .catch((err) => {
            console.error(err);
            alert("Fail!: " + err.toString());
          });
      } else {
        this.lines = removeIndexes(this.lines, selectedIndexes);
      }

      askBeforeLeave(true);
    },
    onSearchHeaderInput(col, o) {
      console.log(`onSearchHeaderInput(${col})`, o);
      console.log("typeof", typeof o);
      if (typeof o === "string") {
        this.search_header[col] = o;
      } else {
        this.search_header[col] = o.key;
      }
      this.search_header = { ...this.search_header };

      for (let val of Object.values(this.search_header)) if (!val) return;

      console.log(this.search_header);
      this.loading = true;
      let { used_date, machine_group, description1 } = this.search_header;

      searchHeaderLines(used_date, machine_group, description1)
        .then(({ data }) => {
          if (data.machineGroups != null)
            this.machineGroups = data.machineGroups;
          this.refreshUi(data.header, data.lines);
          this.loading = false;
        })
        .catch((err) => {
          this.refreshUi({}, []);
          this.loading = false;
        });
    },

    calculatereReceive() {
      console.log("calculate return stamp");

      let return_stamp_cgp = isNaN(parseFloat(this.header["return_stamp_cgp"]))
        ? 0
        : parseFloat(this.header["return_stamp_cgp"]);
      let return_stamp_cgc = isNaN(parseFloat(this.header["return_stamp_cgc"]))
        ? 0
        : parseFloat(this.header["return_stamp_cgc"]);
      let return_stamp_st = isNaN(parseFloat(this.header["return_stamp_st"]))
        ? 0
        : parseFloat(this.header["return_stamp_st"]);
      let receive_t = isNaN(parseFloat(this.header["receive_t"]))
        ? 0
        : parseFloat(this.header["receive_t"]);
      let repair_t = isNaN(
        parseFloat(this.header["repair_t"])
      )
        ? 0
        : parseFloat(this.header["repair_t"]);
      let receive_f = isNaN(parseFloat(this.header["receive_f"]))
        ? 0
        : parseFloat(this.header["receive_f"]);

      this.header["repair"] = repair_t + receive_f;
      this.header["return_stamp"] =
        return_stamp_cgp + return_stamp_cgc * 10 + return_stamp_st + receive_t;
    },

    handleClickConfirmModal() {
        let sum = parseFloat(this.header.receive_t_draft) + parseFloat( this.header.receive_f_draft)
        console.log(sum, this.header.sum_receive, 'receive sum')
        if(sum > this.header.sum_receive) {
            swal('แจ้งเตือน','จำนวนการรับมากกว่าที่ระบบดำเนินการได้','warning')
            return false;
        }
      this.header.receive_t = this.header.receive_t_draft;
      this.header.receive_f = this.header.receive_f_draft;
      this.calculatereReceive();
    },
    onHeaderInput(col, o) {
      console.log(`onHeaderInput(${col})`, o);
      this.header[col] = o.key;
      this.header = { ...this.header };

      if (
        col === "return_stamp_cgp" ||
        col === "return_stamp_cgc" ||
        col === "return_stamp_st"
      ) {
        this.calculatereReceive();
      }
      if (col === "repair_t") {
        this.calculatereReceive();
      }
      askBeforeLeave(true);
    },

    remainingFocusIn(number, i) {
      this.lines[i].remaining = number.toString().replace(",", "");
    },

    onTableInput(row, col, o) {
      console.log(`onHtmlTableInput(${row}, ${col})`, o);

      if (o) this.lines[row][col] = o.key;

      this.isCurrentReadOnly(this.lines[row]);

      if (col === "core_code") {
        // เลขปลายม้วน = รหัสแกน * 40000
        this.lines[row].last_number =
          parseInt(this.lines[row].core_code) *
          this.conversion_rate_master.conversion_rate;
        console.log("this.lines[row].last_number", this.lines[row].last_number);
      }

      if (col === "remaining") {
        this.lines[row].remaining = this.stripNonNumber(this.lines[row][col]);
      }
      if (col === "not_used") {
        this.lines[row].current_number = "";
        this.lines[row].remaining = 0;
        this.lines[row].empty = false;
      }

      if (col === "empty" || col === "current_number") {
        console.log(`this.lines[row].empty`, this.lines[row].empty);
        this.lines[row].not_used = false;
        if (this.lines[row].empty) {
          this.lines[row].old_current_number = this.lines[row].current_number;
          this.lines[row].remaining = 40000;
          this.lines[row].current_number = "";
        } else {
          // let num = this.lines[row].$last_number - this.lines[row].current_number
          // this.lines[row].remaining = isNaN(num) && num > 0 ? num : 0
          let num =
             this.lines[row].last_number - this.lines[row].current_number;
          this.lines[row].remaining = parseInt(num);
        }
      }

      this.lines = [...this.lines];
    },
    transferStampFormSubmit($event) {
      let {
        used_date,
        machine_group,
        description1,
        targetMachineGroup,
        transferAmount,
      } = {
        ...extractDataFormEvent($event),
        targetMachineGroup: this.targetMachineGroup,
      };
      console.log({
        used_date,
        machine_group,
        description1,
        targetMachineGroup,
        transferAmount,
      });
      transferStamp(
        used_date,
        machine_group,
        description1,
        targetMachineGroup,
        transferAmount
      )
        .then(async ({ data }) => {
          searchHeaderLines(
            this.search_header.used_date,
            this.search_header.machine_group,
            this.search_header.description1
          );
          await swal({
            title: "สำเร็จ",
            text: "บันทึกข้อมูลเรียบร้อย",
            icon: "success",
            button: "ตกลง",
          });
        })
        .catch(async (err) => {
          console.error(err);
          await swal({
            title: "มีข้อผิดพลาด",
            text: err.toString(),
            icon: "error",
            button: "ตกลง",
          });
        });
    },
    getBrands() {
      let vm = this;
      // vm.search_header.brand = '';
      vm.search_header.description1 = "";
      vm.brands.loading = true;
      vm.brands.data = [];
      searchBrand(vm.search_header.used_date)
        .then(({ data }) => {
          vm.brands.data = data;
          vm.brands.loading = false;
        })
        .catch((err) => {
          vm.brands.loading = false;
        });

      if (vm.firstLoad == true && vm.id) {
        vm.search_header.description1 = _get(
          vm.init_header,
          "description1",
          null
        );
        vm.firstLoad = false;
      }
    },
    stripNonNumber(text) {
      let charArr = [...text];
      let numArr = [];
      for (let i = 0; i < charArr.length; i++) {
        if (isNaN(charArr[i]) === false) {
          numArr.push(charArr[i]);
        }
      }
      return Number(numArr.join(""));
    },
  },
};
</script>

<style scoped>
.mb-15 {
  margin-bottom: 15px;
}
.col-readonly {
  background: #f5f5f5;
}
.flex {
  display: flex;
  gap: 20px;
  align-items: center;
}
.flex label {
  white-space: nowrap;
  width: 68px;
}
.row-new-record {
  background: #fffbeb;
}

.row-new-record .col-readonly {
  background: #f3efe0;
}

.row-selected-record {
  background: #dbdbdb;
}
.align-items-end {
  align-items: end;
}
</style>
