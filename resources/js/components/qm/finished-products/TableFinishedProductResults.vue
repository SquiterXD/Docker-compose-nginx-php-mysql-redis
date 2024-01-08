<template>

    <div class="tw-ml-5 tw-mr-20 tw-py-2">

        <table class="table table-borderless-horizontal mb-0">
            <thead>
                <tr class="tw-bg-opacity-40 tw-bg-blue-100">
                    <th width="2%" style="z-index: auto;" class="tw-text-gray-600">
                        กระบวนการ
                    </th>
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-text-xs md:tw-table-cell tw-hidden">
                        รายการตรวจสอบ
                    </th>
                    <th width="15%" style="z-index: auto;" class="tw-text-gray-600">
                        ข้อมูลการตรวจสอบ/ความผิดปกติ
                    </th>
                    <th colspan="2" width="12%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        จำนวนที่พบ/ผลการตรวจสอบ
                    </th>
                    <!-- HIDE : 13/10/2022 -->
                    <!-- <th width="4%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ค่าOPTIMAL
                    </th> -->
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        สาเหตุ
                    </th>
                    <th width="5%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        อยู่ในช่วงควบคุม
                    </th>
                    <th width="4%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ผลปกติ
                    </th>
                    <th width="4%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ไม่สามารถลงผลการตรวจสอบได้
                    </th>
                    <th width="10%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        เหตุผลที่ไม่สามารถเก็บข้อมูลได้
                    </th>
                    <th width="4%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        
                    </th>
                    <th width="6%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ระดับความรุนแรงของความผิดปกติ (จำนวน)
                    </th>
                    <th width="6%" style="z-index: auto;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ระดับความรุนแรงของความผิดปกติ (อาการ)
                    </th>
                    <th width="7%" style="z-index: auto; min-width: 160px;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        <span v-if="showType != 'result'"> รูปภาพ </span>
                    </th>
                    <th v-if="showType == 'result'" width="7%" style="z-index: auto; min-width: 100px;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        แนบรูปภาพ
                    </th>
                    <th width="7%" style="z-index: auto; min-width: 100px;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        รูปภาพตัวอย่าง
                    </th>
                    <th v-if="showType == 'defect'" width="10%" style="z-index: auto; min-width: 200px;" class="tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden">
                        สาเหตุ
                    </th>
                </tr>
            </thead>
            <tbody v-if="sampleResults.length > 0">
                
                <!-- RESULT HEADER -->
                <tr>
                    <td colspan="16" class="tw-text-xs tw-bg-opacity-60 tw-bg-gray-200 tw-font-bold">
                        <div> ข้อมูลการตรวจสอบ </div>
                    </td>
                </tr>
                <tr v-for="(sampleResultHeader, indexH) in sampleResultHeaders" :key="`header_${indexH}`">
                    <td class="tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"></td>
                    <td class="tw-text-xs">
                        
                    </td>
                    <td class="tw-text-xs">
                        <div class="tw-py-2">
                            {{ sampleResultHeader.selected_test_desc }}
                            <span class="tw-text-red-600"> * </span>
                        </div>
                    </td>
                    <td class="" colspan="2">

                        <div v-if="showType == 'result' && sampleResultHeader.read_only != 'Y' && isAllowEdit(sampleData, approvalRole)">

                            <template v-if="sampleResultHeader.brand_flag == 'Y'">
                                <!-- <div v-bind:class="[ !isCannotGetResult ? 'qm-el-select-required' : '']"> -->
                                <div class="qm-el-select-required">
                                    <qm-el-select
                                        :id="`input_header_result_value_${indexH}`"
                                        :name="`header_result_value_${indexH}`"
                                        option-key="brand_value"
                                        option-value="brand_value"
                                        option-label="brand_label"
                                        :select-options="listBrands"
                                        :value="sampleResultHeader.result_value"
                                        @onSelected="onHeaderResultChanged($event, sampleResultHeader)"
                                        size="small"
                                        :clearable="true"
                                        :filterable="true"
                                    />
                                </div>
                            </template>
                            <template v-else-if="sampleResultHeader.test ? sampleResultHeader.test.time_flag == 'Y' : false">
                                <!-- RESULT TIME -->
                                <div class="qm-time-picker-required">
                                    <qm-timepicker 
                                        :id="`input_header_result_value_${indexH}`"
                                        :name="`header_result_value_${indexH}`"
                                        :value="sampleResultHeader.result_value" 
                                        @change="onHeaderResultChanged($event, sampleResultHeader)"
                                    />
                                </div>
                            </template>
                            <template v-else-if="sampleResultHeader.selected_test_code == 'RESULT_BY'">
                                <!-- RESULT_BY -->
                                <div class="tw-py-2">
                                    {{ authUser ? authUser.name : "-" }}
                                </div>
                            </template>
                            <template v-else-if="sampleResultHeader.data_type_code == 'N'">
                                <input
                                    :id="`input_header_result_value_${indexH}`"
                                    type="number"
                                    class="form-control input-sm text-center"
                                    :name="`header_result_value_${indexH}`"
                                    v-model="sampleResultHeader.result_value"
                                    placeholder=""
                                />
                            </template>
                            <template v-else>
                                <!-- OTHER -->
                                <input
                                    :id="`input_header_result_value_${indexH}`"
                                    type="text"
                                    class="form-control input-sm text-center"
                                    :name="`header_result_value_${indexH}`"
                                    v-model="sampleResultHeader.result_value"
                                    placeholder=""
                                />
                            </template>

                        </div>
                        <div v-else class="tw-px-2">
                            <template v-if="sampleResultHeader.brand_flag == 'Y'">
                                {{ sampleResultHeader.result_value ? getBrandLabel(sampleResultHeader.result_value) : "-" }}
                            </template>
                            <template v-else>
                                {{ sampleResultHeader.result_value }}
                            </template>
                        </div>

                    </td>

                    <td colspan="11">
                    
                    </td>

                </tr>

                <!-- RESULT DETAILS -->
                <template v-for="(sampleResult, index) in sampleResults">
                    <tr :key="`${index}`">
                        <td colspan="16" class="tw-text-xs tw-bg-opacity-60 tw-bg-gray-200 tw-font-bold">
                            <div> {{ sampleResult.qm_process }} : {{ sampleResult.machine_description }} จำนวนตัวอย่าง {{ sampleResult.sample_qty }} {{ sampleResult.qc_unit_code }}  </div>
                        </td>
                    </tr>
                    <tr
                        v-for="(sampleResultLine,lineIndex) in sampleResultLines.filter(srl => srl.qm_process == sampleResult.qm_process)"
                        :key="`${index}-${lineIndex}`"
                    >
                        <td class="tw-text-right tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden">
                            <div v-if="sampleResultLine.additional_line_flag == 'Y' && showType == 'result' && isAllowEdit(sampleData, approvalRole)" class="tw-pt-1">
                                <button class="btn btn-xs btn-danger" @click="onRemoveResultLine(sampleResultLine)">
                                    <span class="fa fa-times"></span> 
                                </button>
                            </div>
                        </td>
                        <td class="tw-text-xs">
                            <div v-if="sampleResultLine.additional_line_flag != 'Y' || showType != 'result' || !isAllowEdit(sampleData, approvalRole)" class="">
                                {{ sampleResultLine.check_list }}
                                <span v-if="sampleResultLine.optional_ind != 'Y'" class="tw-text-red-600"> * </span>
                            </div>
                            <div v-else>
                                <qm-el-select
                                    :id="`input_check_list_${index}_${lineIndex}`"
                                    :name="`check_list[${index}][${lineIndex}]`"
                                    option-key="check_list"
                                    option-value="check_list"
                                    option-label="check_list"
                                    :select-options="availableCheckListItems.filter(item => item.qm_process == sampleResultLine.qm_process)"
                                    :value="sampleResultLine.check_list"
                                    @onSelected="onSelectedCheckListItem($event, sampleResultLine)"
                                    size="small"
                                    :clearable="false"
                                    :filterable="true"
                                />
                            </div>
                        </td>
                        <td class="tw-text-xs">
                            <div v-if="showType == 'result' && sampleResultLine.read_only != 'Y' && isAllowEdit(sampleData, approvalRole)">
                                <template v-if="sampleResultLine.additional_line_flag != 'Y'">
                                    <qm-el-select
                                        :id="`input_test_id_${index}_${lineIndex}`"
                                        :name="`test_id[${index}][${lineIndex}]`"
                                        option-key="test_id"
                                        option-value="test_id"
                                        option-label="test_desc"
                                        :select-options="checkListTestItems.filter(item => item.qm_process == sampleResultLine.qm_process && item.check_list == sampleResultLine.check_list)"
                                        :value="sampleResultLine.selected_test_id"
                                        @onSelected="onSelectedCheckListTestItem($event, sampleResultLine)"
                                        size="small"
                                        :clearable="false"
                                        :filterable="true"
                                    />
                                </template>
                                <template v-else>
                                    <qm-el-select
                                        :id="`input_test_id_${index}_${lineIndex}`"
                                        :name="`test_id[${index}][${lineIndex}]`"
                                        option-key="test_id"
                                        option-value="test_id"
                                        option-label="test_desc"
                                        :select-options="availableCheckListTestItems.filter(item => item.qm_process == sampleResultLine.qm_process && item.check_list == sampleResultLine.check_list)"
                                        :value="sampleResultLine.selected_test_id"
                                        @onSelected="onSelectedCheckListTestItem($event, sampleResultLine)"
                                        size="small"
                                        :clearable="false"
                                        :filterable="true"
                                    />
                                </template>

                            </div>
                            <div v-else>
                                {{ sampleResultLine.selected_test_desc }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div v-if="isAllowEdit(sampleData, approvalRole)">
                                <template v-if="showType != 'result' || sampleResultLine.read_only == 'Y'">
                                    <input
                                        type="text"
                                        class="form-control input-sm text-right tw-border-white"
                                        style="background-color: #ffffff; max-width: 100px;"
                                        disabled
                                        :value="sampleResultLine.result_value ? sampleResultLine.result_value : '-'"
                                    />
                                </template>
                                <template v-else-if="sampleResultLine.data_type_code == 'N'">
                                    <input :id="`input_result_value_${index}_${lineIndex}`"
                                        :name="`result_value_${index}_${lineIndex}`"
                                        type="number"
                                        class="form-control input-sm text-center"
                                        style="max-width: 100px;"
                                        v-model="sampleResultLine.result_value"
                                        :disabled="sampleResultLine.optimal_result_flag || sampleResultLine.cannot_get_result_flag"
                                        placeholder=""
                                        @change="onResultValueChanged($event, sampleResult, sampleResultLine)"
                                    />
                                </template>
                                <template v-else>
                                    <input :id="`input_result_value_${index}_${lineIndex}`"
                                        :name="`result_value_${index}_${lineIndex}`"
                                        type="text"
                                        class="form-control input-sm text-center"
                                        style="max-width: 100px;"
                                        v-model="sampleResultLine.result_value"
                                        :disabled="sampleResultLine.optimal_result_flag || sampleResultLine.cannot_get_result_flag"
                                        placeholder=""
                                        @change="onResultValueChanged($event, sampleResult, sampleResultLine)"
                                    />
                                </template>
                            </div>
                            <div v-else>
                                {{ sampleResultLine.result_value ? parseFloat(sampleResultLine.result_value) : '' }}
                            </div>
                        </td>
                        <td class="text-left tw-text-xs md:tw-table-cell tw-hidden">
                            <div class=""> {{ sampleResultLine.selected_test_unit_desc }} </div>
                        </td>
                        <!-- HIDE : 13/10/2022 -->
                        <!-- <td class="text-right tw-text-xs md:tw-table-cell tw-hidden">
                            <input
                                type="text"
                                class="form-control input-sm text-right tw-border-white"
                                style="background-color: #ffffff;"
                                disabled
                                :value="sampleResultLine.selected_optimal_value"
                            />
                        </td> -->
                        <td class="text-left tw-text-xs md:tw-table-cell tw-hidden">
                            <input type="text"
                                class="form-control input-sm text-left"
                                v-model="sampleResultLine.cause_of_defect"
                                :disabled="!isAllowEdit(sampleData, approvalRole)"
                                placeholder="ระบุสาเหตุ"
                            />
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <span v-if="sampleResultLine.result_status == 'PASSED'" class="fa fa-2x fa-check-circle tw-text-green-500"></span>
                            <span v-if="sampleResultLine.result_status == 'FAILED'" class="fa fa-2x fa-times tw-text-red-500"></span>
                            <span v-if="!sampleResultLine.result_status" class="fa fa-2x fa-minus"></span>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <div class="tw-mt-2" v-if="showType == 'result' && isAllowEdit(sampleData, approvalRole)">
                                <qm-el-checkbox
                                    :value="sampleResultLine.optimal_result_flag"
                                    label=""
                                    :name="`optimal_result_flag_${index}`"
                                    :id="`optimal_result_flag_${index}`"
                                    size="medium"
                                    @change="onOptimalResultCheckBoxChanged($event, sampleResultLine)"
                                ></qm-el-checkbox>
                            </div>
                            <div v-else>
                                <span v-if="sampleResultLine.optimal_result_flag" class="fa fa-2x fa-check-circle tw-text-green-500"></span>
                            </div>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <div class="tw-mt-2" v-if="showType == 'result' && isAllowEdit(sampleData, approvalRole)">
                                <qm-el-checkbox
                                    :value="sampleResultLine.cannot_get_result_flag"
                                    label=""
                                    :name="`cannot_get_result_flag_${index}`"
                                    :id="`input_cannot_get_result_flag_${index}`"
                                    size="medium"
                                    @change="onCannotGetResultCheckBoxChanged($event, sampleResult, sampleResultLine)"
                                ></qm-el-checkbox>
                            </div>
                            <div v-else>
                                <span v-if="sampleResultLine.cannot_get_result_flag" class="fa fa-2x fa-check-circle tw-text-red-500"></span>
                            </div>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <div v-if="showType == 'result' && isAllowEdit(sampleData, approvalRole)">
                                <input type="text"
                                    :disabled="!sampleResultLine.cannot_get_result_flag"
                                    class="form-control input-sm tw-text-xs text-left"
                                    v-bind:style="{ backgroundColor: sampleResultLine.cannot_get_result_flag ? '#fffbe4' : '' }"
                                    v-model="sampleResultLine.cannot_get_result_reason"
                                    @blur="onCannotGetResultReasonChanged($event, sampleResultLine)"
                                    placeholder="เหตุผลที่ไม่สามารถเก็บข้อมูล"
                                />
                            </div>
                            <div v-else class="tw-py-2">
                                <span v-if="sampleResultLine.cannot_get_result_flag">
                                    {{ sampleResultLine.cannot_get_result_reason }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                            <span v-if="sampleResultLine.failed_status == 'UNDER'" class="fa fa-2x fa-arrow-down tw-text-blue-500"></span>
                            <span v-else-if="sampleResultLine.failed_status == 'OVER'" class="fa fa-2x fa-arrow-up tw-text-red-500"></span>
                        </td>
                        <td class="text-center tw-text-xs">
                            <div v-if="!sampleResultLine.severity_level" class="tw-text-gray-500 tw-font-bold"> - </div>
                            <div v-else-if="sampleResultLine.severity_level == 'NONE'" class="tw-text-gray-500 tw-font-bold"> - </div>
                            <div v-else-if="sampleResultLine.severity_level == 'MINOR'" class="tw-text-blue-500 tw-font-bold"> MINOR </div>
                            <div v-else-if="sampleResultLine.severity_level == 'MAJOR'" class="tw-text-yellow-500 tw-font-bold"> MAJOR </div>
                            <div v-else-if="sampleResultLine.severity_level == 'CRITICAL'" class="tw-text-red-700 tw-font-bold"> CRITICAL </div>
                        </td>
                        <td class="text-center tw-text-xs">

                            <div v-if="showType == 'result' && sampleResultLine.read_only != 'Y' && isAllowEdit(sampleData, approvalRole)">
                                <qm-el-select
                                    :id="`input_test_serverity_code_${index}_${lineIndex}`"
                                    :name="`test_serverity_code[${index}][${lineIndex}]`"
                                    option-key="value"
                                    option-value="value"
                                    option-label="label"
                                    :select-options="listTestServerityCodes"
                                    :value="sampleResultLine.test_serverity_code"
                                    @onSelected="onSelectedTestServerityCode($event, sampleResultLine)"
                                    size="small"
                                    :clearable="false"
                                    :filterable="true"
                                />
                            </div>
                            <div v-else>
                                <!-- <template v-if="sampleResultLine.result_status == 'FAILED'"> -->
                                <div v-if="!sampleResultLine.test_serverity_code" class="tw-text-gray-500 tw-font-bold"> - </div>
                                <div v-else-if="sampleResultLine.test_serverity_code == 'NONE'" class="tw-text-gray-500 tw-font-bold"> - </div>
                                <div v-else-if="sampleResultLine.test_serverity_code == 'MINOR'" class="tw-text-blue-500 tw-font-bold"> MINOR </div>
                                <div v-else-if="sampleResultLine.test_serverity_code == 'MAJOR'" class="tw-text-yellow-500 tw-font-bold"> MAJOR </div>
                                <div v-else-if="sampleResultLine.test_serverity_code == 'CRITICAL'" class="tw-text-red-700 tw-font-bold"> CRITICAL </div>
                                <!-- </template> -->
                            </div>

                        </td>

                        <td class="text-center tw-text-xs">

                            <div v-for="(uploadedImage, i) in sampleResultLine.uploadedImages" :key="i" class="tw-py-2 tw-block">
                                <a class="btn btn-outline btn-primary tw-py-2 tw-px-1 tw-inline-block" 
                                    :href="`/qm/files/image/qm/finished-products/result-quality-line/${uploadedImage.file_name}`" 
                                    target="_blank">
                                    <span class="fa fa-picture-o tw-mr-1"></span> ดูแนบรูปภาพ
                                </a>
                                <button v-if="isAllowEdit(sampleData, approvalRole)" type="button" class="btn btn-danger btn-outline tw-inline-block tw-text-red-700 tw-py-2 tw-px-2" 
                                    @click="onDeleteResultLineUplodedImage(sampleResultLine, i)">
                                    <span class="fa fa-times"></span>
                                </button>
                            </div>

                        </td>

                        <td v-if="showType == 'result'" class="text-center tw-text-xs">

                            <button v-if="isAllowEdit(sampleData, approvalRole)" type="button" class="btn btn-xs btn-outline btn-success tw-py-2" @click="validateBeforeChooseImages(sampleResultLine, index, lineIndex)">
                                <i class="fa fa fa-upload tw-mr-1"></i> เลือกรูปภาพ
                            </button>

                            <div class="tw-hidden">
                                <div class="custom-file custom-file-th">
                                    <input type="file"
                                        accept="image/jpeg,image/gif,image/png"
                                        :id="`input_image_${index}_${lineIndex}`"
                                        :name="`image_${index}_${lineIndex}`"
                                        class="custom-file-input"
                                        :ref-label="`label_image_${index}_${lineIndex}`"
                                        @change="validateImages($event, sampleResultLine)"
                                        :ref="`finished_products_result_quality_line_image_${index}_${lineIndex}`"
                                        multiple>
                                </div>
                            </div>
                            
                            <div v-for="(image, i) in sampleResultLine.images" :key="i">
                                <label class="tw-mt-2 tw-mb-1 tw-text-gray-500" 
                                    style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ image.name }}
                                </label>
                                <label v-if="isAllowEdit(sampleData, approvalRole)" class="tw-mb-1 tw-ml-2 tw-text-red-700 fa fa-times tw-cursor-pointer tw-inline-block" 
                                    style="overflow: hidden;" 
                                    @click="onDeleteResultLineImage(sampleResultLine, i)">
                                </label>
                            </div>

                        </td>

                        <td class="text-center tw-text-xs">
                            <button type="button" class="btn btn-xs btn-outline tw-w-20 tw-bg-opacity-20 tw-bg-purple-200 tw-border-purple-400 hover:tw-bg-purple-200 hover:tw-border-purple-400 tw-py-2 tw-text-purple-600" @click="onShowModalTestImages(sampleResultLine)">
                                <span class="fa fa-picture-o tw-mr-1"></span> ดูภาพ
                            </button>
                        </td>

                        <td v-if="showType == 'defect'" class="text-left tw-text-xs" style="padding-right: 0px;">
                            <template v-if="sampleResultLine.result_status == 'FAILED'">
                                <input type="text"
                                    class="form-control input-sm text-left"
                                    v-model="sampleResultLine.cause_of_defect"
                                    :disabled="!isAllowEdit(sampleData, approvalRole)"
                                    placeholder="ระบุสาเหตุ"
                                />
                            </template>
                            <template v-else>
                                <input type="text" class="form-control input-sm text-left" disabled />
                            </template>
                        </td>
                    </tr>
                    <tr v-if="showType == 'result' && sampleResult.show_input_issue_not_found && isAllowEdit(sampleData, approvalRole)" :key="`${index}-issue_not_found`">
                        <td></td>
                        <td class="tw-text-xs"> <div class=""> ไม่พบความผิดปกติ </div> </td>
                        <td class="qm_issue_not_found_checkbox">
                            <div class="tw-pt-2">
                                <qm-el-checkbox
                                    :value="sampleResult.issue_not_found"
                                    label=""
                                    :name="`issue_not_found_${index}`"
                                    :id="`input_issue_not_found_${index}`"
                                    size="medium"
                                    :disabled="!isAllowEdit(sampleData, approvalRole)"
                                    @change="onIssueNotFouldCheckBoxChanged($event, sampleResult)"
                                ></qm-el-checkbox>
                            </div>
                        </td>
                        <td colspan="8">
                        </td>
                    </tr>
                    <tr v-if="showType == 'result' && !sampleResult.cannot_get_result_flag && !sampleResult.issue_not_found" :key="`${index}-add_button`">
                        <td></td>
                        <td colspan="15">
                            <button v-if="isAllowEdit(sampleData, approvalRole)" 
                                class="btn btn-xs btn-primary" 
                                @click="onAddNewResultLine(sampleResult)"
                                :disabled="sampleResult.cannot_get_result_flag && sampleResult.issue_not_found">
                                <span class="fa fa-plus"></span> 
                            </button>
                        </td>
                    </tr>
                </template>
                <tr v-if="(showType == 'result' || showType == 'defect') && isAllowEdit(sampleData, approvalRole)">
                    <td colspan="16">
                        <div
                            class="row justify-content-center clearfix tw-my-4"
                        >
                            <div class="col text-center">
                                <button v-if="showType == 'result'"
                                    type="button"
                                    class="btn btn-md btn-success tw-w-32"
                                    @click="onSubmitSampleResult($event)"
                                >
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button v-if="showType == 'defect'"
                                    type="button"
                                    class="btn btn-md btn-success tw-w-32"
                                    @click="onSubmitCauseOfDefect($event)"
                                >
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-md btn-danger tw-w-32 tw-ml-4"
                                    @click="onCancelSampleResult"
                                >
                                    <i class="fa fa-times"></i> ปิด
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="16">
                        <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SHOW RESULT LINE IMAGES -->
        <!-- <modal-show-result-line-images
            modal-name="modal-show-result-line-images" 
            modal-width="640" 
            modal-height="auto"
            :sample-result-line="showedModalSampleResultLine"
            @onModalResultLineImageChanged="onModalResultLineImageChanged"
        /> -->

        <!-- MODAL SHOW TEST IMAGES -->
        <modal-show-test-images
            modal-name="modal-show-test-images" 
            modal-width="640" 
            modal-height="auto"
            :specifications="specifications"
            :test-id-value="showedModalTestId"
            @onModalTestImageClosed="onModalTestImageClosed"
        />

    </div>

