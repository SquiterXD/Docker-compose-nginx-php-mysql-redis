<template>
    <div v-loading="loading.page">
        <!-- <div class="row">
            <div class="col-12 text-right">
                <button  :class="transBtn.create.class + ' btn-sm tw-w-25 mb-0 btn-outline'"
                    @click.prevent="addNewLine">
                    <i :class="transBtn.create.icon"></i>
                    เพิ่มรายการ
                </button>
            </div>
        </div> -->
        <div class="row">
            <div class="col-5 b-r">
                <h3 class="no-margins text-center text-navy">
                    รายการบุหรี่

                    <template v-if="header">
                        <button  v-if="header.can.cigarettes.multi_cigarettes" :class="transBtn.create.class + ' btn-sm tw-w-25 mb-0 btn-outline pull-right'"
                            :disabled="!header.can.edit"
                            @click.prevent="addNewLine">
                            <i :class="transBtn.create.icon"></i>
                            เพิ่มรายการ
                        </button>
                    </template>
                </h3>
                <div class="table-responsivex">
                    <table  class="table mt-3  table-hover" style="margin-bottom: 0px;">
                        <thead>
                            <tr class="pdp0008-table-th-detail-color">
                                <th width="20px;">
                                </th>
                                <th width="200px;">
                                    <div>รหัสบุหรี่</div>
                                </th>
                                <th width="" class="hidden-sm hidden-xs">
                                    <div>รายละเอียด</div>
                                </th>
                                <th width="130px;" class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody id="accordion">
                            <template v-for="(line, i) in lines" v-if="lines.length" >
                            <transition
                                enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOutDown">
                                <tr  :data="i" v-if="!line.is_deleted" :key="i">
                                    <td class="text-center align-middle">
                                        <i v-if="selectLineId == line.fm_cigar_id" class="fa fa-check-circle text-success"></i>
                                    </td>
                                    <td @click.prevent="showLineDetail(line)" :class="(selectLineId == line.fm_cigar_id) ? '  ':' '">
                                        <el-select
                                            v-model="line.cigar_item_id"
                                            filterable
                                            :ref="line.fm_cigar_id"
                                            remote
                                            placeholder=""
                                            :remote-method="data => remoteMethod(data, line, 'cigar_list')"
                                            @change="selectCigarItemId(line)"
                                            :disabled="!header.can.edit"
                                            :loading="line.loading"  >
                                            <el-option
                                                v-for="(leaf, index) in line.cigar_list"
                                                :key="leaf.value"
                                                :label="leaf.label"
                                                :value="String(leaf.value)"
                                            ></el-option>
                                        </el-select>
                                    </td>
                                    <td @click.prevent="showLineDetail(line)" :class="(selectLineId == line.fm_cigar_id) ? '  ':' '">
                                       {{ line.cigar_item_desc }}
                                    </td>
                                    <td class="text-right align-middle">
                                        <button  :class="transBtn.delete.class + ' btn-xs mb-0 btn-outline'"
                                            :disabled="!header.can.edit"
                                            @click.prevent="deleteCigarItem(line)">
                                            <!-- @click.prevent="line.is_deleted = true"> -->
                                            <i :class="transBtn.delete.icon"></i>
                                        </button>
                                        <button  :class="transBtn.detail.class + ' btn-xs mb-0 btn-outline'"
                                            :disabled="!header.can.edit"
                                            @click.prevent="showLineDetail(line)">
                                            <i :class="transBtn.detail.icon"></i>
                                            {{ transBtn.detail.text }}
                                        </button>
                                    </td>
                                </tr>
                            </transition>
                            </template>
                        </tbody>
                    </table>
                    <div class="text-center" v-if="lines.length === 0">
                        <span class="lead">No Data.</span>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <h3 class="no-margins text-center text-navy">
                    รายการวัตถุห่อมวน

                    <template v-if="header && selectLineId">
                        <button  v-if="header.can.cigarettes.multi_cigarettes" :class="transBtn.create.class + ' btn-sm tw-w-25 mb-0 btn-outline pull-right'"
                            :disabled="!header.can.edit"
                            @click.prevent="addNewDtlLine">
                            <i :class="transBtn.create.icon"></i>
                            เพิ่มรายการ
                        </button>
                    </template>
                </h3>
                <div class="table-responsivex">

                    <table  class="table mt-3" style="margin-bottom: 0px;">
                        <thead>
                            <tr class="pdp0008-table-th-detail-color">
                                <th width="10%">
                                    <div>ลำดับ</div>
                                </th>
                                <th width="" class="hidden-sm hidden-xs">
                                    <div>รายละเอียดวัตถุห่อมวน</div>
                                </th>
                                <th width="10%" class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody id="accordion">
                            <template v-for="(cigarDtl, key, idx) in filterCigarDetail(selectLineId)" v-if="filterCigarDetail(selectLineId).length" >
                            <transition
                                enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOutDown">
                                <tr style="background-color: rgb(252, 252, 252);" :data="key" :key="key" v-if="!cigarDtl.is_deleted">
                                    <td class="text-center">{{ cigarDtl.cigar_line_no}}</td>
                                    <td>
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="cigarDtl.cigar_description" rows="1" maxlength="240" show-word-limit />
                                    </td>
                                    <td class="text-right align-middle">
                                        <button  :class="transBtn.delete.class + ' btn-xs mb-0 btn-outline'"
                                            :disabled="!header.can.edit"
                                            @click="delDtlLine(cigarDtl)">
                                            <i :class="transBtn.delete.icon"></i>
                                        </button>
                                    </td>
                                </tr>
                            </transition>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import uuidv1 from 'uuid/v1';
