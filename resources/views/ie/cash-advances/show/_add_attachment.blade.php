{{-- <input id="uploadFile" placeholder="Choose File" disabled="disabled" /> --}}
<span id="attachmentDesc" class="d-none">
	<span id="attachmentDescText" class="m-r-xs"></span>
	<span id="btnUploadFile" class="btn btn-xs bg-success btn-outline"
		style="font-size: 10px">
		<i class="fa fa-upload"></i> upload
	</span>
	<span id="btnCancelFile" class="btn btn-xs btn-danger btn-outline"
		style="font-size: 10px">
		<i class="fa fa-times"></i>
	</span>
</span>
{!! Form::open(['route' => ['ie.cash-advances.add_attachment',$cashAdvance->cash_advance_id], 
                    'method' => 'POST',
                    'enctype' => 'multipart/form-data',
                    'id' => 'form-add-attachment']) !!}
<span id="btnAddFile" 
	class="fileUpload btn btn-xs bg-success btn-outline"
	style="font-size: 10px">
    <i class="fa fa-plus"></i> add
    <input id="inputAttachment" name="file" type="file" class="upload" />
</span>
{!! Form::close() !!}