</template>

<script>

// Import loading-overlay component
import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from "moment";

// import ModalShowResultLineImages from "./ModalShowResultLineImages";
import ModalShowTestImages from "./ModalShowTestImages";

export default {

    props: [
        "authUser", 
        "showType", 
        "listBrands", 
        "listTestServerityCodes",
        "approvalData", 
        "approvalRole", 
        "sample", 
        "items", 
        "resultHeaderItems", 
        "resultItems", 
        "resultItemLines", 
        "attachments", 
        "defaultData"
    ],

    components: { Loading, VueNumeric, ModalShowTestImages },

    data() {

        return {
            sampleData: this.sample,
            specifications: this.items.map(item => {
                return {
                    ...item,
                    test_serverity_code: item.test_serverity_code ? (item.test_serverity_code).toUpperCase() : "",
                }
            }),
            sampleResultHeaders: this.resultHeaderItems.map(item => {
                return {
                    ...item,
                    selected_test_id: item.test_id,
                    selected_test_code: item.test_code,
                    selected_test_desc: item.test_desc,
                    selected_test_unit: item.test_unit,
                    selected_test_unit_desc: item.test_unit_desc,
                    // selected_optimal_value: this.getOptimalValue(this.items, item),
                    selected_optimal_value: item.optimal_value,
                    selected_min_value: item.min_value,
                    selected_max_value: item.max_value,
                    result_status: "",
                    severity_level: "",
                    test_serverity_code: "",
                    additional_line_flag: null,
                    uploadedImages: [],
                    result_value: item.test_code == 'RESULT_BY' ? this.authUser.name : item.result_value,
                    images: []
                };
            }).sort((a, b) => {
                return a.seq - b.seq;
            }),

            sampleResults: this.resultItems.map(item => {
                return {
                    qm_process_seq: item.qm_process_seq,
                    qm_process: item.qm_process,
                    sample_qty: item.sample_qty,
                    qc_unit_code: item.qc_unit_code,
                    machine_description: item.machine_description,
                    issue_not_found: this.checkIssueNotFoundValue(item, this.resultItemLines),
                    show_input_issue_not_found: this.checkDisplayInputIssueNotFound(item, this.resultItemLines),
                };
            }).sort((a, b) => {
                return a.qm_process_seq - b.qm_process_seq;
            }),

            sampleResultLines: this.resultItemLines.map(item => {
                return {
                    ...item,
                    check_list_seq: item.check_list_seq,
                    check_list: item.check_list ? item.check_list.trim() : null,
                    selected_test_id: item.test_id,
                    selected_test_code: item.test_code,
                    selected_test_desc: item.test_desc,
                    selected_test_unit: item.test_unit,
                    selected_test_unit_desc: item.test_unit_desc,
                    // selected_optimal_value: this.getOptimalValue(this.items, item),
                    selected_optimal_value: item.optimal_value,
                    selected_min_value: item.min_value,
                    selected_max_value: item.max_value,
                    result_value: item.result_value ? item.result_value : (item.data_type_code == 'N' ? 0 : ""),
                    result_status: this.calResultStatus({
                        ...item, 
                        selected_min_value: item.min_value,
                        selected_max_value: item.max_value,
                        result_value: item.result_value ? item.result_value : (item.data_type_code == 'N' ? 0 : ""), 
                    }),
                    failed_status: this.calFailedStatus({
                        ...item, 
                        selected_min_value: item.min_value,
                        selected_max_value: item.max_value,
                        result_value: item.result_value ? item.result_value : (item.data_type_code == 'N' ? 0 : ""), 
                    }),
                    cause_of_defect: item.cause_of_defect,
                    cannot_get_result_flag: item.cannot_get_result_flag,
                    cannot_get_result_reason: item.cannot_get_result_reason,
                    optimal_result_flag: item.optimal_result_flag,
                    severity_level: this.calSeverityLevel(item),
                    test_serverity_code: item.test_serverity_code ? (item.test_serverity_code).toUpperCase() : null,
                    test_type_code: item.test_type_code ? item.test_type_code : null,
                    test_attachment_id: item.test_attachment_id ? item.test_attachment_id : null,
                    test_image_path: item.test_image_path ? item.test_image_path : null,
                    test_file_name: item.test_file_name ? item.test_file_name : null,
                    additional_line_flag: item.additional_line_flag ? item.additional_line_flag : null,
                    uploadedImages: this.getUplodedImages(item),
                    images: []
                };
            }).filter((value, index, self) => {
                return value.show_header_flag != "Y";
            }).sort((a, b) => {
                return a.check_list_seq - b.check_list_seq;
            }),

            checkListItems: this.items.map(item => {
                return {
                    qm_process: item.qm_process ? item.qm_process.trim() : null,
                    check_list: item.check_list ? item.check_list.trim() : null,
                    check_list_seq: item.check_list_seq ? item.check_list_seq.trim() : null,
                };
            }).filter((value, index, self) => {
                return (
                    index === self.findIndex(t => {
                        return t.qm_process === value.qm_process 
                            && t.check_list === value.check_list
                    })
                );
            }).sort((a, b) => {
                return a.check_list_seq - b.check_list_seq;
            }),

            availableCheckListItems: [],

            checkListTestItems: this.items.map(item => {
                return {
                    qm_process: item.qm_process ? item.qm_process.trim() : null,
                    check_list: item.check_list ? item.check_list.trim() : null,
                    check_list_seq: item.check_list_seq ? item.check_list_seq.trim() : null,
                    result_id: item.result_id,
                    result_line_id: item.result_line_id,
                    test_id: item.test_id,
                    test_code: item.test_code,
                    test_desc: item.test_desc,
                    test_unit: item.test_unit,
                    test_unit_desc: item.test_unit_desc,
                    test_serverity_code: item.test_serverity_code ? (item.test_serverity_code).toUpperCase() : null,
                    // optimal_value: this.getOptimalValue(this.items, item),
                    optimal_value: item.optimal_value,
                    min_value: item.min_value,
                    max_value: item.max_value,
                };
            }).filter((value, index, self) => {
                return (
                    index === self.findIndex(t => {
                        return t.qm_process === value.qm_process 
                            && t.check_list === value.check_list 
                            && t.test_id === value.test_id
                    })
                );
            }).sort((a, b) => {
                return a.check_list_seq - b.check_list_seq;
            }),

            availableCheckListTestItems: [],

            // showedModalSampleResultLine: null,
            showedModalTestId: null,
            // isCannotGetResult: false,
            isLoading: false

        };
    },

    mounted() {

        // SET DEFAULT TEST_SEVERITY_CODE
        this.sampleResultLines.forEach(async (item, i) => {
            const testItem = this.checkListTestItems.find((clt) => { return clt.check_list == item.check_list && clt.test_id == item.test_id; });
            const testServerityCode = testItem ? testItem.test_serverity_code.toUpperCase() : "";
            item.test_serverity_code = item.test_serverity_code ? (item.test_serverity_code).toUpperCase() : testServerityCode;
            this.calResultStatus(item);
            this.calFailedStatus(item);
            this.calSeverityLevel(item);
        });

        const foundCannotGetResultFlag = this.sampleResultLines.find(item => item.cannot_get_result_flag == true);
        // this.isCannotGetResult = foundCannotGetResultFlag ? true : false;

        // SET AVAILABLE_CHECK_LIST_ITEMS 
        this.availableCheckListItems = this.getAvailableCheckListItems(this.checkListItems);
        // SET AVAILABLE_CHECK_LIST_TEST_ITEMS 
        this.availableCheckListTestItems = this.getAvailableCheckListTestItems(this.checkListTestItems);

    },

    methods: {

        getTestData(item) {

            const foundResultItem = this.resultItems.find(i => i.test_id == item.test_id);
            const testData = {
                test_id: foundResultItem ? foundResultItem.test_id : "",
                test_code: foundResultItem ? foundResultItem.test_code : "",
                test_desc: foundResultItem ? foundResultItem.test_desc : "",
                test_unit: foundResultItem ? foundResultItem.test_unit : "",
                // optimal_value: foundResultItem ? this.getOptimalValue(this.specifications, foundResultItem) : "",
                optimal_value: foundResultItem ? foundResultItem.optimal_value : "",
                min_value: foundResultItem ? foundResultItem.min_value : "",
                max_value: foundResultItem ? foundResultItem.max_value : "",
            };
            return testData;

        },

        getUplodedImages(item) {

            // REMINDER : PT_ATTACHMENTS.ATTRIBUTE2 == PTQM_RESULTS_V.RESULT_ID
            const uploadedImages = this.attachments.filter(i => i.attribute2 == item.result_id);
            return uploadedImages;

        },

        getOptimalValue(specifications, item) {
            const foundResultItem = specifications.find(spec => spec.spec_id == item.spec_id && spec.test_id == item.test_id);
            const optimalValue = foundResultItem ? foundResultItem.optimal_value : "";
            return optimalValue;
        },
        

        getBrandLabel(resultValue) {
            let result = "";
            if(resultValue) {
                const foundBrand = this.listBrands.find(item => item.brand_value == resultValue);
                result = foundBrand ? foundBrand.brand_label : ""
            }
            return result;
        },

        isAllowEdit(sample, approvalRole) {
            
            let allowed = false;
            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "1") { // Operator
                    if(sample.approval_status_code == "10") { // Pending : Operator Approval 
                        allowed = true;
                    }
                }
            }
            return allowed;
            
        },

        onResultValueChanged($event, sampleResult, sampleResultLine) {
            
            this.calResultStatus(sampleResultLine);
            this.calSeverityLevel(sampleResultLine);
            // this.calTestSeverityCode(sampleResultLine);
            
            if(sampleResultLine.result_value != "0"){ 
                sampleResult.issue_not_found = false;
            }
            sampleResult.show_input_issue_not_found = this.checkDisplayInputIssueNotFound(sampleResult, this.sampleResultLines);
            
            // AUTO SET RESULT_VALUE TO "SAME-ENTITY" RESULT LINE
            this.$nextTick(() => {

                const sameCheckListResultLines = this.sampleResultLines.filter(srl => {
                    return srl.qm_process == sampleResultLine.qm_process && srl.check_list == sampleResultLine.check_list && srl.test_id != sampleResultLine.test_id;
                });
                sameCheckListResultLines.forEach(async (item, i) => {
                    if(item.result_value === "" || item.result_value === null) {
                        item.result_value = "0";
                        this.calResultStatus(item);
                        this.calSeverityLevel(item);
                    }
                });
                
            });

        },

        checkDisplayInputIssueNotFound(sampleResult, sampleResultLines) {
            
            // let displayed = false;
            let displayed = true;
            const filteredSampleResultLines = sampleResultLines.filter(srl => {
                return sampleResult.qm_process == srl.qm_process;
            });
            const foundCannotGetResult = filteredSampleResultLines.find(fsrl => {
                return fsrl.cannot_get_result_flag == true
            });
            if(foundCannotGetResult){
                displayed = false;
            }
            // const foundEnterredResultValue = filteredSampleResultLines.find(fsrl => {
            //     return fsrl.result_value != null && fsrl.result_value != ""
            // });
            // if(!foundEnterredResultValue){
            //     displayed = true;
            // }
            return displayed;

        },

        checkIssueNotFoundValue(sampleResult, sampleResultLines) {

            const filteredSampleResultLines = sampleResultLines.filter(srl => {
                return srl.qm_process == sampleResult.qm_process;
            });
            const zeroValueSampleResultLines = filteredSampleResultLines.filter(fsrl => {
                return fsrl.result_value == "0";
            });

            const issueNotFound = filteredSampleResultLines.length == zeroValueSampleResultLines.length ? true : false;
            return issueNotFound;

        },

        calSeverityLevel(item) {

            let severityLevel = "";

            if(item.result_value) {

                severityLevel = "NONE";

                if(item.high_level_minor) {
                    if(parseFloat(item.result_value) >= parseFloat(item.high_level_minor)){
                        severityLevel = "MINOR";
                    }
                }

                if(item.high_level_major) {
                    if(parseFloat(item.result_value) >= parseFloat(item.high_level_major)){
                        severityLevel = "MAJOR";
                    }
                }

                if(item.high_level_critical) {
                    if(parseFloat(item.result_value) >= parseFloat(item.high_level_critical)){
                        severityLevel = "CRITICAL";
                    }
                }
            }

            item.severity_level = severityLevel;

            return severityLevel;

        },

        calResultStatus(item) {

            let resultStatus = "";
            if(item.selected_min_value && item.selected_max_value && (item.result_value !== "" && item.result_value !== null)) {
                if(parseFloat(item.result_value) >= parseFloat(item.selected_min_value) 
                && parseFloat(item.result_value) <= parseFloat(item.selected_max_value)) {
                    resultStatus = "PASSED";
                } else {
                    resultStatus = "FAILED";
                }
                this.calFailedStatus(item);
            }
            item.result_status = resultStatus;
            
            return resultStatus;

        },

        calFailedStatus(item) {
            let failedStatus = "";
            if(item.selected_min_value && item.selected_max_value && (item.result_value !== "" && item.result_value !== null)) {
                if(parseFloat(item.result_value) < parseFloat(item.selected_min_value)) {
                    failedStatus = "UNDER";
                }
                if(parseFloat(item.result_value) > parseFloat(item.selected_max_value)) {
                    failedStatus = "OVER";
                }
            }
            item.failed_status = failedStatus;
            return failedStatus;
        },

        // calTestSeverityCode(item) {
        //     const testItem = this.checkListTestItems.find((clt) => {
        //         return clt.check_list == item.check_list && clt.test_id == item.test_id;
        //     });
        //     const testServerityCode = testItem ? testItem.test_serverity_code.toUpperCase() : "";
        //     item.test_serverity_code = testServerityCode;
        //     return testServerityCode;
        // },

        // GET AVAILABLE_CHECK_LIST_ITEMS 
        getAvailableCheckListItems(checkListItems) {

            // let availableItems = checkListItems;

            const availableItems = checkListItems.filter(item => {
                const foundSampleResultLine = this.sampleResultLines.find(srl => {
                    return srl.qm_process == item.qm_process && srl.check_list == item.check_list && srl.optimal_result_flag == true;
                });
                return !foundSampleResultLine;
            });

            return availableItems;

        },

        // GET AVAILABLE_CHECK_LIST_TEST_ITEMS 
        getAvailableCheckListTestItems(checkListTestItems) {

            // let availableItems = checkListTestItems;

            const availableItems = checkListTestItems.filter(item => {
                const foundSampleResultLine = this.sampleResultLines.find(srl => {
                    return srl.qm_process == item.qm_process && srl.check_list == item.check_list && srl.optimal_result_flag == true;
                });
                return !foundSampleResultLine;
            });

            return availableItems;

        },

        onHeaderResultChanged(resultValue, sampleResultHeader) {
            sampleResultHeader.result_value = resultValue;
        },

        onIssueNotFouldCheckBoxChanged(value, sampleResult) {

            sampleResult.issue_not_found = value;
            if(value == true) {
                const filteredSampleResultLines = this.sampleResultLines.filter(srl => {
                    return srl.qm_process == sampleResult.qm_process;
                });
                filteredSampleResultLines.forEach(item => {
                    this.setOptimalResultLine(true, item)
                    this.calResultStatus(item);
                    this.calSeverityLevel(item);
                    // this.calTestSeverityCode(item);
                });
            }

            // SET AVAILABLE_CHECK_LIST_ITEMS 
            this.availableCheckListItems = this.getAvailableCheckListItems(this.checkListItems);
            // SET AVAILABLE_CHECK_LIST_TEST_ITEMS 
            this.availableCheckListTestItems = this.getAvailableCheckListTestItems(this.checkListTestItems);

        },

        onOptimalResultCheckBoxChanged(value, sampleResultLine) {

            const optimalResultFlag = value;

            this.setOptimalResultLine(optimalResultFlag, sampleResultLine);

            let cannotGetResultFlag = null;
            let cannotGetResultReason = null;
            let resultValue = null;

            if(optimalResultFlag == true) {
                cannotGetResultFlag = false;
                cannotGetResultReason = "";
                resultValue = "0";
            }

            // AUTO SET OPTIMAL_RESULT_FLAG VALUE TO "SAME-ENTITY" RESULT LINE
            const sameCheckListResultLines = this.sampleResultLines.filter(srl => {
                return srl.qm_process == sampleResultLine.qm_process && srl.check_list == sampleResultLine.check_list;
            });
            sameCheckListResultLines.forEach(async (item, i) => {
                item.optimal_result_flag = optimalResultFlag;
                item.cannot_get_result_flag = cannotGetResultFlag !== null ? cannotGetResultFlag : item.cannot_get_result_flag;
                item.cannot_get_result_reason = cannotGetResultReason !== null ? cannotGetResultReason : item.cannot_get_result_reason;
                item.result_value = (resultValue !== null || resultValue !== '') ? resultValue : item.result_value;
                this.calResultStatus(item);
                this.calSeverityLevel(item);
                // this.calTestSeverityCode(item);
            });

            // SET AVAILABLE_CHECK_LIST_ITEMS 
            this.availableCheckListItems = this.getAvailableCheckListItems(this.checkListItems);
            // SET AVAILABLE_CHECK_LIST_TEST_ITEMS 
            this.availableCheckListTestItems = this.getAvailableCheckListTestItems(this.checkListTestItems);

        },

        setOptimalResultLine(optimalResultFlag, sampleResultLine) {

            let cannotGetResultFlag = null;
            let cannotGetResultReason = null;
            let resultValue = null;

            if(optimalResultFlag == true) {
                cannotGetResultFlag = false;
                cannotGetResultReason = "";
                resultValue = "0";
            }

            sampleResultLine.optimal_result_flag = optimalResultFlag;
            sampleResultLine.cannot_get_result_flag = cannotGetResultFlag !== null ? cannotGetResultFlag : sampleResultLine.cannot_get_result_flag;
            sampleResultLine.cannot_get_result_reason = cannotGetResultReason !== null ? cannotGetResultReason : sampleResultLine.cannot_get_result_reason;
            sampleResultLine.result_value = (resultValue !== null || resultValue !== '') ? resultValue : sampleResultLine.result_value;
            this.calResultStatus(sampleResultLine);
            this.calSeverityLevel(sampleResultLine);

        },

        onCannotGetResultCheckBoxChanged(cannotGetResultFlag, sampleResult, sampleResultLine) {

            let cannotGetResultReason = null;
            let optimalResultFlag = null;
            let resultValue = null;

            // this.isCannotGetResult = cannotGetResultFlag;

            if(cannotGetResultFlag == true) {
                optimalResultFlag = false;
                resultValue = "0";
            } else {
                cannotGetResultReason = "";
            }

            // AUTO SET SAME QM_PROCESS
            const filteredSampleResultLines = this.sampleResultLines.filter(srl => {
                return srl.qm_process == sampleResultLine.qm_process;
            });
            // this.sampleResultLines.forEach(async (item, i) => {
            filteredSampleResultLines.forEach(async (item, i) => {
                item.cannot_get_result_flag = cannotGetResultFlag;
                item.cannot_get_result_reason = cannotGetResultReason !== null ? cannotGetResultReason : item.cannot_get_result_reason;
                item.optimal_result_flag = optimalResultFlag !== null ? optimalResultFlag : item.optimal_result_flag;
                item.result_value = (resultValue !== null || resultValue !== '') ? resultValue : item.result_value;
                this.calResultStatus(item);
                this.calSeverityLevel(item);
                // this.calTestSeverityCode(item);
            });

            sampleResult.show_input_issue_not_found = this.checkDisplayInputIssueNotFound(sampleResult, filteredSampleResultLines);

        },

        onCannotGetResultReasonChanged(e, sampleResultLine) {

            const cannotGetResultReason = sampleResultLine.cannot_get_result_reason;

            // AUTO SET SAME QM_PROCESS
            const filteredSampleResultLines = this.sampleResultLines.filter(srl => {
                return srl.qm_process == sampleResultLine.qm_process;
            });
            // this.sampleResultLines.forEach(async (item, i) => {
            filteredSampleResultLines.forEach(async (item, i) => {
                item.cannot_get_result_reason = cannotGetResultReason;
            });

        },

        onSelectedCheckListItem(selectedCheckList, sampleResultLine) {

            // const checkListItem = this.checkListItems.find((cl) => {
            //     return cl.qm_process == sampleResultLine.qm_process && cl.check_list == selectedCheckList;
            // });
            sampleResultLine.check_list = selectedCheckList;
            const defaultTestItem = this.checkListTestItems.find((clt) => {
                return clt.qm_process == sampleResultLine.qm_process && clt.check_list == selectedCheckList;
            });
            this.onSelectedCheckListTestItem(defaultTestItem.test_id, sampleResultLine)

        },

        onSelectedCheckListTestItem(selectedTestId, sampleResultLine) {

            const testItem = this.checkListTestItems.find((clt) => {
                return clt.check_list == sampleResultLine.check_list && clt.test_id == selectedTestId;
            });

            sampleResultLine.result_id = testItem.result_id;
            sampleResultLine.result_line_id = testItem.result_line_id;
            sampleResultLine.selected_test_id = testItem.test_id;
            sampleResultLine.selected_test_code = testItem.test_code;
            sampleResultLine.selected_test_desc = testItem.test_desc;
            // sampleResultLine.selected_optimal_value = this.getOptimalValue(this.specifications, testItem);
            sampleResultLine.selected_optimal_value = testItem.optimal_value;
            sampleResultLine.selected_min_value = testItem.min_value;
            sampleResultLine.selected_max_value = testItem.max_value;
            sampleResultLine.test_serverity_code = testItem.test_serverity_code ? testItem.test_serverity_code.toUpperCase() : "";;

            this.calResultStatus(sampleResultLine);
            this.calSeverityLevel(sampleResultLine);
            // this.calTestSeverityCode(sampleResultLine);

        },

        onSelectedTestServerityCode(value, sampleResultLine) {

            // UPDATE TEST_SERVERITY_CODE VALUE
            sampleResultLine.test_serverity_code = value;

        },

        onAddNewResultLine(sampleResult) {

            sampleResult.issue_not_found = false;

            const cloneSampleResultLine = {
                ...(this.sampleResultLines.find(srl => {
                    return srl.qm_process == sampleResult.qm_process;
                }))
            };

            const defaultCheckListItem = this.availableCheckListItems.find((cl) => {
                return cl.qm_process == sampleResult.qm_process;
            });
            cloneSampleResultLine.check_list = defaultCheckListItem ? defaultCheckListItem.check_list : null;
            cloneSampleResultLine.check_list_code = defaultCheckListItem ? defaultCheckListItem.check_list_code : null;
            cloneSampleResultLine.additional_line_flag = "Y";
            cloneSampleResultLine.result_value = "";
            cloneSampleResultLine.result_status = null;
            cloneSampleResultLine.severity_level = "";
            cloneSampleResultLine.test_serverity_code = "";
            cloneSampleResultLine.optimal_result_flag = false;
            cloneSampleResultLine.cannot_get_result_flag = false;
            cloneSampleResultLine.cannot_get_result_reason = "";
            cloneSampleResultLine.uploadedImages = [];
            cloneSampleResultLine.images = [];

            const defaultTestItem = this.availableCheckListTestItems.find((clt) => {
                return clt.qm_process == sampleResult.qm_process 
                    && clt.check_list == cloneSampleResultLine.check_list 
                    && clt.test_id != cloneSampleResultLine.selected_test_id;
            });
            cloneSampleResultLine.result_id = defaultTestItem ? defaultTestItem.result_id : null;
            cloneSampleResultLine.result_line_id = defaultTestItem ? defaultTestItem.result_line_id : null;
            cloneSampleResultLine.selected_test_id = defaultTestItem ? defaultTestItem.test_id : null;
            cloneSampleResultLine.selected_test_code = defaultTestItem ? defaultTestItem.test_code : null;
            cloneSampleResultLine.selected_test_desc = defaultTestItem ? defaultTestItem.test_desc : null;
            cloneSampleResultLine.selected_test_unit = defaultTestItem ? defaultTestItem.test_unit : null;
            cloneSampleResultLine.selected_test_unit_desc = defaultTestItem ? defaultTestItem.test_unit_desc : null;
            // cloneSampleResultLine.selected_optimal_value = defaultTestItem ? this.getOptimalValue(this.specifications, defaultTestItem) : null;
            cloneSampleResultLine.selected_optimal_value = defaultTestItem ? defaultTestItem.optimal_value : null;
            cloneSampleResultLine.selected_min_value = defaultTestItem ? defaultTestItem.min_value : null;
            cloneSampleResultLine.selected_max_value = defaultTestItem ? defaultTestItem.max_value : null;

            this.sampleResultLines.push(cloneSampleResultLine);
            
        },

        onRemoveResultLine(sampleResultLine) {
            const sampleResultLineIndex = this.sampleResultLines.findIndex(item => item == sampleResultLine);
            if(sampleResultLineIndex > 0) {
                this.sampleResultLines.splice(sampleResultLineIndex, 1);
            }
        },

        validateBeforeChooseImages(sampleResultLine, index, lineIndex) {

            const refName = `finished_products_result_quality_line_image_${index}_${lineIndex}`;

            if(sampleResultLine.result_status == "PASSED") {
                swal({
                    title: "",
                    text: "ค่าที่ตรวจสอบอยู่ในเกณฑ์มาตรฐาน ต้องการที่จะแนบรูปภาพใช่หรือไม่ ?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                }, (isConfirm) => {
                    if (isConfirm) {
                        this.$refs[refName][0].click();
                    }
                });
            } else {
                this.$refs[refName][0].click();
            }

        },

        validateImages(event, sampleResultLine) {

            // const uploadMaxFiles = this.defaultData.upload_max_files;
            const uploadMaxFiles = 1;
            const uploadMaxFileSizeMB = this.defaultData.upload_max_file_size;
            const uploadMaxFileSize = uploadMaxFileSizeMB * 1024 * 1024
            const files = [...event.target.files];

            // VALIDATE FILE SIZE
            const validSizeFiles = files.filter(file => {
                return file.size < uploadMaxFileSize;
            });
            if(validSizeFiles.length < files.length) {
                swal("Error", `สามารถแนบรูป ได้ขนาดไม่เกิน ${uploadMaxFileSizeMB} MB, กรุณาอัพโหลดใหม่อีกครั้ง`, "error");
            } else {

                // VALIDATE MAX FILES
                if (files.length > uploadMaxFiles) {
                    swal("Error", `สามารถแนบรูป ได้ไม่เกิน ${uploadMaxFiles} รูป`, "error");
                    sampleResultLine.images = files.slice(0, uploadMaxFiles);
                } else {
                    sampleResultLine.images = files;
                }

            }

        },


        onDeleteResultLineImage(sampleResultLine, imageIndex) {

            sampleResultLine.images.splice(imageIndex, 1);

        },

        async onSubmitSampleResult(event) {
            
            let vm = this;

            // VALIDATE BEFORE SUBMIT RESULT
            const resValidate = this.validateBeforeSave(this.sampleData, this.sampleResultHeaders, this.sampleResultLines);
            if(resValidate.valid) {

                const reqData = new FormData();
                reqData.append('organization_code', this.sampleData.organization_code ? this.sampleData.organization_code : "");
                reqData.append('oracle_sample_id', this.sampleData.oracle_sample_id ? this.sampleData.oracle_sample_id : "");
                reqData.append('sample_no', this.sampleData.sample_no ? this.sampleData.sample_no : "");
                reqData.append('sample_desc', this.sampleData.sample_desc ? this.sampleData.sample_desc : "");
                reqData.append('inventory_item_id', this.sampleData.inventory_item_id ? this.sampleData.inventory_item_id : "");
                reqData.append('item_number', this.sampleData.item_number ? this.sampleData.item_number : "");
                reqData.append('item_desc', this.sampleData.item_desc ? this.sampleData.item_desc : "");
                reqData.append('date_drawn', this.sampleData.date_drawn ? this.sampleData.date_drawn : "");
                reqData.append('sample_disposition', this.sampleData.sample_disposition ? this.sampleData.sample_disposition : "");
                reqData.append('sample_disposition_desc', this.sampleData.sample_disposition_desc ? this.sampleData.sample_disposition_desc : "");
                reqData.append('sample_operation_status', this.sampleData.sample_operation_status ? this.sampleData.sample_operation_status : "");
                reqData.append('sample_result_status', this.sampleData.sample_result_status ? this.sampleData.sample_result_status : "");
                reqData.append('sample_id', this.sampleData.sample_id ? this.sampleData.sample_id : "");
                reqData.append('department_code', this.sampleData.department_code ? this.sampleData.department_code : "");
                reqData.append('qm_group', this.sampleData.qm_group ? this.sampleData.qm_group : "");
                reqData.append('organization_id', this.sampleData.organization_id ? this.sampleData.organization_id : "");
                reqData.append('subinventory_code', this.sampleData.subinventory_code ? this.sampleData.subinventory_code : "");
                reqData.append('locator_id', this.sampleData.locator_id ? this.sampleData.locator_id : "");
                reqData.append('sample_date', this.sampleData.sample_date ? this.sampleData.sample_date : "");
                reqData.append('batch_id', this.sampleData.batch_id ? this.sampleData.batch_id : "");
                reqData.append('qc_area', this.sampleData.qc_area ? this.sampleData.qc_area : "");
                reqData.append('machine_set', this.sampleData.machine_set ? this.sampleData.machine_set : "");
                reqData.append('program_code', this.sampleData.program_code ? this.sampleData.program_code : "");
                
                const allSampleResults = [
                    ...this.sampleResultHeaders,
                    ...this.sampleResultLines
                ];

                // const resultQualityLines = this.sampleResultLines.map((item, srlIndex) => {
                const resultQualityLines = allSampleResults.map((item, srlIndex) => {
                    const result = {
                        result_id: item.result_id,
                        qm_process: item.qm_process,
                        check_list: item.check_list,
                        check_list_code: item.check_list_code,
                        test_id: item.selected_test_id,
                        test_code: item.selected_test_code,
                        test_desc: item.selected_test_desc,
                        optimal_value: item.selected_optimal_value,
                        min_value: item.selected_min_value,
                        max_value: item.selected_max_value,
                        result_status: item.result_status,
                        result_value: item.result_value,
                        cause_of_defect: item.cause_of_defect ? item.cause_of_defect : "",
                        cannot_get_result_flag: item.cannot_get_result_flag == true ? "Y" : "N",
                        cannot_get_result_reason: item.cannot_get_result_reason ? item.cannot_get_result_reason : "",
                        optimal_result_flag: item.optimal_result_flag == true ? "Y" : "N",
                        test_serverity_code: item.test_serverity_code ? item.test_serverity_code : "",
                        show_header_flag: item.show_header_flag,
                        additional_line_flag: item.additional_line_flag ? item.additional_line_flag : null,
                        images: "",
                    }
                    if(item.images.length > 0) {
                        result.images = item.images.map((image, imgIndex) => {
                            reqData.append(`image_${srlIndex}_${imgIndex}`, image);
                            return `image_${srlIndex}_${imgIndex}`;
                        });
                    }
                    return result;
                });
                reqData.append('result_quality_lines', JSON.stringify(resultQualityLines));

                // SHOW LOADING
                this.isLoading = true;

                // CALL STORE SAMPLE RESULT
                let resStoreSampleResultStatus = "success";
                let resSampleDisposition = this.sampleData.sample_disposition;
                let resSampleDispositionDesc = this.sampleData.sample_disposition_desc;
                let resSampleOperationStatus = this.sampleData.sample_operation_status;
                let resSampleOperationStatusDesc = this.sampleData.sample_operation_status_desc;
                let resSampleResultStatus = this.sampleData.sample_result_status;
                let resSampleResultStatusDesc = this.sampleData.sample_result_status_desc;
                let resSampleSeverityLevelMinor = this.sampleData.severity_level_minor;
                let resSampleSeverityLevelMajor = this.sampleData.severity_level_major;
                let resSampleSeverityLevelCritical = this.sampleData.severity_level_critical;
                let resSampleTestServerityCodeMinor = this.sampleData.test_serverity_code_minor;
                let resSampleTestServerityCodeMajor = this.sampleData.test_serverity_code_major;
                let resSampleTestServerityCodeCritical = this.sampleData.test_serverity_code_critical;
                let resSampleResultTestTime = this.sampleData.sample_result_test_time;
                await axios.post(`/qm/ajax/finished-products/result`, reqData)
                .then((res) => {

                    const resData = res.data.data;
                    const resMsg = resData.message;
                    const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                    resStoreSampleResultStatus = resData.status;
                    if(resSample){ 
                        resSampleDisposition = resSample.sample_disposition; 
                        resSampleDispositionDesc = resSample.sample_disposition_desc; 
                        resSampleOperationStatus = resSample.sample_operation_status; 
                        resSampleOperationStatusDesc = resSample.sample_operation_status_desc; 
                        resSampleResultStatus = resSample.sample_result_status; 
                        resSampleResultStatusDesc = resSample.sample_result_status_desc; 
                        resSampleSeverityLevelMinor = resSample.severity_level_minor;
                        resSampleSeverityLevelMajor = resSample.severity_level_major;
                        resSampleSeverityLevelCritical = resSample.severity_level_critical;
                        resSampleTestServerityCodeMinor = resSample.test_serverity_code_minor;
                        resSampleTestServerityCodeMajor = resSample.test_serverity_code_major;
                        resSampleTestServerityCodeCritical = resSample.test_serverity_code_critical;
                        resSampleResultTestTime = resSample.sample_result_test_time;
                    }

                    if(resData.status == "success") {
                        swal("Success", `บันทึกลงผลการตรวจสอบคุณภาพกลุ่มผลิตภัณฑ์สำเร็จรูป (เลขที่การตรวจสอบ	: ${vm.sampleData.sample_no} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("Error", `บันทึกลงผลการตรวจสอบคุณภาพกลุ่มผลิตภัณฑ์สำเร็จรูป (เลขที่การตรวจสอบ	: ${vm.sampleData.sample_no}) | ${resMsg}`, "error");
                    }
                    
                    return resData;

                })
                .catch((error) => {
                    console.log(error);
                    resStoreSampleResultStatus = "error";
                    swal("Error", `บันทึกลงผลการตรวจสอบคุณภาพกลุ่มผลิตภัณฑ์สำเร็จรูป (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${error.message}`, "error");
                });

                // HIDE LOADING
                this.isLoading = false;

                // emit sample result sumitted
                this.$emit("onSampleResultSubmitted", {
                    status: resStoreSampleResultStatus,
                    sample_no: this.sampleData.sample_no,
                    sample_disposition: resSampleDisposition,
                    sample_disposition_desc: resSampleDispositionDesc,
                    sample_operation_status: resSampleOperationStatus,
                    sample_operation_status_desc: resSampleOperationStatusDesc,
                    sample_result_status: resSampleResultStatus,
                    sample_result_status_desc: resSampleResultStatusDesc,
                    severity_level_minor: resSampleSeverityLevelMinor,
                    severity_level_major: resSampleSeverityLevelMajor,
                    severity_level_critical: resSampleSeverityLevelCritical,
                    test_serverity_code_minor: resSampleTestServerityCodeMinor,
                    test_serverity_code_major: resSampleTestServerityCodeMajor,
                    test_serverity_code_critical: resSampleTestServerityCodeCritical,
                    sample_result_test_time: resSampleResultTestTime,
                });

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

        },

        validateBeforeSave(sampleData, sampleResultHeaders, sampleResultLines) {

            const result = {
                valid: true,
                message: "",
            };

            // ####################################################
            // ## VALIDATION OF SAMPLE_RESULT_HEADERS INCOMPLETED

            // HEADER : BRAND
            const sampleResultHeaderBrand = sampleResultHeaders.find(item => item.brand_flag == 'Y');
            if(sampleResultHeaderBrand) {
                if(!sampleResultHeaderBrand.result_value) {
                    result.valid = false;
                    result.message = `กรุณากรอกข้อมูล "${sampleResultHeaderBrand.selected_test_desc}"`
                    return result;
                }
            }

            // HEADER : TEST_TIME
            const sampleResultHeaderTestTime = sampleResultHeaders.find(item => item.test.time_flag == 'Y');
            if(sampleResultHeaderTestTime) {
                if(!sampleResultHeaderTestTime.result_value) {
                    result.valid = false;
                    result.message = `กรุณากรอกข้อมูล "${sampleResultHeaderTestTime.selected_test_desc}"`
                    return result;
                } else {
                    if(!moment(sampleResultHeaderTestTime.result_value, "HH:mm", true).isValid()) {
                        result.valid = false;
                        result.message = `ข้อมูล "${sampleResultHeaderTestTime.selected_test_desc}" ไม่ถูกต้อง กรุณาตรวจสอบ`
                        return result;
                    }
                }

            }

            // ####################################################

            // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE INCOMPLETED
            const incompletedResultValueLines = sampleResultLines.filter(item => {
                return !item.check_list || !item.test_id || (item.result_value === "" || item.result_value === null);
            });

            if(incompletedResultValueLines.length > 0) {
                result.valid = false;
                result.message = `กรุณากรอกข้อมูล "ผลการตรวจสอบ" ให้ครบถ้วน`
                return result;
            } else {

                // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE == 0 BUT OPTIMAL_FLAG IS NOT CHECKED
                const invalidOptimalResultValueLines = sampleResultLines.filter(item => {
                    return parseInt(item.result_value) === 0 && item.optimal_result_flag === false;
                });

                if(invalidOptimalResultValueLines.length > 0) {
                    result.valid = false;
                    result.message = `ผลการตรวจสอบ "${invalidOptimalResultValueLines[0].qm_process} : ${invalidOptimalResultValueLines[0].check_list} : ${invalidOptimalResultValueLines[0].selected_test_desc}" พบข้อบกพร่องเป็น 0, กรุณาติ๊ก Check Box "ผลปกติ" ก่อนบันทึกข้อมูล`
                    return result;
                }

            }

            // IF THERE SAMPLE_RESULT_LINES : CANNOT_GET_RESULT_FLAG & CANNOT_GET_RESULT_REASON INCOMPLETED
            const incompletedCannotGetResultLines = sampleResultLines.filter(item => {
                return item.cannot_get_result_flag == true && !item.cannot_get_result_reason;
            });

            // IF THERE DUPPLICATE TEST_ID
            const sampleResultLineTestIds = sampleResultLines.map(item => item.selected_test_id);
            const dupplicateResultLineTestIds = sampleResultLineTestIds.filter((item, index) => {
                return index !== sampleResultLineTestIds.indexOf(item);
            });

            if(incompletedCannotGetResultLines.length > 0) {
                result.valid = false;
                result.message = `กรุณากรอกข้อมูล "เหตุผลที่ไม่สามารถเก็บข้อมูลได้" ให้ครบถ้วน`
                return result;
            }

            if(dupplicateResultLineTestIds.length > 0) {
                result.valid = false;
                result.message = `พบข้อมูล "การตรวจสอบ/ความผิดปกติ" ซ้ำ กรุณาตรวจสอบอีกครั้ง`
                return result;
            }

            return result;

        },

        async onSubmitCauseOfDefect(event) {

            let vm = this;

            const reqData = new FormData();
            reqData.append('organization_code', this.sampleData.organization_code ? this.sampleData.organization_code : "");
            reqData.append('oracle_sample_id', this.sampleData.oracle_sample_id ? this.sampleData.oracle_sample_id : "");
            reqData.append('sample_no', this.sampleData.sample_no ? this.sampleData.sample_no : "");
            
            const allSampleResults = [
                ...this.sampleResultHeaders,
                ...this.sampleResultLines
            ];

            // const resultQualityLines = this.sampleResultLines.map((item, srlIndex) => {
            const resultQualityLines = allSampleResults.map((item, srlIndex) => {
                const result = {
                    result_id: item.result_id,
                    test_id: item.selected_test_id,
                    test_code: item.selected_test_code,
                    test_desc: item.selected_test_desc,
                    optimal_value: item.selected_optimal_value,
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : "",
                }
                return result;
            });
            reqData.append('result_quality_lines', JSON.stringify(resultQualityLines));

            // SHOW LOADING
            this.isLoading = true;

            // call store cause of defect
            let resStoreCauseOfDefectStatus = "success";
            await axios.post(`/qm/ajax/finished-products/defect`, reqData)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                resStoreCauseOfDefectStatus = resData.status;

                if(resData.status == "success") {
                    swal("Success", `บันทึกสาเหตุความผิดปกติกลุ่มผลิตภัณฑ์สำเร็จรูป (เลขที่การตรวจสอบ	: ${vm.sampleData.sample_no} )`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `บันทึกสาเหตุความผิดปกติกลุ่มผลิตภัณฑ์สำเร็จรูป (เลขที่การตรวจสอบ	: ${vm.sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreCauseOfDefectStatus = "error";
                swal("Error", `บันทึกสาเหตุความผิดปกติกลุ่มผลิตภัณฑ์สำเร็จรูป (เลขที่การตรวจสอบ	: ${this.sampleData.sample_no}) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            // emit cause of defect sumitted
            // this.$emit("onCauseOfDefectSubmitted", {
            //     status: resStoreCauseOfDefectStatus,
            //     sample_no: this.sampleData.sample_no,
            // });

        },

        async onDeleteResultLineUplodedImage(sampleResultLine, imageIndex) {

            const uploadedImage = {
                ...sampleResultLine.uploadedImages[imageIndex]
            }

            swal({
                title: "",
                text: "ต้องการที่จะลบรูปภาพใช่หรือไม่ ?",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, async (isConfirm) => {
                if (isConfirm) {
                    const responseResult = await this.deleteResultLineUplodedImage(sampleResultLine, uploadedImage);
                    if(responseResult.status == "success") {
                        sampleResultLine.uploadedImages.splice(imageIndex, 1);
                    }
                }
            });

        },

        async deleteResultLineUplodedImage(sampleResultLine, uploadedImage) {

            const reqBody = {
                sample_result_line: JSON.stringify(sampleResultLine),
                uploaded_image: JSON.stringify(uploadedImage),
            };

            // SHOW LOADING
            this.isLoading = true;

            const responseResult = await axios.post(`/qm/ajax/finished-products/delete-result-quality-line-image`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("Success", `ลบรูปภาพ: ${uploadedImage.attribute1}`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ลบรูปภาพ: ${uploadedImage.attribute1} | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                swal("Error", `ไม่สามารถ ลบรูปภาพ: ${uploadedImage.attribute1} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            return responseResult;

        },

        onCancelSampleResult(e){
            // emit sample result sumitted
            this.$emit("onCancelSampleResult", e);
        },

        // onShowModalSampleResultLineImages(sampleResultLine) {
        //     this.showedModalSampleResultLine = sampleResultLine;
        //     window.scrollTo(0,150);
        //     this.$modal.show('modal-show-result-line-images');
        // },

        onShowModalTestImages(sampleResultLine) {
            this.showedModalTestId = sampleResultLine.selected_test_id;
            window.scrollTo(0,150);
            this.$modal.show('modal-show-test-images');
        },

        onModalTestImageClosed() {
            window.scrollTo(0, 800);
        },

        async onModalResultLineImageChanged(data) { 

            const changedSampleResultLine = data.sampleResultLine;

            this.sampleResultLines = this.sampleResultLines.map(item => {
                let sampleResultLineUploadedImages = [];
                if( changedSampleResultLine.result_line_id == item.result_line_id && changedSampleResultLine.selected_test_id == item.selected_test_id) {
                    sampleResultLineUploadedImages = changedSampleResultLine.uploadedImages;
                } else {
                    sampleResultLineUploadedImages = item.uploadedImages;
                }
                return {
                    ...item,
                    uploadedImages: sampleResultLineUploadedImages
                }
            });
            
        }

    }
};
</script>
