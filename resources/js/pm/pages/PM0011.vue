<template>
    <div class="pm0011">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">
                                ปีงบประมาณ
                            </label>
                            <div class="col-lg-7">
                                <!--                                <db-lookup-->
                                <!--                                    id="filter-thai-year"-->
                                <!--                                    table-name="PtBiweeklyLookup"-->
                                <!--                                    key-field="thai_year"-->
                                <!--                                    v-model="filter.year"-->
                                <!--                                    label-pattern="{$}"-->
                                <!--                                    :label-fields="['thai_year']"-->
                                <!--                                    :search-keys="['thai_year']"-->
                                <!--                                    :pre-fetch="true"-->
                                <!--                                    :max-results="20"-->
                                <!--                                    :remoteDataSource="() => thaiYears">-->
                                <!--                                </db-lookup>-->
                                <el-select
                                    id="filter-thai-year"
                                    placeholder="ปี"
                                    value-key="thai_year"
                                    v-model="filter.year">
                                    <el-option
                                        v-for="item in thaiYears"
                                        :key="item.thai_year"
                                        :label="item.thai_year"
                                        :value="item">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">
                                แผนผลิตบุหรี่ประจำเดือน
                            </label>
                            <div class="col-lg-7">
                                <!--                                <db-lookup-->
                                <!--                                    id="filter-thai-month"-->
                                <!--                                    table-name="PtBiweeklyLookup"-->
                                <!--                                    key-field="thai_month"-->
                                <!--                                    v-model="filter.month"-->
                                <!--                                    label-pattern="{$}"-->
                                <!--                                    :label-fields="['thai_month']"-->
                                <!--                                    :search-keys="['thai_month']"-->
                                <!--                                    :pre-fetch="true"-->
                                <!--                                    :max-results="20"-->
                                <!--                                    :remoteDataSource="() => thaiMonths">-->
                                <!--                                </db-lookup>-->
                                <el-select
                                    id="filter-thai-month"
                                    placeholder="เดือน"
                                    value-key="thai_month"
                                    v-model="filter.month"
                                    :disabled="filter.year === null">
                                    <el-option
                                        v-for="item in thaiMonths"
                                        :key="item.thai_month"
                                        :label="item.thai_month"
                                        :value="item">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">
                                ปักษ์ที่&nbsp; <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-3">
                                <!--                                <db-lookup-->
                                <!--                                    id="filter-biweekly"-->
                                <!--                                    table-name="PtBiweeklyLookup"-->
                                <!--                                    key-field="biweekly"-->
                                <!--                                    v-model="filter.biweekly"-->
                                <!--                                    label-pattern="{$}"-->
                                <!--                                    :label-fields="['biweekly']"-->
                                <!--                                    :search-keys="['biweekly']"-->
                                <!--                                    :max-results="20"-->
                                <!--                                    :filterBy="() => ({thai_month: filter.month.thai_month})"-->
                                <!--                                    :remoteDataSource="() => biweeklys"-->
                                <!--                                    @change="onSelectBiweekly">-->
                                <!--                                </db-lookup>-->
                                <el-select
                                    id="filter-biweekly"
                                    placeholder="ปักษ์"
                                    value-key="biweekly"
                                    v-model="filter.biweekly"
                                    :disabled="filter.month === null"
                                    @change="onSelectBiweekly">
                                    <el-option
                                        v-for="item in biweeklys"
                                        :key="item.biweekly"
                                        :label="item.biweekly"
                                        :value="item">
                                    </el-option>
                                </el-select>
                            </div>
                            <label class="col-lg-1 col-form-label" for="d-1">
                                ครั้งที่
                            </label>
                            <div class="col-lg-3">
                                <input class="form-control" type="text" autocomplete="off" id="d-1"
                                       disabled="disabled"
                                       :value="lodash.get(header, 'plan_revision_no')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="filter-dates">
                                วันที่
                            </label>
                            <div class="col-lg-3">
                                <input
                                    id="filter-dates"
                                    class="form-control"
                                    type="text"
                                    autocomplete="off"
                                    disabled="disabled"
                                    :value="filter.displayDateRange">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="d-2">
                                แผนการผลิตยาเส้นครั้งที่
                            </label>

                            <div class="col-lg-3">
                                <input class="form-control" type="text" autocomplete="off" id="d-2"
                                       disabled="disabled"
                                       :value="lodash.get(header, 'revision_number')">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>การวางแผนผลิตยาเส้น</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <button
                                        class="btn btn-success"
                                        @click="onPlanning">
                                        <i class="fa fa-plus"></i> วางแผนยาเส้นประจำปักษ์
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        :disabled="lodash.isEqual(dataStage.lines, lines)"
                                        @click="onSave">
                                        <i class="fa fa-plus"></i> บันทึก
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive" v-if="lines && lines.length > 0">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="tr-header">
                                    <th rowspan="3" style="width:3%; text-align:center;  font-size: 1em;"> #</th>
                                    <th rowspan="3" style="width:10%;  font-size: 1em;"> ขอบเขตเครื่องจัตร</th>
                                    <th class="input-lookup"></th>
                                    <th v-for="distColumn in distColumns">
                                        {{ distColumn.planDate }}
                                    </th>
                                </tr>
                                <tr class="tr-header">
                                    <th></th>
                                    <th v-for="distColumn in distColumns">
                                        {{ distColumn.workingHour }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>หัวจ่าย</th>
                                    <th v-for="distColumn in distColumns"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <fragment v-for="(line, i) in lines" :key="line.plan_line_id">
                                    <tr>
                                        <td class="text-center" rowspan="2">
                                            <span>{{ (i + 1) }}</span>
                                        </td>
                                        <td rowspan="2" class="text-left">{{ line.machine_groups.meaning }}</td>
                                        <td rowspan="2">
                                            <db-lookup
                                                table-name="PtpmFeederNameLookup"
                                                v-model="line.feeder_code"
                                                label-pattern="{$}"
                                                placeholder=""
                                                key-field="lookup_code"
                                                :label-fields="['meaning']"
                                                :search-keys="['meaning']"
                                                :pre-fetch="true"
                                                :max-results="20"
                                                :initial-object="line.feeder"
                                                @change="(item) => line.feeder_code = lodash.get(item, 'lookup_code', '')">
                                            </db-lookup>
                                        </td>
                                        <td v-for="dist in line.dists" class="inventory-item-id-lookup">
                                            <db-lookup
                                                table-name="-"
                                                v-model="dist.inventory_item_id"
                                                label-pattern="{$}"
                                                placeholder=""
                                                key-field="inventory_item_id"
                                                :label-fields="['blend_no']"
                                                :search-keys="['blend_no']"
                                                :pre-fetch="false"
                                                :max-results="20"
                                                :initial-object="dist.item_number_v"
                                                :remote-data-source="(_, __, query) => lookupBlendNo(query)"
                                                @change="(item) => dist.inventory_item_id = lodash.get(item, 'inventory_item_id', '')">
                                            </db-lookup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-for="dist in line.dists" class="plan-qty-lookup">
                                            <input
                                                type="number"
                                                v-model="dist.plan_quantity"/>
                                        </td>
                                    </tr>
                                </fragment>
                                </tbody>
                            </table>
                        </div>
                        <div class="lead" v-else>
                            No Data.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import {setAllObjectKeys, warningBeforeUnload} from "../helpers"
import {
    showLoadingDialog,
    showSaveSuccessDialog,
    showSaveFailureDialog,
} from "../../commonDialogs"
import {instance as http} from "../httpClient";
import {
    $route,
    api_pm_planningJobLines_lines,
    api_pm_planningJobLines_lookupBlendNo,
    api_pm_planningJobLines_updateLines,
} from "../../router";
import {DateTime} from 'luxon';
import _get from 'lodash/get';
import _isEqual from 'lodash/isEqual';
import _cloneDeep from 'lodash/cloneDeep';
import * as Validator from 'validatorjs';
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils"

function loadLines(periodName, periodYear, biweekly) {
    return http.get($route(api_pm_planningJobLines_lines), {params: {periodName, periodYear, biweekly}})
}

function lookupBlendNo(query) {
    return http.get($route(api_pm_planningJobLines_lookupBlendNo), {params: {query}}).then(({data}) => {
        return data
    })
}

function updateLines(headerId, lines) {
    return http.put($route(api_pm_planningJobLines_updateLines), {headerId, lines})
}

function unique(arr) {
    return [...new Set(arr)]
}

export default {
    props: {
        biweekly_list: {type: Array, default: [],},
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
            },

            filter: {
                year: null,
                month: null,
                biweekly: null,
                displayDateRange: null,
            },

            distColumns: [],
            header: {
                plan_revision_no: null,
                revision_number: null,
            },
            lines: [],

            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    computed: {
        thaiYears() {
            return unique(
                this.biweekly_list
                    .map(row => row.thai_year)
            )
        },
        thaiMonths() {
            if (this.filter.year === null) return null
            return unique(
                this.biweekly_list
                    .filter(row => row.thai_year === this.filter.year)
                    .map(row => row.thai_month)
            )
        },
        biweeklys() {
            if (this.filter.year === null) return null
            if (this.filter.month === null) return null
            return unique(
                this.biweekly_list.filter(row => row.thai_year === this.filter.year && row.thai_month === this.filter.month)
                    .map(row => row.biweekly)
            )
        },
    },
    methods: {
        lookupBlendNo,
        onSelectBiweekly() {
            let selectedBiweeklyItems = this.biweekly_list.filter(row => {
                return row.thai_year === this.filter.year &&
                    row.thai_month === this.filter.month &&
                    row.biweekly === this.filter.biweekly
            })

            if (selectedBiweeklyItems.length === 0) {
                //TODO not found
                return
            }

            let selectedBiweeklyItem = selectedBiweeklyItems[0]
            console.log({selectedBiweeklyItem})

            let start = new Date(`${selectedBiweeklyItem.start_date}`)
            let end = new Date(`${selectedBiweeklyItem.end_date}`)
            let month = selectedBiweeklyItem.thai_month
            let year = selectedBiweeklyItem.thai_year
            this.filter.displayDateRange = `${start.getDate()}-${end.getDate()} ${month} ${year}`

            //showLoadingDialog()
            loadLines(selectedBiweeklyItem.period_name, selectedBiweeklyItem.period_year, selectedBiweeklyItem.biweekly).then(({data}) => {
                //swal.close()
                console.log(data)
                this.header = data.header
                this.lines = data.lines

                this.dataStage.lines = _cloneDeep(this.lines)

                if (!this.header || this.lines.length === 0) return

                this.distColumns = this.lines[0].dists.map(dist => {
                    let d = DateTime.fromObject(new Date(`${dist.plan_date}`))
                    return {
                        planDate: d.toFormat('dd-LLL-yy'),
                        workingHour: dist.working_hour,
                    }
                })
            }).catch(err => {
                //swal.close()
            })
        },
        onPlanning() {

        },
        onSave() {
            showLoadingDialog()
            updateLines(this.header.plan_header_id, this.lines).then(({data}) => {
                showSaveSuccessDialog()
                console.log({data})
                this.lines = data.lines
            }).catch(err => {
                showSaveFailureDialog()
            })
        },
    }
}

</script>

<style scoped>
.pm0011 th.input-lookup {
    min-width: 200px;
}

.pm0011 .ibox-title {
    padding: 15px 20px 15px 20px;
}

.pm0011 .el-select {
    width: 100%;
}

.pm0011 th, .pm0011 tr, .pm0011 td {
    vertical-align: middle !important;
}

.pm0011 tbody tr td {
    text-align: right;
}

.pm0011 th {
    font-size: 0.8em;
    white-space: nowrap;
}

.pm0011 tr.tr-header {
    text-align: right;
}

.pm0011 td.inventory-item-id-lookup, .pm0011 td.plan-qty-lookup {
    padding: 0;
}

.pm0011 td.plan-qty-lookup input {
    border: none;
    padding: 5px;
    width: 80px;
}
</style>

<style>
.pm0011 td.inventory-item-id-lookup input, td.inventory-item-id-lookup .el-input__inner {
    border: none;
}
</style>
