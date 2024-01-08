<div class="row form-group">

    <qm-search-form-qtm-machines-report-summary
        sample-no-value="{{ old('sample_no') ? old('sample_no') : (isset($searchInputs['sample_no']) ? $searchInputs['sample_no'] : '') }}"
        :task-types="{{ json_encode($taskTypes) }}"
        task-type-value="{{ old('task_type_code') ? old('task_type_code') : (isset($searchInputs['task_type_code']) ? $searchInputs['task_type_code'] : '200') }}"
        :equipment-types="{{ json_encode($equipmentTypes) }}"
        equipment-type-value="{{ old('qtm_equipment_type') ? old('qtm_equipment_type') : (isset($searchInputs['qtm_equipment_type']) ? $searchInputs['qtm_equipment_type'] : '') }}"
        :equipments="{{ json_encode($equipments) }}"
        machine-name-value="{{ old('machine_name') ? old('machine_name') : (isset($searchInputs['machine_name']) ? $searchInputs['machine_name'] : '') }}" 
        :list-makers="{{ json_encode($listMakers) }}" 
        maker-value="{{ old('qtm_maker') ? old('qtm_maker') : (isset($searchInputs['qtm_maker']) ? $searchInputs['qtm_maker'] : '') }}" 
        :list-brands="{{ json_encode($listBrands) }}"
        brand-value="{{ old('qtm_brand') ? old('qtm_brand') : (isset($searchInputs['qtm_brand']) ? $searchInputs['qtm_brand'] : '') }}"
        :list-brand-categories="{{ json_encode($listBrandCategories) }}"
        brand-category-value="{{ old('qtm_brand_category_code') ? old('qtm_brand_category_code') : (isset($searchInputs['qtm_brand_category_code']) ? $searchInputs['qtm_brand_category_code'] : '') }}"
        :show-sample-result-types="{{ json_encode($showSampleResultTypeOptions) }}"
        show-test-id-value="{{ old('show_test_id') ? old('show_test_id') : (isset($searchInputs['show_test_id']) ? $searchInputs['show_test_id'] : '') }}"
        :quality-statuses="{{ json_encode($qualityStatusOptions) }}"
        quality-status-value="{{ old('quality_status') ? old('quality_status') : (isset($searchInputs['quality_status']) ? $searchInputs['quality_status'] : '') }}"
        :result-statuses="{{ json_encode($resultStatusOptions) }}"
        result-status-value="{{ old('result_status') ? old('result_status') : (isset($searchInputs['result_status']) ? $searchInputs['result_status'] : '') }}"
    >
    </qm-search-form-qtm-machines-report-summary>

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

<qm-severity-level-checkboxes
    :minor-value="{{ old('minor') ? old('minor') : (isset($searchInputs['minor']) ? $searchInputs['minor'] : 'true') }}"
    :major-value="{{ old('major') ? old('major') : (isset($searchInputs['major']) ? $searchInputs['major'] : 'true') }}"
    :critical-value="{{ old('critical') ? old('critical') : (isset($searchInputs['critical']) ? $searchInputs['critical'] : 'true') }}"
    :select-all-level-value="{{ old('select_all_level') ? old('select_all_level') : (isset($searchInputs['select_all_level']) ? $searchInputs['select_all_level'] : 'true') }}">
</qm-severity-level-checkboxes>

<qm-test-severity-code-checkboxes
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

<qm-confirm-status-checkboxes v-show="false"
    :pending-confirm-status-value="{{ old('pending_confirm_status') ? old('pending_confirm_status') : (isset($searchInputs['pending_confirm_status']) ? $searchInputs['pending_confirm_status'] : 'true') }}"
    :done-confirm-status-value="{{ old('done_confirm_status') ? old('done_confirm_status') : (isset($searchInputs['done_confirm_status']) ? $searchInputs['done_confirm_status'] : 'true') }}"
    :rejected-confirm-status-value="{{ old('rejected_confirm_status') ? old('rejected_confirm_status') : (isset($searchInputs['rejected_confirm_status']) ? $searchInputs['rejected_confirm_status'] : 'false') }}"
    :select-all-value="{{ old('select_all_confirm_status') ? old('select_all_confirm_status') : (isset($searchInputs['select_all_confirm_status']) ? $searchInputs['select_all_confirm_status'] : 'false') }}">
</qm-confirm-status-checkboxes>