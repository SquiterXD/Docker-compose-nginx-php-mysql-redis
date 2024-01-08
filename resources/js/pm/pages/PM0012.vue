<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>บันทึกสูญเสีย</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input1">เลขที่คำสั่งการผลิต
                                        <span style="color:red">*</span>
                                    </label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="input1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input2">รหัสสินค้าสำเร็จรูป:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="input2" disabled>
                                            </div>
                                            <label class="col-lg-6">
                                                <input type="text" class="form-control" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input3">จำนวนที่ผลิต:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <input type="text" class="form-control" id="input3" disabled>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group row">
                                                    <label class="col-lg-5 col-form-label"
                                                           for="input4">หน่วยนับ:</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" class="form-control" id="input4" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input5">ขั้นตอนWIP
                                        <span style="color:red">*</span></label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control m-b" name="input5" id="input5">
                                                    <option>02</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-7">
                                                <input type="text" class="form-control" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input6">OPT<span
                                        style="color:red">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="input6" id="input6">
                                            <option>98/102</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input7">Blen No.:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="input7" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input8">วันที่ผลิต:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="input8" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input9">
                                        จำนวนที่สูญเสีย:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="input9" disabled>
                                            </div>
                                            <label class="col-lg-4">
                                                <input type="text" class="form-control" disabled>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-title">
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 20%;">รหัสรายการสูญเสีย</th>
                                <th style="width: 50%;">รายการสูญเสีย</th>
                                <th style="width: 15%;">จำนวนสูญเสีย</th>
                                <th style="width: 15%;">หน่วย</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="col-readonly">01</td>
                                <td class="col-readonly">เศษใบยา</td>
                                <td>
                                    <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                        <input type="text" class="form-control input-field">
                                    </label>
                                </td>
                                <td>
                                    <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                        <input type="text" class="form-control input-field">
                                    </label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="button" :class="btn_trans.save.class"><i
                            :class="btn_trans.save.icon"></i>
                            {{ btn_trans.save.text }}
                        </button>
                        <button type="button" :class="btn_trans.cancel.class"><i
                            :class="btn_trans.cancel.icon"></i>
                            {{ btn_trans.cancel.text }}
                        </button>
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
input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

.col-readonly {
    background: #e9ecef42 !important;
}
</style>
