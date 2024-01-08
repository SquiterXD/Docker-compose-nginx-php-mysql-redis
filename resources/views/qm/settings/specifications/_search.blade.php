{{-- <input type="hidden" name="test_type" value="{{ $testType->lookup_code }}"> --}}
{{-- กลุ่มผลิตภัณฑ์ด้านใบยา --}}
@if ($testType->lookup_code == 1)
<input type="hidden" name="test_type" value="{{ $testType->lookup_code }}">
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <qm-input-search-locator-by-qm-group 
                :qm-groups="{{ json_encode($qmGroups) }}"
                qm-group-from-value="{{ old('qm_group_from') ? old('qm_group_from') : request()->qm_group_from }}"
                qm-group-to-value="{{ old('qm_group_to') ? old('qm_group_to') : request()->qm_group_to }}"
                :locators="{{ json_encode($locators) }}"
                locator-value="{{ old('locator_id') ? old('locator_id') : request()->locator_id }}"
                :test-type="{{ json_encode($testType) }}"
                :locators="{{ json_encode($locators) }}">
            </qm-input-search-locator-by-qm-group>
        </div>
    </div>
</div>

{{-- กลุ่มผลิตภัณฑ์สำเร็จรูป --}}
@elseif($testType->lookup_code == 2)
<input type="hidden" name="test_type" value="{{ $testType->lookup_code }}">
<div class="row form-group">
    <div class="col-md-6">
        <div class="row">
            <label class="col-md-4 col-form-label"> กระบวนการตรวจคุณภาพบุหรี่ <span class="text-danger">*</span> </label>
            <div class="col-md-8">
                <input-el-select    name="qm_process_seq" 
                                    id="input_qm_process_seq" 
                                    option-key="lookup_code" 
                                    option-value="lookup_code"  
                                    option-label="meaning" 
                                    :select-options="{{ json_encode($testProcess) }}"
                                    value="{{ old('qm_process_seq', request()->qm_process_seq) }}"
                    />
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <label class="col-md-4 col-form-label"> รายการตรวจสอบ <span class="text-danger">*</span> </label>
            <div class="col-md-8">
                <input-el-select    name="check_list_code" 
                                    id="input_check_list_code" 
                                    option-key="lookup_code" 
                                    option-value="lookup_code"
                                    option-label="meaning" 
                                    :select-options="{{ json_encode($qualityTest) }}"
                                    value="{{ old('check_list_code', request()->check_list_code) }}"
                    />
            </div>
        </div>
    </div>
</div>

{{-- <div class="row form-group">
    <div class="col-md-6">
        <div class="row">
            <label class="col-md-4 col-form-label"> เขตการตรวจคุณภาพ </label>
            <div class="col-md-8">
                <qm-el-select name="qc_area" id="input_qc_area" option-key="qc_area" option-value="qc_area"
                    option-label="qc_area" :select-options="{{ json_encode($qcAreas) }}"
                    value="{{ old('qc_area', request()->qc_area) }}"
                     />
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <label class="col-md-4 col-form-label"> หมายเลขเครื่อง </label>
            <div class="col-md-8">
                <qm-el-select name="machine_set" id="input_machine_set" option-key="machine_set" option-value="machine_set"
                    option-label="machine_set" :select-options="{{ json_encode($machines) }}"
                    value="{{ old('machine_set', request()->machine_set) }}"
                     />
            </div>
        </div>
    </div>
</div> --}}

{{-- QMS0015 กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ - การตรวจคุณภาพมวนบุหรี่ทางฟิสิกส์ ด้วยเครื่องมือวัด --}}
@elseif($testType->lookup_code == 3)
<qm-settings-spec-search-packet-air-and-qtm
    :p-brands="{{ json_encode($brands) }}"
    :p-def-brands="{{ json_encode(old('lot_number', request()->lot_number)) }}"
    :p-product-type="{{ json_encode($productType) }}"
    :p-def-product-type="{{ json_encode(old('product_type_code', request()->product_type_code)) }}"
    :p-request="{{ json_encode(request()->all()) }}"
/>
</qm-settings-spec-search-packet-air-and-qtm>

{{-- การตรวจอัตราลมรั่ว ฟิล์มห่อซองบุหรี่ --}}
@elseif($testType->lookup_code == 5)
<input type="hidden" name="test_type" value="{{ $testType->lookup_code }}">

{{-- การระบาดของมอดยาสูบ  --}}
@elseif($testType->lookup_code == 4)
<input type="hidden" name="test_type" value="{{ $testType->lookup_code }}">
<div class="row form-group">
    <qm-settings-spec-moth
        :old-inputs="{{ json_encode(count(old())?  old() : request()->all()) }}"
        :moth-locators="{{ json_encode($mothLocators) }}"
        :moth-buildings="{{ json_encode($mothBuildings) }}"
        :moth-departments="{{ json_encode($mothDepartments) }}"
    />
</div>

@endif

<div style="display: none;">
    <br>
    <div class="row">
        <div class="col-md-12">
            {{ 'เกณฑ์มาตรฐานในการตรวจสอบ : ' }} {{isset($specifications[0]) ? $specifications[0]->spec_name : ''}}
        </div>        
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ 'SPEC ID : ' }} {{isset($specifications[0]) ? $specifications[0]->spec_id : ''}}
        </div>   
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ 'Version : ' }} {{isset($specifications[0]) ? $specifications[0]->spec_vers : ''}}
        </div>
    </div>
</div>



