<div class="table-responsive">
    <table class="table text-nowrap lookup_data_tb">
        <thead>            
            <tr>
                @if ($program->program_code == 'OMS0009')
                    <th>ลำดับที่</th>
                @endif
                @foreach ($programColumns as $programColumn)
                    <th class="text-center">{{ str_replace('_', ' ', $programColumn->column_prompt) }}</th>
                @endforeach
                @if (canEnter('/lookup?programCode='.$program->program_code))
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody> 
            @foreach ($lookups as $lookup)
                @php
                    if ($program->program_code == 'IRS0001' || $program->program_code == 'IRS0002' || $program->program_code == 'IRS0003' ||
                        $program->program_code == 'IRS0004' || $program->program_code == 'IRS0005' || $program->program_code == 'IRS0006' ||
                        $program->program_code == 'IRS0007' || $program->program_code == 'IRS0008' || $program->program_code == 'IRS0009') 
                    {
                        $irs = true;
                    } else {
                        $irs = false;
                    }
                @endphp
                <tr>   
                    @if ($program->program_code == 'OMS0009')   
                        <td>{{ $loop->iteration }}</td>     
                    @endif  
                    @foreach ($programColumns as $programColumn)
                        <lookup-table :program="{{ json_encode($program) }}"
                                    :program-column="{{ json_encode($programColumn) }}"
                                    :irs="{{ json_encode($irs) }}"
                                    :lookup="{{ json_encode($lookup) }}">
                        </lookup-table>
                    @endforeach

                        
                    {{-- @foreach ($programColumns as $programColumn) 
                        @if ($programColumn->column_name == 'ENABLED_FLAG')                            
                            <td class="text-center" style="vertical-align:middle;" data-sort="{{ $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y' ? true : false }}">
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td>
                        @elseif ($programColumn->column_name == 'TAG' && $program->program_code == 'OMS0022' || $programColumn->column_name == 'TAG' && $program->program_code == 'IRS0004' || $programColumn->column_name == 'TAG' && $program->program_code == 'IRS0007')
                            <td class="text-center" style="vertical-align:middle;" data-sort="{{ $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y' ? true : false }}">
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td>
                        @elseif ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'PPS0002')
                            <td class="text-center" style="vertical-align:middle;" data-sort="{{ $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y' ? true : false }}">
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td>
                        @elseif ($programColumn->column_name == 'START_DATE_ACTIVE' || $programColumn->column_name == 'END_DATE_ACTIVE')
                            @if ($programColumn->input_type == 'datethai')
                                <td align="center">   
                                    {{ 
                                        $lookup->getOriginal(strtolower($programColumn->column_name)) 
                                        ? parseToDateTh($lookup->getOriginal(strtolower($programColumn->column_name))) 
                                        : '' 
                                    }}
                                </td>
                            @else
                                <td align="center">   
                                    {{ 
                                        $lookup->getOriginal(strtolower($programColumn->column_name)) 
                                        ? date(trans('date.format'), strtotime($lookup->getOriginal(strtolower($programColumn->column_name)))) 
                                        : '' 
                                    }}
                                </td>
                            @endif
                            
                        @elseif ($programColumn->view_name)
                            @if ($program->program_code == 'PMS0012' || $program->program_code == 'PMS0013')
                                <td>
                                    {{ $programColumn->sqlDisplayMutiValue($lookup->getOriginal(strtolower($programColumn->column_name)), $lookup->attribute4) }}
                                </td>
                            @elseif ($program->program_code == 'PMS0027')
                                <td>
                                    {{ $programColumn->sqlDisplayMutiValue($lookup->getOriginal(strtolower($programColumn->column_name)), $lookup->attribute1) }}
                                </td>
                            @else
                                <td class="{{ $irs ? 'text-center' : ''}}">
                                    {{ $programColumn->sqlDisplay($lookup->getOriginal(strtolower($programColumn->column_name))) }}
                                </td>
                            @endif
                            
                        @elseif ($programColumn->input_type == 'color')
                            <td style="background-color: {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }};"></td>
                        
                        @elseif ($programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'PMS0001' || 
                                $programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'PMS0027' ||
                                $programColumn->column_name == 'ATTRIBUTE4' && $program->program_code == 'PMS0012' ||
                                $programColumn->column_name == 'ATTRIBUTE4' && $program->program_code == 'PMS0013' || 
                                $programColumn->column_name == 'TAG' && $program->program_code == 'PMS0040')
                            <td>
                                {{ $lookup->organization($lookup->getOriginal((strtolower($programColumn->column_name))), $program->program_code) }}
                            </td>
                        @else
                            @if ($program->program_code == 'PMS0047')
                                @if ($programColumn->column_name == 'LOOKUP_CODE')
                                    <td class="text-center">
                                        {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                    </td>
                                @else
                                    
                                    <td class="{{$programColumn->input_type == 'number' ? 'text-right' : ''}}">
                                        {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                    </td>
                                @endif
                            @else
                                @if ($irs)
                                    <td class="text-center">
                                        {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                    </td> 
                                @else
                                    <td class="{{ $programColumn->input_type == 'number' ? 'text-right' : ''}}">
                                        {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                    </td> 
                                @endif
                            @endif
                        @endif                        
                    @endforeach
                    @if (canEnter('/lookup?programCode='.$program->program_code))
                        <td class="text-center">
                            @if ($program->program_code == 'IRS0001' || $program->program_code == 'IRS0002' || $program->program_code == 'IRS0003' || 
                                 $program->program_code == 'IRS0004' || $program->program_code == 'IRS0005' || $program->program_code == 'IRS0006' || 
                                 $program->program_code == 'IRS0007' || $program->program_code == 'IRS0008' || $program->program_code == 'IRS0009')

                                <form onsubmit="return confirm('ต้องการที่จะลบข้อมูล หรือไม่?')" action="{{ route('lookup.delete', [$lookup->lookup_code, 'programCode' => $program->program_code]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                        @if ($program->update_flag == 'Y')
                                            <a href="{{ route('lookup.edit', [$lookup->lookup_code, 'programCode' => $program->program_code]) }}" class="btn btn-warning btn-xs">
                                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                            </a>
                                        @endif
                                        @if ($program->delete_flag == 'Y')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-times"></i> ลบ
                                            </button>
                                        @endif
                                </form>
                            @else
                                <form onsubmit="return confirm('Do you want to delete this item?')" action="{{ route('lookup.delete', [$lookup->lookup_code, 'programCode' => $program->program_code]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                        @if ($program->update_flag == 'Y')
                                            <a href="{{ route('lookup.edit', [$lookup->lookup_code, 'programCode' => $program->program_code]) }}" class="btn btn-warning btn-xs">
                                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                            </a>
                                        @endif
                                        @if ($program->delete_flag == 'Y')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-times"></i> ลบ
                                            </button>
                                        @endif
                                </form>
                            @endif
                        </td>
                    @endif --}}
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>

{{-- @section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.lookup_data_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop --}}
        