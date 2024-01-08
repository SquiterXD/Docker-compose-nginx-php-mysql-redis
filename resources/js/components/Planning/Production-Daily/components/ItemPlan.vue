<template>
    <span>
        <form id="onhand-form">
            <div class="row ml-3">
                <div style="width: 300px;">
                    <label class="tw-font-bold tw-uppercase mb-1"> ตรวจสอบคงคลังบุหรี่ </label>
                    <el-select style="width: 100%;" name="item" v-model="item_code" @change="selItem" size="large" placeholder="รหัสบุหรี่" clearable filterable ref="item_code" :popper-append-to-body="false">
                        <el-option
                            v-for="item in listItemCigarettes"
                            :key="item.item_code"
                            :label="item.item_code+' : '+item.item_description"
                            :value="item.item_code"
                        >
                        </el-option>
                    </el-select>
                    <div id="el_explode_item" class="error_msg text-left"></div>
                </div>

                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-3">
                    <label> <br> &nbsp; </label>
                    <button type="button" :class="btnTrans.search.class + ' btn-lg tw-w-25'" @click.prevent="getData">
                        <i :class="btnTrans.search.icon"></i>
                        {{ btnTrans.search.text }}
                    </button>
                </div>
            </div>
            <!-- Result Table -->
            <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-6 col-xs-6 mt-2">
                <div class="table-responsive" v-html="html"></div>
            </div>
        </form>
    </span>
</template>

<script>
    export default {
        props:[
            "productDailyPlan", "itemCigars", "productType", "DateFormat", "btnTrans", "url", "itemProductionMain"
        ],
        data() {
            return {
                item_code: '',
                item_name: '',
                loading: false,
                errors: {
                    item_code: false,
                },
                html: '',
                listItemCigarettes: [],
            }
        },
        mounted() {
            this.itemCigarette();
        },
        computed: {
        },
        methods: {
            async getData() {
                let vm = this;
                let form = $('#onhand-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.item_code = false;
                $(form).find("div[id='el_explode_item']").html("");
                if (vm.item_code == ''){
                    vm.errors.item_code = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกรหัสบุหรี่";
                    $(form).find("div[id='el_explode_item']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }

                vm.loading = true;
                vm.html = '';
                let params = {
                    daily_id: vm.productDailyPlan != null? vm.productDailyPlan.daily_id: '',
                    item_code: vm.item_code,
                };
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                await axios.get(vm.url.ajax_get_production_item, { params })
                    .then(res => {
                        vm.html = res.data.data.html
                    })
                    .catch(err => {
                        vm.html = res.data.data.html
                    })
                    .then(() => {
                        vm.loading = false;
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
                vm.errors.item_code = res.err.item_code;
            },
            itemCigarette(){
                // this.listItemCigarettes = this.items.filter(item => {
                //     return item.product_type == this.productType;
                // });
                Object.values(this.itemProductionMain).filter(itemMain => {
                    this.itemCigars.filter(item => {
                        if (item.item_code == itemMain && item.product_type == this.productType) {
                            this.listItemCigarettes.push(item);
                        }
                    });
                });
            },
            selItem(){
                this.listItemCigarettes.filter(item => {
                    if (item.item_code == this.item_code) {
                        return this.item_name = item.item_description;
                    }
                });
            },
        },
        watch: {
            errors: {
                handler(val){
                    val.item_code? this.setError('item_code') : this.resetError('item_code');
                },
                deep: true,
            },
            productType : async function (value, oldValue) {
                // this.itemCigarette();
                this.html = '';
            },
        },
    }
</script>

<style scope>
    .el-input--medium .el-input__inner {
        height: 30px !important;
        line-height: 36px;
    }
    .el-input--medium .el-input__icon {
        line-height: 30px;
    }
</style>