<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h5>เบิกวัตถุดิบใช้ในการผลิต(หน่วยบรรจุภูมิภาค)</h5>
                            </div>
                            <div class="col-sm-12 col-lg-8">
                                <div class="text-right">
                                    <button type="button" class="btn btn-w-m btn-success"><i class="fa fa-plus"></i>
                                        สร้าง
                                    </button>
                                    <button type="button" class="btn btn-w-m btn-primary"><i
                                        class="fa fa-save (alias)"></i> บันทึก
                                    </button>
                                    <button type="button" class="btn btn-w-m btn-info"><i class="fa fa-print"></i>
                                        พิมพ์รายงาน
                                    </button>
                                    <button type="button" class="btn btn-w-m btn-primary"><i class="fa fa-check"></i>
                                        ยืนยันขอโอนวัตถุดิบ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input1">หน่วยงานที่ขอเบิก:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="input1" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input2">เลขที่ใบเบิก:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="input2">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input3">วันที่ใบขอเบิก:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="input3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input4">กลุ่มวัตถุดิบ:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="input4" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input5">สินค้าที่จะผลิต:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="input5">
                                            </div>
                                            <label class="col-lg-6">
                                                <input type="text" class="form-control" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input6">จำนวนที่จะผลิต:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="input6" disabled>
                                            </div>
                                            <label class="col-lg-4">
                                                <input type="text" class="form-control" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input7">ผู้ขอเบิก:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="input7" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="select1">
                                        วัตถุประสงค์ในการเบิก:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account" id="select1">
                                            <option>เบิกเพื่อผลิต</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="select2"> สถานะการเบิก:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account" id="select2" disabled>
                                            <option>ส่งข้อมูลเรียบร้อย</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input8">
                                        วันที่นำส่งยสท.:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="input8">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input9">ขั้นตอนการทำงาน:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="input9" disabled>
                                            </div>
                                            <label class="col-lg-9">
                                                <input type="text" class="form-control" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="select3">
                                        ชุดเครื่องจักร:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account" id="select3">
                                            <option>Handmade</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h5>รายการวัตถุดิบ</h5>
                            </div>
                            <div class="col-sm-6 col-lg-8">
                                <div class="text-right">
                                    <button type="button" class="btn btn-w-m btn-success"><i class="fa fa-plus"></i>
                                        เพิ่มรายการ
                                    </button>
                                    <button type="button" class="btn btn-w-m btn-danger"><i class="fa fa-check"></i>
                                        ลบรายการ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="min-width: 150px;">รหัสวัตถุดิบ</th>
                                    <th style="min-width: 150px;">รายละเอียด</th>
                                    <th style="min-width: 250px;">ปริมาณที่ต้องใช้+สูญเสีย</th>
                                    <th style="min-width: 150px;">หน่วยนับ</th>
                                    <th>คงคลัง</th>
                                    <th>ปริมาณเบิก</th>
                                    <th>หน่วยนับเบิก</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="col-lg-12">
                                            <label for="input10">
                                                <input type="text" class="form-control" id="input10">
                                            </label>
                                        </div>
                                    </td>
                                    <td>ยาเส้นปรุง Blend 12</td>
                                    <td>3,000.00000</td>
                                    <td>KG</td>
                                    <td>LEADCH01</td>
                                    <td></td>
                                    <td>
                                        <div class="col-lg-12">
                                            <label for="input11">
                                                <input type="text" class="form-control" id="input11">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-w-m btn-default"><i
                                            class="fa fa-file-text-o"></i> หมายเหตุ
                                        </button>
                                    </td>
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
</script>
<style scoped>
th,
a td {
    vertical-align: middle !important;
    text-align: center;

}

</style>
