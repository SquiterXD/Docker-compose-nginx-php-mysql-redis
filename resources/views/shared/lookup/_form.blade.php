{{-- {{dd('xxx', $programColumns)}} --}}
@foreach ($programColumns as $programColumn)
    @php
        $lookupCode = $programColumn->column_name == 'LOOKUP_CODE' && $lookup->lookup_code ? true : '';
        $org = $user->organization ? $user->organization->organization_code : '';

        // ---- text placeholder ---
        $text = '';
        if ($program->program_code == 'PMS0012') {
            $text =  $programColumn->column_name == 'ATTRIBUTE1' ? 'นำไปใช้ในการวางแผนผลิตก้นกรอง' : '';
        } elseif ($program->program_code == 'PMS0013') {
            $text =  $programColumn->column_name == 'ATTRIBUTE1' ? 'นำไปใช้ในการวางแผน และ เชื่อมต่อกับ Feeder ของทางใบยา' : '';
        } elseif ($program->program_code == 'PMS0040') {
            if ($programColumn->column_name == 'MEANING') {
                $text = 'ใช้ในการเรียงลำดับช่วงเวลา';
            } elseif ($programColumn->column_name == 'DESCRIPTION') {
                $text = 'ระบุข้อมูลช่วงเวลา ตัวอย่างเช่น 07.30 - 11.00';
            } elseif ($programColumn->column_name == 'ATTRIBUTE3') {
                $text = 'ระบุข้อมูลช่วงเวลา ตัวอย่างเช่น 08.00';
            } elseif ($programColumn->column_name == 'ATTRIBUTE4') {
                $text = 'ระบุข้อมูลช่วงเวลา ตัวอย่างเช่น 15.00';
            }else {
                $text = '';
            }
        }
    @endphp
    @if ($programColumn->input_type == 'color')
        <div class="row mt-2">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                <div class="control-label mb-2"> 
                    <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                    @if ($programColumn->strRequiredFlag)
                        <span class="text-danger">*</span>
                    @endif
                </div>
                <div class="col-12" align="left">
                    <input type="color" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}" {{ $programColumn->column_name == 'LOOKUP_CODE' && $lookup->lookup_code ? 'disabled' : ''}}>
                </div>
            </div>
        </div>
    @elseif($programColumn->input_type == 'number')
        @if ($program->program_code == 'PMS0045')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <div class="form-inline">
                        <input type="number" class="form-control col-10" name="{{ $programColumn->column_name }}" value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}" {{ $programColumn->column_name == 'LOOKUP_CODE' && $lookup->lookup_code ? 'disabled' : ''}}>
                        <strong class="ml-2">เดือน</strong>
                    </div> 
                </div>
            </div>
        @else
            @if ($program->program_code == 'PMS0040' && $programColumn->column_name == 'ATTRIBUTE2')
                {{-- @if ($org == 'M06') --}}
                    <div class="row mt-2">
                        <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                            <div class="control-label mb-2"> 
                                <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                                @if ($programColumn->strRequiredFlag)
                                    <span class="text-danger">*</span>
                                @endif
                            </div>
                            <lookup-input   :data-name="{{json_encode($programColumn->column_name)}}"
                                            :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                            :lookup-code="{{json_encode($lookupCode)}}"
                                            program-code="{{ $program->program_code }}"
                                            :input-type="{{json_encode('number')}}"
                                            :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}">
                            </lookup-input>
                        </div>
                    </div>
                {{-- @endif --}}
            @else  
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <lookup-input   :data-name="{{json_encode($programColumn->column_name)}}"
                                        :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                        :lookup-code="{{json_encode($lookupCode)}}"
                                        program-code="{{ $program->program_code }}"
                                        :input-type="{{json_encode('number')}}"
                                        :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}"
                                        :text-detail="{{json_encode($text)}}">
                        </lookup-input>
                        {{-- <input type="number" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}" {{ $programColumn->column_name == 'LOOKUP_CODE' && $lookup->lookup_code ? 'disabled' : ''}}> --}}
                    </div>
                </div>
            @endif
        @endif
    @else
        @if ($programColumn->column_name == 'ENABLED_FLAG')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <div class="col-12" align="left">
                        <input type="checkbox" name="{{ $programColumn->column_name }}"{{ $lookup->lookup_type ? $lookup->enabled_flag == 'Y' ? 'checked' : '' : 'checked' }}>
                    </div>
                </div>
            </div>

        @elseif ($programColumn->view_name)
            @if ($program->program_code == 'PMS0012' || $program->program_code == 'PMS0013' ||$program->program_code == 'PMS0027' || ($program->program_code == 'PMS0014' || $program->program_code == 'EMS0003'))
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        @php
                            $org = $user->organization ? $user->organization->organization_code : '';
                            $defaultValue = $lookup->getOriginal((strtolower($programColumn->column_name)));
                            if ($program->program_code == 'PMS0012'
                                && !$lookup->lookup_code
                                && $programColumn->column_name == 'ATTRIBUTE2') { //เฉพาะสร้าง
                                $list = $lookup->sqlByOrg($programColumn->sql_text, $org);
                                if (count($list)) {
                                    $defaultValue = $list->first()->value;
                                }
                            }
                        @endphp

                        <lookup-select :data-name="{{json_encode($programColumn->column_name)}}"
                                       :default-value="{{json_encode($defaultValue)}}"
                                       {{-- :data-lists="{{json_encode($lookup->sqlByOrg($programColumn->sql_text, $org))}}" --}}
                                       :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}"
                                       :program-code="{{json_encode($program->program_code)}}"
                                       :program-column="{{json_encode($programColumn)}}">
                        </lookup-select>

                    </div>
                </div>
            {{-- @elseif ($program->program_code == 'PMS0027')
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>

                        <lookup-select :data-name="{{json_encode($programColumn->column_name)}}"
                                       :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                       :data-lists="{{json_encode($lookup->sqlByOrg($programColumn->sql_text, auth()->user()->organization_id))}}"
                                       :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}"
                                       :program-code="{{json_encode($program->program_code)}}"
                                       :program-column="{{json_encode($programColumn)}}">
                        </lookup-select>

                    </div>
                </div> --}}
            @else
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>

                        <lookup-select :data-name="{{json_encode($programColumn->column_name)}}"
                                       :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                       {{-- :data-lists="{{json_encode($lookup->getSqlData($programColumn->sql_text))}}" --}}
                                       :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}"
                                       :program-code="{{json_encode($program->program_code)}}"
                                       :program-column="{{json_encode($programColumn)}}">
                        </lookup-select>
                    </div>
                </div>
            @endif
            

        @elseif($programColumn->column_name == 'START_DATE_ACTIVE' || $programColumn->column_name == 'END_DATE_ACTIVE')
            @php
                $text = '';
                if ($programColumn->column_name == 'START_DATE_ACTIVE') {
                    $text = 'วันที่เริ่มต้น';
                }elseif ($programColumn->column_name == 'END_DATE_ACTIVE') {
                    $text = 'วันที่สิ้นสุด';
                }else {
                    $text = '';
                }
            @endphp
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-p" id="date">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    @if ($programColumn->input_type == 'datethai')
                        <lookup-date-th :data-name="{{json_encode($programColumn->column_name)}}"
                                        :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                        :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}"
                                        :text-detail="{{json_encode($text)}}">
                        </lookup-date-th>

                        <input type="hidden" class="form-control col-12" name="date_type" value="date_thai">
                    @else

                        <lookup-date :data-name="{{json_encode($programColumn->column_name)}}"
                                     :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                     :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}"
                                     :text-detail="{{json_encode($text)}}">
                    
                        </lookup-date>
                    
                        {{-- @if ($program->program_code == 'OMS0001' || $program->program_code == 'OMS0004' || $program->program_code == 'OMS0006' || 
                            $program->program_code == 'OMS0008' || $program->program_code == 'OMS0009' || $program->program_code == 'OMS0032' || 
                            $program->program_code == 'OMS0034' || $program->program_code == 'OMS0035')
                            <lookup-date-th :data-name="{{json_encode($programColumn->column_name)}}"
                                            :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}">
                                
                            </lookup-date-th>
                        @else 
                            <lookup-date :data-name="{{json_encode($programColumn->column_name)}}"
                                        :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}">
                                
                            </lookup-date>
                        @endif --}}
                    @endif

                </div>
            </div>
        @elseif ($programColumn->column_name == 'TAG' && $program->program_code == 'OMS0022' || 
                 $programColumn->column_name == 'TAG' && $program->program_code == 'IRS0007' || 
                 $programColumn->column_name == 'TAG' && $program->program_code == 'OMS0008' || 
                 $programColumn->column_name == 'TAG' && $program->program_code == 'OMS0038')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <div class="col-12" align="left">
                        <input type="checkbox" name="{{ $programColumn->column_name }}"{{ $lookup->lookup_type ? $lookup->tag == 'Y' ? 'checked' : '' : 'checked' }}>
                    </div>
                </div>
            </div>   
        @elseif ($programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'PMS0001' || 
                 $programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'PMS0027' || 
                 $programColumn->column_name == 'ATTRIBUTE1' && $program->program_code == 'PDS0008')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <input type="hidden" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ auth()->user()->organization ? auth()->user()->organization->organization_code : '' }}">
                    <input type="text" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ auth()->user()->organization ? auth()->user()->organization->organization_code . ' : ' .  auth()->user()->organization->organization_name : '' }}" disabled>
                </div>
            </div>
        @elseif ($programColumn->column_name == 'TAG' && $program->program_code == 'PMS0040')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <input type="hidden" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ auth()->user()->organization ? auth()->user()->organization->organization_code : '' }}">
                    <input type="text" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ auth()->user()->organization ? auth()->user()->organization->organization_code . ' : ' .  auth()->user()->organization->organization_name : '' }}" disabled>
                </div>
            </div>
        @elseif ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'PPS0002')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <div class="col-12" align="left">
                        <input type="checkbox" name="{{ $programColumn->column_name }}"{{ $lookup->lookup_type ? $lookup->attribute2 == 'Y' ? 'checked' : '' : '' }}>
                    </div>
                </div>
            </div>
        @elseif ($programColumn->column_name == 'ATTRIBUTE3' && $program->program_code == 'PMS0012' || $programColumn->column_name == 'ATTRIBUTE3' && $program->program_code == 'PMS0013')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <input type="hidden" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ $user->department_code ? $user->department_code : '' }}">
                    <input type="text" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ $user->department_code }}" disabled>
                </div>
            </div>
        @elseif ($programColumn->column_name == 'ATTRIBUTE4' && $program->program_code == 'PMS0012' || $programColumn->column_name == 'ATTRIBUTE4' && $program->program_code == 'PMS0013')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <input type="hidden" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ $user->organization ? $user->organization->organization_code : '' }}">
                    <input type="text" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ $user->organization ? $user->organization->organization_code . ' : ' . $user->organization->organization_name : '' }}" disabled>
                </div>
            </div>
        @elseif ($programColumn->column_name == 'TAG' && $program->program_code == 'PMS0040')
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <input type="hidden" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ auth()->user()->organization ? auth()->user()->organization->organization_id : '' }}">
                    <input type="text" class="form-control col-12" name="{{ $programColumn->column_name }}" value="{{ auth()->user()->organization ? auth()->user()->organization->organization_code . ' : ' .  auth()->user()->organization->organization_name : '' }}" disabled>
                </div>
            </div>
        @elseif ($programColumn->column_name == 'ATTRIBUTE5'    && $program->program_code == 'QMS0024' ||
                 $programColumn->column_name == 'ATTRIBUTE4'    && $program->program_code == 'QMS0024' ||
                 $programColumn->column_name == 'ATTRIBUTE2'    && $program->program_code == 'QMS0024' ||
                 $programColumn->column_name == 'DESCRIPTION'   && $program->program_code == 'QMS0024' ||
                 $programColumn->column_name == 'MEANING'       && $program->program_code == 'QMS0024' ||
                 $programColumn->column_name == 'ATTRIBUTE13'   && $program->program_code == 'QMS0024' ||
                 $programColumn->column_name == 'ATTRIBUTE5'    && $program->program_code == 'QMS0025' ||
                 $programColumn->column_name == 'ATTRIBUTE4'    && $program->program_code == 'QMS0025' || 
                 $programColumn->column_name == 'ATTRIBUTE2'    && $program->program_code == 'QMS0025' ||
                 $programColumn->column_name == 'DESCRIPTION'   && $program->program_code == 'QMS0025' ||
                 $programColumn->column_name == 'MEANING'       && $program->program_code == 'QMS0025' ||
                 $programColumn->column_name == 'ATTRIBUTE13'   && $program->program_code == 'QMS0025' ||
                 $programColumn->column_name == 'ATTRIBUTE5'    && $program->program_code == 'QMS0026' ||
                 $programColumn->column_name == 'ATTRIBUTE4'    && $program->program_code == 'QMS0026' || 
                 $programColumn->column_name == 'ATTRIBUTE2'    && $program->program_code == 'QMS0026' ||
                 $programColumn->column_name == 'DESCRIPTION'   && $program->program_code == 'QMS0026' ||
                 $programColumn->column_name == 'MEANING'       && $program->program_code == 'QMS0026' ||
                 $programColumn->column_name == 'ATTRIBUTE13'   && $program->program_code == 'QMS0026'    )
            @if ($programColumn->column_name == 'ATTRIBUTE5')
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <input  type="hidden" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                        <input  type="text" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ $lookup->displayQualityProcedure }}" 
                                disabled>
                    </div>
                </div>
            @elseif($programColumn->column_name == 'MEANING')
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            {{-- <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>  --}}
                            <strong> {{ 'แผนก' }} </strong> 
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <input  type="hidden" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                        <input  type="text" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ $lookup->displayDept }}" 
                                disabled>
                    </div>
                </div>
            @elseif($programColumn->column_name == 'ATTRIBUTE13')
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            {{-- <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>  --}}
                            <strong> {{ 'ประเภทเครื่องจักร' }} </strong> 
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <input  type="hidden" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                        <input  type="text" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ $lookup->displayMachineTypeDes  }}" 
                                disabled>
                    </div>
                </div>
            @elseif($programColumn->column_name == 'ATTRIBUTE2')
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <input  type="hidden" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                        <input  type="text" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ $lookup->displayAssetNumber }}" 
                                disabled>
                    </div>
                </div>
            @elseif($programColumn->column_name == 'ATTRIBUTE7' && $program->program_code == 'QMS0026')
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            {{-- <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>  --}}
                            <strong>{{ 'QTM Maker' }}</strong>
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <input  type="hidden" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                        <input  type="text" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                    </div>
                </div>
            @else
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong> 
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <input  type="hidden" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}">
                        <input  type="text" 
                                class="form-control col-12" 
                                name="{{ $programColumn->column_name }}" 
                                value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}" 
                                disabled>
                    </div>
                </div> 
            @endif
        @elseif ($programColumn->column_name == 'ATTRIBUTE2' && $program->program_code == 'PPS0008' || $programColumn->column_name == 'ATTRIBUTE3' && $program->program_code == 'PPS0008')
            @if ($programColumn->column_name == 'ATTRIBUTE2')
                <div class="hr-line-dashed m-2 mt-5"></div>
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4 offset-md-3 mt-2">
                        <div class="control-label mb-2 text-left"><h3><strong> <u> ตั้งค่ากลุ่ม และ ลำดับการออกรายงานปิดงบเดือน </u> </strong></h3></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <lookup-input :data-name="{{json_encode($programColumn->column_name)}}"
                                      :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                      :text-detail="{{json_encode($text)}}"
                                      program-code="{{ $program->program_code }}"
                                      :lookup-code="{{json_encode($lookupCode)}}"
                                      :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}">
                        </lookup-input>
                    </div>
                </div>
            @else
                <div class="row mt-2">
                    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                        <div class="control-label mb-2"> 
                            <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                            @if ($programColumn->strRequiredFlag)
                                <span class="text-danger">*</span>
                            @endif
                        </div>
                        <lookup-input :data-name="{{json_encode($programColumn->column_name)}}"
                                      :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                      :text-detail="{{json_encode($text)}}"
                                      program-code="{{ $program->program_code }}"
                                      :lookup-code="{{json_encode($lookupCode)}}"
                                      :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}">
                        </lookup-input>
                    </div>
                </div>
            @endif
        @else
            {{-- @php
                $text = '';
                if ($program->program_code == 'PMS0012') {
                    $text =  $programColumn->column_name == 'ATTRIBUTE1' ? 'นำไปใช้ในการวางแผนผลิตก้นกรอง' : '';
                } elseif ($program->program_code == 'PMS0013') {
                    $text =  $programColumn->column_name == 'ATTRIBUTE1' ? 'นำไปใช้ในการวางแผน และ เชื่อมต่อกับ Feeder ของทางใบยา' : '';
                } elseif ($program->program_code == 'PMS0040') {
                    if ($programColumn->column_name == 'MEANING') {
                        $text = 'ใช้ในการเรียงลำดับช่วงเวลา';
                    } elseif ($programColumn->column_name == 'DESCRIPTION') {
                        $text = 'ระบุข้อมูลช่วงเวลา ตัวอย่างเช่น 07.30 - 11.00';
                    } elseif ($programColumn->column_name == 'ATTRIBUTE3') {
                        $text = 'ระบุข้อมูลช่วงเวลา ตัวอย่างเช่น 08.00';
                    } elseif ($programColumn->column_name == 'ATTRIBUTE4') {
                        $text = 'ระบุข้อมูลช่วงเวลา ตัวอย่างเช่น 15.00';
                    }else {
                        $text = '';
                    }
                }
            @endphp --}}
            <div class="row mt-2">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
                    <div class="control-label mb-2"> 
                        <strong> {{ str_replace('_', ' ', $programColumn->column_prompt) }} </strong>
                        @if ($programColumn->strRequiredFlag)
                            <span class="text-danger">*</span>
                        @endif
                    </div>
                    <lookup-input :data-name="{{json_encode($programColumn->column_name)}}"
                                  :default-value="{{json_encode($lookup->getOriginal((strtolower($programColumn->column_name))))}}"
                                  :text-detail="{{json_encode($text)}}"
                                  program-code="{{ $program->program_code }}"
                                  :lookup-code="{{json_encode($lookupCode)}}"
                                  :old="{{ json_encode(Session::getOldInput($programColumn->column_name)) }}">
                    </lookup-input>
                </div>
            </div>
        @endif
    @endif
@endforeach

@section('scripts')
    <script>
        var mem = $('#date .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: "dd-MM-yyyy",
        });
    </script>    
@endsection
