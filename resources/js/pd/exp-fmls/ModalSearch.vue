<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหา</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left"  v-loading="getParamlLoading">
                        <div class="row col-12" v-if="false">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ยาเส้นปรุง Blend No. :</label>
                                <div class="input-group ">
                                    <!-- <input autocomplete="off" id="lb-2" type="text" class="form-control" name="blend_no"
                                       v-model="blendNo"/> -->

                                    <el-select
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
                                    </el-select>
                                </div>
                            </div>

                            <!-- :popper-append-to-body="false" -->

                            <!-- <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ส่งผลผลิต :</label>
                                <div class="input-group ">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="transactionDateFormat"
                                        :format="transDate['js-format']"
                                        @dateWasSelected="setdate(...arguments)"
                                        />
                                </div>
                            </div> -->

                            <div class="form-group text-right  pr-2 mb-0 col-lg-5 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
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

                                    <!-- <el-input  @input="v => { header.blend_no = v.toUpperCase() }" v-model="newHeader.blend_no"></el-input> -->
                                    <el-select
                                         clearable
                                          style="width: 100%"
                                          v-model="newHeader.blend_no"
                                          placeholder="โปรดเลือก ยาเส้นปรุง Blend No."
                                          :loading="getParamlLoading"
                                          :popper-append-to-body="false"
                                          filterable remote
                                          :remote-method="getParam"
                                          @change="getParam(newHeader.blend_no)"
                                          
                                        >
                                      <el-option
                                        v-for="item in inputParams.blend_no_list"
                                        :key="item.blend_no"
                                        :label="item.blend_no"
                                        :value="item.blend_no"
                                      ></el-option>
                                    </el-select>
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
                                        @change="getParam(newHeader.blend_no,newHeader.tobacco_type_code,newHeader.formula_type_code,newHeader.formula_status,newHeader.recipe_fiscal_year,'search')"
                                        >
                                        <el-option
                                            v-for="item in data.tobacco_type_code_list"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="(item.value)"
                                            v-show="canShow('tobacco_type_code', item.value)">
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
                                        clearable
                                        @change="(value)=>{
                                            checkFmlType()
                                            defRecipeFiscalYear()
                                            getParam(newHeader.blend_no,newHeader.tobacco_type_code,newHeader.formula_type_code,newHeader.formula_status,newHeader.recipe_fiscal_year,'search');
                                        }"
    
                                        >
                                        <el-option
                                            v-for="(fmlType, index) in data.formula_type"
                                            :key="(fmlType.lookup_code)"
                                            :label="fmlType.description"
                                            :value="(fmlType.lookup_code)"
                                            v-show="canShow('formula_type_code', fmlType.lookup_code)">
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
                                        :popper-append-to-body="false"
                                        v-model="newHeader.recipe_fiscal_year"
                                        @change="(value)=>{
                                            getParam(newHeader.blend_no,newHeader.tobacco_type_code,newHeader.formula_type_code,newHeader.formula_status,newHeader.recipe_fiscal_year,'search');
                                        }"
                                        >
                                        <template v-if="newHeader.recipe_fiscal_year != '' && newHeader.recipe_fiscal_year != null">
                                            <el-option
                                                v-for="(item, index) in data.recipe_fiscal_year_list"
                                                v-if="item.value >= newHeader.recipe_fiscal_year"
                                                :key="(item.value)"
                                                :label="item.value"
                                                :value="(item.value)"
                                                v-show="canShow('recipe_fiscal_year_list', item.value)">
                                            </el-option>
                                        </template>
                                        <template v-else>
                                            <el-option
                                                v-for="(item, index) in data.recipe_fiscal_year_list"
                                                :key="(item.value)"
                                                :label="item.value"
                                                :value="(item.value)"
                                                v-show="canShow('recipe_fiscal_year_list', item.value)">
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
                                        clearable
                                        style="width: 100%"
                                        placeholder=""
                                        :popper-append-to-body="false"
                                        value-key="formula_status"
                                        v-model="newHeader.formula_status"
                                        @change="getParam(newHeader.blend_no,newHeader.tobacco_type_code,newHeader.formula_type_code,newHeader.formula_status,newHeader.recipe_fiscal_year,'search')"
                                        >
                                        <el-option
                                            v-for="(item, index) in data.status_list"
                                            :key="index"
                                            :label="item"
                                            :value="index"
                                            v-show="canShow('status_list', index)">
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
                                    <button type="button" @click="resetForm" :class="transBtn.reset.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.reset.icon"></i>
                                        {{ transBtn.reset.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                                    <th width="90px" class="text-center">วันที่อนุมัติ</th>
                                                    <th width="150px" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(line, index) in requestHeaders" @click="selectRow(line)">
                                                    <td class="text-center">{{ line.tobacco_type_desc }}</td>
                                                    <td class="text-center">{{ line.formula_type }}</td>
                                                    <!-- <td class="text-center">{{ line.formula_vers }}</td> -->
                                                    <td class="text-center">{{ line.recipe_fiscal_year }}</td>
                                                    <td :title="'version: ' + line.formula_vers">{{ line.blend_no }}</td>
                                                    <td class="text-center">{{ line.formula_status }}</td>
                                                    <td class="text-center">{{ line.formula_approval_date_format }}</td>
                                                    <td class="text-right">
                                                        <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                            @click="selectRow(line)">
                                                            <i :class="transBtn.detail.icon"></i>
                                                            {{ transBtn.detail.text }}
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
            canSearch: [],
            defaultCanSearch : [],
            defaultCanSearchฺBlend: []
        }
    },
    beforeMount() {
        this.newHeader = JSON.parse(JSON.stringify(this.header));
        this.newHeader.blend_no = '';
        // this.newHeader.formula_type_code = 'A';
        // default ค่าว่าง  === > tanz
        // this.newHeader.formula_status = '';
        // this.newHeader.formula_type_code = '';
        this.checkFmlType()
    },
    mounted() {
        // this.resetForm();
        // this.newHeader.formula_status = '';
        // this.newHeader.formula_type_code = '';

        this.newHeader.blend_no             = ''; 
        this.newHeader.tobacco_type_code    = '';         
        this.newHeader.formula_type_code    = '';         
        this.newHeader.recipe_fiscal_year   = '';         
        this.newHeader.formula_status       = '';
        // if (this.budget_year) {
        //     this.getBiWeekly();
        // }
        // this.openModal();
    },
    computed: {
        // blendLists(){
        //     return this.inputParams.blend_no_list;
        // }
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
                vm.newHeader.recipe_fiscal_year = '';  // แก้ type สูตรมาตรฐาน ไม่ต้อง defaul ปี
                // if (vm.newHeader.can.is_standart_formula_type) {
                //     vm.newHeader.recipe_fiscal_year = vm.newHeader.recipe_fiscal_year ? vm.newHeader.recipe_fiscal_year : vm.newHeader.def_recipe_fiscal_year;
                // } else {
                //     vm.newHeader.recipe_fiscal_year = vm.newHeader.recipe_fiscal_year ? vm.newHeader.recipe_fiscal_year : '';
                // }
            } else {
                vm.newHeader.recipe_fiscal_year = '';  // แก้ type สูตรมาตรฐาน ไม่ต้อง defaul ปี
                // if (vm.newHeader.can.is_standart_formula_type) {
                //     vm.newHeader.recipe_fiscal_year = vm.newHeader.recipe_fiscal_year ? vm.newHeader.recipe_fiscal_year : vm.newHeader.def_recipe_fiscal_year;
                // } else {
                //     vm.newHeader.recipe_fiscal_year = '';
                // }
            }

        },
        async setdate(date) {
            let vm = this;
            vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
        },
        openModal() {
            $('#modal_search').modal('show');
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
            $('#modal_search').modal('hide');
            this.requestHeaders = [];
            this.$emit("selectRow", reqHeader);
        },
        async searchForm() {
            this.search({
                action: 'search',
                // blend_no: this.blendNo,
                // formula_type_code: this.header.formula_type_code
                blend_no: this.newHeader.blend_no,
                tobacco_type_code: this.newHeader.tobacco_type_code,
                formula_type_code: this.newHeader.formula_type_code,
                recipe_fiscal_year: this.newHeader.recipe_fiscal_year,
                formula_status: this.newHeader.formula_status,
            });
        },
        async getParam(query,tobacco_type=null,f_type_code=null, f_status=null,year=null,action=null) {

            let vm = this;
            if(action != null){
                vm.getParamlLoading = true;
            }
            vm.defaultCanSearchฺBlend = []

            if(action==null){
                var params = {
                    action: 'search-get-param',
                    // blend_no: vm.blendNo,
                    blend_no: query,
                    tobacco_type_code: vm.newHeader.tobacco_type_code,
                    formula_type_code:vm.newHeader.formula_type_code,
                    formula_status: vm.newHeader.formula_status,
                    recipe_fiscal_year: vm.newHeader.recipe_fiscal_year
                }
            } else {
                var params = {
                    action: 'search-get-param',
                    // blend_no: vm.blendNo,
                    blend_no: query,
                    tobacco_type_code: tobacco_type,
                    formula_type_code:f_type_code,
                    formula_status: f_status,
                    recipe_fiscal_year: year
                }
            }


            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.getParamlLoading = false;
                vm.inputParams.blend_no_list    = response.blend_no_list;
                vm.canSearch                    = response.can_search
                vm.defaultCanSearchฺBlend        = response.default_can_searchฺ_blend

                // if(action=='search' & vm.newHeader.formula_type_code != 'S'){
                //     vm.newHeader.blend_no = ''
                // } 

            }).then(() => {
                // if(vm.newHeader.blend_no){
                //     vm.newHeader.formula_status     = vm.defaultCanSearchฺBlend.formula_status
                //     vm.newHeader.formula_type_code  = vm.defaultCanSearchฺBlend.formula_type_code
                //     vm.newHeader.recipe_fiscal_year = vm.defaultCanSearchฺBlend.recipe_fiscal_year
                //     vm.newHeader.tobacco_type_code  = vm.defaultCanSearchฺBlend.tobacco_type_code
                //     vm.newHeader.can.is_standart_formula_type   = vm.defaultCanSearchฺBlend.type_s;
                // }
            });
        }, 

        canShow(type, value){
            // return true
            let vm = this;

            if(!vm.canSearch || vm.canSearch=='undefined' || vm.canSearch== '' || Object.keys(vm.canSearch).length ==0){
                return true
            }

            if(type=='tobacco_type_code'){
                let check =  vm.canSearch.tobacco_type_code.find(item => { 
                    return item == value;
                })  
                if(!check || check=='undefined'){
                    return false
                }
            }

            if(type=='formula_type_code'){
                let check =  vm.canSearch.formula_type_code.find(item => { 
                    return item == value;
                })  
                if(!check || check=='undefined'){
                    return false
                }
            }

            if(type=='status_list'){
                let check =  vm.canSearch.formula_status.find(item => { 
                    return item.toUpperCase() == value.toUpperCase();
                })  
                if(!check || check=='undefined'){
                    return false
                }
            }

            if(type=='recipe_fiscal_year_list'){
                let check =  vm.canSearch.recipe_fiscal_year.find(item => { 
                    return item == value;
                })  
                if(!check || check=='undefined'){
                    return false
                }
            }

            return true
        },
        resetForm(){
            this.newHeader.blend_no             = ''; 
            this.newHeader.tobacco_type_code    = '';         
            this.newHeader.formula_type_code    = '';         
            this.newHeader.recipe_fiscal_year   = '';         
            this.newHeader.formula_status       = '';
            this.newHeader.can.is_standart_formula_type = false;
            
            this.getParam(' ')

            this.requestHeaders = []
            this.defaultCanSearchฺBlend = []
            
        }
        
    }
}
</script>