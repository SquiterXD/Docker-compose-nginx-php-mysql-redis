<template>
    <div>
        <!--                        <pre>{{-->
        <!--                                JSON.stringify({-->
        <!--                                    filter_params,-->
        <!--                                    filter,-->
        <!--                                    reviewCompletes,-->
        <!--                                    btn_trans,-->
        <!--                                }, null, 2)-->
        <!--                            }}</pre>-->
        <div class="row" v-if="isUserDepartmentValid">
            <div class="col-lg-12">
                <div class="ibox ">
                    <form class="ibox-title" @submit.prevent="search">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="inventoryItemId">
                                        รหัสสินค้าสำเร็จรูป:
                                    </label>
                                    <div class="col-lg-9">
                                        <db-lookup
                                            id="inventoryItemId"
                                            table-name="PtpmMesReviewCompletesVLookup"
                                            key-field="item_number"
                                            label-pattern="{$}"
                                            :label-fields="['item_number']"
                                            :search-keys="['item_number']"
                                            :pre-fetch="true"
                                            :max-results="20"
                                            :prePopulateText="lodash.get(filter_params, 'item_number')"
                                            @change="row => setFilter('item_number', row)">
                                        </db-lookup>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="opt">OPT:</label>
                                    <div class="col-lg-9">
                                        <db-lookup
                                            id="opt"
                                            table-name="PtpmMesReviewCompletesVLookup"
                                            key-field="opt"
                                            v-model="filter.opt"
                                            label-pattern="{$}"
                                            :label-fields="['opt']"
                                            :search-keys="['opt']"
                                            :pre-fetch="true"
                                            :max-results="20"
                                            :prePopulateText="lodash.get(filter_params, 'opt')"
                                            @change="row => setFilter('opt', row)">
                                        </db-lookup>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="batchNo">เลขที่คำสั่งการผลิต:</label>
                                    <div class="col-lg-9">
                                        <db-lookup
                                            id="batchNo"
                                            table-name="PtpmMesReviewCompletesVLookup"
                                            key-field="batch_no"
                                            label-pattern="{$}"
                                            :label-fields="['batch_no']"
                                            :search-keys="['batch_no']"
                                            :pre-fetch="true"
                                            :max-results="20"
                                            :prePopulateText="lodash.get(filter_params, 'batch_no')"
                                            @change="row => setFilter('batch_no', row)">
                                        </db-lookup>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">วันที่ได้ผลผลิต:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input
                                                    v-model="filter.plan_cmplt_date_from"
                                                    type="date"
                                                    class="form-control">
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">ถึง:</label>
                                                    <div class="col-lg-10">
                                                        <input
                                                            v-model="filter.plan_cmplt_date_to"
                                                            type="date"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 pb-2">
                                <div class="float-right">
                                    <button type="submit" :class="btn_trans.reset.class"><i
                                        :class="btn_trans.reset.icon"></i>
                                        {{ btn_trans.reset.text }}
                                    </button>
                                    <button type="submit" :class="btn_trans.search.class"><i
                                        :class="btn_trans.search.icon"></i>
                                        {{ btn_trans.search.text }}
                                    </button>
                                </div>
                            </div>
                            <!--                            <div class="row">-->
                            <!--                                <div class="col-lg-12">-->
                            <!--                                    <div class="form-group row">-->
                            <!--                                        <div class="col-lg-12 px-4">-->
                            <!--                                            <button-->
                            <!--                                                class="btn btn-w-m btn-default float-left m-t-n-xs" type="submit">-->
                            <!--                                                <i class="fa fa-search"></i><strong>ค้นหา</strong>-->
                            <!--                                            </button>-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                    </form>
                    <form class="ibox-content" @submit.prevent="save">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="form-check abc-checkbox form-check-inline m-l-md">
                                            <!--<input class="form-check-input" type="checkbox" value="option1">-->
                                        </div>
                                    </th>
                                    <th v-if="view(1,2)" style="min-width: 150px;">เลขที่คำสั่งการผลิต</th>
                                    <th v-if="view(1)">Blend no.</th>
                                    <th v-if="view(1,2)">รหัสสินค้าสำเร็จรูป</th>
                                    <th v-if="view(1,2)" style="min-width: 150px;">รายการ</th>
                                    <th v-if="view(1,2)">OPT</th>
                                    <th v-if="view(1,2)">ผลผลิตที่ได้</th>
                                    <th v-if="view(1,2)" style="min-width: 150px;">ยืนยันผลผลิตที่ได้</th>
                                    <th v-if="view(1,2)">หน่วยนับ</th>
                                    <th v-if="view(1,2)">คลังสินค้า</th>
                                    <th v-if="view(2)">คลังย่อย</th>
                                    <th v-if="view(1)" style="min-width: 150px;">สถานที่จัดเก็บ</th>
                                    <th v-if="view(1)">วันที่บันทึกผลผลิต</th>
                                    <th v-if="view(1)">Silo</th>
                                    <th v-if="view(1,2)">สถานะตัดใช้วัตถุดิบ<br/>(ใบยา)</th>
                                    <th v-if="view(1)">สถานะตัดใช้วัตถุดิบ<br/>(สารปรุง/สารหอม)</th>
                                    <th v-if="view(1,2)">สถานะการบันทึกผลผลิต</th>
                                    <th v-if="view(1)" style="min-width: 150px;">หมายเหตุ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="reviewComplete in reviewCompletes">
                                    <td>
                                        <div class="form-check abc-checkbox form-check-inline m-l-md">
                                            <input
                                                :disabled="lodash.get(reviewComplete, 'record_complete_flag') === 'Y'"
                                                v-model="reviewComplete.isSelected"
                                                class="form-check-input" type="checkbox" value="option1">
                                        </div>
                                    </td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.batch_no }}</td>
                                    <td class="col-readonly" v-if="view(1)">
                                        {{ lodash.get(reviewComplete, 'item_number_v.blend_no') }}
                                    </td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.item_number }}</td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.item_desc }}</td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.opt }}</td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.qty }}</td>
                                    <td v-if="view(1,2)">
                                        <div class="col-lg-12 pl-0 pr-0">
                                            <input
                                                :disabled="lodash.get(reviewComplete, 'record_complete_flag') === 'Y'"
                                                v-model="reviewComplete.review_product_quantity"
                                                type="number"
                                                class="form-control input-field">
                                        </div>
                                    </td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.uom_code }}</td>
                                    <td class="col-readonly" v-if="view(1,2)">{{ reviewComplete.to_subinventory }}</td>
                                    <td class="col-readonly" v-if="view(2)">{{ '-' }}</td>
                                    <td class="col-readonly" v-if="view(1)">{{ reviewComplete.to_locator_code }}</td>
                                    <td v-if="view(1)">
                                        <div class="col-lg-12 pl-0 pr-0">
                                            <input
                                                :disabled="lodash.get(reviewComplete, 'record_complete_flag') === 'Y'"
                                                v-model="reviewComplete.transaction_date"
                                                :max="toDateFormatString(new Date())"
                                                type="date"
                                                class="form-control input-field">
                                        </div>
                                    </td>
                                    <td class="col-readonly" v-if="view(1)">{{ reviewComplete.silo }}</td>
                                    <td class="col-readonly" v-if="view(1,2)">
                                        <div class="form-check abc-checkbox form-check-inline m-l-md">
                                            <input
                                                true-value="Y"
                                                v-model="reviewComplete.tobacco_issue_flag"
                                                :disabled="true"
                                                class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="col-readonly" v-if="view(1)">
                                        <div class="form-check abc-checkbox form-check-inline m-l-md">
                                            <input
                                                true-value="Y"
                                                v-model="reviewComplete.flavor_issue_flag"
                                                :disabled="true"
                                                class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="col-readonly" v-if="view(1,2)">
                                        <div class="form-check abc-checkbox form-check-inline m-l-md">
                                            <input
                                                true-value="Y"
                                                v-model="reviewComplete.record_complete_flag"
                                                :disabled="true"
                                                class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td v-if="view(1)">
                                        <div class="col-lg-12 pl-0 pr-0">
                                            <input
                                                :disabled="lodash.get(reviewComplete, 'record_complete_flag') === 'Y'"
                                                v-model="reviewComplete.remark_msg"
                                                type="text"
                                                class="form-control input-field">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div
                                v-if="reviewCompletes.length === 0"
                                class="lead text-center">ไม่มีข้อมูล
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <!--                            <button type="submit" :class="btn_trans.reviewComplete.class"-->
                            <!--                                    :disabled="this.reviewCompletes.filter(row => row.isSelected).length === 0">-->
                            <!--                                <i :class="btn_trans.reviewComplete.icon"></i>-->
                            <!--                                {{ btn_trans.reviewComplete.text }}-->
                            <!--                            </button>-->
                            <button
                                :disabled="this.reviewCompletes.filter(row => row.isSelected).length === 0"
                                type="submit" class="btn btn-w-m btn-primary">
                                <i class="fa fa-save (alias)"></i>
                                บันทึกผลผลิตเข้าคลัง
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-else>
            Invalid User Department.
        </div>
    </div>
