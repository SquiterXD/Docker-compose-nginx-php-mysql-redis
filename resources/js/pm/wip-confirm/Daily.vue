<template>
    <div>
        <div class="ibox float-e-margins" v-loading="loading.lines">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-3">
                        <h3 class="no-margins"> บันทึกผลผลิตประจำวัน</h3>
                    </div>
                </div>
            </div>
            <div class="ibox-content" v-loading="isLoading">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">วันที่ได้ผลผลิต<span style="color:red">*</span>:</label>
                            <div class="col-lg-3">
                                <!-- <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="fDate | formatDate"> -->
                                <ct-datepicker
                                    class="form-control my-1"
                                    style="width: 100%"
                                    placeholder="โปรดเลือกวันที่"
                                    :enableDate="date => isInRange(date, toJSDate(dateStart), toJSDate(dateEnd), true)"
                                    :value="toJSDate(search.from_date, 'yyyy-MM-dd')"
                                    @change="(date) => {
                                        selectedBlend = '';
                                        selectedBatch = '';
                                        selectedOpt = '';
                                        selectedJob = {};
                                        selectedWip = {};
                                        search.from_date = jsDateToString(date)
                                        search = {...search}
                                    }"
                                />
                            </div>
                            <label class="font-weight-bold col-form-label text-right">ถึง:</label>
                            <div class="col-lg-3">
                                <!-- <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="tDate | formatDate"> -->
                                <ct-datepicker
                                    class="form-control my-1"
                                    style="width: 100%"
                                    placeholder="โปรดเลือกวันที่"
                                    :enableDate="date => isInRange(date, toJSDate(dateStart), toJSDate(dateEnd), true)"
                                    :value="toJSDate(search.to_date, 'yyyy-MM-dd')"
                                    @change="(date) => {
                                        selectedBlend = '';
                                        selectedBatch = '';
                                        selectedOpt = '';
                                        selectedJob = {};
                                        selectedWip = {};
                                        search.to_date = jsDateToString(date)
                                        search = {...search}
                                    }"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-1">เลขที่คำสั่งการผลิต<span style="color:red">*</span>: </label>
                            <div class="col-lg-6">
                                <el-select :disabled="organizationCode == 'M02' && !selectedBlend"
                                    style="width: 100%"
                                    placeholder=""
                                    filterable
                                    clearable
                                    v-model="selectedBatch"
                                    @change="onBatchChanged($event)">
                                    <el-option
                                        v-for="(batch, idx) in search.batch_list"
                                        :key="idx"
                                        :label="batch.batch_no"
                                        :value="batch.batch_no">
                                        <span style="float: left">{{ batch.batch_no }}</span>
                                        <span v-if="organizationCode == 'M03'" style="float: right; color: #8492a6; font-size: 13px">{{ batch.item_number }}</span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">OPT<span style="color:red">*</span>: </label>
                            <div class="col-lg-6">
                                <el-select :disabled="!selectedBatch"
                                    style="width: 100%"
                                    placeholder=""
                                    filterable
                                    v-model="selectedOpt"
                                    @change="onOptChanged($event)">
                                    <el-option
                                        v-for="(opt, idx) in search.opt_list"
                                        :key="idx"
                                        :label="opt"
                                        :value="opt">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group row" v-if="showFreezeMsg">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">&nbsp;</label>
                            <div class="col-lg-6">
                                <h4  class="text-danger">
                                    {{ showFreezeMsg }}
                                </h4>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row"> <!-- 'M03' = M03 // ยาเส้นพอง -->
                            <label class="col-lg-3 font-weight-bold col-form-label text-right" for="lb-3">Blend No<span style="color:red">*</span>: </label>
                            <div class="col-lg-6">
                                <el-select :disabled="organizationCode == 'M03'"
                                    style="width: 100%"
                                    placeholder=""
                                    filterable
                                    clearable
                                    v-model="selectedBlend"
                                    @change="onBlendChanged($event)">
                                    <el-option
                                        v-for="(blend, idx) in search.blend_list"
                                        :key="idx"
                                        :label="blend"
                                        :value="blend">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right" for="lb-2">รหัสสินค้าสำเร็จรูป: </label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Object.keys(selectedJob).length ? selectedJob.item_data.item_number : ''">
                                    </div>
                                    <div class="col-lg-7 pl-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Object.keys(selectedJob).length ? selectedJob.item_data.item_desc : ''">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row" > <!-- 'M03' = M03 // ยาเส้นพอง -->
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">จำนวนที่ผลิต:</label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <template v-if="Object.keys(selectedJob).length == 0">
                                            <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Number(0).toLocaleString()"/>
                                        </template>
                                        <template v-else>
                                            <input v-if="organizationCode == 'M03'" type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Number(selectedJob.opt_plan_qty).toLocaleString()"/>
                                            <input v-else type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Number(selectedJob.opt_plan_qty).toLocaleString(undefined, { minimumFractionDigits: 3, maximumFractionDigits: 3 })"/>
                                        </template>
                                    </div>
                                    <div class="col-lg-4 pl-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Object.keys(selectedJob).length ? selectedJob.item_data.primary_unit_of_measure : ''"/>
                                    </div>
                                </div>
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
                    <div class="col-lg-6 text-right">
                        <button
                            type="button"
                            class="btn btn-w-m btn-primary "
                            @click.prevent="addLine"
                            :disabled="!allowAddLine">
                            <i class="fa fa-plus"/> เพิ่มรายการ
                        </button>
                    </div>
                </div>

            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table text-nowrap table-bordered"
                            v-if="!isLoading && Object.keys(jobLines).length > 0 && selectedOpt">
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
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(jobLine, i) in jobLines" :data="i"
                                style="text-align: center">

                                <!--วันที่ได้ผลผลิต-->
                                <!-- :enableDate="date => isInRange(date, Date.now(), null, true)" -->
                                <td class="col-readonly">
                                    <!-- <h1>{{ jobLine.review_line_id }}</h1> -->
                                    <span v-if="jobLine.transaction_date">
                                        <ct-datepicker v-if="jobLine.attribute15 && isEditing && !jobLine.freeze_msg"
                                            class="form-control my-1"
                                            style="width: 100%"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, freezeDate ? freezeDate : null, null, true)"
                                            :value="toJSDate(jobLine.transaction_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                setTransactionDate(jobLine, date)
                                            }"
                                        />
                                        <span v-else>
                                            {{ jobLine.transaction_date | formatDate }}
                                        </span>
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
                                    <span v-if="jobLine.beginning_qty < 0 || jobLine.beginning_qty > 0">
                                        {{ Number(jobLine.beginning_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}
                                    </span>
                                    <span v-else>
                                        0
                                    </span>
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
                                            @change="setConfirmIssueQty(jobLine)"
                                            :disabled="!isEditing || jobLine.freeze_msg"
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
                                            :disabled="!isEditing || jobLine.freeze_msg"
                                            @change="calculateConfirmQuantity(jobLine)"
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
                                            @change="updateBeginningQty(jobLine)"
                                            :disabled="!isEditing || jobLine.freeze_msg"
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
                                            @change="calculateConfirmQuantity(jobLine)"
                                            :disabled="!isEditing || jobLine.freeze_msg"
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
                                            @change="calculateConfirmQuantity(jobLine)"
                                            :disabled="!isEditing || jobLine.freeze_msg"
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
                                    <!-- <span>{{ Number(jobLine.ending_qty).toLocaleString(undefined, { minimumFractionDigits: 3 }) }}</span> -->
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
                                <td class="col-readonly">
                                    <button v-if="jobLine.attribute15 && !jobLine.freeze_msg" @click="delLine(i)"
                                        class="btn btn-danger btn-sm btn-circle btn-outline" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mb-5" v-if="!isLoading && (Object.keys(jobLines).length == 0 || !selectedOpt)">
                    <h2 style="color: red">ไม่พบข้อมูล โปรระบุข้อมูลให้ถูกต้อง</h2>
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

                <div class="text-center m-t" v-if="!isLoading && Object.keys(jobLines).length > 0 && selectedOpt">
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
                <!-- <div class="text-center m-t" v-if="!isLoading && Object.keys(jobLines).length == 0">
                    <button
                        type="button"
                        class="btn btn-w-m btn-danger"
                        @click.prevent="onCloseButtonClicked">
                        <i class="fa fa-times"/>&nbsp;
                        ปิด
                    </button>
                </div> -->
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
        'oldIput', 'transDate',
        "url", "transBtn", "profile",
        // "jobSummary",
        "pFromDate", "pToDate", "pDateStart", "pDateEnd"
    ],
    computed: {
        allowAddLine() {
            let vm = this;
            let allow = !vm.isLoading
                        && vm.selectedOpt != ''
                        && Object.keys(vm.selectedWip).length > 0
                        && Object.keys(vm.jobLines).length > 0;
            if (!allow) {
                return false;
            }

            allow = allow && (vm.selectedOpt != 'ALL' && vm.selectedOpt != '') && (vm.selectedWip != 'ALL' && vm.selectedWip != '')
            if (!allow) {
                return false;
            }

            let maxWip = vm.selectedJob.wip_steps[vm.selectedJob.wip_steps.length - 1];
            allow = allow && vm.selectedWip.oprn_class_desc == maxWip.oprn_class_desc;
            if (!allow) {
                return false;
            }

            let checkEndingQty = vm.jobLines[(Object.keys(vm.jobLines).length - 1)].ending_qty;
            return checkEndingQty > 0;
        },
        showFreezeMsg() {
            let vm = this;
            let allow = !vm.isLoading && Object.keys(vm.jobLines).length > 0;
            vm.freezeDate = null;
            if (!allow) {
                return false;
            }
            const hasFreezeData = vm.jobLines.filter(o => o.freeze_msg);
            if (hasFreezeData && hasFreezeData.length) {
                vm.freezeDate = moment(hasFreezeData[0].freeze_date).add(1, 'days').format('YYYY-MM-DD');
                return hasFreezeData[0].freeze_msg;
            }
            return false;
        },
    },
    data() {
        return {
            DEPARTMENT_TOBACCO: '61000200',
            DEPARTMENT_EXPANDED_TOBACCO: '61000300',
            lodash: {
                cloneDeep: _cloneDeep,
            },
            header: this.pHeader,
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
            selectedBlend: '',
            selectedBatch: '',
            selectedOpt: '',
            selectedJob: {},
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
                blend_list: [],
                batch_list_all: [],
                batch_list: [],
                opt_list: [],
            },
            fDate: this.pFromDate,
            tDate: this.pToDate,

            dateStart: null,
            dateEnd: null,
            freezeDate: null,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        // calculateConfirmQuantity: function (confirmQty,confirmIssueQty,confirmBoxbinQty) {
        calculateConfirmQuantity: function (jobLine) {
            let confirmQTY = parseFloat(jobLine.confirm_qty === null ? 0 : jobLine.confirm_qty);
            let confirmIssueQTY = parseFloat(jobLine.confirm_issue_qty === null ? 0 : jobLine.confirm_issue_qty);
            let confirmBoxbinQTY = parseFloat(jobLine.confirm_boxbin_issue_qty === null ? 0 : jobLine.confirm_boxbin_issue_qty);
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
            this.updateBeginningQty(jobLine);
        },

        indexPage() {
            // wip_confirm_index
            location.href = this.url.wip_confirm_index;
        },
        async setdate(date, key) {
            let vm = this;
            // vm.header[key] = await moment(date).format(vm.transDate['js-format']);
        },
        async setDefaultValue() {
            this.search.from_date = this.pFromDate;
            this.search.to_date = this.pToDate;
            // this.dateStart = this.pFromDate;
            // this.dateEnd = this.pToDate;
            this.dateStart = this.pDateStart;
            this.dateEnd = this.pDateEnd;
            // console.debug('setDefaultValue', this.opts[0]);
            // this.changeSelectedJob(this.opts[0]);
            this.getLines([]);
        },
        async changeSelectedJob(opt) {
            // console.debug('changeSelectedJob', opt, this.header[0]);
            await this.getLines([]);
            this.selectedOpt = opt;
            // if(opt == 'ALL') {
            //     console.debug('getLines all..', opt);
            //     this.selectedWip.oprn_class_desc = 'ALL';
            // } else {
            //     this.selectedOpt = opt;
            // }
            this.selectedWip = this.selectedJob.wip_steps[0]; // default WIP
            await this.onWipChanged(this.selectedWip);
        },
        onBlendChanged() {
            this.selectedBatch = '';
            this.selectedJob = {};
            this.selectedWip = {};
            this.selectedOpt = '';
            if (this.selectedBlend) {
                this.search.batch_list = this.search.batch_list_all.filter(o => {
                    return o.blend_no == this.selectedBlend;
                });
            } else {
                this.search.batch_list = [];
            }
        },
        async onBatchChanged() {
            // this.selectedBatch = '';
            this.selectedJob = {};
            this.selectedWip = {};
            this.selectedOpt = '';
            if (this.selectedBatch) {
                await this.changeSelectedJob('ALL');
            } else {
                this.search.opt_list = [];
            }
        },
        onOptChanged() {
            console.debug('onOptChanged', this.selectedOpt);
            this.changeSelectedJob(this.selectedOpt);
        },
        async onWipChanged(wip) {
            console.debug('onWipChanged', wip);
            // this.jobLines = _.orderBy((this.jobHeaderLines.jobWipLines[wip.oprn_class_desc]), 'review_header_id', 'asc');
            let vm = this;
            // let lines = _.orderBy((this.jobHeaderLines.jobWipLines[wip.oprn_class_desc]), 'review_header_id', 'asc');
            let lines = this.jobHeaderLines.jobWipLines[wip.oprn_class_desc];
                lines.forEach(async function(line, index) {
                    await vm.calEndingQty(line);
                });
            vm.jobLines = lines;
        },
        onSearchDateChanged() {
            this.getLines([]);
        },
        async getLines(reviewHeaderId, oprnClassDesc = false) {
            console.debug('getLines', reviewHeaderId);
            let vm = this;

            this.isLoading = true;
            await axios.get(vm.url.ajax_lines, {
                    params: {
                        reviewHeaderId: reviewHeaderId,
                        // fromDate: this.fDate,
                        // toDate: this.tDate,
                        fromDate: this.search.from_date,
                        toDate: this.search.to_date,
                        blendNo: this.selectedBlend,
                        batchNo: this.selectedBatch,
                        opt: this.selectedOpt,
                    }
                })
                .then(result => {
                    // console.debug(result, result.data);
                    this.isLoading = false;
                    this.isEditing = false;

                    // if (Object.keys(this.selectedOpt).length == 0) {
                        // selectedBlend
                    if ((!this.selectedBlend || this.organizationCode == 'M03') && !this.selectedBatch) {
                        this.search.blend_list      = result.data.search.blend_list;
                        this.search.batch_list_all  = result.data.search.batch_list_all;
                        if (this.organizationCode == 'M03') {
                            this.search.batch_list  = result.data.search.batch_list_all;
                        }
                    }
                    if (this.selectedBatch && !this.selectedOpt) {
                        this.search.opt_list        = result.data.search.opt_list;
                    }

                    this.jobHeaderLines = result.data;
                    this.selectedJob = this.jobHeaderLines.jobHeader;
                    if (oprnClassDesc) {
                        // this.jobLines = _.orderBy((this.jobHeaderLines.jobWipLines[oprnClassDesc]), 'review_header_id', 'asc');
                        this.jobLines = this.jobHeaderLines.jobWipLines[oprnClassDesc]
                    } else {
                        this.jobLines = [];
                    }
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
        async onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            console.debug('validate calculateConfirmQuantity');
            let lineValiResult = true;
            // let linesValidatation = _.orderBy((this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc]), 'review_header_id', 'asc');
            // let linesValidatation = _.orderBy((this.jobLines), 'review_header_id', 'asc');
            let linesValidatation = this.jobLines;
            await linesValidatation.forEach((line, index) => {
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

            let lineData = _.clone(this.jobHeaderLines);
                // lineData.jobWipLines.[this.selectedWip.oprn_class_desc] = _.orderBy((this.jobLines), 'review_header_id', 'asc');
                lineData.jobWipLines.[this.selectedWip.oprn_class_desc] = this.jobLines;
            // console.log('--------------------', )

            await axios.put(this.url.ajax_store, {
                    jobHeaderLines: lineData,
                    selectedWip: this.selectedWip.oprn_class_desc
                })
                .then(result => {
                    console.debug(result, result.data);
                    this.isEditing = false;
                    if (result.data.errors.length > 0) {
                        showValidationFailedDialog(result.data.errors);
                    } else {
                        swal.close();
                    }

                    // this.jobHeaderLines = result.data;
                    // this.jobLines = _.orderBy((this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc]), 'review_header_id', 'asc');
                    this.getLines([], this.selectedWip.oprn_class_desc);
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
        setConfirmIssueQty(jobLine) {
            let lineFilter = this.jobLines.filter(lineData => {
                return lineData.review_line_id == jobLine.review_line_id;
            });
            this.line = lineFilter[0];
            if (this.line && this.line['wip_step'] == 'WIP01') {
                this.line['confirm_issue_qty'] = jobLine.confirm_qty;
            }
            this.updateBeginningQty(jobLine);
        },
        async updateBeginningQty(jobLine) {
            let vm = this;

            // Find Next OPT
            let nextOpt = this.jobLines.filter(o => {
                return  o.wip_step == jobLine.wip_step &&
                        o.opt == jobLine.opt &&
                        o.transaction_date_seq > jobLine.transaction_date_seq
            });
            nextOpt = _.orderBy(nextOpt, 'transaction_date_seq', 'asc');
            // console.log("------------------------------------------------------  updateBeginningQty "
            //     ,"review_line_id", jobLine.review_line_id
            //     ,"list", nextOpt
            // );
            // await nextOpt.forEach((line, index) => {
            await vm.calEndingQty(jobLine);
            await nextOpt.forEach(async function(line, index) {
                // console.log("=============================================== Start Loop =========================================");
                // console.log("-------------- Loop Before;"
                //     , "review_line_id", line.review_line_id
                //     , "transaction_date_seq", line.transaction_date_seq
                //     , "beginning_qty", line.beginning_qty
                //     , "ending_qty", line.ending_qty
                //     , "confirm_qty", line.confirm_qty
                // );
                if (index === 0) {
                    line.beginning_qty = jobLine.ending_qty ? parseFloat(jobLine.ending_qty) : 0;
                } else {
                    line.beginning_qty = nextOpt[index - 1].ending_qty ? parseFloat(nextOpt[index - 1].ending_qty) : 0;
                }
                // console.log("-------------- Loop After"
                //     , "review_line_id", line.review_line_id
                //     , "transaction_date_seq", line.transaction_date_seq
                //     , "beginning_qty", line.beginning_qty
                //     , "ending_qty", line.ending_qty
                //     , "confirm_qty", line.confirm_qty
                // );
                // console.log("=============================================== End Loop =========================================");
                await vm.calEndingQty(line);
            });

        },
        async calEndingQty(jobLine) {
            let vm = this;
            let endingQty       = 0;
            let beginningQty    = jobLine.beginning_qty     ? jobLine.beginning_qty : 0;
            let confirmQty      = jobLine.confirm_qty       ? jobLine.confirm_qty : 0;
            let confirmIssueQty = jobLine.confirm_issue_qty ? jobLine.confirm_issue_qty : 0;

            endingQty           = (parseFloat(beginningQty) + parseFloat(confirmQty)) - parseFloat(confirmIssueQty);
            jobLine.ending_qty  = endingQty;
            // console.log("-------------- calEndingQty "
            //     , "jobLine.beginning_qty => ", jobLine.beginning_qty
            //     , "review_line_id => ", jobLine.review_line_id
            //     , "beginningQty => ", beginningQty
            //     , "confirmQty => ", confirmQty
            //     , "confirmIssueQty => ", confirmIssueQty
            //     , "endingQty => ", endingQty
            //     , "jobLine.ending_qty => ", jobLine.ending_qty
            // );
            return jobLine;
            return endingQty;
        },
        delLine(idx) {
            let vm = this;
            let line = vm.jobLines[idx];
            if (!line.attribute15) {
                return;
            }
            if (!line.review_line_id) {
                vm.jobLines.splice(idx, 1);
            } else {
                swal({
                    title: "Warning",
                    text: "ต้องการลบรายการหรือไม่?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        showLoadingDialog();
                        axios.put(vm.url.ajax_delete, {
                            review_line_id: line.review_line_id,
                        })
                        .then(result => {
                            if (result.data.errors.length > 0) {
                                showValidationFailedDialog(result.data.errors);
                            } else {
                                swal.close();
                                vm.getLines([]);
                            }
                        })
                        .catch(err => {
                            console.debug(err);
                            swal.close();
                            showSaveFailureDialog();
                        });
                    }
                });
            }
        },
        async addLine() {
            let vm = this;
            if (Object.keys(vm.jobLines).length == 0) {
                return;
            }
            let newLine = await _.clone(vm.jobLines[Object.keys(vm.jobLines).length - 1]);

            if (newLine.attribute15) {
                newLine.transaction_date    = moment(newLine.transaction_date).add(1, 'days').format('YYYY-MM-DD');
                if (await moment(newLine.transaction_date) <=  await moment(vm.freezeDate)) {
                    newLine.transaction_date = vm.freezeDate;
                }
            } else {
                newLine.transaction_date    = moment().format('YYYY-MM-DD');
            }
            newLine.transaction_date_seq = await moment(newLine.transaction_date).format('YYYYMMDD');
            newLine.review_line_id      = '';
            newLine.attribute15         =  1; // is_new

            newLine.mes_qty             = 0; // ผลผลิตที่ได้
            newLine.confirm_qty         = 0; // ยืนยันยอดผลผลิต
            newLine.confirm_issue_qty   = newLine.ending_qty; // ยืนยันยอดจ่ายออก
            newLine.beginning_qty       = newLine.ending_qty;

            newLine.loss_qty            = 0; // สูญเสีย
            newLine.mes_issue_qty       = newLine.ending_qty; // จ่ายออก
            newLine.boxbin_issue_qty    = 0; // จ่ายออกไป Boxbin

            newLine.freeze_msg          = null;
            newLine.metaData.confirmQtyIsDisabled   = false;
            newLine.metaData.isConfirmed            = false;
            newLine.metaData.isIssueQtyConfirmed    = false;
            vm.jobLines.push(newLine);
        },
        setTransactionDate(jobLine, date) {
            jobLine.transaction_date = jsDateToString(date)
            jobLine.transaction_date_seq = moment(date).format('YYYYMMDD');
        }

    },
    watch:{
        search: function (val) {
            this.onSearchDateChanged(); // when search date change, get lines again
        }
    },
}
</script>
