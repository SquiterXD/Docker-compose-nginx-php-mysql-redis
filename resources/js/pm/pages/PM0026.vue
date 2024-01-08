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
                                    <button type="button" :class="btn_trans.create.class"><i
                                        :class="btn_trans.create.icon"></i>
                                        {{ btn_trans.create.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.save.class"><i
                                        :class="btn_trans.save.icon"></i>
                                        {{ btn_trans.save.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.print.class"><i
                                        :class="btn_trans.print.icon"></i>
                                        {{ btn_trans.print.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.confirmTransferToInventory.class"><i
                                        :class="btn_trans.confirmTransferToInventory.icon"></i>
                                        {{ btn_trans.confirmTransferToInventory.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-4 col-form-label">ใบส่งเลขที่:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-4 col-form-label">วันที่ได้ผลผลิต:</label>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-4 col-form-label">วันที่ส่งผลผลิต:</label>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-4 col-form-label">คลังสินค้า:</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-lg-3"><input type="text" class="form-control" disabled>
                                            </div>
                                            <div class="col-lg-4"><input type="text" class="form-control" disabled>
                                            </div>
                                            <label class="col-form-label">คลังย่อย:</label>
                                            <div class="col-lg-3"><input type="text" class="form-control" disabled>
                                            </div>

                                        </div>
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
                        <div class="text-right">
                            <button type="button" :class="btn_trans.save.class"><i
                                :class="btn_trans.save.icon"></i>
                                {{ btn_trans.save.text }}
                            </button>
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
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 4%;">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </th>
                                    <th style="width: 15%;">เลขที่คำสั่งผลิต</th>
                                    <th style="width: 15%;">รหัสสินค้าสำเร็จรูป</th>
                                    <th style="width: 30%;">รายละเอียด</th>
                                    <th style="width: 15%;">Lot No.</th>
                                    <th style="width: 15%;">จำนวน</th>
                                    <th style="width: 10%;">หน่วยนับ</th>
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
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">11030DGL015</td>
                                    <td class="col-readonly">กระดาษพันก้นกรองบุหรี่ SMS MENTHOL CHAMBON</td>
                                    <td class="col-readonly"></td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
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
th,
a td {
    vertical-align: middle !important;
    text-align: center;
}

.check-center {
    text-align: center;
}

label.label-input {
    margin-bottom: 0rem;
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

.ibox-title {
    padding: 15px 20px 8px 20px;
}
</style>
