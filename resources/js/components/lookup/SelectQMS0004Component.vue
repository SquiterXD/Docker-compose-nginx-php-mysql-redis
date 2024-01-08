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
                        <!-- <input type="hidden" :name="this.dataName" :value="data_value" autocomplete="off"> -->
                        <!-- <el-checkbox v-model="data_value" size="large" /> -->
                        <!-- <input type="checkbox" v-model="data_value" size="large"> -->
                        <input type="checkbox" :name="this.dataName" v-model="data_value" size="large">
                    </div>
                </div>
            </div>
        </div>

        <div v-if="column.column_name == 'MEANING'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <div v-if="column.strRequiredFlag">
                            <strong> {{ column.column_prompt }} </strong>
                            <span class="text-danger">*</span>
                        </div>
                        <div v-else>
                            <strong> {{ column.column_prompt }} </strong>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" class="form-control col-12" :name="this.dataName" v-model="data_value">
                        <el-input v-model="data_value"></el-input>
                    </div>                    
                </div>
            </div>
        </div>
        
        <div v-if="column.column_name == 'DESCRIPTION'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <div v-if="column.strRequiredFlag">
                            <strong> {{ column.column_prompt }} </strong>
                            <span class="text-danger">*</span>
                        </div>
                        <div v-else>
                            <strong> {{ column.column_prompt }} </strong>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value">
                        <el-input v-model="data_value"></el-input>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="column.column_name == 'ATTRIBUTE2'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <div v-if="column.strRequiredFlag">
                            <strong> {{ column.column_prompt }} </strong>
                            <span class="text-danger">*</span>
                        </div>
                        <div v-else>
                            <strong> {{ column.column_prompt }} </strong>
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
                                    @change="getDetailProcess(data_value)">              
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

        <div v-if="column.column_name == 'ATTRIBUTE1'">
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <div v-if="column.strRequiredFlag">
                            <strong> {{ column.column_prompt }} </strong>
                            <span class="text-danger">*</span>
                        </div>
                        <div v-else>
                            <strong> {{ column.column_prompt }} </strong>
                        </div>
                    </div>
                    <div class="col-12" align="left">
                        <input type="hidden" :name="this.dataName" autocomplete="off" :value="data_value" id="attribute1Value">
                        <el-input v-model="data_value" disabled id="attribute1"></el-input>
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
            this.data_value = this.defaultValue == 'Y' ? true : false;
        }
    },
    methods: {
        getDetailProcess(id) {
            let item = this.dataLists.find((item) => item.value == id);
            $('#attribute1').val(item.attribute8).trigger("change");
            $('#attribute1Value').val(item.attribute8).trigger("change");
        },
    },
}
</script>