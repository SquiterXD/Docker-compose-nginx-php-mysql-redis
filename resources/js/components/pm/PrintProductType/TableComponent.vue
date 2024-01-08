<template>
    <div>
        <table class="table program_info_tb">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-center" style="font-size: small;">
                        <div>ประเภทสิ่งพิมพ์</div>
                    </th>
                    <th class="text-center" style="font-size: small;">
                        <div>Product</div>
                    </th>
                    <th class="text-center" style="font-size: small;">
                        <div>วันที่เริ่มต้นใช้งาน</div>
                    </th>
                    <th class="text-center" style="font-size: small;">
                        <div>วันที่สิ้นสุดใช้งาน</div>
                    </th>
                    <!-- <th></th> -->
                </tr>
            </thead>

            <tbody>
                <tr v-for="(product, index) in listData" :key="index" :row="index">
                    <td>
                        <el-checkbox v-model="product.checkedEditUpdate" @change="checkEdit(product.checkedEditUpdate, product)"></el-checkbox>
                    </td>
                    <input  type="hidden" 
                            :name="'dataGroup['+index+'][flex_value_id]'" 
                            v-model="product.flex_value_id" 
                            autocomplete="off">
                    <input  type="hidden" 
                            :name="'dataGroup['+index+'][flex_value_set_id]'" 
                            v-model="product.flex_value_set_id" 
                            autocomplete="off">
                    <td>
                        <el-input
                            v-model="product.description"
                            :disabled="true">
                        </el-input>
                    </td>
                    <td>
                        <input  type="hidden" 
                            :name="'dataGroup['+index+'][attribute26]'" 
                            v-model="product.attribute26" 
                            autocomplete="off">
                        <el-input   placeholder="โปรดกรอก Product" 
                                    v-model="product.attribute26"
                                    :disabled="product.is_select">
                        </el-input>
                    </td>
                    <td>
                        <input  type="hidden" 
                                :name="'dataGroup['+index+'][start_date_active]'"
                                v-model="product.start_date_active" 
                                autocomplete="off">
                        <datepicker-th
                            style="width: 100%;"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            :name="'dataGroup['+index+'][start_date]'"
                            :placeholder="product.start_date_active ? product.start_date_active : ''"
                            v-model="index.start_date"
                            format="DD-MM-YYYY"
                            :disabled="product.is_select"/>
                    </td>
                    <td>
                        <input  type="hidden" 
                                :name="'dataGroup['+index+'][end_date_active]'"
                                v-model="product.end_date_active" 
                                autocomplete="off">
                        <datepicker-th
                            style="width: 100%;"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            :name="'dataGroup['+index+'][end_date]'"
                            :placeholder="product.end_date_active ? product.end_date_active : ''"
                            v-model="index.end_date"
                            format="DD-MM-YYYY"
                            :disabled="product.is_select"/>
                    </td>
                    <!-- <td>
                        <button @click.prevent="removeRowTableData(index, products.flex_value_id)" class="btn btn-sm btn-danger col text-center">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td> -->
                </tr>
            </tbody>
        </table>
        <div class="col-12 mt-3">
            <div class="row clearfix text-right">
                <div class="col" style="margin-top: 15px;">
                    <button :class="btnTrans.save.class" type="submit"> 
                        <i :class="btnTrans.save.icon" aria-hidden="true"></i> 
                        {{ btnTrans.save.text }} 
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: ['products', 'listProducts', 'btnTrans'],
    data() {
        return {
            // listProducts: this.products.data,
            listData: this.listProducts,
            // start_date: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : moment().add(543, 'years').toDate(),
            start_date: '',
            end_date: '',
            checkedEditUpdate: '',
        }
    }, 
    
    mounted(){
    },

    methods: {
        checkEdit(checkedEditUpdate, products) {
            if(checkedEditUpdate){
                products.is_select = false;
            }else{
                products.is_select = true;
            }
        },

        removeRowTableData: function(index, flexValueId){
            var params = {
                index : index,
                flexValueId : flexValueId
            };
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                },                    
                function (isConfirm) {
                    if(isConfirm){
                        axios   .get('/pm/ajax/print-product-type/destroy',{ params })
                                .then( res =>{ 
                                    swal({  title: "success !", 
                                            text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว", 
                                            type: "success",
                                            showConfirmButton: false
                                    });
                                    window.location.reload(false); 
                                });   
                    }
            });  
        },

    },

}
</script>