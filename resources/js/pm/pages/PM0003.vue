<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.create.class"><i
                        :class="btn_trans.create.icon"></i>
                        {{ btn_trans.create.text }}
                    </button>
                    <button type="button" :class="btn_trans.save.class"><i
                        :class="btn_trans.save.icon"></i>
                        {{ btn_trans.save.text }}
                    </button>
                    <button type="button" :class="btn_trans.annualProductionPlan.class" data-toggle="modal"
                            data-target=".bd-productionPlan-modal-lg"><i
                        :class="btn_trans.annualProductionPlan.icon"></i>
                        {{ btn_trans.annualProductionPlan.text }}
                    </button>
                    <button type="button" :class="btn_trans.estimateUsingMaterial.class"><i
                        :class="btn_trans.estimateUsingMaterial.icon"></i>
                        {{ btn_trans.estimateUsingMaterial.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>ประมาณการวัตถุดิบประจำปี</h5>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                แผนการผลิตประจำปี
                            </label>
                            <div class="col-lg-8">
                                <select class="form-control m-b" name="select1" id="select1">
                                    <option>แผนการผลิตประจำปี 2563</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                Version
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                กลุ่มวัตถุดิบ <span class="remark" style="color: red">*</span>
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                หน่วยงาน
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                สถานะ
                            </label>
                            <div class="col-lg-9">
                                <select class="form-control m-b" name="select1" id="select2">
                                    <option>สร้างใหม่</option>
                                    <option>บันทึก</option>
                                    <option>อนุมัติ</option>
                                    <option>ไม่อนุมัติ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <h5>รายการวัตถุดิบ</h5>
                            </div>

                            <div class="col-lg-8">
                                <div class="text-right">
                                    <button type="button" :class="btn_trans.add.class"><i
                                        :class="btn_trans.add.icon"></i>
                                        {{ btn_trans.add.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.deleteList.class"><i
                                        :class="btn_trans.deleteList.icon"></i>
                                        {{ btn_trans.deleteList.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.print.class"><i
                                        :class="btn_trans.print.icon"></i>
                                        {{ btn_trans.print.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.sendEstimatedInfo.class"><i
                                        :class="btn_trans.sendEstimatedInfo.icon"></i>
                                        {{ btn_trans.sendEstimatedInfo.text }}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="tr-header">
                                    <th rowspan="2">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </th>
                                    <th rowspan="2" class="header">
                                        รหัสวัตถุดิบ
                                    </th>
                                    <th rowspan="2" class="header">
                                        รายละเอียด
                                    </th>
                                    <th rowspan="2" class="header">
                                        ปริมาณที่ต่องใช้+สูญเสีย<br>/ล้านมวน
                                    </th>
                                    <th rowspan="2" class="header">
                                        หน่วยนับ
                                    </th>
                                    <th rowspan="2" class="header">
                                        % การใช้งาน
                                    </th>
                                    <th colspan="2" class="header">
                                        OCT
                                    </th>
                                    <th colspan="2" class="header">
                                        NOV
                                    </th>
                                    <th colspan="2" class="header">
                                        DEC
                                    </th>
                                    <th rowspan="2" class="header">
                                        รวม
                                    </th>

                                </tr>
                                <tr class="subminwidth">
                                    <th class="header">
                                        ต้องการ
                                    </th>
                                    <th class="header">
                                        ผลิต
                                    </th>
                                    <th class="header">
                                        ซื้อ
                                    </th>
                                    <th class="header">
                                        ต้องการ
                                    </th>
                                    <th class="header">
                                        ผลิต
                                    </th>
                                    <th class="header">
                                        ซื้อ
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="col-readonly">100400008</td>
                                    <td class="col-readonly">Tobacco Flavour 001</td>
                                    <td class="col-readonly">150.00</td>
                                    <td class="col-readonly">KG</td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">50.00</td>
                                    <td class="col-readonly"></td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">50.00</td>
                                    <td class="col-readonly"></td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">5000</td>
                                </tr>
                                <!-- end row1 -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-productionPlan-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="productionPlan">แผนการผลิตประจำปี</h3>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th colspan="3" class="header">แผนการผลิตบุหรี่ประจำปี 2563</th>
                                </tr>
                                <tr>
                                    <th class="header">ตราบุหรี่</th>
                                    <th class="header">จำนวน</th>
                                    <th class="header">หน่วย</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-readonly">กรุงทอง</td>
                                    <td class="col-readonly">227.5</td>
                                    <td class="col-readonly">ล้านมวน</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        btn_trans: {type: Object},
    },
    data() {
        return {}
    },
}

</script>
<style scoped>
.subminwidth th {
    min-width: 65px;
}

.ibox-title {
    padding: 20px;
}

.col-readonly {
    background: #e9ecef42 !important;
}

label.label-input {
    margin-bottom: 0rem;
}

input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

.check-center {
    text-align: center;
}

th.header {
    text-align: center;
}

</style>
