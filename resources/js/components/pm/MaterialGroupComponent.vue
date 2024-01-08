<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row" style="padding-left: 15px; padding-top: 15px; padding-bottom: 15px;  padding-right: 15px;">
                    <div class="col-md-6">
                        <label>รหัสแผนก</label><span class="text-danger"> *</span>
                        <input type="hidden" name="dept_code" v-model="departmentSelected">
                        <el-select  v-model="departmentSelected" clearable filterable 
                                    @change="getDepartmentDescription"
                                    placeholder="เลือกรหัสแผนก" 
                                    class="w-100">
                            <el-option
                                v-for="department in departments"
                                :key="department.department_code"
                                :label="department.department_code"
                                :value="department.department_code">
                            </el-option>
                        </el-select>
                    </div>

                    <div class="col-md-6">
                        <label>แผนก</label>
                        <el-input  v-model="departmentDescription" disabled
                                    placeholder="เลือกรหัสแผนก"  
                                    class="w-100">
                            <el-option
                                v-for="department in departments"
                                :key="department.department_code"
                                :label="department.description"
                                :value="department.department_code">
                            </el-option>
                        </el-input>

                    </div>
                </div>

                <div class="row" style="padding-left: 15px; padding-top: 15px; padding-bottom: 15px;  padding-right: 15px;">
                    <div class="col-md-6">
                        <label>รหัส</label><span class="text-danger"> *</span>
                        <input type="hidden" name="itemcat_group_code" v-model="materialGroupSelected">
                        <el-select  v-model="materialGroupSelected" clearable filterable 
                                    @change="getTypeDescription"
                                    placeholder="เลือกรหัส" 
                                    class="w-100">
                            <el-option
                                v-for="materialGroup in materialGroups"
                                :key="materialGroup.type_code"
                                :label="materialGroup.type_code"
                                :value="materialGroup.type_code">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-6">
                        <label>กลุ่มวัตถุดิบ</label>
                        <el-input  v-model="typeDescription" disabled
                                    placeholder="เลือกรหัส"  
                                    class="w-100">
                            <el-option
                                v-for="materialGroup in materialGroups"
                                :key="materialGroup.type_code"
                                :label="materialGroup.type_desc"
                                :value="materialGroup.type_code">
                            </el-option>
                        </el-input>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    props: ["departments", "materialGroups"],
    data() {
        return{
            departmentSelected: '',
            departmentDescription: '',
            materialGroupSelected: '',
            typeDescription: '',
        };
    },
    mounted() {

    },
    methods: {
        getDepartmentDescription: function () {
            var find = this.departments.find((item) => {
                if (item.department_code === this.departmentSelected) {
                    return item;
                }
            });
            this.departmentDescription = find ? find.description : '';
        },
        getTypeDescription: function () {
            var find = this.materialGroups.find((item) => {
                if (item.type_code === this.materialGroupSelected) {
                    return item;
                }
            });
            this.typeDescription = find ? find.type_desc : '';
        }
    },
    };
</script>