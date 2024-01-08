<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            {{-- <tr>
                <th>Document Code</th>
                <th>คำอธิบาย</th>
                <th>โครงสร้าง Running number</th>
                <th>เลขล่าสุด</th>
                <th class="text-center">Active</th>
                <th>วันที่เริ่มใช้งาน</th>
                <th>วันที่สิ้นสุด</th>
                <th></th>
            </tr> --}}
            <tr>
                <th>
                    <div style="width: 110px;">Document Code</div>
                </th>
                <th>
                    <div style="width: 150px;">คำอธิบาย</div>
                </th>
                <th>
                    <div style="width: 180px;">โครงสร้าง Running number</div>
                </th>
                <th>
                    <div style="width: 70px;">เลขล่าสุด</div>
                </th>
                <th class="text-center">
                    <div style="width: 50px;">Active</div>
                </th>
                <th class="text-center">
                    <div style="width: 100px;">วันที่เริ่มใช้งาน</div>
                </th>
                <th class="text-center">
                    <div style="width: 70px;">วันที่สิ้นสุด</div>
                </th>
                <th>
                    <div style="width: 70px;"></div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($headers as $header)
                <tr>
                    <td>{{ $header->doc_seq_code }}</td>
                    <td>{{ $header->doc_seq_description }}</td>
                    <td>{{ $header->format_combine }}</td>
                    <td>{{ $header->last_number }}</td>
                    <td align="center">
                        @include('shared._status_active', ['isActive' =>  $header->active_flag == 'Y' ])
                    </td>
                    <td align="center"> {{ $header->start_date ? date(trans('date.format'), strtotime($header->start_date)) : '' }} </td>
                    <td align="center"> {{ $header->end_date   ? date(trans('date.format'), strtotime($header->end_date))   : '' }} </td>
                    <td>
                        <a href="{{ route('running-number.edit', $header->doc_seq_header_id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $headers->links() }}
</div>

{{-- <div align="right">
    {{ $headers->links() }}
</div> --}}