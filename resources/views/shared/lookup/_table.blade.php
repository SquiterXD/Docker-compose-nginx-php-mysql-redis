<div class="table-responsive">
    @php
        $user = auth()->user();
        $org  = $user->organization ? $user->organization->organization_code : '';
    @endphp
    <table class="table text-nowrap lookup_data_tb">
        <thead>            
            <tr>
                @if ($program->program_code == 'OMS0009')
                    <th>ลำดับที่</th>
                @endif
                @foreach ($programColumns as $programColumn)
                    @if ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'PMS0040')
                        {{-- @if ($org == 'M06') --}}
                            <th class="text-center">{{ str_replace('_', ' ', $programColumn->column_prompt) }}</th>
                        {{-- @endif --}}
                    @elseif ($programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0024' || 
                             $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0025' || 
                             $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0026' || 
                             $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0021')
                        <th class="text-center">{{ 'แผนก' }}</th>
                    @elseif ($programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0024' ||
                             $programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0025' ||
                             $programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0026' ||
                             $programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0021')
                        <th class="text-center">{{ 'ประเภทเครื่องจักร' }}</th>  
                    @elseif ($programColumn->column_name == 'ATTRIBUTE6' && $program->program_code == 'QMS0021'  ||
                             $programColumn->column_name == 'ATTRIBUTE12' && $program->program_code == 'QMS0021' ||
                             $programColumn->column_name == 'ATTRIBUTE7' && $program->program_code == 'QMS0021')

                    @else
                        <th class="text-center">{{ str_replace('_', ' ', $programColumn->column_prompt) }}</th>
                    @endif
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
                    $program->program_code == 'IRS0007' || $program->program_code == 'IRS0008' || $program->program_code == 'IRS0009' ||
                    $program->program_code == 'IRS0010') 
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
                        @if ($programColumn->column_name == 'ENABLED_FLAG')
                            {{-- @if ($lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y')
                                <td data-order="1"  align="center">
                                    <i class="fa fa-check-circle text-success"></i>
                                </td>
                            @else
                                <td data-order="0"  align="center">
                                    <i class="fa fa-circle text-muted"></i>
                                </td>
                            @endif --}}
                            
                            <td class="text-center" style="vertical-align:middle;" data-sort="{{ $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y' ? true : false }}">
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td>
                        @elseif ($programColumn->column_name == 'TAG' && $program->program_code == 'OMS0022' || 
                                 $programColumn->column_name == 'TAG' && $program->program_code == 'IRS0007' || 
                                 $programColumn->column_name == 'TAG' && $program->program_code == 'OMS0008' || 
                                 $programColumn->column_name == 'TAG' && $program->program_code == 'OMS0038')
                            {{-- @if ($lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y')
                                <td data-order="1"  align="center">
                                    <i class="fa fa-check-circle text-success"></i>
                                </td>
                            @else
                                <td data-order="0"  align="center">
                                    <i class="fa fa-circle text-muted"></i>
                                </td>
                            @endif --}}
                            <td class="text-center" style="vertical-align:middle;" data-sort="{{ $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y' ? true : false }}">
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td>
                        @elseif ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'PPS0002')
                            {{-- @if ($lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y')
                                <td data-order="1"  align="center">
                                    <i class="fa fa-check-circle text-success"></i>
                                </td>
                            @else
                                <td data-order="0"  align="center">
                                    <i class="fa fa-circle text-muted"></i>
                                </td>
                            @endif --}}
                            <td class="text-center" style="vertical-align:middle;" data-sort="{{ $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y' ? true : false }}">
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td>
                            {{-- <td align="center">    
                                @include('shared._status_active', ['isActive' => $lookup->getOriginal((strtolower($programColumn->column_name))) == 'Y'])
                            </td> --}}
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
                                {{-- @if ($program->program_code == 'OMS0001' || $program->program_code == 'OMS0004' || $program->program_code == 'OMS0006' || 
                                        $program->program_code == 'OMS0008' || $program->program_code == 'OMS0009' || $program->program_code == 'OMS0032' || 
                                        $program->program_code == 'OMS0034' || $program->program_code == 'OMS0035')
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
                                @endif --}}
                            @endif
                            
                        @elseif ($programColumn->view_name)
                            @if ($program->program_code == 'PMS0012' || $program->program_code == 'PMS0013')
                                <td>
                                    {{ $lookup->getOriginal(strtolower($programColumn->column_name)) ? $programColumn->sqlDisplayMutiValue($lookup->getOriginal(strtolower($programColumn->column_name)), $lookup->attribute4) : '' }}
                                </td>
                            @elseif ($program->program_code == 'PMS0027')
                                <td>
                                    {{ $lookup->getOriginal(strtolower($programColumn->column_name)) ? $programColumn->sqlDisplayMutiValue($lookup->getOriginal(strtolower($programColumn->column_name)), $lookup->attribute1) : '' }}
                                </td>
                            @elseif ($programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'QMS0022')       
                                <td>
                                    {{ $lookup->getOriginal(strtolower($programColumn->column_name)) ? $programColumn->sqlDisplayMutiValue($lookup->getOriginal(strtolower($programColumn->column_name)), $lookup->attribute1) : '' }}
                                </td> 
                            @elseif ($programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'QMS0023')       
                                <td>
                                    {{ $lookup->getOriginal(strtolower($programColumn->column_name)) ? $programColumn->sqlDisplayMutiValue($lookup->getOriginal(strtolower($programColumn->column_name)), $lookup->attribute1) : '' }}
                                </td> 
                            @elseif ($programColumn->column_name == 'ATTRIBUTE6' && $program->program_code == 'QMS0021'  ||
                                     $programColumn->column_name == 'ATTRIBUTE12' && $program->program_code == 'QMS0021')

                            @elseif ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'QMS0021' )
                                <td>
                                    {{ $lookup->displayAssetNumber. ' : ' .$lookup->description  }}
                                </td>
                            @else
                                <td class="{{ $irs ? 'text-center' : ''}}">
                                    {{ $lookup->getOriginal(strtolower($programColumn->column_name)) ? $programColumn->sqlDisplay($lookup->getOriginal(strtolower($programColumn->column_name))) : '' }}
                                </td>
                            @endif
            
                        @elseif ($programColumn->input_type == 'color')
                            <td style="background-color: {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }};"></td>

                        
                        @elseif ($programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0024' ||
                                 $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0025' ||
                                 $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0026' ||
                                 $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0021'
                                )
                            <td>
                                {{ $lookup->displayDept }}
                            </td>
                        @elseif ($programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0024' ||
                                 $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0025' ||
                                 $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0026' ||
                                 $programColumn->column_name == 'MEANING' && $program->program_code == 'QMS0021'
                                )
                            <td>
                                {{ $lookup->displayDept }}
                            </td>
                        @elseif ($programColumn->column_name == 'ATTRIBUTE5' && $program->program_code == 'QMS0024' ||
                                 $programColumn->column_name == 'ATTRIBUTE5' && $program->program_code == 'QMS0025' ||
                                 $programColumn->column_name == 'ATTRIBUTE5' && $program->program_code == 'QMS0026' ||
                                 $programColumn->column_name == 'ATTRIBUTE5' && $program->program_code == 'QMS0021')
                            <td>
                                {{ $lookup->displayQualityProcedure }}
                            </td>
                        @elseif ($programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0024' ||
                                 $programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0025' ||
                                 $programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0026' ||
                                 $programColumn->column_name == 'ATTRIBUTE13' && $program->program_code == 'QMS0021')
                            <td>
                                {{ $lookup->displayMachineTypeDes }}
                            </td> 
                        @elseif ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'QMS0024' ||
                                 $programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'QMS0025' ||
                                 $programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'QMS0026'     )
                            <td>
                                {{ $lookup->displayAssetNumber }}
                            </td> 
                        @elseif ($programColumn->column_name == 'ATTRIBUTE8' && $program->program_code == 'QMS0021')
                            <td>
                                {{ $lookup->displayItemLocation }}
                            </td> 
                        @elseif ($programColumn->column_name == 'ATTRIBUTE7' && $program->program_code == 'QMS0021')
                        @elseif ( $programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'PPS0008' ||
                                $programColumn->column_name == 'ATTRIBUTE3' && $program->program_code == 'PPS0008')
                            <td class="text-center">
                                {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
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
                                    @if ($program->program_code == 'PMS0040')
                                        {{-- @if ($org == 'M06') --}}
                                            {{-- <td class="{{ $programColumn->input_type == 'number' ? 'text-right' : ''}}">
                                                {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                            </td>  --}}
                                        {{-- @endif --}}
                                        @if ($programColumn->column_name == 'DESCRIPTION')
                                            <td class="{{ $programColumn->input_type == 'number' ? 'text-right' : ''}}">
                                                {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                            </td> 
                                        @else
                                            <td class="{{ $programColumn->input_type == 'number' ? 'text-right' : 'text-center'}}">
                                                {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                            </td> 
                                        @endif
                                    @else
                                        <td class="{{ $programColumn->input_type == 'number' ? 'text-right' : ''}}">
                                            {{ $lookup->getOriginal(strtolower($programColumn->column_name)) }}
                                        </td> 
                                    @endif
                                @endif
                            @endif
                        @endif                        
                    @endforeach
                    @if (canEnter('/lookup?programCode='.$program->program_code))
                        <td class="text-center">
                            @if ($program->program_code == 'IRS0001' || $program->program_code == 'IRS0002' || $program->program_code == 'IRS0003' || 
                                 $program->program_code == 'IRS0004' || $program->program_code == 'IRS0005' || $program->program_code == 'IRS0006' || 
                                 $program->program_code == 'IRS0007' || $program->program_code == 'IRS0008' || $program->program_code == 'IRS0009')
                                
                                {{-- @include('shared.lookup._action') --}}
                                {{-- <lookup-action  :url-edit="{{ json_encode(route('lookup.edit', [$lookup->lookup_code, 'programCode' => $program->program_code])) }}"
                                                :url-delete="{{ json_encode(route('lookup.delete', [$lookup->lookup_code, 'programCode' => $program->program_code])) }}"
                                                :lookup-code="{{ json_encode($lookup->lookup_code) }}"
                                                :data-name="{{json_encode($lookup->lookup_code)}}">
                                </lookup-action> --}}
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
                    @endif
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>

@section('scripts')
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
                    // { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });

        // $("#searchBtn").click(() => {
        //     $.ajax({
        //         url: "{{ route('eam.ajax.check-on-hand.search') }}",
        //         method: 'get',
        //         data: {
        //             'item_code': $("#itemCode").val(),
        //             'item_description': $("#itemDescription").val(),
        //             'part_number': $("#partNumber").val(),
        //             'old_item_number': $("#oldOtemNumber").val(),
        //             'part_number_old': $("#partNumberOld").val(),
        //             'machine_01': $("#machine01").val(),
        //             'machine_02': $("#machine02").val(),
        //             'subinventory': $("#subinventory").val(),
        //             'locator_name': $("#locator").val()
        //         },
        //         success: function (response) {
        //             if (response.data.original.data.length > 0) {
        //                 setTableAskForInformationFn(response.data.original);
        //                 window.location.href = '#table'
        //             } else {
        //                 swal("ค้นหาข้อมูลไม่พบ", "", "warning");
        //                 $("#setTbodyTable").html('');
        //                 $("#setTablePagination").html('');
        //             }
        //         },
        //         // error: function (jqXHR, textStatus, errorThrown) {
        //         //     swal("Error", jqXHR.responseText.message, "error");
        //         // }
        //     });
        // });
    </script>
@stop
        