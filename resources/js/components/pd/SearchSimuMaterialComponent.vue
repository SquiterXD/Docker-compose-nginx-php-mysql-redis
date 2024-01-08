<template>
    <div class="row">
        <div class="col-sm-4">
            <label> ประเภทวัตถุดิบจำลอง </label>
            <el-select  class="w-100"
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        :value="form.simu_type"
                        @change="(value)=>{
                            form.simu_type = value
                            getParam();
                        }">              
                <el-option v-for="simulationType in sortArrays(inputParams.simu_type_list)"
                    :key="simulationType.value"
                    :label="simulationType.label"
                    :value="simulationType.value">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-4">
            <label> รหัสวัตถุดิบ </label>
            <el-select  class="w-100"
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        :value="form.simu_raw_num"
                        @change="(value)=>{
                            form.simu_raw_num = value
                            getParam();
                        }">              
                <el-option v-for="simuRawNum in sortArrays(inputParams.simu_raw_num_list)"
                    :key="simuRawNum.value"
                    :label="simuRawNum.value"
                    :value="simuRawNum.value">
                </el-option>
            </el-select>
        </div>

        <input type="hidden" name="simu_type"     :value="form.simu_type">
        <input type="hidden" name="simu_raw_num"  :value="form.simu_raw_num">

        <div class="col-sm-2">
            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
            <div class="text-right">
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fa fa-search" aria-hidden="true"></i> แสดงผล
                </button>
                <a :href="this.actionUrl" class="btn btn-warning btn-sm">
                    <i class="fa fa-undo"></i> รีเซต
                </a>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: ['simulationTypes', 'actionUrl', 'defaultValue', 'search_data'],
        data() {
            return {
                simu_type: this.defaultValue ? this.defaultValue : '',
                // simu_raw_num: this.defaultValue ? this.defaultValue : '',

                loading: false,

                inputParams: {
                    simu_type_list:    [],
                    simu_raw_num_list: [],
                },
                
                form: {
                    simu_type:    null,
                    simu_raw_num: null,
                },
            }
        },
        mounted() {
            this.autoLoad();
        },
        methods: {
            async autoLoad() {
                let vm                   = this;

                vm.form.simu_type     = (vm.search_data.simu_type != '')    ? vm.search_data.simu_type    : null,
                vm.form.simu_raw_num  = (vm.search_data.simu_raw_num != '') ? vm.search_data.simu_raw_num : null,      

                vm.getParam();
            },

            async getParam() {
                let vm = this;
                vm.loading = true;

                let params = {
                    action:         'search_get_param',
                    simu_type:       vm.form.simu_type,
                    simu_raw_num:    vm.form.simu_raw_num,
                }

                axios.get(vm.search_data.search_url, { params }).then(res => {
                    let response = res.data;
                    vm.loading = false;
                    vm.inputParams.simu_type_list    = response.simu_type_list;
                    vm.inputParams.simu_raw_num_list = response.simu_raw_num_list;
                });
            },

            sortArrays(arrays) {
                return _.orderBy(arrays, 'value', 'asc');
            },
        }
    }
</script>
