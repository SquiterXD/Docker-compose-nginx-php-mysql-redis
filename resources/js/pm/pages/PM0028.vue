<template>
    <div>
           <!-- <pre>
            {{ JSON.stringify({lines,date,items}, null, 2) }}
        </pre>    -->
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5> กรุณาเลือกวันที่แจกสูบ <small> </small></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="get">
                                <div class="form-group row ">
                                    <label class="col-sm-2 col-form-label">วันที่แจกสูบ<span
                                            class="remark">*</span></label>

                                    <div class="col-sm-10 col-lg-3">
                                        <div class="input-group date">
                                        <ct-datepicker
                                            id="stamp-using-date"
                                            class="my-1 col-sm-12 form-control"
                                            name="used_date"
                                            onkeydown="return event.key != 'Enter';"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่เริ่มต้น"
                                            :value="toJSDate(stampUsageDate, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                stampUsageDate = jsDateToString(date);
                                                onStampUsageDateChange();
                                            }"
                                        />
                                            <span>{{lines.create_date}}</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="FreeProductsFormSubmit" ref="mainForm">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-lg-6 align-middle">
                                        <h5>บันทึกยอดบุหรี่แจกสูบ</h5>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="text-right">
                                                <button class="btn btn-primary" type="submit" :disabled="this.lines.filter(line => line).length === 0"><i
                                                        class="fa fa fa-save"></i>&nbsp;&nbsp;บันทึก</button>
                                                <button class="btn btn-success" type="button"
                                                    @click.prevent="addNewLine"><i
                                                        class="fa fa-plus"></i>&nbsp;&nbsp;<span
                                                        class="bold">เพิ่มรายการ</span>
                                                </button>

                                                <button class="btn btn-danger" @click.prevent="removeSelectedLines" :disabled="this.lines.filter(line => line.isSelected).length === 0">
                                                    <strong><i class="fa fa-times"></i>&nbsp;&nbsp;ลบรายการ</strong>
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <div class="form-check abc-checkbox text-center">
                                                    <!-- <input class="form-check-input" id="checkbox1" type="checkbox"> -->
                                                </div>
                                            </th>
                                            <th width="20%">รหัสสินค้า<span class="remark">*</span></th>
                                            <th>รายละเอียด</th>
                                            <th>จำนวนแจกสูบ<span class="remark">*</span></th>
                                            <th>หน่วยนับ</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="lines.length > 0">
                                        <tr v-for="(line,i) in lines" v-bind:key="i"
                                            :class="{'row-new-record': line.newRecord, 'row-selected-record': line.isSelected}">
                                            <td>
                                                <div class="abc-checkbox text-center">
                                                    <input class="" type="checkbox"
                                                        v-model="line.isSelected" @change="selectLine($event)" />

                                                </div>
                                            </td>
                                            <td>

                                                <el-select
                                                    filterable
                                                    :value="line.item_number_label || (typeof line.item != 'undefined' ? line.item + ' ' : '')"
                                                    placeholder="ค้นหา"
                                                    @change="handleChangeItemNumber(line, $event)">
                                                    <el-option
                                                        v-for="item in listItemLookup"
                                                        :key="item.item_number"
                                                        :label="item.item_number + ' : ' + item.item_desc"
                                                        :value="item.item_number">
                                                    </el-option>
                                                </el-select>

                                                <!-- {{line.item}} -->
                                            </td>
                                            <td class="col-readonly">{{line.description}}</td>
                                            <td> <input @focus="inputQtyFocus(line)"  @focusout="inputQtyFocusOut(line)" type="text" class="form-control" id="create-qty"
                                                    v-model="line.qty" name="qty" placeholder="" required>
                                                <!-- {{line.qty}} -->
                                            </td>
                                            <td class="col-readonly">
                                                มวน
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-center" v-if="lines.length === 0">
                                    <span class="lead">No Data.</span>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
    // import {extractDataFormEvent, copyObject} from "../helpers";
    import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'
    import _cloneDeep from 'lodash/cloneDeep';
    import { instance as http } from "../httpClient";
    import _isEqual from 'lodash/isEqual';
    import { $route } from '../../router'
    import { Loading } from 'element-ui';
    //import swal from 'sweetalert';


    function updateLines(date, lines) {
        return http.put($route('api.pm.free-products.update', {
            date
        }), {
            lines
        })
    }


    function deleteLines(lineIds) {
        return http.delete($route('api.pm.free-products.deleteLines'), {
            data: {
                ids: lineIds
            }
        })
    }

    export default {
        // created: function () {
        //     console.log('!! created !!')
        // },
        metaInfo: {
            title: 'บันทึกบุหรี่แจกสูบ',
        },
        data() {
            return {
                lines: this.init_lines,
                accountMenuOption: '/',
                isInRange,
                jsDateToString,
                toJSDate,
                listItemLookup: this.item_number_look_up,
                toThDateString,
                item_number:'',
                stampUsageDate: _cloneDeep(this.date),
                // linesHeader: [
                //     "รหัสวัตถุดิบ", "รายละเอียด", "Lot", "ปริมาณที่ต้องใช้+สูญเสีย", "หน่วยนับ", "คงคลังฝ่ายจัดหา", "ปริมาณเบิก", "หน่วยเบิก", "หมายเหตุ"
                // ],
                // mode: this.header_id ? 'update' : 'create',
                // header: this.init_header,
                // lines: this.init_lines.map(line => ({...line, newRecord: false})),
                // lineTableModel: {}
            }
        },
        props: [
            'init_lines',
            'date',
            'items',
            'item_number_look_up',
        ],
        // components: {
        //     Menu,
        //     Footer,
        // },
        methods: {
            selectLine($event) {
                // let r = this.lines.filter(line => line.isSelected)
                // console.log(selectLine(${$event}))
            },

           async handleChangeItemNumber(line, item) {
                const itemSet = await _.filter(this.item_number_look_up, i => i.item_number == item )
                console.log('selected item', {line, item, itemSet })

                Vue.set(line, 'description', itemSet[0].item_desc)
                Vue.set(line, 'organization_id', itemSet[0].organization_id)
                Vue.set(line, 'inventory_item_id', itemSet[0].inventory_item_id)
                Vue.set(line, 'item_number_label', item + ' ')
                Vue.set(line, 'item', item)
            },

            gotoNewPage(stampUsageDate) {
                console.debug('gotoNewPage', stampUsageDate);
                window.location = '/pm/free-products/'
                    + stampUsageDate;
            },

            isDataStageChange() {
                console.debug('isDataStageChange', this.dataStage, this.data);

                let isEqual = _isEqual(this.dataStage, this.data);
                console.debug(isEqual);

                //warning user if there is unsaved data
                return !isEqual;
            },
            
            inputQtyFocus(line){
                console.log('inputQtyFocus')
                try {
                line.qty = line.qty.replaceAll(',', '')
                }catch(e) {
                }
            },

            inputQtyFocusOut(line) {
                console.log('inputQtyFocusOut')
                Vue.set(line, 'qty', this.numberWithCommas(line.qty))
            },
            async onStampUsageDateChange() {
                Vue.set(this, 'stampUsageDate', this.stampUsageDate);
                const stampUsageDate = this.stampUsageDate;
                console.debug('onStampUsageDateChange', {stampUsageDate});

                const loading = Loading.service({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                        })
                await axios.get($route('pm.free-products.date', {date:stampUsageDate}) + "?api=callback", {
                headers: {
                    'Content-Type': 'application/json'
                }
                })
                .then(result => {
                    let data = result.data;
                    console.log({data})
                    Vue.set(this, 'lines', data.init_lines)
                    Vue.set(this, 'listItemLookup', data.item_number_look_up)
                    
                    window.history.pushState('page2', 'Title', $route('pm.free-products.date', {date:stampUsageDate}));
                })
                .catch(e => {
                    console.log(e)
                })
                loading.close()

                // if (this.isDataStageChange()) {
                //     showProgressWithUnsavedChangesWarningDialog()
                //         .then((isConfirmed) => {
                //             this.clearWarningBeforeUnload();
                //             if (isConfirmed) {
                //                 this.gotoNewPage(this.stampUsageDate);
                //             }
                //         });
                // } else {
                //     this.gotoNewPage(this.stampUsageDate);
                // }
            },

            removeSelectedLines() {
                // let date = $date
                let ids = this.lines.filter(line => line.isSelected).map(line => line.id)
                console.log(this.lines, ids, this.lines.filter(line => line.isSelected))
                swal({
                        title: "ลบข้อมูล?",
                        icon: "warning",
                        buttons: ["ยกเลิก","ตกลง"],
                        dangerMode: true,
                        showCancelButton: true,
                    },  async (status) => {
                        
                        if (!status) return
                        const del_num_row = this.lines.filter(line => line.isSelected).length
                        this.lines = this.lines.filter(line => line.isSelected != true)

                        let {data} = await deleteLines(ids)
                        if (data.res > 0 ) {
                            swal("ลบข้อมูลสำเร็จ!");
                            
                            window.location = $route('pm.free-products.date', {
                                date: this.stampUsageDate
                            })
                        } else if(del_num_row > 0) {
                            swal("ลบข้อมูลสำเร็จ!");

                        } else {
                            swal("ไม่มีรายการที่ถูกลบ!")
                        }
                    })
                    
            },
            $getData($event) {
                let lines = [...this.lines]
                return {
                    lines
                }
            },

            $update(date, lines) {
                console.log('$update', lines)
                updateLines(this.stampUsageDate, lines).then(({
                    data
                }) => {
                    // alert('Success!')
                    swal({
                        title: "บันทึกข้อมูลสำเร็จ!",
                        icon: "success",
                        button: "ปิด",
                    });
                    window.location = $route('pm.free-products.date', {
                        date: this.stampUsageDate
                    })
                }).catch(err => {
                    console.error(err)
                    alert('Fail!: ' + err.toString())
                })
            },
            numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            FreeProductsFormSubmit($event) {
                let {
                    lines
                } = this.$getData($event)
                console.log('=>', lines)
                this.$update(this.date, lines)

            },

            onTableInput(row, col, o) {
                console.log(`onHtmlTableInput(${row}, ${col})`, o, this.lines[row][col])
                this.lines[row][col] = o.key

                if (col === 'item') {
                    this.lines[row]['inventory_item_id'] = o.row.inventory_item_id
                    this.lines[row]['item'] = o.row.item_number
                    this.lines[row]['description'] = o.row.item_desc
                    this.lines[row]['uom'] = o.row.primary_unit_of_measure
                    this.lines[row]['organization_id'] = o.row.organization_id
                }


                this.lines = [...this.lines]
            },
            addNewLine() {
                console.log('test')
                this.lines.push({
                    newRecord: true,
                    isSelected: false,
                    
                })
                this.lines = [...this.lines]
            },


            onChange(event) {

                axios.get($route('pm.free-products.date', {date:event.target.value}) + "?api=callback", {
                headers: {
                    'Content-Type': 'application/json'
                }
                })
                .then(result => {
                    let data = result.data;
                    console.log({data})
                    window.history.pushState('page2', 'Title', $route('pm.free-products.date', {date:event.target.value}));
                })
                .catch(e => {
                    console.log(e)
                })
                // window.location = $route('pm.free-products.date', {
                //     date: event.target.value
                // })
            },
        },
    };

</script>
<style scoped>
    .remark {
        color: rgb(218, 69, 69);
        padding: 5px;
    }

    .ibox-title {
        padding: 15px;
    }
    th, td {
    vertical-align: middle !important;
     }

</style>
