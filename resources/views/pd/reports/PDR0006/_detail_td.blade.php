<td width="60px;" style="min-width: 60px; max-width: 60px;" valign="top">
    <div style="text-align: right;">
        @if ($approvedDate)
            <div style='font-size:30px; line-height: 9px; padding-top: 7px;'>&#8594;</div>
        @endif
    </div>
    <div style="text-align: right;">
        {{ $approvedDate  }}
    </div>
</td>
<td width="50px;" style="min-width: 50px; max-width: 50px;"  valign="top">
    <div style="text-align: left;">
        {{ $lineMedicinalLeafGroup   }}
    </div>
    <div style="text-align: left;">
        {{ $yearEdge }} {{ $lotNumber }}&nbsp;
    </div>
</td>
<td width="30px;" style="min-width: 30px; max-width: 30px; text-align: left;"  valign="top" >
    {{ $quantityPercent  }}
</td>


{{-- <td width="90px;">
    <div style="text-align: right;">
        <div style='font-size:30px; line-height: 9px; padding-top: 7px;'>&#8594;</div>
    </div>
    <div style="text-align: right;">
        {{ $col->approved_date }}
    </div>
</td>
<td width="90px;">
    <div style="text-align: left;">
        {{ $col->line_medicinal_leaf_group }}
    </div>
    <div style="text-align: left;">
        {{ $col->year_edge }} {{ $col->lot_number }}&nbsp;
    </div>
</td>
<td width="90px;" valign="top" style="text-align: left;">
    {{ $col->quantity_percent }}
</td> --}}