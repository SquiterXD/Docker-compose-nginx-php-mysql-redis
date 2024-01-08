<div id="modal-edit-mapping-ous" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0 modal-lg">
        {!! Form::open(['route' => ['ie.settings.preferences.update_mapping_ous'],
                    'method' => 'POST',
        ]) !!}
        <div class="modal-content">
            <div class="modal-body" id="modal-body-edit-mapping-ous">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>
                    <div>Mapping Operating Units</div>
                    {{-- <div><small>ตั้งค่าใบแจ้งหนี้</small></div> --}}
                </h4>
                <div class="row">
                    <div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
                        <div class="table-responsive">
                            <table id="table-edit-mapping-ous" class="table table-hover">
                                <tbody>
                                @if(count($ous))
                                @foreach($ous as $ou)
                                    <tr>
                                        <td width="60%">
                                            {{ $ou->name }}
                                            {{-- {!! Form::checkbox('unblock_users[]',$user->user_id,in_array($user->user_id, $unblockers)) !!} --}}
                                        </td>
                                        <td width="40%">
                                            {!! Form::text('mapping_ou['. $ou->organization_id .']', $mappingOU ? $mappingOU[$ou->organization_id] : null, ['class' => 'form-control']) !!}
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <h3 class="text-center m-t-md m-b-md" style="color:#bbb">
                                                Not found operating unit.
                                            </h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button id="btn_save_edit_mapping_ous"
                            class="btn btn-sm btn-primary" type="submit">
                        Save
                    </button>
                    <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
</div>
