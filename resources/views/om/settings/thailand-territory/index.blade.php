@extends('layouts.app')

@section('title', 'OMS0018')

@section('page-title')
    <h3>OMS0018: ข้อมูลอำเภอ/เขต, จังหวัด, ภาค, รหัสไปรษณีย์ ของประเทศไทย</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.thailand-territory.index') }}">ข้อมูลอำเภอ/เขต, จังหวัด, ภาค, รหัสไปรษณีย์ ของประเทศไทย</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>ข้อมูลอำเภอ/เขต, จังหวัด, ภาค, รหัสไปรษณีย์ ของประเทศไทย</h5>
                </div>

                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.thailand-territory.import'] , "method" => "post", "enctype" => "multipart/form-data", "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    @csrf
                    <div class="row m-3">
                        <div class="col-md-5 text-right">
                            <label> 
                                <strong>File Excel ที่ต้องนำเข้า</strong>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <input type="file" name="select_file" id="fileInput" accept=".xls,.xlsx" class="form-control-file">
                        </div>

                        <div class="col-md-12">
                            <div class="tw-m-5">
                                <div class="text-left">
                                    <div class="text-left" id="preview-existing-data-html"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center mt-3">
                            <a href="{{ route('om.settings.thailand-territory.download-excel-template') }}" class="btn btn-sm btn-outline-info" title="Download Excel Template">
                                <i class="fa fa-download"></i> Download Excel Template
                            </a>
                            <button class="btn btn-sm btn-primary" id="btn-upload-data" type="submit"> <i class="fa fa-save"></i> นำข้อมูลเข้า </button>
                            <button id="preview-existing-data" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading ..." type="button" class="btn btn-sm btn-info btn-outline">
                                <i class="fa fa-check-square-o"></i> Check
                            </button> Check datas that already exit in database by thambon id from excel.
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("button#btn-upload-data").hide();
        $("button#preview-existing-data").show();

        let selectedFile;

        document.getElementById('fileInput').addEventListener("change", (event) => {
            selectedFile = event.target.files[0];
        })

        document.getElementById('preview-existing-data').addEventListener("click", () => {
            if(selectedFile) {
                let fileReader = new FileReader();
                fileReader.readAsBinaryString(selectedFile);
                fileReader.onload = (event)=>{
                    let data = event.target.result;
                    let workbook = XLSX.read(data,{type:"binary"});

                    workbook.SheetNames.forEach(sheet => {
                        let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                        let tambonIDs = rowObject.map(({ TambonID }) => TambonID); // get tambonIds from excel to check old datas
                        let url = '';
                        let valid = true; let html = ''; let arrErrMsg = '';
                        let element = $("div#preview-existing-data-html");

                        url = "{{ url('/') }}/om/settings/thailand-territory/preview-import";

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: { _token: "{{ csrf_token() }}", tambonIds : tambonIDs },
                            beforeSend: function( xhr ) {
                                $("button#btn-upload-data").hide();
                                $("button#preview-existing-data").button('loading');
                                element.next("div.error_msg").remove();
                                element.removeClass('err_validate');
                                element.html('\
                                <div class="m-t-lg m-b-lg">\
                                    <div class="text-center sk-spinner sk-spinner-wave">\
                                        <div class="sk-rect1"></div>\
                                        <div class="sk-rect2"></div>\
                                        <div class="sk-rect3"></div>\
                                        <div class="sk-rect4"></div>\
                                        <div class="sk-rect5"></div>\
                                    </div>\
                                </div>');
                            }
                        })
                        .done(function(result) {
                            valid = result.valid;
                            html = result.html;
                            arrErrMsg = result.err_msg;

                            element.next("div.error_msg").remove();
                            element.removeClass('err_validate');
                            element.html(html);

                            if (arrErrMsg != '') {
                                element.addClass('err_validate');
                                element.after('<div class="error_msg"> '+ arrErrMsg +' </div>');

                                $("button#btn-upload-data").hide();
                                $("button#preview-existing-data").show();
                            } else {
                                $("button#btn-upload-data").show();
                            }

                            $("button#preview-existing-data").button('reset');
                        });
                    })
                }
            }
        });
    });
</script>
@endsection