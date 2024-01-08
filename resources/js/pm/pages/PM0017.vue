<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h5>กองพิมพ์</h5>
                            </div>
                            <div class="col-sm-12 col-lg-8">
                                <div class="text-right">
                                    <button type="button" class="btn btn-w-m btn-default"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <button type="button" class="btn btn-w-m btn-warning"><i
                                            class="fa fa-edit (alias)"></i> แก้ไข</button>
                                    <button type="button" class="btn btn-w-m btn-primary"><i
                                            class="fa fa-save (alias)"></i> บันทึก</button>
                                    <button type="button" class="btn btn-w-m btn-primary"><i class="fa fa-check"></i>
                                        ส่งอนุมัติ</button>
                                    <button type="button" class="btn btn-w-m btn-info"><i class="fa fa-print"></i>
                                        พิมพ์</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">ปีงบประมาณ:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account">
                                            <option>2564</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-3 col-sm-4 col-form-label">เดือน:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account">
                                            <option>พฤศจิกายน</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-3 col-sm-4 col-form-label">ปักษ์:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account">
                                            <option>3</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-3 col-sm-4 col-form-label">เวอร์ชั่น:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account">
                                            <option>1</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">สถานะ:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control m-b" name="account">
                                            <option>สร้างใหม่</option>
                                            <option>บันทึก</option>
                                            <option>รออนุมัติ</option>
                                            <option>อนุมัติ</option>
                                            <option>ไม่อนุมัติ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">ผู้อนุมัติ:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">วันที่อนุมัติ:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                            <div class="text-right">
                                <button type="button" class="btn btn-w-m btn-success"><i class="fa fa-plus"></i>
                                    สร้างรายการเบิกวัตถุดิบ</button>
                                <button type="button" class="btn btn-w-m btn-primary"><i class="fa fa-check"></i>
                                    เปิดคำสั่งผลิต</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="min-width: 150px;">ตราบุหรี่</th>
                                    <th style="min-width: 150px;">ชนิดสิ่งพิมพ์</th>
                                    <th>รหัสสินค้าสำเร็จรูป</th>
                                    <th style="min-width: 250px;">รายละเอียด</th>
                                    <th style="min-width: 150px;">สั่งผลิต(ม้วนใหญ่)</th>
                                    <th>หน่วย</th>
                                    <th>จำนวนผลิตทั้งเดือน</th>
                                    <th>เหลือที่ต้องผลิต</th>
                                    <th style="min-width: 150px;">เลขที่คำสั่งผลิต</th>
                                    <th>ประมาณการผลิต</br>จากฝ่ายวางแผน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>กรุงทอง90</td>
                                    <td>กระดาษพันก้นกรอง</td>
                                    <td>11030DGL018</td>
                                    <td>กระดาษพันก้นกรองบุหรี่ กรุงทอง 90</td>
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>ROL</td>
                                    <td>10</td>
                                    <td>10</td>
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>1</td>
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
    td {
        vertical-align: middle !important;
        text-align: center;

    }

</style>
