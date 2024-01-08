<!--suppress ALL -->
<template>
    <div>
        <form ref="mainForm">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row pl-2 pt-3">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-lg-1 col-form-label pm21-field"
                                       for="lookup-header-request-num">
                                    เลขที่เอกสาร:
                                </label>
                                <div class="col-lg-2 pl-0">
                                    <el-autocomplete
                                        id="lookup-header-request-num"
                                        class="inline-input"
                                        v-model="queriesModel.requestNum"
                                        :fetch-suggestions="autoCompleteRequestNumber"
                                        :trigger-on-focus="true"
                                        placeholder="โปรดระบุเลขที่เอกสาร"
                                    />
                                </div>
                                <label class="col-lg-1 col-form-label pm21-field" for="header-request-date">
                                    วันที่ร้องขอ:
                                </label>
                                <div class="col-lg-2 pl-0">
                                    <ct-datepicker
                                        id="header-request-date"
                                        class="form-control my-1"
                                        placeholder="โปรดเลือกวันที่"
                                        :enableDate="date => isInRange(date, null, null, true)"
                                        :value="toJSDate(queriesModel.date, 'yyyy-MM-dd')"
                                        @change="(date)=>{
                                            queriesModel.date = jsDateToString(date)
                                            queriesModel = {...queriesModel}
                                        }"
                                    />
                                </div>
                                <label
                                    class="col-lg-1 col-form-label pm21-field"
                                    for="lookup-header-status">
                                    สถานะการร้องขอ:
                                </label>
                                <div class="col-lg-2">
                                    <el-select
                                        clearable
                                        placeholder="โปรดเลือกสถานะ"
                                        :value="getStatusDesc(queriesModel.status)"
                                        @change="(value)=>{
                                            queriesModel.status = value.lookup_code
                                            queriesModel = {...queriesModel}
                                        }">

                                        <el-option
                                            v-for="status in material_status_lookup"
                                            :key="status.lookup_code"
                                            :label="status.description"
                                            :value="status">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-lg-3">
                                    <div class="float-right">
                                        <!--ปุ่มล้างค่า-->
                                        <button type="button"
                                                :class="btn_trans.reset.class"
                                                @click.prevent="onClearTextButtonClicked()">
                                            <i :class="btn_trans.reset.icon"></i>
                                            {{ btn_trans.reset.text }}
                                        </button>

                                        <!--ปุ่มค้นหา-->
                                        <button type="button"
                                                :class="btn_trans.search.class"
                                                href="#modal-form"
                                                @click.prevent="onSearchButtonClicked">
                                            <i :class="btn_trans.search.icon"></i>
                                            {{ btn_trans.search.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5>รายการขอเบิกวัตถุดิบจากจัดหา</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered" v-if="ingredientRequestsModel.length > 0 && !isSearching">
                        <thead>
                        <tr>
                            <th>เลขที่ใบร้องขอ</th>
                            <th>หน่วยงานที่ร้องขอ</th>
                            <th>ชุดเครื่องจักร</th>
                            <th>วันที่ร้องขอ</th>
                            <th>สถานะการร้องขอ</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(ingredientRequest, i) in ingredientRequestsModel">
                            <!-- เลขที่ใบร้องขอ -->
                            <td>
                                <a
                                    :href="getItemRoute(ingredientRequest.ingreq_header_id)">
                                    {{ ingredientRequest.request_num }}
                                </a>
                            </td>

                            <!-- หน่วยงานที่ร้องขอ -->
                            <td>
                                {{ ingredientRequest.department_name }}
                            </td>

                            <!-- ชุดเครื่องจักร -->
                            <td>
                                {{ ingredientRequest.machine_group }}
                            </td>

                            <!-- วันที่ร้องขอ -->
                            <td>
                                {{ toThDateString(toJSDate(ingredientRequest.request_date, 'yyyy-MM-dd')) }}
                            </td>

                            <!-- สถานะการร้องขอ -->
                            <td>
                                {{ ingredientRequest.status.description }}
                            </td>

                            <td>
                                <div class="text-left">
                                    <a
                                        class="btn btn-primary"
                                        :href="getItemRoute(ingredientRequest.ingreq_header_id)">

                                        รายละเอียด
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="text-center" v-if="ingredientRequestsModel.length === 0 && !isSearching">
                        <span class="lead">ไม่พบข้อมูล</span>
                    </div>

                    <div v-if="isSearching"
                         class="sk-spinner sk-spinner-wave mb-4"
                         style="display: block">

                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
        </form>

<!--        <div class="form-group row">-->
<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        ingredientRequestsModel,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        material_status_lookup,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        queriesModel,-->
<!--                        isSearching,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->
<!--        </div>-->
    </div>
</template>

<script>
import {instance as http} from "../httpClient";
import {
    $route,
    api_pm_machineIngredientRequests_show,
    api_pm_ingredientRequests_index,
} from "../../router";
import {warningBeforeUnload} from "../helpers";
import {DateTime} from 'luxon';
import _get from 'lodash/get';
import _isEqual from 'lodash/isEqual';
import _cloneDeep from 'lodash/cloneDeep';
import _isEmpty from 'lodash/isEmpty';
import {
    toJSDate,
    toThDateString,
    jsDateToString,
    isInRange,
} from '../../dateUtils'

function getPM0020Route(headerId) {
    return $route(api_pm_machineIngredientRequests_show, {id: headerId})
}

function gotoPM0021(queries) {

    let queryString = {};
    if (requestNum) {
        queryString.requestNum = queries.requestNum;
    }
    if (requestDate) {
        queryString.date = queries.date;
    }
    if (requestStatus) {
        queryString.status = queries.status;
    }

    window.location = $route(api_pm_ingredientRequests_index) + '?' +
        (new URLSearchParams(queryString).toString());
}

function searchIngredientRequest(requestNum, date, status) {
    console.debug('searchIngredientRequest', requestNum, date, status);

    let params = {};
    if (requestNum) {
        params.requestNum = requestNum;
    }
    if (date) {
        params.date = date;
    }
    if (status) {
        params.status = status;
    }

    let route = $route(api_pm_ingredientRequests_index) + '?' +
        new URLSearchParams(params).toString();

    return http.get(route);
}

export default {
    created() {
        warningBeforeUnload(() => {
            return false;
        })
    },
    data() {
        return {
            //lodash
            lodash: {
                _get,
                _isEqual,
                _cloneDeep,
                _isEmpty,
            },

            //luxon
            DateTime,

            //date picker
            toJSDate,
            toThDateString,
            jsDateToString,
            isInRange,

            queriesModel: _cloneDeep(this.queries),
            ingredientRequestsModel: _cloneDeep(this.ingredient_requests),

            isSearching: false,
        }
    },
    props: {
        btn_trans: {type: Object},
        material_status_lookup: {type: Array, default: []},
        ingredient_requests: {type: Array, default: []},
        queries: {type: Object, default: {}},
    },
    methods: {
        autoCompleteRequestNumber(query, callback) {
            if (!query || _isEmpty(query)) {
                callback([]);
                return;
            }

            searchIngredientRequest(query, null, null)
                .then((result) => {
                    callback(
                        _get(result, 'data.ingredient_requests', []).map((request) => {
                            return {value: request.request_num}
                        })
                    );
                })
                .catch((err) => {
                    callback([]);
                });
        },
        getStatusDesc(statusCode) {
            let matchedStatus = this.material_status_lookup.find((status) => {
                if (+status.lookup_code === +statusCode) {
                    return true;
                }
            });
            if (matchedStatus) {
                return matchedStatus.description;
            }
            return null;
        },
        getItemRoute(headerId) {
            return getPM0020Route(headerId);
        },
        onClearTextButtonClicked() {
            this.queriesModel = {};
        },
        onSearchButtonClicked() {
            console.debug('onSearchButtonClicked', this.queriesModel);
            this.isSearching = true;

            let requestNum = this.queriesModel.requestNum;
            let date = this.queriesModel.date;
            let status = this.queriesModel.status;

            searchIngredientRequest(requestNum, date, status)
                .then((result) => {
                    console.debug('onSearchButtonClicked (success)')
                    this.isSearching = false;
                    this.ingredientRequestsModel = _get(result, 'data.ingredient_requests', []);
                })
                .catch((err) => {
                    console.debug('onSearchButtonClicked (error)')
                    this.isSearching = false;
                    this.ingredientRequestsModel = [];
                });
        },
    },
}
</script>

<style scoped>
label.col-lg-1.col-form-label.pm21-field {
    padding: 7px 4px;
}

.el-autocomplete-suggestion {
    z-index: 3000 !important;
}
</style>
