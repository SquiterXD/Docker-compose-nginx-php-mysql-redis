<template>
    <div>
        <div class="tabs-container mb-3">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab1">
                        ประมาณการผลิตแยกรายตรา
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab2">
                        ประมาณการผลิตแยกตามกลุ่มราคา
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab3">
                        ตรวจสอบรายการ PR
                    </a>
                </li>
            </ul>
            <div class="tab-content" v-loading="">
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body ">
                        <form id="stamp-form-tab1">
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> รหัสแสตมป์ :</label>
                                    <div class="input-group ">
                                        <el-select style="width: 100%" v-model="tab1Input.stamp_code" size="large" placeholder="รหัสแสตมป์" clearable filterable ref="stamp_code_tab1" @change="selStamp">
                                            <el-option
                                               v-for="(item, index) in header.stamp_summary"
                                                :key="index"
                                                :label="index"
                                                :value="index"
                                            >
                                            <span style="float: left">{{ index }}</span>
                                            <span style="float: left; color: #8492a6;"> : {{ item[0].stamp_description }}</span>
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_stamp_code_tab1" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> &nbsp;</label>
                                    <div class="input-group ">
                                        <el-input size="llarge" :readonly="true" disabled
                                            :value="(()=>{
                                                if(!tab1Input.stamp_code) return '';
                                                let result = header.stamp_summary[tab1Input.stamp_code].find(item => item.stamp_code === tab1Input.stamp_code)
                                                if(result){
                                                    return result.stamp_description
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ม้วนละ :</label>
                                    <div class="input-group ">
                                        <el-input size="llarge" class="text-right" :readonly="true" disabled
                                            :value="(()=>{
                                                if(!tab1Input.stamp_code) return '';
                                                let result = header.stamp_summary[tab1Input.stamp_code].find(item => item.stamp_code === tab1Input.stamp_code)
                                                if(result){
                                                    return result.stamp_per_roll
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ราคาต่อดวง :</label>
                                    <div class="input-group">
                                        <el-input size="llarge" class="text-right" :readonly="true" disabled
                                            :value="(()=>{
                                                if(!tab1Input.stamp_code) return '';
                                                let result = header.stamp_summary[tab1Input.stamp_code].find(item => item.stamp_code === tab1Input.stamp_code)
                                                if(result){
                                                    return result.unit_price
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> รหัสบุหรี่ :</label>
                                    <div class="input-group ">
                                        <el-select style="width: 100%" v-model="tab1Input.cigarettes_code" size="large" placeholder="รหัสบุหรี่"  clearable filterable ref="cigarettes_code" @change="getStampDailyTab1">
                                            <el-option
                                               v-for="(item, index) in head.stamp_items_group[tab1Input.stamp_code]"
                                                :key="item.cigarettes_code"
                                                :label="item.cigarettes_code +': '+ item.cigarettes_description"
                                                :value="item.cigarettes_code"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_cigarettes_code_tab1" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ตราบุหรี่</label>
                                    <div class="input-group ">
                                        <el-input size="large" disabled :readonly="true"
                                            :value="(()=>{
                                                if(!tab1Input.stamp_code) return '';
                                                if(!tab1Input.cigarettes_code) return '';

                                                let result = head.stamp_items_group[tab1Input.stamp_code].find(item => item.cigarettes_code === tab1Input.cigarettes_code)
                                                if(result){
                                                    return result.cigarettes_description
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 pt-1">
                                    <span> <br>&nbsp; </span>
                                    <button type="button" @click.prevent="refreshStampTap1" :class="btnTrans.upload.class + ' btn-lg tw-w-25'" >
                                        อัพเดตประมาณการตัดใช้แสตมป์
                                    </button>
                                </div>
                            </div>
                            <div class="hr-line-dashed mt-3"></div>
                            <div class="m-t-lg m-b-lg" v-if="loading.stampDailyTab1Process">
                                <div class="text-center sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                            <div v-else-if="summaryDataTab1.length > 0 && !loading.stampDailyTab1Process">
                                <stamp-daily-table-tab1
                                    :header="header"
                                    :stamp="header.stamp_summary[tab1Input.stamp_code][0]"
                                    :btnTrans="btnTrans"
                                    :url="url"
                                    :summaryData="summaryDataTab1"
                                    @updateStamp="updateStamp"
                                    @validAction="validAction"
                                />
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TAB2 -->
                <div role="tabpanel" id="tab2" class="tab-pane">
                    <div class="panel-body ">
                        <!-- Stamp tab by price group -->
                        <form id="stamp-form-tab2">
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> รหัสแสตมป์ :</label>
                                    <div class="input-group ">
                                        <el-select style="width: 100%" v-model="tab2Input.stamp_code" size="large" placeholder="รหัสแสตมป์" clearable filterable ref="stamp_code_tab2" @change="getStampDailyTab2">
                                            <el-option
                                               v-for="(item, index) in header.stamp_summary"
                                                :key="index"
                                                :label="index"
                                                :value="index"
                                            >
                                            <span style="float: left">{{ index }}</span>
                                            <span style="float: left; color: #8492a6;"> : {{ item[0].stamp_description }}</span>
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_stamp_code_tab2" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> &nbsp;</label>
                                    <div class="input-group ">
                                        <el-input size="llarge" :readonly="true" disabled
                                            :value="(()=>{
                                                if(!tab2Input.stamp_code) return '';
                                                let result = header.stamp_summary[tab2Input.stamp_code].find(item => item.stamp_code === tab2Input.stamp_code)
                                                if(result){
                                                    return result.stamp_description
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ม้วนละ :</label>
                                    <div class="input-group ">
                                        <el-input size="llarge" class="text-right" :readonly="true" disabled
                                            :value="(()=>{
                                                if(!tab2Input.stamp_code) return '';
                                                let result = header.stamp_summary[tab2Input.stamp_code].find(item => item.stamp_code === tab2Input.stamp_code)
                                                if(result){
                                                    return result.stamp_per_roll
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ราคาต่อดวง :</label>
                                    <div class="input-group">
                                        <el-input size="llarge" class="text-right" :readonly="true" disabled
                                            :value="(()=>{
                                                if(!tab2Input.stamp_code) return '';
                                                let result = header.stamp_summary[tab2Input.stamp_code].find(item => item.stamp_code === tab2Input.stamp_code)
                                                if(result){
                                                    return result.unit_price
                                                }
                                            })()"
                                            > </el-input>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2 pt-1">
                                    <span> <br>&nbsp; </span>
                                    <button type="button" @click.prevent="refreshStampTap2" :class="btnTrans.upload.class + ' btn-lg tw-w-25'" >
                                        อัพเดตคงคลังแสตมป์
                                    </button>
                                </div>
                            </div>
                            <div class="hr-line-dashed mt-3"></div>
                            <div class="m-t-lg m-b-lg" v-if="loading.stampDailyTab2Process">
                                <div class="text-center sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                            <div v-else-if="summaryDataTab2.length > 0 && !loading.stampDailyTab2Process">
                                <stamp-daily-table-tab2
                                    :header="header"
                                    :stamp="tab2Input.stamp_code? header.stamp_summary[tab2Input.stamp_code][0]: ''"
                                    :btnTrans="btnTrans"
                                    :url="url"
                                    :summaryData="summaryDataTab2"
                                />
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TAB3 -->
                <div role="tabpanel" id="tab3" class="tab-pane">
                    <div class="panel-body">
                        <stamp-daily-table-tab3
                            :header="header"
                            :interfaceTemps="interfaceTemps"
                            :poLists="poLists"
                            :btnTrans="btnTrans"
                            :url="url"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StampDailyTableTab1 from './StampDailyTableTab1.vue';
    import StampDailyTableTab2 from './StampDailyTableTab2.vue';
    import StampDailyTableTab3 from './StampDailyTableTab3.vue';
    export default {
        components: {
            StampDailyTableTab1, StampDailyTableTab2, StampDailyTableTab3
        },
        props:[
            'header', 'btnTrans', 'url', 'interfaceTemps', 'poLists'
        ],
        data() {
            return {
                head: this.header,
                loading: {
                    stampDailyTab1Process: false,
                    stampDailyTab2Process: false,
                    stampDailyTab3Process: false
                },
                valid_action: false,
                stamp_code: '',
                set_stamp_code: '',
                summaryDataTab1: [],
                summaryDataTab2: [],
                summaryDataTab3: [],
                errors: {
                    stamp_code_tab1: false,
                    stamp_code_tab2: false,
                    cigarettes_code: false
                },
                tab1Input: {
                    stamp_code: '',
                    cigarettes_code: '',
                },
                tab2Input: {
                    stamp_code: '',
                    set_stamp_code: '',
                },
            }
        },
        mounted() {
            //
        },
        computed: {
        },
        watch:{
            errors: {
                handler(val){
                    val.stamp_code_tab1? this.setError('stamp_code_tab1') : this.resetError('stamp_code_tab1');
                    val.stamp_code_tab2? this.setError('stamp_code_tab2') : this.resetError('stamp_code_tab2');
                    val.cigarettes_code? this.setError('cigarettes_code') : this.resetError('cigarettes_code');
                },
                deep: true,
            },
        },
        methods: {
            selStamp(){
                if(this.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    this.stamp_code = this.set_stamp_code;
                    return;
                }
                this.summaryData = [];
                this.tab1Input.cigarettes_code = '';
                this.summaryDataTab1 = [];
            },
            updateStamp(res){
                this.valid_action = res.valid_action;
                if (res.status === 'S') {
                    this.getStampDailyTab1();
                    this.$emit("updateStamp", res.stamp_main);
                }
            },
            validAction(res){
                this.valid_action = res;
            },
            async getStampDailyTab1() {
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                let form = $('#stamp-form-tab1');
                let valid = true;
                let errorMsg = '';
                vm.errors.stamp_code_tab1 = false;
                vm.errors.cigarettes_code = false;
                $(form).find("div[id='el_explode_stamp_code_tab1']").html("");
                $(form).find("div[id='el_explode_cigarettes_code_tab1']").html("");
                if (vm.tab1Input.stamp_code == '' || vm.tab1Input.stamp_code == null){
                    vm.errors.stamp_code_tab1 = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกรหัสแสตมป์";
                    $(form).find("div[id='el_explode_stamp_code_tab1']").html(errorMsg);
                }
                if (vm.tab1Input.cigarettes_code == '' || vm.tab1Input.cigarettes_code == null){
                    vm.errors.cigarettes_code = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกรหัสบุหรี่";
                    $(form).find("div[id='el_explode_cigarettes_code_tab1']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                let stampId = vm.header.stamp_summary[vm.tab1Input.stamp_code][0].follow_stamp_id;
                vm.set_stamp_code = this.tab1Input.stamp_code;
                vm.summaryData = '';
                vm.loading.stampDailyTab1Process = true;
                await axios.get(vm.url.ajax_get_stamp_daily_tab1, {
                    params: {
                        follow_stamp_main_id: vm.header.follow_stamp_main_id,
                        stamp_code: vm.tab1Input.stamp_code,
                        cigarettes_code: vm.tab1Input.cigarettes_code
                    }
                })
               .then(res => {
                    vm.summaryDataTab1 = res.data.data.stampDaily;
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">'+data.message+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading.stampDailyTab1Process = false;
                });
            },
            async getStampDailyTab2() {
                console.log('tab2');
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                let form = $('#stamp-form-tab2');
                let valid = true;
                let errorMsg = '';
                vm.errors.stamp_code_tab2 = false;
                $(form).find("div[id='el_explode_stamp_code_tab2']").html("");
                if (vm.tab2Input.stamp_code == '' || vm.tab2Input.stamp_code == null){
                    vm.errors.stamp_code_tab2 = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกรหัสแสตมป์";
                    $(form).find("div[id='el_explode_stamp_code_tab2']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                let stampId = vm.header.stamp_summary[vm.tab2Input.stamp_code][0].follow_stamp_id;
                vm.set_stamp_code = vm.tab2Input.stamp_code;
                vm.summaryData = '';
                vm.loading.stampDailyTab2Process = true;
                await axios.get(vm.url.ajax_get_stamp_daily_tab2, {
                    params: {
                        follow_stamp_main_id: vm.header.follow_stamp_main_id,
                        stamp_code: vm.tab2Input.stamp_code,
                    }
                })
               .then(res => {
                    vm.summaryDataTab2 = res.data.data.stampDaily;
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">'+data.message+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading.stampDailyTab2Process = false;
                });
            },
            updateIssueStamp() {
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                let urlUpdate = '/planning/ajax/stamp-follow/update_issue/'+vm.header.follow_stamp_main_id;
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทการตัดใช้แสตมป์รายวัน ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทการตัดใช้แสตมป์รายวัน ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .get(urlUpdate)
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทการตัดใช้แสตมป์รายวัน',
                                    text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "success",
                                    html: true
                                });
                                if (vm.tab1Input.stamp_code) { 
                                    vm.valid_action = false; 
                                    vm.getStampDailyTab1(); 
                                }
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        });
                    }
                });
            },
            refreshStampTap1() {
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                let urlRefresh = vm.url.ajax_refresh_stamp_tab1;
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทประมาณการใช้แสตมป์รายวัน ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทประมาณการใช้แสตมป์รายวัน ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .get(urlRefresh)
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทประมาณการใช้แสตมป์รายวัน',
                                    text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "success",
                                    html: true
                                });
                                if (vm.tab1Input.stamp_code) {
                                    vm.valid_action = false;
                                    vm.getStampDailyTab1();
                                }
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        });
                    }
                });
            },
            refreshStampTap2() {
                let vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                let urlRefresh = vm.url.ajax_refresh_stamp_onhand_tab2;
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทคงคลังแสตมป์รายวัน ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทคงคลังแสตมป์รายวัน ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .get(urlRefresh)
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทคงคลังแสตมป์รายวัน',
                                    text: '<span style="font-size: 16px; text-align: left;" class="mt-2">'+res.data.data.msg+'</span>',
                                    type: "success",
                                    html: true
                                });
                                if (vm.tab2Input.stamp_code) {
                                    vm.valid_action = false;
                                    vm.getStampDailyTab2();
                                }
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        });
                    }
                });
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference
                        ? this.$refs[ref_name].$refs.reference.$refs.input
                        : (this.$refs[ref_name].$refs.textarea
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs
                                ? this.$refs[ref_name].$refs.input.$refs.input
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference
                        ? this.$refs[ref_name].$refs.reference.$refs.input
                        : (this.$refs[ref_name].$refs.textarea
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs
                                ? this.$refs[ref_name].$refs.input.$refs.input
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            errorRef(res){
                var vm = this;
                vm.errors.stamp_code_tab1 = res.err.stamp_code;
                vm.errors.stamp_code_tab2 = res.err.stamp_code_tab2;
                vm.errors.cigarettes_code = res.err.cigarettes_code;
            },
        },
    }
</script>