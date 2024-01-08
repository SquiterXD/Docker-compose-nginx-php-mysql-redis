<div class="ibox float-e-margins mb-2">
    <div class="ibox-title">
        <div class="text-right">
            <form action="{{ route('pm.ingredient-preparation.print-pdf') }}"  target="_bank">
                <input type="hidden" name="plan_date" value="currentDate" v-model="currentDate">
                <button class="btn btn-w-m btn-info"><i class="fa fa-print"></i> พิมพ์รายงาน</button>

            </form>
            {{-- <a href="{{ route('pm.ingredient-preparation.print-pdf') }}" target="_bank" class="btn btn-w-m btn-info">
                <i class="fa fa-print"></i> พิมพ์รายงานคิวอาร์โค้ด
            </a> --}}
        </div>
    </div>
    <div class="ibox-content tw-border-b">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
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
                        <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="dateSelected"
                                v-model="dateSelected"
                                placeholder="โปรดเลือกวันที่"
                                value="{{ old("dateSelected") }}"
                                format="{{ trans("date.js-format") }}"
                                @change="getTableData()">
                    </div>
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
                        <tr>
                            <td colspan="6" class="text-center"><b>@{{index}}</b></td>
                        </tr>
                        <tr v-for="(list, i) in lists">
                            <td class="text-center">@{{ i + 1 }}</td>
                            <td>@{{ list.item_number }}</td>
                            <td>@{{ list.description }}</td>
                            <td class="text-right">@{{ Math.ceil(list.b) }}</td>
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


{{-- ----------------------- detial -------------------------}}

{{-- <div id="detailReportModal" ref="detailReportModalRef" class="modal bd-example-modal-xl fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="isCurrentDetailsLoading">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                <div v-if="!isCurrentDetailsLoading" class="ibox-content">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-2 col-sm-4 col-form-label">วันที่</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" v-model="currentDetailPlanDate" disabled="disabled"/>
                                </div>
                            </div>
                        </div>
                        <div class="text-right col-lg-3">
                            <button type="button" class="btn btn-w-m btn-info"><i
                                class="fa fa-print"></i>
                                พิมพ์รายงาน
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-3 col-sm-4 col-form-label">รายการพัสดุ</label>
                                <div class="col-lg-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="currentItemNumber"
                                        disabled="disabled"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="currentItemDescription"
                                        disabled="disabled"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="col-lg-4 ml-auto">
                                <qrcode-vue v-model="currentQRCode" :size="100" level="H"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="isDetailsLoading">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table
                        v-if="!isDetailsLoading"
                        class="table table-bordered">
                        <thead>
                            <tr>
                                <th><div style="width: 160px;">ชุดเครื่องจักร</div></th>
                                <th><div style="width: 160px;">ปริมาณที่ต้องใช้</div></th>
                                <th><div style="width: 160px;">คงคลังเช้าหน้าเครื่อง</div></th>
                                <th><div style="width: 150px;">วางหน้าเครื่องสูงสุด</div></th>
                                <th><div style="width: 160px;">ปริมาณที่สามารถเบิกได้</div></th>
                                <th><div style="width: 70px;">หน่วยนับ</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="line in detailLines">
                                <td>@{{ line.machine_set + ' : ' + line.machine_description }}</td>
                                <td class="text-right">@{{ line.used_qty }}</td>
                                <td class="text-right">@{{ line.machine_qty }}</td>
                                <td class="text-right">@{{ line.max_machine }}</td>
                                <td class="text-right">@{{ line.remaining_qty }}</td>
                                <td class="text-center">@{{ line.oprn_desc }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}