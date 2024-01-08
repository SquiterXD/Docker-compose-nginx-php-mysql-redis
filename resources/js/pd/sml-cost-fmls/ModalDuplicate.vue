<template>
    <span>
        <div class="modal inmodal fade" id="modal_dup" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">คัดลอกสูตร</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left" style="font-size: 14px;">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h3>ต้นฉบับ</h3>
                            </div>
                            <div class="ibox-content no-padding">
                                <div class="row">
                                    <div class="col-6 mb-2 mt-3 b-r">
                                        <div class="form-group mb-1 row">
                                            <label class="col-6 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                ประเภทยาเส้น:
                                            </label>
                                            <label class="col-5  pr-0 font-weight-boldx col-form-label">
                                                {{ header.tobacco_type_desc }}
                                            </label>
                                        </div>

                                        <div class="form-group mb-1 row">
                                            <label class="col-6 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                ประเภทสูตร:
                                            </label>
                                            <label class="col-5  pr-0 font-weight-boldx col-form-label">
                                                {{ header.formula_type }}
                                            </label>
                                        </div>

                                        <div class="form-group mb-1 row">
                                            <label class="col-6 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                ปีงบประมาณ:
                                            </label>
                                            <label class="col-5  pr-0 font-weight-boldx col-form-label">
                                                {{ header.recipe_fiscal_year }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-6 mb-2 mt-3 b-r">
                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                Blend No.
                                            </label>
                                            <label class="col-5  pr-0 font-weight-boldx col-form-label">
                                                {{ header.blend_no }}
                                            </label>
                                        </div>

                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                รหัสยาเส้น:
                                            </label>
                                            <label class="col-8  pr-0 font-weight-boldx col-form-label">
                                                {{ header.product_item_code }} : {{ header.product_item_desc }}
                                            </label>
                                        </div>

                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                รายละเอียด:
                                            </label>
                                            <label class="col-8  pr-0 font-weight-boldx col-form-label">
                                                {{ header.description }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content text-success" style="border-top: 0px;">
                                <h3 class="no-margins"><i class="fa fa-copy"></i> คัดลอก</h3>
                            </div>
                            <div class="ibox-content " style="border-top: 0px;">
                                <div class="row">
                                    <div class="col-12 mb-2 mt-3">
                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                ประเภทยาเส้น:
                                            </label>
                                            <div class="col-7 ">
                                                <el-select
                                                    :popper-append-to-body="false"
                                                    class="required"
                                                    style="width: 100%"
                                                    placeholder=""
                                                    v-model="newHeader.tobacco_type_code"
                                                    @change="(value)=>{
                                                    }"
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
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                ประเภทสูตร
                                            </label>
                                            <div class="col-7 ">
                                                <el-select
                                                    :disabled=" (newHeader.tobacco_type_code == '' )"
                                                    :popper-append-to-body="false"
                                                    style="width: 100%"
                                                    placeholder=""
                                                    v-model="newHeader.formula_type_code"
                                                    >
                                                    <el-option
                                                        v-for="(fmlType, index) in data.formula_type"
                                                        v-if="fmlType.lookup_code != header.formula_type_code"
                                                        :key="(fmlType.lookup_code)"
                                                        :label="fmlType.description"
                                                        :value="(fmlType.lookup_code)">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                Blend No.
                                            </label>
                                            <div class="col-7 ">
                                                <el-input placeholder=""
                                                    @input="v => { newHeader.blend_no = v.toUpperCase() }"
                                                    :disabled=" (newHeader.formula_type_code == '' )"
                                                    @change="(value)=>{
                                                        getProductItem()
                                                    }"
                                                    v-model="newHeader.blend_no"></el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="form-group mb-1 row">
                                            <label class="col-4 pl-0 pr-0 font-weight-bold col-form-label  text-right">
                                                ปริมาณ
                                            </label>
                                            <div class="col-4 ">
                                                <div class="input-group ">
                                                    <!-- <input class="form-control text-right " type="number" v-model.number="newHeader.quantity" /> -->
                                                    <input class="form-control text-right " type="text"
                                                        :value="newHeader.quantity | number2Digit"
                                                        @change="(event) => {
                                                            newHeader.quantity = stripNonNumber(event.target.value)
                                                            if (newHeader.quantity < 0) {
                                                                newHeader.quantity = 0
                                                            }
                                                        }"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- @click.prevent="save()" -->
                        <button  type="button" @click.prevent="duplicate()" :disabled="!can.save" :class="transBtn.save.class + ' btn-lg tw-w-25'" >
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>
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
    props:['header', 'data', "transBtn", "transDate", "url", "countOpen", "menu"],
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
            loading: {
                page: false,
                before_mount: false,
                product_item_id: false,
                duplicate: false,
            },
            can: {
                save: false,
            }
        }
    },
    mounted() {
        // if (this.budget_year) {
        //     this.getBiWeekly();
        // }
        this.newHeader = JSON.parse(JSON.stringify(this.header));
        this.newHeader.formula_type_code = '';
        // this.openModal();
    },
    computed: {
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
            // this.getParam(' ')
        },
    },
    methods: {
        stripNonNumber(text) {
          return parseFloat(text.replace(/,/g, ''));
        },
        async setdate(date) {
            let vm = this;
            vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
        },
        openModal() {
            $('#modal_dup').modal('show');
            $('.slimScroll').slimScroll({
                height: '250px',
                width: '100%'
            });
        },
        async getProductItem(isCreation = 1) {
            let vm = this;
            // reset data
            vm.data.blend_no_list = [];
            vm.data.product_item_id_list = [];
            vm.can.save = false;

            if (vm.newHeader.tobacco_type_code != '' && vm.newHeader.formula_type_code != '') {
                let params = {
                    blend_no:           vm.newHeader.blend_no,
                    tobacco_type_code:  vm.newHeader.tobacco_type_code,
                    formula_type_code:  vm.newHeader.formula_type_code,
                    is_creation:        isCreation,
                    action:             'get-blend-no',
                };

                vm.loading.product_item_id = true;
                await axios.get(vm.url.index, { params }).then(res => {
                    let response = res.data.data
                    if (response.status == 'S') {
                        // vm.data.product_item_id_list = response.product_item_id_list
                        vm.can.save = true;
                    }

                    if (response.status == 'E') {
                        swal({
                            title: "Error !",
                            text: response.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                        vm.newHeader.blend_no = '';
                    }
                    vm.loading.product_item_id = false;
                });
            }
        },
        async duplicate() {

            let vm = this;
            vm.loading.duplicate = true;
            vm.can.save = false;

            await axios.post(vm.url.ajax_store, {
                    new_header: vm.newHeader,
                    action: 'duplicate'
                })
                .then(res => {
                    let data = res.data.data;
                    if (data.status == 'S') {
                        swal({
                            title: '&nbsp;',
                            text: 'บันทึกข้อมูลสำเร็จ',
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
                    vm.loading.duplicate = false;
                    vm.can.save = true;
                });
        },
        async selectRow(reqHeader) {
            $('#modal_dup').modal('hide');
            this.$emit("selectRow", reqHeader);
        },
    }
}
</script>