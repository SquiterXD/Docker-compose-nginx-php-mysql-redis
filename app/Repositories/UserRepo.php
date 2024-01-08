<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\HREmployee;
use App\Models\PersonalDeptLocation;
use DB;
use Arr;

class UserRepo
{
    public static function sync($oraclePersonId)
    {
    }

    public static function syncAll()
    {
        $hrUsers = HREmployee::all();
        $dateNow = now();

        foreach ($hrUsers as $key => $hrUser) {
            $fndUser = collect(DB::select("
                SELECT  employee_number, user_id
                FROM    per_all_people_f papf
                        , fnd_user fnd
                WHERE   1=1
                and     papf.person_id = fnd.employee_id
                and     employee_number = '{$hrUser->username}'
            "))
            ->first();

            $newDept = '-1';
            $newDeptData = PersonalDeptLocation::select(['dept_cd_f02'])->where('pnps_psnl_no', $hrUser->username)->first();
            if ($newDeptData) {
                $newDept = $newDeptData->dept_cd_f02;
            }

            $user = $hrUser->user;
            if (!$user) {
                $newUser = new User;
                $newUser->name = "{$hrUser->first_name} {$hrUser->last_name}";
                $newUser->email = $hrUser->email;
                $newUser->password = bcrypt($hrUser->id_card);
                $newUser->username = $hrUser->username;
                // $newUser->department_code = $hrUser->dept_code_account;
                $newUser->department_code = $newDept;
                $newUser->last_updated_by = -1;
                $newUser->fnd_user_id = optional($fndUser)->user_id ?? -1;
                $newUser->created_by = -1;
                $newUser->last_update_date = $dateNow;
                $newUser->save();
            } else {
                $user->name = "{$hrUser->first_name} {$hrUser->last_name}";
                $user->email = $hrUser->email;
                $user->last_update_date = $dateNow;
                $user->password = bcrypt($hrUser->id_card);
                $user->save();
            }
        }
    }

    public static function syncUpdateDept()
    {
        $hrUsers = HREmployee::all();
        $dateNow = now();
        foreach ($hrUsers as $key => $hrUser) {
            $fndUser = collect(DB::select("
                SELECT  employee_number, user_id
                FROM    per_all_people_f papf
                        , fnd_user fnd
                WHERE   1=1
                and     papf.person_id = fnd.employee_id
                and     employee_number = '{$hrUser->username}'
            "))
            ->first();

            $newDept = '-1';
            $newDeptData = PersonalDeptLocation::select(['dept_cd_f02'])->where('pnps_psnl_no', $hrUser->username)->first();
            if ($newDeptData) {
                $newDept = $newDeptData->dept_cd_f02;
            }

            $user = $hrUser->user;
            $user->department_code = $newDept;
            $user->last_update_date = $dateNow;
            $user->save();
        }
    }
}