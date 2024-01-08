<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;
use App\Models\MtlParameter;
use App\Http\Requests\User\StoreUserRequest;

use Illuminate\Http\Request;

class TestController extends Controller
{

    public function adUser()
    {
        $username = request()->username ?? 'erpadmin';
        $password = request()->password ?? 'toatadmin989!$';
        $err_login = '';

        $connections = [ 'connection1' => config('ldap.connections.default.settings') ?? []];
        $ad = new \Adldap\Adldap($connections);
        $connectionName = 'connection1';

        try {
            $provider = $ad->connect($connectionName);
            if ($provider->auth()->attempt($username, $password)) {
                // Passed.
                $user = $this->checkUser($ad, $connectionName, $username, $password);
                dd('Passed');
            } else {
                $suffix = config('services.ldap.account_suffix');
                if ($provider->auth()->attempt($username . $suffix, $password)) {
                    // Passed.
                    $user = $this->checkUser($ad, $connectionName, $username, $password, $suffix);
                    dd($user);

                    return response()->json($user);
                    dd('Passed: account_suffix');
                } else {
                    // Failed.
                    // dd('Failed');
                }
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
}
