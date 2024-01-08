<div>
    <div class="row">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Program Code </strong> </div>
            <el-input v-if="programInfo.program_code" name="name" :value="name" placeholder="Program Code" v-model="name" size="medium" autocomplete="off" readonly></el-input>
            <el-input v-else name="name" :value="name" placeholder="Program Code" v-model="name" size="medium" autocomplete="off"></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-3 mt-2">
            <div class="control-label mb-2"> <strong> Program Type </strong> <span class="text-danger">*</span></div>
            <input type="hidden" name="program_type" :value="programType">
            <el-select v-model="programType" clearable size="medium" placeholder="Program Type" filterable remote style="width: 100%;">
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

    <div class="row  mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Module </strong> <span class="text-danger">*</span></div>
            <input type="hidden" name="module" :value="module">
            <el-select v-model="module" clearable size="medium" placeholder="Module" filterable remote style="width: 100%;" @change="chooseModule()">
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

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Schema </strong> <span class="text-danger">*</span></div>
            <el-input name="schema" :value="schema" placeholder="Schema" v-model="schema" size="medium" autocomplete="off" readonly></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"> <strong> Source Type </strong> </div>
            <input type="hidden" name="source_type" :value="sourceType">
            <el-select v-model="sourceType" clearable size="medium" placeholder="Source Type" filterable remote style="width: 100%;">
                <el-option
                    v-for="(sourceType, index) in sourceTypeLists"
                    :key="index"
                    :label="sourceType"
                    :value="sourceType"
                >
                </el-option>
            </el-select>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Source Name </strong> </div>
            <el-input name="source_name" :value="sourceName" placeholder="Source Name" v-model="sourceName" size="medium" autocomplete="off"></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Description </strong> </div>
            <el-input type="textarea" :rows="4" name="description" :value="description" placeholder="Description" v-model="description" autocomplete="off"> </el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Archive Directory </strong> </div>
            <el-input name="archive_directory" :value="archiveDirectory" placeholder="Archive Directorye" v-model="archiveDirectory" size="medium" autocomplete="off"></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Output Directory </strong> </div>
            <el-input name="output_directory" :value="outputDirectory" placeholder="Output Directory" v-model="outputDirectory" size="medium" autocomplete="off"></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Error Directory </strong> </div>
            <el-input name="error_directory" :value="errorDirectory" placeholder="Error Directory" v-model="errorDirectory" size="medium" autocomplete="off"></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Log Directory </strong> </div>
            <el-input name="log_directory" :value="logDirectory" placeholder="Log Directory" v-model="logDirectory" size="medium" autocomplete="off"></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="col-form-label mt-2"><strong> Action </strong>
                <label class="i-checks ml-3">
                    <input type="checkbox" name="insert" v-model="insertFlag"> <span class="tw-font-bold" style="color: #669825;"> Insert </span>
                </label>
                <label class="i-checks ml-3">
                    <input type="checkbox" name="update" v-model="updateFlag"> <span class="text-warning tw-font-bold"> Update </span>
                </label>
                <label class="i-checks ml-3">
                    <input type="checkbox" name="delete" v-model="deleteFlag"><span class="text-danger tw-font-bold"> Delete </span>
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="col-form-label mt-2"><strong> Active </strong>
                <label class="i-checks ml-3">
                    <input type="checkbox" name="enable" v-model="enableFlag">
                </label>
            </div>
        </div>
    </div>
</div>