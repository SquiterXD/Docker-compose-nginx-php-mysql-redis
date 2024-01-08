<template>

    <div class="row form-group">
        
        <div class="col-md-6">

            <label class="required"> เขตตรวจคุณภาพ </label>

            <qm-el-select name="qc_area" id="input_qc_area" placeholder="เลือกเขตตรวจคุณภาพ" 
                option-key="qc_area_value" option-value="qc_area_value" option-label="qc_area_label"
                :select-options="qcAreaOptions" :value="qcArea" @onSelected="onQcAreaWasSelected" 
                :filterable="true" />

        </div>

        <div class="col-md-6">
        
            <label class="required"> เลขชุดเครื่องจักร </label>

            <qm-el-select name="machine_set" id="input_machine_set" placeholder="เลือกเลขชุดเครื่องจักร" option-key="qc_area_machine_set"
                option-value="machine_set_value" option-label="machine_set_label"
                :select-options="machineSetOptions" :value="machineSet" @onSelected="onMachineSetWasSelected" 
                :filterable="true" />

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

            if(qcAreaValue == "ALL") {
                options = this.machineSets;
            } else {
                options = [
                    { 
                        "machine_set_value": "ALL", 
                        "machine_set_label": "เลือกทั้งหมด"
                    },
                    ...this.machineSets.filter(item => item.qc_area_cig == qcAreaValue)
                ];
            }

            return options;

        },

        onQcAreaWasSelected(value) {
            this.machineSetOptions = this.getMachineOptionsInQcArea(value);
            this.qcArea = value;
            this.machineSet = "ALL"; // default value
        },

        onMachineSetWasSelected(value) {
            this.machineSet = value;
            if(value && value != "ALL") {
                const foundMachineSet = this.machineSets.find(item => item.machine_set_value == this.machineSet);
                this.qcArea = foundMachineSet ? foundMachineSet.qc_area_cig : "ALL";
                this.machineSetOptions = this.getMachineOptionsInQcArea(this.qcArea);
            }
        }

    }
};
</script>
