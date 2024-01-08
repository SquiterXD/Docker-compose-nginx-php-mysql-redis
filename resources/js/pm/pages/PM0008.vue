<template>
    <div id="pm0008">
<!--        <div class="form-group row">-->
<!--                <pre class="col-lg-4" style="display: block">{{-->
<!--                        JSON.stringify({-->
<!--                            expMonth,-->
<!--                            isCheckLotNo,-->
<!--                            isCheckMinQty,-->
<!--                            isCheckExpDate,-->
<!--                            qSegment,-->
<!--                            qOrganization,-->
<!--                            qSubInventory,-->
<!--                            qInventoryItem,-->
<!--                            qLocatorInventory,-->
<!--                            qSegment2,-->
<!--                            qSegment2AndLocator-->
<!--                        }, null, 2)-->
<!--                    }}-->
<!--                </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        checkLotNo,-->
<!--                        checkExpDate,-->
<!--                        checkMinQty-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--                </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({}, null, 2)-->
<!--                }}-->
<!--                </pre>-->
<!--        </div>-->
        <div class="row">
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>รายการวัตถุดิบคงคลัง</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="float-right">
                                    <button :class="btn_trans.reset.class" @click.prevent="onClickResetBtn">
                                        <i :class="btn_trans.reset.icon"></i>
                                        {{ btn_trans.reset.text }}
                                    </button>
                                    <button :class="btn_trans.displayInfo.class"
                                            @click.prevent="onClickSearchBtn"
                                            :disabled="qSegment === '' || qOrganization === ''">
                                        <i :class="btn_trans.displayInfo.icon"></i>
                                        {{ btn_trans.displayInfo.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row" style="justify-content: center;">
                                    <label class="col-md-2 col-form-label">ประเภทวัตถุดิบ:
                                        <span style="color: red;">*</span>
                                    </label>
                                    <div class="col-md-3">
                                        <el-select v-model="qSegment"
                                                   clearable
                                                   filterable
                                                   placeholder="โปรดเลือกประเภทวัตถุดิบ"
                                                   @change="onChgSegment">
                                            <el-option
                                                v-for="item in lovSegment"
                                                :key="item.tobacco_group_code"
                                                :label="item.tobacco_group_code + ' : ' + item.tobacco_group"
                                                :value="item.tobacco_group_code">
                                                <span>{{ item.tobacco_group_code }}</span> : <span>{{
                                                    item.tobacco_group
                                                }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-md-0"></div>
                                    <label class="col-md-2 col-form-label">คลังจัดเก็บ:</label>
                                    <div class="col-md-4">
                                        <el-select v-model="qSubInventory"
                                                   clearable
                                                   filterable
                                                   :disabled="qOrganization === ''"
                                                   placeholder="โปรดเลือกคลังจัดเก็บ"
                                                   @change="onChgSubInventory">
                                            <el-option
                                                v-for="item in lovSubInventory"
                                                :key="item.subinventory_code + item.organization_code"
                                                :label="item.subinventory_code"
                                                :value="item.subinventory_code">
                                                <span>{{ item.subinventory_code }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row" style="justify-content: center;">
                                    <label class="col-md-2 col-form-label">Organization:
                                        <span style="color: red;">*</span>
                                    </label>

                                    <div class="col-md-3">
                                        <el-select v-model="qOrganization"
                                                   clearable
                                                   filterable
                                                   :disabled="qSegment === ''"
                                                   placeholder="โปรดเลือก Organization"
                                                   @change="onChgOrganization">
                                            <el-option
                                                v-for="item in lovOrganization"
                                                :key="item.organization_code + item.tobacco_group_code"
                                                :label="item.organization_code + ' : ' + item.organization_name"
                                                :value="item.organization_code">
                                                <span>{{ item.organization_code }}</span> : <span>{{
                                                    item.organization_name
                                                }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-md-0"></div>
                                    <label class="col-md-2 col-form-label">สถานที่จัดเก็บ:</label>
                                    <div class="col-md-4">
                                        <el-select
                                            v-model="qSegment2AndLocator"
                                            clearable
                                            filterable
                                            :disabled="qSubInventory === ''"
                                            placeholder="โปรดเลือกสถานที่จัดเก็บ"
                                            @change="onChgLocatorInventory">
                                            <el-option
                                                v-for="item in lovLocatorInventory"
                                                :key="item.organization_code + item.segment2 + item.locator + item.subinventory_code"
                                                :label="item.segment2 + ' : ' + item.locator"
                                                :value="item.segment2 + ',' + item.locator">
                                                <span>{{ item.segment2 }}</span> : <span>{{
                                                    item.locator
                                                }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group row" style="justify-content: center;">
                                    <div class="col-md-5">
                                    </div>
                                    <div class="col-md-0"></div>
                                    <label class="col-md-2 col-form-label">รหัสวัตถุดิบ:</label>
                                    <div class="col-md-4">
                                        <el-select v-model="qInventoryItem"
                                                   clearable
                                                   filterable
                                                   :disabled="qOrganization === '' || qSegment === ''"
                                                   placeholder="โปรดเลือกรหัสวัตถุดิบ">
                                            <el-option
                                                v-for="item in lovInventoryItem"
                                                :key="item.inventory_item_id + item.organization_code"
                                                :label="item.item_number + ' : ' + item.item_desc"
                                                :value="item.inventory_item_id">
                                                <span>{{ item.item_number }}</span> : <span>{{ item.item_desc }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group row" style="justify-content: center;">

                                    <label class="col-md-4 col-form-label b-r-sm bg-warning">
                                        <input type="checkbox"
                                               v-model="checkMinQty"
                                               :disabled="checkLotNo || checkExpDate"
                                               @change="onChgCheckMinQty"
                                        />
                                        ปริมาณคงคลังต่ำกว่าค่าเฝ้าระวังต่ำสุด
                                    </label>

                                    <label class="col-md-3 col-form-label b-r-sm bg-primary ml-2 mr-2">
                                        <input
                                            type="checkbox"
                                            v-model="checkLotNo"
                                            :disabled="checkMinQty || checkExpDate"
                                        />
                                        แสดง Lot No.
                                    </label>

                                    <label class="col-md-3 col-form-label b-r-sm bg-danger">
                                        <input
                                            type="checkbox"
                                            v-model="checkExpDate"
                                            :disabled="checkMinQty"
                                            @change="onChgCheckExpDate"
                                        />
                                        วัตถุดิบใกล้หมดอายุ
                                    </label>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3 scroll-bar-top">
                                <thead>
                                <tr>
                                    <th style="min-width: 120px;">รหัสวัตถุดิบ</th>
                                    <th style="min-width: 250px;">รายละเอียด</th>
                                    <th style="min-width: 150px;">คลังจัดเก็บ</th>
                                    <th style="min-width: 150px;">สถานที่จัดเก็บ</th>
                                    <th :class="getDisplayColumnClass()" style="min-width: 120px;">Lot No.</th>
                                    <th style="min-width: 150px;">ปริมาณคงคลัง</th>
                                    <th style="min-width: 100px;">หน่วย</th>
                                    <th style="min-width: 90px;">ค่าเฝ้าระวังต่ำสุด</th>
                                    <th style="min-width: 90px;">ค่าเฝ้าระวังสูงสุด</th>
                                    <th :class="getDisplayColumnClass()" style="min-width: 100px;">วันที่ได้รับ</th>
                                    <th :class="getDisplayColumnClass()" style="min-width: 100px;">วันหมดอายุ</th>
                                </tr>
                                </thead>
                                <tbody v-if="rows.length">
                                <tr v-for="row in rows" :class="getQuantityRowClass(row)">
                                    <td class="text-left">{{ row.item_number }}</td>
                                    <td class="text-left">{{ row.item_desc }}</td>
                                    <td class="text-left">{{ row.subinventory_code }}</td>
                                    <td class="text-left">{{ row.segment2 }} : {{ row.locator }}</td>
                                    <td :class="getDisplayColumnClass()">{{ row.lot_number }}</td>
                                    <td class="text-right" style="text-align: right">
                                        {{ numberFormat(row.transaction_quantity) }}
                                    </td>
                                    <td class="text-left">{{ row.unit_of_measure }}</td>
                                    <td class="text-right">{{ numberFormat(row.min_qty) }}</td>
                                    <td class="text-right">{{ numberFormat(row.max_qty) }}</td>
                                    <td :class="getDisplayColumnClass()">
                                        {{ toThDateString(luxon.DateTime.fromSQL(row.creation_date).toJSDate()) }}
                                    </td>
                                    <td :class="getExpDateClass(row)">
                                        {{ toThDateString(luxon.DateTime.fromSQL(row.expiration_date).toJSDate()) }}
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td colspan="15">ไม่พบข้อมูล</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    showLoadingDialog,
} from "../../commonDialogs"

import {
    isInRange,
    jsDateToString,
    toJSDate,
    toThDateString
} from '../../dateUtils'

import {DateTime} from 'luxon';

export default {
    props: {
        btn_trans: {type: Object},
        data: {type: Array},
        res: {type: Array},
        lov_segment: {type: Array},
        lov_organization: {type: Array},
        lov_sub_inventory: {type: Array},
        lov_locator_inventory: {type: Array},
        lov_inventory_item: {type: Array},
        is_check_lot_no: {type: Boolean},
        is_check_min_qty: {type: Boolean},
        is_check_exp_date: {type: Boolean},
        exp_month: {type: String},
    },

    data() {
        return {
            rows: [],
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            luxon: {
                DateTime,
            },

            expMonth: this.exp_month,

            lovSegment: this.lov_segment,
            lovOrganization: this.lov_organization,
            lovSubInventory: this.lov_sub_inventory,
            lovInventoryItem: this.lov_inventory_item,

            qSegment: '',
            qOrganization: '',
            qSubInventory: '',
            qLocatorInventory: '',
            qSegment2AndLocator: '',
            qSegment2: '',

            qInventoryItem: '',
            checkLotNo: false,
            checkExpDate: false,
            checkMinQty: false,

            lovSegmentLst: this.lov_segment,
            lovOrganizationLst: this.lov_organization,
            lovSubInventoryLst: this.lov_sub_inventory,
            lovLocatorInventoryLst: this.lov_locator_inventory,
            lovLocatorInventory: this.lov_locator_inventory,
            lovInventoryItemLst: this.lov_inventory_item,

            isCheckLotNo: this.is_check_lot_no,
            isCheckMinQty: this.is_check_min_qty,
            isCheckExpDate: this.is_check_exp_date,
        }
    },
    mounted() {
        console.log('mounted !!!')
    },
    computed: {},
    methods: {
        onClickResetBtn() {
            this.qSegment = ''
            this.qOrganization = ''
            this.qSubInventory = ''
            this.qlocatorInventory = ''
            this.qSegment2 = ''
            this.qSegment2AndLocator = ''
            this.qInventoryItem = ''
            this.checkLotNo = false
            this.checkExpDate = false
            this.checkMinQty = false
        },
        onClickSearchBtn() {
            console.log('onClickSearchBtn')
            showLoadingDialog()
            let params = {
                segment: this.qSegment,
                organization: this.qOrganization,
                sub_inventory: this.qSubInventory,
                locator: this.qLocatorInventory,
                segment2: this.qSegment2,
                inventory_item: this.qInventoryItem,
                check_lot_no: this.checkLotNo,
                check_exp_date: this.checkExpDate,
                check_min_qty: this.checkMinQty,
                exp_month: this.expMonth
            }
            axios.post('/api/pm/pm0008/', params).then(response => {
                if (response.status == 200) {

                    this.rows = response.data.res
                    this.isCheckLotNo = response.data.is_check_lot_no
                    this.isCheckExpDate = response.data.is_check_exp_date
                    this.isCheckMinQty = response.data.is_check_min_qty

                    swal.close()
                    console.log('status 200')
                    console.log(response)
                }
            }).catch(error => {
                console.log(error)
            })
        },
        onChgSegment() {
            this.qOrganization = ''
            this.qSubInventory = ''
            this.qSegment2AndLocator = ''
            this.qLocatorInventory = ''
            this.qSegment2 = ''
            this.qInventoryItem = ''

            if (!this.qSegment) {
                this.lovOrganization = this.lovOrganizationLst
                this.lovInventoryItem = this.lovInventoryItemLst
                return
            }

            this.lovOrganization = this.lovOrganizationLst
            let filterOrganizationLst = this.lovOrganization.filter(item => item.tobacco_group_code === this.qSegment)
            this.lovOrganization = filterOrganizationLst

            this.lovInventoryItem = this.lovInventoryItemLst
            let filterInventoryItemLst = this.lovInventoryItem.filter(item => item.tobacco_group_code === this.qSegment)
            this.lovInventoryItem = filterInventoryItemLst
        },
        onChgOrganization() {
            this.qSubInventory = ''
            this.qLocatorInventory = ''
            this.qSegment2AndLocator = ''
            this.qSegment2 = ''
            this.qInventoryItem = ''

            if (!this.qOrganization) {
                this.lovSubInventory = this.lovSubInventoryLst
                return
            }

            this.lovSubInventory = this.lovSubInventoryLst
            let filterSubInventoryLst = this.lovSubInventory.filter(item => item.organization_code === this.qOrganization)
            this.lovSubInventory = filterSubInventoryLst

            this.lovLocatorInventory = this.lovLocatorInventoryLst
            let filterLocatorInventoryLst = this.lovLocatorInventory.filter(item => item.organization_code === this.qOrganization)
            this.lovLocatorInventory = filterLocatorInventoryLst

            this.lovInventoryItem = this.lovInventoryItemLst
            let filterInventoryItemLst = this.lovInventoryItem.filter(item => item.tobacco_group_code === this.qSegment &&
                item.organization_code === this.qOrganization
            )
            this.lovInventoryItem = filterInventoryItemLst
        },
        onChgLocatorInventory() {

            let segment2AndLocatorArray = this.qSegment2AndLocator.split(',')

            this.qSegment2 = segment2AndLocatorArray[0]
            this.qLocatorInventory = segment2AndLocatorArray[1]
            return
        },
        onChgSubInventory(){
            this.qSegment2AndLocator = ''
            this.qLocatorInventory = ''
            this.qSegment2 = ''

            if (!this.qSubInventory) {
                this.lovLocatorInventory = this.lovLocatorInventoryLst
                return
            }

            this.lovLocatorInventory = this.lovLocatorInventoryLst
            let filterLocatorLst = this.lovLocatorInventory.filter(item => item.subinventory_code === this.qSubInventory
            && item.organization_code === this.qOrganization)
            this.lovLocatorInventory = filterLocatorLst
        },
        onChgCheckMinQty() {
            if (this.checkMinQty) {
                this.checkExpDate = false
                this.checkLotNo = false
                return
            }
        },
        onChgCheckExpDate() {
            if (this.checkExpDate) {
                this.checkLotNo = true
                this.checkMinQty = false
                return
            }
        },
        getDisplayColumnClass() {
            if (!this.isCheckLotNo) {
                return 'hide-column'
            }
        },
        getDisplayColumnExpClass() {
            if (!this.isCheckLotNo && !this.isCheckExpDate) {
                return 'hide-column'
            }
        },
        getQuantityRowClass(row) {
            if (parseFloat(row.min_qty) > parseFloat(row.transaction_quantity)) {
                return 'bg-warning text-dark'
            }
            return
        },
        getExpDateClass(row) {
            if (!this.isCheckLotNo) {
                return 'hide-column'
            }
            if (this.isCheckExpDate) {
                return 'bg-danger text-center'
            }
        },
        numberFormat(n) {
            if (n !== null && n !== '') {
                return parseFloat(n).toLocaleString()
            }
            return
        },
    },
}
</script>

<style>
#pm0008 th,
#pm0008 td {
    vertical-align: middle !important;
    text-align: center;
}

#pm0008 table.scroll-bar-top {
    overflow-x: auto;
    scrollbar-x-position: top;
}

#pm0008 .form-check-input {
    width: 20px;
    height: 45px;
    border: 1px solid #e5e6e7;
}

#pm0008 .checkbox label::before {
    content: "";
    display: inline-block;
    width: 17px;
    height: 17px;
    left: 0;
    margin-left: -20px;
    border: 1px solid #cccccc;
}

#pm0008 .container {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
#pm0008 .container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

/* Create a custom checkbox */
#pm0008 .checkmark {
    position: absolute;
    top: 10px;
    left: 0;
    height: 20px;
    width: 20px;
    border: 1px solid #e5e6e7;
    border-radius: 4px;
}

/* On mouse-over, add a grey background color */
#pm0008 .container:hover input ~ .checkmark {
    border: 1px solid #e5e6e7;
    border-radius: 4px;
}

/* When the checkbox is checked, add a blue background */
#pm0008 .container input:checked ~ .checkmark {
    background-color: #1ab394;
}

/* Create the checkmark/indicator (hidden when not checked) */
#pm0008 .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
#pm0008 .container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
#pm0008 .container .checkmark:after {
    left: 7px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

#pm0008 .ibox-title {
    padding: 20px !important;
}

#pm0008 .text-dark {
    color: black !important;
}

#pm0008 .el-select {
    width: 100%;
}

#pm0008 th.hide-column {
    display: none;
}

#pm0008 td.hide-column {
    display: none;
}

</style>
