<template>

    <div class="col-md-8">

        <div class="row">

            <div class="col-md-6">

                <div class="row form-group">

                    <label class="col-md-4 col-form-label"> เลขที่การตรวจสอบ </label>
                    <div class="col-md-8">
                        <input type="text" id="input_sample_no" name="sample_no" class="form-control" v-model="sampleNo" >
                    </div>

                </div>

                <div class="row form-group">
                    <label class="col-md-4 col-form-label"> ประเภทเครื่อง </label>
                    <div class="col-md-8">
                        <qm-el-select name="qtm_equipment_type" id="input_qtm_equipment_type" placeholder="เลือกประเภทเครื่อง "
                            option-key="equipment_type_value" option-value="equipment_type_value" option-label="equipment_type_label"
                            :select-options="equipmentTypes" 
                            @onSelected="onEquipmentTypeChanged($event)"
                            :clearable="true" 
                            :filterable="true"
                            :value="equipmentType" />
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 col-form-label"> หมายเลขเครื่อง QTM </label>
                    <div class="col-md-8">
                        <qm-el-select name="machine_name" id="input_machine_name" placeholder="เลือกหมายเลขเครื่อง QTM "
                            option-key="equipment_value" option-value="equipment_value" option-label="equipment_label"
                            :select-options="equipmentOptions" 
                            @onSelected="onMachineNameChanged($event)"
                            :clearable="true" 
                            :filterable="true"
                            :value="machineName" />
                    </div>
                </div>

                <div class="row form-group">

                    <label class="col-md-4 col-form-label"> แสดงค่าความผิดปกติ </label>

                    <div class="col-md-8">

                        <qm-el-select name="show_test_id" id="input_show_test_id" placeholder="เลือกแสดงค่าความผิดปกติ" 
                            option-key="value" option-value="test_id" option-label="test_full_desc"
                            :select-options="showSampleResultTypeOptions" 
                            @onSelected="onShowTestIdChanged($event)"
                            :clearable="true"
                            :filterable="true"
                            :value="showTestId"
                        />

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="row form-group">
                    <label class="col-md-4 col-form-label"> ประเภทงาน </label>
                    <div class="col-md-8">
                        <qm-el-select name="task_type_code" id="input_task_type_code" placeholder="เลือกประเภทงาน "
                            option-key="task_type_value" option-value="task_type_value" option-label="task_type_label"
                            :select-options="taskTypes" 
                            @onSelected="onTaskTypeChanged($event)"
                            :clearable="true" 
                            :filterable="true"
                            :value="taskType" />
                    </div>
                </div>

                <div style="display: none;" class="row form-group">
                    <label class="col-md-4 col-form-label"> หมวดงาน </label>
                    <div class="col-md-8">
                        <qm-el-select name="qtm_brand_category_code" id="input_qtm_brand_category_code" placeholder="เลือกหมวดงาน "
                            option-key="category_value" option-value="category_value" option-label="category_label"
                            :select-options="listBrandCategoryOptions" 
                            @onSelected="onBrandCategoryChanged($event)"
                            :clearable="true" 
                            :filterable="true"
                            :value="brandCategory"
                        />
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 col-form-label"> หมายเลขเครื่อง Maker </label>
                    <div class="col-md-8">
                        <qm-el-select name="qtm_maker" id="input_qtm_maker" placeholder="เลือกหมายเลขเครื่อง Maker "
                            option-key="maker_value" option-value="maker_value" option-label="maker_label"
                            :select-options="listMakerOptions" 
                            @onSelected="onMakerChanged($event)"
                            :clearable="true" 
                            :filterable="true"
                            :value="maker" />
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 col-form-label"> บุหรี่ / ก้นกรอง </label>
                    <div class="col-md-8">
                        <qm-el-select name="qtm_brand" id="input_qtm_brand" placeholder="เลือกบุหรี่ / ก้นกรอง "
                            option-key="brand_value" option-value="brand_value" option-label="brand_label"
                            :select-options="listBrandOptions" 
                            @onSelected="onBrandChanged($event)"
                            :clearable="true" 
                            :filterable="true"
                            :value="brand"
                        />
                    </div>
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
        "sampleNoValue",
        "taskTypes",
        "taskTypeValue",
        "equipmentTypes",
        "equipmentTypeValue",
        "equipments", 
        "machineNameValue", 
        "listMakers", 
        "makerValue", 
        "listBrands",
        "brandValue",
        "listBrandCategories",
        "brandCategoryValue",
        "showSampleResultTypeOptions",
        "showTestIdValue"
    ],

    components: {
        Loading
    },

    data() {
        return {
            sampleNo: this.sampleNoValue,
            taskType: this.taskTypeValue,
            machineName: this.machineNameValue,
            equipmentType: this.equipmentTypeValue,
            maker: this.makerValue,
            brand: this.brandValue,
            brandCategory: this.brandCategoryValue,
            showTestId: this.showTestIdValue,
            equipmentOptions: this.equipments,
            listMakerOptions: this.listMakers,
            listBrandOptions: this.listBrands,
            listBrandCategoryOptions: this.listBrandCategories,
        };
    },

    mounted() {

        if(this.taskTypeValue || this.equipmentTypeValue || this.brandCategoryValue) {

            this.filterMakerOptions(this.taskTypeValue);
            this.filterBrandCategoryOptions(this.taskTypeValue);
            this.filterEquipmentOptions(this.taskTypeValue, this.equipmentTypeValue);
            this.filterBrandOptions(this.taskTypeValue, this.brandCategoryValue);

        }

    },

    methods: {

        onTaskTypeChanged(taskType){
            this.taskType = taskType;
            this.filterEquipmentOptions(this.taskType, this.equipmentType);
            this.filterMakerOptions(this.taskType);
            this.filterBrandCategoryOptions(taskType);
            this.filterBrandOptions(this.taskType, this.brandCategory);
        },

        onMachineNameChanged(machineName) {
            this.machineName = machineName;
        },

        onEquipmentTypeChanged(equipmentType) {
            this.equipmentType = equipmentType;
            this.filterEquipmentOptions(this.taskType, this.equipmentType);
        },

        onMakerChanged(maker) {
            this.maker = maker;
        },

        onBrandChanged(brand) {
            this.brand = brand;
        },

        onBrandCategoryChanged(brandCategory) {
            this.brandCategory = brandCategory;
            this.filterBrandOptions(this.taskType, this.brandCategory);
        },

        onShowTestIdChanged(showTestId) {
            this.showTestId = showTestId;
        },

        filterEquipmentOptions(taskType, equipmentType) {

            this.equipmentOptions = this.equipments;  
            if(taskType == "200" || taskType == "300") {
                this.equipmentOptions = this.equipments.filter(item => item.task_type_code == taskType);
                if(equipmentType) {
                    this.equipmentOptions = this.equipments.filter(item => {
                        return (item.task_type_code == taskType) && (item.equipment_type == equipmentType)
                    });
                }
            } else {
                if(equipmentType) {
                    this.equipmentOptions = this.equipments.filter(item => item.equipment_type == equipmentType);
                }
            }

            const foundSelectedEqItem = this.equipmentOptions.find(item => item.equipment_value == this.equipment);
            this.$nextTick(() => {
                if(!foundSelectedEqItem){ this.equipment = ""; }
            });

        },

        filterMakerOptions(taskType) {
            this.listMakerOptions = this.listMakers;  
            if(taskType == "200" || taskType == "300") {
                this.listMakerOptions = this.listMakers.filter(item => item.task_type_code == taskType);
            }
            const foundSelectedMakerItem = this.listMakerOptions.find(item => item.maker_value == this.maker);
            this.$nextTick(() => {
                if(!foundSelectedMakerItem){ this.maker = ""; }
            });
        },

        filterBrandCategoryOptions(taskType) {
            this.listBrandCategoryOptions = this.listBrandCategories;  
            if(taskType == "200") {
                this.listBrandCategoryOptions = this.listBrandCategories.filter(item => item.category_code.startsWith('C'));
            }
            if(taskType == "300") {
                this.listBrandCategoryOptions = this.listBrandCategories.filter(item => item.category_code.startsWith('F'));
            }
            const foundSelectedBrandCategoryItem = this.listBrandCategoryOptions.find(item => item.category_value == this.brandCategory);
            this.$nextTick(() => {
                if(!foundSelectedBrandCategoryItem){ this.brandCategory = ""; }
            });
        },


        filterBrandOptions(taskType, brandCategory) {
            this.listBrandOptions = this.listBrands;  
            if(brandCategory) {
                this.listBrandOptions = this.listBrands.filter(item => item.category_code == brandCategory);
            } else {
                if(taskType == "200") {
                    this.listBrandOptions = this.listBrands.filter(item => item.category_code.startsWith('C'));
                }
                if(taskType == "300") {
                    this.listBrandOptions = this.listBrands.filter(item => item.category_code.startsWith('F'));
                }
            }
            const foundSelectedBrandItem = this.listBrandOptions.find(item => item.brand_value == this.brand);
            this.$nextTick(() => {
                if(!foundSelectedBrandItem){ this.brand = ""; }
            });
        },

    }

};
</script>
