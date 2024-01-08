<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\Settings\Email;
use App\Models\HREmployee;
use App\Models\Lookup\ValueSetup;
use App\Models\IR\Settings\PtglCoaDeptCodeView;

class EmailController extends Controller
{
    public function updateActiveFlag()
    {
        $user = auth()->user();

        $data = Email::find(request()->email_id);
        $data->active_flag      = request()->active_flag;
        $data->last_updated_by  = $user->user_id;
        $data->save();

        $data = ['status' => 'success'];
                
        return response()->json($data);

        // dd('updateActiveFlag', request()->all());
    }

    public function checkDuplicate()
    {
        //เช็ค รูปแบบ email
        $keyWords = explode(',' , request()->email);
        foreach ($keyWords as $value) {
            $mail = explode('@' , $value);
            $text = '@'.$mail[1];

            $emailFormat = ValueSetup::where('lookup_type', 'PTIR_EMAIL_CHECK')
                                        ->whereNull('end_date_active')
                                        ->where('enabled_flag', 'Y')
                                        ->where('description', $text)
                                        ->first();
            if (!$emailFormat) {
                $data['status'] = 'E';
                $data['msg'] = 'กรุณาระบุรูปแบบ Email ให้ถูกต้อง';
                
                return response()->json($data);
            }
        }

        if (request()->id) {
            $checkFirst = Email::where('email_id', '!=', request()->id)
                            ->where('email', str_replace(' ', '', request()->email))
                            ->where('department_name', request()->department_name)
                            ->first();

            if ($checkFirst) {
                $data['status'] = 'E';
                $data['msg'] = 'ชื่อและ Email ซ้ำกับในระบบ';
                
                return response()->json($data);
            }

            $checkDup = Email::where('email_id', '!=', request()->id)
                            ->where('email', str_replace(' ', '', request()->email))
                            ->where('company_number', request()->company_number)
                            ->where('employee_number', request()->employee_number)
                            ->where('department_name', request()->department_name)
                            ->where('to_flag', request()->to_flag)
                            ->where('cc_flag', request()->cc_flag)
                            ->where('sender_flag', request()->sender_flag)
                            ->first();
        } else {
            $checkFirst = Email::where('email_id', '!=', request()->id)
                            ->where('department_name', request()->department_name)
                            ->where('email', str_replace(' ', '', request()->email))
                            ->orWhere('employee_number', request()->employee_number)
                            ->where('email', str_replace(' ', '', request()->email))
                            ->orWhere('company_number', request()->company_number)
                            ->where('email', str_replace(' ', '', request()->email))
                            ->first();
            // dd($checkFirst);
            if ($checkFirst) {
                $data['status'] = 'E';
                $data['msg'] = 'ชื่อและ Email ซ้ำกับในระบบ';

                return response()->json($data);
            }

            $checkDup = Email::where('email', str_replace(' ', '', request()->email))
                            ->where('company_number', request()->company_number)
                            ->where('employee_number', request()->employee_number)
                            ->where('department_name', request()->department_name)
                            ->where('to_flag', request()->to_flag)
                            ->where('cc_flag', request()->cc_flag)
                            ->where('sender_flag', request()->sender_flag)
                            ->first();
        }

        if ($checkDup) {
            // $data = true;
            $data['status'] = 'E';
            $data['msg'] = 'ข้อมูลซ้ำกับในระบบ';
        } else {
            // $data = false;
            $data['status'] = 'S';
            $data['msg'] = '';
        }

        return response()->json($data);
    }

    public function getEmployee()
    {
        $text  = request()->get('query');
        $data = HREmployee::when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('username', 'like', "%${text}%")
                                ->orWhere('first_name', 'like', "%${text}%")
                                ->orWhere('last_name', 'like', "%${text}%");
                           });
                     })
                     ->limit(20)
                     ->get();
        // dd($data);

        return response()->json($data);
    }

    public function getDepartment()
    {
        $text  = strtolower(request()->get('query'));
        $data  = PtglCoaDeptCodeView::when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->whereRaw("lower(department_code) like '%{$text}%' ")
                                ->orWhereRaw("lower(description) like '%{$text}%' ");
                                // $r->where('department_code', 'like', "%${text}%")
                                // ->orWhere('description', 'like', "%${text}%");
                           });
                     })
                     ->limit(20)
                     ->get();

        return response()->json($data);
    }
}
