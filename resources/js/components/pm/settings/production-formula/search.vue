<template>
    <form :action="search_data.search_url" id="searchForm" v-loading="loading">

        <div v-if="organization_code == 'M06'">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>สถานะ</label>
                    <el-select
                        style="width: 100%"
                        placeholder="สถานะ"
                        clearable
                        filterable
                        :value="form.status"
                        @change="(value)=>{
                        form.status = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.status_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>รหัสสินค้า</label>
                    <el-select
                        style="width: 100%"
                        placeholder="รหัสสินค้า"
                        clearable
                        filterable
                        :value="form.inventory_item_id"
                        @change="(value)=>{
                        form.inventory_item_id = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.inventory_item_id_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>ประเภทสูตร</label>
                    <el-select
                        style="width: 100%"
                        placeholder="ประเภทสูตร"
                        clearable
                        filterable
                        :value="form.folmula_type"
                        @change="(value)=>{
                        form.folmula_type = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.folmula_type_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>เวอร์ชั่น</label>
                    <el-select
                        style="width: 100%"
                        placeholder="เวอร์ชั่น"
                        clearable
                        filterable
                        :value="form.version"
                        @change="(value)=>{
                        form.version = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.version_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>ปีงบประมาณ</label>
                    <el-select
                        style="width: 100%"
                        placeholder="ปีงบประมาณ"
                        clearable
                        filterable
                        :value="form.period_year"
                        @change="(value)=>{
                        form.period_year = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.period_year_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>

                <div class="col-12 text-right">
                    <label>&nbsp;</label>
                    <div>
                        <button type="button" :class="trans_btn.search.class" @click="searchForm" >
                            <i :class="trans_btn.search.icon"></i>
                            แสดงข้อมูล
                        </button>
                        
                        <button type="button"  class="btn btn-danger" @click="clearForm" >
                            ล้างค่า
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>สถานะ</label>
                    <el-select
                        style="width: 100%"
                        placeholder="สถานะ"
                        clearable
                        filterable
                        :value="form.status"
                        @change="(value)=>{
                        form.status = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.status_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>รหัสสินค้า</label>
                    <el-select
                        style="width: 100%"
                        placeholder="รหัสสินค้า"
                        clearable
                        filterable
                        :value="form.inventory_item_id"
                        @change="(value)=>{
                        form.inventory_item_id = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.inventory_item_id_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>ประเภทสูตร</label>
                    <el-select
                        style="width: 100%"
                        placeholder="ประเภทสูตร"
                        clearable
                        filterable
                        :value="form.folmula_type"
                        @change="(value)=>{
                        form.folmula_type = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.folmula_type_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>ขั้นตอนการทำงาน</label>
                    <el-select
                        style="width: 100%"
                        placeholder="ขั้นตอนการทำงาน"
                        clearable
                        filterable
                        :value="form.wip"
                        @change="(value)=>{
                        form.wip = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.wip_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>ประเภทเครื่องจักร</label>
                    <el-select
                        style="width: 100%"
                        placeholder="ประเภทเครื่องจักร"
                        clearable
                        filterable
                        :value="form.machine"
                        @change="(value)=>{
                        form.machine = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.machine_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>เวอร์ชั่น</label>
                    <el-select
                        style="width: 100%"
                        placeholder="เวอร์ชั่น"
                        clearable
                        filterable
                        :value="form.version"
                        @change="(value)=>{
                        form.version = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.version_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <label>ปีงบประมาณ</label>
                    <el-select
                        style="width: 100%"
                        placeholder="ปีงบประมาณ"
                        clearable
                        filterable
                        :value="form.period_year"
                        @change="(value)=>{
                        form.period_year = value
                        getParam();
                    }">
                        <el-option
                            v-for="item in inputParams.period_year_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>

                <div class="col-12 text-right">
                    <label>&nbsp;</label>
                    <div>
                        <button type="button" :class="trans_btn.search.class" @click="searchForm" >
                            <i :class="trans_btn.search.icon"></i>
                            แสดงข้อมูล
                        </button>
                        
                        <button type="button"  class="btn btn-danger" @click="clearForm" >
                            ล้างค่า
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="status"            :value="form.status">
        <input type="hidden" name="inventory_item_id" :value="form.inventory_item_id">
        <input type="hidden" name="folmula_type"      :value="form.folmula_type">
        <input type="hidden" name="wip"               :value="form.wip">
        <input type="hidden" name="machine"           :value="form.machine">
        <input type="hidden" name="version"           :value="form.version">
        <input type="hidden" name="period_year"       :value="form.period_year">
    </form>
</template>

<script>
import moment from "moment";

export default {
    props:['search_data', 'trans_btn', 'organization_code'],
    data() {
        return {
            loading: false,
            inputParams: {
                status_list:            [],
                inventory_item_id_list: [],
                folmula_type_list:      [],
                wip_list:               [],
                machine_list:           [],
                version_list:           [],
                period_year_list:       [],
            },
            form: {
                status:            null,
                inventory_item_id: null,
                folmula_type:      null,
                wip:               null,
                machine:           null,
                version:           null,
                period_year:       null,
            },
        }
    },
    mounted() {
        this.autoLoad();
    },
    computed: {
    },
    watch:{

        // "transDateFormat.to_date": function (newValue) {
        //     this.getParam();
        // },
        // // wipRequestNo : async function (value, oldValue) {
        // //     this.getParam();
        // // },
        // wipRequestStatus : async function (value, oldValue) {
        //     this.getParam();
        // },
    },
    methods: {
        async autoLoad() {
            let vm                    = this;
            vm.form.status            = (vm.search_data.status != '') ? vm.search_data.status : null,
            vm.form.inventory_item_id = (vm.search_data.inventory_item_id != '') ? vm.search_data.inventory_item_id : null,
            vm.form.folmula_type      = (vm.search_data.folmula_type != '') ? vm.search_data.folmula_type : null,
            vm.form.wip               = (vm.search_data.wip != '') ? vm.search_data.wip : null,
            vm.form.machine           = (vm.search_data.machine != '') ? vm.search_data.machine : null,
            vm.form.version           = (vm.search_data.version != '') ? vm.search_data.version : null,
            vm.form.period_year       = (vm.search_data.period_year != '') ? vm.search_data.period_year : null,

            vm.getParam();
        },
        async searchForm() {
            $( "#searchForm" ).submit();
        },
        async clearForm() {
            this.form.status            = null;
            this.form.inventory_item_id = null;
            this.form.folmula_type      = null;
            this.form.wip               = null;
            this.form.machine           = null;
            this.form.version           = null;
            this.form.period_year       = null;

            this.getParam();
        },
        async getParam() {
            let vm = this;
            vm.loading = true;

            let params = {
                action:            'search_get_param',
                status:            vm.form.status,
                inventory_item_id: vm.form.inventory_item_id,
                folmula_type:      vm.form.folmula_type,
                wip:               vm.form.wip,
                machine:           vm.form.machine,
                version:           vm.form.version,
                period_year:       vm.form.period_year,
            }

            axios.get(vm.search_data.search_url, { params }).then(res => {
                let response = res.data;
                vm.loading = false;
                vm.inputParams.status_list               = response.status_list;
                vm.inputParams.inventory_item_id_list    = response.inventory_item_id_list;
                vm.inputParams.folmula_type_list         = response.folmula_type_list;
                vm.inputParams.wip_list                  = response.wip_list;
                vm.inputParams.machine_list              = response.machine_list;
                vm.inputParams.version_list              = response.version_list;
                vm.inputParams.period_year_list          = response.period_year_list;
            });
        }
    }
}
</script>