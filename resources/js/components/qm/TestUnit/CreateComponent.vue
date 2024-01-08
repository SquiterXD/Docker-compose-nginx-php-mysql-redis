<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ชื่อ หน่วยการทดสอบ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="qcunit_code" v-model="qcunit_code">
                        <el-input placeholder="กรุณากรอกชื่อหน่วยการทดสอบ" v-model="qcunit_code"></el-input>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>รายละเอียด หน่วยการทดสอบ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="qcunit_desc" v-model="qcunit_desc">
                        <el-input placeholder="กรุณากรอกรายละเอียดหน่วยการทดสอบ" v-model="qcunit_desc"></el-input>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>สถานะการใช้งาน</label><span class="text-danger"> *</span>
                        <input type="hidden" name="enable_flag" v-model="enable_flag">
                        <el-checkbox v-model="enable_flag" class="w-100"></el-checkbox>
                    </div>                        
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["oldInput"],
        data() {
            return{
                qcunit_code     : this.oldInput.length != 0 ? this.oldInput.qcunit_code : '',
                qcunit_desc     : this.oldInput.length != 0 ? this.oldInput.qcunit_desc : '',
                enable_flag     : this.oldInput.length != 0 ? this.oldInput.enable_flag == 'true' ? true : false : true,
            };
        },
        methods: {
            
        }
    };

</script>