<template>
    <div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h5>การเรียกใบยาและการส่งขออนุมัติการสร้างลูกค้า</h5>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 ">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                วันที่เรียกใบยา
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="date" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                Blend No.<span class="remark">*</span>
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                สินค้าที่จะผลิต
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                จำนวนที่ผลิต
                            </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                            <div class="col-lg-2">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                ประเภทใบยาที่ต้องการเรียก<span class="remark" style="color: red;">*</span>
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                เลขที่คำสั่งผลิต
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                OPT.<span class="remark" style="color: red">*</span>
                            </label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12">
                        <div class="text-right">
                            <button type="button" :class="btn_trans.search.class"><i
                                :class="btn_trans.search.icon"></i>
                                {{ btn_trans.search.text }}
                            </button>
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
                            <div class="col-lg-6">
                                <h5>รายการวัตถุดิบ</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="float-right mb-3">
                                    <button type="button" :class="btn_trans.add.class"><i
                                        :class="btn_trans.add.icon"></i>
                                        {{ btn_trans.add.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.deleteList.class"><i
                                        :class="btn_trans.deleteList.icon"></i>
                                        {{ btn_trans.deleteList.text }}
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
                                    <th>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </th>
                                    <th style="min-width: 80px;">
                                        กลุ่มใบยา
                                    </th>
                                    <th style="min-width: 100px;">
                                        รหัสวัตฤดิบ
                                    </th>
                                    <th style="min-width: 100px;">
                                        รายละเอียด
                                    </th>
                                    <th style="min-width: 100px;">
                                        Lot No
                                    </th>
                                    <th style="min-width: 80px;">
                                        หน่วยนับ
                                    </th>
                                    <th style="min-width: 120px;">
                                        ปริมาณที่ต้องใช้
                                    </th>
                                    <th style="min-width: 80px;">
                                        หน่วยนับ
                                    </th>
                                    <th style="min-width: 130px">
                                        ปริมาณคงคลัง<br>FULL/ASRS
                                    </th>
                                    <th style="min-width: 120px;">หน่วยเบิก</th>
                                    <th style="min-width: 140px">ปริมาณที่ต้องการเบิก<br>Quarter/RGV
                                    </th>
                                    <th style="min-width: 120px;">
                                        หน่วยเบิก
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--  row1 -->
                                <tr>
                                    <td>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="col-readonly"> BX</td>
                                    <td class="col-readonly">100100BX</td>
                                    <td class="col-readonly">FX</td>
                                    <td class="col-readonly">5,000</td>
                                    <td class="col-readonly">400</td>
                                    <td class="col-readonly">KG</td>
                                    <td class="col-readonly">2</td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>หีบ</option>
                                            </select>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>ลูก</option>
                                            </select>
                                        </label>
                                    </td>
                                </tr>
                                <!-- end row1 -->
                                <!--  row2 -->
                                <tr>
                                    <td>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="col-readonly"></td>
                                    <td class="col-readonly"></td>
                                    <td class="col-readonly"></td>
                                    <td class="col-readonly"></td>
                                    <td class="col-readonly"></td>
                                    <td class="col-readonly"></td>
                                    <td class="col-readonly"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <!-- end row2 -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa fa-check"></i>&nbsp;&nbsp;ยืนยันเรียกใบยา
                                </button>
                            </div>
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
}
</script>
<style scoped>
.subminwidth th {
    min-width: 65px;
}

.ibox-title {
    padding: 20px;
}

.check-center {
    text-align: center;
}

.col-readonly {
    background: #e9ecef42 !important;
}

input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

select.form-control.select-field {
    border: none;
}

select.form-control.select-field:focus {
    outline: 1px solid #1ab394;
}

</style>
