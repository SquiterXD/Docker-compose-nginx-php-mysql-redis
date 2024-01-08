<form action="{{ url()->current() }}">
    <div class="row">
        <div class="col-md-10">
            <div class="row mb-2">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <label for="">Search Username</label>
                    <input name="search" value="{{ request()->search }}" type="text" class="form-control" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="col-md-2 text-right mt-auto">
            <div class="mb-2">
                <button class="btn btn-default" id="btn_submit_search_form">Search</button>
                <a type="button" class="btn btn-danger" href="{{route('users.index')}}">Clear</a>
            </div>
        </div>
    </div>
</form>