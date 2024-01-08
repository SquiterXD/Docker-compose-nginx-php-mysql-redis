<div class="row d-none" id="div-ca-search-form">
    <div class="col-md-10">
        <form id="ca-search-form" action="{{ url()->current() }}">
            <div class="row mb-2">
                <div class="col-md-4">
                    <label for="">Document Number</label>
                    <input name="search[document_no]" type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Requester</label>
                    <input name="search[requester]" type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Description</label>
                    <input name="search[description]" type="text" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <label for="">Invoice Number</label>
                    <input name="search[invoice_no]" type="text" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="">Req. Date From - To</label>
                    <div class="input-group"> 
                        <input name="search[req_date_from]" id="txt_req_date_from" type="text" class="form-control" autocomplete="off">
                        <input name="search[req_date_to]" id="txt_req_date_to" type="text" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Status</label>
                    <select name="search[status]" id="txt_status" class="form-control">
                        <option value="">-</option>
                        @foreach ($statusSet as $item)
                            <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-2 text-right d-flex align-items-end flex-column">
        <div class="">
            <button type="button" class="close" id="btn_close_search_form">&times;</button>
        </div>
        <div class="mt-auto">
            <button class="btn btn-default" id="btn_submit_search_form">Search</button>
            <a type="button" class="btn btn-danger" href="{{ url()->current() }}">Clear</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <button class="btn btn-default" id="btn_open_search_form">Search</button>
        {{-- @include('ie.cash-advances._btn_return_encumbrance') --}}
    </div>
</div>