</template>

<script>
import {
    showLoadingDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
} from "../../commonDialogs"
import {instance as http} from "../httpClient";
import {
    $route,
    api_pm_reviewComplete_search,
    api_pm_reviewComplete_save,
} from "../../router";
import {DateTime} from 'luxon';
import _get from 'lodash/get';

function setQueryParams(params) {
    const s = new URLSearchParams(location.search)
    for (let key in params) {
        if (!params[key]) continue
        s.set(key, params[key])
    }
    window.history.replaceState({}, '', `${location.pathname}?${s.toString()}`)
}

function search(query) {
    console.log('search', {query})
    return http.get($route(api_pm_reviewComplete_search), {params: query}).then(({data}) => {
        return data
    })
}

function save(reviewCompletes) {
    return http.post($route(api_pm_reviewComplete_save), {reviewCompletes}).then(({data}) => {
        return data
    })
}

function toDateFormatString(d) {
    let month = `${d.getMonth() + 1}`
    let date = `${d.getDate()}`
    return `${d.getFullYear()}-${month.padStart(2, '0')}-${date.padStart(2, '0')}`
}

function mappingReviewComplete(items) {
    return items.map(item => {
        return {
            ...item,
            transaction_date: item.transaction_date ?
                toDateFormatString(new Date(item.transaction_date)) :
                toDateFormatString(new Date()),
        }
    })
}

