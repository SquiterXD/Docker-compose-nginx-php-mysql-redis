<?php

namespace App\Http\Controllers\Ajax;

use App\Models\User;
use App\Models\HREmployee;
use App\Models\PtglCoaDeptCodeV;
use App\Models\PersonalDeptLocation;
use App\Models\FndUser;

use App\Http\Requests\User\StoreUserRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getUser()
    {
        $name = strtolower(request()->name);
        $username = strtolower(request()->username) ?? false;
        $deptTable = (new PersonalDeptLocation)->getTable();
        $users = HREmployee::where(function($query) use ($username) {
                        if (!$username) {
                            $query->doesntHave('user');
                        }
                    })
                    ->selectRaw("
                        employee_user_view.username
                        , employee_user_view.title
                        , employee_user_view.first_name
                        , employee_user_view.last_name
                        , employee_user_view.id_card
                        , employee_user_view.employment_date
                        , employee_user_view.employment_end_date
                        , employee_user_view.email
                        , dept.dept_cd_f02 as dept_code_account
                        , employee_user_view.username ||': '|| employee_user_view.first_name || ' ' || employee_user_view.last_name lable
                    ")
                    ->when($name, function($q) use($name) {
                        $q->whereRaw("LOWER(username ||' '|| first_name || ' ' || last_name) like ?", ["%{$name}%"]);
                    })
                    ->when($username, function($q) use($username) {
                        $q->whereRaw("LOWER(username) like ?", ["{$username}"]);
                    })
                    ->leftJoin("{$deptTable} AS dept", "dept.pnps_psnl_no", "=", "employee_user_view.username", function ($join) {
                        // $join->on("planning.period_name", '=', "dept.period_name");
                        // $join->on("planning.dept", '=', "dept.biweekly");
                    })
                    ->orderBy('first_name')
                    ->limit(20)
                    ->get();

        return response()->json(['data' => $users]);
    }


    public function getDepartment()
    {
        $query = strtolower(request()->name);
        $data = PtglCoaDeptCodeV::selectRaw("department_code ||': '|| description as description, department_code")
                    ->orderBy('department_code')
                    ->when($query, function($q) use($query) {
                        $q->whereRaw("LOWER(department_code ||' '|| description) like ?", ["%{$query}%"]);
                    })
                    ->limit(20)
                    ->get();

        return response()->json(['data' => $data]);
    }

    public function getOaUser()
    {
        $query = strtolower(request()->name);
        $userId = strtolower(request()->user_id);
        $data = FndUser::selectRaw("user_name, user_id")
                    ->when($query, function($q) use($query) {
                        $q->whereRaw("LOWER(user_name) like ?", ["%{$query}%"]);
                    })
                    ->when($userId, function($q) use($userId) {
                        $q->whereUserId($userId);
                    })
                    ->limit(20)
                    ->get();

        return response()->json(['data' => $data]);
    }

    public function store(StoreUserRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $data = $request->validated();
        $data['password'] = bcrypt($request->password ?? 'welcome');
        $data['last_updated_by'] = $userId;
        $data['created_by'] = $userId;
        $data['organization_id'] = $request->organization_id;



        $departmentOptions = [];
        foreach (request()->department_options as $key => $value) {
            unset($value['department_list']);
            array_push($departmentOptions, $value);
        }

        $invOrgOptions = [];
        foreach (request()->inv_org_options as $key => $value) {
            array_push($invOrgOptions, $value);
        }


        $data['department_options'] = $departmentOptions;
        $data['inv_org_options'] = $invOrgOptions;
        User::create($data);
        $data = [
            'status' => 'S'
        ];

        return response()->json(['data' => $data]);
    }

    public function update(StoreUserRequest $request, User $user)
    {
        try {
            \DB::beginTransaction();

            $departmentOptions = [];
            foreach (request()->department_options as $key => $value) {
                unset($value['department_list']);
                array_push($departmentOptions, $value);
            }

            $invOrgOptions = [];
            foreach (request()->inv_org_options as $key => $value) {
                array_push($invOrgOptions, $value);
            }


            $userId = optional(auth()->user())->user_id ?? -1;
            $user->name = $request->name;
            $user->department_code = $request->department_code;

            $user->email = $request->email;
            $user->role_options = $request->role_options;
            $user->department_options = $departmentOptions;
            $user->inv_org_options = $invOrgOptions;
            $user->last_updated_by = $userId;
            $user->last_update_date = now();
            $user->organization_id = $request->organization_id;

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            \DB::commit();
            $data = [
                'status' => 'S'
            ];
            return response()->json(['data' => $data]);

            return redirect()->route('users.index')->with('success', 'ทำการอัพเดตสมาชิกในระบบเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
