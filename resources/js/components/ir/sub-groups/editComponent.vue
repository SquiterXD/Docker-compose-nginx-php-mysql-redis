<template>
    <div>
        <input type="hidden" name="policyHeader" v-model="policyHeader" autocomplete="off">
        <div class="text-right">
            <button :class="btnTrans.add.class + ' btn-sm'" 
                    type="submit" 
                    @click.prevent="addLine" 
                    id="myBtn"> 
                <i :class="btnTrans.add.icon" aria-hidden="true"></i> 
                {{ btnTrans.add.text }} 
            </button>
        </div><br>
        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <th width="1%" class="text-center"> </th>
                    <th width="10%"> รหัส (Code) <span class="text-danger"> *</span></th>
                    <th width="20%"> คำอธิบาย (Description) <span class="text-danger"> *</span></th>
                    <th width="5%" class="text-center"> Active <span class="text-danger"> *</span></th>
                    <th width="5%" class="text-center"> </th>
                </tr>
            </thead>
            <tbody>
            <input type="hidden" name="policyHeader" v-model="policyHeader" autocomplete="off">
            <tr v-for="(row, index) in lines" :key="index" :row="row">
                <td class="text-center" style="vertical-align: middle;"> {{ index + 1 }} </td>
                <td>
                    <input type="hidden" :name="'dataGroup['+row.id+'][sub_group_id]'" v-model="row.subId" autocomplete="off">
                    <input type="hidden" :name="'dataGroup['+row.id+'][sub_group_code]'" v-model="row.subCode" autocomplete="off">
                    <el-input   placeholder="ระบุรหัส" v-model="row.subCode" size="mediem" :disabled="row.openRow"
                                @change="checkDuplicateSubGroupCode(index)"></el-input>
                </td>
                <td>
                    <input type="hidden" :name="'dataGroup['+row.id+'][sub_group_description]'" v-model="row.subDescription" autocomplete="off">
                    <el-input   placeholder="ระบุคำอธิบาย" v-model="row.subDescription" size="mediem"></el-input>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <input type="hidden" :name="'dataGroup['+row.id+'][active_flag]'" v-model="row.active" autocomplete="off">
                    <el-checkbox  @change="checkInactive(row, index)"  v-model="row.active" class="text-center"></el-checkbox>
                </td>
                <td class="text-center" style="vertical-align: middle;" v-if="row.delRow">
                    <button id="click" @click.prevent="removeRow(index, row.delRow, row)" class="btn btn-sm btn-danger">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </td>
                <td class="text-center" style="vertical-align: middle;" v-else>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import uuidv1 from 'uuid/v1';
    export default {
        props: ["policySets", "header", 'subLines', 'btnTrans'],
        data() {
            return{
                lines: [],
                id: uuidv1(),
                policyHeader: this.header.policy_set_header_id,
                activeRow: '',
            };
        },
        mounted() {
            this.subLines.forEach(subLine => {
                this.lines.push({
                    id: uuidv1(),
                    subId: subLine.sub_group_id,
                    subCode: subLine.sub_group_code,
                    subGroupSource: subLine.sub_group_source, 
                    subDescription: subLine.sub_group_description,
                    active: subLine.active_flag == 'Y'? true: false ,
                    openRow: true,
                    delRow: false,
                });
            });
        },
        methods: {
            addLine() {
                this.lines.push({
                    id: "Item #"+this.lines.length,
                    subGroupCode: '',
                    subGroupDescription: '',
                    subGroupSource: '',
                    active: true,
                    openRow: false,
                    // delRow: false,
                    delRow: true,
                });

                window.scrollTo({
                    top: document.body.scrollHeight,
                    left: 0,
                    behavior: 'smooth'
                });
                // scrollTo.top = Specifies the number of pixels along the Y axis to scroll the window or element.
                // scrollTo.left = Specifies the number of pixels along the X axis to scroll the window or element.
            },

            removeRow: function (index, delRow, row) {
                // var params = {
                //     sub_group_id    : row.subId,
                //     index           : index,
                // };
                // var dataLines = this;
                if(delRow){
                    this.lines.splice(index, 1);
                    // swal({
                    //     title: "Are you sure?",
                    //     text: "You will not be able to recover this data!",
                    //     type: "warning",
                    //     showCancelButton: true,
                    //     confirmButtonClass: 'btn btn-warning',
                    //     confirmButtonText: "Confirm",
                    //     closeOnConfirm: false
                    // },                    
                    // function (isConfirm) {
                    //     if(isConfirm){
                    //         axios   .get('/ir/ajax/sub-groups/destroy',{ params })
                    //                 .then( res =>{ 
                    //                     if(res.data.status === 's'){
                    //                         swal({  title: "success !", 
                    //                                 text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว", 
                    //                                 type: "success",
                    //                                 showConfirmButton: false
                    //                         });
                    //                         // dataLines.lines.splice(index, 1);
                    //                         window.location.reload(false); 
                    //                     }else if(res.data.status === 'e'){
                    //                         swal({  title: "Error !", 
                    //                                 text: "ไม่สามารถลบข้อมูลได้ เนื่อจากมีการใช้งานข้อมูลนี้อยู่", 
                    //                                 type: "error",
                    //                                 showConfirmButton: true
                    //                         });
                    //                     }
                    //                 });
                                    
                    //     }
                    // });  
                }else{
                    // this.lines.splice(index, 1);
                }
            },

            checkInactive(row, index) {
                var params = {
                    active: row.active ? 'Y' : 'N',
                    sub_group_code: row.subCode,
                    id: row.subId
                };
                 
                return axios
                    .get('/ir/ajax/sub-groups/check-inactive',{ params })
                    .then(res => {
                        if(res.data.status == 'success'){
                            swal({
                                title: "Success !",
                                text: "บันทึกสำเร็จ",
                                type: "success",
                                showConfirmButton: true
                            });
                        }else{
                            swal({
                                title: "Error !",
                                text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่ที่หน้าจอ IRM0005",
                                type: "error",
                                showConfirmButton: true
                            });
                            row.active = true;
                        }
                    });
            },

            checkDuplicateSubGroupCode(index) {
                this.lines.forEach((element,i) => {
                    if(i != index){
                        if(this.lines[index].subCode == element.subCode){
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
        },
    };
</script>