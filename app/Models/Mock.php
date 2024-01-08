<?php


namespace App\Models;


use stdClass;

class Mock
{
    public static function getMockUser(): object
    {
        //TODO remove mock user
        $user = new stdClass();
        $user->user_id = 27;
        $user->organization_id = 121;
        $user->name = 'CentrillionUser';
        $user->username = 'centrillion';
        $user->department_code = 61000200;
        $user->department_name = 'หน่วยงานทดสอบ ใช้เพื่อจำลองข้อมูลเท่านั้น';
        $user->active = 1;

        return $user;
    }

    public static function getMockUserWith($userAttributesToOverride): object
    {
        $user = (array)self::getMockUser();
        $user = array_merge($user, $userAttributesToOverride);
        return (object)$user;
    }
}
