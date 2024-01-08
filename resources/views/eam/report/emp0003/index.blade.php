<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $programCode }} - {{ $progTitle }}</title>
    @include('eam.report.emp0003._style')
</head>

<body>
        <table width="3800px">
            <thead>
                <tr>
                    <th class="foot" colspan="{{$m['Week']+3}}">
                        <h1>แผนงานการบำรุงรักษาเครื่องจักร (Planned Maintenance)</h1>
                    </th>
                </tr>
                <tr>
                    <th class="foot" colspan="{{$m['Week']+3}}">
                        <h1>ปีงบประมาณ {{$tyear}}</h1>
                    </th>
                </tr>
                <tr>
                    <th class='h_col' rowspan="2">ลำดับ</th>
                    <th class="w400" rowspan="2">เครื่องจักร</th>
                    <th class='h_col'>เดือน</th>
                    @for ($i=1; $i<=12; $i++) @if($i<=12) <th class='h_col' colspan="{{ $m[$i]['span'] }}">{{ $m[$i]['d'] }}</th>
                        @else
                        <td></td>
                        @endif
                        @endfor
                </tr>
                <tr>
                    <th class='h_col'>สัปดาห์</th>
                    @for ($i=1; $i<=12; $i++) @if($i<=12) @for ($s=1; $s<=$m[$i]['span']; $s++) @if($m[$i]['w']=='52' ) @php if($m[$i]['w']+$s-1==52){ echo "<th class='h_col'>52</th>" ; } else { $t=$m[$i]['w']+$s-1-52; echo "<th class='h_col'>" .$t."</th>";
                        }
                        @endphp
                        @elseif($m[$i]['w']=='53')
                        @php
                        if($m[$i]['w']+$s-1==53){
                        echo "<th class='h_col'>53</th>";
                        } else {
                        $t=$m[$i]['w']+$s-1-53;
                        echo "<th class='h_col'>".$t."</th>";
                        }
                        @endphp
                        @else
                        <th class='h_col'>{{ $m[$i]['w']+$s-1 }}</th>
                        @endif
                        @endfor
                        @else
                        <td></td>
                        @endif
                        @endfor
                </tr>

            </thead>
            <tbody>
                @foreach ($data->groupBy('department_desc') as $depart => $asset)
                <tr>
                    <th class="g-head" colspan="3">{{ $depart }}</th>
                    @for($i=0; $i<=$m['Week']-1; $i++) @php if(($m[1]['w']+$i)<=$m['Week']){ $week=$m[1]['w']+$i; }else{ $week=$m[1]['w']+$i-$m['Week']; }; $r="" ; foreach($hol as $h){ if($week==$h->w){
                        $r="*";
                        }
                        }
                        @endphp

                        @if($i==$m['Week']-1)
                        <th class="g-head"></th>
                        @else
                        <th class="g-head">{{$r ?? ''}}</th>
                        @endif
                        @endfor
                </tr>
                   @foreach($asset->groupBy('asset_number') as $lines => $line )
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th colspan="2" class="desc">{{$line[0]->asset_desc}}</th>
                            
                            @foreach($line as $l)
                                @php
                                    $d_start[$loop->iteration]=$l->d_start;
                                    $d_comp[$loop->iteration]=$l->d_comp;
                                    $status[$loop->iteration]=$l->status_desc;
                                    $strplan[$loop->iteration]=$l->plan_str;
                                    $count=$loop->count;
                                @endphp
                            @endforeach

                            @php
                                for($i=0; $i<=$m['Week']-1; $i++){

                                    if(($m[1]['w']+$i)<=$m['Week']){
                                        $week=$m[1]['w']+$i;
                                    } else {
                                        $week=$m[1]['w']+$i-$m['Week'];
                                    }
                                    
                                    $ck[$week]=array();
                                    $bg[$week]=array();
                                    $ds[$week]=array();

                                    for($ii=1; $ii<=$count; $ii++){
                                        $s=$d_start[$ii];
                                        $c=$d_comp[$ii];
                                        $sts=$status[$ii];
                                        $str=$strplan[$ii];

                                        if($s>$c){
                                            $c2=$c+$m['End'];
                                            if($week<$s){ 
                                                $s2=$s-$m['End'];
                                                if($week>=$s2 && $week<=$c){ 
                                                    $ck[$week]=$week; 
                                                    if($sts=="complete"){ $bg[$week]="bgcolor='#088717'";} else { $bg[$week]="bgcolor='#2BB9FE'"; }
                        
                                                } 
                                            }else{ 
                                                if($week>=$s && $week<=$c2){ 
                                                    $ck[$week]=$week; 
                                                    if($sts=="complete"){ $bg[$week]="bgcolor='#088717'";} else { $bg[$week]="bgcolor='#2BB9FE'"; }
                                                    
                                                } 
                                            } 
                                        }else{ 
                                            if($week>=$s && $week<=$c){ 
                                                $ck[$week]=$week; 

                                                if($sts=="complete"){ $bg[$week]="bgcolor='#088717'";} else { $bg[$week]="bgcolor='#2BB9FE'"; }
                                               
                                            } 
                                        } 

                                        $t=$c+1;
                                        if($t>$m['End']){$t=1;}
                                        if($week==$t){ $ds[$week]=$str; }
                                    } 

                                    if($ck[$week]){
                                        echo "<td $bg[$week] ></td>";
                                    } else {
                                        if($ds[$week]){
                                            echo "<td>{$ds[$week]}</td>";    
                                        } else {
                                            echo "<td></td>";
                                        }
                                    }

                                }    
                            @endphp 
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr class="foot">
                    <th class="foot" colspan="{{$m['Week']+4}}"></th>
                </tr>
                <tr class="foot">
                    <th class="foot" colspan="{{$m['Week']+4}}"></th>
                </tr>
                <tr class="foot">
                    <th class="foot"></th>
                    <th class="foot" colspan="2">
                        <h2>หมายเหตุ</h2>
                    </th>
                    <th class="foot">
                        <h2>*</h2>
                    </th>
                    <th class="foot" colspan="7">
                        <h2 style="text-align:left;">&nbsp;&nbsp;- สัปดาห์ที่มีวันหยุดระหว่างสัปดาห์</h2>
                    </th>
                    <th class="foot" colspan="30">
                        <h1 style="text-align:center;" >( {{ $user[0]->name }} )</h1>
                    </th>
                </tr>
                <tr class="foot">
                    <th class="foot"></th>
                    <th class="foot" colspan="2"></th>
                    <th class="foot" bgcolor="#2BB9FE"></th>
                    <th class="foot" colspan="7">
                        <h2 style="text-align:left;">&nbsp;&nbsp;- กำหนดการบำรุงรักษาตามแผน</h2>
                    </th>
                    <th class="foot" colspan="30">
                        <h1 style="text-align:center;" >ผู้จัดทำแผนงาน</h1>
                    </th>
                </tr>
                <tr class="foot">
                    <th class="foot"></th>
                    <th class="foot" colspan="2"></th>
                    <th class="foot" bgcolor="#088717"></th>
                    <th class="foot" colspan="7">
                        <h2 style="text-align:left;">&nbsp;&nbsp;- การบำรุงรักษาแล้วเสร็จ</h2>
                    </th>
                    <th class="foot" colspan="30">
                        <h1 style="text-align:center;" >{{ $date }}</h1>
                    </th>
                </tr>
                <tr class="foot">
                    <th class="foot" colspan="{{$m['Week']+4}}"></th>
                </tr>
                <tr class="foot">
                    <th class="foot" colspan="{{$m['Week']+4}}"></th>
                </tr>
            </tfoot>
        </table>
</body>

</html>