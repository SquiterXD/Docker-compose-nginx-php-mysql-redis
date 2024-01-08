
<table class="table">
    <thead>
            <tr>
                <th colspan="10" align="left" style=" border-bottom: 1px solid #464DD5" ></th>
            </tr>
                <tr style="border-top: 1px solid #464DD5; margin: 0px; padding: 0px">
                    <td align="center">สถานที่ - ยี่ห้อ</td>
                    <td align="center"> ทะเบียน</td>
                    <td align="center"> ระยะเวลาเอาประกัน ตั้งแต่ - สิ้นสุด</td>
                </tr>
            <tr>
                <th style="border-top: 1px solid #464DD5" colspan="10" ></th>
            </tr>
                @foreach ($vehicles->groupBy('department_name') as $element)
                    @foreach ($element as $vehicle)
                        <tr>
                            <td>{{ $vehicle->department_name }}</td>
                        </tr> 
                            @foreach ($element->groupBy('vehicle_type_name') as $lines)
                                @foreach ($lines as $line)
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $line->vehicle_type_name }}</td> 
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $line->vehicle_brand_name }}</td> 
                                        <td align="center">{{ $line->license_plate }}</td> 
                                        <td align="center">{{ $line->start_date }} - {{ $line->end_date }}</td> 
                                    </tr>
                                @endforeach
                            @endforeach
                    @endforeach
                @endforeach
    </tbody>
    </table>
