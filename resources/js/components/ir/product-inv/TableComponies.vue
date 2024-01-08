<template>
    <div class="table-responsive" style="max-height: 500px;">
        <div class="table" id="table">
            <table class="table table table-bordered myTable" style="position: sticky;">
                <thead>            
                    <tr>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">กรมธรรม์ชุดที่</th>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">กลุ่มของทรัพย์สิน</th>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">รายการ</th>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">รหัสหน่วยงาน</th>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">รหัสคลังสินค้า</th>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">กลุ่มสินค้าย่อย</th>
                        <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Active</th>
                        <th style="width: 78px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;"> </th>
                    </tr>
                </thead>
                <tbody v-if="headers.length != 0"> 
                        <tr v-for="(header, index) in headers" :key="index">
                            <td class="text-left" style="font-size:11px; vertical-align:middle;" :data-sort="header.group_product.policy_set_header.policy_set_number">
                                {{ (header.group_product ? header.group_product.policy_set_header : '') ? header.group_product.policy_set_header.policy_set_number+' : '+header.group_product.policy_set_header.policy_set_description : '' }}
                            </td>
                            <td class="text-left" style="font-size:11px; vertical-align:middle;">
                                {{ (header.group_product ? header.group_product.asset_group : '') ? header.group_product.asset_group.meaning+' : '+header.group_product.asset_group.description : '' }}
                            </td>
                            <td class="text-left" style="font-size:11px; vertical-align:middle;">
                                {{ header.group_product ? header.group_product.description : '' }}
                            </td>
                            <td class="text-left" style="font-size:11px; vertical-align:middle;">
                                <!-- {{ header.department ? header.department.department_code+' : '+header.department.description : '' }} -->
                                {{ header.department_code+ ' : ' +header.department_desc }}
                            </td>
                            <td class="text-left" style="font-size:11px; vertical-align:middle;">
                                <!-- {{ header.sub_inventory ? header.sub_inventory.subinventory_code+' : '+ header.sub_inventory.subinventory_desc : '' }} -->
                                {{  header.subinventory_code+ ' : ' + header.subinventory_desc }}
                            </td>
                            <td class="text-left" style="font-size:11px; vertical-align:middle;">
                                <!-- {{ header.sub_groups ? header.sub_groups.sub_group_description : '' }} -->
                                {{ header.sub_group_code+ ' : ' +header.sub_group_desc }}
                            </td>
                            <td class="text-center" style="font-size:12px; vertical-align:middle;">
                                <!-- <el-checkbox    v-model="header.flag"
                                                :checked="header.active_flag == 'Y' ? true : false"
                                                :id="'test'+header.header_id"
                                                @change="changeActive(header.header_id, header.flag)">
                                </el-checkbox> -->
                                <input  type="checkbox" 
                                        :id="'checkbox'+header.header_id" 
                                        @change="changeActive(header.header_id)" 
                                        :checked="header.showFlag">
                            </td>
                            <!-- <td class="text-center" style="font-size:11px; vertical-align:middle;">
                                <input  type="checkbox"
                                        value="{{$header->active_flag}}"
                                        name="active{{$header->header_id}}"
                                        onchange="changeActive({
                                            'code': '{{$header->header_id}}',
                                            'flg': '{{$header->active_flag}}'
                                        })">
                            </td> -->
                            <td class="text-center" style="font-size:11px; vertical-align:middle;">                       
                                <a  type="button" 
                                    :href="'/ir/settings/product-header/'+ header.header_id +'/edit'" 
                                    class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                                </a>
                            </td>  
                        </tr>    
                </tbody>
                <tbody v-else> 
                    <tr>
                        <td colspan="8">
                            <h3 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h3>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['headers'],
    data() {
        return {

        };
    },
    mounted() {
        $('.myTable').dataTable( {
            "searching": false,
            "bInfo": false,
        });
    },
    computed:{
        
    },
    methods: {
        async changeActive(data){
            let flag = $(`#checkbox${data}`).is(':checked');
            var params = {
                header_id: data,
                active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
            };
            return await axios
                .get('/ir/ajax/product-header/updateActiveFlag',{ params })
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
                            text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่",
                            type: "error",
                            showConfirmButton: true
                        });
                    }

                    if(res.data.status == 'IRM0004Close'){
                        swal({
                                title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                                text: "ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 และ IRM0005 ใช่ไหม?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: 'btn btn-warning',
                                confirmButtonText: "เปิดการใช้งาน",
                                closeOnConfirm: false
                            },                    
                            function (isConfirm) {
                                var params = {
                                    header_id: data,
                                    confirm: isConfirm,
                                    active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
                                };
                                if(isConfirm){
                                    axios   .get('/ir/ajax/product-header/updateActiveFlag',{ params })
                                            .then( res =>{ 
                                                swal({  title: "success !", 
                                                        text: "บันทึกสำเร็จ", 
                                                        type: "success",
                                                        showConfirmButton: true
                                                });
                                                // window.location.reload(false); 
                                                $(`#checkbox${data}`).prop('checked', true) 
                                            });   
                                }else{
                                    $(`#checkbox${data}`).prop('checked', false)
                                }
                            });  
                    }
                    if(res.data.status == 'twoClose'){
                        swal({
                                title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                                text: "ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า และ IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 IRM0009 และ IRM0005 ใช่ไหม?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: 'btn btn-warning',
                                confirmButtonText: "เปิดการใช้งาน",
                                closeOnConfirm: false
                            },                    
                            function (isConfirm) {
                                var params = {
                                    header_id: data,
                                    confirm: isConfirm,
                                    active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
                                };
                                if(isConfirm){
                                    axios   .get('/ir/ajax/product-header/updateActiveFlag',{ params })
                                            .then( res =>{ 
                                                swal({  title: "success !", 
                                                        text: "บันทึกสำเร็จ", 
                                                        type: "success",
                                                        showConfirmButton: true
                                                });
                                                // window.location.reload(false); 
                                                $(`#checkbox${data}`).prop('checked', true) 
                                            });   
                                }else{
                                    $(`#checkbox${data}`).prop('checked', false)
                                }
                            });  
                    }
                    if(res.data.status == 'IRM0009Close'){
                        swal({
                                title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                                text: "ข้อมูลหน้า IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0009 และ IRM0005 ใช่ไหม?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: 'btn btn-warning',
                                confirmButtonText: "เปิดการใช้งาน",
                                closeOnConfirm: false
                            },                    
                            function (isConfirm) {
                                var params = {
                                    header_id: data,
                                    confirm: isConfirm,
                                    active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
                                };
                                if(isConfirm){
                                    axios   .get('/ir/ajax/product-header/updateActiveFlag',{ params })
                                            .then( res =>{ 
                                                swal({  title: "success !", 
                                                        text: "บันทึกสำเร็จ", 
                                                        type: "success",
                                                        showConfirmButton: true
                                                });
                                                // window.location.reload(false);
                                                $(`#checkbox${data}`).prop('checked', true) 
                                            });   
                                }else{
                                    $(`#checkbox${data}`).prop('checked', false)
                                }
                            });  
                    }
                });
        }
    }
};
</script>