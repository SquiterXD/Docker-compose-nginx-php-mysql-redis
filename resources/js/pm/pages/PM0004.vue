<template>
    <form>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>ค้นหา</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form" class="form">
                                    <div class="form-group row">
                                        <label for="i1" class="col-lg-2 col-form-label">เลขที่เอกสาร:</label>
                                        <div class="col-lg-4">
                                            <db-lookup
                                                id="i1"
                                                table-name="PtpmRequestHeaderLookup"
                                                v-model="search_params.request_number"
                                                key-field="request_number"
                                                value-field="request_number"
                                                label-pattern="{$}"
                                                :label-fields="['request_number']"
                                                :search-keys="['request_number']"
                                                :max-results="20"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i2" class="col-2 col-form-label">วันที่ขอเบิก:</label>
                                        <div class="col-4">
                                            <ct-datepicker
                                                id="i2"
                                                class="form-control"
                                                :enableDate="date => isInRange(date, null, search_params.request_date_to)"
                                                v-model="search_params.request_date_from"/>
                                        </div>
                                        <label for="i3" class="col-1 text-center col-form-label">ถึง</label>
                                        <div class="col-4">
                                            <ct-datepicker
                                                id="i3"
                                                class="form-control"
                                                :enableDate="date => isInRange(date, search_params.request_date_from, null)"
                                                v-model="search_params.request_date_to"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="i1" class="col-lg-3 col-form-label">สถานะการขอเบิก:</label>
                                    <div class="col-lg-4">
                                        <el-select
                                            clearable
                                            v-model="search_params.request_status"
                                            name="request_status"
                                            placeholder="เลือกสถานะ">
                                            <el-option
                                                v-for="item in request_status_list"
                                                :key="item.lookup_code"
                                                :label="item.description"
                                                :value="item.lookup_code">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="i4" class="col-3 col-form-label">วันที่นำส่ง ยสท.</label>
                                    <div class="col-4">
                                        <ct-datepicker
                                            id="i4"
                                            class="form-control"
                                            :enableDate="date => isInRange(date, null, search_params.send_date_to)"
                                            v-model="search_params.send_date_from"/>
                                    </div>
                                    <label for="i5" class="col-1 text-center col-form-label">ถึง</label>
                                    <div class="col-4">
                                        <ct-datepicker
                                            id="i5"
                                            class="form-control"
                                            :enableDate="date => isInRange(date, search_params.send_date_from, null)"
                                            v-model="search_params.send_date_to"/>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <div class="col-lg-12">
                                        <div class="float-right">
                                            <button
                                                type="button"
                                                :class="btn_trans.reset.class"
                                                @click.prevent="clearSearchForm">
                                                <i :class="btn_trans.reset.icon"></i>
                                                {{ btn_trans.reset.text }}
                                            </button>
                                            <button
                                                value="ค้นหา"
                                                type="submit"
                                                :disabled="!canSearch"
                                                :class="btn_trans.search.class"
                                                @click.prevent="searchForm">
                                                <i :class="btn_trans.search.icon"></i>
                                                {{ btn_trans.search.text }}
                                            </button>
                                            <!--                                        <button class="btn btn-w-m btn-default" type="submit" value="ค้นหา">-->
                                            <!--                                            <i class="fa fa-search"></i> ค้นหา-->
                                            <!--                                        </button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">

                        <table class="table table-bordered">
                            <thead>
                            <tr class="">
                                <th class="" style="width:10%">เลขที่เอกสาร</th>
                                <th class="" style="width:20%">หน่วยงานที่ขอเบิก</th>
                                <th class="" style="width:10%">วันที่ขอเบิก</th>
                                <th class="" style="width:10%">วันที่นำส่งยสท.</th>
                                <th class="" style="width:15%">สถานะการขอเบิก</th>
                                <th style="width:15%"></th>
                                <th style="width:15%"></th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="header in headers">
                                <td class="col-readonly">{{ header.request_number }}</td>
                                <td class="col-readonly">
                                    {{ lodash.get(header, 'coa_dept_code_v.description') }}
                                </td>
                                <td class="col-readonly">{{ toThDateString(header.request_date) }}</td>
                                <td class="col-readonly">{{ toThDateString(header.send_date) }}</td>
                                <td class="col-readonly">
                                    {{ lodash.get(header, 'request_transfer_status.description') }}
                                </td>
                                <td>
                                    <a
                                        :href="header.url"
                                        type="button"
                                        :class="btn_trans.detail.class">
                                        <i :class="btn_trans.detail.icon"></i>
                                        {{ btn_trans.detail.text }}
                                    </a>
                                </td>
                                <td>
                                    <button type="button" :class="btn_trans.cancelRawMaterialTransfer.class"><i
                                        :class="btn_trans.cancelRawMaterialTransfer.icon"></i>
                                        {{ btn_trans.cancelRawMaterialTransfer.text }}
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-center" v-if="headers.length === 0">
                            <span class="lead">No Data.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import DatePicker from "vue2-datepicker"
