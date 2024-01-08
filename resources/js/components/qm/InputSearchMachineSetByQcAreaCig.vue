<template>

    <div class="">

        <div class="row form-group">

            <label class="col-md-4 col-form-label"> เขตตรวจคุณภาพ </label>

            <div class="col-md-8">

                <qm-el-select name="qc_area" id="input_qc_area" placeholder="เขตตรวจคุณภาพ" 
                    option-key="qc_area_value" option-value="qc_area_value" option-label="qc_area_label"
                    :select-options="qcAreaOptions" :value="qcArea" @onSelected="onQcAreaWasSelected" 
                    :clearable="true" :filterable="true" />

            </div>

        </div>

        <div class="row form-group">

            <label class="col-md-4 col-form-label"> เลขชุดเครื่องจักร </label>

            <div class="col-md-8">

                <qm-el-select name="machine_set" id="input_machine_set" placeholder="เลขชุดเครื่องจักร" option-key="qc_area_machine_set"
                    option-value="machine_set_value" option-label="machine_set_label"
                    :select-options="machineSetOptions" :value="machineSet" @onSelected="onMachineSetWasSelected" 
                    :clearable="true" :filterable="true" />

            </div>

        </div>

    </div>

</template>

<script>
export default {
    props: [
        "qcAreas",
        "machineSets",
        "qcAreaValue",
        "machineSetValue"
    ],

    data() {
        return {
            qcArea: this.qcAreaValue,
            machineSet: this.machineSetValue,
            qcAreaOptions: this.qcAreas,
            machineSetOptions: this.getMachineOptionsInQcArea(this.qcAreaValue),
        };
    },

    methods: {

        getMachineOptionsInQcArea(qcAreaValue) {

            let options = [];

            if(qcAreaValue == "") {
                options = this.machineSets;
            } else {
                options = [
                    ...this.machineSets.filter(item => item.qc_area_cig == qcAreaValue)
                ];
            }

            return options;

        },

        onQcAreaWasSelected(value) {
            this.machineSetOptions = this.getMachineOptionsInQcArea(value);
            this.qcArea = value;
            this.machineSet = ""; // default value
        },

        onMachineSetWasSelected(value) {
            this.machineSet = value;
            if(value && value != "") {
                const foundMachineSet = this.machineSets.find(item => item.machine_set_value == this.machineSet);
                this.qcArea = foundMachineSet ? foundMachineSet.qc_area_cig : "";
                this.machineSetOptions = this.getMachineOptionsInQcArea(this.qcArea);
            }
        }

    }
};
</script>
