<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-8">
                <div class="text-right">
                    <button type="button" :class="btn_trans.search.class" data-toggle="modal"
                            data-target=".bd-search-modal-lg"><i
                        :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
                    <button type="button" :class="btn_trans.save.class"><i
                        :class="btn_trans.save.icon"></i>
                        {{ btn_trans.save.text }}
                    </button>
                    <button type="button" :class="btn_trans.calculateManufacturing.class"><i
                        :class="btn_trans.calculateManufacturing.icon"></i>
                        {{ btn_trans.calculateManufacturing.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>วางแผนการผลิตยาเส้นภูมิภาค</h5>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="">
                                ปีงบประมาณ
                            </label>
                            <div class="col-lg-7">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="">
                                ประมาณการขายยาเส้นประจำเตือน
                            </label>
                            <div class="col-lg-7">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="">
                                ปักษ์ที่
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                            <label class="col-lg-1 col-form-label" for="">
                                ครั้งที่
                            </label>
                            <div class="col-lg-2">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="">
                                Version
                            </label>
                            <div class="col-lg-7">
                                <input class="form-control" type="number" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                หน่วยงาน
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                วันที่ผลิต
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" autocomplete="off" disabled>
                            </div>
                            <label class="col-lg-1 col-form-label" for="">
                                ถึง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 20px 8px 15px">
                        <div class="row align-items-center">
                            <div class="col-lg-6 align-middle">
                                <h5>รายละเอียดแผนยาเส้น</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <button type="button" :class="btn_trans.productionOrder.class"><i
                                        :class="btn_trans.productionOrder.icon"></i>
                                        {{ btn_trans.productionOrder.text }}
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
                                        <div>
                                            <label>
                                                <input class="align-middle" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </th>
                                    <th style="min-width:100px">
                                        ตราบุหรี่
                                    </th>
                                    <th style="min-width:150px">
                                        รหัสสินค้า
                                    </th>
                                    <th style="min-width:250px">
                                        รายละเอียด
                                    </th>
                                    <th style="min-width:150px">
                                        ประมาณการจำหน่าย
                                    </th>
                                    <th style="min-width:70px">
                                        หน่วยนับ
                                    </th>
                                    <th>
                                        จำนวนซอง
                                    </th>
                                    <th style="min-width:70px">
                                        หน่วยนับ
                                    </th>
                                    <th style="min-width: 150px;">
                                        จำนวนที่ต้องผลิต
                                    </th>
                                    <th style="min-width:70px">
                                        หน่วยนับ
                                    </th>
                                    <th style="min-width: 150px;">
                                        เลขที่คำสั่งการผลิต
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <label>
                                                <input class="align-middle" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="col-readonly">Line</td>
                                    <td class="col-readonly">10060198</td>
                                    <td>ยาเส้นปรุง Blend No.19</td>
                                    <td class="col-readonly">1700</td>
                                    <td class="col-readonly">CS</td>
                                    <td class="col-readonly">204,000.00</td>
                                    <td class="col-readonly">PTN</td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text"
                                                   class="form-control input-field number">
                                        </label>
                                    </td>
                                    <td class="col-readonly">KG</td>
                                    <td class="col-readonly">64-4-BB001</td>
                                </tr>
                                <!-- end row1 -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        modal search-->
        <div class="modal fade bd-search-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>ค้นหา</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row pl-4">
                                    <label class="col-form-label" for="">
                                        ปีงบประมาณ
                                    </label>
                                    <div class="col-lg-2">
                                        <select class="form-control m-b" name="account">
                                            <option>2564</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-3 col-form-label" for="" style="padding: 7px">
                                        ประมานการขายยาเส้นประจำเดือน
                                    </label>
                                    <div class="col-lg-3">
                                        <select class="form-control m-b" name="account">
                                            <option>พฤศจิกายน</option>
                                        </select>
                                    </div>
                                    <label class="col-form-label" for="">
                                        ปักษ์ที่
                                    </label>
                                    <div class="col-lg-2">
                                        <select class="form-control m-b" name="account">
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-right pr-4">
                                    <button type="button" :class="btn_trans.search.class"><i
                                        :class="btn_trans.search.icon"></i>
                                        {{ btn_trans.search.text }}
                                    </button>
                                </div>
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
    data() {
        return {}
    },
}
</script>
<style scoped>
label.col-lg-1.col-form-label {
    padding: 2px;
}

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
