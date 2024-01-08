<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <input type="hidden" name="layout_id" v-model="layoutId" autocomplete="off">
            <div class="row" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                <div class="col-md-6">
                    <label>วันที่เริ่มต้นการใช้งาน</label>
                    <datepicker-th
                        style="width: 100%;"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="start_date_active"
                        placeholder="โปรดเลือกวันที่"
                        v-model="start_date"
                        format="DD-MM-YYYY">
                    </datepicker-th>
                </div>
                <div class="col-md-6">
                    <label>วันที่เลิกใช้งาน</label>
                    <datepicker-th
                        style="width: 100%;"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="end_date_active"
                        placeholder="โปรดเลือกวันที่"
                        v-model="end_date"
                        format="DD-MM-YYYY">
                    </datepicker-th>
                </div>                                          
            </div>

            <div class="row" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                <div class="col">
                    <label>จำนวน Layout</label><span class="text-danger"> *</span>
                    <input type="hidden" name="numberLayout" v-model="numberLayout" autocomplete="off">
                    <!-- <el-input placeholder="โปรดกรอกจำนวน Layout" v-model="numberLayout"></el-input> -->
                    <vue-numeric 
                        placeholder="จำนวน Layout"
                        separator="," 
                        v-bind:precision="0" 
                        v-bind:minus="false"
                        class="form-control w-100 text-right"
                        v-model="numberLayout"
                    ></vue-numeric>
                </div>                        
            </div>

            <div class="row" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                <div class="col-md-6">
                    <label>หน่วย</label><span class="text-danger"> *</span>
                    <el-input :disabled="true" placeholder="Please input" v-model="unit"></el-input>
                </div>   
                <div class="col-md-6" style="padding-top: 26px;">
                    <el-input :disabled="true" placeholder="Please input" v-model="unitMeasure"></el-input>
                </div>                         
            </div>
            <div class="row" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                <div class="col-md-6">
                    <label>หน่วย</label>
                    <el-select name="custom_uom_code" style="width: 100%" v-model="customUomCode" placeholder="Select" clearable filterable @change="(value)=>{
                            if (value && customUomList.length > 0) {
                                let query = customUomList.findIndex(o => o.value == value);
                                    query = customUomList[query];
                                    customUomName = query.label;
                            } else {
                                customUomName = ''
                            }
                        }">
                        <el-option
                          v-for="item in customUomList"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                          >
                          <span style="float: left">{{ item.label }}</span>
                        </el-option>
                    </el-select>
                    <input type="hidden" name="custom_uom_code" :value="customUomCode">
                </div>
                <div class="col-md-6" style="padding-top: 26px;">
                    <el-input :disabled="true"  v-model="customUomName"></el-input>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
    props: ["setupLayout", "listDateLayout", 'customUomList'],
        data() {
            return {
                layoutId        : this.setupLayout.layout_id,
                start_date      : this.listDateLayout[0] ? this.listDateLayout[0].start_date : '',
                end_date        : this.listDateLayout[0] ? this.listDateLayout[0].end_date : '',
                numberLayout    : this.setupLayout ? this.setupLayout.layout_qty : '',
                unit            : this.setupLayout ? this.setupLayout.primary_uom_code : '',
                unitMeasure     : this.setupLayout ? this.setupLayout.primary_unit_of_measure : '',
                customUomCode   : this.setupLayout ? this.setupLayout.custom_uom_code : '',
                customUomName   : this.setupLayout ? this.setupLayout.custom_uom_name : '',
            };
        },

        mounted() {
            console.log(this.setupLayout);
        },

        methods: {
            
        }
    };
</script>