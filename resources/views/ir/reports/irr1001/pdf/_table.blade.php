
<table class="table">
    <thead>

      @foreach ($ptirStockHeader->groupBy('sub_inventory_desc')->sortBy('sub_inventory_code') as $subInvDes => $subInvs)
        @foreach ($subInvs->groupBy('location_desc')->sortBy('lcation_code') as $locationDesc => $lines)
            <tr>
                <th colspan="9" align="left"><b> รหัสคลังสินค้า : {{  $subInvDes }}</b> </th>
                <th></th>
            </tr>
            <tr>
                <th colspan="10" align="left" ><b>กลุ่มสินค้าย่อย :{{ $locationDesc }}</b>  </th>
            </tr>
            <tr>
                <th colspan="10" align="left" style=" border-bottom: 1px solid #464DD5" ></th>
            </tr>
                <tr style="border-top: 1px solid #464DD5; margin: 0px; padding: 0px">
                    <td align="center"> รหัสพัสดุ</td>
                    <td align="center"> ชื่อพัสดุ</td>
                    <td align="center"> Organization</td>
                </tr>
            <tr>
                <th style="border-top: 1px solid #464DD5" colspan="10" ></th>
            </tr>
            {{-- <hr class="p-0 m-0"> --}}
                @foreach ($lines as $line)
                    <tr>
                        <td>{{ $line->item_code }} {{ $line->line_id  }} {{   $line->status }}</td>
                        <td>{{ $line->item_description }}</td>
                        <td>{{ $line->organization_code}} :  {{ $line->lineView->organization_name }}</td>
                    </tr>
                @endforeach                    
            @endforeach
      @endforeach
    </tbody>
    </table>
