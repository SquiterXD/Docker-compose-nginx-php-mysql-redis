{{-- <div class="ibox">
    <div class="ibox-content">
        <form :action="search_data.search_url" id="searchForm" v-loading="loading">
            <div class="form-group row">
                <label class="col-md-2 col-form-label">รายการบัญชี</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width: 100%"
                        placeholder="รายการบัญชี"
                        clearable
                        filterable
                        v-model="ac_ledger_id"
                        @change="getTableData()">
                        <el-option
                            v-for="header in alls"
                            :key="header.ac_ledger_id"
                            :label="header.seq + ' : ' + header.name"
                            :value="header.ac_ledger_id">
                        </el-option>
                    </el-select>
                </div>
            </div>

            <input type="hidden" name="ac_ledger_id" :value="ac_ledger_id">
        </form>
    </div> --}}

    <div class="ibox-content mt-3">
        <div class="table-responsive mini-scroll-bar" style="max-height: 350px;overflow-x: auto;overflow-y: auto; padding-right: 5px;">
            <table class="table text-nowrap table-bordered  table-hover">
                <thead>
                    <tr>
                        <th>หน่วยงาน</th>
                        <th>ศูนย์ต้นทุน</th>
                        <th>ORG.</th>
                        <th>CAT.</th>
                        <th>กลุ่มผลิตภัณฑ์</th>
                        <th>รหัสบัญชี</th>
                        <th>รหัสบริษัท</th>
                        <th>EVM</th>
                        <th>หน่วยงานงบ</th>
                        <th>รายละเอียดงบ</th>
                        <th>เหตุผลงบ</th>
                        <th>RES1</th>
                        <th>RES2</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailList as $line)
                        <tr>
                            <td>{{ $line->department ? $line->department :'' }}</td>
                            <td>{{ $line->code_segment4 ? $line->code_segment4 + ' : ' + $line->segment4_desc : '' }}</td>
                            <td>{{ $line->organization_code ? $line->organization_code : '' }}</td>
                            <td>{{ $line->tobacco_group_code ? $line->tobacco_group_code + ' : ' + $line->tobacco_group : '' }}</td>
                            <td>{{ $line->product_group ? $line->product_group + ' : ' + $line->product_group_desc : '' }}</td>
                            <td>{{ $line->code_segment9 ? $line->code_segment9 + ' : ' + $line->segment9_desc : '' }}</td>
                            <td>{{ $line->code_segment1 ? $line->code_segment1 + ' : ' + $line->segment1_desc : '' }}</td>
                            <td>{{ $line->code_segment2 ? $line->code_segment2 + ' : ' + $line->segment2_desc : '' }}</td>
                            <td>{{ $line->code_segment3 ? $line->code_segment3 + ' : ' + $line->segment3_desc : '' }}</td>
                            <td>{{ $line->code_segment7 ? $line->code_segment7 + ' : ' + $line->segment7_desc : '' }}</td>
                            <td>{{ $line->code_segment8 ? $line->code_segment8 + ' : ' + $line->segment8_desc : '' }}</td>
                            <td>{{ $line->code_segment11 ? $line->code_segment11 + ' : ' + $line->segment11_desc : '' }}</td>
                            <td>{{ $line->code_segment12 ? $line->code_segment12 + ' : ' + $line->segment12_desc : '' }}</td>
                            <td>
                                {{-- <a  type="button" :href="`/ct/account_code_ledger/${line.ac_ledger_detail_id}/edit`" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                    {{-- <tr v-for="line in DataLists">
                        <td>@{{ line.department ? line.department :'' }}</td>
                        <td>@{{ line.code_segment4 ? line.code_segment4 + ' : ' + line.segment4_desc : '' }}</td>
                        <td>@{{ line.organization_code ? line.organization_code : '' }}</td>
                        <td>@{{ line.tobacco_group_code ? line.tobacco_group_code + ' : ' + line.tobacco_group : '' }}</td>
                        <td>@{{ line.product_group ? line.product_group + ' : ' + line.product_group_desc : '' }}</td>
                        <td>@{{ line.code_segment9 ? line.code_segment9 + ' : ' + line.segment9_desc : '' }}</td>
                        <td>@{{ line.code_segment1 ? line.code_segment1 + ' : ' + line.segment1_desc : '' }}</td>
                        <td>@{{ line.code_segment2 ? line.code_segment2 + ' : ' + line.segment2_desc : '' }}</td>
                        <td>@{{ line.code_segment3 ? line.code_segment3 + ' : ' + line.segment3_desc : '' }}</td>
                        <td>@{{ line.code_segment7 ? line.code_segment7 + ' : ' + line.segment7_desc : '' }}</td>
                        <td>@{{ line.code_segment8 ? line.code_segment8 + ' : ' + line.segment8_desc : '' }}</td>
                        <td>@{{ line.code_segment11 ? line.code_segment11 + ' : ' + line.segment11_desc : '' }}</td>
                        <td>@{{ line.code_segment12 ? line.code_segment12 + ' : ' + line.segment12_desc : '' }}</td>
                        <td>
                            <a  type="button" :href="`/ct/account_code_ledger/${line.ac_ledger_detail_id}/edit`" class="btn btn-warning btn-xs">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                            </a>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>