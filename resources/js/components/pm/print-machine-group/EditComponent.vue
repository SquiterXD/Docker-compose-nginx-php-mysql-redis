<template>
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>แก้ไขกำหนดกลุ่มเครื่องจักรกับเครื่องจักร</h5>
            </div>
            <form action="/pm/settings/print-machine-group/update" method="get">
            <div class="ibox-content">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col" style="padding-top: 15px;">
                                <label>กลุ่มเครื่องจักร</label><span class="text-danger"> *</span>
                                <input type="hidden" name="id" v-model="id">
                                <input type="hidden" name="machineGroup" v-model="machineGroup">
                                <el-select  v-model="machineGroup" clearable filterable 
                                            placeholder="กลุ่มเครื่องจักร" 
                                            disabled 
                                            class="w-100">
                                    <el-option
                                        v-for="(item,index) in lookupMachineGroup"
                                        :key="index"
                                        :label="'กลุ่มที่ ' + item.lookup_code + ' : ' + item.asset_group.asset_group"
                                        :value="item.lookup_code">
                                    </el-option>
                                </el-select>
                            </div>     
                        </div>

                        <div class="row">
                            <div class="col" style="padding-top: 15px;">
                                <label>ระบบการพิมพ์</label><span class="text-danger"> *</span>
                                <input type="hidden" name="id" v-model="id">
                                <input type="hidden" name="printType" v-model="printType">
                                <el-select  v-model="printType" clearable filterable
                                            placeholder="ระบบการพิมพ์"
                                            class="w-100">
                                    <el-option
                                        v-for="(item,index) in printTypes"
                                        :key="index"
                                        :label="item.print_type_label"
                                        :value="item.print_type_value">
                                        <div class="text-left">{{ item.print_type_label }}</div>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col" style="padding-top: 15px;">
                                <label>ชื่อเครื่องจักร</label><span class="text-danger"> *</span>
                                <input type="hidden" name="machineId" v-model="machineId">
                                <input type="hidden" name="oldMachineId" v-model="oldMachineId">
                                <el-select  v-model="machineId" clearable filterable 
                                            placeholder="ชื่อเครื่องจักร" 
                                            class="w-100">
                                    <el-option
                                        v-for="(item,index) in assetList"
                                        :key="index"
                                        :label="item.asset_number + ' : ' + item.asset_description"
                                        :value="String(item.asset_id)">
                                    </el-option>
                                </el-select>
                            </div>     
                        </div>   

                        <div class="row">
                            <div class="col" style="padding-top: 15px;">
                                <label>สถานะการใช้งาน</label><span class="text-danger"> *</span>
                                <input type="hidden" name="checked" v-model="checked">
                                <input type="hidden" name="oldChecked" v-model="oldChecked">
                                <el-checkbox v-model="checked" class="w-100"></el-checkbox>
                            </div>     
                        </div>   
                    </div>
                </div>

                <div class="row clearfix text-right">
                    <div class="col" style="margin-top: 15px;">
                        <button class="btn btn-success" type="submit"> 
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                        </button>
                        <a type="button" class="btn btn-danger" :href="`/pm/settings/print-machine-group`">
                            <i class="fa fa-times" aria-hidden="true" ></i> ยกเลิก
                        </a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props:['dataMachineGroup', 'lookupMachineGroup', 'assetList', 'printTypes'],
        data() {
          return {
            id: this.dataMachineGroup ? this.dataMachineGroup.id : '',
            oldMachineId: this.dataMachineGroup ? this.dataMachineGroup.machine_id : '',
            oldChecked: this.dataMachineGroup ? this.dataMachineGroup.enable_flag == 'Y' ? true : false : false,
            checked: this.dataMachineGroup ? this.dataMachineGroup.enable_flag == 'Y' ? true : false : false,
            machineGroup: this.dataMachineGroup ? this.dataMachineGroup.machine_group : '',
            machineId: this.dataMachineGroup ? this.dataMachineGroup.machine_id : '',
            printType: this.dataMachineGroup ? this.dataMachineGroup.print_type : '',
          }
        },
        mounted() {
            // console.log(this.dataMachineGroup);
        },
        methods: {
           
        }
    }
</script>
