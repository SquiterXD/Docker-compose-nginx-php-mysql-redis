<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    use HasFactory;
    protected $table = "ptw_menus";
    public $primaryKey = 'menu_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'menu_title',
        'parent_id',
        'sort_order',
        'url',
        'permission_code',
        'server_id',
        'program_code',
        'department_code',
        'last_updated_by',
        'created_by',
    ];


    public function parent()
    {
        return $this->hasOne('App\Models\Menu', 'menu_id', 'parent_id')->orderBy('sort_order');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'menu_id')->orderBy('sort_order');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'menu_id', 'menu_id');
    }

    public function programInfo()
    {
        return $this->hasOne(ProgramInfo::class, 'program_code', 'program_code');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getParentFormatAttribute()
    {
        $format = '';
        $parent = $this->parent;
        $parentSecond = optional($parent)->parent;

        if ($parentSecond) {
            $format .= $parentSecond->menu_title . ", ";
        }

        if ($parent) {
            $format .= $parent->menu_title . "";
        }

        return $format;
    }

    public static function treeRole($roleId)
    {
        return Cache::remember('treeRoleData.'. auth()->user()->user_id .'.'.$roleId , 1500, function () use ($roleId) {
            $role = \App\Models\Role::selectRaw('role_id')->find($roleId);
            $menuCols = "menu_id, menu_title, parent_id, sort_order, url, program_code";

            $menuLv3Arr = [];
            $menuLv2Arr = [];
            $menuLv1Arr = [];
            $menuArr = [];
            if ($permissions = optional($role)->permissions ?? []) {
                $menuLv3Arr = $permissions->pluck('menu_id', 'menu_id')->all();
                $menuLv3 = static::selectRaw($menuCols)->whereIn('menu_id', $menuLv3Arr)->get();

                if ($data = $menuLv3->whereNotNull('parent_id')) {
                    $menuLv2Arr = $data->pluck('parent_id', 'parent_id')->all();

                    $menuLv1 = static::selectRaw($menuCols)->whereIn('menu_id', $menuLv2Arr)->get();
                    if ($data = $menuLv1->whereNotNull('parent_id')) {
                        $menuLv1Arr = $data->pluck('parent_id', 'parent_id')->all();
                    }
                }
                $menuArr = $menuLv3Arr + $menuLv2Arr + $menuLv1Arr;
            }


            $data = static::selectRaw($menuCols)
                ->with([
                    'children' => function ($query) use ($menuArr, $menuCols) {
                        $query->selectRaw($menuCols)->whereIn('menu_id', $menuArr)->orderBy('sort_order');
                    },
                    'children.children' => function ($query) use ($menuArr, $menuCols) {
                        $query->selectRaw($menuCols)->whereIn('menu_id', $menuArr)->orderBy('sort_order');
                    }
                ])
                ->active()
                ->where('parent_id', '=', '0')
                ->whereIn('menu_id', $menuArr)
                ->orderBy('sort_order')->get();

            // dd('zzz', $data->first(), $data, $menuArr, $role);
            return $data;
        });
    }

    public static function tree($serverId = false, $userId = false)
    {
        $user = false;
        if ($userId) {
            $user = \App\Models\User::find($userId);
        }
        $arrMenu = [];
        if ($user && $user->permissions) {
            $arrMenu = $user->permissions->pluck('menu_id', 'menu_id')->all();
        }


        return static::with([
                        'children' => function ($query) use($arrMenu) {
                            $query->whereIn('menu_id', $arrMenu);
                        },
                        'children.children' => function ($query) use($arrMenu) {
                            $query->whereIn('menu_id', $arrMenu);
                        }
                    ])
                    ->active()
                    ->where('parent_id', '=', '0')
                    ->when($serverId, function($q) use($serverId) {
                        $q->where('server_id', $serverId);
                    })
                    ->when($user, function($q) use($user, $arrMenu) {
                        $q->whereIn('menu_id', $arrMenu);
                    })
                    ->orderBy('sort_order')->get();
    }

    public static function treeAll($onlyActive = false)
    {
        // dd('xx', implode('.', array_fill(0, 2, 'children.programInfo')));
        return static::with(implode('.', array_fill(0, 100, 'children')) )
                    // ->whereIn('menu_id', $arrMenu)
                    // ->active()
                    ->when($onlyActive, function($q) {
                        $q->active();
                    })
                    ->where('parent_id', '=', '0')
                    ->orderBy('sort_order')->get();
    }

    public function menuByModule($moduleName)
    {
        $menus = Menu::whereHas('programInfo', function ($query) use ($moduleName) {
                            $query->where('module_name', $moduleName);
                        })->get();

        $data = $this->getMenuList($menus);
        return $data;
    }

    public function getMenuList($menus)
    {
        $thirdMenu = optional($menus->pluck('menu_id', 'menu_id'))->all() ?? [];

        $secondMenu = [];
        $secondParentMenu = optional($menus->pluck('parent_id', 'parent_id'))->all() ?? [];
        $secondParentMenu = Menu::whereIn('menu_id', $secondParentMenu)->get();
        if (count($secondParentMenu) > 0) {
            $secondMenu = $secondParentMenu->pluck('menu_id', 'menu_id')->all();
        }

        $firstMenu = [];
        $firstParentMenu = optional($secondParentMenu->pluck('parent_id', 'parent_id'))->all() ?? [];
        $firstParentMenu = Menu::whereIn('menu_id', $firstParentMenu)->get();
        if (count($firstParentMenu)) {
            $firstMenu = $firstParentMenu->pluck('menu_id', 'menu_id')->all();
        }

        $menuId = $thirdMenu + $secondMenu + $firstMenu;
        $data = Menu::with([
                    'programInfo:program_code,description',
                    'permissions:permission_id,menu_id,name'
                ])
                ->whereIn('menu_id', $menuId)->get();

        return $data;
    }

    public function mappingChildrenMenu($menus)
    {
        $arr = [];
        $firstLevel = $menus->where('parent_id', 0);
        foreach ($firstLevel as $key => $firstMenu) {

            $secondMenus = $menus->where('parent_id', $firstMenu->menu_id);
            foreach ($secondMenus as $key => $secondMenu) {
                $secondMenu->children_menus = $menus->where('parent_id', $secondMenu->menu_id);

                foreach ($secondMenu->children_menus as $key => $thirdMenu) {
                    $thirdMenu->children_menus = $menus->where('parent_id', $thirdMenu->menu_id);
                }
            }
            $firstMenu->children_menus = $secondMenus;
            $arr[$firstMenu->menu_id] = $firstMenu;
        }

        return (object)$arr;
    }
}
