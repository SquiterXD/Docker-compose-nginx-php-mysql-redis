<template>
    <div class="container row" v-loading="loading">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group row mb-0">
                                    <label class="col-md-4 col-form-label">เลขที่ใบเบิก</label>
                                    <div class="col-md-8 d-flex align-items-center">
                                        {{ this.form.issue_number }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-md-4 col-form-label">รายละเอียดขอเบิก</label>
                                    <div class="col-md-8 d-flex align-items-center">
                                        {{ this.form.description }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-md-4 col-form-label">สถานะ</label>
                                    <div class="col-md-3 d-flex align-items-center">
                                        {{ this.form.issue_status }}
                                    </div>
                                    
                                    <label class="col-md-1 col-form-label" v-if="this.issueHeader.cancel_date">โดย</label>
                                    <div class="col-md-4 d-flex align-items-center" v-if="this.issueHeader.cancel_date">
                                        {{ this.cancel_username }} - {{ this.cancel_name }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0" v-if="this.issueHeader.cancel_date">
                                    <label class="col-md-4 col-form-label">รายละเอียดการยกเลิก</label>
                                    <div class="col-md-8 d-flex align-items-center">
                                        {{ this.issueHeader.reason_name }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0" v-if="this.issueHeader.cancel_date">
                                    <label class="col-md-4 col-form-label">วันที่ยกเลิกรายการ</label>
                                    <div class="col-md-8 d-flex align-items-center">
                                        {{ this.cancel_date }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row mb-0">
                                    <label class="col-md-3 col-form-label">วันที่สร้างรายการ</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        {{ this.form.creation_date }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-md-3 col-form-label">หน่วยงานผู้ขอเบิก</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        {{ this.form.coaDeptCode.department_code }} - {{ this.form.coaDeptCode.description }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-md-3 col-form-label">Cost Center</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        {{ this.form.cost_center }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-md-3 col-form-label">Org</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        {{ this.form.organization_code }} - {{ this.form.organization_name }}
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-md-3 col-form-label">Subinventory</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        {{ this.form.subinventory_code }} - {{ this.form.subinventory_name }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">รหัสบัญชี</label>
                                    <div class="col-md-9 d-flex align-items-center">
                                        {{ this.form.gl_alias_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 p-0 mt-3">
                                <table class="table bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>รายละเอียดสินค้า</th>
                                            <th v-if="issueHeader.issue_status == 'WAITING' && allowed_status == 'Y'"></th>
                                            <th v-if="issueHeader.issue_status == 'UPDATE' && allowed_status == 'Y'"></th>
                                            <th class="text-center tw-whitespace-nowrap">จำนวนคงเหลือ</th>
                                            <th class="text-center tw-whitespace-nowrap">จำนวนที่ขอเบิก</th>
                                            <th class="text-center tw-whitespace-nowrap">หน่วยนับ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in form.items" :key="index">
                                            <td class="tw-text-xs">{{ item.line_no }}</td>
                                            <td class="tw-text-xs">{{ item.item }}</td>
                                            <td class="tw-text-xs">{{ item.description }}</td>
                                            <td class="tw-whitespace-nowrap" v-if="issueHeader.issue_status == 'WAITING' && allowed_status == 'Y'">
                                                <ModalSelectLotComponent 
                                                    :subinventory-code="form.subinventory_code"
                                                    :item="item" 
                                                    :lot-onhands="item.lot_onhand"
                                                    :index="index"/>
                                                <div v-for="(issueApproveDetail) in issueApproveDetails" :key="issueApproveDetail.id">
                                                    <div v-if="issueApproveDetail['issue_detail_id'] == item.issue_detail_id">
                                                        <span class="tw-text-xs">
                                                            <b>ตำแหน่ง: </b> {{issueApproveDetail['locator']}} <br>
                                                            <b>ล็อต: </b> {{issueApproveDetail['lot_number']}} <br>
                                                            <b>จำนวน: </b> {{parseFloat(issueApproveDetail['quantity'])}} <br>
                                                            <br>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td v-if="issueHeader.issue_status == 'UPDATE' && allowed_status == 'Y'">
                                                <ModalSelectLotComponent 
                                                    :subinventory-code="form.subinventory_code"
                                                    :item="item" 
                                                    :lot-onhands="item.lot_onhand"
                                                    :index="index"/>
                                                <div v-for="(issueApproveDetail) in issueApproveDetails" :key="issueApproveDetail.id">
                                                    <div v-if="issueApproveDetail['issue_detail_id'] == item.issue_detail_id">
                                                        <span class="tw-text-xs">
                                                            <b>ตำแหน่ง: </b> {{issueApproveDetail['locator']}} <br>
                                                            <b>ล็อต: </b> {{issueApproveDetail['lot_number']}} <br>
                                                            <b>จำนวน: </b> {{parseFloat(issueApproveDetail['quantity'])}} <br>
                                                            <br>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tw-text-xs text-center">{{ totalLotNumber(item.lot_onhand) }}</td>
                                            <td class="tw-text-xs text-center">{{ item.transaction_quantity }}</td>
                                            <td class="tw-text-xs">{{ item.primary_unit_of_measure }}</td>
                                            <td class="tw-text-xs">{{ item.transaction_account }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-right mt-2 p-0">
                                    <el-button
                                        v-if="issueHeader.issue_status == 'WAITING'"
                                        class="btn-success"
                                        size="mini"
                                        type="success"
                                        @click="getCtReport"
                                        >ใบเบิกวัสดุเครื่องเขียน
                                    </el-button>
                                    <el-button
                                        v-if="issueHeader.issue_status == 'APPROVED'"
                                        class="btn-success"
                                        size="mini"
                                        type="success"
                                        @click="getCtReport"
                                        >ใบเบิกวัสดุเครื่องเขียน
                                    </el-button>
                                    <el-button
                                        v-if="issueHeader.issue_status == 'UPDATE'"
                                        class="btn-success"
                                        size="mini"
                                        type="success"
                                        @click="getCtReport"
                                        >ใบเบิกวัสดุเครื่องเขียน
                                    </el-button>
                                    <el-button
                                        v-if="issueHeader.issue_status == 'WAITING' && allowed_status == 'Y'"
                                        class="btn-success"
                                        size="mini"
                                        type="success"
                                        @click="approve"
                                        
                                        >ตัดจ่าย
                                    </el-button>
                                    <el-button
                                        v-if="issueHeader.issue_status == 'UPDATE' && allowed_status == 'Y'"
                                        class="btn-success"
                                        size="mini"
                                        type="success"
                                        @click="approve"
                                        
                                        >ตัดจ่าย
                                    </el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.el-select-dropdown__item {
    font-size: 12px;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}
</style>

<script>
import moment from "moment";
import ModalSelectLotComponent from './ModalSelectLotComponent.vue'

export default {
    components: {
        ModalSelectLotComponent,
    },
    props: ["issueHeader", "lookupValues", "user"],
    data() {
        return {
            selectedLot: [],
            issueApproveDetails: [],
            onhand_quantity: "",

            form: {
                coaDeptCode: this.issueHeader?.coa_dept_code || "",
                organization_code: this.issueHeader?.issue_program_profile_v.organization_code || "",
                organization_name: this.issueHeader?.organization_units.name || "",
                subinventory_code: this.issueHeader?.secondary_inventory.secondary_inventory_name || "",
                subinventory_name: this.issueHeader?.secondary_inventory.description || "",
                organization_id: this.issueHeader?.organization_id || "",
                issue_header_id: this.issueHeader?.issue_header_id || "",
                issue_number: this.issueHeader?.issue_number || "",
                cost_center: this.issueHeader?.acc_segment4 || "",
                transaction_date:
                    this.issueHeader ? moment(this.issueHeader.transaction_date).add(543, "year").format("DD/MM/YYYY") : moment().add(543, "year").format("DD/MM/YYYY"),
                created_at:
                    this.issueHeader ? moment(this.issueHeader.created_at).add(543, "year").format("DD/MM/YYYY") : moment().add(543, "year").format("DD/MM/YYYY"),
                    creation_date:
                this.issueHeader ? moment(this.issueHeader.creation_date).add(543, "year").format("DD/MM/YYYY") : moment().add(543, "year").format("DD/MM/YYYY"),
                inventory_item_id: this.issueHeader?.inventory_item_id || "",
                description: this.issueHeader?.description || "",
                gl_alias_name: this.issueHeader?.gl_alias_name || "",
                issue_status: 
                    this.issueHeader?.issue_status == 'WAITING' ? "รอตัดจ่าย" 
                    : this.issueHeader?.issue_status == 'APPROVED' ? "ตัดจ่ายสำเร็จ" 
                    : this.issueHeader?.issue_status == 'INPROCESS' ? "INPROCESS"
                    : this.issueHeader?.issue_status == 'CANCELLED' ? "ยกเลิก" 
                    : this.issueHeader?.issue_status == 'RETURN' ? "ยกเลิก" 
                    : this.issueHeader?.issue_status == 'DRAFT' ? "ร่างรายการเบิก" 
                    : "รอตัดจ่าย" ,
                items:
                    this.issueHeader?.details.map((detail) => {
                        let data = {
                        ...detail,
                        ...{ item: detail.inventory_item.segment1 },
                        ...{ primary_unit_of_measure: detail.inventory_item.primary_unit_of_measure },
                        };
                        return data;
                        
                    }) || [],
                lot_number: "",
                locator: "",
                locator_id: "", 
            },
            username: this.user?.username || "",
            allowed_status: 'N',

            cancel_date: this.issueHeader?.cancel_date ? moment(this.issueHeader.cancel_date).format("DD/MM/YYYY") : "",
            cancel_username: this.issueHeader?.cancel_user?.username || "",
            cancel_name: "",

            loading: false,
        }
    },
    created: function () {
        this.getMasterData();
    },
    mounted() {
        let allowedUser = this.lookupValues.find((user) => {
            return user.meaning == this.username
        });

        if (allowedUser) {
            this.allowed_status = 'Y'
        }

        let cancelUser = this.lookupValues.find((value) => {
            return value.meaning == this.cancel_username
        });
        if (cancelUser) {
            this.cancel_name = cancelUser.description;
        }

    },
    watch: {

    },
    methods: {
        getMasterData() {
            this.getIssueApproveDetails();
        },
        getIssueApproveDetails() {
            axios
                .get("/inv/issue_approve_detail")
                .then((response) => {
                    this.issueApproveDetails = response.data;
                })
                .catch((err) => {
                    console.log("error get car fuels")
                });
        },
        approve() {
            this.loading = true;
            for (let index = 0; index < this.form.items.length; index++) {
                if (parseInt(this.form.items[index].transaction_quantity) > parseInt(this.form.items[index].onhand_quantity)) {
                    alert("จำนวนรายการสินค้า "+this.form.items[index].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ")
                    this.loading = false;
                    return 
                }

                let issueApproveDetails = this.issueApproveDetails.find((detail) => {
                    return detail.issue_detail_id == this.form.items[index].issue_detail_id
                });

                if (!issueApproveDetails) {
                    return alert("กรุณาเลือก lot number ของ " + this.form.items[index].description);
                }
            }
            if (confirm("อนุมัติการเบิกจ่ายเครื่องเขียน ?")) {
                this.loading = true;
                axios
                    .patch(
                        `/inv/requisition_stationery/${this.form.issue_header_id}/approve`
                    )
                    .then((res) => {
                        this.loading = true;
                        this.$notify({
                            title: 'Success',
                            message: 'Successfully',
                            type: 'success'
                        });
                        window.location.reload();
                    })
                    .catch((err) => {
                        this.loading = false;
                        if (err.response.status == 403) {
                            this.$notify.error({
                            title: 'Error',
                            message: err.response.data.msg,
                            duration: 4500,
                            });
                        }

                        let errorMessage = this.$formatErrorMessage(error);
                        alert(errorMessage);
                    })
            }
        },
        getCtReport() {
            window.location.replace(`/inv/requisition_stationery/${this.form.issue_header_id}/ct-web-stationery-pdf`)
        },
        totalLotNumber(lotOnhand) {
            let sum = 0; 
            lotOnhand.forEach((item) => {
                sum += parseInt(item.on_hand)
            });
            return sum
        }
    }
}
</script>