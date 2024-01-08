<div class="ibox float-e-margins mb-2">
    {{-- <div class="ibox-title">
        <div class="text-right">
            <form action="{{ route('pm.ingredient-preparation.print-pdf') }}"  target="_bank">
                <input type="hidden" name="plan_date" value="currentDate" v-model="currentDate">
                <button class="btn btn-w-m btn-info"><i class="fa fa-print"></i> พิมพ์รายงาน</button>

            </form>
        </div>
    </div> --}}
    <div class="ibox-content tw-border-b">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group row">
                    <label class="col-lg-2 col-sm-4 col-form-label">วันที่</label>
                    <div class="col-lg-10">
                        {{-- <el-date-picker 
                            v-model="dateSelected"
                            style="width: 100%;"
                            type="date"
                            name="dateSelected"
                            format="dd-MM-yyyy"
                            @change="getTableData()">
                        </el-date-picker> --}}
                        {{-- <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="dateSelected"
                                v-model="dateSelected"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ old("dateSelected") }}"
                                format="{{ trans("date.js-format") }}"
                                @change="getTableData()"> --}}
                        <ct-datepicker
                            class="my-1 col-sm-12 form-control"
                            name="dateSelected"
                            style="width: 100%;"
                            placeholder="โปรดเลือกวันที่เริ่มต้น"
                            :enableDate="date => isInRange(date, null, toJSDate(), true)"
                            :value="toJSDate(dateSelected, 'yyyy-MM-dd')"
                            @change="(date) => {
                                dateSelected = jsDateToString(date)
                                getCurrentDate()
                            }"
                        />
                        <input type="hidden" name="dateSelected" :value="dateSelected">
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-3 text-right mt-2">
                        <button class="btn btn-sm btn-success" type="submit" @click.prevent="getTableData" > แสดงข้อมูล </button>
                    </div>
                    <div class="col-md-3 mt-2">
                        <form action="{{ route('pm.ingredient-preparation.print-pdf') }}"  target="_bank">
                            <input type="hidden" name="plan_date" value="currentDate" v-model="currentDate">
                            <button class="btn btn-sm btn-info"><i class="fa fa-print"></i> พิมพ์รายงาน</button>
            
                        </form>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ----------------------- table list -------------------------}}
<div class="ibox">
    <div class="ibox-content">
        <div v-if="isLoading">
            <div class="sk-spinner sk-spinner-wave">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div>
        <div v-if="!isLoading"
            class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">ลำดับที่</th>
                    <th class="text-center">รหัสวัตถุดิบ</th>
                    <th class="text-center" style="width: 580px;">รายละเอียด</th>
                    <th class="text-center">จำนวนต่อวัน</th>
                    <th class="text-center">หน่วย</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                    <template v-for="(lists, index) in DataLists">
                        <template v-if="hasM05Data">
                            <tr>
                                <td colspan="6" class="text-center"><b>@{{index}}</b></td>
                            </tr>
                            <tr v-for="(list, i) in lists">
                                <td class="text-center">@{{ i + 1 }}</td>
                                <td>@{{ list.item_number }}</td>
                                <td>@{{ list.description }}</td>
                                <td class="text-right">
                                    @{{ Math.ceil(list.b - list.b_m05).toLocaleString() }}
                                </td>
                                <td class="text-center">@{{ list.unit_of_measure }}</td>
                                <td>
                                    <button type="button" class="btn btn-w-m btn-default" data-toggle="modal" data-target="#detailReportModal"
                                        @click.prevent="onShowDetailClicked(list)">
                                        รายละเอียด
                                    </button>
                                    @include('pm.ingredient-preparation._detail_modal')
                                </td>
                            </tr>
                        </template>
                        <template v-if="!hasM05Data">
                            <tr>
                                <td colspan="6" class="text-center"><b>@{{index}}</b></td>
                            </tr>
                            <tr v-for="(list, i) in lists">
                                <td class="text-center">@{{ i + 1 }}</td>
                                <td>@{{ list.item_number }}</td>
                                <td>@{{ list.description }}</td>
                                <td class="text-right">@{{ Math.ceil(list.b).toLocaleString() }}</td>
                                <td class="text-center">@{{ list.unit_of_measure }}</td>
                                <td>
                                    <button type="button" class="btn btn-w-m btn-default" data-toggle="modal" data-target="#detailReportModal"
                                        @click.prevent="onShowDetailClicked(list)">
                                        รายละเอียด
                                    </button>
                                    @include('pm.ingredient-preparation._detail_modal')
                                </td>
                            </tr>
                        </template>
                    </template>
                    {{-- <tr v-for="(list, i) in DataLists">
                        <td colspan="6"></td>
                    </tr> --}}
                    {{-- <tr v-for="(list, i) in DataLists">
                        <td class="text-center">@{{ i + 1 }}</td>
                        <td>@{{ list.item_number }}</td>
                        <td>@{{ list.description }}</td>
                        <td class="text-right">@{{ list.b }}</td>
                        <td class="text-center">@{{ list.unit_of_measure }}</td>
                        <td>
                            <button type="button" class="btn btn-w-m btn-default" data-toggle="modal" data-target="#detailReportModal"
                                @click.prevent="onShowDetailClicked(list)">
                                รายละเอียด
                            </button>
                            @include('pm.ingredient-preparation._detail_modal')
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>