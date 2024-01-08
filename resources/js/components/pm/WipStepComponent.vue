<template>
    <div> 
        <div class="row">      
            <div class="col-md-4">
                <label> ขั้นตอนการทำงานของ <span class="text-danger">*</span></label>
                <el-input name="routing_no" v-model="routing_no" maxlength="9" :disabled="this.disableEdit"></el-input>
            </div>
            <div class="col-md-4">
                <label> Organization <span class="text-danger">*</span></label>
                <input type="hidden" name="organization_code"  :value="organization_code" autocomplete="off">
                <el-select  v-model="organization_code"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                :disabled="this.disableEdit">              
                    <el-option  v-for="organization in organizations"
                                :key="organization.organization_code"
                                :label="organization.organization_desc"
                                :value="organization.organization_code">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> การใช้งาน </label>
                <div>
                    <input type="checkbox" name="active_flag" v-model="active_flag">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> ขั้นตอนการทำงาน <span class="text-danger">*</span></label>
                <!-- <el-input name="wip_step" v-model="wip_step" :disabled="this.disableEdit"></el-input> -->

                <input type="hidden" name="wip_step"  :value="wip_step" autocomplete="off">
                <el-select  v-model="wip_step"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                :disabled="this.disableEdit">              
                    <el-option  v-for="option in openClass"
                                :key="option.oprn_class"
                                :label="option.oprn_class + ' : ' +option.oprn_class_desc"
                                :value="option.oprn_class">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                 <label> รายละเอียด <span class="text-danger">*</span></label>
                <el-input name="wip_step_desc" v-model="wip_step_desc" :disabled="this.disableEdit"></el-input>
            </div>
            <div class="col-md-4">
                <label> หน่วยนับผลผลิต <span class="text-danger">*</span></label>
                <input type="hidden" name="uom_code"  :value="uom_code" autocomplete="off">
                <el-select  v-model="uom_code"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                :disabled="this.disableEdit">              
                    <el-option  v-for="uom in uoms"
                                :key="uom.uom_code"
                                :label="uom.description"
                                :value="uom.uom_code">
                    </el-option>
                </el-select>
            </div>                  
        </div>
    </div>
</template>

<script>
export default {
    props: ['departments', 'uoms', 'organizations', 'openClass', 'defaultValue', 'old'],
    data() {
        return {
            wip_step:          this.old.wip_step          ? this.old.wip_step          : this.defaultValue ? this.defaultValue.wip_step           : '',
            wip_step_desc:     this.old.wip_step_desc     ? this.old.wip_step_desc     : this.defaultValue ? this.defaultValue.wip_step_desc      : '',
            uom_code:          this.old.uom_code          ? this.old.uom_code          : this.defaultValue ? this.defaultValue.uom_code           : '',
            organization_code: this.old.organization_code ? this.old.organization_code : this.defaultValue ? this.defaultValue.organization_code  : '',
            routing_no:        this.old.routing_no        ? this.old.routing_no        : this.defaultValue ? this.defaultValue.routing_no         : '',
            active_flag:       this.old.active_flag       ? this.old.active_flag       ? true : false : this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
            disableEdit:       this.defaultValue          ? true                       : false,
        }
    }
}
</script>