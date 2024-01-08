
<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> Name </strong> <span class="text-danger">*</span></div>
        {!! Form::text('name', old('name', $user->name), ['class' => 'form-control col-12', 'placeholder' => "NAME", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
</div>


<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> username </strong> <span class="text-danger">*</span></div>
        {!! Form::text('username', old('username', $user->username), ['class' => 'form-control col-12', 'placeholder' => "USERNAME", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
</div>

<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> <strong> Email </strong> </div>
        {!! Form::email('email', old('email', $user->email), ['class' => 'form-control col-12', 'placeholder' => "USERNAME", 'autocomplete' => "off"]) !!}
    </div>
</div>

<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> <strong> Password </strong> <span class="text-danger">*</span></div>
        {!! Form::password('password', ['class' => 'form-control col-12', 'placeholder' => "PASSWORD"]) !!}
    </div>
</div>


<div class="row">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"><strong> Department Code </strong> <span class="text-danger">*</span></div>
        {!! Form::text('department_code', old('department_code', $user->department_code), ['class' => 'form-control col-12', 'placeholder' => "USERNAME", 'autocomplete' => "off", 'required' => 'required']) !!}
    </div>
</div>