<template>
    <div>
        <div class="ibox" style="padding-top: 50px;" v-loading="loading.page">
            <div class="ibox-title">
                <h5> กำหนดแจ้งเตือนปริมาณใบยา </h5>
            </div>
            <div class="ibox-content">
                <div class="text-right" style="padding-bottom: 15px;">
                        <button class="btn btn-sm btn-primary" type="submit" @click.prevent="addLine"> 
                            <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
                        </button>
                    </div>
                    <table class="table table table-bordered table-data">
                        <thead>
                            <tr>
                                <th class="text-center" width="30%">
                                    <div>รหัสวัตถุดิบ<span class="text-danger"> *</span></div>
                                </th>
                                <th class="text-center" width="30%">
                                    <div>รายละเอียด</div>
                                </th>
                                <th class="text-center" width="30%">
                                    <div>จำนวนเดือนที่แจ้งเตือน<span class="text-danger"> *</span></div>
                                </th>
                                <th class="text-center" width="10%">

                                </th>
                            </tr>
                        </thead>
                    <tbody v-if="this.tobaccoForewarnList.data.length != 0">
                        <tr v-for="(tobacco, index) in tobaccoForewarnList.data" :key="'showData'+index" :row="index">
                            <td class="text-center" style="vertical-align:middle;"> 
                                {{ tobacco.item_number }}
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                {{ tobacco.item_desc }}
                            </td>
                            <td style="vertical-align:middle;">
                                <vue-numeric 
                                    placeholder="ระบุจำนวนการแจ้งเตือน"
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    class="form-control w-100 text-right"
                                    v-model="tobacco.warning_num"
                                ></vue-numeric>
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                
                            </td>
                        </tr>
                        <tr v-for="(line, index) in lines" :key="index" :row="index">
                            <td class="text-center" style="vertical-align:middle;">
                                <el-select
                                    class="w-100"
                                    v-model="line.itemNumber"
                                    filterable
                                    remote
                                    reserve-keyword
                                    placeholder="เลือก รหัสวัตถุดิบ"
                                    @input="getValueDetails(line.itemNumber, line)"
                                    :remote-method="remoteMethod"
                                    :loading="loading.itemNumberTable">
                                    <el-option
                                        v-for   ="(itemNumber,index) in itemNumbersSearchList"
                                        :key    ="index"
                                        :label  ="itemNumber.item_number + ' : ' + itemNumber.item_desc"
                                        :value  ="itemNumber.inventory_item_id">
                                    </el-option>
                                </el-select>
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                {{ line.itemDesc }}
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                <vue-numeric 
                                    placeholder="ระบุจำนวนการแจ้งเตือน"
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    class="form-control w-100 text-right"
                                    v-model="line.warningNum"
                                ></vue-numeric>
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-if="this.checkText">
                            <td colspan="4" class="text-center" style="vertical-align:middle; font-size: 18px;"> 
                                {{ 'ไม่มีข้อมูลในระบบ' }}
                            </td>
                        </tr>
                        <tr v-for="(line, index) in lines" :key="index" :row="index">
                            <td class="text-center" style="vertical-align:middle;">
                                <el-select
                                    class="w-100"
                                    v-model="line.itemNumber"
                                    filterable
                                    remote
                                    reserve-keyword
                                    placeholder="เลือก รหัสวัตถุดิบ"
                                    @input="getValueDetails(line.itemNumber, line)"
                                    :remote-method="remoteMethod"
                                    :loading="loading.itemNumberTable">
                                    <el-option
                                        v-for   ="(itemNumber,index) in itemNumbersSearchList"
                                        :key    ="index"
                                        :label  ="itemNumber.item_number + ' : ' + itemNumber.item_desc"
                                        :value  ="itemNumber.inventory_item_id">
                                    </el-option>
                                </el-select>
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                {{ line.itemDesc }}
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                <vue-numeric 
                                    placeholder="ระบุจำนวนการแจ้งเตือน"
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    class="form-control w-100 text-right"
                                    v-model="line.warningNum"
                                ></vue-numeric>
                            </td>
                            <td class="text-center" style="vertical-align:middle;">
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>                
                </table>
                <div class="col-12 mt-3">
                    <div class="row clearfix text-right">
                        <div class="col" style="margin-top: 15px;">
                            <button class="btn btn-success" type="submit" @click.prevent="save()"> 
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                            </button>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</template>

