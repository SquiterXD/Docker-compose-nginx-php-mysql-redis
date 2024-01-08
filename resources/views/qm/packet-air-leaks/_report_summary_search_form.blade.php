<div class="row form-group">

    <div class="col-md-4">

        <div class="row">

            <qm-input-search-machine-name-by-qc-area :qc-areas="{{ json_encode($qcAreas) }}" qc-area-value="{{ old('qc_area') ? old('qc_area') : (isset($searchInputs['qc_area']) ? $searchInputs['qc_area'] : '') }}" 
                :machines="{{ json_encode($machines) }}" machine-value="{{ old('machine_name') ? old('machine_name') : (isset($searchInputs['machine_name']) ? $searchInputs['machine_name'] : '') }}">
            </qm-input-search-machine-name-by-qc-area>

        </div>

        <div class="row form-group">
            <label class="col-md-4 col-form-label"> ตราบุหรี่ </label>
            <div class="col-md-8">
                <qm-el-select name="leak_brand" id="input_leak_brand" :clearable="true" :filterable="true"
                    option-key="brand_value" option-value="brand_value" option-label="brand_label"
                    :select-options="{{ json_encode($listBrands) }}" 
                    value="{{ old('leak_brand') ? old('leak_brand') : (isset($searchInputs['leak_brand']) ? $searchInputs['leak_brand'] : '') }}">
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-4 col-form-label"> ขนาดบุหรี่ </label>
            <div class="col-md-8">
                <qm-el-select name="leak_brand_category_code" id="input_leak_brand_category_code" :clearable="true" :filterable="true"
                    option-key="category_value" option-value="category_value" option-label="category_label"
                    :select-options="{{ json_encode($listBrandCategories) }}" 
                    value="{{ old('leak_brand_category_code') ? old('leak_brand_category_code') : (isset($searchInputs['leak_brand_category_code']) ? $searchInputs['leak_brand_category_code'] : '') }}">
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-4 col-form-label"> เลขที่การตรวจสอบ </label>
            <div class="col-md-8">
                <input id="input_sample_no" type="text"
                    class="form-control{{ $errors->has('sample_no') ? ' is-invalid' : '' }}" name="sample_no"
                    name="sample_no"
                    value="{{ old('sample_no') ? old('sample_no') : (isset($searchInputs['sample_no']) ? $searchInputs['sample_no'] : '') }}">
            </div>
        </div>

    </div>

    <div class="col-md-4">

        <div class="row form-group">
            <label class="col-md-4 col-form-label"> ประเภทเครื่อง </label>
            <div class="col-md-8">
                <qm-el-select name="leak_machine_type" id="input_leak_machine_type" :clearable="true" :filterable="true"
                    option-key="machine_type_value" option-value="machine_type_value" option-label="machine_type_label"
                    :select-options="{{ json_encode($machineTypes) }}" 
                    value="{{ old('leak_machine_type') ? old('leak_machine_type') : (isset($searchInputs['leak_machine_type']) ? $searchInputs['leak_machine_type'] : '') }}">
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-4 col-form-label"> ขอบเขตเครื่องจักร </label>
            <div class="col-md-8">
                <qm-el-select name="machine_result_status" id="input_machine_result_status" option-key="value"
                    option-value="value" option-label="label" :filterable="true"
                    :select-options="{{ json_encode($machineResultStatuses) }}"
                    value="{{ old('machine_result_status') ? old('machine_result_status') : (isset($searchInputs['machine_result_status']) ? $searchInputs['machine_result_status'] : 'ALL') }}"
                    />
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-4 col-form-label"> ตำแหน่งที่รั่ว </label>
            <div class="col-md-8">
                <qm-el-select name="position_leak" id="input_position_leak" :clearable="true" :filterable="true"
                    option-key="position_leak_value" option-value="position_leak_value" option-label="position_leak_label"
                    :select-options="{{ json_encode($listLeakPositions) }}" 
                    value="{{ old('position_leak') ? old('position_leak') : (isset($searchInputs['position_leak']) ? $searchInputs['position_leak'] : '') }}">
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-7 col-form-label required"> ไฮไลท์หมายเลขเครื่องตั้งแต่ </label>
            <div class="col-md-5">
                <div class="input-group">
                    <input name="hightlight_machine_from_percent"
                        id="input_hightlight_machine_from_percent"
                        type="number"
                        min="0"
                        max="100"
                        oninput="this.value = Math.abs(this.value)"
                        class="form-control input-sm text-center"
                        value="{{ old('hightlight_machine_from_percent') ? old('hightlight_machine_from_percent') : (isset($searchInputs['hightlight_machine_from_percent']) ? $searchInputs['hightlight_machine_from_percent'] : '60') }}"
                    />
                    <div class="input-group-append">
                      <span class="input-group-text input-sm"> % </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-7 col-form-label required"> ไฮไลท์ตำแหน่งที่รั่วสูงตั้งแต่</label>
            <div class="col-md-5">
                <div class="input-group">
                    <input name="hightlight_position_leak_from_percent"
                        id="input_hightlight_position_leak_from_percent"
                        type="number"
                        min="0"
                        max="100"
                        oninput="this.value = Math.abs(this.value)"
                        class="form-control input-sm text-center"
                        value="{{ old('hightlight_position_leak_from_percent') ? old('hightlight_position_leak_from_percent') : (isset($searchInputs['hightlight_position_leak_from_percent']) ? $searchInputs['hightlight_position_leak_from_percent'] : '30') }}"
                    />
                    <div class="input-group-append">
                      <span class="input-group-text input-sm"> % </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-4">

        <qm-datepicker-th-from-to label="วันที่เก็บตัวอย่าง" 
            from-date-name="sample_date_from"
            from-date-id="input_sample_date_from"
            from-date-value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : date('d/m/Y', strtotime('+543 years'))) }}"
            from-time-name="sample_time_from"
            from-time-id="input_sample_time_from"
            from-time-value="{{ old('sample_time_from') ? old('sample_time_from') : (isset($searchInputs['sample_time_from']) ? $searchInputs['sample_time_from'] : '00:00') }}"
            to-date-name="sample_date_to" 
            to-date-id="input_sample_date_to"
            to-date-value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : date('d/m/Y', strtotime('+543 years'))) }}"
            to-time-name="sample_time_to" 
            to-time-id="input_sample_time_to"
            to-time-value="{{ old('sample_time_to') ? old('sample_time_to') : (isset($searchInputs['sample_time_to']) ? $searchInputs['sample_time_to'] : '23:59') }}">
        </qm-datepicker-th-from-to>

    </div>

