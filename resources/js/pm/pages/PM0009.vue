<template>
    <div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="text-right">
                                <button class="btn btn-w-m btn-success" @click.prevent="newHeader">
                                    <i class="fa fa-plus"></i> สร้าง
                                </button>
                                <button type="submit" class="btn btn-w-m btn-primary">
                                    <i class="fa fa-save (alias)"></i> บันทึก
                                </button>
                                <button type="submit" class="btn btn-w-m btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i> ตัดใช้วัตถุดิบ
                                </button>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <form role="form">
                                        <div class="form-group row row">
                                            <label class="col-lg-3 col-form-label"><B>หน่วยงาน</B></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label
                                                class="col-lg-3 col-form-label"><B>เลขที่คำสั่งผลิต<span style="color:red">*</span></B></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"><B>OPT</B></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"><B>สินค้าที่จะผลิต</B></label>
                                            <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label
                                                class="col-lg-3 col-form-label"><B>ประเภทวัตถุดิบ</B></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label
                                                class="col-lg-3 col-form-label"><B>กลุ่มวัตถุดิบ</B></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label
                                                class="col-lg-3 col-form-label"><B>จำนวนที่ผลิต</B></label>
                                            <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label
                                                class="col-lg-3 col-form-label"><B>ผลผลิตที่ได้</B></label>
                                            <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row"><label
                                            class="col-lg-3 col-form-label"><B>เลขที่ตัดใช้วัตถุดิบ<span style="color:red">*</span></B></label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row"><label
                                            class="col-lg-3 col-form-label"><B>ประเภทคำสั่งผลิต</B></label>
                                        <div class="col-lg-6">
                                            <select id="inputState" class="form-control" disabled>
                                                <option selected>สินค้าทดลอง</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-lg-3 col-form-label"><B>Blend
                                                No.</B></label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><B>ขั้นตอนการทำงาน<span style="color:red">*</span></B></label>
                                        <div class="col-lg-6">
                                                <div class="form-row">
                                                    <div class="col-lg-4">
                                                        <select  class="form-control" disabled>
                                                            <option selected>30</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-group row"><label
                                            class="col-lg-3 col-form-label"><B>ชุดเครื่องจักร<span style="color:red">*</span></B></label>
                                        <div class="col-lg-6">
                                            <select id="inputState" class="form-control" disabled>
                                                <option selected>สินค้าทดลอง</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label
                                            class="col-lg-3 col-form-label"><B>วันที่ตัดใช้วัตถุดิบ</B></label>
                                        <div class="col-lg-6">
                                            <input type="date" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label
                                            class="col-lg-3 col-form-label"><B>วันที่ได้ผลผลิต<span style="color:red">*</span></B></label>
                                        <div class="col-lg-6">
                                            <input type="date" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <h3>รายการวัตถุดิบ</h3>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <th>รหัสวัตถุดิบ</th>
                                    <th>รายละเอียด</th>
                                    <th>ปริมาณที่ต้องใช้+สูญเสีย</th>
                                    <th>หน่วยนับ</th>
                                    <th>คลังจัดเก็บ</th>
                                    <th>สถานที่จัดเก็บ</th>
                                    <th>Lot Number*.</th>
                                    <th>วันหมดอายุ</th>
                                    <th>ปริมาณคงคลังโซนผลิต</th>
                                    <th>คงคลังเช้า</th>
                                    <th>ปริมาณเบิกทั้งวัน2</th>
                                    <th>คงคลังเย็น</th>
                                    <th>ปริมาณที่ใช้*</th>
                                    <th>หน่วยนับ2</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-readonly">100300001</td>
                                        <td class="col-readonly">กระดาษมวนบุหรี่ No.2 ชนิดม้วนแบบเรียบ ขนาด 27 ม.ม.X6000
                                            ม.</td>
                                        <td class="col-readonly">37,310.00</td>
                                        <td class="col-readonly">ROL</td>
                                        <td class="col-readonly">FC4R0J01</td>
                                        <td class="col-readonly">PROTO590E-1</td>
                                        <td class="col-readonly">KB04/60/10/20 16S/13/17_1</td>
                                        <td class="col-readonly"></td>
                                        <td class="col-readonly">45,500.00</td>
                                        <td class="col-readonly">5,000.00</td>
                                        <td class="col-readonly">40,000.00</td>
                                        <td class="col-readonly">7,000.00</td>
                                        <td class="col-readonly">10,00.00</td>
                                        <td class="col-readonly">ROL</td>
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
