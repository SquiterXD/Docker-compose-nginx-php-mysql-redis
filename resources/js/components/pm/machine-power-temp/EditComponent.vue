<template>
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>แก้ไขบันทึกกำลังผลิตรายเครื่อง</h5>
            </div>
            <form action="/pm/settings/machine-power-temp/update" method="get">
            <div class="ibox-content">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- <div class="row"> -->
                            <!-- <div class="col" style="padding-top: 15px;"> -->
                                <!-- <label>ประเภทของการผลิตของเครื่องจักร</label><span class="text-danger"> *</span> -->
                                <!-- <input type="hidden" name="machineType" v-model="machineType"> -->
                                <input type="hidden" name="machineId" v-model="machineId">
                                <input type="hidden" name="machineGroup" v-model="machineGroup">
                                <!-- <el-input
                                    placeholder="Please input"
                                    v-model="machineType"
                                    :disabled="true">
                                </el-input> -->
                            <!-- </div>      -->
                        <!-- </div> -->
                        
                        <div v-for="(data, index) in productPeriodShow" :key="index">
                            <div v-for="(value, key) in dataMachinePowerTempShow" :key="key">
                                <div v-if="data.lookup_code == value.product_time">
                                    <div class="row">
                                        <div class="col" style="padding-top: 15px;">
                                            <label>{{ data.description }}</label><span class="text-danger"> *</span>
                                            <input type="hidden" :name="'power['+[index+1]+']'"  v-model="value.power">
                                            <input type="hidden" :name="'lookupCode['+[index+1]+']'"  v-model="value.product_time">
                                            <el-input
                                                placeholder="โปรดกรอกกำลังการผลิต"
                                                v-model="value.power"
                                                @change="checkValue(value.power, value.product_time, index+1)">
                                            </el-input>
                                        </div>     
                                    </div>  
                                </div> 
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col" style="padding-top: 15px;">
                                <label>หน่วย</label><span class="text-danger"> *</span>
                                <input type="hidden" name="uom" v-model="uom">
                                <el-input
                                    placeholder="Please input"
                                    v-model="uom_description"
                                    :disabled="true">
                                </el-input>
                            </div>     
                        </div> -->

                        <div class="row">
                            <div class="col" style="padding-top: 15px;">
                                <label>หน่วย</label><span class="text-danger"> *</span>
                                <input type="hidden" name="uom" v-model="uom">
                                <el-select  v-model="uom" 
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
                            </div>     
                        </div>
                    </div>
                </div>

                <div class="row clearfix text-right">
                    <div class="col" style="margin-top: 15px;">
                        <button :class="btnTrans.save.class" type="submit" :disabled="this.statusBtuSave"> 
                            <i :class="btnTrans.save.icon" aria-hidden="true"></i> {{ btnTrans.save.text }} 
                        </button>
                        <a type="button" :class="btnTrans.cancel.class" :href="`/pm/settings/machine-power-temp`">
                            <i :class="btnTrans.cancel.icon" aria-hidden="true" ></i> {{ btnTrans.cancel.text }}
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
        props:['productPeriod', 'dataMachinePowerTemp', 'btnTrans', 'uomList'],
        data() {
            return {
                // machineType: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].machine_type : '',
                productPeriodShow: this.productPeriod,
                dataMachinePowerTempShow: this.dataMachinePowerTemp,
                uom: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].uom : '',
                // uom_description: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].uomList.description : '',
                machineId: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].machine_id : '',
                machineGroup: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].machine_group : '',
                statusBtuSave: false,
            }
        },
        mounted() {

        },
        methods: {
            checkValue(value, indexPeriod, index){
                let vm = this;
                vm.dataMachinePowerTemp.forEach((element, i) => {
                    if(index < element.product_time){
                        if(index != element.product_time){
                            if(Number(value) > Number(element.power)){
                                this.showAlert();
                                this.statusBtuSave = true;
                                return;
                            }else{
                                this.statusBtuSave = false;                                
                            }
                        }
                    }
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
        }
    }
</script>
