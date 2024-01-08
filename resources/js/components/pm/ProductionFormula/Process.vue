<template>
    <div class="ibox-content">
        <!-- <div><h4>ขั้นตอนการผลิต</h4></div> -->
        <!-- <div class="row">
            <div class="col-md-4">
                <label> ประเภทสิ่งผลิต <span class="text-danger">*</span></label>
                <input type="hidden" name="routing_desc"  :value="routing_desc" autocomplete="off">
                <el-select  v-model="routing_desc"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="getWipStepList()">              
                    <el-option  v-for="(routing, index) in routings"
                                :key="index"
                                :label="index"
                                :value="index">

                    </el-option>
                </el-select>
            </div>
        </div> -->
        <!-- <div class="row" v-if="this.wipStepList.length > 0">
            <div class="col-md-6">
                <label> ลำดับขั้นตอน </label>
                <div>
                    <div class="table-responsive">
                        <table class="table table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th>ขั้นตอนการทำงาน</th>
                                    <th>ชื่อขั้นตอนการทำงาน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="wipStep in wipStepList">
                                    <tr :style="oprn_id == wipStep.oprn_id ? 'cursor: pointer; background-color: #F0F0F0;' : 'cursor: pointer; '" @click="newTableLine(wipStep.routingstep_no, wipStep.oprn_id, wipStep.oprn_class_desc)">
                                        <input type="hidden" name="oprn_id" v-model="oprn_id">
                                        <input type="hidden" name="step_no" v-model="step_no">
                                        <input type="hidden" name="oprns_id" v-model="oprns_id">
                                        <td>{{ wipStep.oprn_class_desc }}</td>
                                        <td>{{ wipStep.oprn_desc }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->

<!-- ------------------------------------------------------------------วัตถุดิบที่ใช้-------------------------------------------------------------------- -->
        <div>
            <div class="row mb-2">
                <div class="col-3">
                    <h4 class="no-margins"> กำหนดวัตถุดิบ </h4>
                </div>
                <div class="col-9 text-right" v-if="this.wipStep">
                    <!-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button> -->
                    <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine" :disabled="this.check_add_line"> <i class="fa fa-plus"></i> เพิ่ม </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap table-bordered  table-hover">
                    <thead>
                        <tr>
                            <!-- <th> 
                                <div>ลำดับขั้นตอน </div> 
                            </th> -->
                            <th> ลำดับวัตถุดิบ </th>
                            <th v-if="this.check_org_multi_wip && (org_code != 'M06' && org_code != 'M12')">ขั้นตอนการทำงาน</th>
                            <th style="min-width: 150px;"> รหัสวัตถุดิบ <span class="text-danger">*</span> </th>
                            <th> รายละเอียด </th>
                            <th> จำนวนตามสูตร <span class="text-danger">*</span> </th>
                            <th width="120px;"> % สูญเสีย </th>
                            <th> ปริมาณที่ต้องใช้ </th>
                            <th> หน่วยนับ </th>
                            <th> สถานะการใช้งาน </th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in lines"  :key="index" :row="row">
                            <!-- <td>{{ row.ingredient_step_line }}</td> -->
                            <td class="text-center">{{ row.ingredient_line }}</td>
                            <td v-if="row.multi_wip && (org_code != 'M06' && org_code != 'M12')">{{ row.oprn_desc }}</td>
                            <td>
                                <div>
                                    <input type="hidden" :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_item_id]'"  :value="row.ingredient_item_id" autocomplete="off">
                                    <el-select  v-model="row.ingredient_item_id"
                                                    filterable
                                                    remote
                                                    reserve-keyword
                                                    class="w-100" 
                                                    size="medium"
                                                    :remote-method="getItemList"
                                                    @change="getItemData(row); getItemList(); checkDuplicate(row, index);"
                                                    ref="inventory_item"
                                                    placeholder="">              
                                        <el-option  v-for="item in itemLists"
                                                    :key="item.inventory_item_id"
                                                    :label="item.item_number"
                                                    :value="item.inventory_item_id">
                                                    <span>{{ item.item_number + ' : ' + item.item_desc }}</span>
                                        </el-option>
                                    </el-select>
                                </div>
                            </td>
                            <!-- <td><el-input v-model="row.description" size="medium" disabled></el-input></td> -->
                            <td> {{ row.description }} </td>
                            <td>
                                <!-- <el-input :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]'" v-model="row.ingredient_folmula_qty" size="medium" @input="onlyNumeric(row)"></el-input> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="5" 
                                    v-bind:minus="false"
                                    :id="`input_ingredient_folmula_qty_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]'"
                                    v-model="row.ingredient_folmula_qty"
                                    @change="getIngredientQty(row, index)"
                                    :disabled="row.itemLoading"
                                ></vue-numeric>
                                    <!-- @input="setFocus(row, index)" -->
                            </td>
                            <td>
                                <!-- <el-input :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_loss]'" v-model="row.ingredient_loss" size="medium"  @input="onlyNumeric(row)"></el-input> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="5" 
                                    v-bind:minus="false"
                                    :id="`input_ingredient_loss_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_loss]'"
                                    v-model="row.ingredient_loss"
                                    :disabled="row.itemLoading"
                                ></vue-numeric>
                            </td>
                            <td> {{ row.ingredient_qty | number5Digit }}</td>
                            <td class="text-center"> {{ row.ingredient_uom }} </td>
                            <!-- <td><el-input :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_qty]'" v-model="row.ingredient_qty" size="medium" disabled></el-input></td>
                            <td><el-input v-model="row.ingredient_uom" size="medium" disabled></el-input></td> -->
                            <td class="text-center"><input type="checkbox" :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][active_flag]'" v-model="row.active_flag"></td>
                            <td>
                                <div v-if="!row.disabledRow">
                                    <button @click.prevent="removeRow(row, index)" class="btn btn-sm btn-danger">
                                    X
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
import VueNumeric from 'vue-numeric';
export default {
    props:['routings', 'defaultStep', 'defaultItems', 'wipSteps', 'wipStep', 'defaultSteps', 'defaultRoutingId', 'orgId', 'items', 'routingDesc', 'orgCode'],
    
    components: {
        VueNumeric
    },

    data() {
        return {
            //
            routing_desc:  this.routingDesc ? this.routingDesc : '',
            wipStepList: [],
            oprns_id:    [],
            oprn_id:     '',
            step_no:     '',
            numberTest:  '',
            wip_step_id: '',

            routing_id: this.defaultRoutingId ? this.defaultRoutingId : '',
            org_id:     this.orgId            ? this.orgId            : '',
            org_code:   this.orgCode          ? this.orgCode          : '',
            //
            lines: [],
            itemLists: [],
            test_oprn: 1,
            desc: '',
            firstLoad: true,

            check_org_multi_wip: false,
            oprn_desc: '',
            check_add_line: false,
        };
    }, 
    mounted() {
        console.log('Process');
        // if (this.defaultStep) {
        //     if(this.routing_no) {
        //         this.getWipStepList();
        //     }
        // }
        this.getItemList();


        if (this.routing_id) {
            this.selectedData = this.wipSteps.find( i => {
                if (i.routing_id == this.routing_id) {
                    this.routing_desc = i.routing_desc;
                }
            });
            
            this.getWipStepList();
        }

        if (this.org_code == 'MPG' || this.org_code == 'M12' || this.org_code == 'M06') {
            this.check_org_multi_wip = true;
        }

    },
    watch: {
        wipStep : async function () {
            if (this.wipStep) {
                this.oprn_id = this.wipStep;

                this.selectedData = this.wipSteps.find( i => {
                    if (i.oprn_id == this.oprn_id) {
                        this.oprn_desc = i.oprn_desc;
                    }
                });

                this.oprn_id = this.wipStep;
                    
                if (this.org_code == 'MPG' || this.org_code == 'M12') {
                    
                } else {
                    this.lines = [];
                } 
            }        
        },
        
        routingDesc : async function () {
            this.routing_desc = this.routingDesc;
            // if (this.routing_desc) {
                this.getWipStepList();
            // }           
        },

        lines : async function () {

            if (this.lines.length > 0) {
                this.check = this.lines.find(i => {
                    return i.ingredient_item_id == '';
                });
                if (this.check) {
                    this.check_add_line = true;
                } else {
                    this.check_add_line = false;
                }
            } else {
                this.check_add_line = false;
            }

            this.$emit('lines', this.lines)           
        },

        // routing_desc : async function () {
        //     // this.desc = this.routing_desc
        //     this.$emit('routing_desc', this.routing_desc)           
        // },
    },
    methods:{
        // updateGlobalForm() {
        //     this.$emit(
        //         this.routing_no
        //     );
        // },
        addLine() {
            var number = this.lines.length + 1;
            var seq_raw_material = number + '0';
            var today = new Date();
            var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());
            
            this.lines.push({
                id                     : time,
                ingredient_step_line   : this.step_no,
                ingredient_line        : number,
                ingredient_item_id     : '',
                description            : '',
                ingredient_folmula_qty : 0,
                ingredient_loss        : 0,
                ingredient_qty         : '',
                ingredient_uom         : '',
                active_flag            : true,
                disabledRow            : false,
                oprn_id                : this.oprn_id,
                multi_wip              : this.check_org_multi_wip,
                oprn_desc              : this.oprn_desc,
                itemLoading            : true,
            });
        },
        removeRow: function (row, index) {
            this.lines.splice(index, 1);
        },
        async getItemList(query) {

            this.itemLists = [];
            let defIngredientItemId = [];
            if (this.firstLoad && this.defaultItems != undefined && this.defaultItems.length > 0) {
                // defIngredientItemId = (JSON.stringify(this.defaultItems))
                defIngredientItemId = this.defaultItems.map((number, x) => {
                    number = {
                        ingredient_item_id: number.ingredient_item_id
                    }
                    return number;

                  // return number*2
                })
                this.firstLoad = false
            }
            // console.log('aaaaaa', this.firstLoad, this.defaultItems, defIngredientItemId);

            axios.get("/pm/ajax/get-item", {
                params: {
                    org_id: this.org_id,
                    query:  query,
                    // def_ingredient_item_id: this.defaultItems,
                    def_ingredient_item_id: defIngredientItemId,
                }
            })
            .then(res => {
                this.itemLists = res.data;
            })
            .catch(err => {
                console.log(err)
            });
        },
        async getWipStepList(query) {

            this.wipStepList =  [],

            axios.get("/pm/ajax/get-wip-step", {
                params: {
                    routing_desc: this.routing_desc,
                    org_id:       this.org_id,
                    query:        query,
                }
            })
            .then(res => {
                // console.log('getWipStepList <-->' + res.data);
                this.wipStepList = res.data;
                

                if (this.defaultItems) {

                // console.log('เข้า function getWipStepList');
                    // var number = this.lines.length + 1;
                    // var seq_raw_material = number + '0';

                    var seq_raw_material = 1;
                    let itemDesc = '';
                    let uomDesc = '';
                    
                    this.defaultItems.forEach(line => {  
                        this.selectedData = this.wipStepList.find( i => {
                            return i.routingstep_id == line.routingstep_id;
                        });    

                        this.selectedItem = this.items.find( i => {
                            if (i.inventory_item_id == line.ingredient_item_id) {
                                itemDesc = i.item_desc;
                                uomDesc  = i.primary_unit_of_measure;
                            }
                            // return i.inventory_item_id == line.ingredient_item_id;
                        });
                        console.log('selectedData <--> ' + this.selectedData.oprn_id);
                        // console.log();

                        this.step_no = line.ingredient_step_line;  
                        this.oprn_id = this.selectedData.oprn_id;   
                        
                        
                        if (this.oprns_id.length < 1) {
                            this.oprns_id.push(this.selectedData.oprn_id);
                        } else {
                            this.checkOprn = this.oprns_id.find(i => {
                                return  i == this.selectedData.oprn_id;
                            });
                            
                            if (!this.checkOprn) {
                                this.oprns_id.push(this.selectedData.oprn_id);
                            } 
                        }
                        
                        //query item
                        // this.getItemList(line.ingredient_item_id);

                        let loss = '';

                        // let folmula_qty = line.ingredient_folmula_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        // let ingredient_qty = line.ingredient_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        loss = (Number(line.ingredient_qty)/Number(line.ingredient_folmula_qty) * 100)-100;

                        //
                        this.lines.push({
                            id                     : line.line_no,
                            ingredient_step_line   : line.ingredient_step_line,
                            ingredient_line        : seq_raw_material,
                            ingredient_item_id     : line.ingredient_item_id,
                            description            : itemDesc,
                            // ingredient_folmula_qty : line.ingredient_folmula_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                            // ingredient_loss        : Number(line.ingredient_qty) - Number(line.ingredient_folmula_qty),
                            // ingredient_qty         : line.ingredient_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                            ingredient_folmula_qty : line.ingredient_folmula_qty,
                            ingredient_loss        : line.scrap_factor,
                            ingredient_qty         : Number(line.ingredient_qty),

                            // ingredient_folmula_qty : Number(folmula_qty),
                            // ingredient_loss        : line.scrap_factor,
                            // ingredient_qty         : Number(ingredient_qty),
                            ingredient_uom         : uomDesc,
                            active_flag            : line.enable_flag == 'Y' ? true : false,
                            oprn_id                : this.selectedData.oprn_id,
                            disabledRow            : false,
                            multi_wip              : this.check_org_multi_wip,
                            oprn_desc              : this.selectedData.oprn_desc,
                            itemLoading            : false,
                        });  

                        

                        seq_raw_material += 1;
                    }); 

                    // this.lines.forEach(line => { 
                    //     this.onlyNumeric(line);
                    // });
                }
            })
            .catch(err => {
                console.log(err)
            });
        },
        newTableLine (routingstep_no, oprn_id, oprn_class_desc) {
            if (this.wipStep) {

                this.checkOprn = this.oprns_id.find(i => {
                    if (i != this.wipStep) {
                        this.lines = [];
                        this.oprns_id = [];
                    }
                });
                // console.log('oprn_class_desc ----> ' + oprn_class_desc);
                // console.log('wip step ----> ' + this.wipStep);
                // this.selectedData = this.wipSteps.find( i => {
                //     return i.oprn_class_desc == this.wipStep;
                // });

                
                // this.oprn_id = this.selectedData.oprn_id;

                if (this.wipStep == oprn_id) {
                // if (this.wipStep == oprn_id) {
                    this.step_no = routingstep_no;
                    this.oprn_id = oprn_id;
                    this.test_oprn = this.oprn_id;

                    if (this.oprns_id.length < 1) {
                        this.oprns_id.push(oprn_id);
                    } else {
                        this.checkOprn = this.oprns_id.find(i => {
                            return  i == oprn_id;
                        });
                        
                        if (!this.checkOprn) {
                            this.oprns_id.push(oprn_id);
                        } 
                    }
                    // this.lines = [];

                    var number = this.lines.length + 1;
                    var seq_raw_material = number + '0';

                    var today = new Date();
                    var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

                    
                    this.lines.push({
                        id                   : time,
                        ingredient_step_line : this.step_no,
                        ingredient_line      : number,
                        ingredient_item_id   : '',
                        description          : '',
                        number_folmula       : '',
                        ingredient_loss      : 0,
                        ingredient_qty       : '',
                        ingredient_uom       : '',
                        active_flag          : true,
                        disabledRow          : false,
                        oprn_id              : this.oprn_id,
                        multi_wip            : this.check_org_multi_wip,
                        oprn_desc            : this.oprn_desc,
                        itemLoading          : true,
                    });

                    this.xxx = this.lines;

                    // this.lines.forEach(list_line => {
                    //     if (list_line.ingredient_step_line == this.step_no) {
                    //         this.linesTest.push({
                    //             id                   : list_line.id,
                    //             ingredient_step_line : list_line.ingredient_step_line,
                    //             ingredient_line      : list_line.ingredient_line,
                    //             ingredient_item_id   : list_line.ingredient_item_id,
                    //             description          : list_line.description,
                    //             number_folmula       : list_line.number_folmula,
                    //             ingredient_loss      : list_line.ingredient_loss,
                    //             ingredient_qty       : list_line.ingredient_qty,
                    //             ingredient_uom       : list_line.ingredient_uom,
                    //             active_flag          : list_line.active_flag,
                    //             disabledRow          : list_line.disabledRow,
                    //             oprn_id              : list_line.oprn_id,
                    //         });
                    //     }
                    // });



                    // this.linesTest = this.lines.find( i => {
                    //     return
                    //     if (i.ingredient_step_line == this.step_no) {
                    //         row.description    = i.item_desc;
                    //         row.ingredient_uom = i.primary_uom_code;
                    //     }
                    // });
                }

            } else {
                if (this.oprns_id.length < 1) {
                    this.oprns_id.push(oprn_id);
                } else {
                    this.checkOprn = this.oprns_id.find(i => {
                        return  i == oprn_id;
                    });

                    if (!this.checkOprn) {
                        this.oprns_id.push(oprn_id);
                    } 
                }
                
                // this.oprns_id.push(oprn_id);

                // console.log('oprn_id ---> ' + this.oprn_id);
                this.step_no = routingstep_no;
                this.oprn_id = oprn_id;

                // this.lines = [];

                var number = this.lines.length + 1;
                var seq_raw_material = number + '0';

                var today = new Date();
                var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

                this.lines.push({
                    id                   : time,
                    ingredient_step_line : this.step_no,
                    ingredient_line      : number,
                    ingredient_item_id   : '',
                    description          : '',
                    number_folmula       : '',
                    ingredient_loss      : 0,
                    ingredient_qty       : '',
                    ingredient_uom       : '',
                    active_flag          : true,
                    disabledRow          : false,
                    oprn_id              : oprn_id,
                    multi_wip            : this.check_org_multi_wip,
                    oprn_desc            : this.oprn_desc,
                    itemLoading          : true,
                });
            }
        },
        getItemData(row) {
            if (row.ingredient_item_id) {
                row.itemLoading = false;
                this.selectedData = this.itemLists.find( i => {
                    if (i.inventory_item_id == row.ingredient_item_id) {
                        row.description    = i.item_desc;
                        row.ingredient_uom = i.primary_unit_of_measure;
                    }
                });
                this.check_add_line = false;
            } else {
                row.itemLoading    = true;
                row.description    = '';
                row.ingredient_uom = '';
            }
        },
        onlyNumeric(row) {
            
            row.ingredient_folmula_qty = row.ingredient_folmula_qty.replace(/[^0-9 .]/g, '');
            //  if (row.ingredient_loss) {
            //     row.ingredient_loss        = row.ingredient_loss.replace(/[^0-9 .]/g, '');
            //  }
            row.ingredient_qty         = Number(row.ingredient_folmula_qty) * Number(row.ingredient_loss) / 100 + Number(row.ingredient_folmula_qty);
            // row.ingredient_qty         = Number(row.ingredient_folmula_qty) + (Number(row.ingredient_loss) * Number(row.ingredient_folmula_qty));
            row.ingredient_folmula_qty = row.ingredient_folmula_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // if (row.ingredient_loss) {
            //     row.ingredient_loss        = row.ingredient_loss.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // }

            // row.ingredient_qty         = row.ingredient_qty.toLocaleString()

        },
        checkDuplicate(row, index) {
            if (row.ingredient_item_id) {
                if (index > 0) {
                    var idx = this.lines.find(line => {
                        if (line.id != row.id) {
                            if (row.ingredient_item_id == line.ingredient_item_id) {
                                row.ingredient_item_id = '';
                                swal({
                                    title: "มีข้อผิดพลาด",
                                    text: 'ไม่สามารถเลือกรหัสวัตถุดิบซ้ำกันได้',
                                    timer: 3000,
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                        }
                    });
                }
            }
        },
        getIngredientQty(row, index){
            if (!row.ingredient_item_id) {
                // this.setFocus(row, index);
            }

            row.ingredient_qty  = Number(row.ingredient_folmula_qty) * Number(row.ingredient_loss) / 100 + Number(row.ingredient_folmula_qty);
        },
        setFocus(row, index) {

            if (!row.ingredient_item_id) {
                row.ingredient_folmula_qty = 0;
                row.ingredient_loss = 0;

                var barcodes = document.createElement('tr');

                const nbBarcodes = this.$refs.inventory_item.length;
                this.$refs.inventory_item[nbBarcodes - 1].focus();

            }            
        },
    },
}
</script>

<style scoped>
.border_table{
    border: 1px solid #DCDFE6 !important;

}
</style>
