<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="text-right" style="padding-bottom: 15px;">
                    <!-- <button class="btn btn-light" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                    </button> -->
                    <a type="button" :href="'/pm/settings/machine-power-temp'" class="btn btn-danger">
                        ล้างค่า
                    </a>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> กลุ่มเครื่องจักร </strong>
                        </label>
                        <!-- <input type="hidden" name="search[wipTransaction]" v-model="wip" autocomplete="off"> -->
                        <el-select  v-model="machineGroup" 
                                    placeholder="โปรดเลือกกลุ่มเครื่องจักร"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword
                                    @change="getDetails(machineGroup)">
                            <el-option
                                v-for="(item,index) in machineGroupList"
                                :label="item.asset_group"
                                :key="index"
                                :value="item.machine_group">
                            </el-option>
                        </el-select>
                    </div>
                    <!-- <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> รายละเอียด </strong>
                        </label>
                        <el-input
                            v-model="machineGroupDetails"
                            :disabled="true">
                        </el-input>  
                    </div> -->
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> ระบบการพิมพ์ </strong>
                        </label>
                        <!-- <input type="hidden" name="search[wipTransaction]" v-model="wip" autocomplete="off"> -->
                        <el-select  v-model="printType" 
                                    placeholder="โปรดเลือกระบบการพิมพ์"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword
                                    v-loading="loading.printType"
                                    :disabled="!machineGroup"
                                    @change="(value)=>{
                                        selectPrintType()
                                    }">
                            <el-option
                                v-for="(item,index) in printTypeList"
                                :key="index"
                                :label="item.print_type_label"
                                :value="item.print_type_value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row" style="padding-top: 15px;">
                    <div class="col-6">
                        <label class="w-100 text-left">
                            <strong> เครื่องจักร </strong>
                        </label>
                        <!-- <input type="hidden" name="search[wipTransaction]" v-model="wip" autocomplete="off"> -->
                        <el-select  v-model="machine" 
                                    placeholder="โปรดเลือกเครื่องจักร"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword
                                    :disabled="!machineGroup || !printType"
                                    v-loading="loading.machine"
                                    @change="getTable(machineGroup, machine)">
                            <el-option
                                v-for="(item,index) in machineList"
                                :key="index"
                                :label="item.machine_name"
                                :value="item.machine_id">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>บันทึกกำลังผลิตรายเครื่อง</h5>
            </div>
            <div class="ibox-content" v-loading="loading.table">
                <machine-power-temp-table   :machinePowerTempList = 'machinePowerTempList'
                                            :productPeriodList = 'productPeriodList'
                                            :numberColumn = 'numberColumn'
                                            :uomList = 'uomList'
                                            :machineGroup = 'machineGroup'
                                            :machine = 'machine'
                                            :btnTrans = 'btnTrans'>
                </machine-power-temp-table>
            </div>
        </div>
    </div>        

</template>

<script>
export default {
    props: ['machineGroupList', 'routeIndex', 'productPeriod', 'btnTrans'],
    data() {
        return {
            machineGroup: '',
            printType: '',
            machineGroupDetails: '',
            machine: '',
            respMachineList: [],
            machineList: [],
            printTypeList: [],
            machinePowerTempList: [],
            productPeriodList: this.productPeriod,
            numberColumn: this.productPeriod.length + 4,
            // lookupTypeMachine: [],
            uomList: [],
            loading: {
                machine: false,
                printType: false,
                table: false,
            },
        };
    },
    mounted() {

    },
    computed:{
        
    },
    methods: {
        getDetails(value) {
            // this.loading.machine = true;
            if (!this.machineGroup) {
                this.printType = '';
                this.machine = '';
                this.machinePowerTempList = [];
            }
            this.loading.printType = true;
            this.machineGroupList.forEach(element => {
                if(value == element.machine_group){
                    this.machineGroupDetails = element.asset_group;
                }
            });
            var params = {
                machine_group : value,
            };
            return axios
                .get('/pm/ajax/machine-power-temp/getMachine',{ params })
                .then(res => {
                    this.respMachineList = res.data.machineList;
                    this.printTypeList = res.data.printTypeList;
                    // this.loading.machine = false;
                    this.loading.printType = false;
                });
        },
        async selectPrintType() {
            if (!this.printType) {
                this.machine = '';
            }
            this.machineList = this.respMachineList.filter(item => item.print_type == this.printType);
            // this.machineList = this.respMachineList;
        },

        getTable(value, value1) {
            var params = {
                machine_group : value,
                machine_id : value1
            };
            this.loading.table = true;
            return axios
                .get('/pm/ajax/machine-power-temp/getTable',{ params })
                .then(res => {
                    this.machinePowerTempList = res.data.machinePowerTempList;
                    // this.lookupTypeMachine = res.data.lookupTypeMachine;
                    this.uomList = res.data.uomList
                    this.loading.table = false;
                });
        }
    }
};
</script>
