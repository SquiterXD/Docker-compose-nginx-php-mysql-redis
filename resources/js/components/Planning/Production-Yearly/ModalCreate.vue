<template>
    <span>

        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}
        </button>

        <div class="modal fade" id="modal_create" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">สร้างแผนประมาณการผลิตประจำปี</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="production-plan-create-form">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
                                        <el-input :readonly="true" placeholder="Please input" v-model="budget_year" size="large"></el-input>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2" >
                                    <label class="tw-font-bold tw-uppercase mb-1"> ครั้งที่ :</label>
                                    <el-input v-loading="timeLoading" placeholder="ครั้งที่" v-model="times" size="large" :readonly="true"> </el-input>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-2" >
                                    <label class="tw-font-bold tw-uppercase mb-1"> คงคลังต้นปีงบประมาณเพียงพอ(วัน) :</label>
                                    <vue-numeric
                                        :style="'width: 100%; height: 40px; '+ (errors.begin_onhand? 'border: 1px solid red;' : '')"
                                        name="begin_onhand"
                                        v-bind:minus="false"
                                        :min="0"
                                        :max="100"
                                        class="form-control input-md text-right"
                                        v-model="begin_onhand"
                                        autocomplete="off"
                                    ></vue-numeric>
                                    <div id="el_explode_begin_onhand" class="error_msg text-left"></div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2" >
                                    <label class="tw-font-bold tw-uppercase mb-1"> เปอร์เซ็นต์สูญเสีย(%) :</label>
                                    <vue-numeric
                                        :style="'width: 100%; height: 40px; '+ (errors.per_loss? 'border: 1px solid red;' : '')"
                                        name="per_loss"
                                        v-bind:minus="false"
                                        v-bind:precision="2"
                                        :min="0"
                                        :max="100"
                                        class="form-control input-md text-right"
                                        v-model="per_loss"
                                        autocomplete="off"
                                    ></vue-numeric>
                                    <div id="el_explode_per_loss" class="error_msg text-left"></div>
                                </div>
                            </div>
                        </form>

                        <transition
                            enter-active-class="animated fadeInUp"
                            leave-active-class="animated fadeOutDown">
                            <div v-html="html" v-if="budget_year" class="mt-4"></div>
                        </transition>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal">Close</button>
                        <button type="button" v-loading="loading" @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
                            <i :class="btnTrans.create.icon"></i>
                            {{ btnTrans.create.text }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        props:["defaultYear", "defaultWorkingHour", "btnTrans", "url"],
        components: {
            VueNumeric
        },
        data() {
            return {
                budget_year: this.defaultYear ? this.defaultYear : '',
                times: '',
                loading: false,
                timeLoading: false,
                errors: {
                    budget_year: false,
                    begin_onhand: false,
                    per_loss: false,
                },
                biWeeklyLists: [],
                html: '',
                // New Requirement 03082022
                begin_onhand: '',
                per_loss: '',
                working_hour: this.defaultWorkingHour? this.defaultWorkingHour: '', //defualt จาก Header P01
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
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                },
                deep: true,
            },
        },
        methods: {
            openModal() {
                $('#modal_create').modal('show');
                this.getBiWeekly();
            },
            getBiWeekly(){
                this.times = '';
                this.budget_year = this.defaultYear ? this.defaultYear : '',
                this.getDetail();
            },
            async getDetail(){
                let vm = this;
                vm.times = 1;
                vm.html = '';
                vm.timeLoading = true;
                axios.get(vm.url.ajax_modal_create_details, { params : {
                    budget_year: vm.budget_year
                }}).then(res => {
                    let response = res.data.data;
                    vm.times = response.times;
                    vm.html = response.html;
                    vm.timeLoading = false;
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
            async submit(){
                let vm = this;
                var form  = $('#modal_create');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.begin_onhand = false;
                this.errors.per_loss = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_begin_onhand']").html("");
                $(form).find("div[id='el_explode_per_loss']").html("");
                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (this.begin_onhand == ''){
                    this.errors.begin_onhand = true;
                    valid = false;
                    errorMsg = "กรุณาระบุคงคลังต้นปีงบประมาณเพียงพอ";
                    $(form).find("div[id='el_explode_begin_onhand']").html(errorMsg);
                }
                if (this.per_loss == ''){
                    this.errors.per_loss = true;
                    valid = false;
                    errorMsg = "กรุณาระบุเปอร์เซ็นต์สูญเสีย";
                    $(form).find("div[id='el_explode_per_loss']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                let res = await this.create();
                vm.loading = false;
                if(res.status == 'S'){
                    swal({
                        title: 'สร้างแผนประมาณการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลแผนประมาณการผลิตรายปีเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.href = res.redirect_show_page;
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create() {
                console.log('--S--');
                let vm2 = this;
                let data = [];
                let params = {
                    budget_year: vm2.budget_year,
                    begin_onhand: vm2.begin_onhand,
                    per_loss: vm2.per_loss,
                    working_hour: vm2.working_hour
                };
                vm2.loading = true;
                console.log('--S1--');
                await axios.post(vm2.url.ajax_production_yearly_store, params)
                    .then(res => {
                        console.log(res);
                        data = res.data.data;
                    })
                    .catch(err => {
                        let msg = err.response.data.data;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg,
                            type: "error",
                        });
                    })
                    .then(() => {
                        vm2.loading = false;
                    });
                console.log('--E--');
                return data;
            },
        }
    }
</script>