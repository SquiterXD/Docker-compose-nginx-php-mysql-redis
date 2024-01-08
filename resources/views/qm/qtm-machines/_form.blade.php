<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        
        <qm-input-form-qtm-machines-create
            task-type-value="{{ old('task_type') ? old('task_type') : "ALL" }}"
            equipment-value="{{ old('equipment') ? old('equipment') : "ALL" }}"
            machine-name-value="{{ old('machine_name') ? old('machine_name') : "ALL" }}"
            brand-value="{{ old('brand') ? old('brand') : "ALL" }}"
            :task-types="{{ json_encode($taskTypes) }}"
            :equipments="{{ json_encode($equipments) }}"
            :cig-equipments="{{ json_encode($cigEquipments) }}"
            :filter-equipments="{{ json_encode($filterEquipments) }}"
            :machines="{{ json_encode($machines) }}"
            :cig-machines="{{ json_encode($cigMachines) }}"
            :filter-machines="{{ json_encode($filterMachines) }}"
            :list-brands="{{ json_encode($listBrands) }}"
            :list-cig-brands="{{ json_encode($listCigBrands) }}"
            :list-filter-brands="{{ json_encode($listFilterBrands) }}"
        >
        </qm-input-form-qtm-machines-create>
        

        <div class="row form-group">
            <div class="col-md-12">

                <label class="required">วัน/เวลา ที่เก็บตัวอย่าง</label>

                <div class="row">

                    <div class="col-md-8">
                        <qm-datepicker-th class="form-control md:tw-mb-0 tw-mb-2" name="sample_date" id="input_sample_date" placeholder="โปรดเลือกวันที่เก็บตัวอย่าง" value="{{ old('sample_date') }}"  />
                    </div>
                    <div class="col-md-4">
                        <qm-timepicker name="sample_time" id="input_sample_time" value="{{ old('sample_time') }}" />
                    </div>

                </div>

            </div>
            
        </div>

        <qm-input-group-repeat 
            repeat-flag-value="{{ old('repeat_flag') ? old('repeat_flag') : 'false' }}"
            repeat-time-hour-value="{{ old('repeat_time_hour') ? old('repeat_time_hour') : '0' }}"
            repeat-time-min-value="{{ old('repeat_time_min') ? old('repeat_time_min') : '0' }}"
            repeat-qty-value="{{ old('repeat_qty') ? old('repeat_qty') : '1' }}" >
        </qm-input-group-repeat>

    </div>
</div>
