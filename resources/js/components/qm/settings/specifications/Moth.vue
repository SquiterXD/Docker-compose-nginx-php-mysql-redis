<template>
    <div class="col-12">
        <div class="row form-group">
            <label class="col-md-2 col-form-label text-right"> อาคาร </label>
            <div class="col-md-4">
                <input type="hidden" name="building" :value="building">
                <el-select
                    v-model="building"
                    placeholder=""
                    class="w-100"
                    size="medium"
                    :clearable="true"
                    :filterable="true"
                    @change="showLocation"
                >
                    <el-option
                        v-for="(mothBuilding, index) in mothBuildings"
                        :key="index"
                        :label="index"
                        :value="index"
                    >
                    </el-option>
                </el-select>
            </div>
            <label class="col-md-1 col-form-label text-right"> หน่วยงาน </label>
            <div class="col-md-4">
                <input type="hidden" name="department" :value="department">
                <el-select
                    v-model="department"
                    placeholder=""
                    class="w-100"
                    size="medium"
                    :clearable="true"
                    :filterable="true"
                    @change="changeDept()"
                >
                    <el-option
                        v-for="(dep, index) in departments"
                        :key="index"
                        :label="index"
                        :value="index"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row form-group mt-3">
            <label class="col-md-2 col-form-label text-right"> จุดตรวจสอบ <span style="color: red;"> * </span></label>
            <input type="hidden" name="locator_id" :value="locator">
            <div class="col-md-4">
                <el-select
                    v-model="locator"
                    placeholder=""
                    class="w-100"
                    size="medium"
                    :clearable="true"
                    :filterable="true"
                >
                    <el-option
                        v-for="(loc, index) in locators"
                        :key="index"
                        :label="loc.location_desc + ' : ' + loc.locator_desc"
                        :value="loc.inventory_location_id"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "mothLocators", "mothBuildings", 'mothDepartments', 'oldInputs'
        ],
        data() {
            return {
                building: (this.oldInputs != undefined && this.oldInputs) ? this.oldInputs['building'] : null,

                department: (this.oldInputs != undefined && this.oldInputs) ? this.oldInputs['department'] : null,
                departments: [],

                locator: (this.oldInputs != undefined && this.oldInputs) ? this.oldInputs['locator_id'] : null,
                locators: this.mothLocators,
                loading: false,
            };
        },
        watch: {
        },
        mounted() {
            this.showLocation();
        },
        methods: {
            async showLocation() {
                let vm = this;
                vm.departments = [];
                if (vm.building) {
                    vm.departments = vm.mothDepartments[vm.building];
                    vm.locators = vm.mothLocators.filter(o => {
                        return o.build_name == vm.building;
                    })
                }

                if (vm.department) {
                    vm.locators = vm.locators.filter(o => {
                        return o.department_name == vm.department;
                    })
                }

                if (!vm.building) {
                    vm.locators = vm.mothLocators;
                }
            },
            async changeDept() {
                let vm = this;
                vm.locator = '';
                vm.showLocation();
            }
        }
    }
</script>
<style scope>

    tr.duplicate_test_id > td {
        border: 4px solid #ED5565 !important;
    }

</style>