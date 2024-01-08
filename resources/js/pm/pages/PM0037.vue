<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.print.class"><i
                        :class="btn_trans.print.icon"></i>
                        {{ btn_trans.print.text }}
                    </button>
                    <button type="button" :class="btn_trans.add.class"><i
                        :class="btn_trans.add.icon"></i>
                        {{ btn_trans.add.text }}
                    </button>
                    <button type="button" :class="btn_trans.save.class"><i
                        :class="btn_trans.save.icon"></i>
                        {{ btn_trans.save.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>รายการจัดเตรียมวัตถุดิบ</h5>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 ">
                        <div class="form-group row mt-3">
                            <label class="col-lg-2 col-form-label" for="">
                                วันที่
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" autocomplete="off">
                            </div>

                            <label class="col-lg-2 col-form-label" for="">
                                เลขที่ใบเบิก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="tr-header">
                                    <th width="6%">
                                        ลำดับที่
                                    </th>
                                    <th width="10%">
                                        รหัสวัตถุดิบ
                                    </th>
                                    <th width="30%">
                                        รายละเอียด
                                    </th>
                                    <th width="10%">
                                        จำนวนที่ใช้ต่อวัน<br>(ระบบแนะนำ)
                                    </th>
                                    <th>
                                        หน่วยนับ
                                    </th>
                                    <th width="10%">
                                        จำนวนที่ขอเบิกจากกองซ่อม
                                    </th>
                                    <th>
                                        หน่วยเบิก
                                    </th>
                                    <th>
                                        เครื่อง
                                    </th>
                                    <th>
                                        Brand
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--  row ซองบุหรี่ -->
                                <tr>
                                    <td class="text-center" colspan="7">ซองบุหรี่</td>
                                    <td class="" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="col-readonly">1</td>
                                    <td class="col-readonly text-left">1101R0005</td>
                                    <td class="col-readonly text-left">WHITE TIPPING BASE PAPER 34 GSM SIZE 570 mm.
                                        x 8,500 mm
                                    </td>
                                    <td class="col-readonly">100</td>
                                    <td class="col-readonly">ROL</td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>ROL</option>
                                            </select>
                                        </label>
                                    </td>
                                    <td class="col-readonly">
                                        BOBST1
                                    </td>
                                    <td class="col-readonly">
                                        SMS แดง
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-readonly">2</td>
                                    <td class="col-readonly text-left">1101R0005</td>
                                    <td class="col-readonly text-left">WHITE TIPPING BASE PAPER 34 GSM SIZE 570 mm.
                                        x 8,500 mm
                                    </td>
                                    <td class="col-readonly">100</td>
                                    <td class="col-readonly">ROL</td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>KG</option>
                                            </select>
                                        </label>
                                    </td>
                                    <td class="col-readonly">
                                        BOBST1
                                    </td>
                                    <td class="col-readonly">
                                        SMS แดง
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-readonly">3</td>
                                    <td class="col-readonly text-left">1101R0005</td>
                                    <td class="col-readonly text-left">WHITE TIPPING BASE PAPER 34 GSM SIZE 570 mm.
                                        x 8,500 mm
                                    </td>
                                    <td class="col-readonly">100</td>
                                    <td class="col-readonly">ROL</td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>KG</option>
                                            </select>
                                        </label>
                                    </td>
                                    <td class="col-readonly">
                                        BOBST1
                                    </td>
                                    <td class="col-readonly">
                                        SMS แดง
                                    </td>
                                </tr>

                                <!--  row ซองบุหรี่ -->
                                <!-- end row กระดาษพันก้นกรอง-->
                                <tr>
                                    <td class="text-center" colspan="7">กระดาษพันก้นกรอง</td>
                                    <td class="" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="col-readonly">1</td>
                                    <td class="col-readonly text-left">1101P0033</td>
                                    <td class="col-readonly text-left">กระดาษอาร์ตการ์ดมันหน้าเดียวสีขาว</td>
                                    <td class="col-readonly">2000</td>
                                    <td class="col-readonly">ROL</td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>KG</option>
                                            </select>
                                        </label>
                                    </td>
                                    <td class="col-readonly">
                                        BOBST1
                                    </td>
                                    <td class="col-readonly">
                                        SMS แดง
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-readonly">2</td>
                                    <td class="col-readonly text-left">1101P0033</td>
                                    <td class="col-readonly text-left">กระดาษอาร์ตการ์ดมันหน้าเดียวสีขาว</td>
                                    <td class="col-readonly">2000</td>
                                    <td class="col-readonly">ROL</td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="">
                                        <div class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>KG</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="col-readonly">
                                        BOBST1
                                    </td>
                                    <td class="col-readonly">
                                        SMS แดง
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-readonly">3</td>
                                    <td class="col-readonly text-left">1101P0033</td>
                                    <td class="col-readonly text-left">กระดาษอาร์ตการ์ดมันหน้าเดียวสีขาว</td>
                                    <td class="col-readonly">2000</td>
                                    <td class="col-readonly">ROL</td>
                                    <td class="">
                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="">
                                        <div class="label-input col-lg-12 pl-0 pr-0">
                                            <select class="form-control select-field" name="account">
                                                <option>ROL</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="col-readonly">
                                        BOBST1
                                    </td>
                                    <td class="col-readonly">
                                        SMS แดง
                                    </td>
                                </tr>
                                <!-- end กระดาษพันก้นกรอง -->
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
input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

select.form-control.select-field {
    border: none;
}

select.form-control.select-field:focus {
    outline: 1px solid #1ab394;
}
</style>
