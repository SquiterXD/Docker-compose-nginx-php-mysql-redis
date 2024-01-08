<div class="row justify-content-center">
    <div class="col-lg-6 col-md-10">

        <div class="row">

            <qm-input-machine-name-by-qc-area :qc-areas="{{ json_encode($qcAreas) }}" qc-area-value="{{ old('qc_area') ? old('qc_area') : "ALL" }}" 
                :machines="{{ json_encode($machines) }}" machine-value="{{ old('machine_name') ? old('machine_name') : "ALL" }}">
            </qm-input-machine-name-by-qc-area>
            
        </div>

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
