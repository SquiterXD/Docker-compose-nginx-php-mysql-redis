<div class="row justify-content-center">

    <div class="col-lg-12 col-md-12">

        <qm-form-create-tobaccos 
            :qm-groups="{{ json_encode($qmGroups) }}"  
            :process-qm-groups="{{ json_encode($processQmGroups) }}"  
            :silo-qm-groups="{{ json_encode($siloQmGroups) }}"  
            :locators="{{ json_encode($locators) }}" 
            sample-date-value="{{ old('sample_date') ? old('sample_date') : date('d/m/Y', strtotime('+543 years')) }}"  
            sample-time-value="{{ old('sample_time') }}"  
            repeat-flag="{{ old('repeat_flag') ? old('repeat_flag') : 'false' }}"
            repeat-time-hour="{{ old('repeat_time_hour') ? old('repeat_time_hour') : '0' }}"
            repeat-time-min="{{ old('repeat_time_min') ? old('repeat_time_min') : '0' }}"
            repeat-qty="{{ old('repeat_qty') ? old('repeat_qty') : '1' }}"
            qm-group-value="{{ old('qm_group') ? old('qm_group') : "" }}"
            qm-group-type-value="{{ old('qm_group_type') ? old('qm_group_type') : "" }}"
            locator-value="{{ old('locator_id') ? old('locator_id') : "ALL" }}"
            opt-selection-type-value="{{ old('opt_selection_type') ? old('opt_selection_type') : "CHECKLIST" }}"
        >
        </qm-form-create-tobaccos>

    </div>

</div>
