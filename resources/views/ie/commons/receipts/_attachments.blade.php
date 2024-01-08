<div class="file-box" style="width: 115px">
  <div class="file" style="margin-bottom: 10px;margin-right: 10px;">
          <span class="file-corner-icon-top-right">
              @if(isset($canRemove))
                  <a id="btn_remove_receipt_attachment_{{ $attachment->attachment_id }}" 
                    style="word-wrap:break-word;" title="remove"
                    type="button" class="text-danger"
                    data-receipt-id="{{ $receipt->receipt_id }}"
                    data-attachment-id="{{ $attachment->attachment_id }}">
                    <div class="attach-files">
                        <i class="fa fa-times"></i> 
                    </div>
                  </a>
              @endif
          </span>
          <span class="corner">
          </span>
          <div class="icon" style="height: 80px;padding: 10px 10px;">
              @if($attachment->is_image)
                  <img src="{{ url('ie/attachments/'.$attachment->attachment_id.'/image') }}" class="img-modal"     data-id="{{ $attachment->attachment_id }}" title="{{$attachment->original_name}}" 
                       style="height: 60px;">
              @else
                <i class="fa fa-file" style="font-size: 60px;"></i>
              @endif
          </div>
          <div class="file-name" style="text-overflow:ellipsis;white-space: nowrap;overflow: hidden;padding: 5px;">
                <a style="font-size: 11px;word-wrap:break-word;" href="{!! route('ie.attachments.download', [$attachment->attachment_id]) !!}" title="Download {{ $attachment->original_name }}">
                  <div class="attach-files">
                      <i class="fa fa-download"></i>
                      {{ $attachment->original_name }} 
                  </div>
              </a>
          </div>
  </div>
</div>
