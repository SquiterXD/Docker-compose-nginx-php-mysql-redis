<div id="detailReportModal" ref="detailReportModalRef" class="modal bd-example-modal-xl fade">
    <div class="modal-dialog modal-xl" role="document">
        {{-- style="max-width: 1350px!important;" --}}
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
                                    <input type="text" class="form-control" v-model="currentPlanDate" disabled="disabled"/>
                                </div>
                            </div>
                        </div>
                        {{-- @php
                            $test = currentDetailPlanDate;
                        @endphp --}}
                        <div class="text-right col-lg-3">
                            <form action="{{ route('pm.ingredient-preparation.print-pdf') }}"  target="_bank">
                                <input type="hidden" name="plan_date" value="currentDetailPlanDate" v-model="currentDetailPlanDate">
                                <input type="hidden" name="item" value="currentDetailItemId" v-model="currentDetailItemId">
                                <button class="btn btn-w-m btn-info" target="_bank"><i class="fa fa-print"></i> พิมพ์รายงาน</button>
                                {{-- <button type="button" class="btn btn-w-m btn-info"><i
                                    class="fa fa-print"></i>
                                    พิมพ์รายงาน
                                </button> --}}
                            </form>
                            {{-- <a href="{{ route('pm.ingredient-preparation.print-pdf', [ 'plan_date' => $test]) }}" class="btn btn-w-m btn-info">
                                <i class="fa fa-print"></i> พิมพ์รายงาน
                            </a> --}}
                            {{-- <router-link :to="{ name: 'Profile', params: { msg } }">
                                Go to your profile
                             </router-link> --}}
                            {{-- <button type="button" class="btn btn-w-m btn-default" data-toggle="modal" data-target="#detailReportModal"
                                @click.prevent="printReport(list)">
                                รายละเอียด
                            </button> --}}
                            {{-- <button type="button" class="btn btn-w-m btn-info" @click.prevent="printReport(list)"><i
                                class="fa fa-print"></i>
                                พิมพ์รายงาน
                            </button> --}}
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
                <div class="table-responsive mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                    <table v-if="!isDetailsLoading" class="table table-bordered">
                        <thead>
                            <tr>
                                <th><div style="width: 180px;">ชุดเครื่องจักร</div></th>
                                <th><div style="width: 100px;">ปริมาณที่ต้องใช้</div></th>
                                {{-- <th><div style="width: 125px;">คงคลังเช้าหน้าเครื่อง</div></th>
                                <th><div style="width: 120px;">วางหน้าเครื่องสูงสุด</div></th>
                                <th><div style="width: 150px;">ปริมาณที่สามารถเบิกได้</div></th> --}}
                                <th><div style="width: 70px;">หน่วยนับ</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="hasM05Data">
                                <tr v-for="line in detailLines">
                                    <td>@{{ line.machine_set + ' : ' + line.machine_description }}</td>
                                    <td class="text-right">@{{ Math.ceil(line.used_qty - calM05).toLocaleString() }}</td>
                                    <td class="text-center">@{{ line.detail_uom_desc }}</td>
                                </tr>
                                <tr>
                                    <th>รวม</th>
                                    <th class="text-right">@{{ Math.ceil(totalUsedQty - bM05).toLocaleString() }}</th>
                                    <th></th>
                                </tr>
                            </template>
                            <template v-if="!hasM05Data">
                                <tr v-for="line in detailLines">
                                    <td>@{{ line.machine_set + ' : ' + line.machine_description }}</td>
                                    <td class="text-right">@{{ Math.ceil(line.used_qty).toLocaleString() }}</td>
                                    {{-- <td class="text-right">@{{ line.machine_qty }}</td>
                                    <td class="text-right">@{{ line.max_machine }}</td>
                                    <td class="text-right">@{{ line.remaining_qty }}</td> --}}
                                    <td class="text-center">@{{ line.detail_uom_desc }}</td>
                                </tr>
                                <tr>
                                    <th>รวม</th>
                                    <th class="text-right">@{{ Math.ceil(totalUsedQty).toLocaleString() }}</th>
                                    {{-- <th class="text-right">@{{ totalMchineQty }}</th>
                                    <th class="text-right">@{{ totalMaxMachine }}</th>
                                    <th class="text-right">@{{ totalRemainingQty }}</th> --}}
                                    <th></th>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>