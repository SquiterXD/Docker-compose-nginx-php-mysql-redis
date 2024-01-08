<template>
    <span>
        <div class="modal inmodal fade" id="modal_copy_blend" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px; padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">คัดลอก Blend</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ยาเส้นปรุง Blend No. :</label>
                                <div class="input-group ">
                                    <!-- <el-select
                                          style="width: 100%"
                                          v-model="blendNo"
                                          placeholder="โปรดเลือก ยาเส้นปรุง Blend No."
                                          :loading="getParamlLoading"
                                          :popper-append-to-body="false"
                                          filterable remote
                                          :remote-method="getParam"
                                        >
                                      <el-option
                                        v-for="item in inputParams.blend_no_list"
                                        :key="item.blend_no"
                                        :label="item.blend_no"
                                        :value="item.blend_no"
                                      ></el-option>
                                    </el-select> -->

                                    <el-input  @input="v => { header.blend_no = v.toUpperCase() }" v-model="newHeader.blend_no"></el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ประเภทยาเส้น :</label>
                                <div class="input-group ">
                                    <el-select
                                        style="width: 100%"
                                        placeholder=""
                                        :popper-append-to-body="false"
                                        v-model="newHeader.tobacco_type_code"
                                        clearable
                                        filterable
                                        >
                                        <el-option
                                            v-for="item in data.tobacco_type_code_list"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="(item.value)">
                                            <span style="float: left">{{ item.label }}</span>
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ประเภทสูตร :</label>
                                <div class="input-group ">
                                    <!-- <input autocomplete="off" id="lb-2" type="text" class="form-control" name="blend_no"
                                       v-model="blendNo"/> -->

                                    <el-select
                                        style="width: 100%"
                                        placeholder=""
                                        value-key="formula_type_code"
                                        :popper-append-to-body="false"
                                        v-model="newHeader.formula_type_code"
                                        @change="(value)=>{
                                            checkFmlType()
                                            defRecipeFiscalYear();
                                        }"
                                        >
                                        <el-option
                                            v-for="(fmlType, index) in data.formula_type"
                                            :key="(fmlType.lookup_code)"
                                            :label="fmlType.description"
                                            :value="(fmlType.lookup_code)">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">
                                    <el-select clearable
                                        style="width: 100%"
                                        placeholder=""
                                        value-key="recipe_fiscal_year"
                                        :disabled="!(newHeader.can.is_standart_formula_type)"
                                        v-model="newHeader.recipe_fiscal_year"
                                        @change="(value)=>{
                                        }"
                                        >
                                        <template v-if="newHeader.recipe_fiscal_year != '' && newHeader.recipe_fiscal_year != null">
                                            <el-option
                                                v-for="(item, index) in data.recipe_fiscal_year_list"
                                                v-if="item.value >= newHeader.recipe_fiscal_year"
                                                :key="(item.value)"
                                                :label="item.value"
                                                :value="(item.value)">
                                            </el-option>
                                        </template>
                                        <template v-else>
                                            <el-option
                                                v-for="(item, index) in data.recipe_fiscal_year_list"
                                                :key="(item.value)"
                                                :label="item.value"
                                                :value="(item.value)">
                                            </el-option>
                                        </template>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1">สถานะ :</label>
                                <div class="input-group ">
                                    <!-- <input autocomplete="off" id="lb-2" type="text" class="form-control" name="blend_no"
                                       v-model="blendNo"/> -->


                                    <el-select
                                        style="width: 100%"
                                        placeholder=""
                                        :popper-append-to-body="false"
                                        value-key="formula_status"
                                        v-model="header.formula_status"
                                        >
                                        <el-option
                                            v-for="(item, index) in data.status_list"
                                            :key="index"
                                            :label="item"
                                            :value="index">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group text-right  pr-2 mb-0 col-lg-4 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row col-12">
                            <div class="form-group text-right  pr-2 mb-0 col-lg-5 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div> -->
                        <div class="ibox-content table-responsivex m-t mb-3 ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="slimScroll">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="90px" class="text-center">ประเภทยาเส้น</th>
                                                    <th width="90px" class="text-center">ประเภทสูตร</th>
                                                    <!-- <th width="90px" class="text-center">เวอร์ชั่น</th> -->
                                                    <th width="90px" class="text-center">ปีงบประมาณ</th>
                                                    <th width="" class="text-left">ยาเส้นปรุง Blend No.</th>
                                                    <th width="90px" class="text-center">สถานะ</th>
                                                    <!-- <th width="90px" class="text-center">วันที่อนุมัติ</th> -->
                                                    <th width="150px" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(line, index) in requestHeaders">
                                                    <td class="text-center">{{ line.tobacco_type_desc }}</td>
                                                    <td class="text-center">{{ line.formula_type }}</td>
                                                    <!-- <td class="text-center">{{ line.formula_vers }}</td> -->
                                                    <td class="text-center">{{ line.recipe_fiscal_year }}</td>
                                                    <td :title="'version: ' + line.formula_vers">{{ line.blend_no }}</td>
                                                    <td class="text-center">{{ line.formula_status }}</td>
                                                    <!-- <td class="text-center">{{ line.formula_approval_date_format }}</td> -->
                                                    <td class="text-right">
                                                        <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                            @click="checkVersion(line)">
                                                            <i :class="transBtn.detail.icon"></i>
                                                            คัดลอก
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
import moment from "moment";