</div>

<qm-severity-level-checkboxes style="display: none"
    :minor-value="{{ old('minor') ? old('minor') : (isset($searchInputs['minor']) ? $searchInputs['minor'] : 'true') }}"
    :major-value="{{ old('major') ? old('major') : (isset($searchInputs['major']) ? $searchInputs['major'] : 'true') }}"
    :critical-value="{{ old('critical') ? old('critical') : (isset($searchInputs['critical']) ? $searchInputs['critical'] : 'true') }}"
    :select-all-level-value="{{ old('select_all_level') ? old('select_all_level') : (isset($searchInputs['select_all_level']) ? $searchInputs['select_all_level'] : 'true') }}">
</qm-severity-level-checkboxes>

<qm-test-severity-code-checkboxes style="display: none"
    :minor-value="{{ old('test_serverity_code_minor') ? old('test_serverity_code_minor') : (isset($searchInputs['test_serverity_code_minor']) ? $searchInputs['test_serverity_code_minor'] : 'true') }}"
    :major-value="{{ old('test_serverity_code_major') ? old('test_serverity_code_major') : (isset($searchInputs['test_serverity_code_major']) ? $searchInputs['test_serverity_code_major'] : 'true') }}"
    :critical-value="{{ old('test_serverity_code_critical') ? old('test_serverity_code_critical') : (isset($searchInputs['test_serverity_code_critical']) ? $searchInputs['test_serverity_code_critical'] : 'true') }}"
    :select-all-level-value="{{ old('select_all_test_serverity_code') ? old('select_all_test_serverity_code') : (isset($searchInputs['select_all_test_serverity_code']) ? $searchInputs['select_all_test_serverity_code'] : 'true') }}">
</qm-test-severity-code-checkboxes>

