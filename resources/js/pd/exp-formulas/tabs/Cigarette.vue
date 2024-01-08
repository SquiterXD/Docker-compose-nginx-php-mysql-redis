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
            <div class="col-7 b-r">
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
                    <table  class="table" style="margin-bottom: 0px;">
                        <thead>
                            <tr>
                                <th width="40%">
                                    <div>รหัสบุหรี่</div>
                                </th>
                                <th width="" class="hidden-sm hidden-xs">
                                    <div>รายละเอียด</div>
                                </th>
                                <th width="10%" class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody id="accordion">
                            <template v-for="(line, i) in lines" v-if="lines.length" >
                            <transition
                                enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOutDown">
                                <tr style="background-color: rgb(252, 252, 252);" :data="i" v-if="!line.is_deleted" :key="i">
                                    <td>
                                        <el-select
                                            v-model="line.cigar_item_id"
                                            filterable
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
                                    <td>
                                        {{ line.cigar_item_desc }}
                                    </td>
                                    <td class="text-right align-middle">
                                        <button  :class="transBtn.delete.class + ' btn-xs mb-0 btn-outline'"
                                            :disabled="!header.can.edit"
                                            @click.prevent="line.is_deleted = true">
                                            <i :class="transBtn.delete.icon"></i>
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
            <div class="col-5">
                <h3 class="no-margins text-center text-navy">
                    รายการวัตถุห่อมวน
                </h3>
                <div class="table-responsivex">
                    <table  class="table" style="margin-bottom: 0px;">
                        <thead>
                            <tr>
                                <th width="10%">
                                    <div>ลำดับ</div>
                                </th>
                                <th width="" class="hidden-sm hidden-xs">
                                    <div>รายละเอียดวัตถุห่อมวน</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="accordion">
                            <template v-for="(cigarDtl, key, idx) in lineCigarDtl" v-if="lineCigarDtl.length" >
                            <transition
                                enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOutDown">
                                <tr style="background-color: rgb(252, 252, 252);" :data="key" :key="key">
                                    <td class="text-center">{{ cigarDtl.cigar_line_no = key +1 }}</td>
                                    <td>
                                        <el-input type="textarea" name="note"
                                            :disabled="!header.can.edit"
                                            v-model="cigarDtl.cigar_description" rows="1" maxlength="240" show-word-limit />
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
        // lines:  async function (val, oldVal) {
        //     this.$emit("syncLines", val);
        // }
    },
    data() {
        return {
            loading: {
                page: false,
                leaf_formula: false,
            },
            lines: [],
            lineCigarDtl: [],
            tab: this.tabs
        }
    },
    mounted() {
        console.log('Cigarettes: Component mounted.')
    },
    methods: {
        async addNewLine() {
            let vm = this;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.lines, row, newLine);

            vm.setHasChange();
            vm.$set(vm.tab.casings, 'has_change', vm.lines.length);

            if (vm.header.can.edit) {
                vm.remoteMethod(' ', vm.lines.[row], 'cigar_list');
            }
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
        }
    }
}
</script>

<style scoped>

.fruit-table-move {
  transition: transform 1s;
}
</style>