import {DateTime} from 'luxon';
import {toJSDate, jsDateToString, toThDateString, isInRange} from '../../dateUtils'

import _get from "lodash/get"
import {instance as http} from "../httpClient";
import {
    $route,
    pm_0004_index,
    pm_0005_index,
} from '../../router'

import {
    showLoadingDialog,
} from "../../commonDialogs"

// const request_status_list = [
//     {key: '1', label: 'ยังไม่ส่งข้อมูล'},
//     {key: '2', label: 'ส่งข้อมูลเรียบร้อย'},
//     {key: '3', label: 'ยืนยันการรับข้อมูล'},
//     {key: '4', label: 'ยกเลิกการขอโอนวัตถุดิบ'},
// ]

function createHeaderLines(header, lines, user) {
    return http.post($route('api.pm.request-materials.create'), {
        header,
        lines,
        user
    })
}

function filterObject(object, predicate = null) {
    predicate ??= (key, value) => !!value
    let o = {}
    for (let key in object) {
        if (object.hasOwnProperty(key) && predicate(key, object[key])) o[key] = object[key]
    }
    return o
}

function mappingHeader(header, request_status_list) {
    return {
        ...header,
        url: $route(pm_0005_index, {'id': header.request_header_id}),
    }
}

export default {
    created: function () {
        console.log('!! created !!')
    },
    mounted() {
        console.log('!! mounted !!')
    },
    props: {
        request_status_list: {type: Array, default: []},
        init_headers: {type: Array, default: []},
        init_search_params: {
            type: Object,
            default: {
                request_number: null,
                request_date_from: null,
                request_date_to: null,
                send_date_from: null,
                send_date_to: null,
                request_status: null,
            },
        },
        btn_trans: {type: Object},
        user: {type: Object},
    },
    computed: {
        canSearch() {
            return true//Object.values(this.search_params).filter(it => !!it).length > 0
        },
    },
    data() {
        return {

            lodash: {get: _get},
            isInRange,
            toThDateString,
            luxon: DateTime,

            search_params: {
                ...this.init_search_params,
                request_date_from: toJSDate(this.init_search_params.request_date_from),
                request_date_to: toJSDate(this.init_search_params.request_date_to),
                send_date_from: toJSDate(this.init_search_params.send_date_from),
                send_date_to: toJSDate(this.init_search_params.send_date_to),
            },

            headers: this.init_headers.map(it => mappingHeader(it, this.request_status_list)),
        }
    },
    methods: {
        searchForm() {
            let form = {
                ...this.search_params,
                request_date_from: jsDateToString(this.search_params.request_date_from),
                request_date_to: jsDateToString(this.search_params.request_date_to),
                send_date_from: jsDateToString(this.search_params.send_date_from),
                send_date_to: jsDateToString(this.search_params.send_date_to),
            }
            let queryString = filterObject(form)
            console.log(form, queryString)

            showLoadingDialog()
            window.location = $route(pm_0004_index) + '?' + (new URLSearchParams(queryString).toString());
        },
        clearSearchForm() {
            this.search_params = {
                request_number: null,
                request_date_from: null,
                request_date_to: null,
                send_date_from: null,
                send_date_to: null,
                request_status: null,
            }
        },
    },
}

</script>


<style scoped>
.form-control {
    height: 40px;
    border-radius: 4px;
}

.col-readonly {
    background: #e9ecef42 !important;
}

label.col-lg-1.col-form-label {
    padding: 7px 15px;
}

</style>
