<template>
    <div>
        <div class="row">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"><strong> Username </strong> <span class="text-danger">*</span></div>

                <el-select
                  style="width: 100%"
                  v-model="username"
                  :disabled="pUser != ''"
                  filterable
                  clearable
                  remote
                  @change="setUser"
                  placeholder="ชื่อ หรือ นามสกุล"
                  :remote-method="remoteMethod"
                  :loading="loading"
                >
                  <el-option
                    v-for="user in users"
                    :key="user.lable"
                    :label="user.lable"
                    :value="user.username"
                  ></el-option>
                </el-select>
            </div>
        </div>

        <div class="row">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"><strong> Email </strong></div>
                <input  placeholder="Email" 
                        autocomplete="off" 
                        v-model="email" 
                        type="text" 
                        class="form-control col-12"
                        disabled>
            </div>
        </div>

        <transition
            enter-active-class="animated fadeInUp"
            leave-active-class="animated fadeOutDown">
            <div class="row " v-if="user != null">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 offset-md-3 mt-2">
                    <div class="control-label">
                        <strong>HR: First Name </strong>
                    </div>
                    <p class="text-muted pl-3 mb-0">
                        <strong> {{ user.first_name }} </strong>
                    </p>
                </div>

                <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                    <div class="control-label ">
                        <strong>HR: Last Name </strong>
                    </div>
                    <p class="text-muted pl-3 mb-0">
                        <strong> {{ user.last_name }} </strong>
                    </p>
                </div>

                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6  offset-md-3 mt-2">
                    <div class="control-label ">
                        <strong>HR: Department Code </strong>
                    </div>
                    <p class="text-muted pl-3 mb-0">
                        <strong> {{ user.dept_code_account }} </strong>
                    </p>
                    <div v-if="pUser != '' && (user.dept_code_account != pUser.department_code)" class="mt-2">
                        <button type="button" class="btn btn-w-m btn-primary" @click="save">
                            อัพเดท Department Code
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <div class="row ">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="hr-line-dashed"></div>
            </div>
        </div>

        <div class="row ">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 text-right">
                <button type="button" class="btn btn-w-m btn-primary" @click="addAssignDeptList">
                    <i class="fa fa-plus"></i> Add Dept.
                </button>
            </div>
        </div>

        <div class="row " v-for="(assign, index) in assignDeptList">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 offset-md-3 mt-2">
                <div class="control-label">
                    <strong> Department Code </strong>
                </div>
                <el-select
                  style="width: 100%"
                  v-model="assign.department_code"
                  filterable
                  clearable
                  remote
                  placeholder="Department Code"
                  :remote-method="data => remoteMethodDept(data,index)"
                  :loading="loading"
                >
                  <el-option
                    v-for="dept in assign.department_list"
                    :key="dept.description"
                    :label="dept.description"
                    :value="dept.department_code"
                  ></el-option>
                </el-select>
            </div>

            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                <div class="control-label ">
                    <strong> End Date </strong>
                </div>
                <el-date-picker
                  style="width: 100%"
                  v-model="assign.end_date"
                  type="date"
                  placeholder="Pick a day">
                </el-date-picker>
            </div>
            <div class="form-group text-left pl-12 pr-2 mb-0 col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2">
                <div class="control-label mb-2">
                    &nbsp;
                </div>
                <a  @click="delAssignDeptList(index)" style="cursor: pointer;">
                    <i class="fa fa-times-circle fa-2x text-danger"></i>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"><strong> OA User </strong> <span class="text-danger">*</span></div>

                <el-select
                  style="width: 100%"
                  v-model="oaUserId"
                  filterable
                  clearable
                  remote
                  placeholder=""
                  :remote-method="remoteMethodOAUser"
                  :loading="loading"
                >
                  <el-option
                    v-for="oaUser in oaUserList"
                    :key="oaUser.user_name"
                    :label="oaUser.user_name"
                    :value="oaUser.user_id"
                  ></el-option>
                </el-select>
            </div>

            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-6 col-sm-6 col-xs-6  mt-2">
                <div class="control-label mb-2"><strong> Organization Control </strong> </div>
                <el-select
                  style="width: 100%"
                  v-model="orgId"
                  filterable
                  clearable
                  placeholder=""
                >
                  <el-option
                    v-for="(org, i) in pOrgList"
                    :key="i"
                    :label="org"
                    :value="i"
                  ></el-option>
                </el-select>
            </div>
        </div>

        <div class="row">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"><strong> Role </strong> <span class="text-danger">*</span></div>

                <el-select
                  style="width: 100%"
                  v-model="roleList"
                  multiple
                  filterable
                  clearable
                  remote
                  placeholder=""
                >
                  <el-option
                    v-for="(role, index) in pRoleList"
                    :key="role"
                    :label="role"
                    :value="index"
                  ></el-option>
                </el-select>
            </div>
        </div>

        <div class="row">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"><strong>Assign Org</strong></div>

                <el-select
                  style="width: 100%"
                  v-model="invOrgOptions"
                  multiple
                  filterable
                  clearable
                  remote
                  placeholder=""
                >
                  <el-option
                    v-for="(org, i) in pOrgList"
                    :key="i"
                    :label="org"
                    :value="i"
                  ></el-option>
                </el-select>
            </div>
        </div>

        <div class="col-12 mt-3">
            <hr>
            <div class="row clearfix m-t-lg text-right">
                <div class="col-sm-12">
                    <button class="btn btn-sm btn-primary" type="button"  @click="save"> Save </button>
                    <a :href="pRouteList.users_index" type="button" class="btn btn-sm btn-white"> Cancel </a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>


    export default {
        props: [
            "pUser",
            "pRouteList",
            "pRoleList",
            "pOrgList"
        ],
        data() {
            return {
                user: null,
                email: null,
                oaUserId: (this.pUser != undefined && this.pUser != '') ? parseInt(this.pUser.fnd_user_id) : '',

                loading: false,
                username: (this.pUser != undefined && this.pUser != '') ? this.pUser.username : '',
                orgId: (this.pUser != undefined && this.pUser != '') ? this.pUser.organization_id : '',
                users: [],
                oaUserList: [],
                roleList: (this.pUser != undefined && this.pUser != '') ? this.pUser.role_options : '',
                invOrgOptions: [],

                assignDeptList: {},

            };
        },
        mounted() {
            // this.addRow();
            // this.addAssignDeptList();
            // if (this.roleId !== "") {
            //     this.getRoleHasPermision();
            // } else {
            //     this.roleHasPermisions = [];
            // }

            if (this.username != '') {
                this.getUsers({ username: this.username});
            }

            if (this.oaUserId != '') {
                this.getOAUser({ user_id: this.oaUserId});
            }

            if (this.pUser && this.pUser.department_options.length > 0) {
                this.assignDeptList = this.pUser.department_options;
            }

            if (this.pUser && this.pUser.inv_org_options.length > 0) {
                this.invOrgOptions = this.pUser.inv_org_options;
            }

            if (this.pUser && this.pUser.role_options.length > 0) {
                this.roleList = this.pUser.role_options;
            }
        },
        methods: {
            addAssignDeptList() {
                // let row = Object.keys(this.assignDeptList).length + 1;
                var max = 0;
                for (var property in this.assignDeptList) {
                  max = (max < parseFloat(property)) ? parseFloat(property) : max;
                }

                this.$set(this.assignDeptList, max + 1, {
                    department_list: [],
                    department_code: null,
                    end_date: null,
                });
            },
            delAssignDeptList(index)
            {
                this.$delete(this.assignDeptList, index);
            },


            remoteMethodOAUser(query) {

                if (query !== "") {
                    this.getOAUser({ name: query});
                } else {
                }
            },
            async getOAUser(params) {
                let data = [];
                await axios.get(this.pRouteList.ajax_get_oa_user, { params }).then(res => {
                    data = res.data.data;
                });

                this.oaUserList = data;
            },

            remoteMethodDept(query, index) {
                if (query !== "") {
                    this.getDepartment({ name: query}, index);
                } else {
                    // this.assignDeptList[index].department_list = [];
                }
            },
            async getDepartment(params, index) {
                let data = [];
                await axios.get(this.pRouteList.ajax_get_department, { params }).then(res => {
                    data = res.data.data;
                });

                this.assignDeptList[index].department_list = data;
            },
            remoteMethod(query) {
              if (query !== "") {
                this.getUsers({ name: query});
              } else {
                this.users = [];
              }
            },
            async getUsers(params) {
                this.user = null;
                this.loading = true;
                axios.get(this.pRouteList.ajax_get_user, { params }).then(res => {
                    this.loading = false;
                    this.users = res.data.data;
                    this.setUser();
                });
            },
            async setUser() {
                if (this.username && this.users.length > 0) {
                    let userFilter = this.users.filter(userData => {

                        return userData.username == this.username;
                    });
                    this.user = userFilter[0];
                    this.email = this.user.email;
                } else {
                    this.user = null;
                }
            },
            async save() {
                if (this.pUser == '') {
                    // console.log('url', this.pRouteList.ajax_users_store);
                    await axios.post(this.pRouteList.ajax_users_store, {
                        name: this.user.first_name + ' ' + this.user.last_name,
                        username: this.username,
                        email: this.email,
                        password: this.user.id_card,
                        department_code: this.user.dept_code_account,
                        fnd_user_id: this.oaUserId,
                        role_options: this.roleList,
                        inv_org_options: this.invOrgOptions,
                        department_options: this.assignDeptList,
                        organization_id: this.orgId,
                    })
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            window.location.href = this.pRouteList.users_index;
                        }
                    });
                } else {
                    // console.log('url', this.pRouteList.ajax_users_update);
                    let name = this.pUser.name;
                    let password = '';
                    let departmentCode = this.pUser.department_code;
                    if (this.user) {
                        name = this.user.first_name + ' ' + this.user.last_name;
                        password = this.user.id_card;
                        departmentCode = this.user.dept_code_account;
                    }
                    await axios.patch(this.pRouteList.ajax_users_update, {
                        username: this.username,
                        name: name,
                        email: this.email,
                        password: password,
                        department_code: departmentCode,
                        fnd_user_id: this.oaUserId,
                        role_options: this.roleList,
                        inv_org_options: this.invOrgOptions,
                        department_options: this.assignDeptList,
                        organization_id: this.orgId,
                    })
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            window.location.href = this.pRouteList.users_index;
                        }
                    });
                }
            }
        }
    }
</script>
