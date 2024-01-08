<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = "ptw_users";
    public $primaryKey = 'user_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'department_code',
        'last_updated_by',
        'fnd_user_id',
        'created_by',
        'role_options',
        'department_options',
        'organization_id',
        'inv_org_options'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_options'   => 'array',
        'department_options'   => 'array',
        'inv_org_options' => 'array',
    ];

    public function department()
    {
        return $this->hasOne(\App\Models\IE\FNDListOfValues::class, 'flex_value', 'department_code')->department();
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }

    public function scopeIsFinance($query){
        return $query->where('user_id', 4);
        return $query->where('role','finance');
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isFinance()
    {
        return $this->user_id == 4;
        return true;
        return $this->role == 'finance';
    }

    public function isUser()
    {
        return $this->role == 'user';
    }

    public function isUnblocker()
    {
        $unblockers = \App\Models\IE\Preference::getUnblockers();
        if(count($unblockers) > 0){
            return in_array($this->user_id, $unblockers);
        }
        return false;
    }

    public function isChangeApprover()
    {
        $changeApprovers = \App\Models\IE\Preference::getChangeApprovers();
        if(count($changeApprovers) > 0){
            return in_array($this->user_id, $changeApprovers);
        }
        return false;
    }

    public function isAccountantUser()
    {
        $accountantUsers = \App\Models\IE\Preference::getaccountantUsers();
        if(count($accountantUsers) > 0){
            return in_array($this->user_id, $accountantUsers);
        }
        return false;
    }

    public function isShowAll()
    {
        $showAllUsers = \App\Models\IE\Preference::getShowAllUsers();
        if(count($showAllUsers) > 0){
            return in_array($this->user_id, $showAllUsers);
        }
        return false;
    }

    public function isAllowCreateRequest()
    {
        $allow = true;
        if($this->employee){
            if(!$this->employee->position_id){
                $allow = false;
            }
            if(!$this->employee->email_address){
                $allow = false;
            }
        }
        return $allow;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'ptw_permission_user', 'user_id', 'permission_id');
    }

    public function fndUser()
    {
        return $this->hasOne(FndUser::class, 'user_id', 'fnd_user_id');
    }

    public function hrEmp()
    {
        return $this->hasOne(HREmployee::class, 'username', 'username');
    }

    public function pnMaster()
    {
        return $this->hasOne(PNMaster::class, 'prmf_empcode', 'username');
    }

    public function userAccounts()
    {
        return $this->hasMany(\App\Models\IE\UserAccount::class, 'user_id', 'user_id');
    }

    public function PersonalDeptLocation()
    {
        return $this->hasOne(PersonalDeptLocation::class, 'pnps_psnl_no', 'username');
    }

    public function getOrganizationIdAttribute($value)
    {
        if (auth()->user()->user_id == $this->user_id) {
            return session()->get('organization_id', $value);
        }
        return $value;
    }

    public function getOAUserName()
    {
        return optional(getDefaultData())->fnd_user_name;
    }

    public function assignPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function dismissPermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function hasPermission($permission){
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        if (get_class($permission) === 'App\Models\Permission') {
           return $this->permissions->contains($permission);
        }
        return !! $permission->intersect($this->permissions)->count();
    }

    public function getDepartmentNameAttribute()
    {
        $result = '-';
        if($this->department){
            $result = $this->department->description;
        }
        return $result;
    }

    public function getOperatingUnit()
    {
        $orgId = null;
        if($this->PersonalDeptLocation){
            $orgId = optional(optional($this->PersonalDeptLocation)->location)->org_id;
        }
        return \App\Models\IE\HrOperatingUnit::when($orgId, function($query, $orgId){
            $query->where('organization_id', $orgId);
        })->orderBy('organization_id')->first();
    }

    public static function getListApprovers()
    {
        $changeApprovers = \App\Models\IE\Preference::getChangeApprovers();

        $result = self::whereNotIn('user_id', $changeApprovers)->get();

        return $result;
    }

    public function setSession($changeDeptCode = false)
    {
        $user = $this;
        // $user = User::find(301);
        $departmentOptions = collect($user->department_options ?? [])->pluck('department_code');

        $dept = PtglCoaDeptCodeAllV::where(function($r) use($user, $departmentOptions) {
                        $r->whereIn('department_code', $departmentOptions)
                            ->orWhere('department_code', $user->department_code);
                    })
                    ->selectRaw("ptgl_coa_dept_code_all_v.*, department_code ||': '|| description display")
                    ->get();

        if (!$changeDeptCode) {
            $changeDeptCode = $user->department_code;
        }

        $currentDept = $dept->where('department_code', $changeDeptCode)->first();
        if ($currentDept) {
            session([
                'current_department' => $currentDept,
                'department_list'=> $dept->isEmpty() ? [] : $dept,
            ]);
        }


        $this->setSessionOrg();
        // $this->setSessionMenu();

        // $organizationId = $user->organization_id;
        // $organizationCode = '';
        // $organizationName = '';
        // $organizationList = [];

        // $org    = \DB::connection('oracle')->table('org_organization_definitions')
        //             ->where('organization_id', $organizationId)
        //             ->first();
        // if ($org) {
        //     $organizationCode = $org->organization_code;
        //     $organizationName = $org->organization_name;

        // }

        // $orgList = \DB::connection('oracle')
        //             ->table('org_organization_definitions')
        //             ->select(['organization_id', 'organization_code', 'organization_name'])
        //             ->whereIn('organization_id', $user->inv_org_options ?? [])
        //             ->get();

        // if (count($orgList)) {
        //     $organizationList = $orgList;
        // }

        // session([
        //     'organization_id' => $organizationId,
        //     'organization_code'=> $organizationCode,
        //     'organization_name'=> $organizationName,
        //     'organization_list'=> $organizationList,
        // ]);
        // dd('xxx', session()->all());
    }

    public function setSessionOrg($orgId = false)
    {
        $user = $this;

        $organizationId = $user->organization_id;
        $organizationCode = '';
        $organizationName = '';
        $organizationList = [];


        if (!$orgId && !$organizationId) {
            if (count($user->inv_org_options ?? [])) {
                $organizationId = $user->inv_org_options[0];
            }
        }

        if ($orgId) {
            $organizationId = $orgId;
        }

        $org    = \DB::connection('oracle')->table('org_organization_definitions')
                    ->where('organization_id', $organizationId)
                    ->first();
        if ($org) {
            $organizationCode = $org->organization_code;
            $organizationName = $org->organization_name;

        }

        $orgList = \DB::connection('oracle')
                    ->table('org_organization_definitions')
                    ->select(['organization_id', 'organization_code', 'organization_name'])
                    ->where(function($r) use($user) {
                        $r->whereIn('organization_id', $user->inv_org_options ?? [])
                            ->orWhere('organization_id', $user->getAttributes()['organization_id']);
                    })
                    ->get();

        if (count($orgList)) {
            $organizationList = $orgList;
        }

        session([
            'organization_id' => $organizationId,
            'organization_code'=> $organizationCode,
            'organization_name'=> $organizationName,
            'organization_list'=> $organizationList,
        ]);
        // dd('xxx', session()->all());
    }

    public function setSessionMenu()
    {
        $user = $this;
        $roles = [];
        foreach ($user->role_options ?? [] as $key => $roleId) {
            $role = \App\Models\Role::find($roleId);
            $menu = new \App\Models\Menu;
            $menuList = $menu->treeRole($roleId);
            if ($menuList) {
                $role->menu_list = $menuList;
                $roles[] = $role;
            }
        }
        session([
            'roles' => $roles,
        ]);
    }

    public function organization()
    {
        // return $this->hasOne(MtlParameter::class, 'organization_id', 'organization_id');

        return $this->hasOne(OrgOrganizationDefinition::class, 'organization_id', 'organization_id');
        
    }

    public function scopeSearch($query, $search)
    {
        if($search){
            $query->whereRaw("CONCAT(username, UPPER(name)) like '%".strtoupper($search)."%'");
        }

        return $query;
    }
}
