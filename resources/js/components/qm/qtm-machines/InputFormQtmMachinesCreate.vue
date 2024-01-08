<template>

    <div class="row">

        <div class="col-md-12">

            <div class="row form-group">

                <div class="col-md-6">

                    <label class="required"> ประเภทงาน </label>

                    <qm-el-select name="task_type" id="input_task_type" placeholder="ประเภทงาน "
                        option-key="task_type_value" option-value="task_type_value" option-label="task_type_label"
                        @onSelected="onTaskTypeChanged($event)"
                        :select-options="taskTypes" 
                        :clearable="false" 
                        :filterable="true"
                        :value="taskType"  />

                </div>

                <div class="col-md-6">

                    <label class="required"> หมายเลขเครื่อง QTM </label>

                    <qm-el-select name="equipment" id="input_equipment" placeholder="หมายเลขเครื่อง QTM "
                        option-key="equipment_value" option-value="equipment_value" option-label="equipment_label"
                        @onSelected="onEquipmentChanged($event)"
                        :select-options="equipmentOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="equipment"  />

                </div>

            </div>

            <div class="row form-group">
                <div class="col-md-12">

                    <label class="required"> หมายเลขเครื่อง </label>

                    <qm-el-select name="machine_name" id="input_machine_name" placeholder="หมายเลขเครื่อง "
                        option-key="machine_name_value" option-value="machine_name_value" option-label="machine_name_label"
                        @onSelected="onMachineNameChanged($event)"
                        :select-options="machineOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="machineName"  />

                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">

                    <label class="required"> บุหรี่ / ก้นกรอง </label>

                    <qm-el-select name="brand" id="input_brand" placeholder="เลือกบุหรี่ / ก้นกรอง "
                        option-key="brand_value" option-value="brand_value" option-label="brand_label"
                        @onSelected="onBrandChanged($event)"
                        :select-options="listBrandOptions" 
                        :clearable="false" 
                        :filterable="true"
                        :value="brand"  />

                </div>
                
            </div>

        </div>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    props: [
        "taskTypes",
        "taskTypeValue",
        "equipments", 
        "cigEquipments",
        "filterEquipments",
        "equipmentValue", 
        "machines", 
        "cigMachines", 
        "filterMachines", 
        "machineNameValue", 
        "listBrands",
        "listCigBrands",
        "listFilterBrands",
        "brandValue"
    ],

    components: {
        Loading
    },

    data() {
        return {
            taskType: this.taskTypeValue,
            equipment: this.equipmentValue,
            machineName: this.machineNameValue,
            brand: this.brandValue,
            equipmentOptions: (this.taskTypeValue == "200" || this.taskTypeValue == "300") ? (this.taskTypeValue == "200" ? this.cigEquipments : this.filterEquipments) : this.equipments,
            machineOptions: (this.taskTypeValue == "200" || this.taskTypeValue == "300") ? (this.taskTypeValue == "200" ? this.cigMachines : this.filterMachines) : this.machines,
            listBrandOptions: (this.taskTypeValue == "200" || this.taskTypeValue == "300") ? (this.taskTypeValue == "200" ? this.listCigBrands : this.listFilterBrands) : this.listBrands,
        };
    },

    mounted() {

        if(this.taskTypeValue) {

            this.filterMachineOptions(this.taskTypeValue);
            this.filterEquipmentOptions(this.taskTypeValue);
            this.filterBrandOptions(this.taskTypeValue);

        }

    },

    methods: {

        onTaskTypeChanged(taskType){

            this.taskType = taskType;

            this.filterMachineOptions(this.taskType);
            this.filterEquipmentOptions(this.taskType);
            this.filterBrandOptions(this.taskType);

        },

        onEquipmentChanged(equipment) {
            this.equipment = equipment;
            if(equipment != "ALL") {
                const foundEquipment = this.equipmentOptions.find(item => item.equipment_value == equipment);
                if(foundEquipment) {
                    this.taskType = foundEquipment.task_type_code;
                    this.onTaskTypeChanged(this.taskType);
                }
            }
        },

        onMachineNameChanged(machineName) {
            this.machineName = machineName;
        },

        onBrandChanged(brand) {
            this.brand = brand;
        },

        filterMachineOptions(taskType) {
            this.machineOptions = this.machines;  
            if(taskType == "200" || taskType == "300") {
                this.machineOptions = taskType == "200" ? this.cigMachines : this.filterMachines;
                const foundSelectedMachineItem = this.machineOptions.find(item => item.machine_name_value == this.machineName);
                this.$nextTick(() => {
                    if(!foundSelectedMachineItem){ this.machineName = "ALL"; }
                });
            }
        },

        filterEquipmentOptions(taskType) {
            this.equipmentOptions = this.equipments;  
            if(taskType == "200" || taskType == "300") {
                this.equipmentOptions = taskType == "200" ? this.cigEquipments : this.filterEquipments;
                const foundSelectedEqItem = this.equipmentOptions.find(item => item.equipment_value == this.equipment);
                this.$nextTick(() => {
                    if(!foundSelectedEqItem){ this.equipment = "ALL"; }
                });
            }
        },

        filterBrandOptions(taskType) {
            this.listBrandOptions = this.listBrands;  
            if(taskType == "200" || taskType == "300") {
                this.listBrandOptions = taskType == "200" ? this.listCigBrands : this.listFilterBrands;
                const foundSelectedBrandItem = this.listBrandOptions.find(item => item.brand_value == this.brand);
                this.$nextTick(() => {
                    if(!foundSelectedBrandItem){ this.brand = "ALL"; }
                });
            }
        },

    }

};
</script>
