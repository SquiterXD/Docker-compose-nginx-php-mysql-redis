<!--suppress JSUnresolvedVariable -->
<template>
    <div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-12">

<!--                    <div class="ibox form-group row">-->
<!--                        <pre class="col-lg-6" style="display: block">{{-->
<!--                                JSON.stringify({-->
<!--                                    rawMaterialId, rawMaterial,-->
<!--                                }, null, 2)-->
<!--                            }}-->
<!--                        </pre>-->

<!--                        <pre class="col-lg-6" style="display: block">{{-->
<!--                                JSON.stringify({-->
<!--                                    rawMaterialOnShelfId, rawMaterialOnShelf,-->
<!--                                }, null, 2)-->
<!--                            }}-->
<!--                        </pre>-->
<!--                    </div>-->

                    <!-- หน้าจอหลัก (1) -->

                    <div class="ibox animated fadeInRight" v-if="step === 1">
                        <form>
                            <div class="ibox-content ">
                                <div class="HomeScreen fill">
                                    <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                        <h1
                                            class="font-bold p-3">
                                            ตรวจสอบวัตถุดิบ
                                        </h1>
                                        <div>
                                            <!--suppress HtmlFormInputWithoutLabel -->
                                            <input
                                                id="input-report-id"
                                                type="text"
                                                autocomplete="off"
                                                v-model="rawMaterialId"/>
                                        </div>
                                        <br/>
                                        <div class="text-center">
                                            <button
                                                type="button"
                                                class="btn btn-success col-lg-5 p-3 mb-5"
                                                @click.prevent="onScanRawMaterialClicked">
                                                <i class="fa fa-qrcode"></i>
                                                &nbsp;&nbsp;สแกนรายงาน
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- End หน้าจอหลัก -->

                    <!-- แสดงผลสแกน QR Code (3) -->
                    <div class="ibox animated fadeInRight" v-if="step === 2">
                        <div class="ibox-content ">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ผลการสแกน</h1>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                        </div>
                                        <div class="col-lg-9">
                                            <span class="form-text">
                                                {{ rawMaterial.id }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รายละเอียด</h4>
                                        </div>
                                        <div class="col-lg-9">
                                            <span class="form-text">
                                                {{ rawMaterial.description }}
                                            </span>
                                        </div>
                                    </div>

                                    <!--suppress HtmlFormInputWithoutLabel -->
                                    <input
                                        type="text"
                                        autocomplete="off"
                                        v-model="rawMaterialOnShelfId"/>

                                    <div class="form-group row text-center mt-5">
                                        <div class="col-sm-12 col-lg-6">
                                            <button
                                                class="btn btn-success col-lg-12 p-3"
                                                @click.prevent="onCompareRawMaterialClicked">

                                                <i class="fa fa-check"></i>&nbsp;ตรวจสอบวัตถุดิบ
                                            </button>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 ">
                                            <button
                                                type="button"
                                                class="btn btn-danger col-lg-12 p-3"
                                                @click.prevent="onCancelClicked">

                                                <i class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End แสดงผลสแกน QR code -->

                    <!--Compare-->
                    <div class="ibox animated fadeInRight" style="display: block" v-if="step === 3">
                        <div class="ibox-content">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ผลการตรวจสอบ</h1>

                                    <div class="form-group row text-left mb-3">
                                        <div class="col-lg-12">
                                            <h2 class="font-bold mb-3">วัตถุดิบที่ต้องใช้</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                        </div>
                                        <div class="col-lg-9">
                                            <span class="form-text">
                                                {{ rawMaterial.id }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h3 class="font-bold">รายละเอียด</h3>
                                        </div>
                                        <div class="col-lg-9">
                                            <span class="form-text">
                                                {{ rawMaterial.description }}
                                            </span>
                                        </div>
                                    </div>

                                    <!--divider-->

                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group row text-left">
                                        <div class="col-lg-12 mb-2">
                                            <h2 class="font-bold">วัตถุดิบที่ชั้นวาง</h2>
                                        </div>
                                    </div>

                                    <div
                                        class="form-group row text-left"
                                        v-if="!isRawMaterialOnShelfExist">
                                        <h4 class="font-bold" style="color:red">
                                            ไม่พบข้อมูลวัตถุดิบ
                                        </h4>
                                    </div>

                                    <div
                                        v-if="isRawMaterialOnShelfExist">

                                        <div class="form-group row text-left">
                                            <div class="col-lg-3">
                                                <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                            </div>
                                            <div class="col-lg-9">
                                            <span class="form-text">
                                                {{ rawMaterialOnShelf.id }}
                                            </span>
                                            </div>
                                        </div>

                                        <div class="form-group row text-left">
                                            <div class="col-lg-3">
                                                <h4 class="font-bold">รายละเอียด</h4>
                                            </div>
                                            <div class="col-lg-9">
                                            <span class="form-text">
                                            {{ rawMaterialOnShelf.description }}
                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="form-group row text-center mt-5"
                                        v-if="rawMaterialOnShelf.status">
                                        <div class="col-sm-12 col-lg-12 mb-3">
                                            <h3 class="green-text"><i
                                                class="fa fa-check fa-2x"></i>&nbsp;วัตถุดิบถูกต้อง</h3>
                                        </div>
                                        <div class="col-sm-12 col-lg-12">
                                            <button
                                                type="button"
                                                class="btn btn-success col-lg-6 p-3"
                                                @click.prevent="onGoToMainClicked">

                                                <i class="fa fa-home"></i>&nbsp;&nbsp;กลับหน้าจอหลัก
                                            </button>
                                        </div>
                                    </div>

                                    <div
                                        class="form-group row text-center mt-5"
                                        v-if="!rawMaterialOnShelf.status">

                                        <div class="col-sm-12 col-lg-12 mb-3 red-text">
                                            <h3><i class="fa fa-times fa-2x"></i>&nbsp;วัตถุดิบไม่ถูกต้อง</h3>

                                        </div>
                                        <div class="col-sm-12 col-lg-12">
                                            <button
                                                type="button"
                                                class="btn btn-success col-lg-6 p-3"
                                                @click.prevent="onCompareAgainClicked">

                                                <i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;ตรวจสอบใหม่อีกครั้ง
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-success col-lg-6 p-3"
                                                @click.prevent="onGoToMainClicked">

                                                <i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;กลับหน้าจอหลัก
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Compare-->
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import {instance as http} from "../httpClient";
import {$route} from "../../router";
import _get from "lodash/get";
import _isEqual from "lodash/isEqual";
import _cloneDeep from "lodash/cloneDeep";
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils";
import {showGenericFailureDialog, showLoadingDialog, showValidationFailedDialog} from "../../commonDialogs";

const STEP_HOME = 1;
const STEP_SCAN_COMPARE = 2;
const STEP_SCAN_RESULT = 3;

function getRawMaterial(id) {
    return http.get(
        $route('api.pm.transaction-pnk-check-material.rawMaterials', {
            id: id
        })
    );
}

function compareRawMaterial(rawMaterialId, onShelfRawMaterialId) {
    let queryString = {};
    queryString['rawMaterialId'] = rawMaterialId;
    queryString['onShelfRawMaterialId'] = onShelfRawMaterialId;

    return http.get(
        $route('api.pm.transaction-pnk-check-material.compareRawMaterials') + '?' +
        new URLSearchParams(queryString).toString());
}

export default {
    metaInfo: {
        title: 'ตรวจสอบวัตถุดิบ',
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },

            step: STEP_HOME,

            rawMaterialId: '',
            rawMaterialOnShelfId: '',

            rawMaterial: {},
            rawMaterialOnShelf: {},
            isRawMaterialOnShelfExist: false,
        }
    },
    props: {},
    methods: {
        validateScanRawMaterial() {
            let idValidationRules = {
                rawMaterialId: 'required|numeric',
            };
            let attributesNames = {
                rawMaterialId: 'รหัสวัตถุดิบ'
            }
            let data = {
                rawMaterialId: this.rawMaterialId,
            }

            let validatingEntries = [];
            validatingEntries.push(
                buildValidatingEntry(data, idValidationRules, attributesNames));

            let validatingResult = validateDataAgainstRules(validatingEntries);
            if (validatingResult.status) {
                return true;
            }
            showValidationFailedDialog(validatingResult.errorMessages);
            return false;
        },
        validateCompareRawMaterial() {
            let idValidationRules = {
                rawMaterialOnShelfId: 'required|numeric',
            };
            let attributesNames = {
                rawMaterialOnShelfId: 'รหัสวัตถุดิบที่ชั้นวาง'
            }
            let data = {
                rawMaterialOnShelfId: this.rawMaterialOnShelfId,
            }

            let validatingEntries = [];
            validatingEntries.push(
                buildValidatingEntry(data, idValidationRules, attributesNames));

            let validatingResult = validateDataAgainstRules(validatingEntries);
            if (validatingResult.status) {
                return true;
            }
            showValidationFailedDialog(validatingResult.errorMessages);
            return false;
        },
        onScanRawMaterialClicked() {
            let result = this.validateScanRawMaterial();
            if (!result) {
                return;
            }

            showLoadingDialog();
            getRawMaterial(this.rawMaterialId)
                .then((result) => {
                    console.debug(result);
                    swal.close();

                    this.rawMaterial = result.data;

                    //progress to next step
                    this.step = STEP_SCAN_COMPARE;
                })
                .catch((err) => {
                    console.debug(err);

                    if (err.response.status === 404) {
                        showGenericFailureDialog('ไม่พบข้อมูลวัตถุดิบ กรุณาลองใหม่อีกครั้ง');
                    } else {
                        showGenericFailureDialog();
                    }
                });
        },
        onCompareRawMaterialClicked() {
            let isValid = this.validateCompareRawMaterial();
            if (isValid) {
                showLoadingDialog();
                compareRawMaterial(this.rawMaterialId, this.rawMaterialOnShelfId)
                    .then((result) => {
                        console.debug(result);
                        swal.close();
                        this.rawMaterialOnShelf = result.data;
                        this.isRawMaterialOnShelfExist = true;

                        //display scan result
                        this.step = STEP_SCAN_RESULT;
                    })
                    .catch((err) => {
                        console.debug(err.response);
                        swal.close();

                        if (err.response.status === 404) {
                            this.isRawMaterialOnShelfExist = false;

                            //display scan result
                            this.step = STEP_SCAN_RESULT;
                        } else {
                            showGenericFailureDialog();
                        }
                    });
            }
        },
        onCompareAgainClicked() {
            this.step = STEP_SCAN_COMPARE;
        },
        goToFirstStep() {
            this.rawMaterialId = '';
            this.rawMaterialOnShelfId = '';
            this.rawMaterial = {};
            this.rawMaterialOnShelf = {};
            this.step = STEP_HOME;
        },
        onCancelClicked() {
            this.goToFirstStep();
        },
        onGoToMainClicked() {
            this.goToFirstStep();
        },
    }
}

</script>

<style scoped>
.fill {
    min-height: 60vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