export default {
    props:['header', "transBtn", "transDate", "url", "countOpen", "menu", "data"],
    data() {
        return {
            newHeader: {},
            loading: false,
            getParamlLoading: false,
            // reqHeaderHeaderId: '',
            transactionDateFormat: '',
            blendNo: '',
            requestHeaders: [],
            inputParams: {
                blend_no_list: [],
            },
        }
    },
    beforeMount() {
        this.newHeader = JSON.parse(JSON.stringify(this.header));
        this.newHeader.blend_no = '';
        this.newHeader.formula_type_code = 'A';
        this.checkFmlType()
    },
    mounted() {
    },
    computed: {
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
            this.getParam(' ')
        },
    },
    methods: {
        async checkFmlType() {
            let vm = this;
            console.log('CP checkFmlType', vm.newHeader.formula_type_code, !vm.newHeader.formula_type_code);
            if (!vm.newHeader.formula_type_code) {
                return;
            }
            let chkFormulaType = vm.data.formula_type.findIndex(o => o.lookup_code == vm.newHeader.formula_type_code);
                chkFormulaType = vm.data.formula_type[chkFormulaType];
                chkFormulaType.lookup_code != 'P'

            vm.newHeader.can.leaf_formulas.ingredient.add_lot_number = chkFormulaType.lookup_code != 'P';

            vm.newHeader.can.is_standart_formula_type = (chkFormulaType.lookup_code == 'S'); // 'สูตรมาตรฐาน'
            vm.newHeader.can.is_actual_formula_type = (chkFormulaType.lookup_code == 'A');
            vm.newHeader.can.is_chnp_formula_type = (chkFormulaType.lookup_code == 'P'); // สูตร ชนป
        },
        async defRecipeFiscalYear() {
            let vm = this;
            if (!vm.newHeader.formula_type_code) {
                return;
            }

            // if (!vm.newHeader.has_tmp_table) {
            //     return;
            // }
            let chkFormulaType = vm.data.formula_type.findIndex(o => o.lookup_code == vm.newHeader.formula_type_code);
                chkFormulaType = vm.data.formula_type[chkFormulaType];


            if (vm.newHeader.has_tmp_table) {
                if (vm.newHeader.can.is_standart_formula_type) {
                    vm.newHeader.recipe_fiscal_year = vm.newHeader.recipe_fiscal_year ? vm.newHeader.recipe_fiscal_year : vm.newHeader.def_recipe_fiscal_year;
                } else {
                    vm.newHeader.recipe_fiscal_year = vm.newHeader.recipe_fiscal_year ? vm.newHeader.recipe_fiscal_year : '';
                }
            } else {
                if (vm.newHeader.can.is_standart_formula_type) {
                    vm.newHeader.recipe_fiscal_year = vm.newHeader.recipe_fiscal_year ? vm.newHeader.recipe_fiscal_year : vm.newHeader.def_recipe_fiscal_year;
                } else {
                    vm.newHeader.recipe_fiscal_year = '';
                }
            }

        },
        async setdate(date) {
            let vm = this;
            vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
        },
        openModal() {
            $('#modal_copy_blend').modal('show');
            $('.slimScroll').slimScroll({
                height: '250px',
                width: '100%'
            });
        },
        // remoteMethod(query) {
        //     if (query !== "") {
        //         this.search({ wip_request_no: query, transaction_date: this.transactionDateFormat, action: 'search' });
        //     } else {
        //         this.requestHeaders = [];
        //     }
        // },
        search(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.requestHeaders = response.data;
            });
        },
        async selectRow(reqHeader) {
            $('#modal_copy_blend').modal('hide');
            this.requestHeaders = [];
            this.$emit("selectRow", reqHeader);
        },
        async searchForm() {
            this.search({
                blend_no: this.newHeader.blend_no,
                tobacco_type_code: this.newHeader.tobacco_type_code,
                formula_type_code: this.newHeader.formula_type_code,
                recipe_fiscal_year: this.newHeader.recipe_fiscal_year,
                formula_status: this.newHeader.formula_status,
                action: 'searchPd08',
            });
        },
        async getParam(query) {
            let vm = this;
            vm.getParamlLoading = true;

            let params = {
                action: 'search-get-param',
                // blend_no: vm.blendNo,
                blend_no: query,
            }

            axios.get(vm.url.index,
                { params }).then(res => {
                let response = res.data.data
                vm.getParamlLoading = false;
                vm.inputParams.blend_no_list = response.blend_no_list;
            });
        },
        async checkVersion(selectHeader) {
            let vm = this;
            let reqVersion = new Promise(async (resolve, reject) => {
                vm.loading = true;
                await axios.post(vm.url.ajax_store, {
                        action: 'checkVersion',
                        header: selectHeader,
                    })
                    .then(res => {
                        let data = res.data.data;
                        vm.loading = false;
                        resolve(data.header.max_version);
                    })
                    .catch(err => {
                        let data = err.response.data;
                        // alert(data.message);
                    })
                    .then(() => {
                        // vm.loading.page = false;
                    });
                vm.loading = false;
            });
            let maxVersion = await reqVersion; // wait until the promise resolves (*)
            if (parseInt(maxVersion) > 0 ) {
                confirm = await helperAlert.showProgressConfirm('Blend No.: '+ selectHeader.blend_no +' Version: '+ maxVersion + ' มีในระบบแล้วต้องการดำเนินการคัดลอก หรือไม่');
                if (confirm) {
                    await vm.storeFromPd08(selectHeader);
                }
            } else {
                await vm.storeFromPd08(selectHeader);
            }
        },
        async storeFromPd08(selectHeader) {

            let vm = this;
            vm.loading = true;

            await axios.post(vm.url.ajax_store, {
                    header: selectHeader,
                    action: 'storeFromPd08'
                })
                .then(res => {
                    let data = res.data.data;
                    if (data.status == 'S') {
                        swal({
                            title: '&nbsp;',
                            text: 'คัดลอกสูตรสำเร็จ',
                            type: "success",
                            html: true
                        });

                        vm.selectRow(data.header);
                    }

                    if (data.status != 'S') {
                        swal({
                            title: "Error !",
                            text: data.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    // alert(data.message);
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
        },
    }
}
</script>