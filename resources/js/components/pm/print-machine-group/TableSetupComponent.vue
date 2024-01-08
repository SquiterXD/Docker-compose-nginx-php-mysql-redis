<template>
    <div class="col-lg-12" v-loading="loading">
        <div class="ibox">
            <div class="ibox-title">
                <h5>กำหนดกลุ่มเครื่องจักรกับเครื่องจักร</h5>
            </div>
            <div class="ibox-content">
                <div class="text-right" v-if="lookupCode.length != 0">
                    <button :class="btnTrans.save.class" type="submit" @click.prevent="save()"> 
                        <i :class="btnTrans.save.icon" aria-hidden="true"></i> {{ btnTrans.save.text }} 
                    </button>
                    <button class="btn btn-primary" type="submit" @click.prevent="addLine"> 
                        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
                    </button>
                </div><br>
                <table class="table table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 180px;">
                                <div>ลำดับที่</div>
                            </th>
                            <th class="text-center" style="width: 180px;">
                                <div>กลุ่มเครื่องจักร</div>
                            </th>
                            <th class="text-center" style="width: 180px;">
                                <div>ระบบการพิมพ์</div>
                            </th>
                            <th class="text-center">
                                <div>ชื่อเครื่องจักร</div>
                            </th>
                            <th class="text-center">
                                <div>สถานะการใช้งาน</div>
                            </th>
                            <th class="text-center">
                                
                            </th>
                            <th class="text-center">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="printMachineGroup.length != 0">
                        <tr v-for="(data, index) in printMachineGroup" :key="'showdata'+index">
                            <td class="text-center" style="vertical-align:middle">
                                {{ index+1 }}
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <!-- {{ 'กลุ่มที่ ' + data.machine_group + ' : ' + data.assetGroup.asset_group }} -->
                                {{ data.assetGroup.asset_group }}
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                {{ data.print_type_label }}
                            </td>
                            <td class="text-left" style="vertical-align:middle">
                                {{ data.machine_name }}
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <el-checkbox v-model="data.checked" :checked="data.enable_flag == 'Y' ? true : false" disabled></el-checkbox>
                            </td>
                            <td>

                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <a  type="button" :href="'/pm/settings/print-machine-group/'+ data.id +'/edit'" 
                                    :class="btnTrans.edit.class">
                                    <i :class="btnTrans.edit.icon" aria-hidden="true"></i> {{ btnTrans.edit.text }}
                                </a>
                            </td>
                        </tr> 
                        <tr v-for="(data, index) in lines" :key="index">
                            <td class="text-center" style="vertical-align:middle">
                                {{data.index}}
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                {{ assetGroup }}
                                <!-- {{ data.machine_group }} -->
                                <!-- <el-select  v-model="data.machine_group" 
                                            placeholder="โปรดเลือก กลุ่มเครื่องจักร"
                                            style="width: 100%;"
                                            clearable
                                            filterable>
                                        <el-option
                                            v-for="(item,index) in lookupMachineGroup"
                                            :key="index"
                                            :label="item.asset_group.asset_group"
                                            :value="item.lookup_code">
                                            <div class="text-left">{{ item.asset_group.asset_group }}</div>
                                        </el-option>
                                </el-select> -->
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <el-select  v-model="data.print_type"
                                            placeholder="โปรดเลือก ระบบการพิมพ์"
                                            style="width: 100%;"
                                            clearable
                                            filterable>
                                        <el-option
                                            v-for="(item,index) in printTypes"
                                            :key="index"
                                            :label="item.print_type_label"
                                            :value="item.print_type_value">
                                            <div class="text-left">{{ item.print_type_label }}</div>
                                        </el-option>
                                </el-select>
                            </td>
                            <td>
                                <el-select  v-model="data.machine_id" 
                                            placeholder="โปรดเลือก ชื่อเครื่องจักร"
                                            style="width: 100%;"
                                            clearable
                                            filterable>
                                        <el-option
                                            v-for="(item,index) in assetList"
                                            :key="index"
                                            :label="item.asset_number + ' : ' + item.asset_description"
                                            :value="item.asset_id">
                                        </el-option>
                                </el-select>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <el-checkbox v-model="data.checked"></el-checkbox>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                
                            </td>
                        </tr>             
                    </tbody>
                    <tbody v-else>
                        <tr class="text-center">
                            <td colspan="6" v-if="isTextNotFound">ไม่มีข้อมูล</td>
                        </tr>
                        <tr v-for="(data, index) in lines" :key="index">
                            <td class="text-center" style="vertical-align:middle">
                                {{data.index}}
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                {{ assetGroup }}
                                <!-- <el-select  v-model="data.machine_group" 
                                            placeholder="โปรดเลือก กลุ่มเครื่องจักร"
                                            style="width: 100%;"
                                            clearable
                                            filterable>
                                        <el-option
                                            v-for="(item,index) in lookupMachineGroup"
                                            :key="index"
                                            :label="'กลุ่มที่ ' + item.lookup_code + ' : ' + item.asset_group.asset_group"
                                            :value="item.lookup_code">
                                        </el-option>
                                </el-select> -->
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <el-select  v-model="data.print_type"
                                            placeholder="โปรดเลือก ระบบการพิมพ์"
                                            style="width: 100%;"
                                            clearable
                                            filterable>
                                        <el-option
                                            v-for="(item,index) in printTypes"
                                            :key="index"
                                            :label="item.print_type_label"
                                            :value="item.print_type_value">
                                            <div class="text-left">{{ item.print_type_label }}</div>
                                        </el-option>
                                </el-select>
                            </td>
                            <td>
                                <el-select  v-model="data.machine_id" 
                                            placeholder="โปรดเลือก ชื่อเครื่องจักร"
                                            style="width: 100%;"
                                            clearable
                                            filterable>
                                        <el-option
                                            v-for="(item,index) in assetList"
                                            :key="index"
                                            :label="item.asset_number + ' : ' + item.asset_description"
                                            :value="item.asset_id">
                                        </el-option>
                                </el-select>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <el-checkbox v-model="data.checked"></el-checkbox>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                
                            </td>
                        </tr>                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import uuidv1 from 'uuid/v1';
    import moment from 'moment';
    export default {
        props:['lookupMachineGroup', 'assetList', 'lookupCode', 'printMachineGroup', 'btnTrans', 'assetGroup', 'printTypes'],
        data() {
          return {
            lines: [],
            loading: false,
            isTextNotFound: true 
          }
        },
        mounted() {
            
        },
        methods: {
            addLine() {
                this.isTextNotFound = false;
                this.lines.push({
                    id                  : uuidv1(),
                    machine_group       : this.lookupCode ? this.lookupCode : '',
                    machine_id          : '',
                    checked             : true,
                    print_type          : '',
                });
            },
            save(){
                var params = {...this.lines}
                this.loading = true;
                return axios
                    .post('/pm/ajax/print-machine-group/store',{ params })
                    .then(res => {
                        this.loading = false;
                        if(res.data == "success"){
                            swal({
                                title: "Success",
                                text: 'บันทึกสำเร็จ',
                                timer: 3000,
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            })
                            setTimeout(() => {
                                window.location.href = '/pm/settings/print-machine-group'
                            }, 3000)
                        }

                        if(res.data == "duplicate"){
                            swal({
                                title: "คำเตือน !",
                                text: "ไม่สามารถบันทึกได้ เนื่องจากมีข้อมูลซ้ำ",
                                type: "warning",
                                showConfirmButton: true
                            });
                            // setTimeout(() => {
                            //     window.location.href = '/pm/settings/print-machine-group'
                            // }, 3000)
                        }
                    });
            },
            removeRow: function(index) { 
                this.lines.splice(index, 1); 
                if(this.lines.length == 0){
                    this.isTextNotFound = true;
                }else{
                    this.isTextNotFound = false;
                }    
            }, 
        }
    }
</script>