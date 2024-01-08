<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h5>วางแผนผลิตยาเส้นพองประจำปักษ์</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="select1">แผนการผลิตยาเส้นประจำปี:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control m-b" name="account" id="select1" disabled>
                                            <option>พฤศจิกายน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="select2">ปักษ์ที่:</label>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <select class="form-control m-b" name="account" id="select2" disabled>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="select3">ครั้งที่:</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="input1">วันที่:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input1" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="input2">แผนการผลิตยาเส้นพองครั้งที่:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input2" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" :class="btn_trans.detailTobacco.class" data-toggle="modal"
                                    data-target="#detailModal"><i
                                :class="btn_trans.detailTobacco.icon"></i>
                                {{ btn_trans.detailTobacco.text }}
                            </button>
                            <button type="button" :class="btn_trans.calculateTobacco.class"><i
                                :class="btn_trans.calculateTobacco.icon"></i>
                                {{ btn_trans.calculateTobacco.text }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="header" style="min-width: 150px;">Job Number</th>
                                    <th class="header" style="min-width: 150px">รหัสสินค้า</th>
                                    <th class="header" style="min-width: 300px">รายละเอียด</th>
                                    <th class="header">ปริมาณคงคลัง</th>
                                    <th class="header">หน่วยนับ</th>
                                    <th class="header">ปริมาณที่ต้องผลิต</th>
                                    <th class="header">ปริมาณที่ควรผลิต</th>
                                    <th class="header">หน่วยนับ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-readonly">63-6E000-0001</td>
                                    <td class="col-readonly">100730EL</td>
                                    <td class="col-readonly">EL(ยาเส้นพอง โรจนะ)</td>
                                    <td class="col-readonly">2000</td>
                                    <td class="col-readonly">KG</td>
                                    <td class="col-readonly">34,770.59</td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">KG</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="button" :class="btn_trans.sentMes.class"><i
                                :class="btn_trans.sentMes.icon"></i>
                                {{ btn_trans.sentMes.text }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        modal search-->
        <div class="modal fade" id="detailModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">รายละเอียดแผนยาเส้นประจำปักษ์</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-header" style="display:none;">
                        <h5 class="modal-title"></h5>
                        <button ref="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="col-lg-12 col-sm-12 pl-0 pt-2 pb-2">
                                <div class="form-group row pl-3">
                                    <label class="col-lg-2 col-sm-6 col-form-label" for="innput23">
                                        ปีงบประมาณ<strong style="color: red">*</strong></label>
                                    <div class="col-lg-2">
                                        <select class="form-control m-b" name="account" disabled>
                                            <option>2564</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row pl-3">
                                    <label class="col-lg-2 col-sm-6 col-form-label" for="innput25">
                                        แผนผลิตบุหรี่ประจำเดือน<strong style="color: red">*</strong>
                                    </label>
                                    <div class="col-lg-2">
                                        <select class="form-control" name="account" disabled>
                                            <option>พฤศจิกายน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row pl-3">
                                    <label class="col-lg-2 col-sm-6 col-form-label" for="innput25">
                                        ปักษ์ที่<strong style="color: red">*</strong>
                                    </label>
                                    <div class="col-lg-2">
                                        <select class="form-control" name="account" disabled>
                                            <option>4</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-1 col-form-label" for="innput25">
                                        ครั้งที่
                                    </label>
                                    <div class="col-lg-1 pl-0">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row pl-3">
                                    <label class="col-lg-2 col-sm-6 col-form-label" for="innput25">
                                        วันที่
                                    </label>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row pl-3">
                                    <label class="col-lg-2 col-sm-6 col-form-label" for="innput25">
                                        แผนการผลิตยาเส้นครั้งที่
                                    </label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="3"></th>
                                    <th rowspan="3" style="width: 250px;">ขอบเขตเครื่องจักร</th>
                                    <th style="width: 250px;"></th>
                                    <th style="width: 250px;">16-Nov-20</th>
                                    <th style="width: 250px;">17-Nov-20</th>
                                    <th style="width: 250px;">18-Nov-20</th>
                                    <th style="width: 250px;">19-Nov-20</th>
                                    <th style="width: 250px;">20-Nov-20</th>
                                    <th style="width: 250px;">21-Nov-20</th>
                                    <th style="width: 250px;">22-Nov-20</th>
                                    <th style="width: 250px;">23-Nov-20</th>
                                    <th style="width: 250px;">24-Nov-20</th>
                                    <th style="width: 250px;">25-Nov-20</th>
                                    <th style="width: 250px;">26-Nov-20</th>
                                    <th style="width: 250px;">27-Nov-20</th>
                                    <th style="width: 250px;">28-Nov-20</th>
                                    <th style="width: 250px;">29-Nov-20</th>
                                    <th style="width: 250px;">30-Nov-20</th>
                                </tr>
                                <tr>
                                    <th class="number"></th>
                                    <th class="number">9</th>
                                    <th class="number">13</th>
                                    <th class="number">13</th>
                                    <th class="number">0</th>
                                    <th class="number">0</th>
                                    <th class="number">0</th>
                                    <th class="number">0</th>
                                    <th class="number">9</th>
                                    <th class="number">9</th>
                                    <th class="number">9</th>
                                    <th class="number">9</th>
                                    <th class="number">9</th>
                                    <th class="number">0</th>
                                    <th class="number">0</th>
                                    <th class="number">9</th>
                                </tr>
                                <tr>
                                    <th>หัวจ่าย</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-readonly number" rowspan="2">1</td>
                                    <td class="col-readonly number" rowspan="2">F6-L1(P 90 E No. 1-2&G.D.121No.3-4)</td>
                                    <td class="col-readonly number" rowspan="2">FD.1</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                    <td class="col-readonly number">99</td>
                                </tr>
                                <tr>
                                    <td class="col-readonly number">10641.4</td>
                                    <td class="col-readonly number">15584.80</td>
                                    <td class="col-readonly number">15584.80</td>
                                    <td class="col-readonly number"></td>
                                    <td class="col-readonly number"></td>
                                    <td class="col-readonly number"></td>
                                    <td class="col-readonly number"></td>
                                    <td class="col-readonly number">10641.4</td>
                                    <td class="col-readonly number">10641.4</td>
                                    <td class="col-readonly number">10641.4</td>
                                    <td class="col-readonly number">10641.4</td>
                                    <td class="col-readonly number">10641.4</td>
                                    <td class="col-readonly number"></td>
                                    <td class="col-readonly number"></td>
                                    <td class="col-readonly number">10641.4</td>
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
}
</script>
<style scoped>
th,
td {
    vertical-align: middle !important;
    text-align: center;
}

td.col-readonly.number {
    background: #e9ecef42 !important;
    text-align: right;
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

table.table.table-bordered {
    overflow-x: auto;
    white-space: nowrap;
}

th.number {
    text-align: right;
}

label.col-lg-1.col-form-label {
    padding: 6px 12px;
}
</style>
