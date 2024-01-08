<form action="" method="GET" autocomplete="off">
    <div class="row">
        <div class="col-sm-4 el_select padding_12">
            <label> Document Code </label>
            <input type="hidden" name="running_code" :value="running_code" autocomplete="off">
            <el-select  v-model="running_code"
                        filterable
                        remote
                        >
                <el-option  v-for="header in headers"
                            :key="header.doc_seq_code"
                            :label="header.doc_seq_code + ' : ' + header.doc_seq_description"
                            :value="header.doc_seq_code">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-4 el_select padding_12">
            <label> ระบบงาน </label>
            <input type="hidden" name="system_module" :value="system_module" autocomplete="off">
            <el-select  v-model="system_module">
                <el-option  v-for="systemModule in modules"
                            :key="systemModule.lookup_code"
                            :label="systemModule.description"
                            :value="systemModule.lookup_code">
                </el-option>
            </el-select>
        </div>

        <div class="col-sm-4 padding_12 margin_auto">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-Search"></i> ค้นหา
            </button>
            <a href="{{ $actionUrl }}" class="btn btn-danger btn-sm">Clear</a>
            {{-- <button type="button" class="btn btn-success" @click="search()">Search</button> --}}
            {{-- <button type="button" class="btn btn-danger" @click="clear()">Clear</button> --}}
        </div>
    </div>
</form>