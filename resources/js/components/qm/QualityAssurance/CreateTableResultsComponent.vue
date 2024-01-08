<template>
    <div class="table-responsive">
        <div class="text-right" style="padding-bottom: 15px;padding-top: 15px;padding-right: 15px;">
            <button class="btn btn-sm btn-primary" @click.prevent="addLine"> 
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="font-size: small;">
                            <div>สถานะการใช้งาน</div>
                        </th>
                        <th class="text-center" style="font-size: small;">
                            <div>รายการตรวจสอบคุณภาพบุหรี่ <span class="text-danger">*</span></div>
                        </th>
                        <th class="text-center" style="font-size: small;">
                            <div>รายละเอียดการตรวจสอบคุณภาพบุหรี่ <span class="text-danger">*</span></div>
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in lines" :key="index">
                        <td class="text-center" style="vertical-align:middle;">
                            <input type="hidden" :name="'lines['+data.id+'][enabledFlag]'" v-model="data.enabledFlag" autocomplete="off">
                           <el-checkbox v-model="data.enabledFlag"></el-checkbox>
                        </td>
                        <td style="vertical-align:middle;">
                            <input type="hidden" :name="'lines['+data.id+'][tobaccoQTYchecklist]'" v-model="data.tobaccoQTYchecklist" autocomplete="off">
                            <el-input placeholder="รายการตรวจสอบคุณภาพบุหรี่" v-model="data.tobaccoQTYchecklist"></el-input>
                        </td>
                        <td style="vertical-align:middle;">
                            <input type="hidden" :name="'lines['+data.id+'][description]'" v-model="data.description" autocomplete="off">
                            <el-input placeholder="รายละเอียดการตรวจสอบคุณภาพบุหรี่" v-model="data.description"></el-input>
                        </td>
                        <td class="text-center" style="vertical-align:middle;">
                            <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import uuidv1 from 'uuid/v1';
export default {
    props: [ ],
    data() {
        return {
            lines: [],
        };
    },
    mounted() { 
        this.addLine()
    },
    methods: {
        addLine() {
            this.lines.push({
                id : uuidv1(),
                enabledFlag : true,
                tobaccoQTYchecklist : '',
                description : ''
            });
        },  
        removeRow: function(index) {    
            this.lines.splice(index, 1);
        },  
    }
};
</script>
