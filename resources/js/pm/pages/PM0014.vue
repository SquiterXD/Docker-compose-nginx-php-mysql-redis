<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h5>ปิดคำสั่งการผลิต(ใบยา)</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="select1">แผนการผลิตประจำปีงบประมาณ:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control m-b" name="select1" id="select1">
                                            <option>2563</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="select2">ประจำเดือน:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control m-b" name="select2" id="select2">
                                            <option>พฤศจิกายน</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="select3">ปักษ์ที่:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control m-b" name="select3" id="select3">
                                            <option>4</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="input1">วันที่:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input1" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th style="min-width: 150px;">Job Number</th>
                                    <th style="min-width: 150px;">Blend No.</th>
                                    <th>ปริมาณที่ต้องผลิต</th>
                                    <th>หน่วยนับ</th>
                                    <th>สถานะคำสั่งการผลิต</th>
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
                                    <td class="col-readonly">63-4-0001</td>
                                    <td class="col-readonly">17</td>
                                    <td class="col-readonly">4875.00</td>
                                    <td class="col-readonly">KG</td>
                                    <td class="col-readonly"><a data-toggle="modal" href="#modal-form">Ready to
                                        close</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form role="form">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>OPT</th>
                                                            <th>Transaction</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td class="col-readonly">17/50</td>
                                                            <td class="col-readonly">ตัดใช้วัตถุดิบ</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-readonly">17/50</td>
                                                            <td class="col-readonly">บันทึกผลผลิตเข้าคลัง</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:tw-text-center">
                            <button type="button" :class="btn_trans.closeJob.class"><i
                                :class="btn_trans.closeJob.icon"></i>
                                {{ btn_trans.closeJob.text }}
                            </button>
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
th,
td {
    vertical-align: middle !important;
    text-align: center;

}

.col-readonly {
    background: #e9ecef42 !important;
}

.check-center {
    text-align: center;
}
</style>
