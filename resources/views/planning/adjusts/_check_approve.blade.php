<h4 class="text-center text-warning">
    แจ้งเตือนปัจจุบันปักษ์นี้มีการอนุมัตในระบบแล้ว
</h4>

<h5  class="text-center text-warning">หากกดปุ่ม ตกลง ระบบ จะทำการอัพเดทปักษ์ดังนี้เป็น Inactive </h5>
<table class="table" style="font-size: 13px;">
    <thead>
        <tr>
            <th class="text-left">รายละเอียด</th>
            <th width="30%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $productBiweekly)
            <tr>
                <td class="text-left">
                    <div >
                        <strong>ปีงบประมาณ:</strong>
                        <span class="text-muted">{{ $productBiweekly->ppBiWeekly->thai_year }}</span>
                    </div>
                    <div >
                        <strong>ปักษ์ที่:</strong>
                        <span class="text-muted">{{ $productBiweekly->ppBiWeekly->biweekly }}</span>
                    </div>
                    <div >
                        <strong>ครั้งที่:</strong>
                        <span class="text-muted">{{ $productBiweekly->version_no }}</span>
                    </div>
                    <div >
                        <strong>ประจำเดือน:</strong>
                        <span class="text-muted">{{ $productBiweekly->thai_month }}</span>
                    </div>
                    <div >
                        <strong>วันที่สร้าง:</strong>
                        <span class="text-muted">{{ $productBiweekly->created_at_format }}</span>
                    </div>
                    <div >
                        <strong>วันที่อนุมัติ:</strong>
                        <span class="text-muted">{{ $productBiweekly->approved_at_format }}</span>
                    </div>
                </td>
                <td>
                    <a target="_blank" href="{{ route('planning.production-biweekly.show', $productBiweekly->product_main_id) }}" class="btn-lg tw-w-25 {{ trans('btn.detail.class') }}">
                        <i class="{{ trans('btn.detail.icon') }}"></i>
                        {{ trans('btn.detail.text') }}
                    </a>
                </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