export default {
    props: {
        user: {type: Object},
        review_completes: {type: Array},
        coa_dept_code: {type: Object},
        filter_params: {type: Object},
        btn_trans: {type: Object},
    },
    computed: {
        isUserDepartmentValid() {
            console.log('user.department_code', _get(this.user, 'department_code'), this.isView1, this.isView2)
            return this.isView1 || this.isView2
        },
        isView1() {
            return _get(this.user, 'department_code') === '61000200'
        },
        isView2() {
            return _get(this.user, 'department_code') === '61000300'
        },
    },
    data() {
        return {
            toDateFormatString,

            lodash: {
                get: _get,
            },
            view: (...args) => {
                if (this.isView1 && args.indexOf(1) >= 0) return true
                if (this.isView2 && args.indexOf(2) >= 0) return true
                return false
            },
            filter: {
                ...this.filter_params,
            },
            reviewCompletes: mappingReviewComplete(this.review_completes),
        }
    },
    methods: {
        setFilter(field, value) {
            console.log('set filter', field, value)
            this.filter[field] = _get(value, field)
        },
        search() {
            setQueryParams({...this.filter})

            showLoadingDialog()
            search({...this.filter}).then(({reviewCompletes}) => {
                swal.close()
                this.reviewCompletes = mappingReviewComplete(reviewCompletes)
            }).catch(err => {
                swal.close()
                showGenericFailureDialog('เกิดข้อผิดพลาด ไม่สามารถค้นหาข้อมูลได้')
            })
        },
        save() {
            let rows = this.reviewCompletes.filter(row => row.isSelected)
            console.log('save', rows)

            showLoadingDialog()
            save(rows).then(({reviewCompletes}) => {
                showSaveSuccessDialog()
                this.reviewCompletes = mappingReviewComplete(reviewCompletes)
            }).catch(err => {
                swal.close()
                showGenericFailureDialog('เกิดข้อผิดพลาด ไม่สามารถค้นหาข้อมูลได้')
            })
        },

        // onTransactionDateChange(val, row) {
        //     let selectedDate = new Date(val)
        //     console.log({selectedDate})
        //
        //     let today = new Date()
        //     if (selectedDate.getTime() > today.getTime()) {
        //         this.form.request_date = toDateFormatString(today)
        //     }
        // },
    }
}
</script>
<style scoped>
th,
td {
    vertical-align: middle !important;
    text-align: center;
}

.col-readonly {
    background: #e9ecef42 !important;
}

input.form-control.input-field {
    border: none;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}
</style>
