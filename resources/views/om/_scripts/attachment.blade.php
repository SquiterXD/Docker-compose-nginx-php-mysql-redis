<div class="modal modal-600 fade" id="attachmentModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            <div class="modal-header">
                <h3>Upload File</h3>
            </div>
            <form id="form_attachment" data-action="{{ url('/') }}/om/upload-attachment-multiple">
                {{ csrf_field() }}
                <input type="hidden" class="form-control text-right" name="attachment_program_code" id="attachment_program_code" placeholder="" value="{{ (isset($program_code)) ? $program_code : '' }}">
                <div class="modal-body pt-4 pb-4">
                    <div class="attachment-box">

                        <div class="form-group d-flex mb-1">
                            <div class="custom-file">
                                <input id="attachment" type="file" class="custom-file-input" name="attachment" value="" accept=".jpeg, .jpg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .csv">
                                <label for="attachment" class="custom-file-label label-attachment">Choose file...</label>
                            </div>
                            <div class="button">
                                <button class="btn btn-success" type="button" onclick="submitChooseFile()">Submit</button>
                                <button class="btn btn-warning" type="button" id="btn_clear" disabled onclick="clearInputFile('clear')">Clear</button>
                            </div>
                        </div>
                        <p><small>Allow type : jpeg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size < 2mb</small></p>
                        <ul class="nav files">
                            @if ($attachmentFile)
                                @foreach ($attachmentFile as $item)
                                <li id="file_attachment_{{ $item->attachment_id }}">
                                    @if (!filter_var($item->path_name, FILTER_VALIDATE_URL))
                                    <code><a href="{{ url('/') }}/{{ $item->path_name }}" target="_blank"><i class="fa fa-file-pdf-o"></i>  {{ $item->file_name }}</code></a>
                                    <button class="btn btn-remove" onclick="removeFileAttachment(0,{{ $item->attachment_id }},`db`)" type="button"><i class="fa fa-times"></i></button>
                                    @else
                                    <code><a href="{{ $item->path_name }}" target="_blank"><i class="fa fa-file-pdf-o"></i>  {{ $item->file_name }}</code></a>
                                    <button class="btn btn-remove" onclick="removeFileAttachment(0,{{ $item->attachment_id }},`db`)" type="button"><i class="fa fa-times"></i></button>
                                    @endif
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div><!--modal-body-->

                <div class="modal-footer center mt-4">
                    <button class="btn btn-gray" type="button"  data-dismiss="modal">
                        ปิด<small>Close</small>
                    </button>
                    <button class="btn btn-primary" type="submit">
                        ยืนยัน<small>Confirm</small>
                    </button>
                </div>
            </form>

        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal-->

<script>
    var fileChoose = [];
    var fileChooseUpload = [];
    var fileSecChoose = 1;
    var fileRunChoose = -1;

    function submitChooseFile(){
        let html = '<li id="file_choose_'+fileSecChoose+'_'+fileRunChoose+'">'+
                '<code><a href="#" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+fileChoose[fileRunChoose].name+'</code></a>'+
                '<button class="btn btn-remove" onclick="removeFileAttachment('+fileSecChoose+','+fileRunChoose+')" type="button"><i class="fa fa-times"></i></button>'+
            '</li>';
        $("ul.files").append(html);
        fileChooseUpload.push(fileChoose[fileRunChoose])
        clearInputFile('clear');
    }

    async function setAttachment(attachment){
        let html = ''
        let url ="{{ url('/') }}"
        $("ul.files").empty();
        await $.each(attachment,async function(index, item) {
            html += '<li id="file_attachment_'+item.attachment_id+'">'
                html += '<code><a href="'+url+'/'+item.path_name+'" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+item.file_name +'</code></a>'
                html += '<button class="btn btn-remove" onclick="removeFileAttachment(0,'+item.attachment_id+',`db`)" type="button"><i class="fa fa-times"></i></button>'
            html += '</li>'
        });
        $("ul.files").append(html);
    }

    $('#attachment').change(function(){
        var id = $(this).data('id')
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        console.log($(this))
        $('#btn_clear').prop("disabled", false)
        // if (input.files && input.files[0]&& (ext == "pdf" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        // {
            var reader = new FileReader();
            let result = reader.readAsDataURL(input.files[0]);
            fileChoose.push(input.files[0])
            fileRunChoose = 0;
        // }
    });

    function clearInputFile(type=''){
        $('#attachment').replaceWith($('#attachment').val('').clone(true));
        $('.label-attachment').html('Choose file...')
        if(type == 'clear'){
            delete fileChoose[fileRunChoose];
            fileChoose = [];
            fileRunChoose = -1;

            $('#btn_clear').prop("disabled", true)
        }
    }

    function removeFileAttachment(section,index,type='local'){
        if(type != 'local'){
            // console.log("{{ url('/') }}/om/remove-attachment/"+index)
            $.ajax({
                type: 'get',
                url: "{{ url('/') }}/om/remove-attachment/"+index,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#file_attachment_'+index).remove()
                    let count_attachment = parseInt($('.count_attachment').html()) - 1
                    $('.count_attachment').html(count_attachment)
                },
                error: function (data) {
                    console.log("error : " + data);
                }
            });
        }else{
            delete fileChoose[index];
            $('#file_choose_'+section+'_'+index).remove()
        }
    }

    $("#form_attachment").submit(async function(e) {
        e.preventDefault();
        let form_attachment = this // this
        let formData = new FormData();
        var ids = '';

        formData.append('_token', "{{ csrf_token() }}");
        formData.append('order_header_id', $('#order_header_id').val());
        formData.append('header_id', $('#order_header_id').val());
        formData.append('order_id', $('#order_id').val());
        formData.append('attachment_program_code', $('#attachment_program_code').val());


        // console.log(fileChoose)
        await $.each(fileChooseUpload,async function(index, file) {
            if(typeof file !== "undefined")
                await formData.append('attachment[]', file);
        });

        // console.log(formData)
        $.ajax({
            type: 'post',
            url: $(form_attachment).data('action'),
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {

                console.log(result)
                if(result.status){
                    fileChoose = [];
                    fileChooseUpload = [];
                    fileRunChoose = -1;
                    fileSecChoose += 1;
                    clearInputFile()
                    console.log('ids <--> ', result.data.ids);
                    document.getElementById("attachment_id").value = result.data.ids;
                    // $("#attachment_id").val(result.data.ids);
                    // console.log($("#attachment_id").val());

                    
                    $('.count_attachment').html(result.data.file.length)
                    $('#attachmentModal').modal('hide')

                    $('ul.files').html('');
                    let html = '';
                    $.each(result.data.file,function(index, item) {
                        html +='<li id="file_attachment_'+item.attachment_id+'">'+
                            '<code><a href="'+result.data.path+item.file_name+'" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+item.file_name+'</code></a>'+
                            '<button class="btn btn-remove" onclick="removeFileAttachment(0,'+item.attachment_id+',`db`)" type="button"><i class="fa fa-times"></i></button>'+
                        '</li>';
                    });
                    $("ul.files").append(html);
                }else{
                    $('#attachmentModal').modal('hide')
                }

            },
            error: function (data) {
                $('#attachmentModal').modal('hide')
            }
        });

    })
</script>
