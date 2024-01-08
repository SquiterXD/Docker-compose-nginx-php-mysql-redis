<template>
    <div>
        <div class="row">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-4">
                <label> ประเภทลูกค้า <span class="text-danger">*</span></label>
                <input type="hidden" :value="selectCustomerType" name="customer_type">
                <el-select filterable class="w-100" v-model="selectCustomerType"  @change="getCheckPrimary()">
                    <el-option v-for="type in types"
                                :key="type.meaning"
                                :label="type.meaning + ' : ' + type.description"
                                :value="type.meaning">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ผู้มีอำนาจอนุมัติ <span class="text-danger">*</span></label>
                <input type="hidden" :value="selectEmployee" name="authority_id">
                <el-select filterable class="w-100" v-model="selectEmployee" @change="getPosition()">
                    <el-option v-for="authoRity in authoRityLists"
                                :key="authoRity.authority_id"
                                :label="authoRity.employee_name + ' : ' + authoRity.position_name"
                                :value="authoRity.authority_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> Email <span class="text-danger">*</span></label>
                <el-input name="email" v-model="email" ></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-4">
                <label> Status <span class="text-danger">*</span></label>
                <el-select class="w-100" name="status" v-model="selectStatus">
                    <el-option v-for="item in statusData"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> Primary Approval <span class="text-danger">*</span></label>
                <div class="ml-2">
                    <input type="checkbox" name="primary_approval"  v-model="primary_approval">
                </div>
            </div> 
        </div>
    </div>
</template>

<script>
    export default {
        props: ['types', 'authoRityLists', 'defaultValue'],
        data(){
            return {
                selectCustomerType:   this.defaultValue ? this.defaultValue.customer_type        : '',
                selectEmployee:       this.defaultValue ? Number(this.defaultValue.authority_id)  : '',
                selectStatus:         this.defaultValue ? this.defaultValue.status               : 'Active',

                geographies: [],
                position_name:        this.defaultValue ? this.defaultValue.position_name         : '',
                disablePosition:      this.defaultValue ? this.defaultValue.position_name         ? false : true : true,
                primary_approval:     this.defaultValue ? this.defaultValue.primary_approval == 'Y' ? true : false   : '',
                email:                this.defaultValue ? this.defaultValue.email         : '',

                statusData: [{
                    value: 'Active',
                    label: 'Active'
                }, {
                    value: 'Inactive',
                    label: 'Inactive'
                }],
            }
        },
        methods: {
            getPosition() {
                console.log(this.selectEmployee);
                if (this.selectEmployee) {
                    this.selectedData = this.authoRityLists.find( i => {
                        return i.authority_id == this.selectEmployee;
                    });
                    this.position_name = this.selectedData.position_name;
                    this.disablePosition = false;
                }

            },

            getCheckPrimary(){
                axios.get("/om/settings/customer/primary-approval", {
                    params: {
                        customer_type: this.selectCustomerType,
                    }
                })
                .then(res => {
                    if (!res.data) {
                        this.primary_approval = true;
                    } 

                })
            }
        },
    }
</script>
