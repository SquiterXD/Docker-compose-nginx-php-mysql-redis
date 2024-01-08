<template>
    <div>
        <div class="ibox float-e-margins mb-2" v-loading="loading">
            <div class="row col-12 mb-2">
                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                    <h3> ประมาณการกำลังผลิตประจำปี </h3>
                </div>
                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 text-right">
                    <button class="btn btn-white btn-lg" @click.prevent="submit">
                        <i class="fa fa-search"></i> ค้นหา
                    </button>
                    <a :href="url.submit_p01" class="btn btn-white btn-lg">ล้าง</a>
                </div>
            </div>
            <div class="card" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 b-r">
                            <form id="machine-form" :action="url.submit_p01">
                                <div class="row">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                                        <div class="input-group ">
                                            <input type="hidden" name="search[budget_year]" :value="budget_year">
                                            <el-select  v-model="budget_year" size="medium" placeholder="ปีงบประมาณ" filterable @change="checkSearchCondition" ref="budget_year">
                                                <el-option
                                                   v-for="(year, index) in budgetYears"
                                                    :key="index"
                                                    :label="year.thai_year"
                                                    :value="year.thai_year"
                                                >
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต </label>
                                        <div>
                                            <input type="hidden" name="search[product_type]" :value="product_type"> 
                                            <el-radio-group v-model="product_type" size="small" @change="checkSearchCondition()">
                                                <template v-for="(product, index) in productTypes">
                                                    <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                                        {{ product.meaning }}
                                                    </el-radio>
                                                </template>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-1">
                                        <div class="col-sm-6 text-sm-right">
                                            <dt>วันที่สร้าง:</dt>
                                        </div>
                                        <div class="col-sm-6 text-sm-left">
                                            <dd class="mb-1">
                                                <div v-if="header && show_flag">
                                                    {{ header.created_at_format }}
                                                </div>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-1">
                                        <div class="col-sm-6 text-sm-right">
                                            <dt title="">วันที่แก้ไขล่าสุด:</dt>
                                        </div>
                                        <div class="col-sm-6 text-sm-left">
                                            <dd class="mb-1">
                                                <div v-if="header && show_flag">
                                                    {{ header.updated_at_format? header.updated_at_format :header.created_at_format }}
                                                </div>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-1">
                                        <div class="col-sm-6 text-sm-right">
                                            <dt>ผู้บันทึก:</dt>
                                        </div>
                                        <div class="col-sm-6 text-sm-left">
                                            <dd class="mb-1">
                                                <div v-if="header && show_flag">
                                                    {{ creator }}
                                                </div>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <template v-if="search">
                <div class="row">
                    <div class="col-lg-12">
                        <lines-machine-yearly-component 
                            :p-efficiency-machine-percent="efficiency_machine"
                            :p-efficiency-product-percent="efficiency_product"
                            :p-header="header"
                            :p-default-input="defaultInput"
                            :p-search-input="searchInput"
                            :p-edit-flag="edit_flag"
                            :p-show-flag="show_flag"
                            :month-details="monthDetails"
                            :budget-year="budget_year"
                            :product-type="product_type"
                            :pUrl="url"
                            :p-date-format="dateFormat"
                            :btn-trans="btnTrans"
                            :search="search"
                            @updateEditFlag="updateEditFlag"
                        >
                        </lines-machine-yearly-component>
                    </div>
                </div>
           </template>
        </div>
    </div>
</template>

<script>
    export default {
        props:['productTypes', 'budgetYears', 'defaultInput', 'searchInput', 'search', 'header', 'pUrl', 'monthDetails', 'btnTrans', 'dateFormat'],
        data() {
            return {
                budget_year: this.search? this.search.budget_year: this.defaultInput.current_year,
                efficiency_machine: this.header? this.header.efficiency_machine: '',
                efficiency_product: this.header? this.header.efficiency_product: this.defaultInput.efficiency_product,
                product_type: this.search? this.search.product_type: this.defaultInput.product_type,
                url: this.pUrl,
                month_lists: [],
                loading: false,
                m_loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                },
                // Support Issue with IT
                edit_flag: false,
                show_flag: true,
                valid_action: false,
                set_budget_year: this.search? this.search.budget_year: this.defaultInput.current_year,
                set_product_type: this.search? this.search.product_type: this.defaultInput.product_type,
                creator: this.header && this.header.updated_by? this.header.updated_by.name: (this.header && this.header.created_by? this.header.created_by.name: null),
            }
        },
        mounted() {
        },
        computed: {
            monthLists: function () {
                return this.month_lists;
            },
            efficiencyMachine: function () {
                return this.efficiency_machine;
            },
            efficiencyProduct: function () {
                return this.efficiency_product;
            }
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
            changeSearch(){
                var vm = this;
                vm.edit_flag = '';
                vm.show_flag = true;
                if (vm.set_product_type != vm.product_type || vm.set_budget_year != vm.budget_year) {
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }
            },
            async submit(){
                var form  = $('#machine-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.month = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                this.loading = true;
                form.submit();
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
            checkSearchCondition(){
                // Check show data when change search
                var vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    vm.budget_year = vm.set_budget_year;
                    vm.product_type = vm.set_product_type;
                    return;
                }
                vm.edit_flag = '';
                vm.show_flag = true;
                if (vm.set_budget_year != vm.budget_year) {
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }else if(vm.set_budget_year == vm.budget_year && vm.set_product_type != vm.product_type) {
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }
            },
            updateEditFlag(res){
                this.valid_action = res;
            }
        }
    }
</script>