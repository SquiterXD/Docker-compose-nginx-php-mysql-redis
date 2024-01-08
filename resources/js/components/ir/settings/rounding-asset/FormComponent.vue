<template>
    <div id="submitForm">
        <el-form :model="form"
                 ref="save_data"
                 label-width="120px"
                 class="demo-dynamic form_table_line">
            <div>
                <div class="row">
                    <label class="col-md-4 col-form-label lable_align"><strong>กรมธรรม์ชุดที่ (Policy No)<span class="text-danger">*</span></strong></label>
                    <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                        <el-form-item :prop="'policy_set_header_id'" :rules="rules.policy_set_header_id">
                            <input type="hidden" name="policy_set_header_id" :value="form.policy_set_header_id">
                            <el-select  v-model="form.policy_set_header_id"
                                        placeholder="กรมธรรม์"
                                        remote
                                        clearable
                                        filterable
                                        @change="getPolicyDetail(); getAssetList()"
                                        :disabled="isEdit">
                                <el-option  v-for="(data, index) in policyLists"
                                            :key="index"
                                            :label="data.policy_set_number"
                                            :value="data.policy_set_header_id">
                                    <span style="float: left">{{ data.policy_set_number }}</span>
                                    <span style="float: left;"> : {{ data.policy_set_description }}</span>
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 col-form-label lable_align"><strong>คำอธิบายกรมธรรม์ชุดที่ (Policy Description)</strong></label>
                    <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                        <el-form-item>
                            <el-input type="text" name="policy_set_description" ref="policy_set_description" v-model="form.policy_set_description" placeholder="คำอธิบายกรมธรรม์" autocomplete="off" disabled></el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-4 col-form-label lable_align"><strong>รหัสทรัพย์สิน (Asset Number)<span class="text-danger">*</span></strong></label>
                    <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                        <el-form-item :prop="'asset_id'" :rules="rules.asset_id">
                            <input type="hidden" name="asset_id" :value="form.asset_id">
                            <el-select  v-model="form.asset_id"
                                        placeholder="รหัสทรัพย์สิน"
                                        remote
                                        clearable
                                        filterable
                                        :disabled="assetDisable"
                                        :remote-method="getAssetList"
                                        @change="getAssetList(form.asset_id); getAssetDetail();">
                                <el-option  v-for="(data, index) in assetList"
                                            :key="index"
                                            :label="data.asset_number"
                                            :value="data.asset_id">
                                            <span style="float: left">{{ data.asset_number }}</span>
                                    <span style="float: left;"> : {{ data.description }}</span>
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 col-form-label lable_align"><strong>คำอธิบายรหัสทรัพย์สิน (Asset Description)</strong></label>
                    <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                        <el-form-item>
                            <el-input type="text" name="asset_name" ref="asset_name" v-model="form.asset_name" placeholder="คำอธิบายรหัสทรัพย์สิน" autocomplete="off" disabled></el-input>
                        </el-form-item>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 text-right">
                        <!-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                        <a :href="this.urlReset" type="button" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i> ยกเลิก </a> -->
                        <button type="button" class="btn btn-sm btn-primary" @click="clickSave">
                            <i class="fa fa-save"></i> บันทึก
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" @click="clickCancel">
                            ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
        </el-form>
    </div>
</template>

<script>
export default {
    props: ['policyLists', 'defaultValue', 'urlSave', 'urlReset'],
    data() {
        return {
            csrf:   document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            isEdit: this.defaultValue ? true : false,

            form: {
                policy_set_header_id:    '',
                policy_set_description:  '',
                asset_id:                '',
                asset_name:              '',
            },
            rules: {
                policy_set_header_id: [
                    { required: true, message: 'กรุณาระบุ กรมธรรม์', trigger: "blur"}
                ],
                asset_id: [
                    { required: true, message: 'กรุณาระบุ รหัสทรัพย์สิน', trigger: "blur"}
                ],
            },

            assetList: [],
            assetDisable: true,
        }
    },
    mounted (){
        if (this.defaultValue) {
            this.form.policy_set_header_id = this.defaultValue.policy_set_header_id;
            this.form.asset_id             = Number(this.defaultValue.asset_id);

            this.getPolicyDetail();
            this.getAssetList(this.form.asset_id);
        }
    },
    methods: {
        async getAssetList(query) {

            if (this.form.policy_set_header_id) {
                this.assetList = [];
                await axios.get("/ir/ajax/rounding-asset/get-asset", {
                    params: {
                        query:  query,
                        policy_set_header_id: this.form.policy_set_header_id,
                        asset_id: this.form.asset_id
                    }
                })
                .then(res => {
                    this.assetDisable = false;
                    this.assetList    = res.data;
                });
            } else {
                this.assetList = [];
                this.form.asset_id = '';
                this.assetDisable = true;
            }
            if (this.form.asset_id) {
                this.getAssetDetail();
            }
        },
        getPolicyDetail(){
            this.form.policy_set_description = '';

            if (this.form.policy_set_header_id) {
                var check = this.policyLists.find((list)=>{
                    return list.policy_set_header_id == this.form.policy_set_header_id;
                });

                this.form.policy_set_description = check.policy_set_description
            }
        },
        getAssetDetail(){
            this.form.asset_name = '';

            console.log('getAssetDetail <-->  ', this.form.asset_id);

            if (this.form.asset_id) {
                console.log('getAssetDetail <-->  ', this.assetList);
                
                var check = this.assetList.find((list)=>{
                    return list.asset_id == this.form.asset_id;
                });

                this.form.asset_name = check ? check.description : '';
            }
        },
        clickSave(){
                if (this.isEdit) {
                    this.clickUpdate();
                }else {
                    this.clickCreate();
                }
        },
        clickCreate(){
            let vm = this;

            this.$refs.save_data.validate((valid) => {
                if (valid) {
                    let params = {
                        form: vm.form,
                    };
                    axios.post("/ir/settings/rounding-asset", params)
                    .then(res => {
                        swal({
                            title: "Success",
                            text: "บันทึกข้อมูลเรียบร้อยแล้ว",
                            type: "success",
                            showConfirmButton: true,
                        }, (isConfirm) => {
                            window.location.href = '/ir/settings/rounding-asset';
                        });
                    })
                    .catch(err => {
                        swal({
                            title: "Warning",
                            text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                            type: "warning",
                            showCancelButton: false,
                        });
                    })
                    .then(() => {
                        vm.loading = false;
                    });
                }
            })
        },
        clickUpdate(){
            let vm = this;

            this.$refs.save_data.validate((valid) => {
                if (valid) {
                    let params = {
                        form: vm.form,
                    };
                    axios.put(vm.urlSave, params)
                    .then(res => {
                        swal({
                            title: "Success",
                            text: "บันทึกข้อมูลเรียบร้อยแล้ว",
                            type: "success",
                            showConfirmButton: true,
                        }, (isConfirm) => {
                            window.location.href = '/ir/settings/rounding-asset';
                        });
                    })
                    .catch(err => {
                        swal({
                            title: "Warning",
                            text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                            type: "warning",
                            showCancelButton: false,
                        });
                    })
                    .then(() => {
                        vm.loading = false;
                    });
                }
            })
        },
        clickCancel(){
            window.location.href = '/ir/settings/rounding-asset';
        },
    },
}
</script>
<style lang="scss" scoped>
.error-message {
    display: flex;
    color: #ec4958;
    margin-top: 5px;

    strong {
        margin-right: 5px;
    }
}
</style>