<template>

    <div class="col-md-12">

        <div class="form-group">

            <label class="required"> เขตตรวจคุณภาพ </label>

            <qm-el-select name="qc_area" id="input_qc_area" placeholder="เลือกเขตตรวจคุณภาพ" 
                option-key="qc_area_value" option-value="qc_area_value" option-label="qc_area_label"
                :select-options="qcAreaOptions" :value="qcArea" @onSelected="onQcAreaWasSelected" 
                :filterable="true" />

        </div>

        <div class="form-group">
        
            <label class="required">หมายเลขเครื่อง</label>

            <qm-el-select name="machine_set" id="input_machine_set" placeholder="เลือกหมายเลขเครื่อง" option-key="qc_area_machine_set"
                option-value="machine_set_value" option-label="machine_set_label"
                :select-options="machineOptions" :value="machine" @onSelected="onMachineSetWasSelected" 
                :filterable="true" />

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

            let options = [];

            if(qcAreaValue == "ALL") {
                options = [{
                    "machine_set_value": "ALL", 
                    "machine_set_label": "เลือกทั้งหมด"
                }];
            } else {
                options = [
                    { 
                        "machine_set_value": "ALL", 
                        "machine_set_label": "เลือกทั้งหมด"
                    },
                    ...this.machines.filter(item => item.qc_area == qcAreaValue)
                ];
            }

            return options;

        },

        onQcAreaWasSelected(value) {
            this.machineOptions = this.getMachineOptionsInQcArea(value);
            this.qcArea = value;
            this.machine = "ALL"; // default value
        },

        onMachineSetWasSelected(value) {
            this.machine = value;
        }

    }
};
</script>
