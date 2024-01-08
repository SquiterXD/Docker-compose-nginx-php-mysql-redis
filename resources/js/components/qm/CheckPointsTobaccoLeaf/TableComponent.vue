<template>
    <div class="table-responsive">
        <table class="table program_info_tb dataTable">
            <thead>
                <tr>
                    <th class="text-center">
                        <div>สถานะการใช้งาน</div>
                    </th>
                    <th class="text-left">
                        <div>ชื่อจุดตรวจสอบ</div>
                    </th>
                    <th class="text-left">
                        <div>รายละเอียดจุดตรวจสอบ</div>
                    </th>
                    <th class="text-left">
                        <div>กลุ่มงาน</div>
                    </th>
                    <th class="text-center">
                        <div>รูปภาพประกอบ</div>
                    </th>
                    <th class="text-center">
                        <div> </div>
                    </th>
                </tr>
            </thead>
            <!-- <tbody v-if="this.checkPoints.data.length == 0">
                <tr>
                    <td class="text-center" colspan="7">
                        <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">ไม่มีข้อมูลในระบบ</h2>
                    </td>
                </tr>
            </tbody> -->
            <tbody>
                <tr v-for="(data, index) in this.checkPoints" :key="index" :row="data">
                    <td class="text-center" style="vertical-align:middle;" :data-sort="data.enabled_flag">
                        <div v-if="data.enabled_flag == 'Y'">
                            <i class="fa fa-check-circle text-success"></i>
                        </div>
                        <div v-else>
                            <i class="fa fa-circle text-muted"></i>
                        </div>
                    </td>
                    <td class="text-left" style="vertical-align:middle;">
                        {{ data.location_desc }}
                    </td>
                    <td class="text-left" style="vertical-align:middle;">
                        {{ data.locator_desc }}
                    </td>
                    <td class="text-left" style="vertical-align:middle;">
                        {{ data.qm_group }}
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <!-- Button trigger modal -->
                        <button type="button" 
                                class="btn btn-primary" 
                                data-toggle="modal" 
                                :data-target="'#exampleModalScrollable'+data.inventory_location_id"
                                :disabled="data.isAttachments">
                            <i class="fa fa-file-image-o" aria-hidden="true"></i> ดูรูปภาพ
                        </button>

                        <!-- Modal -->
                        <div    class="modal fade" 
                                :id="'exampleModalScrollable'+data.inventory_location_id" 
                                tabindex="-1" 
                                role="dialog" 
                                :aria-labelledby="'exampleModalScrollableTitle'+data.inventory_location_id" 
                                aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">ดูแนบรูปภาพ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li
                                            v-for="attach in data.attachments"
                                            :key="attach.attachment_id"
                                            style="text-align: left;"
                                        >
                                            <a  :target="hrefTarget" 
                                                :href="'attachments/'+ attach.attachment_id +'/imageCheckPoints'"
                                            >
                                                {{ attach.file_name }}
                                            </a>
                                            <a @click="removeFile(attach.attachment_id)">
                                                <i class="fa fa-close" style="color: red; text-align: right;"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <a  type="button" 
                            :href="'/qm/settings/check-points-tobacco-leaf/'+ data.inventory_location_id +'/edit'" 
                            class="btn btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['checkPoints', 'profile'],
        data() {
            return{
                hrefTarget : '_blank'
            };
        },
        mounted() {
            $('.dataTable').dataTable( {
                "searching": false,
                "bInfo": false,
                columnDefs: [
                   { orderable: false, targets: 4 },
                   { orderable: false, targets: 5 }
                ]
            });
        },
        methods: {
            removeFile(id){
                let programCode = this.profile.program_code
                swal({
                    title: "คุณแน่ใจ?",
                    text: "คุณที่จะต้องการลบรูปภาพนี้ใช่ไหม ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: false
                },                    
                function (isConfirm) {
                    if(isConfirm){
                        return axios
                        .get('/qm/ajax/attachments/'+ id + '/' + programCode +'/deleteByPKGCheckPoints')
                        .then(res => {
                            console.log(res.data.message);
                            if(res.data.message == "Success"){
                                swal({
                                    title: "success !",
                                    text: "ลบรูปภาพสำเร็จ !",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                setTimeout(() => {
                                    window.location.reload(false); 
                                }, 3000)
                            } 
                        });
                    }
                });
            }
        }
    };

</script>