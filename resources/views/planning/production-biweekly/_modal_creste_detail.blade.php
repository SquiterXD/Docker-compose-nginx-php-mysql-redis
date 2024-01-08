<div class="ibox-content ">
    @if ($saleForecast)
        <h4>อ้างอิงประมาณการจำหน่ายรายปักษ์ ฝ่ายขาย</h4>
        <div class="row">
            <div class="col-12">
                <dl class="row mb-0">
                    <div class="col-sm-3 text-sm-right">
                        <dt>ชื่อไฟล์ประมาณการจำหน่าย:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1"> {{ $saleForecast->file_name }}</dd>
                    </div>
                </dl>

                <dl class="row mb-0">
                    <div class="col-sm-3 text-sm-right">
                        <dt>ปักษ์ที่:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1"> {{ $saleForecast->biweekly_no }}</dd>
                    </div>
                </dl>

                <dl class="row mb-0">
                    <div class="col-sm-3 text-sm-right">
                        <dt>อัพโหลดเวอร์ชั่น:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1"> {{ $saleForecast->version }}</dd>
                    </div>
                </dl>

                <dl class="row mb-0">
                    <div class="col-sm-3 text-sm-right">
                        <dt>วันที่อนุมัติ:</dt>
                    </div>
                    <div class="col-sm-8 text-sm-left">
                        <dd class="mb-1"> {{ $saleForecast->approve_date_format }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    @else
        <div class="well">
            <h4 class="text-danger">ไม่พบข้อมูล ข้อมูลอ้างอิงประมาณการจำหน่ายรายปักษ์ของฝ่ายขาย</h4>
        </div>
    @endif
</div>

