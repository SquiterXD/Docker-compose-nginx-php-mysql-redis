<div class="ibox float-e-margins collapse {{ (Request::get('search'))? 'show' : ''  }}  mb-2" id="search_form">
    <div class="ibox-content tw-bg-blue-100 tw-border-b">
        <div class="card tw-bg-blue-100" >
            <div class="card-body" >
                <form class="" action="{{ $actionUrl }}">
                    <div class="row">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class="tw-font-bold tw-uppercase mb-0" for="search[request_number]"> Program :</label>
                            <div class="input-group ">
                                <el-input name="search[program]" :value="program" placeholder="โปรแกรม" v-model="program" size="small"></el-input>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Program Type :</label>
                            <div class="">
                                <input type="hidden" name="search[program_type]" :value="programType">
                                <el-select v-model="programType"clearable size="small" placeholder="ชนิดโปรแกรม" filterable remote clearable>
                                    <el-option
                                       v-for="(type, index) in types"
                                        :key="index"
                                        :label="type.program_type_name"
                                        :value="type.program_type_name"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Module :</label>
                            <div class="">
                                <input type="hidden" name="search[module]" :value="module">
                                <el-select v-model="module" clearable size="small" placeholder="โมดูล" filterable remote >
                                    <el-option
                                       v-for="(module, index) in moduleLists"
                                        :key="index"
                                        :label="module"
                                        :value="module"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Status :</label>
                            <div class="">
                                <input type="hidden" name="search[status]" :value="status">
                                <el-select v-model="status" clearable size="small" placeholder="สถานะ" filterable remote>
                                    <el-option
                                       v-for="(status, index) in statusLists"
                                        :key="index"
                                        :label="status"
                                        :value="index"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-0" >Creation Date :</label>
                            <div class=" ">
                                <el-date-picker
                                    @change="chooseStartDate"
                                    name="search[start_date]"
                                    :value="startDate"
                                    v-model="startDate"
                                    type="date"
                                    format="{{ trans('date.vue-format') }}"
                                    value-format="{{ trans('date.vue-format') }}"
                                    placeholder="Start Date"
                                    size="small"
                                    filterable style="width: 155px;">
                                </el-date-picker>
                                <el-date-picker
                                    @change="checkEndDate"
                                    name="search[end_date]"
                                    :value="endDate"
                                    v-model="endDate"
                                    type="date"
                                    format="{{ trans('date.vue-format') }}"
                                    value-format="{{ trans('date.vue-format') }}"
                                    placeholder="End Date"
                                    size="small"
                                    filterable style="width: 155px;">
                                </el-date-picker>
                            </div>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-4 col-sm-6 col-xs-6">
                            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                            <div class="text-right">
                                <a href="{{ $actionUrl }}" class="btn btn-sm">Clear</a>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>