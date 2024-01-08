<br><div class="row col-lg-12">
    <div class="col-md-7" style="font-size: 16px; text-align: left;">
        <div style="margin-bottom: 10px;"> PO_509 </div>
        <div> </div>
        <div> </div>
    </div>
    <div class="col-md-5" style="font-size: 16px; text-align: right;">
        <div style="margin-bottom: 10px;">
            เลขที่ &nbsp; {{ $header->pr_number }} &nbsp;&nbsp;&nbsp; พิมพ์วันที่ {{ date('d-M-Y') }} &nbsp; เวลา {{ date('H:i') }}
        </div>
        <div style="margin-bottom: 10px;"> วันที่ : {{ date('d-M-Y', strtotime($header->pr_creation_date)) }} &nbsp;&nbsp;&nbsp; หน้า 1 ของ 1</div>
    </div>
</div>