{{-- <qm-sample-disposition-checkboxes v-show="false"
    :pending-sample-disposition-value="{{ old('pending_sample_disposition') ? old('pending_sample_disposition') : (isset($searchInputs['pending_sample_disposition']) ? $searchInputs['pending_sample_disposition'] : 'true') }}"
    :correct-sample-disposition-value="{{ old('correct_sample_disposition') ? old('correct_sample_disposition') : (isset($searchInputs['correct_sample_disposition']) ? $searchInputs['correct_sample_disposition'] : 'true') }}"
    :incorrect-sample-disposition-value="{{ old('incorrect_sample_disposition') ? old('incorrect_sample_disposition') : (isset($searchInputs['incorrect_sample_disposition']) ? $searchInputs['incorrect_sample_disposition'] : 'true') }}"
    :select-all-value="{{ old('select_all_sample_disposition') ? old('select_all_sample_disposition') : (isset($searchInputs['select_all_sample_disposition']) ? $searchInputs['select_all_sample_disposition'] : 'true') }}">
</qm-sample-disposition-checkboxes> --}}

<qm-sample-operation-status-checkboxes
    :pending-sample-operation-status-value="{{ old('pending_sample_operation_status') ? old('pending_sample_operation_status') : (isset($searchInputs['pending_sample_operation_status']) ? $searchInputs['pending_sample_operation_status'] : 'true') }}"
    :inprogress-sample-operation-status-value="{{ old('inprogress_sample_operation_status') ? old('inprogress_sample_operation_status') : (isset($searchInputs['inprogress_sample_operation_status']) ? $searchInputs['inprogress_sample_operation_status'] : 'true') }}"
    :completed-sample-operation-status-value="{{ old('completed_sample_operation_status') ? old('completed_sample_operation_status') : (isset($searchInputs['completed_sample_operation_status']) ? $searchInputs['completed_sample_operation_status'] : 'true') }}"
    :rejected-sample-operation-status-value="{{ old('rejected_sample_operation_status') ? old('rejected_sample_operation_status') : (isset($searchInputs['rejected_sample_operation_status']) ? $searchInputs['rejected_sample_operation_status'] : 'false') }}"
    :select-all-value="{{ old('select_all_sample_operation_status') ? old('select_all_sample_operation_status') : (isset($searchInputs['select_all_sample_operation_status']) ? $searchInputs['select_all_sample_operation_status'] : 'false') }}">
</qm-sample-operation-status-checkboxes>

<qm-sample-result-status-checkboxes
    :pending-sample-result-status-value="{{ old('pending_sample_result_status') ? old('pending_sample_result_status') : (isset($searchInputs['pending_sample_result_status']) ? $searchInputs['pending_sample_result_status'] : 'true') }}"
    :conform-sample-result-status-value="{{ old('conform_sample_result_status') ? old('conform_sample_result_status') : (isset($searchInputs['conform_sample_result_status']) ? $searchInputs['conform_sample_result_status'] : 'true') }}"
    :nonconform-sample-result-status-value="{{ old('nonconform_sample_result_status') ? old('nonconform_sample_result_status') : (isset($searchInputs['nonconform_sample_result_status']) ? $searchInputs['nonconform_sample_result_status'] : 'true') }}"
    :rejected-sample-result-status-value="{{ old('rejected_sample_result_status') ? old('rejected_sample_result_status') : (isset($searchInputs['rejected_sample_result_status']) ? $searchInputs['rejected_sample_result_status'] : 'false') }}"
    :select-all-value="{{ old('select_all_sample_result_status') ? old('select_all_sample_result_status') : (isset($searchInputs['select_all_sample_result_status']) ? $searchInputs['select_all_sample_result_status'] : 'false') }}">
</qm-sample-result-status-checkboxes>

<qm-approval-status-checkboxes
    :pending-approval-status-value="{{ old('pending_approval_status') ? old('pending_approval_status') : (isset($searchInputs['pending_approval_status']) ? $searchInputs['pending_approval_status'] : 'true') }}"
    :approved-approval-status-value="{{ old('approved_approval_status') ? old('approved_approval_status') : (isset($searchInputs['approved_approval_status']) ? $searchInputs['approved_approval_status'] : 'true') }}"
    :rejected-approval-status-value="{{ old('rejected_approval_status') ? old('rejected_approval_status') : (isset($searchInputs['rejected_approval_status']) ? $searchInputs['rejected_approval_status'] : 'false') }}"
    :select-all-value="{{ old('select_all_approval_status') ? old('select_all_approval_status') : (isset($searchInputs['select_all_approval_status']) ? $searchInputs['select_all_approval_status'] : 'false') }}">
</qm-approval-status-checkboxes>