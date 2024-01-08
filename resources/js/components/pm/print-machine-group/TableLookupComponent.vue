<template>
    <div class="col-lg-12" v-loading="loading">
        <div class="ibox">
            <div class="ibox-title">
                <h5>กำหนดกลุ่มเครื่องจักร</h5>
            </div>
            <div class="ibox-content">
                <div class="text-right">
                    <a class="btn btn-sm btn-primary" type="button" target="_blank" 
                        :href="`/lookup?programCode=PMS0047`"> 
                        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ กลุ่มเครื่องจักร
                    </a>
                </div><br>
                <table class="table table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 150px;">
                                <div>ลำดับที่</div>
                            </th>
                            <!-- <th class="text-center">
                                <div>กลุ่มที่</div>
                            </th> -->
                            <th class="">
                                <div>ชื่อกลุ่ม</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="lookupMachineGroup.length != 0">
                        <tr v-for="(data, index) in lookupMachineGroup" 
                            :key="'showdata'+index" 
                            style="cursor: pointer;" 
                            @click="newTableLine(data.lookup_code, data.asset_group.asset_group)">
                            <td class="text-center">
                                <!-- {{ data.lookup_code }} -->
                                {{ index + 1 }}
                            </td>
                            <!-- <td class="text-center">
                                {{ 'กลุ่มที่ ' + data.lookup_code }}
                            </td> -->
                            <td class="">
                                {{ data.asset_group.asset_group }}
                            </td>
                        </tr> 
                    </tbody>
                    <tbody v-else>
                        <tr class="text-center">
                            <td colspan="5">ไม่มีข้อมูล</td>
                        </tr>        
                    </tbody>
                </table>
            </div>
        </div>
        <machine-group-table-setup  :assetList = "assetList"
                                    :printTypes= "printTypes"
                                    :assetGroup="assetGroup"
                                    :printMachineGroup = "printMachineGroup"
                                    :lookupMachineGroup = "lookupMachineGroup"
                                    :lookupCode = "lookupCode"
                                    :btnTrans = "btnTrans">
        </machine-group-table-setup>
        </div>
</template>

<script>
    import uuidv1 from 'uuid/v1';
    import moment from 'moment';
    export default {
        props:['lookupMachineGroup', 'assetList', 'btnTrans', 'printTypes'],
        data() {
          return {
            lookupCode: '',
            assetGroup: '',
            printMachineGroup: '',
            loading: false,
          }
        },
        mounted() {
            
        },
        methods: {
            newTableLine(value, assetGroup){
                this.loading = true;
                this.assetGroup = assetGroup;
                return axios
                    .post('/pm/ajax/print-machine-group/getTableSetup',{ value })
                    .then(res => {
                        this.loading = false;
                        this.printMachineGroup = res.data.printMachineGroup;
                        this.lookupCode = value;
                    });
            }
        }
    }
</script>
