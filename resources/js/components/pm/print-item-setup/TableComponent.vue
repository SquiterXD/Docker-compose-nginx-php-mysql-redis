<template>
    <div class="ibox-content">
        <div class="table-responsive">
        <table class="table table-bordered tw-text-xs">
            <thead>
                <tr>
                    <th class="text-center" style="width: 7%;"> สถานะการใช้งาน </th>
                    <th class="text-center" style="width: 19%;"> รหัสสินค้า </th>
                    <th class="text-center" style="width: 10%;"> ขนาดบุหรี่ </th>
                    <th class="text-center" style="width: 12%;"> Brand </th>
                    <th class="text-center" style="width: 12%;"> Brand Color </th>
                    <th class="text-center" style="width: 12%;"> Product </th>
                    <th class="text-center" style="width: 12%;"> Product Color </th>
                    <th class="text-center" style="width: 10%;"> ระบบการพิมพ์ </th>
                    <th class="text-center" style="width: 10%;">  </th>
                </tr>
            </thead>
            <tbody v-if="printItemSetupList.length > 0">
                <template v-for="(printItemSetup, index) in printItemSetupListOrderBy">
                    <tr :key="index" clsss="tw-text-xs">
                        <td class="text-center" style="vertical-align:middle">
                            <div v-if="printItemSetup.enable_flag == 'Y'">
                                <i class="fa fa-check-circle text-success"></i>
                            </div>   
                            <div v-else>
                                <i class="fa fa-circle text-muted"></i>
                            </div> 
                        </td>
                        <td style="vertical-align:middle">{{ printItemSetup.itemNumberV.item_number + ' : ' + printItemSetup.itemNumberV.item_desc }}</td>
                        <td style="vertical-align:middle">
                            <div v-if="printItemSetup.tobacco_size">
                                {{ printItemSetup.lookupValues[0].description }}
                            </div>
                        </td>
                        <td style="vertical-align:middle">{{ printItemSetup.brand }}</td>
                        <td v-bind:style="{backgroundColor: printItemSetup.brand_colors}"></td>
                        <td style="vertical-align:middle">{{ printItemSetup.product }}</td>
                        <td v-bind:style="{backgroundColor: printItemSetup.product_colors}"></td>
                        <td style="vertical-align:middle">{{ printItemSetup.printType[0] ? printItemSetup.printType[0].description : '' }}</td>
                        <td class="text-center" style="vertical-align:middle">
                            <a  type="button" 
                                :href="'/pm/settings/print-item-setup/'+ printItemSetup.pm_print_set_id +'/edit'" 
                                :class="btnTrans.edit.class">
                                <i :class="btnTrans.edit.icon" aria-hidden="true"></i> 
                                {{ btnTrans.edit.text }}
                            </a>
                        </td>
                    </tr>
                </template>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="9">
                        <h2 class="p-1 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "printItemSetupList",
            "btnTrans"
        ],

        computed: {
            printItemSetupListOrderBy: function () {
                return _.orderBy(this.printItemSetupList, 'itemNumberV.item_number')
            }
        },

        mounted() {

        },

        data() {
            return {
                
            };
        },

        methods: {
           
        }
    }
</script>