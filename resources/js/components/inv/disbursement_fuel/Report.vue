<template>
    <div class="container">
        <div class="form-group row">
            <label class="col-md-1 col-form-label">ค้นหา:</label>
            <div class="col-md-8">
                <el-input ></el-input>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-right">Organization:</label>
            <div class="col-md-4">
                <el-select
                    v-model="organization"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getIssueProfileV"
                    :loading="loadingInput.issueProfileV"
                    placeholder="Organization"
                    style="width: 100%"
                >
                    <el-option
                        v-for="item in issue_profile_v"
                        :key="item.organization_code"
                        :label="item.organization_code"
                        :value="item.organization_code"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-right">ระหว่างวันที่:</label>
            <div class="col-md-3">
                <el-date-picker
                    v-model="from_date"
                    type="date"
                    format="dd/MM/yyyy"
                    placeholder="Pick a day">
                </el-date-picker>
            </div>
            <label class="col-form-label">ถึง</label>
            <div class="col ml-3">
                <el-date-picker
                    v-model="to_date"
                    type="date"
                    format="dd/MM/yyyy"
                    placeholder="Pick a day">
                </el-date-picker>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label text-right">ประเภทกลุ่มพนักงาน:</label>
            <div class="col-md-6">               
                <el-select
                    v-model="department_code"
                    filterable
                    placeholder="ประเภทกลุ่มพนักงาน"
                    style="width: 100%"
                >
                    <el-option
                        v-for="item in issue_profile_v"
                        :key="item.department_code"
                        :label="item.department_code"
                        :value="item.department_code"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-2">
                <el-button type="primary">ค้นหา</el-button>
                <el-button class="text-refresh" type="text" @click.native.prevent="refresh()">ล้างข้อมูล</el-button>
            </div>
        </div>

        <el-divider class="mx-3"></el-divider>

        <div class="col-md-3 offset-2 card tw-bg-gray-100">
            <div class="card-header tw-bg-transparent">
                <label class="h4"><strong>รายงาน:</strong></label>
            </div>
            <div class="card-body">
                รายงานยอดการใช้น้ำมันรถยนต์ส่วนกลาง
            </div>
            <div class="col text-right">
                <a href="" class="col-1 tw-text-black"><i class="fa fa-download fa-2x"></i></a>
                <a href="" class="col-1 tw-text-black"><i class="fa fa-repeat fa-2x"></i></a>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .text-refresh {
        color: #ec4958;
    }
</style>

<script>
export default {
    data() {
        return {
            issue_profile_v: [],

            organization: "",
            from_date: "",
            to_date: "",
            department_code: "",

            loadingInput: {
                issueProfileV: false
            },
            loading: false
        }
    },

    created() {
        this.getMasterData();
    },

    methods: {
        getMasterData() {
            this.getIssueProfileV();
        },
        getIssueProfileV(query) {
            this.loadingInput.issueProfileV = true;
            axios
                .get("/inv/ajax/issue_profile_V", { params: { text: query } })
                .then((response) => {
                    this.issue_profile_v = response.data;
                })
                .catch((err) => {
                    console.log("error get issue profile")
                })
                .then(() => {
                    this.loadingInput.issueProfileV = false;
                });
        },
        refresh() {
            this.organization = "";
            this.from_date = "";
            this.to_date = "";
            this.department_code = "";
        },
    },
}
</script>