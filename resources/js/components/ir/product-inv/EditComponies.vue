<template>
    <div v-loading="loading.page">
        <input type="hidden" name="subinventory_desc" v-model="subinventoryDesc" autocomplete="off">
        <input type="hidden" name="subinventory_code" v-model="subinventoryCode" autocomplete="off">
        <input type="hidden" name="productInvHeader" v-model="productInvHeader" autocomplete="off">
        <input type="hidden" name="groupProductId" v-model="groupProductId" autocomplete="off">
        <div class="mt-2">
            <div class="text-right">
                <button :class="btnTrans.add.class + ' btn-sm'" 
                        type="submit" 
                        @click.prevent="addLine"> 
                    <i :class="btnTrans.add.icon" aria-hidden="true"></i> {{ btnTrans.add.text }} 
                </button>
            </div><br>
            <div class="table-responsive"  style="max-height: 400px;">
                <table class="table-sm"  style="position: sticky;">
                    <thead>
                        <tr>
                            <th width="1%" class="sticky-col th-row"> </th>
                            <th width="70%" class="sticky-col th-row"> รหัสประเภท (Category Code) </th>
                            <th width="30%" class="sticky-col th-row"> Locator </th>
                            <th width="1%" class="sticky-col th-row"> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in lines" :key="index" :row="row" v-bind:class="[index == lines.length - 1 ? 'endTable' : '']">
                        <td style="vertical-align:middle;"> {{ index + 1 }} </td>
                        <td id='message'>  
                            <input type="hidden" :name="'dataGroup['+row.id+'][line_id]'" v-model="row.lineId" autocomplete="off">
                            <input type="hidden" :name="'dataGroup['+row.id+'][cate_codes]'" v-model="row.cate_code" autocomplete="off">
                            <el-select  v-model="row.cate_code"
                                        filterable
                                        remote
                                        clearable 
                                        reserve-keyword
                                        class="w-100"
                                        @change="checkDuplicateCategory(row, index)">
                                <el-option  v-for="(itemCategory,index) in itemCategories"
                                            :key="index"
                                            :label="itemCategory.lookup_code + ' : ' + itemCategory.description"
                                            :value="itemCategory.lookup_code">
                                </el-option>
                            </el-select>
                        </td>
                        <td>
                            <input type="hidden" :name="'dataGroup['+row.id+'][locators]'" v-model="row.locator" autocomplete="off">
                            <el-select  v-model="row.locator"
                                        filterable
                                        remote
                                        clearable  
                                        reserve-keyword
                                        class="w-100"
                                        v-loading="loading.locator"
                                        :disabled="isDisabled"
                                        :remote-method="searchFunction"
                                        @change="checkDuplicateLocators(index)">
                                <el-option  v-for="(Locator,index) in itemLocatorsLists"
                                            :key="index"
                                            :label="Locator.meaning + ' : ' + Locator.description"
                                            :value="Locator.flex_value">
                                </el-option>
                            </el-select>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <button @click.prevent="removeRow(index, row.delRow, row)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div v-for="(row, index) in linesOld" :key="index" :row="row">
                <input type="hidden" :name="'dataGroupOld['+row.id+'][line_id]'" v-model="row.lineId" autocomplete="off">
                <input type="hidden" :name="'dataGroupOld['+row.id+'][cate_code_old]'" v-model="row.cate_code_old" autocomplete="off">
                <input type="hidden" :name="'dataGroupOld['+row.id+'][locators_old]'" v-model="row.locator_old" autocomplete="off">
            </div>
        </div>

        <div class="row" style="padding-left: 15px; padding-top: 10px;">
            <label>Active</label><span class="text-danger"> *</span>
            <input type="hidden" name="activeFlag" v-model="activeFlag">
            <input type="hidden" name="confirmActiveFlag" v-model="confirmActiveFlag">
            <input type="hidden" name="openProgamFlag" v-model="openProgamFlag">
            <!-- <el-checkbox    style="margin-left: 45px;"
                            v-model="flag"
                            :checked="activeFlag"
                            @change="checkActive(header.header_id, flag)">
            </el-checkbox> -->
            <input  style="margin-left: 10px;"
                    type="checkbox" 
                    :id="'checkbox'+header.header_id" 
                    @change="checkActive(header.header_id)" 
                    :checked="header.showFlag"
                    v-model="activeFlag">
        </div>

        <div class="row clearfix text-right">
            <div class="col" style="margin-top: 15px;">
                <button :class="btnTrans.save.class + ' btn-sm'" 
                        type="submit"> 
                    <i :class="btnTrans.save.icon" aria-hidden="true"></i> 
                    {{ btnTrans.save.text }} 
                </button>
                <a :href="backUrl" 
                    type="button" 
                    :class="btnTrans.cancel.class + ' btn-sm'">
                    <i :class="btnTrans.cancel.icon" aria-hidden="true"></i> 
                    {{ btnTrans.cancel.text }}
                </a>
            </div>
        </div>

    </div>
