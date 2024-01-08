<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.lines">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-3">
                        <h3 class="no-margins"> บันทึกผลผลิตประจำวัน </h3>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-1">เลขที่คำสั่งการผลิต: </label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="header[0].batch_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">รหัสสินค้าสำเร็จรูป: </label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="header[0].item_data.item_number">
                                    </div>
                                    <div class="col-lg-7 pl-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="header[0].item_data.item_desc">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-if="organizationCode != 'M03'"> <!-- 'M03' = M03 // ยาเส้นพอง -->
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-3">Blend No: </label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="header[0].item_data.blend_no">
                            </div>
                        </div>
                        <div class="form-group row" v-if="organizationCode == 'M03'"> <!-- 'M03' = M03 // ยาเส้นพอง -->
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">จำนวนที่ผลิต:</label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" v-model="Number(selectedJob.opt_plan_qty).toLocaleString()"/>
                                    </div>
                                    <div class="col-lg-4 pl-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" v-model="header[0].item_data.primary_unit_of_measure"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">วันที่ได้ผลผลิต:</label>
                            <div class="col-lg-4">
                                <!-- <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="fDate | formatDate"> -->
                                <ct-datepicker
                                    class="form-control my-1"
                                    style="width: 100%"
                                    placeholder="โปรดเลือกวันที่"
                                    :enableDate="date => isInRange(date, toJSDate(dateStart), toJSDate(dateEnd), true)"
                                    :value="toJSDate(search.from_date, 'yyyy-MM-dd')"
                                    @change="(date) => {
                                        search.from_date = jsDateToString(date)
                                        search = {...search}
                                    }"
                                />
                            </div>
                            <label class="font-weight-bold col-form-label text-right">ถึง:</label>
                            <div class="col-lg-4">
                                <!-- <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="tDate | formatDate"> -->
                                <ct-datepicker
                                    class="form-control my-1"
                                    style="width: 100%"
                                    placeholder="โปรดเลือกวันที่"
                                    :enableDate="date => isInRange(date, toJSDate(dateStart), toJSDate(dateEnd), true)"
                                    :value="toJSDate(search.to_date, 'yyyy-MM-dd')"
                                    @change="(date) => {
                                        search.to_date = jsDateToString(date)
                                        search = {...search}
                                    }"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">OPT<span style="color:red">*</span>: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    filterable
                                    clearable
                                    v-model="selectedOpt"
                                    @change="onOptChanged($event)">
                                    <el-option
                                        v-for="opt in opts"
                                        :key="opt"
                                        :label="opt"
                                        :value="opt">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row" v-if="organizationCode != 'M03'"> <!-- 'M03' = M03 // ยาเส้นพอง -->
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">จำนวนที่ผลิต:</label>
                            <div class="col-lg-4">
                                <!-- <input
                                    type="text"
                                    class="form-control"
                                    autocomplete="off"
                                    disabled="disabled"
                                    v-model="Number(selectedJob.opt_plan_qty).toLocaleString()"
                                    /> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="3" 
                                    v-bind:minus="false"
                                    class="form-control" 
                                    v-model="selectedJob.opt_plan_qty"
                                    disabled="disabled"
                                    ></vue-numeric>
                            </div>
                            <label class="font-weight-bold col-form-label text-right">หน่วยนับ:</label>
                            <div class="col-lg-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    disabled="disabled"
                                    v-model="header[0].item_data.primary_unit_of_measure"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins" v-loading="loading.lines">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row mb-0">
                            <label class=" col-lg-3 col-form-label">
                                <b>
                                    ขั้นตอนการทำงาน/WIP<span style="color:red">*</span>
                                </b>
                            </label>
                            <div class="row">
                                <div class="col-lg-4">
                                    <el-select
                                        id="select-wip"
                                        value-key="oprn_class_desc"
                                        v-model="selectedWip"
                                        @change="onWipChanged($event)">

                                        <el-option
                                            v-for="wip in selectedJob.wip_steps"
                                            :key="wip.oprn_class_desc"
                                            :label="wip.oprn_class_desc"
                                            :value="wip">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-lg-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        disabled="disabled"
                                        v-model="selectedWip.oprn_desc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table text-nowrap table-bordered"
                            v-if="!isLoading && Object.keys(jobLines).length > 0">
                        <thead>
                            <tr>
                                <th class="text-center">วันที่ได้ผลผลิต</th>
                                <th class="text-center">OPT</th>
                                <th class="text-center">WIP</th>
                                <th class="text-center">คงคลังเช้า</th>
                                <th class="text-center">ผลผลิตที่ได้</th>
                                <th class="text-center" style="min-width:130px;">ยืนยันยอดผลผลิต</th>
                                <th  class="text-center">สถานะ</th>
                                <th class="text-center">สูญเสีย</th>
                                <th class="text-center">จ่ายออก</th>
                                <th class="text-center" style="min-width:130px;">ยืนยันยอดจ่ายออก</th>
                                <th class="text-center" v-if="organizationCode == 'M02'">สถานะ</th> <!-- 182 = M02 -->
                                <th class="text-center" v-if="organizationCode == 'M02'">จ่ายออกไป Boxbin</th>
                                <th class="text-center" v-if="organizationCode == 'M02'" style="min-width:130px;">ยืนยันยอดจ่ายออกไป Boxbin</th>
                                <th  class="text-center">สถานะ</th>
                                <th class="text-center">คงคลังเย็น</th>
                                <th class="text-center">หน่วยนับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(jobLine, i) in jobLines"
                                style="text-align: center">

                                <!--วันที่ได้ผลผลิต-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.transaction_date">
                                        {{ jobLine.transaction_date | formatDate }}
                                    </span>
                                </td>

                                <!--OPT-->
                                <td class="col-readonly">
                                    <span v-if="selectedOpt">
                                        {{ jobLine.header.opt }}
                                    </span>
                                </td>

                                <!--wip step-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.wip_step">
                                        {{ jobLine.wip_step }}
                                    </span>
                                </td>

                                <!--คงคลังเช้า-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.beginning_qty > 0">
                                        <!-- {{ jobLine.beginning_qty }} -->
                                        {{ Number(jobLine.beginning_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}
                                    </span>
                                    <span v-else> 0 </span>
                                </td>

                                <!--ผลผลิตที่ได้-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.mes_qty > 0">
                                        <!-- {{ jobLine.mes_qty }} -->
                                        <!-- {{ Number(jobLine.mes_qty).toLocaleString() }} -->
                                        {{ Number(jobLine.mes_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}

                                    </span>
                                    <span v-else> 0 </span>
                                </td>

                                <!--ยืนยันยอดผลผลิต-->
                                <td v-if="organizationCode == 'M03' && jobLine.wip_step == 'WIP01'">
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == true">
                                        <!-- <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_qty"
                                            disabled/> -->
                                        <vue-numeric 
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_qty"
                                            disabled
                                            ></vue-numeric>
                                    </span>
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == false">
                                        <!-- <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_qty"
                                            @change="setConfirmIssueQty(jobLine.review_line_id,jobLine.confirm_qty)"
                                            :disabled="!isEditing"/> -->
                                        <vue-numeric 
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_qty"
                                            @change="setConfirmIssueQty(jobLine.review_line_id,jobLine.confirm_qty)"
                                            :disabled="!isEditing"
                                            ></vue-numeric>
                                    </span>
                                </td>
                                <td v-else>
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == true">
                                        <!-- <input
                                            v-if="jobLine.mes_qty > 0"
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_qty"
                                            disabled/> -->
                                        <vue-numeric 
                                            v-if="jobLine.mes_qty > 0"
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_qty"
                                            disabled
                                            ></vue-numeric>
                                    </span>
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == false">
                                        <!-- <input
                                            v-if="jobLine.mes_qty > 0"
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_qty"
                                            @change="calculateConfirmQuantity(jobLine.confirm_qty,jobLine.confirm_issue_qty,jobLine.confirm_boxbin_issue_qty)"
                                            :disabled="!isEditing"/> -->
                                        <vue-numeric 
                                            v-if="jobLine.mes_qty > 0"
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_qty"
                                            :disabled="!isEditing"
                                            @change="calculateConfirmQuantity(jobLine.confirm_qty,jobLine.confirm_issue_qty,jobLine.confirm_boxbin_issue_qty)"
                                            ></vue-numeric>
                                    </span>
                                </td>

                                <!--สถานะ-->
                                <td v-if="organizationCode == 'M03' && jobLine.wip_step == 'WIP01'">
                                    <span
                                        style="color:darkgreen"
                                        v-if="jobLine.metaData.isConfirmed">
                                        ยืนยันแล้ว
                                    </span>

                                    <span
                                        style="color:red"
                                        v-if="!jobLine.metaData.isConfirmed">
                                        ยังไม่ยืนยัน
                                    </span>
                                </td>
                                <td v-else>
                                    <span v-if="jobLine.mes_qty > 0">
                                        <span
                                            style="color:darkgreen"
                                            v-if="jobLine.metaData.isConfirmed">
                                            ยืนยันแล้ว
                                        </span>

                                        <span
                                            style="color:red"
                                            v-if="!jobLine.metaData.isConfirmed">
                                            ยังไม่ยืนยัน
                                        </span>
                                    </span>
                                </td>

                                <!--สูญเสีย-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.loss_qty && jobLine.metaData.isConfirmed">
                                        <!-- {{ jobLine.loss_qty }} -->
                                        {{ Number(jobLine.loss_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}
                                    </span>
                                    <span v-else> 0 </span>
                                </td>

                                <!--จ่ายออก-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.mes_issue_qty > 0">
                                        <!-- {{ jobLine.mes_issue_qty }} -->
                                        {{ Number(jobLine.mes_issue_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}
                                    </span>
                                    <span v-else> 0 </span>
                                </td>

                                <!-- ยืนยันยอดจ่ายออก -->
                                <td v-if="organizationCode == 'M03' && jobLine.wip_step == 'WIP01'">
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == true">
                                        <!-- <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_issue_qty"
                                            disabled/> -->
                                        <vue-numeric 
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_issue_qty"
                                            disabled
                                            ></vue-numeric>
                                    </span>
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == false">
                                        <!-- <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_issue_qty"
                                            :disabled="!isEditing"/> -->
                                        <vue-numeric 
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_issue_qty"
                                            :disabled="!isEditing"
                                            ></vue-numeric>
                                    </span>
                                </td>
                                <td v-else>
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == true">
                                        <!-- <input
                                            v-if="jobLine.mes_issue_qty > 0"
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_issue_qty"
                                            disabled/> -->
                                        <vue-numeric 
                                            v-if="jobLine.mes_issue_qty > 0"
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_issue_qty"
                                            disabled
                                            ></vue-numeric>
                                    </span>
                                    <span v-if="jobLine.metaData.confirmQtyIsDisabled == false">
                                        <!-- <input
                                            v-if="jobLine.mes_issue_qty > 0"
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_issue_qty"
                                            @change="calculateConfirmQuantity(jobLine.confirm_qty,jobLine.confirm_issue_qty,jobLine.confirm_boxbin_issue_qty)"
                                            :disabled="!isEditing"/> -->
                                        <vue-numeric
                                            v-if="jobLine.mes_issue_qty > 0"
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_issue_qty"
                                            @change="calculateConfirmQuantity(jobLine.confirm_qty,jobLine.confirm_issue_qty,jobLine.confirm_boxbin_issue_qty)"
                                            :disabled="!isEditing"
                                            ></vue-numeric>
                                    </span>
                                </td>

                                <!--สถานะ-->
                                <td v-if="organizationCode == 'M03' && jobLine.wip_step == 'WIP01'">
                                    <span
                                        style="color:darkgreen"
                                        v-if="jobLine.metaData.isIssueQtyConfirmed">
                                        ยืนยันแล้ว
                                    </span>

                                    <span
                                        style="color:red"
                                        v-if="!jobLine.metaData.isIssueQtyConfirmed">
                                        ยังไม่ยืนยัน
                                    </span>
                                </td>
                                <td v-else>
                                    <span v-if="jobLine.mes_issue_qty > 0">
                                        <span
                                            style="color:darkgreen"
                                            v-if="jobLine.metaData.isIssueQtyConfirmed">
                                            ยืนยันแล้ว
                                        </span>

                                        <span
                                            style="color:red"
                                            v-if="!jobLine.metaData.isIssueQtyConfirmed">
                                            ยังไม่ยืนยัน
                                        </span>
                                    </span>
                                </td>

                                <!--จ่ายออกไป Boxbin-->
                                <td v-if="organizationCode == 'M02'" class="col-readonly"> <!-- 182 = M02 -->
                                    <span v-if="jobLine.boxbin_issue_qty">
                                        <!-- {{ jobLine.boxbin_issue_qty }} -->
                                        {{ Number(jobLine.boxbin_issue_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}
                                    </span>
                                    <span v-else> 0 </span>
                                </td>

                                <!-- ยืนยันยอดจ่ายออกไป Boxbin -->
                                <td v-if="organizationCode == 'M02'"> <!-- 182 = M02 -->
                                    <span v-if="jobLine.boxbin_issue_qty > 0">
                                        <!-- <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_boxbin_issue_qty"
                                            @change="calculateConfirmQuantity(jobLine.confirm_qty,jobLine.confirm_issue_qty,jobLine.confirm_boxbin_issue_qty)"
                                            :disabled="!isEditing"/> -->
                                        <vue-numeric
                                            id="input-confirm-quantity"
                                            separator="," 
                                            v-bind:precision="3" 
                                            v-bind:minus="false"
                                            class="form-control text-right" 
                                            v-model="jobLine.confirm_boxbin_issue_qty"
                                            @change="calculateConfirmQuantity(jobLine.confirm_qty,jobLine.confirm_issue_qty,jobLine.confirm_boxbin_issue_qty)"
                                            :disabled="!isEditing"
                                            ></vue-numeric>
                                    </span>
                                </td>

                                <!--สถานะ ยืนยันยอดจ่ายออกไป Boxbin-->
                                <!-- <td v-if="organizationCode == 'M02' && jobLine.boxbin_issue_qty > 0"> -->
                                <td v-if="organizationCode == 'M02'"> <!-- 182 = M02 -->
                                    <span v-if="jobLine.boxbin_issue_qty > 0">
                                        <span
                                            style="color:darkgreen"
                                            v-if="jobLine.metaData.isBoxbinIssueQtyConfirmed">
                                            ยืนยันแล้ว
                                        </span>
                                        <span
                                            style="color:red"
                                            v-if="!jobLine.metaData.isBoxbinIssueQtyConfirmed">
                                            ยังไม่ยืนยัน
                                        </span>
                                    </span>
                                </td>
                                <!-- <td v-else></td> -->

                                <!--คงคลังเย็น-->
                                <!-- NEW CODE -->
                                <td class="col-readonly">
                                    <!-- <span>{{ jobLine.ending_qty }}</span> -->
                                    <span>{{ Number(jobLine.ending_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}</span>
                                </td>
                                <!-- OLD CODE -->
                                <!-- <td class="col-readonly">
                                    <span v-if="jobLine.mes_qty && jobLine.metaData.isConfirmed && jobLine.ending_qty >= 0">
                                        {{ Number(jobLine.ending_qty).toLocaleString() }}
                                    </span>
                                    <span v-if="jobLine.mes_qty && !jobLine.metaData.isConfirmed"> 0 </span>
                                    <span v-if="!jobLine.mes_qty && jobLine.ending_qty > 0">
                                        {{ Number(jobLine.ending_qty).toLocaleString() }}
                                    </span>
                                    <span v-if="!jobLine.mes_qty && jobLine.ending_qty <= 0"> 0 </span>
                                </td> -->

                                <!--หน่วยนับ-->
                                <td class="col-readonly">
                                    <span v-if="jobLine.uom_code">
                                        {{ jobLine.uom_code }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mb-5" v-if="!isLoading && Object.keys(jobLines).length == 0">
                    <h2 style="color: red">ไม่พบข้อมูล</h2>
                </div>

                <!--loading indicator-->
                <div class="row text-center" v-if="isLoading">
                    <div class="col-lg-12">
                        <div class="sk-spinner sk-spinner-wave mb-4">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center m-t" v-if="!isLoading && Object.keys(jobLines).length > 0">
                    <button
                        type="button"
                        class="btn btn-w-m btn-warning"
                        @click.prevent="onEditButtonClicked">
                        <i class="fa fa-pencil-square-o"/>&nbsp;
                        แก้ไข
                    </button>

                    <button
                        type="button"
                        class="btn btn-w-m btn-primary"
                        @click.prevent="onSaveButtonClicked"
                        :disabled="!isSaveable">
                        <i class="fa fa-save (alias)"/>&nbsp;
                        บันทึก
                    </button>

                    <button
                        type="button"
                        class="btn btn-w-m btn-danger"
                        @click.prevent="onCloseButtonClicked">
                        <i class="fa fa-times"/>&nbsp;
                        ปิด
                    </button>
                </div>
                <div class="text-center m-t" v-if="!isLoading && Object.keys(jobLines).length == 0">
                    <button
                        type="button"
                        class="btn btn-w-m btn-danger"
                        @click.prevent="onCloseButtonClicked">
                        <i class="fa fa-times"/>&nbsp;
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {
    showLoadingDialog,
    showSaveFailureDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"
import {instance as http} from "../httpClient";
import _cloneDeep from "lodash/cloneDeep";
import {$route} from "../router";
import moment from "moment";
import VueNumeric from 'vue-numeric';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils';

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(moment(String(value)).add(543, 'years').toDate()).format('DD/MM/YYYY');
    }
})

export default {
    created() {
        Vue.nextTick(() => {
            this.setDefaultValue();
        });
    },
    components: {
        VueNumeric
    },
    props:[
        "pHeader", 'oldIput', 'transDate',
        "url", "transBtn", "profile", 
        // "jobSummary", 
        "opts", "pFromDate", "pToDate", "headerids"
    ],
    computed: {

    },
    data() {
        return {
            DEPARTMENT_TOBACCO: '61000200',
            DEPARTMENT_EXPANDED_TOBACCO: '61000300',
            lodash: {
                cloneDeep: _cloneDeep,
            },
            header: this.pHeader,
            headerOrgId: this.pHeader[0].organization_id ?? 0,
            user: this.profile,
            organizationCode: this.profile.organization_code,
            lines: [],
            lineAll: [],
            loading: {
                lines: false,
            },
            disabledInput: {
                blend_no: false,
                inventory_item_id: false,
            },
            firstLoad: true,
            linesTh: {},
            updateInput: {},
            // departmentCode: this.jobSummary.department_code,
            selectedJob: {},
            selectedOpt: {},
            selectedWip: {},
            isLoading: true,
            isEditing: false,
            isSaveable: false,
            // styleCSS: '',
            jobHeaderLines: {},
            jobLines: {},
            transactionDate: moment().add(543, 'years').toDate(),

            headerIDs: [],
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            search: {
                from_date: null,
                to_date: null,
            },
            fDate: this.pFromDate,
            tDate: this.pToDate,

            dateStart: null,
            dateEnd: null,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        calculateConfirmQuantity: function (confirmQty,confirmIssueQty,confirmBoxbinQty) {
            let confirmQTY = parseFloat(confirmQty === null ? 0 : confirmQty);
            let confirmIssueQTY = parseFloat(confirmIssueQty === null ? 0 : confirmIssueQty);
            let confirmBoxbinQTY = parseFloat(confirmBoxbinQty === null ? 0 : confirmBoxbinQty);
            let totalConfirmQTY = confirmIssueQTY + confirmBoxbinQTY;
            // console.log(confirmQTY,confirmIssueQTY,confirmBoxbinQTY);
            // console.log(totalConfirmQTY);
            if (totalConfirmQTY > confirmQTY) {
                // swal({
                //     title: '',
                //     text: 'ยอดรวมของ ยอดยืนยันจ่ายออก \nและ ยอดยืนยันจ่ายออกไป Boxbin \nไม่สามารถมากกว่า ยอดยืนยันผลผลิต',
                //     type: 'warning',
                //     showConfirmButton: true,
                //     closeOnConfirm: true,
                //     confirmButtonText: 'ปิด',
                // });
                // this.isSaveable = false;
            } else {
                this.isSaveable = true;
            }
        },

        indexPage() {
            // wip_confirm_index
            location.href = this.url.wip_confirm_index;
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
        },
        setDefaultValue() {
            this.search.from_date = this.pFromDate;
            this.search.to_date = this.pToDate;
            this.dateStart = this.pFromDate;
            this.dateEnd = this.pToDate;
            console.debug('setDefaultValue', this.opts[0]);
            this.changeSelectedJob(this.opts[0]);
        },
        changeSelectedJob(opt) {
            console.debug('changeSelectedJob', opt, this.header[0]);

            if(opt == 'ALL') {
                console.debug('getLines all..', opt, this.headerids);

                this.selectedOpt = opt;
                this.selectedWip.oprn_class_desc = 'ALL';
                this.getLines(this.headerids);
                this.headerIDs = this.headerids;
            } else {
                this.selectedJob = this.header.find(header => {
                    return header.opt === opt;
                });

                this.selectedOpt = opt;
                this.selectedWip = this.selectedJob.wip_steps[0];

                let reviewHeaderId = [this.selectedJob.review_header_id];
                this.getLines(reviewHeaderId);
                this.headerIDs = reviewHeaderId;
            }
        },
        onOptChanged() {
            console.debug('onOptChanged', this.selectedOpt);
            this.changeSelectedJob(this.selectedOpt);
        },
        onWipChanged(wip) {
            console.debug('onWipChanged', wip);

            this.jobLines = _.orderBy((this.jobHeaderLines.jobWipLines[wip.oprn_class_desc]), 'review_header_id', 'asc');
        },
        onSearchDateChanged() {
            this.getLines(this.headerIDs);
        },
        async getLines(reviewHeaderId) {
            console.debug('getLines', reviewHeaderId);
            let vm = this;

            this.isLoading = true;
            await axios.post(vm.url.ajax_lines, {
                    reviewHeaderId: reviewHeaderId,
                    // fromDate: this.fDate,
                    // toDate: this.tDate,
                    fromDate: this.search.from_date,
                    toDate: this.search.to_date,
                })
                .then(result => {
                    console.debug(result, result.data);
                    this.isLoading = false;
                    this.isEditing = false;

                    this.jobHeaderLines = result.data;
                    this.selectedJob = this.jobHeaderLines.jobHeader;
                    this.jobLines = _.orderBy((this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc]), 'review_header_id', 'asc');
                })
                .catch(err => {
                    console.debug(err);
                    this.isLoading = false;
                    // let data = err.response.data;
                    // alert(data.message);
                });

            return;
        },
        onEditButtonClicked() {
            console.debug('onEditButtonClicked');
            this.isEditing = true;
            this.isSaveable = true;

            Vue.nextTick(() => {
                // this.$refs['input-confirm-quantity-ref'][0].focus();
            });
        },
        onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            console.debug('validate calculateConfirmQuantity');
            let lineValiResult = true;
            let linesValidatation = _.orderBy((this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc]), 'review_header_id', 'asc');
            linesValidatation.forEach((line, index) => {
                let confirmQTY = parseFloat(line.confirm_qty === null ? 0 : line.confirm_qty);
                let confirmIssueQTY = parseFloat(line.confirm_issue_qty === null ? 0 : line.confirm_issue_qty);
                let confirmBoxbinQTY = parseFloat(line.confirm_boxbin_issue_qty === null ? 0 : line.confirm_boxbin_issue_qty);
                let totalConfirmQTY = confirmIssueQTY + confirmBoxbinQTY;
                if (totalConfirmQTY > confirmQTY) {
                    // console.log('confirmQTY,confirmIssueQTY,confirmBoxbinQTY');
                    // console.log(confirmQTY,confirmIssueQTY,confirmBoxbinQTY);
                    // console.log('totalConfirmQTY...');
                    // console.log(totalConfirmQTY);
                    // this.isSaveable = false;
                    // this.lineValiResult = false;
                    return this.lineValiResult;
                } else {
                    this.isSaveable = true;
                    this.lineValiResult = true;
                }
            });

            if (this.lineValiResult === false) {
                swal({
                    title: '',
                    text: 'ยอดรวมของ ยอดยืนยันจ่ายออก \nและ ยอดยืนยันจ่ายออกไป Boxbin \nไม่สามารถมากกว่า ยอดยืนยันผลผลิต',
                    type: 'warning',
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ปิด',
                });
            } else {

            showLoadingDialog();

            //update product date
            this.jobHeaderLines.jobHeader = this.lodash.cloneDeep(this.selectedJob);
            this.jobHeaderLines.jobHeader.product_date = moment(moment(this.transactionDate).subtract(543, 'years').toDate()).format('YYYY-MMM-D');

            axios.put(this.url.ajax_store, {
                    jobHeaderLines: this.jobHeaderLines,
                    selectedWip: this.selectedWip.oprn_class_desc
                })
                .then(result => {
                    console.debug(result, result.data);
                    swal.close();
                    this.isEditing = false;

                    this.jobHeaderLines = result.data;
                    this.jobLines = _.orderBy((this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc]), 'review_header_id', 'asc');
                })
                .catch(err => {
                    console.debug(err);
                    swal.close();
                    this.isEditing = false;

                    showSaveFailureDialog();
                });
            }

        },
        onCloseButtonClicked() {
            window.location = this.url.wip_confirm_index;
        },
        setConfirmIssueQty(lineId,confirmQty) {
            let lineFilter = this.jobLines.filter(lineData => {
                return lineData.review_line_id == lineId;
            });
            this.line = lineFilter[0];
            if (this.line && this.line['wip_step'] == 'WIP01') {
                this.line['confirm_issue_qty'] = confirmQty;
            }
        }

    },
    watch:{
        search: function (val) {
            this.onSearchDateChanged(); // when search date change, get lines again
        }
    },
}
</script>
