<template>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <div> รหัส (Code) </div>
                    </th>
                    <th class="text-center">
                        <div> คำอธิบาย (Description) </div>
                    </th>
                    <th class="text-center" witdth="20%"> 
                        <div> รหัสบัญชี (Account Code) </div>
                    </th>
                    <th class="text-center">
                        <div> Active </div>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                    <tr v-for="account in accountAlls">
                        <td> {{ account.account_code }} </td>
                        <td> {{ account.description }} </td>
                        <td> {{ account.account_combine }} </td>
                        <td class="text-center">
                            <el-checkbox    v-model="account.active_flag"
                                            :checked="account.active_flag == 'Y' ? true : false"
                                            @change="changeActive(account, account.active_flag)">
                            </el-checkbox>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('ir.settings.account-mapping.edit', $account->account_id) }}" class="btn btn-warning btn-xs">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["accountAlls"],
    data() {
        return{

        };
    },
    methods: {
        async changeActive(data, flag){
            // var params = {
            //     group_product_id: data.group_product_id,
            //     active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
            // };
            // return await axios
            //     .get('/ir/ajax/product-groups/updateActiveFlag',{ params })
            //     .then(res => {
            //         if(res.data.status == 'success'){
            //             swal({
            //                 title: "Success !",
            //                 text: "บันทึกสำเร็จ",
            //                 type: "success",
            //                 showConfirmButton: true
            //             });
            //         }else{
            //             swal({
            //                 title: "Error !",
            //                 text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่",
            //                 type: "error",
            //                 showConfirmButton: true
            //             });
            //             data.active_flag = true;
            //         }
            //     });
        }
    },
}
</script>