</template>
<script>
    import uuidv1 from 'uuid/v1';
    export default {
    props: ["header", "itemLocators", "itemCategories", 'backUrl', 'data', 'btnTrans'],
    data() {
        return{
            flag                    : '',
            activeFlag              : this.header.active_flag == 'Y' ? true : false,
            confirmActiveFlag       : '',
            openProgamFlag          : '',
            isDisabled              : false,
            cate_code               : '',
            lines                   : [],
            linesOld                : [],
            id                      : uuidv1(),
            productInvHeader        : this.header.header_id,
            subinventoryCode        : this.header.subinventory_code,
            subinventoryDesc        : this.header.subinventory_desc,
            groupProductId          : this.header.group_product_id,
            loading: {
                locator             : '',
                page                : false,
            },
            itemLocatorsLists       : this.itemLocators,
        };        
    },
    // watch: {
    //     confirmActiveFlag: function (newQuestion, oldQuestion) {
    //          
    //          
    //     }
    // },
    mounted() {
        this.header.product_inv_lines.forEach(element => {
           this.lines.push({
                id                  : uuidv1(),
                lineId              : element.line_id,
                cate_code           : Number(element.category_code),
                locator             : element.zone_code,  
                delRow              : true,
            });                 
        }); 

        if(this.itemLocatorsLists.length == 0){
            this.isDisabled = true;
        }

        this.header.product_inv_lines.forEach(element => {
            this.linesOld.push({
                id                  : uuidv1(),
                lineId              : element.line_id,
                cate_code_old       : Number(element.category_code),
                locator_old         : element.zone_code,  
                delRow              : true,
            });
        }); 

        if (this.data == "DuplicateLine") {
            swal({
                    title: "warning !",
                    text: "มีข้อมูลซ้ำ ระดับ Line",
                    type: "warning",
                    showConfirmButton: true
            });
        }
                
    },
    methods: {
            checkDuplicateCategory(row, index) {
                // this.lines.find(line => {
                //     if (line.id != row.id) {
                //         if (row.cate_code == line.cate_code) {
                //             row.cate_code = '';
                //             swal({
                //                 title: "Warning",
                //                 text: 'ไม่สามารถเลือก รหัสประเภท (Category Code) ซ้ำกันได้',
                //                 type: "warning",
                //                 showConfirmButton: true
                //             });
                //         }
                //     }
                // });
                this.lines.forEach((element,i) => {
                    if(i != index){
                        if(this.lines[index].cate_code == element.cate_code && this.lines[index].locator == element.locator){
                            this.showAlert();
                            this.lines[index].locator = '';
                            this.lines[index].cate_code = '';
                            return;
                        }
                    }
                });
            },

            checkDuplicateLocators(index){
                this.lines.forEach((element,i) => {
                    if(i != index){
                        if(this.lines[index].locator == element.locator && this.lines[index].cate_code == element.cate_code){
                            this.showAlert();
                            this.lines[index].cate_code = '';
                            this.lines[index].locator = '';
                            return;
                        }                        
                    }
                });

                if(this.lines.locator != ''){
                    this.searchFunction();
                } 
            },

            showAlert(){
                swal({
                    title: "Error !",
                    text: "ไม่สามารถเลือกชุดข้อมูลนี้ได้ เนื่องจากมีชุดข้อมูลซ้ำ",
                    type: "error",
                    showConfirmButton: true
                });
            },

            addLine() {
                this.lines.push({
                    id                  : uuidv1(),
                    lineId              : '',
                    cate_code           : '',
                    locator             : '',
                    delRow              : false,
                });

                this.$nextTick(() => {
                    const el = this.$el.getElementsByClassName('endTable')[0];
                    if (el) {
                        el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                    }
                });
            },

            removeRow: function (index, delRow, row) {    
                const vm = this;           
                var params = {
                    sub_group_id : row.lineId,
                };

                // if(delRow){
                    swal({
                        title: "Warning",
                        text: "ต้องการลบหรือไม่!",
                        type: "warning",
                        showCancelButton: true,
                        showCancelButton: true,
                        closeOnConfirm: true
                    },                    
                    function (isConfirm) {
                        if(isConfirm){
                            if(delRow){
                                axios.get('/ir/ajax/destroy',{ params })
                                .then( res =>{ 
                                    if(res.data.status === 's'){
                                        swal({  
                                            title: "Success", 
                                            text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว", 
                                            type: "success",
                                            showConfirmButton: true
                                        });
                                        vm.lines.splice(index, 1);
                                        // window.location.reload(false);
                                    }
                                });
                            }else{
                                vm.lines.splice(index, 1);
                                swal({  
                                    title: "Success", 
                                    text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว", 
                                    type: "success",
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                    
                // }else{
                    // this.lines.splice(index, 1);

                    // swal({  
                    //     title: "Success", 
                    //     text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว", 
                    //     type: "success",
                    //     showConfirmButton: true
                    // });

                //     swal({
                //         title: "Warning",
                //         text: "ต้องการลบหรือไม่!",
                //         type: "warning",
                //         showCancelButton: true,
                //         showCancelButton: true,
                //         closeOnConfirm: true
                //     },                    
                //     function (isConfirm) {
                //         if(isConfirm){
                //             vm.lines.splice(index, 1);
                //             swal({  
                //                 title: "Success", 
                //                 text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว", 
                //                 type: "success",
                //                 showConfirmButton: true
                //             });
                //         }
                //     });
                // }
            },

            async searchFunction(query){
                this.loading.locator = true;
                await axios.get('/ir/ajax/get-value-set', { 
                    params: {
                        subinventory_code: this.subinventoryCode,
                        status: 'Edit',
                        query: query,
                    },
                })
                .then(res => {
                    this.itemLocatorsLists = res.data.data;
                })
                .catch(err => {
                     
                })
                .then( () => {
                    this.loading.locator = false;
                });
            },

            async checkActive(data){
                let flag = $(`#checkbox${data}`).is(':checked');
                var params = {
                    header_id: data,
                    active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
                };
                this.loading.page = true;
                var vm = this;
                return await axios
                    .get('/ir/ajax/product-header/getDataActiveFlag',{ params })
                    .then(res => {
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
                                function(isConfirm){
                                    if(isConfirm){
                                        vm.confirmActiveFlag = true;
                                        vm.openProgamFlag = res.data.status;
                                        swal.close();
                                    }else{
                                        $(`#checkbox${data}`).prop('checked', false)
                                    }
                                });  
                            this.loading.page = false;
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
                                function(isConfirm){
                                    if(isConfirm){
                                        vm.confirmActiveFlag = true;
                                        vm.openProgamFlag = res.data.status;
                                        swal.close();
                                    }else{
                                        $(`#checkbox${data}`).prop('checked', false)
                                    }
                                });  
                            this.loading.page = false;
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
                                function(isConfirm){
                                    if(isConfirm){
                                        vm.confirmActiveFlag = true;
                                        vm.openProgamFlag = res.data.status;
                                        swal.close();
                                    }else{
                                        $(`#checkbox${data}`).prop('checked', false)
                                    }
                                });  
                            this.loading.page = false;
                        }
                        if(res.data.status == 'success'){
                            this.loading.page = false;
                        }
                    });
            }

        },
    };
</script>
<style scope>
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 116px;
        /*left: 150px;*/
    }

    .th-row {
        /* width: 250px;
        min-width: 150px;
        max-width: 250px; */
        top: 0;
        /* left: 0px; */
        /*left: 250px;*/
    }

    .fo-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 416px;
        /*left: 400px;*/
    }

    .fi-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
        /*left: 550px;*/
    }

    .t1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 0px;
    }

    .t2-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
    }
</style>