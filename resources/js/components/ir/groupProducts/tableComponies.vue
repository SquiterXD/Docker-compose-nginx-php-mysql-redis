<template>
    <div v-loading="loading" class="table-responsive" style="max-height: 500px;">
        <table class="table table-test table table-bordered" style="position: sticky;">
            <thead>
                <tr>
                    <th width="15%" class="text-center" style="font-size:12px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                        <div>กรมธรรม์ชุดที่</div>
                    </th>
                    <th width="20%" class="text-center" style="font-size:12px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                        <div>กลุ่มของทรัพย์สิน</div>
                    </th>
                    <th width="20%" class="text-center" style="font-size:12px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                        <div>รายการ</div>
                    </th>
                    <th width="20%" class="text-center" style="font-size:12px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                        <div>รหัสบัญชี</div>
                    </th>
                    <th width="1%" class="text-center" style="font-size:12px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                        <div>Active</div>
                    </th>
                    <th width="10%" class="text-center" style="font-size:12px; background-color: #fff; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                    </th>
                </tr>
            </thead>
            <tbody v-if="this.groupProducts.length != 0">
                <tr v-for="(data, index) in groupProducts" :key="index">
                    <td class="text-left" style="font-size:12px; vertical-align:middle;"
                        :data-sort="data.policy_set_headers.policy_set_number">
                        {{ data.policy_set_headers != null ? data.policy_set_headers.policy_set_number + ' : ' + data.policy_set_headers.policy_set_description : ''}}
                    </td>
                    <td class="text-left" style="font-size:12px; vertical-align:middle;"
                        :data-sort="data.asset_group ? data.asset_group.meaning : ''">
                        {{ data.asset_group ? data.asset_group.meaning+ ' : ' +data.asset_group.description : '' }}
                    </td>
                    <td class="text-left" style="font-size:12px; vertical-align:middle;">
                        {{ data.description }}
                    </td>
                    <td class="text-left" style="font-size:12px; vertical-align:middle;">
                        {{ data.mapping_acc ? data.mapping_acc.account_combine : '' }}
                    </td>
                    <td class="text-center" style="vertical-align:middle;" :data-sort="data.active_flag == 'Y' ? true : false">
                        <el-checkbox    v-model="data.flag"
                                        :checked="data.active_flag == 'Y' ? true : false"
                                        @change="changeActive(data, data.flag)">
                        </el-checkbox>
                    </td>
                    <td class="text-center" style="font-size:12px; vertical-align:middle;">
                        <a  type="button"
                            :href="'/ir/settings/product-groups/'+ data.group_product_id +'/edit' " 
                            :class="btnTrans.edit.class + ' btn-xs'">
                            <i :class="btnTrans.edit.icon" aria-hidden="true"></i> 
                            {{ btnTrans.edit.text }}
                        </a>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td class="text-center" style="font-size:18px; vertical-align:middle;" colspan="6">ไม่พบข้อมูล</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>

    export default {
        props: ["groupProducts", "btnTrans"],
        data() {
            return{
                loading: false,
                // groupProductsList: this.groupProducts,
                // currentPage: 1,
                // perPage: 10,
            };
        },
        computed: {
            // rows() {
            //     return this.groupProducts.length;
            // },
            // groupProductsList() {
            //     return this.groupProducts.slice(
            //         (   this.currentPage - 1) * this.perPage,
            //             this.currentPage * this.perPage,
            //     );
            // }
        },
        mounted() {
            $('.table-test').dataTable( {
                "searching": false,
                "bInfo": false,
                "order": [[ 0, 'asc'], [ 1, 'asc'], [2, 'asc']],
                columnDefs: [
                   { orderable: false, targets: 5 },
                ]
            });
        },
        methods: {
            async changeActive(data, flag){
                this.loading = true;
                var params = {
                    group_product_id: data.group_product_id,
                    active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
                };
                return await axios
                    .get('/ir/ajax/product-groups/updateActiveFlag',{ params })
                    .then(res => {
                        if(res.data.status == 'success'){
                            swal({
                                title: "Success !",
                                text: "บันทึกสำเร็จ",
                                type: "success",
                                showConfirmButton: true
                            });
                            this.loading = false;
                            setTimeout(() => {
                                window.location.reload(false); 
                            }, 3000)
                        }else{
                            swal({
                                title: "Error !",
                                text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่",
                                type: "error",
                                showConfirmButton: true
                            });
                            this.loading = false;
                            setTimeout(() => {
                                window.location.reload(false); 
                            }, 3000)
                        }
                    });
            }
        },
    };
</script>
