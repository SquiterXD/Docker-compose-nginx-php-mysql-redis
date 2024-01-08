<template>
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-8">

                <!-- <input type="hidden" name="test_unit_id" v-model="test_unit_id"> -->

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ชื่อ หน่วยการทดสอบ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="qcunit_code" v-model="qcunit_code">
                        <el-input placeholder="กรุณากรอกชื่อหน่วยการทดสอบ" v-model="qcunit_code" :disabled="true" ></el-input>
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
        props: ["units"],
        data() {
            return{
                test_unit_id    : this.units ? this.units.test_unit_id : '',
                qcunit_code     : this.units ? this.units.qcunit_code : '',
                qcunit_desc     : this.units ? this.units.qcunit_desc : '',
                enable_flag     : this.units ? this.units.enable_flag == 'Y' ? true : false : '',
            };
        },
        mounted() {
            // console.log(this.units);
        },
        methods: {
            
        }
    };

</script>