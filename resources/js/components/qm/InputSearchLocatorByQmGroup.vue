<template>

    <div class="col-12">
        <div class="row form-group">
            <label class="col-md-4 col-form-label">กลุ่มงาน <span class="text-danger">*</span></label>
            <div class="col-md-8">
                <qm-el-select   name="qm_group_from" 
                                id="input_qm_group_from" 
                                option-key="qm_group_value"
                                option-value="qm_group_value" 
                                option-label="qm_group_label" 
                                :select-options="qmGroupOptions" 
                                :value="qmGroupFrom" 
                                @onSelected="onQmGroupFromWasSelected" 
                                :clearable="true" 
                                :filterable="true" />
                <!-- <qm-el-select   name="qm_group_from" 
                                id="input_qm_group_from" 
                                option-key="qm_group_value"
                                option-value="qm_group_value" 
                                option-label="qm_group_label" 
                                :select-options="qmGroupOptions" 
                                :value="qmGroupFrom" 
                                :clearable="true" 
                                :filterable="true" /> -->
            </div>
            <!-- <div class="col-md-4">
                <qm-el-select name="qm_group_to" id="input_qm_group_to" option-key="qm_group_value"
                    option-value="qm_group_value" option-label="qm_group_label" 
                    :select-options="qmGroupOptions" :value="qmGroupTo" @onSelected="onQmGroupToWasSelected" 
                    :clearable="true" :filterable="true" />
            </div> -->
        </div>

        <div class="row form-group">
            <label class="col-md-4 col-form-label">จุดตรวจสอบ <span class="text-danger">*</span></label>
            <div class="col-md-8">
                <!-- <qm-el-select   name="locator_id" 
                                id="input_locator_id" 
                                option-key="inventory_location_id"
                                option-value="inventory_location_id" 
                                option-label="location_full_desc"
                                :select-options="locatorOptions" 
                                :value="locator" 
                                @onSelected="onLocatorWasSelected"
                                :clearable="true" 
                                :filterable="true" /> -->
                <qm-el-select   name="locator_id" 
                                id="input_locator_id" 
                                option-key="inventory_location_id"
                                option-value="inventory_location_id" 
                                option-label="location_full_desc"
                                :select-options="locatorOptions" 
                                :value="locator" 
                                :clearable="true" 
                                :filterable="true" />
            </div>
        </div>
    </div>

</template>

<script>
export default {

    props: [
        "qmGroups",
        "locators",
        "qmGroupFromValue",
        "qmGroupToValue",
        "locatorValue"
    ],

    mounted() {
        
    },

    data() {
        return {
            qmGroupFrom: this.qmGroupFromValue,
            // qmGroupTo: this.qmGroupToValue,
            locator: this.locatorValue,
            qmGroupOptions: this.qmGroups,
            locatorOptions: (this.qmGroupFromValue || this.qmGroupToValue) ? this.getLocatorOptions(this.qmGroupFromValue, this.qmGroupToValue) : []
        };
    },

    methods: {

        getLocatorOptions(qmGroupFrom) {
            const locatorQmGroupFromOptions = qmGroupFrom ? this.locators.filter(item => item.qm_group == qmGroupFrom) : [];
            const resultOptions = [
                ...locatorQmGroupFromOptions
            ].filter((value, index, self) => {
                return index === self.findIndex(item => item.inventory_location_id === value.inventory_location_id);
            }).sort((a, b) => {
                return a.location_desc - b.location_desc;
            });

            return resultOptions;
        },

        onQmGroupFromWasSelected(value) {
            this.qmGroupFrom = value;
            this.locatorOptions = this.getLocatorOptions(value);
            if(!this.locator || !this.locatorOptions.find(item => item.inventory_location_id == this.locator)){
                this.locator = null;
            }
        },

        // getLocatorOptions(qmGroupFrom, qmGroupTo) {
        //     console.log(qmGroupFrom, qmGroupTo);
        //     const locatorQmGroupFromOptions = qmGroupFrom ? this.locators.filter(item => item.qm_group == qmGroupFrom) : [];
        //     const locatorQmGroupToOptions = qmGroupTo ? this.locators.filter(item => item.qm_group == qmGroupTo) : [];
        //     const resultOptions = [
        //         ...locatorQmGroupFromOptions,
        //         ...locatorQmGroupToOptions,
        //     ].filter((value, index, self) => {
        //         return index === self.findIndex(item => item.inventory_location_id === value.inventory_location_id);
        //     }).sort((a, b) => {
        //         return a.location_desc - b.location_desc;
        //     });

        //     return resultOptions;
        // },

        // onQmGroupFromWasSelected(value) {
        //     this.qmGroupFrom = value;
        //     this.locatorOptions = this.getLocatorOptions(value, this.qmGroupTo);
        //     if(!this.locator || !this.locatorOptions.find(item => item.inventory_location_id == this.locator)){
        //         this.locator = null;
        //     }
        // },

        // onQmGroupToWasSelected(value) {
        //     this.qmGroupTo = value;
        //     this.locatorOptions = this.getLocatorOptions(this.qmGroupFrom, value);
        //     if(!this.locator || !this.locatorOptions.find(item => item.inventory_location_id == this.locator)){
        //         this.locator = null;
        //     }
        // },

        // onLocatorWasSelected(value) {
        //     this.locator = value;
        // }

    }
};
</script>