<script>
    import uuidv1 from 'uuid/v1';
    import VueNumeric from 'vue-numeric';
    export default {
    props: ['tobaccoForewarnList', 'itemNumbersUpdateList', 'itemNumberShowAllList'],
        data() {
            return {
                lines: [],
                itemNumber: '',
                warningNum: '',
                checkText: true,
                loading: {
                    page: false,
                    itemNumberTable: false
                },
                itemNumbersSearchList: this.itemNumbersUpdateList
            };
        },
        components: {
            VueNumeric
        },
        mounted() {
            $('.table-data').dataTable( {
                "searching": false,
                "bInfo": false,
            });
        },
        methods: {
            addLine() {
                this.isDisabledBtu  = false;
                this.checkText = false;
                this.lines.push({
                    id              : uuidv1(),
                    itemNumber      : '',
                    warningNum      : '',
                    inventoryItemId : '',
                });
            },
            removeRow: function (index) {    
                this.lines.splice(index, 1);
                if(this.lines.length == 0){
                    this.checkText = true;
                }
            },
            getValueDetails(value, line) {
                this.itemNumberShowAllList.forEach(element => {
                    if(element.inventory_item_id == value){
                        line.itemNumber = element.item_number;
                        line.inventoryItemId = element.inventory_item_id;
                        line.itemDesc = element.item_desc;
                    }
                });
            },
            save(){
                let checkStatus = false
                this.lines.forEach((element) => {
                    if(!element.itemNumber && !element.warningNum){
                        swal({
                            title: "คำเตือน !",
                            text:  'ไม่สามารถบันทึกได้ เนื่องจากกรอกข้อมูลไม่ครบถ้วน',
                            type: "warning",
                            showConfirmButton: true,
                        })
                        // element.validateRemark = true;
                        return checkStatus = true;
                    }else{
                        // element.validateRemark = false;
                    }
                });
                if(!checkStatus){
                    var params = {...this.lines};
                    var params1 = {...this.tobaccoForewarnList};
                    this.loading.page = true;
                     return axios
                        .post('/pd/ajax/ohhand-tobacco-forewarn/updateOrCreate',{ params, params1 })
                        .then(res => {
                            if(res.data.data == "succeed"){
                                swal({
                                    title: "Success !",
                                    text: "บันทึกสำเร็จ",
                                    type: "success",
                                    showConfirmButton: true
                                });
                            }else{
                                swal({
                                    title: "Error !",
                                    text: "บันทึกไม่สำเร็จ",
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                            this.loading.page = false;
                            setTimeout(() => {
                                window.location.reload(false); 
                            }, 3000)
                        });
                }                
            },
            remoteMethod(query) {
                if (query !== '') {
                    let vm = this;
                    this.loading.itemNumberTable = true;
                    var params = {
                        query: query,
                        itemCatSeg1: vm.$parent.itemCatSeg1,
                        itemCatSeg2: vm.$parent.itemCatSeg2,
                        inventoryItemId: vm.$parent.itemNumber,
                        UpdateList: 'UpdateList'
                    };
                
                    return axios
                        .get('/pd/ajax/ohhand-tobacco-forewarn/get-search-item-number',{ params })
                        .then(res => {
                            this.itemNumbersSearchList = res.data.itemNumberList;
                            this.loading.itemNumberTable = false;
                        });
                } 
                else{
                    this.itemNumbersSearchList = this.itemNumbersUpdateList;
                }
            }
        }
    };
</script>
