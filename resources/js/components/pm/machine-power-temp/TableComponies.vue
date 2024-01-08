<template>
    <div>
        <div class="text-right" style="padding-bottom: 15px;" v-if="this.machineGroup && this.machine">
            <button :class="btnTrans.save.class" @click.prevent="addLine" :disabled="this.disabledAddLine"> 
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
            </button>
            <button :class="btnTrans.save.class" 
                    v-on:click="saveDataToTable()" 
                    :disabled="this.disabledSave"> 
                <i :class="btnTrans.save.icon" aria-hidden="true"></i> {{ btnTrans.save.text }} 
            </button>
        </div>
        <table class="table table table-bordered">
            <thead>
                <tr>
                    <!-- <th width="20%" class="text-center">
                        <div>ประเภทของการผลิตของเครื่องจักร</div>
                    </th> -->
                    <th v-for="item in productPeriodList" :key="item.key" class="text-center" width="10%">
                        <div>{{item.description}}</div>
                    </th>
                    <th width="5%" class="text-center">
                        <div>หน่วย</div>
                    </th>
                    <th width="5%" class="text-center">

                    </th>
                    <th width="5%" class="text-center">

                    </th>
                </tr>
            </thead>
            <tbody v-if="this.machinePowerTempList === undefined || this.machinePowerTempList.length === 0">
                <tr class="text-center" v-if="checkText">
                    <td :colspan="numberColumn">ไม่มีข้อมูล</td>
                </tr>
                <tr v-for="(data, index) in lines" :key="index">
                    <!-- <td>
                        <el-select  v-model="data.machine_type" 
                                    placeholder="เลือกประเภทของการผลิตของเครื่องจักร"
                                    clearable
                                    class="w-100"
                                    @change="getDetailsUom(data.machine_type, data)">
                            <el-option
                                v-for="(data,index) in lookupTypeMachine"
                                :key="index"
                                :label="data.meaning"
                                :value="data.lookup_code">
                            </el-option>
                        </el-select>
                    </td> -->
                    <td v-for="(item, key) in productPeriodList" :key="key">
                        <el-input   :placeholder="item.description" 
                                    v-model="data.power[key+1]"
                                    @change="checkValue(data.power[key+1], item.lookup_code, index, key+1)"></el-input>
                    </td>
                    <!-- <td class="text-center" style="vertical-align:middle;">
                        {{ data.uom_description }}
                    </td> -->
                    <td class="text-center" style="vertical-align:middle;">
                        <el-select  v-model="data.uom" 
                                    placeholder="เลือก หน่วย"
                                    clearable
                                    class="w-100"
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(uom,index) in uomList"
                                :key="index"
                                :label="uom.unit_of_measure"
                                :value="uom.uom_code">
                            </el-option>
                        </el-select>
                    </td>
                    <td class="text-center">
                        <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td>
                    <td>

                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="(data, index) in getDataMachineType" :key="index" >
                    <!-- <td class="text-center"  style="vertical-align:middle;">
                        {{ index }}
                    </td> -->
                    <td v-for="(time, key) in productPeriodList" :key="key" class="text-center" style="vertical-align:middle;">
                        <div v-for="(item, itemKey) in data" :key="itemKey">
                            <div v-if="item.machine_name == index && item.product_time == time.lookup_code">
                                {{ item.power }}
                            </div>
                        </div>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        {{ data[0].uom_v ? data[0].uom_v.unit_of_measure : '' }}
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-center" style="font-size:12px">
                        <a  type="button"  
                            :class="btnTrans.edit.class" 
                            :href="'/pm/settings/machine-power-temp/'+ data[0].machine_group +'/'+ data[0].machine_id +'/'+ data[0].machine_type +'/edit'">
                            <i :class="btnTrans.edit.icon" aria-hidden="true"></i> {{ btnTrans.edit.text }}
                        </a>
                    </td>
                </tr>  
                <tr v-for="(data, index) in lines" :key="index">
                    <!-- <td>
                        <el-select  v-model="data.machine_type" 
                                    placeholder="เลือกประเภทของการผลิตของเครื่องจักร"
                                    clearable
                                    class="w-100"
                                    @change="getDetailsUom(data.machine_type, data)">
                            <el-option
                                v-for="(data,index) in lookupTypeMachine"
                                :key="index"
                                :label="data.meaning"
                                :value="data.lookup_code">
                            </el-option>
                        </el-select>
                    </td> -->
                    <td v-for="(item, key) in productPeriodList" :key="key">
                        <el-input   :placeholder="item.description" 
                                    v-model="data.power[key+1]"
                                    @change="checkValue(data.power[key+1], item.lookup_code, index, key+1)"></el-input>
                    </td>
                    <!-- <td class="text-center" style="vertical-align:middle;">
                        {{ data.uom_description }}
                    </td> -->
                    <td class="text-center" style="vertical-align:middle;">
                        <el-select  v-model="data.uom" 
                                    placeholder="เลือก หน่วย"
                                    clearable
                                    class="w-100"
                                    filterable
                                    remote 
                                    reserve-keyword>
                            <el-option
                                v-for="(uom,index) in uomList"
                                :key="index"
                                :label="uom.unit_of_measure"
                                :value="uom.uom_code">
                            </el-option>
                        </el-select>
                    </td>
                    <td class="text-center">
                        <button @click.prevent="removeRow(index)" 
                                :class="btnTrans.delete.class">
                                <i :class="btnTrans.delete.icon" aria-hidden="true"></i>
                        </button>
                    </td>
                    <td>

                    </td>
                </tr> 
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['machinePowerTempList', 'productPeriodList', 'numberColumn', 'uomList', 'machineGroup', 'machine', 'btnTrans'],
        data() {
            return{
                lines: [],
                statusBtuSave: false,
                checkText: true,
                disabledAddLine: false,
                disabledSave: false
            };
        },
        computed: {
            getDataMachineType() {
                if(this.machinePowerTempList.length == 0){
                    this.disabledAddLine = false;
                    this.disabledSave = false;
                }else{
                    this.disabledAddLine = true;
                    this.disabledSave = true;
                }
                return _.groupBy(this.machinePowerTempList, "machine_name");
            },
        },
        mounted() {
    
        },
        methods: {
            addLine() {
                this.checkText = false;
                this.lines.push({
                    machine_id: this.machine ? this.machine : '',
                    machine_group: this.machineGroup ? this.machineGroup : '',
                    // machine_type: '',
                    // uom_description: '',
                    power: [],
                    lookupCode: [],
                    uom: ''
                });
                this.disabledAddLine = true;                   
            },
            // getDetailsUom(value, arrayData){
            //     this.lookupTypeMachine.forEach(element => {
            //         if(value == element.lookup_code){
            //             // arrayData.uom = element.attribute1
            //             arrayData.uom_description = element.description
            //             arrayData.uom_code = element.uom_code
            //         }
            //     });
            // },
            checkValue(value, index, indexLine, indexPeriod){
                let vm = this;
                vm.lines.forEach((element, i) => {
                    element.power.forEach((data,key) => {
                        if(indexLine == i){
                            if(index > key){
                                if(Number(data) > Number(value)){
                                    this.showAlert();
                                    this.statusBtuSave = true;
                                    return;
                                }else{
                                    this.statusBtuSave = false;
                                }
                            }
                            element.lookupCode[indexPeriod] = index
                        }
                    });
                });              
            },
            showAlert(){
                swal({
                    title: "Error !",
                    text: "ไม่สามารถกรอกจำนวนเลขนี้ได้",
                    type: "error",
                    showConfirmButton: true
                });
            },
            removeRow: function(index) {    
                this.lines.splice(index, 1);
                if(this.lines.length == 0){
                    this.checkText = true;
                }else{
                    this.checkText = false;
                }
                this.disabledAddLine = false;
            },  
            saveDataToTable() {
                var params = {...this.lines};
                return axios
                    .post('/pm/ajax/machine-power-temp/store',{ params })
                    .then(res => {
                        if(res.data.data == "succeed"){
                            swal({
                                title: "Success",
                                text: 'บันทึกสำเร็จ',
                                timer: 3000,
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            })
                            setTimeout(() => {
                                window.location.href = '/pm/settings/machine-power-temp'
                            }, 3000)
                        }
                    });
            },  
        },
    };
</script>
