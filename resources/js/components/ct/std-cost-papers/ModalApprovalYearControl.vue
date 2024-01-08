<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.3"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> สถานะกระดาษทำการ </h4>
                <hr>

                <div class="tw-p-4">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ปีบัญชีงบประมาณ : </label>

                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" v-model="periodYearThai" readonly>
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนผลิตครั้งที่ : </label>

                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" v-model="planVersionNo" readonly>
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ครั้งที่ :  </label>

                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" v-model="versionNo" readonly>
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ศูนย์ต้นทุน : </label>

                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" v-model="costCodeFullDesc" readonly>
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> สถานะ :  </label>

                        <div class="col-md-8">

                            <pm-el-select name="approved_status" id="input_approved_status" 
                                :select-options="approvedStatuses"
                                option-key="value"
                                option-value="value" 
                                option-label="label" 
                                :value="approvedStatus"
                                :filterable="true"
                                @onSelected="onApprovedStatusChanged"
                            />
                            
                        </div>

                    </div>

                </div>

                <hr>

                <div class="text-right tw-mt-4">

                    <button type="button" 
                        @click="onSaveApprovedStatus" 
                        class="btn btn-primary tw-w-32"> 
                        บันทึก 
                    </button>

                    <button type="button" 
                        @click="$modal.hide(modalName)" 
                        class="btn btn-link"> 
                        ยกเลิก 
                    </button>
                    
                </div>

            </div>

        </modal>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight",
        "yearControlItem",
        "approvedStatuses",
    ],

    components: { Loading },

    watch: {
        
        yearControlItem : function (value) {
            this.yearControl = value;
            this.approvedStatus = value.approved_status;
            this.periodYearThai = value ? value.period_year_thai : '-',
            this.planVersionNo = value ? value.plan_version_no : '-',
            this.versionNo = value ? value.ct14_last_version_no : '-',
            this.costCodeFullDesc = `${value.cost_code} : ${value.cost_description}`;
        },

    },

    mounted() {
        
        if(this.yearControl) {

            this.approvedStatus = this.yearControl.approved_status ;
            this.approvedStatusLabel = this.getApprovedStatusLabel(this.approvedStatus);
        }

    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            yearControl: this.yearControlItem,
            periodYearThai: this.yearControlItem ? this.yearControlItem.period_year_thai : '-',
            planVersionNo: this.yearControlItem ? this.yearControlItem.plan_version_no : '-',
            versionNo: this.yearControlItem ? this.yearControlItem.ct14_last_version_no : '-',
            costCodeFullDesc: this.yearControlItem ? `${this.yearControlItem.cost_code} : ${this.yearControlItem.cost_description}` : '',
            approvedStatus: this.yearControlItem ? this.yearControlItem.approved_status : "Inactive",
            approvedStatusLabel: this.getApprovedStatusLabel(this.yearControlItem ? this.yearControlItem.approved_status : "Inactive"),
            
        };
    },

    created() {
        this.handleResize();
    },

    methods: {

        handleResize() {
            if (window.innerWidth < 768) {
                // set modal width = 90% when screen width < 769px
                this.width = "90%";
            } else if (window.innerWidth < 992) {
                // set modal width = 80% when screen width < 992px
                this.width = "80%";
            } else {
                this.width = this.modalWidth;
            }
        },

        async onApprovedStatusChanged(value) {

            this.approvedStatus = value;
            this.approvedStatusLabel = this.getApprovedStatusLabel(this.approvedStatus);

        },

        getApprovedStatusLabel(approvedStatus) {
            const foundApprovedStatus = this.approvedStatuses.find(item => item.value == approvedStatus);
            return foundApprovedStatus ? foundApprovedStatus.label : "";
        },

        onSaveApprovedStatus() {
            this.$modal.hide(this.modalName);
            this.$emit("onSaveApprovedStatus", {
                year_control: this.yearControl,
                approved_status: this.approvedStatus,
            });
        },

    }
};
</script>
<style scoped>
.v--modal-overlay {
  z-index: 2000;
  padding-top: 3rem;
  padding-bottom: 3rem;
}
.vm--overlay[data-modal="modal-search-allocate-year"] {
    height: 100% !important;
}
</style>