<template>

    <div>
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> รหัสวัตถุดิบ </strong> <span class="text-danger">*</span>
                </div>
                <div align="center">
                    <input type="text" class="form-control col-12" name="simu_raw_num" v-model="simu_raw_num" :disabled='this.defaultValue'>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> รายละเอียด </strong> <span class="text-danger">*</span>
                </div>
                <div align="center">
                    <input type="text" class="form-control col-12" name="description" v-model="description">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> ประเภทวัตถุดิบจำลอง </strong> <span class="text-danger">*</span>
                </div>
                <div align="center">
                    <!-- <el-select v-model="simu_type"  name="simu_type" placeholder="Select" class="w-100">
                        <el-option
                        v-for="simulationType in simulationTypes"
                        :key="simulationType.lookup_code"
                        :label="simulationType.meaning"
                        :value="simulationType.lookup_code">
                        </el-option>
                    </el-select> -->
                    <input type="hidden" name="simu_type" :value="simu_type" autocomplete="off">
                    <el-select  class="w-100"
                                v-model="simu_type"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                :disabled='this.checkTransection'>              
                        <el-option v-for="simulationType in simulationTypes"
                            :key="simulationType.lookup_code"
                            :label="simulationType.meaning"
                            :value="simulationType.lookup_code">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> ราคาต่อหน่วย </strong> <span class="text-danger">*</span>
                </div>
                <div align="center">
                    <!-- <input type="text" class="form-control col-12" name="price_per_unit" v-model="price_per_unit" @input="onlyNumeric"> -->
                    <vue-numeric
                        separator=","
                        v-bind:precision="2"
                        v-bind:minus="false"
                        class="form-control col-12"
                        v-model="price_per_unit"
                    ></vue-numeric>
                    <input type="hidden" name="price_per_unit" :value="price_per_unit">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> หน่วย </strong> <span class="text-danger">*</span>
                </div> 
                <div align="center">
                    <!-- <input type="hidden" name="simu_uom" value="simu_uom"> 
                    <el-select v-model="simu_uom" placeholder="Select" class="w-100">
                        <el-option
                        v-for="uom in uoms"
                        :key="uom.uom_code"
                        :label="uom.description"
                        :value="uom.uom_code">
                        </el-option>
                    </el-select> -->
                    <input type="hidden" name="simu_uom" :value="simu_uom" autocomplete="off">
                    <el-select  class="w-100"
                                v-model="simu_uom"
                                filterable
                                remote
                                reserve-keyword
                                clearable>              
                        <el-option  v-for="uom in uoms"
                                    :key="uom.uom_code"
                                    :label="uom.description"
                                    :value="uom.uom_code">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> การใช้งาน </strong>
                </div>
                <div>
                    <input type="checkbox" name="active_flag" v-model="active_flag">
                </div>
            </div>
        </div>
        <!-- <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> วันที่เริ่ม </strong>
                </div>
                <div align="center">
                    <el-date-picker class="w-100"
                        v-model="start_date"
                        type="date"
                        placeholder="Pick a Date"
                        name="start_date"
                        format="dd-MM-yyyy"
                        value-format="dd-MM-yyyy"
                    >
                    </el-date-picker>
                </div>
            </div>
        </div> -->
        <!-- <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> วันที่สิ้นสุด </strong>
                </div>
                <div align="center" >
                <el-date-picker class="w-100"
                    v-model="end_date"
                    type="date"
                    placeholder="Pick a Date"
                    name="end_date"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                >
                </el-date-picker>
                </div>
            </div>
        </div> -->
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> หมายเหตุ </strong>
                </div>
                <div>
                    <el-input type="textarea" class="required" name="remark" v-model="remark" rows="3" maxlength="255" show-word-limit/>
                </div>
            </div>
        </div>

        
    </div>
</template>

<script>

import DatePicker from 'element-ui';
import VueNumeric from 'vue-numeric';
// Vue.use(DatePicker);

export default {
    props: ['simulationTypes', 'uoms', 'defaultValue', 'old', 'checkTransection'],
    components: {
        VueNumeric
    },
    data(){

        return {
            start_date:      this.defaultValue           ? this.defaultValue.start_date  : '',
            end_date:        this.defaultValue           ? this.defaultValue.end_date    : '',
            simu_uom:        this.old.simu_uom           ? this.old.simu_uom             : this.defaultValue  ? this.defaultValue.simu_uom        : '',
            simu_type:       this.old.simu_type          ? this.old.simu_type            : this.defaultValue  ? this.defaultValue.simu_type       : '',
            simu_raw_num:    this.old.simu_raw_num       ? this.old.simu_raw_num         : this.defaultValue  ? this.defaultValue.simu_raw_num    : '',
            description:     this.old.description        ? this.old.description          : this.defaultValue  ? this.defaultValue.description     : '',
            price_per_unit:  this.old.price_per_unit     ? this.old.price_per_unit       : this.defaultValue  ? this.defaultValue.price_per_unit  : '',
            remark:          this.old.remark             ? this.old.remark               : this.defaultValue  ? this.defaultValue.remark          : '',
            active_flag:     this.old.active_flag == 'Y' ? true : this.defaultValue      ? this.defaultValue.active_flag == 'Y' ? true : false : true,
            totalcharacter: 0,
            
        }
    },
    methods: {
        onlyNumeric() {
            this.price_per_unit = this.price_per_unit.replace(/[^0-9 .]/g, '');
        },
        charCount: function(){

         this.totalcharacter = this.remark.length;

       },
    }
}
</script>
