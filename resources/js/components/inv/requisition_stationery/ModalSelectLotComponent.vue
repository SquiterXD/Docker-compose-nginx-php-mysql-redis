<template>
    <div>
        <div class="form-group">
            <div>
                <button class="btn btn-sm btn-primary" data-toggle="modal" :data-target="`#selectLotNumber`+index">
                    Select Lot Number
                </button>
            </div>
        </div>

        <div class="modal fade" :id="`selectLotNumber`+index" tabindex="-1" role="dialog" aria-labelledby="selectLotNumberLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-select-lot-number" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-select-lot-number">
                        <div class="modal-title" id="selectLotNumberLabel">
                            <h3 class="m-0">Select Lot Number</h3>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-body-select-lot-number">
                        <div class="card">
                            <div class="card-body text-center row">
                                <div class="col-md-7 tw-whitespace-pre-wrap">
                                        <span class="tw-font-bold mr-3">ชื่อสินค้า</span>{{item.description}}
                                </div>
                                <div class="col-md-5">
                                        <span class="tw-font-bold mr-3">จำนวน</span>
                                        <span class="mr-3">{{item.transaction_quantity}}</span>{{item.primary_unit_of_measure}}
                                </div>
                                
                            </div>
                        </div>
                        <div class="text-center" v-if="lotOnhands.length == 0">
                            <span>จำนวนคงเหลือในคลัง : 0</span>
                        </div>
                        <table class="table table-select-lot-number" v-if="lotOnhands.length != 0">
                            <thead>
                                <tr>
                                    <th class="text-center">ตำแหน่ง</th>
                                    <th class="text-center">Lot Number</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(approvalItem, index) in formApprovalItems" :key="index">
                                    <td class="tw-text-xs">{{ approvalItem.locator }}</td>
                                    <td class="tw-text-xs text-center">{{ approvalItem.lot_number }}
                                        <br>
                                        <span class="bg-secondary text-white">{{ approvalItem.on_hand }}</span>
                                    </td>
                                    <td class="text-right">
                                        <el-input-number
                                            :min="0"
                                            controls-position="right"
                                            size="mini"
                                            v-model="approvalItem.quantity"
                                        ></el-input-number>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer modal-footer-select-lot-number">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" @click.prevent="save()">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .el-input-number--mini {
        width: 90px;
        line-height: 26px;
    }
    .table-select-lot-number {
        margin: 0px;
    }
    .modal-body-select-lot-number {
        padding: 0;
    }
    .modal-header-select-lot-number {
        align-items: center;
    }
    .modal-footer-select-lot-number {
        padding: 10px;
    }
    .modal-dialog-select-lot-number {
        max-width: 500px;
        margin: 1.75rem auto;
    }
    body.modal-open {
        overflow: scroll !important;
    }
</style>

<script>
export default {
    
    props: {
        lotOnhands: Array,
        index: Number,
        item: Object,
        subinventoryCode: String,
    },

    data() {
        return {
            issueApproveDetails: [],
            issue_detail_id: this.item.issue_detail_id,
            formApprovalItems: this.lotOnhands.map( lotOnhand => {
                return {
                    issue_detail_id: this.item.issue_detail_id,
                    inventory_item_id: lotOnhand.inventory_item_id,
                    subinventory_code: lotOnhand.subinventory_code,
                    locator: lotOnhand.locator,
                    lot_number: lotOnhand.lot_number,
                    on_hand: lotOnhand.on_hand,
                    quantity: 0,
                }
            }),
            loading: false,
        }
    },

    mounted() {
        this.formApprovalItems = this.formApprovalItems.filter((i) => {
            return i.subinventory_code == this.subinventoryCode
        })

    },

    created: function () {

    },
    methods: {
        save() {
            this.loading = true;
            let issueApproveDetails = this.formApprovalItems.map((detail) => {
                let data = {
                    ...detail,
                    ...{item_transaction_quantity: this.item.transaction_quantity}
                };
                return data
            })
            
            var sumQuantity = issueApproveDetails.reduce((sum, item) => sum + item.quantity, 0);

            for (let index = 0; index < issueApproveDetails.length; index++) {
                if (issueApproveDetails[index].on_hand < issueApproveDetails[index].quantity) {
                    return alert('จำนวนคงเหลือไม่พอต่อการเบิก')
                }
                if (sumQuantity < issueApproveDetails[index].item_transaction_quantity) {
                    return alert('ระบุจำนวนน้อยกว่าจำนวนที่ขอเบิก')
                }
                if (sumQuantity > issueApproveDetails[index].item_transaction_quantity) {
                    return alert('ระบุจำนวนมากกว่าจำนวนที่ขอเบิก')
                }
            }
            
            axios
                .post("/inv/issue_approve_detail", {
                    formApprovalItems: this.formApprovalItems,
                    issueDetailId: this.issue_detail_id
                })
                .then((res) => {
                    this.loading = true;
                    window.location.reload()
                })
                .catch((err) => {
                    this.loading = false;
                    let errorMessage = this.$formatErrorMessage(error);
                    alert(errorMessage);
                });
        }
    }
    
}
</script>