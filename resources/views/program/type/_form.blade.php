<div>
    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Program Type Name </strong> <span class="text-danger">*</span></div>
            <el-input name="name" :value="name" placeholder="Name" v-model="name" size="small" autocomplete="off" required></el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> User Program Type </strong> <span class="text-danger">*</span></div>
            <el-input name="user_type" :value="userType" placeholder="User Program Type" v-model="userType" size="small" autocomplete="off" required></el-input>
            <div style="color: #a7a7a7;"> <u>Example:</u> View Only, Setup </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"><strong> Description </strong> <span class="text-danger">*</span></div>
            <el-input type="textarea" :rows="4" name="description" :value="description" placeholder="Description" v-model="description" autocomplete="off"> </el-input>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="control-label mb-2"> <strong> Program Type </strong> <span class="text-danger">*</span></div>
            <input type="hidden" name="program_type" :value="type">
            <el-select v-model="type" size="small" clearable size="medium" placeholder="Program Type" filterable remote style="width: 247px;">
                <el-option
                    v-for="(typeList, index) in typeLists"
                    :key="index"
                    :label="typeList"
                    :value="index"
                >
                </el-option>
            </el-select>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
            <div class="col-form-label mt-2"><strong> Active </strong>
                {{-- <span class="ml-2"> <input name="enable" class="icheck" type="checkbox" checked="true"> </span> --}}
                <label class="i-checks ml-3">
                    <input type="checkbox" name="enable" v-model="enableFlag">
                </label>
            </div>
        </div>
    </div>
</div>
