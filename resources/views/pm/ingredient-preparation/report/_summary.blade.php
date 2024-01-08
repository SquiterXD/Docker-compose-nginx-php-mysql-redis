{{-- <div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ลำดับที่</th>
                <th>รหัสวัตถุดิบ</th>
                <th style="width: 400px;">รายละเอียด</th>
                <th>จำนวนต่อวัน</th>
                <th>หน่วย</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataLists as $index => $datas)
                <tr>
                    <td colspan="6" class="text-center"><b>{{ $index }}</b></td>
                </tr>
                @foreach ($datas as $data)
                    @if ($hasM05Data)
                        @php
                            if ($data->b_m05 > 0) {
                                $totalCal = $data->b - $data->b_m05;
                            } else {
                                $totalCal = $data->b;
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->item_number }}</td>
                            <td>{{ $data->description }}</td>
                            <td class="text-right">{{ number_format(ceil($totalCal)) }}</td>
                            <td class="text-center">{{ $data->unit_of_measure }}</td>
                        </tr> 
                    @else
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->item_number }}</td>
                            <td>{{ $data->description }}</td>
                            <td class="text-right">{{ number_format(ceil($data->b)) }}</td>
                            <td class="text-center">{{ $data->unit_of_measure }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</div> --}}

<div>
    @foreach ($dataLists as $index => $datas)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ลำดับที่</th>
                    <th>รหัสวัตถุดิบ</th>
                    <th style="width: 400px;">รายละเอียด</th>
                    <th>จำนวนต่อวัน</th>
                    <th>หน่วย</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center"><b>{{ $index }}</b></td>
                </tr>
                @foreach ($datas as $data)
                    @if ($hasM05Data)
                        @php
                            if ($data->b_m05 > 0) {
                                $totalCal = $data->b - $data->b_m05;
                            } else {
                                $totalCal = $data->b;
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->item_number }}</td>
                            <td>{{ $data->description }}</td>
                            <td class="text-right">{{ number_format(ceil($totalCal)) }}</td>
                            <td class="text-center">{{ $data->unit_of_measure }}</td>
                        </tr> 
                    @else
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->item_number }}</td>
                            <td>{{ $data->description }}</td>
                            <td class="text-right">{{ number_format(ceil($data->b)) }}</td>
                            <td class="text-center">{{ $data->unit_of_measure }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="page-break"></div>
    @endforeach
</div>