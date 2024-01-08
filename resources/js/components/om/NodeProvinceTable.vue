<template>
    <div>
        <div class="text-right mb-2">
            <button
                :class="transBtn.add.class + ' btn-lg  btn-sm'"
                @click.prevent="addRow()"
            >
                <i :class="transBtn.add.icon"></i>
                {{ transBtn.add.text }}
            </button>

            <button
                :class="transBtn.save.class + ' btn-lg  btn-sm'"
                @click.prevent="saveForm()"
            >
                <i :class="transBtn.save.icon"></i>
                {{ transBtn.save.text }}
            </button>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools"></div>
                <h5>กำหนด Node</h5>
            </div>
            <div class="ibox-content">
                <div class="text-right">
                    <span> Node : </span>
                    <el-select v-model="search.node" filterable placeholder="Select" clearable>
                            <el-option
                            v-for="node in nodeHeaders"
                            :key="node.node_name"
                            :label="node.node_name"
                            :value="node.node_name"
                            >
                            </el-option>
                    </el-select>
                    <span> จังหวัด : </span>
                    <el-select v-model="search.province" filterable placeholder="Select" clearable>
                            <el-option
                                v-for="province in provinces"
                                :key="province.province_id"
                                :label="province.province_thai"
                                :value="province.province_id">
                            </el-option>
                    </el-select>
                    <button
                        :class="transBtn.search.class + ' btn-sm mb-1'"
                        @click="fitterNodes"
                    >
                        <i
                            :class="
                                transBtn.search.icon + ' btn-lg tw-w-25 '
                            "
                        ></i>
                            {{  transBtn.search.text  }}
                    </button>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="6%" class="text-center">Node</th>
                                <th width="45%" class="text-center">จังหวัด</th>
                                <th width="10%" class="text-center">วันที่เริ่มต้น</th>
                                <th width="10%" class="text-center">วันที่สิ้นสุด</th>
                                <th width="10%" class="text-center">สถานะ</th>
                                <th width="15%" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody v-for="(header, index) in nodeHeaders" :key="index">
                            <tr>
                                <td class="text-right">
                                    <el-input class="text-right"  v-model="nodeHeaders[index].node_name" :disabled="!header.can_edit">

                                    </el-input>
                                </td>
                                <td>   
                                    <el-select v-model="nodeHeaders[index].province_ids" multiple placeholder="Select" filterable class="form-control-file" :disabled="!header.can_edit">
                                            <el-option 
                                            v-for="province in provinces"
                                            :key="province.province_id"
                                            :label="province.province_thai"
                                            :value="province.province_id"
                                            :disabled="disableProvince(header, province.province_id)">
                                            </el-option>
                                    </el-select> 

                                </td>
                                <td>
                                    <el-date-picker
                                        v-model="nodeHeaders[index].start_date"
                                        type="date"
                                        :disabled="!header.can_edit"
                                        >
                                    </el-date-picker>
                                    <!-- <datepicker-th
                                        style="width: 100%; border-radius:3px;"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        v-model="nodeHeaders[index].start_date"
                                        format="transDate['js-format']"
                                        @dateWasSelected="getDate" 
                                        @click="inputDate(index)"
                                    /> -->
                                    <!-- <el-input placeholder="Please input" v-model="nodeHeaders[index].start_date"></el-input> -->
                                </td>
                                <td>
                                    <el-date-picker
                                        v-model="nodeHeaders[index].end_date"
                                        type="date"
                                        :disabled="!header.can_edit"
                                        >
                                    </el-date-picker>
                                </td>
                                <td> 
                                    <select name="" id="" class="form-control" :disabled="!header.can_edit">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button
                                        :class="transBtn.edit.class + ' btn-lg  btn-sm'"
                                        @click.prevent="toggleEdit(index)"
                                    >
                                        <i :class="transBtn.save.icon"></i>
                                        {{ transBtn.edit.text }}
                                    </button>
                                    <button
                                        :class="transBtn.delete.class + ' btn-lg  btn-sm'"
                                        @click.prevent="delRaw(index, header.node_header_id)"
                                    >
                                        <i :class="transBtn.delete.icon"></i>
                                        {{ transBtn.delete.text }}
                                    </button>
                            </td>
                            </tr>
                        </tbody>
                    </table>
            <!-- <div class="text-right">
                <button
                    :class="transBtn.add.class + ' btn-lg  btn-sm'"
                    @click.prevent="addRow()"
                >
                    <i :class="transBtn.add.icon"></i>
                    {{ transBtn.add.text }}
                </button>
            </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props:['user-profile', 'user-profile', 'trans-date','trans-btn', 'provinces', 'sys-date', 'p-node-headers'],
    data() {
        return {
            nodeHeaders: this.pNodeHeaders? this.pNodeHeaders : [],
            value1: [],
            nodeHeader:{},
            node: "",
            search:{
                node:"",
                province:"",
            },
            // can:{
            //     edit:false,
            // }

        }
    },
    mounted() {

    },
    methods: {

        fromDateWasSelected(date, index) {
            // change disabled_date_to of to_date = from_date
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
        },
        addRow() {        
            let total = this.nodeHeaders.length+1;        
            this.nodeHeader= {
                node_name: total,
                start_date:  moment(this.sysDate).format("DD/MM/YYYY"),
                end_date: "",
                province_ids:[],
                node_header_id: null,
                can_edit: true,
                status: "",
            };
            this.nodeHeaders.push(this.nodeHeader);

        },
        saveData(index, id=null){
            console.log(index, id);
            if(id==null){
                axios
                    .post("/om/settings/node-province/store", {
                        ...this.nodeHeaders[index]
                    })
                    .then(res => {
                        return swal({
                            title: "Success !",
                            text: "Success !",
                            type: "success",
                            showConfirmButton: true
                        });
                        // alert('complete');
                    })
                    .catch(error => {
                        return  swal({
                            title: "Error !",
                            text: "Error !",
                            type: "error",
                            showConfirmButton: true
                        });
                    });
            } else{
                this.update(index, id);
            }

        },

        update(index, id){
            axios
                .post('/om/settings/node-province/update/'+id, {
                    ...this.nodeHeaders[index]
                })
                .then(res => {
                    console.log(res);
                        return swal({
                            title: "Success !",
                            text: "Success !",
                            type: "success",
                            showConfirmButton: true
                        });
                })
                .catch(error => {
                    alert(error);
                });
        },

        saveForm(){
            // this.nodeHeaders.
             const dataForm =  this.nodeHeaders.map((item) => {
                return {
                    node_name:  item.node_name,
                    start_date:  moment(item.start_date).format("YYYY-MM-DD"),
                    end_date:  item.end_date ? moment(item.start_date).format("YYYY-MM-DD") : "",
                    province_ids: item.province_ids,
                    node_header_id: item.node_header_id,
                    status:item.status,
                    }
            }); 

            axios
                .post('/om/settings/node-province/update-form', {
                    nodeHeaders: dataForm
                })
                .then(res => {
                    this.nodeHeaders = [];
                    this.nodeHeaders = res.data.ptomNodeHeaders;
                    // this.nodeHeaders = res.date.ptomNodeHeaders;
                    // console.log(res.data.ptomNodeHeaders);
                    return swal({
                        title: "Success !",
                        text: "Success !",
                        type: "success",
                        showConfirmButton: true
                    });
                        
                })
                .catch(error => {
                    alert(error);
                });
        },

        delRaw(index, id){
            console.log(index, id);
            if(id==null){
                this.nodeHeaders.splice(this.nodeHeaders.indexOf(this.nodeHeaders[index]), 1);
            } else{
                this.deleteRaw(index, id);
            }
           
        },

        deleteRaw(index, id){
            axios
                .post('/om/settings/node-province/delete/'+id, {
                    ...this.nodeHeaders[index]
                })
                .then(res => {
                    this.nodeHeaders.splice(this.nodeHeaders.indexOf(this.nodeHeaders[index]), 1);
                    return swal({
                        title: "Success !",
                        text: "Success !",
                        type: "success",
                        showConfirmButton: true
                    });
                })
                .catch(error => {
                    return  swal({
                        title: "Error !",
                        text: 'Error',
                        type: "error",
                        showConfirmButton: true
                    });
                });
        },

        disabledOption(nodeName, province){
            let disabled = false;     
            this.nodeHeaders.forEach(item => {
                // item.province_ids.forEach(province => {
                //     if(province == province & province){

                //     }
                // })
                // if(this.nodeHeaders.node_name == nodeName & line.raw_material_num != uItemCode){
                //     disabled  = true;
                // }
            });  
            return disabled;
        },

        disableProvince(value, provinceId){

            let disable = false;
            // value.array.forEach(element => {
                this.nodeHeaders.forEach(item => {
                    if(item.province_ids.includes(provinceId) & !value.province_ids.includes(provinceId)){
                        disable =  true;
                    }
                });

            return disable;


        },
        toggleEdit(index){
            this.nodeHeaders[index].can_edit =  !this.nodeHeaders[index].can_edit;
        },

        fitterNodes(){
            // let search = this.search;
            var request = {
                params: this.search
            }
            // axios.get(this.urlGerParam, request)
            // .then((res) => {
            //     // this.infos = res.data.ptirReportInfos;
            //     this.programs = res.data.programs;
            //     this.options = res.data.programs;
            // })
            axios
                .get('/om/settings/node-province/search', request)
                .then(res => {
                    this.nodeHeaders = [];
                    this.nodeHeaders = res.data.ptomNodeHeaders;
                    // console.log(res.data.ptomNodeHeaders);
                    // return swal({
                    //     title: "Success !",
                    //     text: "Success !",
                    //     type: "success",
                    //     showConfirmButton: true
                    // });
                        
                })
                .catch(error => {
                    alert(error);
                });

        }
    }
    
}
</script>
