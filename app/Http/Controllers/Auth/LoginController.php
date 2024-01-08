<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest')->except(['logout', 'showLoginFormMobile','logoutMobile']);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // $user = \App\User::findByUserName($request->username);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $db = \DB::connection('oracle')->table('v$database')->first();
        $user = \App\Models\User::where('username', request()->username)->first();

        if (($db->name == 'UAT' || $db->name == 'PROD') && $user && $user->hrEmp) {
            if ($this->adUser(request()->username, request()->password)) {
                if ($user && $user->hrEmp && ($user->personalDeptLocation->dept_cd_f02 != $user->department_code)) {
                    return view('notification-change-dept');
                }
                if ($user->active) {
                    \Auth::login($user, request()->remember ?? false);
                    $user->setSession();
                    $db = \DB::connection('oracle')->table('v$database')->first();
                    session(['db_name' => $db->name]);
                    return redirect()->route('home');
                }
            }
        }


        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->hrEmp && ($user->personalDeptLocation->dept_cd_f02 != $user->department_code)) {
                return view('notification-change-dept');
            }

            // Make sure the user is active
            if ($user->active && $this->attemptLogin($request)) {

                $user->setSession();

                $db = \DB::connection('oracle')->table('v$database')->first();
                session(['db_name' => $db->name]);

                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->with('err_login', 'You must be active to login.');
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        $user = \App\Models\User::where('username', request()->username)->first();
        if ($user) {
            $errLogin = 'ข้อมูลรหัส ที่ระบุไม่ถูกต้อง';
        } else {
            $errLogin = 'ข้อมูล ชื่อ ที่ระบุไม่ถูกต้อง';
        }

        return redirect()
                ->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->with('err_login', $errLogin);

        return $this->sendFailedLoginResponse($request);
    }

    public function username()
    {
        return 'username';
    }


    public function adUser($username, $password)
    {
        // $username = request()->username ?? 'erpadmin';
        // $password = request()->password ?? 'toatadmin989!$';
        $err_login = '';

        $connections = [ 'connection1' => config('ldap.connections.default.settings') ?? []];
        $ad = new \Adldap\Adldap($connections);
        $connectionName = 'connection1';

        try {
            $provider = $ad->connect($connectionName);
            if ($provider->auth()->attempt($username, $password)) {
                // Passed.
                return true;
                // $user = $this->checkUser($ad, $connectionName, $username, $password);
                // dd('Passed');
            }

            $suffix = config('services.ldap.account_suffix');
            if ($provider->auth()->attempt($username . $suffix, $password)) {
                return true;
                // Passed.
                // $user = $this->checkUser($ad, $connectionName, $username, $password, $suffix);

                // dd($user);

                // return response()->json($user);
                // dd('Passed: account_suffix');
            }
        } catch (\Adldap\Auth\UsernameRequiredException $e) {
            // The user didn't supply a username.
            $err_login = $e->getMessage();
        } catch (\Adldap\Auth\PasswordRequiredException $e) {
            // The user didn't supply a password.
            $err_login = $e->getMessage();
        } catch (\Exception $e) {
            $err_login = $e->getMessage();
        }


        return false;

        dd('Failed', $err_login, $provider, $connections, config('services.ldap.account_suffix'));

    }

    public function checkUser($ad, $connectionName, $username, $password, $suffix = '')
    {
        $username = trim($username . $suffix);
        $provider = $ad->connect($connectionName, $username, $password);

        if ($suffix == '') {
            $users = $ad->search()->users()->where('cn', $username)->get();
        }else{
            $users = $ad->search()->users()->where('userprincipalname', $username)->get();
        }
        if ($users) {
            $user = $users->first();
            // $user = \App\User::where($username);
            return $user;
        } else {
            throw new \Exception("login failed, not found ad user: {$username}, please contact oracle system administrator.");
        }
    }

    public function showLoginFormMobile()
    {
        return view('mobile.auth.login');
    }

    public function loginMobile(Request $request)
    {
        $this->validateLogin($request);

        // $user = \App\User::findByUserName($request->username);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $db = \DB::connection('oracle')->table('v$database')->first();
        $user = \App\Models\User::where('username', request()->username)->first();

        if ($db->name == 'UAT' && $user && $user->hrEmp) {
            if ($this->adUser(request()->username, request()->password)) {
                if ($user && $user->hrEmp && ($user->personalDeptLocation->dept_cd_f02 != $user->department_code)) {
                    return view('notification-change-dept');
                }
                if ($user->active) {
                    \Auth::login($user, request()->remember ?? false);
                    $user->setSession();
                    $db = \DB::connection('oracle')->table('v$database')->first();
                    session(['db_name' => $db->name]);
                    return redirect()->route('mobiles.index');
                }
            }
        }


        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->hrEmp && ($user->personalDeptLocation->dept_cd_f02 != $user->department_code)) {
                return view('notification-change-dept');
            }

            // Make sure the user is active
            if ($user->active && $this->attemptLogin($request)) {

                $user->setSession();

                $db = \DB::connection('oracle')->table('v$database')->first();
                session(['db_name' => $db->name]);

                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->with('err_login', 'You must be active to login.');
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        $user = \App\Models\User::where('username', request()->username)->first();
        if ($user) {
            $errLogin = 'ข้อมูลรหัส ที่ระบุไม่ถูกต้อง';
        } else {
            $errLogin = 'ข้อมูล ชื่อ ที่ระบุไม่ถูกต้อง';
        }

        return redirect()
                ->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->with('err_login', $errLogin);

        return $this->sendFailedLoginResponse($request);
    }

    public function logoutMobile()
    {
        $this->guard()->logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('mobiles.index');
    }
}