export default {
    // components: {
    //     LeafIngredient
    // },
    props:[
        "header", 'url', 'transBtn', 'transDate', 'data', 'cigarettes', 'cigarDtl', "tabs"
    ],
    computed: {
        // totalProportion: function () {
        //     let total =  _.sumBy(this.lines, function(o) { return parseInt(o.leaf_proportion); });
        //     return parseFloat(total);
        // }
    },
    watch:{
        cigarettes : async function (value, oldValue) {
            let vm = this;
            vm.lines = value;
        },
        cigarDtl : async function (value, oldValue) {
            let vm = this;
            vm.lineCigarDtl = value;
        },
    },
    data() {
        return {
            loading: {
                page: false,
                leaf_formula: false,
            },
            lines: [],
            lineCigarDtl: [],
            lineCigarDtlByItem: [],
            tab: this.tabs,
            selectLineId: '',
        }
    },
    mounted() {
        console.log('Cigarettes: Component mounted.')
    },
    methods: {
        async addNewDtlLine() {
            // let vm = this;
            // if (vm.lineCigarDtl[vm.selectLineId] == undefined) {
            //     vm.$set(vm.lineCigarDtl, vm.selectLineId, {});
            // }

            // let row = vm.lineCigarDtl[vm.selectLineId].length;
            // let newLine = await _.clone(vm.data.new_dtl_line);
            // // vm.$set(vm.lineCigarDtl, row, newLine);
            // vm.$set(vm.lineCigarDtl[vm.selectLineId], row, newLine);


            // vm.setHasChange();
            // vm.$set(vm.tab.cigarettes, 'has_change', vm.lineCigarDtl.length);
            // vm.resetLineNoDtlLine();

            let vm = this;
            let row = vm.lineCigarDtl.length;
            let newLine = await _.clone(vm.data.new_dtl_line);
                newLine.fm_cigar_id = vm.selectLineId;
                vm.$set(vm.lineCigarDtl, row, newLine);

            vm.setHasChange();
            vm.$set(vm.tab.cigarettes, 'has_change', vm.lineCigarDtl.length);
            vm.resetLineNoDtlLine();
        },
        async delDtlLine(lineCigarDtl) {
            lineCigarDtl.is_deleted = true;
            this.resetLineNoDtlLine();
        },
        async showLineDetail(line) {
            this.selectLineId = line.fm_cigar_id;
        },
        async resetLineNoDtlLine() {
            let vm = this;
            let lineNum = 1;
            let filterCigarDetailData = await vm.filterCigarDetail(vm.selectLineId);
            let maxLine = await _.maxBy(filterCigarDetailData, async function(o) {
                if (o.is_deleted == false) {
                    return o.cigar_line_no;
                }
            });

            lineNum = maxLine.cigar_line_no ? parseInt(maxLine.cigar_line_no) : 1 ;
            filterCigarDetailData.forEach(async (o, i) => {
                if (o.is_deleted == false) {
                    o.cigar_line_no = lineNum;
                    lineNum = lineNum + 1;
                }
            });
        },
        async addNewLine() {
            let vm = this;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            newLine.fm_cigar_id = uuidv1();
            vm.$set(vm.lines, row, newLine);

            vm.setHasChange();
            vm.$set(vm.tab.cigarettes, 'has_change', vm.lines.length);

            if (vm.header.can.edit) {
                vm.remoteMethod(' ', vm.lines.[row], 'cigar_list');
            }
            vm.showLineDetail(newLine)

            vm.$nextTick(() => {
                const input = vm.$refs[newLine.fm_cigar_id];
                // input[0].focus();
            });
        },
        async deleteCigarItem(line) {
            let vm = this;
            let validate = new Promise(async (resolve, reject) => {
                let filterCigarDetailLines = await vm.filterCigarDetail(vm.selectLineId);
                console.log('xxxx============> '
                    , filterCigarDetailLines, vm.selectLineId)
                if (filterCigarDetailLines.length) {
                    vm.filterCigarDetail(vm.selectLineId).forEach(async (o, i) => {
                        vm.delDtlLine(o)
                    });
                }
                resolve(true)
            });

            let result = await validate;
            line.is_deleted = true
        },
        async selectCigarItemId(line) {
            let vm = this;
            line.cigar_organization_code = '';
            line.cigar_organization_id  = '';
            line.cigar_item_code        = '';
            line.cigar_item_desc        = '';

            // checkDup
            let checkDup = vm.lines.filter(o => {
                return o.cigar_item_id == line.cigar_item_id && o.is_deleted == false;
            });

            if (checkDup.length > 1) {
                line.cigar_item_id = '';
                return;
            }

            let cigarette = line.cigar_list.findIndex(o => o.value == line.cigar_item_id);
                cigarette = line.cigar_list[cigarette];

            if (cigarette) {

                line.cigar_organization_code = cigarette.cigar_organization_code;
                line.cigar_organization_id  = cigarette.cigar_organization_id;
                line.cigar_item_code        = cigarette.cigar_item_code;
                line.cigar_item_desc        = cigarette.cigar_item_desc;
            }
            vm.setHasChange();
        },
        setHasChange() {
            let vm = this;
            vm.checkHasChange = true;
        },
        async remoteMethod(query, row, inputName) {
            let vm = this;
            row[inputName] = [];
            let lines = vm.lines.filter(o => {
                    return o.is_deleted == false;
                });
            let except  = [... new Set(lines.map(o => o.cigar_item_id)) ];

            let line = _.clone(row);
                line.cigar_list = [];
            if (query !== "") {
                this.getData({
                    number: query,
                    header: this.header,
                    line: line,
                    type: inputName,
                    except: except,
                }, row, inputName);
            }
        },
        async getData(params, row, inputName) {
            let vm = this;
            row.loading = true;
            axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data
                row.loading = false;
                row[inputName] = response[inputName];
            });
        },
         filterCigarDetail(fmCigarId) {
            let vm = this;
            let data =  vm.lineCigarDtl.filter(item => item.fm_cigar_id == fmCigarId)
            return data;
        }

    }
}
</script>

<style scoped>

.fruit-table-move {
  transition: transform 1s;
}
</style>