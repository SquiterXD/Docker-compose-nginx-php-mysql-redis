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
        >

            <div class="p-4 text-left">
                
                <h3 class="text-left"> ดูแนบรูปภาพ </h3>
                <hr class="tw-mt-1">

                <div style="min-height: 300px;">
                
                    <div v-for="(uploadedImage, i) in sampleResultLineData.uploadedImages" :key="i" class="tw-py-2" style="border-bottom: 1px solid #f0f0f0;">
                        <a class="tw-inline-block" 
                            :href="`/qm/files/image/qm/finished-products/result-quality-line/${uploadedImage.file_name}`" 
                            target="_blank">
                            <span class="fa fa-picture-o tw-mr-1"></span> {{ uploadedImage.attribute1 }}
                        </a>
                        <button type="button" class="btn btn-xs btn-outline tw-text-red-700 fa fa-times tw-pt-0" style="font-size: .9rem;"
                            @click="onDeleteResultLineImage(i)">
                        </button>
                    </div>

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
        "sampleResultLine",
    ],

    components: { Loading },

    watch: {

        sampleResultLine : function (data) {
            this.sampleResultLineData = data ? data : null;
        },
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            sampleResultLineData: this.sampleResultLine ? this.sampleResultLine : null,
        };
    },

    created() {

        this.handleResize();

    },

    mounted() {

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

        async onDeleteResultLineImage(imageIndex) {

            const uploadedImage = {
                ...this.sampleResultLineData.uploadedImages[imageIndex]
            }

            await this.deleteResultLineImage(this.sampleResultLineData, uploadedImage);

            this.sampleResultLineData.uploadedImages.splice(imageIndex, 1);

            this.$emit("onModalResultLineImageChanged", {
                sampleResultLine: this.sampleResultLineData,
            });

        },

        async deleteResultLineImage(sampleResultLine, uploadedImage) {

            const reqBody = {
                sample_result_line: JSON.stringify(sampleResultLine),
                uploaded_image: JSON.stringify(uploadedImage),
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/qm/ajax/finished-products/delete-result-quality-line-image`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("Success", `ลบรูปภาพ: ${uploadedImage.attribute1}`, "success");
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ลบรูปภาพ: ${uploadedImage.attribute1} | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                swal("Error", `ไม่สามารถ ลบรูปภาพ: ${uploadedImage.attribute1} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

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
