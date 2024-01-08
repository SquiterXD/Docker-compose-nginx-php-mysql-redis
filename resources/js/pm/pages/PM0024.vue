<template>
    <div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <!-- หน้าจอหลัก (1) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="HomeScreen fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">รับโอนวัตถุดิบ</h1>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-success col-lg-5 p-3 mb-5"><i
                                                class="fa fa-qrcode"></i>&nbsp;&nbsp;สแกนรายงาน</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End หน้าจอหลัก -->
                    <!-- สแกน Qrcode (2) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="ScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">สแกน</h1>
                                    <div class="form-group mb-3">
                                        <img src="https://cdn.techinasia.com/wp-content/uploads/2010/11/qrcode.png">
                                    </div>
                                    <button type="button" class="btn btn-danger col-lg-5 p-3 mb-5"><i
                                            class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End  สแกน Qrcode -->

                    <!-- แสดงผลสแกน Qrcode (3) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ผลการสแกน</h1>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">1003000001</span> </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รายละเอียด</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">กระดาษมวนบุหรี่ No.1 ชนิด
                                                ม้วนแบบเรียบ ขนาด 27 ม.ม x 6000 ม.</span> </div>
                                    </div>

                                    <div class="form-group row text-center mt-5">
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button class="btn btn-success col-lg-12 p-3"><i
                                                    class="fa fa-qrcode"></i>&nbsp;สแกนเครื่องจักร</button>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button type="button" class="btn btn-danger col-lg-12 p-3"><i
                                                    class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End แสดงผลสแกน Qrcod -->

                    <!-- สแกน Qrcode (5)-->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="ScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">สแกนเครื่องจักร</h1>
                                    <div class="form-group mb-3">
                                        <img src="https://cdn.techinasia.com/wp-content/uploads/2010/11/qrcode.png">
                                    </div>
                                    <button type="button" class="btn btn-danger col-lg-5 p-3 mb-5"><i
                                            class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End  สแกน Qrcode -->

                    <!-- แสดงผลตรวจสอบถูก (5) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ผลการตรวจสอบ</h1>
                                    <div class="form-group row text-left mb-3">
                                        <div class="col-lg-12">
                                            <h2 class="font-bold mb-3">วัตถุดิบที่นำมา</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">1003000001</span> </div>
                                    </div>

                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h3 class="font-bold">รายละเอียด</h3>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">กระดาษมวนบุหรี่ No.1 ชนิด
                                                ม้วนแบบเรียบ ขนาด 27 ม.ม x 6000 ม.</span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-12 mb-2">
                                            <h2 class="font-bold">เครื่องจักร</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัส</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">PROTOS90E No.1</span>
                                        </div>
                                    </div>


                                    <div class="form-group row text-center mt-5">
                                        <div class="col-sm-12 col-lg-12 mb-3">
                                            <h3 class="green-text"><i
                                                    class="fa fa-check fa-2x"></i>&nbsp;วัตถุดิบถูกต้องตรงกับที่ต้องการใช้
                                            </h3>
                                        </div>

                                    </div>

                                    <div class="form-group row text-center mt-3">
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button class="btn btn-success col-sm-12 col-lg-12 p-3"><i
                                                    class="fa fa-qrcode"></i>&nbsp;&nbsp;สแกนผู้รับโอน</button>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button type="button" class="btn btn-primary col-lg-12 p-3"><i
                                                    class="fa fa-home"></i>&nbsp;&nbsp;กลับหน้าจอหลัก</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End แสดงผลสแกน Qrcod -->
                    <!-- แสดงผลตรวจสอบผิด (6) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ผลการตรวจสอบ</h1>
                                    <div class="form-group row text-left mb-3">
                                        <div class="col-lg-12">
                                            <h2 class="font-bold mb-3">วัตถุดิบที่ต้องใช้</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">1003000001</span>
                                        </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h3 class="font-bold">รายละเอียด</h3>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">กระดาษมวนบุหรี่ No.1 ชนิด
                                                ม้วนแบบเรียบ ขนาด 27 ม.ม x 6000 ม.</span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-12 mb-2">
                                            <h2 class="font-bold">เครื่องจักร</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัส</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">PROTOS90E No.1</span>
                                        </div>
                                    </div>


                                    <div class="form-group row text-center mt-5">
                                        <div class="col-sm-12 col-lg-12 mb-3 red-text">
                                            <h3><i class="fa fa-times fa-2x"></i>&nbsp;วัตถุดิบไม่ถูกต้อง
                                                ไม่ตรงกับที่ต้องการใช้</h3>

                                        </div>
                                    </div>
                                    <div class="form-group row text-center mt-3">
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button class="btn btn-success col-sm-12 col-lg-12 p-3"><i
                                                    class="fa fa-qrcode"></i>&nbsp;&nbsp;สแกนเครื่องจักร</button>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button type="button" class="btn btn-primary col-lg-12 p-3"><i
                                                    class="fa fa-home"></i>&nbsp;&nbsp;กลับหน้าจอหลัก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--End แสดงผลสแกน Qrcod -->
                    <!-- สแกน Qrcode (7) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="ScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">สแกน</h1>
                                    <div class="form-group mb-3">
                                        <img src="https://cdn.techinasia.com/wp-content/uploads/2010/11/qrcode.png">
                                    </div>
                                    <button type="button" class="btn btn-danger col-lg-5 p-3 mb-5"><i
                                            class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End  สแกน Qrcode -->
                    <!-- แสดงผลผู้รับโอน (8) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ผู้รับโอน</h1>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">ผู้รับโอน</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">นายแดง</span> </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสผนักงาน</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">20010</span> </div>
                                    </div>

                                    <div class="form-group row text-center mt-5">
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button class="btn btn-primary col-lg-12 p-3"><i
                                                    class="fa fa-check"></i>&nbsp;ยืนยันผู้รับโอน</button>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button type="button" class="btn btn-danger col-lg-12 p-3"><i
                                                    class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End แสดงผลผู้รับโอน-->
                    <!-- ระบุจำนวนรับโอนวัตถุดิบ (9) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="DisplayScanQr fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">
                                    <h1 class="font-bold p-3">ระบุจำนวนรับโอนวัตถุดิบ</h1>
                                    <div class="form-group row text-left mb-3">
                                        <div class="col-lg-12">
                                            <h2 class="font-bold mb-3">วัตถุดิบที่นำมา</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสวัตถุดิบ</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">1003000001</span>
                                        </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-3">
                                            <h3 class="font-bold">รายละเอียด</h3>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">กระดาษมวนบุหรี่ No.1 ชนิด
                                                ม้วนแบบเรียบ ขนาด 27 ม.ม x 6000 ม.</span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-12 mb-2">
                                            <h2 class="font-bold">เครื่องจักร</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัส</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">PROTOS90E No.1</span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-12 mb-2">
                                            <h2 class="font-bold">ผู้รับโอน</h2>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">ชื่อ</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">นายแดง</span>
                                        </div>
                                        <div class="col-lg-3">
                                            <h4 class="font-bold">รหัสผนักงาน</h4>
                                        </div>
                                        <div class="col-lg-9"><span class="form-text">20010</span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row text-left">
                                        <div class="col-lg-12 mb-2">
                                            <h2 class="font-bold">การโอน</h2>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="font-bold">จำนวนสุงสุดที่สามารถรับโอน</h4>
                                        </div>
                                        <div class="col-lg-6 input-group">
                                            <input type="number" class="form-control col-lg-8 mb-3"><span
                                                class="form-text col-lg-4">ม้วน</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="font-bold">จำนวนที่รับโอน</h4>
                                        </div>
                                        <div class="col-lg-6 input-group">
                                            <input type="number" class="form-control col-lg-8 mb-3"><span
                                                class="form-text col-lg-4"> ม้วน</span>
                                        </div>
                                    </div>




                                    <div class="form-group row text-center mt-4">
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button class="btn btn-primary col-sm-12 col-lg-12 p-3"><i
                                                    class="fa fa-check"></i>&nbsp;&nbsp;ยืนยันรับโอน</button>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 col-md-6">
                                            <button type="button" class="btn btn-danger col-sm-12 col-lg-12 p-3"><i
                                                    class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--End ระบุจำนวนรับโอนวัตถุดิบ -->
                    <!-- หน้าจอรับโอนวัตถุดิบเรียบร้อย (10) -->
                    <div class="ibox">
                        <div class="ibox-content ">
                            <div class="HomeScreen fill">
                                <div class="p-lg text-center centered col-lg-6 col-sm-12">

                                    <div class="icon-success-box">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>

                                    <div class="text-center mt-5">
                                        <h1 class="font-bold p-3">รับโอนวัตถุดิบเรียบร้อย</h1>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End หน้าจอหลัก -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        metaInfo: {
            title: 'การโอนวัตถุดิบ',
        },
        props: {

        },
        methods: {}
    }

</script>

<style scoped>
    .green-text {
        color: green;
    }

    .red-text {
        color: red;
    }

    .fill {
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .icon-success-box i {
        color: #a5dc86;
        font-size: 4rem;
        border: 3px solid rgb(165 220 134 / 40%);
        border-radius: 50%;
        padding: 30px;
        /* font-weight: 300; */
    }

</style>
