<template>
    <div>
        <!--<pre>{{ JSON.stringify({sampleproducts,user}, null, 2) }}</pre>-->

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="ibox-title">
                        <!-- <div class="form-group row">
                            <label class="col-lg-1 col-form-label"><B>วันที่ทำรายการ *</B></label>
                            <div class="col-lg-6">
                                <input type="date" class="form-control" name="request_date" :value="date"
                                       @change="onChange($event)">
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group  row mb-1">
                                    <label class="col-sm-4 mt-2 col-form-label text-right" for="request_date">
                                        <strong>วันที่ทำรายการ <span style="color:red">*</span></strong>
                                    </label>
                                    <div class="col-sm-6">
                                        <ct-datepicker
                                            id="request_date"
                                            class="my-1 col-sm-12 form-control"
                                            name="request_date"
                                            onkeydown="return event.key != 'Enter';"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่เริ่มต้น"
                                            :value="toJSDate(date, 'yyyy-MM-dd')"
                                            @change="(val) => {
                                                date = jsDateToString(val)
                                                onChange(jsDateToString(val));
                                            }"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <B>สรุปยอดบุหรี่ตัวอย่าง</B>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>รหัสสินค้า</th>
                            <th>รายละเอียด</th>
                            <th>จำนวน</th>
                            <th>หน่วยนับ</th>
                        </tr>
                        </thead>
                        <tbody v-if="sampleproducts.productmes.length > 0">
                        <tr v-for="(SampleProductsMes,i) in sampleproducts.productmes" v-bind:key="i">
                            <td class="col-readonly">{{ SampleProductsMes.segment1 }}</td>
                            <td class="col-readonly">{{ SampleProductsMes.description }}</td>
                            <td class="col-readonly">{{ numberWithCommas(SampleProductsMes.example_qty) }} (<span :style="(SampleProductsMes.example_qty_used  > SampleProductsMes.example_qty ? 'color:red; font-weight: 600;' : '')">{{ numberWithCommas(SampleProductsMes.example_qty_used || 0)}}</span>)</td>
                            <td class="col-readonly">{{ SampleProductsMes.unit_of_measure }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="text-center" v-if="sampleproducts.productmes.length === 0">
                        <span class="lead">No Data.</span>
                    </div>
                </div>
            </div>
        </div>
        </br></br>
        <form @submit.prevent="SampleProductsFormSubmit" ref="mainForm">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title pb-3">
                            <h5>บันทึกยอดบุหรี่ตัวอย่างตามหน่วยงาน</h5>
                        </div>
                        <div class="ibox-tools pr-3">
                            <button class="btn btn-primary"  type="submit"><i
                                class="fa fa-check"></i>&nbsp;บันทึก
                            </button>
                            <button class="btn btn-primary" type="button" @click.prevent="addNewLine"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">เพิ่มรายการ</span></button>

                            <button class="btn btn-danger" @click.prevent="removeSelectedLines"
                                    :disabled="this.sampleproducts.lines.filter(line => line.isSelected).length === 0">
                                <strong><i class="fa fa-times"></i>ลบรายการ</strong>
                            </button>
                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>รหัสหน่วยงาน*</th>
                                    <th>ชื่อหน่วยงาน</th>
                                    <th>รหัสสินค้า*</th>
                                    <th>รายละเอียด</th>
                                    <th>จำนวน*</th>
                                    <th>หน่วยนับ*</th>
                                </tr>
                                </thead>
                                <tbody v-if="sampleproducts.lines.length > 0">
                                <tr v-for="(SampleProductsLine,i) in sampleproducts.lines" v-bind:key="i"
                                    :class="{'row-new-record': SampleProductsLine.newRecord, 'row-selected-record': SampleProductsLine.isSelected}">
                                    <td>
                                        <!-- <pre>{{ SampleProductsLine.department_code_list }}</pre> -->
                                        <div class="form-check abc-checkbox text-center">
                                            <input class="form-check-input" type="checkbox"
                                                   v-model="SampleProductsLine.isSelected"
                                                   @change="selectLine($event)"/>

                                        </div>
                                    </td>
                                    <td>
                                        <!-- <ct-lookup table="PtglCoaDeptCodeV" id_field="department_code"
                                                   lookup_field="department_code"
                                                   :selected="SampleProductsLine.department_code"
                                                   @change="(val) => onTableInput(i,'department_code',val)">
                                        </ct-lookup> -->

                                            <!-- :disabled="brands.loading" -->
                                            <!-- :loading="brands.loading" -->
                                            <!-- @change="(val) => onSearchHeaderInput('description1',val)" -->
                                        <el-select filterable clearable
                                            :value="SampleProductsLine.department_code_label"
                                            @input="(val) => onTableInput(i,'department_code',val)"
                                            style="width: 100%"
                                            placeholder="">
                                            <el-option
                                                v-for="item in init_lines.department"
                                                :key="item.flex_value"
                                                :label="item.flex_value +' : ' + item.description"
                                                :value="item.flex_value">
                                            </el-option>
                                        </el-select>

                                        <!-- department_code_list -->

                                    </td>
                                    <td class="col-readonly">{{ SampleProductsLine.department_name }}</td>
                                    <td>
                                        <!-- <ct-lookup table="PtpmSampleProductMesV" id_field="item" lookup_field="item"
                                                   :selected="SampleProductsLine.item"
                                                   @change="(val) => onTableInput(i,'item',val)">
                                        </ct-lookup> -->
                                         <el-select filterable clearable
                                            :value="SampleProductsLine.item_label"
                                            @input="(val) => onTableInput(i,'item',val)"
                                            style="width: 100%"
                                            placeholder="">
                                            <el-option
                                                v-for="item in sampleproducts.listSelectSampleProducts"
                                                :key="item.segment1"
                                                :label="item.segment1+' - '+item.description"
                                                :value="item.segment1">
                                            </el-option>
                                        </el-select>
                                    </td>
                                    <td class="col-readonly">{{ SampleProductsLine.description }}</td>
                                    <td><input type="text" 
                                                @focus="inputQtyFocus(SampleProductsLine)"  @focusout="inputQtyFocusOut(SampleProductsLine)"
                                                 class="form-control" id="create-qty"
                                                 v-model="SampleProductsLine.qty" name="qty">
                                                 <div class="validate">{{SampleProductsLine.validate_qty}}</div>
                                                 </td>
                                    <td>{{ SampleProductsLine.uom }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center" v-if="sampleproducts.lines.length === 0">
                                <span class="lead">No Data.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import {
    extractDataFormEvent,
    copyObject
} from "../helpers";
import {
    instance as http
} from "../httpClient";
// import {
//     instance as http2
// } from "../httpClient2";
import {
    $route
} from '../../router'
//import swal from 'sweetalert';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'
    import { Loading } from 'element-ui';

function updateLines(date, lines) {
    return http.put($route('api.pm.sample-cigarettes.update', {
        date
    }), {
        lines
    })
}

function deleteLines(lineIds) {
    return http.delete($route('api.pm.sample-cigarettes.delete'), {
        data: {
            ids: lineIds
        }
    })
}

function calUsedExample(example, line) {
    console.log('process Calculate used example', {example, line})
    _.each(example, (item, key) => {
        let lineFilter = _.filter(line, o => o.item == item.segment1)
        _.each(lineFilter, i => {
            i.qty_label = parseInt((i.qty).replaceAll(',', ''))
        })
        let sumUsedExample = _.sumBy(lineFilter, 'qty_label');
        let validate = parseInt(item.example_qty) >= parseInt(sumUsedExample);
        Vue.set(item, 'validate', validate)
        Vue.set(item, 'example_qty_used', sumUsedExample)
        console.log('loop example', {item, key, lineFilter, sumUsedExample, validate});
    })
    let validate = _.filter(example, o => o.validate === false)
    console.log('filter validate', {validate});

    return validate.length > 0 ? true : false;
}

function searchDept(query) {
    let params = {
        label: query,
        action: 'get-dept'
    }
    return http.get($route('pm.sample-cigarettes.index'), { params })
}

// import DeptInput from './pm/pages/PM00027/DeptInput'
// import DeptInput from '../PM00027/DeptInput'



// import DeptInput from '../pages/PM00027/DeptInput.vue'
// import DeptInput2 from './pm/pages/PM00027/DeptInput.vue'
// resources/js/pm/pages/PM00027/DeptInput.vue

export default {
    // components: { DeptInput },
    data() {
        return {
            isInRange,
            jsDateToString,
            toJSDate,
            linesHeader: [
                "รหัสหน่วยงาน", "ชื่อหน่วยงาน", "รหัสสินค้า", "รายละเอียด", "จำนวน", "หน่วยนับ",
            ],
            // mode: this.line_id ? 'update' : 'create',
            sampleproducts: this.init_lines,
            init_lines: this.init_lines,
            date: this.p_date,
            readysave: false,
            // sampleproducts: this.init_lines.map(line => ({
            //     ...sampleproducts,
            //     newRecord: false
            // })),
            // lineTableModel: {}
        }
    },
    props: {
        line_id: null,
        init_lines: {
            type: Object,
            //default: []
        },
        // sampleproducts: {
        //     type: Object,
        // },
        user: {
            type: Object
        },
        p_date: {
            type: String,
        }
        // organization_id: {
        //     type: String,
        // },
    },

    // metaInfo: {
    //     title: 'ตัวอย่างบุหรี่',
    // },
    // props: [
    //     'sampleproducts',
    //     'user'
    //     // 'items',
    // ],
    mounted() {
        console.log(this.init_lines)
        _.each(this.init_lines.lines, o => {
            Vue.set(o, 'department_code_label', o.department_code + " ")
            Vue.set(o, 'item_label', o.item + " ")
        })
        let statusValidate = calUsedExample(this.sampleproducts.productmes, this.sampleproducts.lines)
        this.readysave = statusValidate;
        console.log('check status', {statusValidate})
    },
    methods: {
        $getData($event) {
            console.log('--->', this.sampleproducts.lines)
            return {
                lines: [...this.sampleproducts.lines]
            }
        },

        inputQtyFocus(line){
                console.log('inputQtyFocus')
                try {
                line.qty = line.qty.replaceAll(',', '')
                }catch(e) {
                }
            },
numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            inputQtyFocusOut(line) {
                // let example = _.filter(this.sampleproducts.productmes, o => o.segment1 == line.item);
                // let lineProduct = _.filter(this.sampleproducts.lines, o => o.item == line.item)
                // line.qty_label = line.qty
                // lineProduct = _.map(lineProduct, i => {
                //     i.qty_label = parseInt(i.qty_label)
                //     return i;
                // })
                // console.log('inputQtyFocusOut', {lineProduct, example})
                // Vue.set(example[0], 'example_qty_used', _.sumBy(lineProduct, 'qty_label'))

                let statusValidate = calUsedExample(this.sampleproducts.productmes, this.sampleproducts.lines)
                this.readysave = statusValidate;
                console.log('check status', {statusValidate})
                Vue.set(line, 'qty', this.numberWithCommas(line.qty))
            },
        async onChange(date) {
            console.log(event.target.value)
            const loading = Loading.service({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                        })
            await axios.get($route('pm.sample-cigarettes.show', {date:date}) + "?api=callback", {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(result => {
                let data = result.data;
                console.log({data})
                
                
                Vue.set(this, 'sampleproducts', data.init_lines)
                // Vue.set(this, 'init_lines', data.init_lines)
                _.each(this.sampleproducts.lines, o => {
                    Vue.set(o, 'department_code_label', o.department_code + " ")
                    Vue.set(o, 'item_label', o.item + " ")
                })
                this.date =  data.p_date;
                window.history.pushState('page2', 'Title', $route('pm.sample-cigarettes.show', {date:date}));
            })
            .catch(e => {
                console.log(e)
            })
                loading.close()

            // window.location = $route('pm.sample-cigarettes.show', {
            //     date: date
            // })
        },
        async onTableInput(row, col, o) {
            console.log(`onHtmlTableInput(${row}, ${col})`, o, this.sampleproducts.lines[row][col])
            this.sampleproducts.lines[row][col] = o.key

            if (col === 'department_code') {
                // this.sampleproducts.lines[row]['department_code_list'] = [];
                // this.sampleproducts.lines[row]['department_code_list'] = await this.getDeptList();
                let bindFields = ['department_name']
                this.sampleproducts.lines[row]['department_code'] = o;
                this.sampleproducts.lines[row]['department_code_label'] = o + ' ';
                let dept = _.filter(this.init_lines.department, i => i.flex_value == o)
                if(dept.length > 0) {
                     this.sampleproducts.lines[row]['department_name'] = dept[0].description
                }
                console.log(dept, 'select value')
                // for (let field of bindFields) {
                //     this.sampleproducts.lines[row][field] = o.row[field]
                //     this.sampleproducts.lines[row]['department_name'] = o.row.description
                // }
            }
            if (col === 'item') {
                 this.sampleproducts.lines[row]['item'] = o
                 this.sampleproducts.lines[row]['item_label'] = o + ' '
                 let filterSelectItem = _.filter(this.init_lines.listSelectSampleProducts, i => i.segment1 === o)
                 if(filterSelectItem.length > 0) {
                     filterSelectItem = filterSelectItem[0]
                    this.sampleproducts.lines[row]['description'] = filterSelectItem.description
                    this.sampleproducts.lines[row]['uom'] = filterSelectItem.unit_of_measure
                    this.sampleproducts.lines[row]['qty'] = 0
                     this.sampleproducts.lines[row]['qty_limit'] = filterSelectItem.example_qty
                 }

                // let bindFields = ['description', 'uom']
                // for (let field of bindFields) {
                //     this.sampleproducts.lines[row][field] = o.row[field]
                // }
            }
            this.sampleproducts.lines = [...this.sampleproducts.lines]
        },
        addNewLine() {
            this.sampleproducts.lines.push({
                newRecord: true,
                isSelected: false,
            })
        },

        $update(date, lines) {
            console.log('$update', lines)
            updateLines(date, lines).then(({
                                               data
                                           }) => {
                swal({
                    title: "บันทึกข้อมูลสำเร็จ!",
                    icon: "success",
                    button: "ปิด",
                });
                window.location = $route('pm.sample-cigarettes.show', {
                    date: date
                })
            }).catch(err => {
                console.error(err)
                // swal("บันทึกข้อมูลไม่สำเร็จ");
                alert('Fail!: ' + err.toString())
            })
        },
        SampleProductsFormSubmit($event) {
            let statusValidate = calUsedExample(this.sampleproducts.productmes, this.sampleproducts.lines)
            this.readysave = statusValidate;
            if(this.readysave) {
                swal('แจ้งเตือน', 'ไม่สามารถบันทึกได้ เนื่องจากเกินจำนวนที่กำหนด', 'warning')
                return false;
            }
            let {
                lines
            } = this.$getData($event)
            console.log('=>', lines)
            this.$update(this.date, lines)
            // else {
            //     this.$update(this.date, sampleproducts)
            // }
        },

        selectLine($event) {
            //let r = this.lines.filter(line => line.isSelected)
            //console.log(`selectLine(${$event})`)
        },

        removeSelectedLines() {
            let ids = this.sampleproducts.lines.filter(line => line.isSelected).map(line => line.id)
            console.log(this.sampleproducts, ids)
            swal({
                title: "ลบข้อมูล?",
                icon: "warning",
                buttons: ["ยกเลิก", "ตกลง"],
                showCancelButton: true,
                dangerMode: true,
                cancel: true,
            }, async status => {
                    const del_num_row = this.sampleproducts.lines.filter(line => line.isSelected).length
                    this.sampleproducts.lines = this.sampleproducts.lines.filter(line => line.isSelected != true)

                    if (!status) return
                    let {data} = await deleteLines(ids)
                    if (data.res > 0) {
                        swal("ลบข้อมูลสำเร็จ!");
                        window.location = $route('pm.sample-cigarettes.show', {
                            date: this.date
                        })
                    } else if(del_num_row > 0) {
                            swal("ลบข้อมูลสำเร็จ!");

                    }else {
                        swal("ไม่มีรายการที่ถูกลบ!")
                    }
            })
                // .then(async (status) => {
                //     if (!status) return
                //     let {data} = await deleteLines(ids)
                //     if (data.res > 0) {
                //         swal("ลบข้อมูลสำเร็จ!", {
                //             icon: "success",
                //             buttons: false,
                //         });
                //         window.location = $route('pm.sample-cigarettes.show', {
                //             date: this.date
                //         })
                //     } else {
                //         swal("ไม่มีรายการที่ถูกลบ!")

                //     }
                // }).catch(err => {
                // console.error(err)
                // alert('Fail!: ' + err.toString())
            // })


            // deleteLines(ids).then(({
            //     data
            // }) => {
            //     swal({
            //         title: 'ลบข้อมูล?',
            //         icon: 'warning',
            //         icon: "warning",
            //         buttons: true,
            //         dangerMode: true,
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             swal(
            //                 'ลบข้อมูลสำเร็จ!',
            //             )

            //         }else{
            //             swal(
            //                 'ยกเลิก!',
            //             )
            //         }
            //     })
            // window.location = $route('pm.sample-cigarettes.show', {
            //      date: this.date
            // })
            //alert('Delete Success!')

            // }).catch(err => {
            //     console.error(err)
            //     alert('Fail!: ' + err.toString())
            // })
        },

        async getDeptList(query) {
            let vm = this;
            let deptData = [];
            await searchDept(query).then(({data}) => {
                console.log('getDeptList', query, data);
                deptData = data
            }).catch(err => {
                
            })

            return deptData;
            // vm.search_header.brand = '';
            // vm.search_header.description1 = '';
            // vm.brands.loading = true;
            // vm.brands.data = [];
            // searchBrand(vm.search_header.used_date).then(({data}) => {
            //     vm.brands.data = data;
            //     vm.brands.loading = false
            // }).catch(err => {
            //     vm.brands.loading = false
            // })

            // if (vm.firstLoad == true && vm.id) {
            //     vm.search_header.description1 = _get(vm.init_header, 'description1', null);
            //     vm.firstLoad = false
            // }
        },

    },

};

</script>

<style scoped>
.validate {
    color: red;
    font-style: italic;
    margin-top: 5px;
}
.validate-input {
    border-color:red;
}
</style>
