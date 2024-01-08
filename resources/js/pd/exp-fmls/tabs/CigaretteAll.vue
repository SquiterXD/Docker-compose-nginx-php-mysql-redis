<template>
    <div v-loading="loading.page">
       <div class="table-responsivex">
            <table  class="table" style="margin-bottom: 0px;">
                <thead>
                    <tr class="pdp0008-table-th-detail-color">
                        <th width="5%" class="text-center">
                            <div>กลุ่ม/ประเภท</div>
                        </th>
                        <th width="5%" class="text-center">
                            <div>Leaf FML</div>
                        </th>
                        <th width="15%">
                            <div>รหัสวัตถุดิบ</div>
                        </th>
                        <th width="" class="hidden-sm hidden-xs">
                            <div>รายละเอียด</div>
                        </th>
                        <th width="5%" class="text-right">
                            <div>Lot</div>
                        </th>
                        <th width="10%" class="text-right">
                            <div>ปริมาณที่ใช้</div>
                        </th>


                        <th width="5%" class="text-center">
                            <div>หน่วย</div>
                        </th>
                    </tr>
                </thead>
                <tbody id="accordion">
                    <template v-for="(line, i) in lines" v-if="lines.length" >
                    <transition
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated fadeOutDown">
                        <tr style="background-color: rgb(252, 252, 252);" :data="i" :key="i">
                            <td class="text-center">
                               {{ line.tab }}
                            </td>
                            <td class="text-center">
                               {{ line.leaf_formula }}
                            </td>
                            <td>
                               {{ line.item_number }}
                            </td>
                            <td>
                                {{ line.item_description }}
                            </td>
                            <td class="text-right">
                                {{ line.lot_number }}
                            </td>
                            <td class="text-right">
                                {{ line.qty | numberFormat }}
                            </td>
                            <td class="text-center">
                                {{ line.uom }}
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
</template>

<script>


export default {
    // components: {
    //     LeafIngredient
    // },
    props:[
        // "header", 'url', 'transBtn', 'transDate', 'data', 'cigaretteAll', 'cigarDtl', "tabs"
        "header", 'url', 'transBtn', 'transDate', 'cigaretteAll', "tabs"
    ],
    computed: {
    },
    watch:{
        cigaretteAll : async function (value, oldValue) {
            let vm = this;
            vm.lines = value;
        },
    },
    data() {
        return {
            loading: {
                page: false,
                leaf_formula: false,
            },
            lines: [],
        }
    },
    mounted() {
        console.log('Cigarette All: Component mounted.')
    },
    methods: {
    }
}
</script>

<style scoped>

</style>