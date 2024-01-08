<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.rawMaterial.class" @click.prevent="confirm"><i
                        :class="btn_trans.rawMaterial.icon"></i>
                        {{ btn_trans.rawMaterial.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h4>แจ้งเตือนปริมาณคงคลังวัตถุดิบ</h4>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 pt-3">
                                <div class="form-group row">
                                    <label class="col-form-label pl-3 pr-3">วันที่:</label>
                                    <div class="col-lg-6">
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="header">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </th>
                                    <th class="header" style="min-width: 150px;">รหัสวัตถุดิบ</th>
                                    <th class="header" style="min-width: 250px;">รายละเอียด</th>
                                    <th class="header">คงคลัง</th>
                                    <th class="header">ปริมาณจัดเก็บต่ำสุด</th>
                                    <th class="header">ปริมาณเฝ้าระวังต่ำสุด</th>
                                    <th class="header">จำนวนที่ต้องการเบิก<strong style="color: red">*</strong></th>
                                    <th class="header">หน่วยนับ</th>
                                    <th class="header">ใบเบิกวัตถุดิบ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </th>
                                    <td class="col-readonly">100400027</td>
                                    <td class="col-readonly">PROPYLENE GLYCOL</td>
                                    <td class="col-readonly">71.80</td>
                                    <td class="col-readonly">50.00</td>
                                    <td class="col-readonly">1,000.00</td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">KG</td>
                                    <td class="col-readonly">55-3100M-0001</td>
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
    methods: {
        confirm() {
            swal({
                title: 'ยืนยันการเบิกวัตถุดิบ',
                text: "<span style=\"font-size:16px\">Item 100400027:PROPYLENE GLYCOL จำนวน 860 KG<br>" +
                    "Item 100400027:แอลกอฮอล์(เครื่องปรุง) จำนวน 800 KG",
                html: true,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ED5565',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            })
        }
    },
}
</script>

<style scoped>
.col-readonly {
    background: #e9ecef42 !important;
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

.check-center {
    text-align: center;
}

.swal-text {
    font-size: 16px;
}
</style>
