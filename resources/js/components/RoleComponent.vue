<template>
    <div>
        <!-- <h1>xxxx {{ permissionList }}</h1> -->
        <div class="row">
            <div class="col-sm-4 b-r">
                <form role="form">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" placeholder="" v-model="roleName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Module Name </label>
                        <el-select style="width: 100%"
                            size="small"
                            v-model="moduleName"
                            filterable
                            :disabled="roleId != ''"
                            remote
                            clearable
                            @change="getMenus"
                            placeholder=""
                            :loading="loading"
                        >
                            <el-option
                                v-for="module in pModuleList"
                                :key="module"
                                :label="module"
                                :value="module"
                            ></el-option>
                        </el-select>
                    </div>
                </form>
            </div>
            <div class="col-sm-8" v-loading="loading">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th width="20%" class="text-center">
                                Enter | View
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="menu in menus">
                            <tr>
                                <td>
                                    <h3 class="no-margins pb-2">
                                        <strong class="text-navy">{{ menu.menu_title }}</strong>
                                    </h3>
                                </td>
                                <td class="text-center">
                                    <div v-if="menu.children_menus.length == 0">
                                        <template v-for="perm in menu.permissions" >
                                            <el-switch v-model="perm.has_permission" @change="changePerm(perm)"></el-switch> &nbsp;
                                        </template>
                                    </div>
                                </td>
                            </tr>
                            <template v-for="secondMenu in menu.children_menus" >
                            <tr>
                                <td>
                                    <div class="pl-4">
                                        <div class="pb-1">
                                            <i class="fa fa-arrow-circle-o-right text-muted"></i>
                                            {{ secondMenu.program_code }}
                                            {{ secondMenu.menu_title }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div v-if="secondMenu.children_menus.length == 0">
                                        <template v-for="perm in secondMenu.permissions" >
                                            <el-switch v-model="perm.has_permission" @change="changePerm(perm)"></el-switch> &nbsp;
                                        </template>
                                    </div>
                                </td>
                            </tr>
                                <template v-for="thirdMenu in secondMenu.children_menus" >
                                <tr>
                                    <td>
                                        <div class="pl-4 ml-4">
                                            <div class="pb-1">
                                                <i class="fa fa-arrow-circle-o-right text-muted"></i>
                                                {{ thirdMenu.program_code }}
                                                {{ thirdMenu.menu_title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <template v-for="perm in thirdMenu.permissions" >
                                            <el-switch v-model="perm.has_permission" @change="changePerm(perm)"></el-switch> &nbsp;
                                        </template>
                                    </td>
                                </tr>
                                </template>
                            </template>
                        </template>
                    </tbody>
                </table>
            </div>


            <div class="col-12 mt-3">
                <hr>
                <div class="row clearfix m-t-lg text-right">
                    <div class="col-sm-12">
                        <button class="btn btn-sm btn-primary" type="button"  @click="save"> Save </button>
                        <a :href="pRoleRoute" type="button" class="btn btn-sm btn-white"> Cancel </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        props: [
            "pModuleList",
            "pRole",
            "pMenuByModuleRoute",
            "pPermissionRoute",
            "pAssignPermissionRoute",
            "pRoleRoute",
            "pRoleStoreRoute",
            "pRoleUpdateRoute"
        ],
        data() {
            return {
                roleId: (this.pRole != undefined && this.pRole != '') ? parseInt(this.pRole.role_id) : '',
                roleName: (this.pRole != undefined && this.pRole != '') ?  this.pRole.name : '',
                // moduleName: (this.pModuleName != undefined && this.pModuleName != '') ? parseInt(this.pModuleName) : '',
                moduleName: (this.pRole != undefined && this.pRole != '') ?  this.pRole.module_name : '',
                loading: false,
                menus: [],
                disabled: this.pDisabled ? true : false,
                roleHasPermisions: [],
                permissionList: {},
            };
        },
        mounted() {
            if (this.roleId !== "") {
                this.getRoleHasPermision();
            } else {
                this.roleHasPermisions = [];
            }
        },
        methods: {
            async getMenus() {
                this.permissionList = {};
                if (this.moduleName) {
                    this.loading = true;
                    await axios.get(this.pMenuByModuleRoute + "?module="+this.moduleName)
                        .then(res => {
                            let response = res.data
                            let menusData = response.data;

                            for (const index in menusData) {
                                this.loopPerm(menusData[index].permissions);
                                let secondMenu = menusData[index].children_menus;

                                for (const index2 in secondMenu) {
                                    this.loopPerm(secondMenu[index2].permissions);

                                    let thirdMenu = secondMenu[index2].children_menus
                                    for (const index3 in thirdMenu) {
                                        this.loopPerm(thirdMenu[index3].permissions);
                                    }
                                }
                            }

                            this.menus = menusData;
                            this.loading = false;
                        });
                } else {
                    this.menus = [];
                }
            },
            async getRoleHasPermision() {
                await axios.get(this.pPermissionRoute + "?role_id="+ this.roleId)
                    .then(res => {
                        let response = res.data
                        this.roleHasPermisions = response.data;
                        this.getMenus();
                    });
            },
            async loopPerm(permissions) {
                if (permissions.length == 0) {
                    return;
                }
                for (const index in permissions) {
                    this.checkHasPerm(permissions[index]);
                }
            },
            async checkHasPerm(permission) {
                if (permission.has_permission != undefined) {
                    return;
                }
                let hasPermission = false;
                if (this.roleHasPermisions.length > 0) {

                    let data = await this.roleHasPermisions.filter( o  => {
                        return o.name === permission.name;
                    });
                    if (data.length > 0) {
                        hasPermission = true;
                    } else {
                        hasPermission = false;
                    }

                } else {
                    hasPermission = false;
                }

                this.$set(permission, 'has_permission', hasPermission);
            },
            async changePerm(permission) {

                if (this.roleId == '') {
                    if (permission.has_permission) {
                        this.permissionList[permission.permission_id] = permission;
                    } else {
                        delete this.permissionList[permission.permission_id];
                    }
                    return;
                }

                // let url = this.pAssignPermissionRoute.replaceAll('xxx', this.roleId);
                let url = this.pAssignPermissionRoute;
                await axios.post(url, {
                    permission_id: permission.permission_id,
                    is_checked: permission.has_permission
                })
                .then(res => {
                    if (res.data.data.status != 'S') {
                        this.$set(permission, 'has_permission', !permission.has_permission);
                    }
                });
            },
            async save() {
                if (this.roleId == "") {
                    await axios.post(this.pRoleStoreRoute, {
                        role_name: this.roleName,
                        module_name: this.moduleName,
                        permission_list: this.permissionList
                    })
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            location.href = this.pRoleRoute;
                        }
                    });
                } else {
                    await axios.patch(this.pRoleUpdateRoute, {
                        role_name: this.roleName,
                    })
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            location.href = this.pRoleRoute;
                        }
                    });
                }
            }
        }
    }
</script>
