<template>
    <div v-loading="loading">
        <div class="row">
            <div class="col-md" style="margin-left: 5px; margin-left: 5px;width: 530px;padding-left: 250px;padding-right: 250px;">
                <label>กรมธรรม์ชุดที่ (Policy No.)</label><span class="text-danger"> *</span>
                <input type="hidden" name="policy" v-model="policySelected">
                <el-select  v-model="policySelected" clearable filterable 
                            placeholder="เลือกชื่อจุดตรวจสอบ" 
                            class="w-100"
                            @change="createLine">
                    <el-option
                        v-for ="policySetHeader in policySetHeaders"
                        :key ="policySetHeader.policy_set_header_id"
                        :label ="policySetHeader.policy_set_number + ' : ' + policySetHeader.policy_set_description"
                        :value ="policySetHeader.policy_set_header_id">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="mt-2" v-if="this.create">
            <hr>
            <div class="text-right">
                <button :class="btnTrans.add.class + ' btn-sm'" 
                        type="submit" 
                        @click.prevent="addLine"> 
                    <i :class="btnTrans.add.icon" aria-hidden="true"></i> 
                    {{ btnTrans.add.text }} 
                </button>
            </div>
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th width="1%"> </th>
                        <th width="40%"> รหัส (Code) <span class="text-danger"> *</span></th>
                        <th width="40%"> คำอธิบาย (Description) <span class="text-danger"> *</span></th>
                        <!-- <th width="15%"> Active <span class="text-danger"> *</span></th> -->
                        <th width="4%"> </th>
                    </tr>
                </thead>
                <tbody v-if="this.lines.length == 0">
                    <tr>
                        <td colspan="4" class="text-center" style="vertical-align: middle;">
                            <h2> ยังไม่มีการเพิ่มรายการใหม่ </h2>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr v-for="(row, index) in lines" :key="index" :row="row">
                        <td style="vertical-align: middle;"> {{ index + 1 }} </td>
                        <td>
                            <input type="hidden" :name="'dataGroup['+row.id+'][sub_group_code]'" v-model="row.subGroupCode" autocomplete="off">
                            <el-input   placeholder="ระบุรหัส" v-model="row.subGroupCode"
                                        @change="checkDuplicateSubGroupCode(index)"></el-input>
                        </td>
                        <td>
                            <input type="hidden" :name="'dataGroup['+row.id+'][sub_group_description]'" v-model="row.subGroupDescription" autocomplete="off">
                            <el-input   placeholder="ระบุคำอธิบาย" v-model="row.subGroupDescription"
                                        @change="checkDuplicatesubGroupDescription(index)"></el-input>
                        </td>
                        <td style="vertical-align: middle;">
                            <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md" style="margin-left: 5px;width: 530px;padding-right: 250px;padding-top: 25px;">
                    <label>Active</label><span class="text-danger" style="padding-right: 15px;"> *</span>
                    <input type="hidden" name="active_flag" v-model="activeFlag" autocomplete="off">
                    <el-checkbox v-model="activeFlag"></el-checkbox>
                </div>
            </div>

            <div class="row clearfix text-right">
                <div class="col" style="margin-top: 15px;">
                    <button :class="btnTrans.save.class + ' btn-sm'" type="submit"> 
                        <i :class="btnTrans.save.icon" aria-hidden="true"></i> 
                        {{ btnTrans.save.text }} 
                    </button>
                    <a  :href="url" 
                        type="button" 
                        :class="btnTrans.cancel.class + ' btn-sm'">
                        <i :class="btnTrans.cancel.icon" aria-hidden="true"></i> 
                        {{ btnTrans.cancel.text }}
                    </a>
                </div>
            </div>
        </div>
    </div>     
</template>

<script>
    import uuidv1 from 'uuid/v1';
    export default {
    props: ["policySetHeaders", 'oldInput', 'url', 'btnTrans'],
    data() {
        return{
            policySelected : this.oldInput ? this.oldInput.oldPolicyHeaders : '',
            create : false,
            lines : [],
            id : uuidv1(),
            checked : true,
            subGroupCode : '',
            subGroupDescription : '',
            activeFlag : true,
            loading: false,
        };
    },
    mounted() {
        //
    },
    methods: {
        createLine(){
            this.create = true;
        },
        addLine() {
                this.lines.push({
                    id                  : uuidv1(),
                    checked             : true,
                    subGroupCode        : '',
                    subGroupDescription : '',
                });

                window.scrollTo({
                    top: document.body.scrollHeight,
                    left: 0,
                    behavior: 'smooth'
                });
            },
            addLine() {
                    this.lines.push({
                        id                  : uuidv1(),
                        checked             : true,
                        subGroupCode        : '',
                        subGroupDescription : '',
                        subGroupSource      : '',
                        activeFlag          : '',
                    });
                },
            removeRow: function (index) {
                this.lines.splice(index, 1);
            },
        },
        checkDuplicateSubGroupCode(index) {
            this.lines.forEach((element,i) => {
                if(i != index){
                     
                    if(this.lines[index].subGroupCode == element.subGroupCode){
                        swal({
                            title: "warning !",
                            text: "รหัสข้อมูลซ้ำ",
                            type: "warning",
                            showConfirmButton: true
                        });
                    }
                }
            });
        },
    };
</script>
