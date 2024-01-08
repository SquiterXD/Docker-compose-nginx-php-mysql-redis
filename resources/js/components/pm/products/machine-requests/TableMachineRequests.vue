<template>

    <div>

        <div class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0" style="min-width: 800px;">
                <thead>
                    										
                    <tr>
                        <th class="text-center" style="min-width: 60px;"> ลำดับที่ </th>
                        <!-- <th class="text-center" style="min-width: 140px;"> ประเภทสิ่งพิมพ์ </th>
                        <th class="text-center" style="min-width: 140px;"> ตราบุหรี่ </th>
                        <th class="text-center" style="min-width: 100px;"> รหัสสิ่งพิมพ์ </th> -->
                        <!-- <th class="text-center" style="min-width: 140px;"> เครื่องจักร </th> -->
                        <th class="text-center" style="min-width: 100px;"> รหัสวัตถุดิบ </th>
                        <th class="text-center" style="min-width: 300px;"> รายละเอียด </th>
                        <th class="text-center" style="min-width: 100px;"> หน่วยนับ </th>
                        <th class="text-center" style="min-width: 160px;"> จำนวนที่ขอเบิกจากกองซ่อม </th>
                        <th class="text-center" style="min-width: 60px;"> หน่วยเบิก </th>
                        <th class="text-center" style="min-width: 60px;"> </th>
                    </tr>
                </thead>
                <tbody class="yearly-lines" v-if="machineRequestItems.length > 0">

                    <template v-for="(machineRequestItem, index) in machineRequestItems">

                        <tr :key="`${index}`" v-if="!machineRequestItem.marked_as_deleted">
                            
                            <td style="min-width: 60px;" class="scroll-col text-center"> 
                                {{ index+1 }}
                            </td>

                            <!-- <td style="min-width: 140px;" class="scroll-col text-center"> 
                                {{ machineRequestItem.item_category }}
                            </td>

                            <td style="min-width: 140px;" class="scroll-col text-center"> 
                                {{ machineRequestItem.product_item_desc }}
                            </td>

                            <td style="min-width: 100px;" class="scroll-col text-center">  
                                {{ machineRequestItem.product_item_number }}
                            </td> -->

                            <!-- <td style="min-width: 140px;" class="scroll-col text-center"> 
                                {{ machineRequestItem.machine_name }}
                            </td> -->

                            <td style="min-width: 100px;" class="scroll-col text-center">
                                <div v-if="machineRequestItem.is_new_line">
                                    <pm-el-select name="inventory_item_id" 
                                        id="input_inventory_item_id" 
                                        :select-options="itemOptions"
                                        option-key="inventory_item_id"
                                        option-value="inventory_item_id" 
                                        option-label="full_item_desc" 
                                        :value="machineRequestItem.inventory_item_id"
                                        :filterable="true"
                                        @onSelected="onInvItemChanged($event, machineRequestItem)"
                                    />
                                </div>
                                <div v-else>
                                    {{ machineRequestItem.inv_item_number }}
                                </div>
                            </td>

                            <td style="min-width: 300px;" class="scroll-col text-left"> 
                                {{ machineRequestItem.inv_item_desc }}
                            </td>

                            <td style="min-width: 100px;" class="scroll-col text-center"> 
                                {{ machineRequestItem.uom_desc }}
                            </td>

                            <td style="min-width: 160px;" class="scroll-col text-right"> 
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :id="`input_request_qty_${index}`"
                                    style="min-width: 120px;"
                                    class="form-control input-sm text-right"
                                    :name="`request_qty_${index}`"
                                    v-model="machineRequestItem.request_qty"
                                    @change="onRequestQtyChanged(machineRequestItem)"
                                    ></vue-numeric>
                            </td>

                            <td style="min-width: 60px;" class="scroll-col text-center"> 

                                <pm-el-select name="uom2" id="input_uom2" 
                                    :select-options="uomCodes"
                                    option-key="uom_code_value"
                                    option-value="uom_code_value" 
                                    option-label="uom_code_label"
                                    :value="machineRequestItem.uom2"
                                    :filterable="true"
                                    @onSelected="onUOM2Changed($event, machineRequestItem)"
                                />
                                <!-- {{ machineRequestItem.uom2_desc }} -->

                            </td>

                            <td style="min-width: 60px;" class="scroll-col text-center"> 
                                <button v-if="machineRequestItem.is_new_line" 
                                    type="button" 
                                    class="btn btn-sm btn-danger" 
                                    @click="onDeleteItem(machineRequestItem)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>

                        </tr>
                        
                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="9">
                            <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                        </td>
                    </tr>
                </tbody>

            </table>

    
    
        </div>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'

export default {
    
    props: ["requestDateValue", "machineRequests", "itemOptions", "uomCodes"],

    components: {
        VueNumeric
    },

    watch: {
        machineRequests : function (value) {
            this.machineRequestItems = value;
        },
    },

    data() {

        return {

            requestDate: this.requestDateValue,
            machineRequestItems: this.machineRequests.map(item => {
                return {
                    ...item,
                    request_qty: item.request_qty ? item.request_qty : 0,
                    uom2: item.uom2 ? item.uom2 : item.uom,
                    uom_desc : this.getUomCodeDescriptionByCode(this.uomCodes, item.uom),
                    uom2_desc : this.getUomCodeDescriptionByCode(this.uomCodes, item.uom2 ? item.uom2 : item.uom),
                    is_new_line: item.attribute10 == "Y" ? true : false, // attribute10 == 'Y' => is_new_line == true
                    marked_as_deleted: false,
                }
            }),

        }

    },

    mounted() {
        this.emitMachineRequestChanged();
    },

    computed: {

    },
    methods: {

        onRequestQtyChanged(machineRequestItem) {
            this.emitMachineRequestChanged();
        },

        onUOM2Changed(value, machineRequestItem) {
            machineRequestItem.uom2 = value;
            machineRequestItem.uom2_desc = this.getUomCodeDescription(this.uomCodes, value);
        },

        onDeleteItem(machineRequestItem) {

            swal({
                title: "",
                text: `ต้องการลบรายการ ${machineRequestItem.inv_item_desc ? machineRequestItem.inv_item_desc : ""} ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    machineRequestItem.marked_as_deleted = true;
                    this.emitMachineRequestChanged();
                }
            });

        },

        onInvItemChanged(value, machineRequestItem) {

            machineRequestItem.inventory_item_id = value;
            const foundItem = this.itemOptions.find(i => {
                return i.inventory_item_id == value;
            });

            machineRequestItem.inv_item_number = foundItem.item_number;
            machineRequestItem.inv_item_desc = foundItem.item_desc;
            machineRequestItem.uom = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code)
            machineRequestItem.uom_desc = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code);
            machineRequestItem.uom2 = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code)
            machineRequestItem.uom2_desc = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code);

            this.emitMachineRequestChanged();

        },

        getUomCodeDescriptionByCode(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code_value == uomCode);
            return foundUomCode ? foundUomCode.uom_code_label : "";
        },

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code_label == uomCode);
            return foundUomCode ? foundUomCode.uom_code_label : "";
        },

        emitMachineRequestChanged() {
            this.$emit("onMachineRequestChanged", {
                machineRequestItems: this.machineRequestItems
            });
        },

    }

}

</script>