<template>
    <div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h5>บันทึกใช้ยาเส้น Zone C48</h5>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row mt-3">
                            <label class="col-lg-3 col-form-label" for="">
                                คลังจัดเก็บ
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                Blend no. <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                            <label class="col-form-label" for="">
                                OPT <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-4">
                                <select class="form-control" name="account">
                                    <option>98/102</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                จำนวนที่ต้องการ <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>

                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                เลขที่เอกสาร <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row mt-3">
                            <label class="col-lg-3 col-form-label" for="">
                                สถานที่จัดเก็บ
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                รหัสสินค้าสำเร็จรูป
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off" disabled="">
                            </div>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                วันที่ <span style="color:red">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="date" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <h5>เลือกได้แค่ 1 รายการต่อครั้ง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="tr-header">
                                    <th class="header" width="3%">
                                    </th>
                                    <th class="header" width="10%">
                                        Blend No.
                                    </th>
                                    <th class="header" width="12%">
                                        รหัสสินค้าสำเร็จรูป
                                    </th>
                                    <th class="header" width="23%">
                                        รายละเอียด
                                    </th>
                                    <th class="header">
                                        LOT
                                    </th>
                                    <th class="header" width="20%">
                                        ปริมาณคงคลัง
                                    </th>
                                    <th class="header" width="10%">
                                        หน่วยนับ
                                    </th>
                                    <th class="header" width="12%">
                                        ปริมาณที่นำไปโรย
                                    </th>
                                    <th width="10%">
                                        หน่วยนับ
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--  row 1-->
                                <tr>
                                    <td>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="col-readonly text-center">3</td>
                                    <td class="col-readonly text-left">100600003</td>
                                    <td class="col-readonly text-left">ยาเส้นปรุง Blend No.3 300.00 KG</td>
                                    <td class="col-readonly text-left">000001</td>
                                    <td class="col-readonly text-right">300.00</td>
                                    <td class="col-readonly text-left">KG</td>
                                    <td class="text-left">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly text-left">KG</td>
                                </tr>
                                <!--  row 1-->
                                <!-- end row กระดาษพันก้นกรอง-->
                                <!-- end กระดาษพันก้นกรอง -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center">
                                <button type="button" :class="btn_trans.confirmTobacco.class"><i
                                    :class="btn_trans.confirmTobacco.icon"></i>
                                    {{ btn_trans.confirmTobacco.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end table1 -->
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

tr.tr-header.t2 th {
    min-width: 100px;
}

.ibox-title {
    padding: 20px !important;
}

.check-center {
    text-align: center;
}

input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

th.header {
    text-align: center;
}

</style>
