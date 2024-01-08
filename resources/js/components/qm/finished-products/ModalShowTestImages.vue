<template>

    <!-- <div style="position: fixed; z-index: 100;"> -->

    <div style="z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.45"
            :shiftY="0.3"
            @before-close="onModalClosed"
        >

            <div class="p-4 text-left">
                
                <h3 class="text-left"> ดูแนบรูปภาพ </h3>
                <hr class="tw-mt-1">

                <div v-if="testData && (testData.test_attachments).length > 0" style="min-height: 300px;">
                
                    <div v-for="(testAttachment, i) in testData.test_attachments" :key="i" class="tw-py-2" style="border-bottom: 1px solid #f0f0f0;">
                        <a v-if="testAttachment.attachment_id"
                            :href="'/qm/settings/attachments/'+ testAttachment.attachment_id + '/' + testData.test_type_code +'/imageDefineTests'"
                            class="btn btn-xs btn-outline tw-w-full tw-bg-opacity-20 tw-bg-purple-200 tw-border-purple-400 hover:tw-bg-purple-200 hover:tw-border-purple-400 tw-py-2 tw-px-5 text-left tw-font-bold tw-text-purple-600" 
                            target="_blank"
                        >
                            <span class="fa fa-picture-o tw-mr-1"></span> {{ testAttachment.file_name }}
                        </a>
                    </div>

                </div>
                <div v-else>
                    <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                </div>

                <hr class="tw-mt-1">

                <div class="text-right">
                    <button type="button" @click="$modal.hide(modalName)" class="btn btn-link"> 
                        ปิด 
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
import moment from 'moment';

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight", 
        "specifications",
        "testIdValue",
    ],

    components: { Loading },

    watch: {

        specifications : function (items) {
            this.specificationItems = items ? items : [];
            this.testData = this.getTestData(this.specificationItems, this.testId);
        },

        testIdValue : function (data) {
            this.testId = data ? data : null;
            this.testData = this.getTestData(this.specificationItems, this.testId);
        },
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            specificationItems: this.specifications ? this.specifications : [],
            testId: this.testIdVaue ? this.testIdVaue : null,
            testData: null,
        };
    },

    created() {

        this.handleResize();

    },

    mounted() {
        this.testData = this.getTestData(this.specificationItems, this.testId);
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

        getTestData(specifications, testId) {
            let result = null;
            if(specifications && testId) {
                result = specifications.find(item => item.test_id == testId);
            }
            return result;
        },

        onModalClosed(event){
            this.$emit("onModalTestImageClosed");
        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
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
</style>
