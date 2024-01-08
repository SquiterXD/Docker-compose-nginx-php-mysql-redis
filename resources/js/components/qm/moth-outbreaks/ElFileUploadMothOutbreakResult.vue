<template>
    
    <div>

        <div class="row">

            <label class="col-md-3 col-form-label"> ลงผลการตรวจสอบ </label>
            <div class="col-md-9 text-center tw-border-2 tw-border-dashed tw-border-gray-200 tw-py-4 ">

                <el-upload
                    class="upload-demo"
                    ref="upload"
                    :id="id"
                    :name="name"
                    action=""
                    :on-change="handleUploadChange"
                    :before-upload="handleBeforeUpload"
                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    :file-list="fileList"
                    :auto-upload="false"
                    :limit="1"
                    :disabled="isUploading"
                >
                    <el-button :disabled="isUploading" slot="trigger" size="medium" type="success">
                        <i class="fa fa fa-file-excel-o tw-mr-1"></i> Choose file
                    </el-button>
                    <el-button :disabled="isUploading" type="primary" size="medium" @click="submitUpload">
                        <i class="fa fa-upload tw-mr-1"></i> Upload ผลการทดสอบ
                    </el-button>
                    <div class="el-upload__tip" slot="tip">
                        รองรับ .xlsx .csv เท่านั้น
                    </div>
                </el-upload>

            </div>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL REVIEW SAMPLE RESULTS -->
        <modal-review-sample-results
            modal-name="modal-review-sample-results" 
            modal-width="1340" 
            modal-height="640"
            :locators="locators"
            :sheets="sheets"
            :sample-dates="sampleDates"
            :prepared-locators="preparedLocators"
            :samples="samples"
            :input-samples="inputSamples"
            :compared-input-samples="comparedInputSamples"
            @onSampleResultSubmitted="onSampleResultSubmitted"
        />

        <div v-show="isUploading" class="tw-mt-5">
            <p class="tw-mb-2"> Uploading ... </p>
            <el-progress :text-inside="true" :stroke-width="20" :percentage="uploadingPercentage" :status="uploadingStatus"></el-progress>
        </div>

    </div>
    
</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";
import moment from "moment";
import ModalReviewSampleResults from "./ModalReviewSampleResults";

