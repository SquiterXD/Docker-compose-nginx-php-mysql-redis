<template>

    <div class="col-12">

        <div class="row form-group">

            <label class="col-md-4 col-form-label"> เขตตรวจคุณภาพ </label>

            <div class="col-md-8">

                <qm-el-select name="qc_area" id="input_qc_area" 
                    option-key="qc_area_value" option-value="qc_area_value" option-label="qc_area_label"
                    :select-options="qcAreaOptions" :value="qcArea" @onSelected="onQcAreaWasSelected" 
                    :clearable="true" :filterable="true" />

            </div>

        </div>

        <div class="row form-group">

            <label class="col-md-4 col-form-label"> หมายเลขเครื่อง </label>

            <div class="col-md-8">

                <qm-el-select name="machine_set" id="input_machine_set" option-key="qc_area_machine_set"
                    option-value="machine_set_value" option-label="machine_set_label"
                    :select-options="machineOptions" :value="machine" @onSelected="onMachineSetWasSelected" 
                    :clearable="true" :filterable="true" />

            </div>

        </div>

    </div>

</template>

<script>
export default {

    props: [
        "qcAreas",
        "machines",
        "qcAreaValue",
        "machineValue"
    ],

    data() {
        return {
            qcArea: this.qcAreaValue,
            machine: this.machineValue,
            qcAreaOptions: this.qcAreas,
            machineOptions: this.getMachineOptionsInQcArea(this.qcAreaValue),
        };
    },

    methods: {

        getMachineOptionsInQcArea(qcAreaValue) {

            let options = this.machines.filter(item => item.qc_area == qcAreaValue);
            return options;

        },

        onQcAreaWasSelected(value) {
            this.machineOptions = this.getMachineOptionsInQcArea(value);
            this.qcArea = value;
        },

        onMachineSetWasSelected(value) {
            this.machine = value;
        }

    }
};
</script>
