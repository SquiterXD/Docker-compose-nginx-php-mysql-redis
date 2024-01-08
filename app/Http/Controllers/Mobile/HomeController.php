<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Menu;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = [
            // 'primary','orange','purple','green',
            'primary','green','purple','orange',
            'blue','indigo','pink',
            'red','orange','yellow',
            'teal','cyan','gray',
            'secondary','success','info',
            'warning','danger','dark',
        ];

        $profile = getDefaultData('/mobiles');
        $menus = Menu::selectRaw("distinct menu_title, url, program_code, sort_order")
                    ->whereIn('program_code', ['PMP0022', 'PMP0023', 'PMP0024', 'PMP0043'])
                    ->orderBy('sort_order')
                    ->where('menu_id', '>', '2000000')
                    ->get();

        if ($profile->organization_code == 'M05') {
            // $menus = $menus->whereIn('program_code', ['PMP0022', 'PMP0023', 'PMP0024', 'PMP0043']);
            $menus = $menus->whereIn('program_code', ['PMP0022', 'PMP0024', 'PMP0043']);
            foreach ($menus as $key => $menu) {
                $menu->menu_title = "$menu->program_code : $menu->menu_title";
                if ($menu->program_code == 'PMP0022') {
                    $menu->menu_title = 'ขั้นตอนที่1 <br> '. $menu->menu_title ;
                }
                if ($menu->program_code == 'PMP0024') {
                    $menu->menu_title = 'ขั้นตอนที่2 โอนย้ายวัตถุดิบ <br> '. $menu->menu_title ;
                }
                if ($menu->program_code == 'PMP0043') {
                    $menu->menu_title = 'เฉพาะเปลี่ยนตรา, เฉพาะคืนของ <br> '. $menu->menu_title ;
                }
            }
            $menus = $menus->sortBy('program_code');
        } else {
            $menus = $menus->whereIn('program_code', ['PMP0022', 'PMP0023', 'PMP0043']);
            foreach ($menus as $key => $menu) {
                $menu->menu_title = "$menu->program_code : $menu->menu_title";
                if ($menu->program_code == 'PMP0022') {
                    $menu->menu_title = 'ขั้นตอนที่1 <br> '. $menu->menu_title ;
                }
                if ($menu->program_code == 'PMP0023') {
                    $menu->menu_title = 'ขั้นตอนที่2 <br> '. $menu->menu_title ;
                }
                if ($menu->program_code == 'PMP0024') {
                    $menu->menu_title = 'โอนย้ายวัตถุดิบ <br> '. $menu->menu_title ;
                }
                if ($menu->program_code == 'PMP0043') {
                    $menu->menu_title = 'เฉพาะเปลี่ยนตรา, เฉพาะคืนของ <br> '. $menu->menu_title ;
                }
            }
        }

        foreach ($menus as $key => $value) {
            $value->color = \Arr::get($colors, $key);
        }

        return view('mobile.home', compact("menus"));
    }

    public function change()
    {
        $orgList = \Session::get('organization_list', []);
        if (count($orgList) == 0) {
            return redirect()->back()->withInput()->with('error', 'ไม่สามารถเปลียนกองได้');
        }
        return view('mobile.change', compact("orgList"));
    }

    public function changeOrg(User $user)
    {
        $user->setSessionOrg(request()->organization_id);
        return redirect()->route('mobiles.index');
        return redirect()->back();
    }
}