export default {

    props: ["id", "name", "action", "locators"],

    components: { Loading, ModalReviewSampleResults },

    data() {
        return {
            isLoading: false,
            isUploading: false,
            uploadingPercentage: 0,
            uploadingStatus: "warning",
            fileList: [],
            sheets: [],
            sampleDates: [],
            preparedLocators: [],
            samples: [],
            inputSamples: [],
            comparedInputSamples: []
        };
    },

    methods: {

        submitUpload() {
            
            const formData = new FormData();
            if(this.fileList[0]) {

                // show loading
                this.isLoading = true;

                formData.append("file", this.fileList[0].raw);
                axios.post(this.action, formData).then((res) => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {

                        // swal("Success", `บันทึกผลการทดสอบการระบาดของมอดยาสูบ สำเร็จ`, "success");
                        this.showModalReviewSampleResults(resData);

                    }

                    if(resData.status == "error") {
                        swal("Error", `${resMsg}`, "error");
                    }

                    this.fileList = [];

                    this.isLoading = false;
                    
                    return resData;

                }).catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                    swal("Error", `${error.message}`, "error");
                });

            } else {
                this.isLoading = false;
                swal("Error", `กรุณาเลือกไฟล์ที่ต้องการอัพโหลด`, "error");
            }

        },
        
        handleUploadChange(file, fileList) {
            this.fileList = fileList.slice(-1);
        },

        handleBeforeUpload(file) {
            const allowedExcelMime = [
                "text/csv",
                "text/plain",
                "application/csv",
                "text/comma-separated-values",
                "application/excel",
                "application/vnd.ms-excel",
                "application/vnd.msexcel",
                "text/anytext",
                "application/octet-stream",
                "application/txt"
            ];
            if (allowedExcelMime.includes(file.type)) {
                return true;
            } else {
                this.$message.error(
                    "ประเภทไฟล์ไม่ถูกต้อง (รองรับ .xlsx .csv เท่านั้น)"
                );
                this.fileList.pop(file);
            }
        },

        showModalReviewSampleResults(resData) {

            this.inputSamples = resData.inputSamples.map(item => {
                return {
                    ...item,
                    sample_date_formatted: moment(item.sample_date).add(543, 'years').format('DD/MM/YYYY')
                }
            });

            this.samples = resData.samples.map(item => {
                return {
                    ...item,
                    sample_date_formatted: moment(item.date_drawn).add(543, 'years').format('DD/MM/YYYY')
                }
            });

            this.sheets = resData.sheets;

            this.comparedInputSamples = this.inputSamples.map(inputSample => {

                const foundSample = this.samples.find(sample => {
                    return (sample.sample_date_formatted == inputSample.sample_date_formatted && sample.locator_id == inputSample.locator_id);
                });

                const oldResultValue = foundSample ? foundSample.results[0].result_value : null;
                const resultValueHasChanged = foundSample ? (foundSample.results[0].result_value != inputSample.result_value) : true;
                return {
                    ...inputSample,
                    is_new_sample: foundSample ? false : true,
                    old_result_value: oldResultValue,
                    result_value_has_changed: resultValueHasChanged,
                    selected: !!resultValueHasChanged ? true : false,
                }

            });

            this.sampleDates = this.comparedInputSamples.map(item => {
                return {
                    sample_date_formatted: item.sample_date_formatted
                };
            }).filter((value, index, self) => {
                return (
                    index === self.findIndex(t => {
                        return t.sample_date_formatted === value.sample_date_formatted
                    })
                );
            });
            
            this.preparedLocators = this.comparedInputSamples.map(item => {
                const locatorData = this.getLocatorDesc(item);
                return {
                    locator_id: item.locator_id,
                    sheet_index: item.sheet_index,
                    sheet_name: item.sheet_name,
                    location_code: locatorData.location_code,
                    location_desc: locatorData.location_desc,
                    location_full_desc: locatorData.location_full_desc,
                };
            }).filter((value, index, self) => {
                return (
                    index === self.findIndex(t => {
                        return t.locator_id === value.locator_id
                    })
                );
            });

            window.scrollTo(0,150);

            this.$modal.show('modal-review-sample-results');

        },

        async onSampleResultSubmitted(data) {
            
            const resInputSamples = data.input_samples;
            if(resInputSamples.length > 0) {

                this.$modal.hide('modal-review-sample-results');

                // show loading
                // this.isLoading = true;
                this.isUploading = true;

                let errStoreSampleResponses = [];
                let errStoreSampleResultResponses = [];
                let errStoreSampleResultStatusResponses = [];

                let percentage = 0;
                const countSampleDates = this.sampleDates.length;

                for (let sampleDate of this.sampleDates) {

                    const sampleDateFormatted = sampleDate.sample_date_formatted
                    const filteredInputSamples = resInputSamples.filter(inputSample => inputSample.sample_date_formatted == sampleDateFormatted);
                    const resStoreSamples = await this.storeSamples(filteredInputSamples);
                    if(resStoreSamples.status == "error") { 
                        errStoreSampleResponses.push(resStoreSamples.message);
                    }

                    percentage = percentage + parseFloat(50/countSampleDates);
                    console.log("percentage : ", percentage);
                    this.uploadingPercentage = percentage;
                    this.uploadingStatus = percentage >= 49 ? "primary" : "warning";

                };

                console.log("errStoreSampleResponses : ", errStoreSampleResponses);

                if(errStoreSampleResponses.length > 0) {

                    // HIDE LOADING
                    // this.isLoading = false;
                    this.isUploading = false;

                    const resErrorMsg = errStoreSampleResponses.join(", ");
                    swal("Error", `บันทึกสร้างตัวอย่างการระบาดของมอดยาสูบ ไม่สำเร็จ : ${resErrorMsg}`, "error");

                } else {

                    for (let sampleDate of this.sampleDates) {
                        
                        const sampleDateFormatted = sampleDate.sample_date_formatted
                        const filteredInputSamples = resInputSamples.filter(inputSample => inputSample.sample_date_formatted == sampleDateFormatted);
                        const resStoreResults = await this.storeSampleResults(filteredInputSamples);
                        if(resStoreResults.status == "error") { 
                            errStoreSampleResultResponses.push(resStoreResults.message);
                        }
                        const resSetSampleResultStatuses = await this.setSampleResultStatus(filteredInputSamples);
                        if(resSetSampleResultStatuses.status == "error") { 
                            errStoreSampleResultStatusResponses.push(resSetSampleResultStatuses.message);
                        }
                        
                        percentage = percentage + parseFloat(50/countSampleDates);
                        console.log("percentage : ", percentage);
                        
                        this.uploadingPercentage = percentage;
                        this.uploadingStatus = percentage >= 99 ? "success" : "primary";

                    }

                    console.log("errStoreSampleResultResponses : ", errStoreSampleResultResponses);
                    console.log("errStoreSampleResultStatusResponses : ", errStoreSampleResultStatusResponses);

                    if(errStoreSampleResultResponses.length <= 0) {

                        setTimeout(() => {
                            this.isUploading = false;
                            this.uploadingPercentage = 0;
                            this.uploadingStatus = "warning";
                        }, 5000);

                        // SUCCESS
                        swal("Success", `บันทึกลงผลการระบาดของมอดยาสูบ`, "success");

                    } else {
                        
                        // HIDE LOADING
                        // this.isLoading = false;
                        this.isUploading = false;

                        const resErrorMsg = errStoreSampleResultResponses.join(", ");
                        swal("Error", `บันทึกลงผลการระบาดของมอดยาสูบ ไม่สำเร็จ : ${resErrorMsg}`, "error");

                    }

                }
                
                // HIDE LOADING
                this.isLoading = false;

            }

        },

        async storeSamples(inputSamples) {

            const reqBody = {
                input_samples: JSON.stringify(inputSamples)
            };

            // call store samples
            const resStoreSamples = await axios.post(`/qm/ajax/moth-outbreaks/samples`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                
                // if(resData.status == "error") {
                //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                // }
                
                return resData;

            })
            .catch((error) => {
                this.isLoading = false;
                console.log(error);
                swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${error.message}`, "error");
            });

            return resStoreSamples;

        },

        async storeSampleResults(inputSamples) {

            const reqBody = {
                input_samples: JSON.stringify(inputSamples)
            };

            // CALL STORE SAMPLE RESULTS
            const resStoreResults = await axios.post(`/qm/ajax/moth-outbreaks/results`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;

                // if(resData.status == "error") {
                //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                // }
                
                return resData;

            })
            .catch((error) => {
                // this.isLoading = false;
                this.isUploading = false;
                console.log(error);
                swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${error.message}`, "error");
            });

            if(resStoreResults.status == "success") {
                const resWebBatchNo = resStoreResults.web_batch_no ? resStoreResults.web_batch_no : null;
                const resCallPackage = await this.callPackageAddSampleResults(resWebBatchNo);
                if(resCallPackage.status == "error") {
                    return resCallPackage;
                }
            }

            return resStoreResults;

        },

        async callPackageAddSampleResults(webBatchNo) {

            const reqBody = {
                web_batch_no: webBatchNo
            };

            // CALL STORE SAMPLE RESULTS
            const resCallPackage = await axios.post(`/qm/ajax/moth-outbreaks/call-pkg-add-results`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;

                // if(resData.status == "error") {
                //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                // }
                
                return resData;

            })
            .catch((error) => {
                // this.isLoading = false;
                this.isUploading = false;
                console.log(error);
                swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${error.message}`, "error");
            });

            return resCallPackage;

        },

        async setSampleResultStatus(inputSamples) {

            const reqBody = {
                input_samples: JSON.stringify(inputSamples)
            };

            // CALL STORE SAMPLE RESULTS
            const resCallPackage = await axios.post(`/qm/ajax/moth-outbreaks/set-sample-result-status`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;

                // if(resData.status == "error") {
                //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                // }
                
                return resData;

            })
            .catch((error) => {
                // this.isLoading = false;
                this.isUploading = false;
                console.log(error);
                swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${error.message}`, "error");
            });

            return resCallPackage;

        },

        getLocatorDesc(item) {

            const foundLocator = this.locators.find(i => i.inventory_location_id == item.locator_id);
            const locationCode = foundLocator ? `${foundLocator.location_code ? foundLocator.location_code : ""}` : "";
            const locationDesc = foundLocator ? `${foundLocator.location_desc ? foundLocator.location_desc : ""}` : "";
            const locationFullDesc = foundLocator ? `${foundLocator.location_full_desc ? foundLocator.location_full_desc : ""}` : "";
            return {
                location_code: locationCode,
                location_desc: locationDesc,
                location_full_desc: locationFullDesc,
            };

        },
        
    }
};
</script>
