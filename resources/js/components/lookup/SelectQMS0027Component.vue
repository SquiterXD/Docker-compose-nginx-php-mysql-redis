<template>
    <div>
        <div v-if="column.column_name == 'ENABLED_FLAG'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                        <div v-if="column.strRequiredFlag">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" :value="data_value" autocomplete="off">
                        <el-checkbox    v-model="data_value" 
                                        size="large"
                                        :checked="data_value"/>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="column.column_name == 'ATTRIBUTE2'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                        <div v-if="column.strRequiredFlag">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value">
                        <el-select  class="w-100"
                                    v-model="data_value"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    @change="getDetails(data_value)">              
                            <el-option  v-for="list in this.dataLists"
                                        :key="list.value"
                                        :label="list.label"
                                        :value="list.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-if="column.column_name == 'ATTRIBUTE7'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value" id='attribute7Value'>
                        <el-input v-model="data_value" disabled id='attribute7'/>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="column.column_name == 'ATTRIBUTE4'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value" id='attribute4Value'>
                        <el-input v-model="data_value" id='attribute4'/>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="column.column_name == 'ATTRIBUTE2'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ 'ประเภทเครื่องจักร' }} </strong>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" name="MACHINE_TYPE_DESC" autocomplete="off" id='machineTypeDescValue'>
                        <el-input disabled id='machineTypeDesc'/>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="column.column_name == 'ATTRIBUTE12'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                        <div v-if="column.strRequiredFlag">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value">
                        <el-select  class="w-100"
                                    v-model="data_value"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable>              
                            <el-option  v-for="list in this.dataLists"
                                        :key="list.value"
                                        :label="list.label"
                                        :value="list.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="this.dataName == 'ATTRIBUTE5'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                        <div v-if="column.strRequiredFlag">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value">
                        <el-select  class="w-100"
                                    v-model="data_value"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    v-bind:id="'attribute5'">              
                            <el-option  v-for="list in this.dataLists"
                                        :key="list.value"
                                        :label="list.label"
                                        :value="list.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="this.dataName == 'ATTRIBUTE8'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                        <div v-if="column.strRequiredFlag">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value">
                        <el-select  class="w-100"
                                    v-model="data_value"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable>              
                            <el-option  v-for="list in this.dataLists"
                                        :key="list.value"
                                        :label="list.label"
                                        :value="list.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="this.dataName == 'ATTRIBUTE6'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ column.column_prompt }} </strong>
                        <div v-if="column.strRequiredFlag">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value">
                        <el-select  class="w-100"
                                    v-model="data_value"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable>              
                            <el-option  v-for="list in this.dataLists"
                                        :key="list.value"
                                        :label="list.label"
                                        :value="list.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['programColumn', 'dataName', 'dataLists', 'defaultValue'],
    data() {
        return {
            column: this.programColumn,
            data_value: this.defaultValue
        };
    },
    mounted(){
        if(this.column.column_name == 'ENABLED_FLAG'){
            this.data_value = this.defaultValue == null ? true : this.defaultValue == 'Y' ? true : false;
        }

        if( this.column.column_name == 'ATTRIBUTE2' && 
            this.defaultValue != null &&
            this.defaultValue != '' ){
            let item = this.dataLists.find((item) => item.resource_code == this.defaultValue);
            this.data_value = item.value;
            this.getDetails(this.data_value);
        }
    },
    methods: {
        getDetails(id) {
            let item = this.dataLists.find((item) => item.value == id);
            $('#attribute7').val(item.asset_description);
            $('#attribute7Value').val(item.asset_description);  
            $('#machineTypeDesc').val(item.machine_type_desc);  
            $('#machineTypeDescValue').val(item.machine_type_desc);
            $('#machineRelation').val(item.machine_relation);   
            $('#machineRelationValue').val(item.machine_relation);
            $('#attribute8').val(item.stock_locator);
            $('#attribute8Value').val(item.stock_locator);
        },
    },
}
</script>