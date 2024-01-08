<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $user = auth()->user();
        // foreach ($user->role_options ?? [] as $key => $roleId) {

        //     $menu = new \App\Models\Menu;
        //     // $menuList = $menu->treeRole($roleId);
        //     $menuList = $menu->treeRole(101);

        //     dd('1', $menuList);
        //     $role = \App\Models\Role::find($roleId);
        //     dd('x', $role);
        //     // code...
        // }
        // dd($user->role_options);
        return view('home');
    }
}
