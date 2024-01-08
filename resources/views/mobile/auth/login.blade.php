
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TOAT | Login</title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{!! asset('mobile/css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('mobile/css/vendor.css') !!}" />
</head>

<body class="gray-bg" style="background: #eefec8;">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <!-- <div class="col-md-6 text-center" style="color: #2F4050;">
                <h2 class="font-bold mb-1" style="font-size: 140px;">BST</h2>
                <div>
                    Bangkok Synthetics Co., Ltd.
                </div>
            </div> -->
            <div class="col-12 col-lg-6 offset-lg-3 p-0">
                <div class="p-4">
                    <form class="m-t" role="form" method="POST" action="{{ route('mobiles.login.post') }}">
                    {{-- <form class="m-t" role="form" action="{{  route('mobile.login.post') }}" method="POST"> --}}
                    {{-- <form class="m-t" role="form" action="{{  route('mobile.login') }}" method="get"> --}}
                        @method('POST')
                        @csrf
                        {{-- <div class="form-group">
                            <input  id="email" placeholder="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        <div class="form-group">
                                {{-- onkeyup="this.value = this.value.toUpperCase();" --}}
                            <input
                                id="username" placeholder="Username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {{-- <input type="password" name="password" class="form-control" placeholder="Password" required=""> --}}
                            <input  id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        {{-- <div class="text-right">
                            <a href="{{ route('password.request') }}"  >
                                <small>Forgot password?</small>
                            </a>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
