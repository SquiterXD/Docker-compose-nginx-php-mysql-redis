<?php 

namespace App\Repositories\IE;

use App\Models\IE\ActivityLog;

class ActivityLogRepo
{
    public function create($parent, $title, $activity, $description = null, $userId = null)
    {
        if(!$userId){
            $userId = \Auth::user()->user_id;
        }
        $activityLog = new ActivityLog();
        $activityLog->user_id  = $userId;
        $activityLog->title = $title;
        $activityLog->activity = $activity;
        $activityLog->last_updated_by = $userId;
        $activityLog->created_by = $userId;
        if($description){
            $activityLog->description = $description;
        }

        $parent->activityLogs()->save($activityLog);
    }

    public static function getActivityMessage($activity,$parent = null)
    {
        $result = '';
        $additionDesc = '';
        
        if($parent){
            $additionDesc = self::getAdditionDesc($parent);
        }

        $activityMessages = [

            'NEW_REQUEST'                    =>  'create new request.',
            'UNBLOCK'                        =>  'unblock request.',
            'RESERVE_ENCUMBRANCE'            =>  'reserve encumbrance request.',
            'UNRESERVE_ENCUMBRANCE'          =>  'unreserve encumbrance request.',
            'SEND_REQUEST'                   =>  'send request'. ($additionDesc ? ' but'.$additionDesc : '') .'.',
            'APPROVER_APPROVE'               =>  'approved'.$additionDesc.' request.',
            'APPROVER_REJECT'                =>  'reject'.$additionDesc.' request.',
            'APPROVER_SENDBACK'              =>  'send back'.$additionDesc.' request.',
            'SET_DUE_DATE'                   =>  'enter due date.',
            'SET_PAID_DATE'                  =>  'enter paid date.',
            'FINANCE_APPROVE'                =>  'approved'.$additionDesc.' request.',
            'FINANCE_REJECT'                 =>  'reject'.$additionDesc.' request.',
            'FINANCE_SENDBACK'               =>  'send back'.$additionDesc.' request.',
            'CLEARING_CREATE_REQUEST'        =>  'create clearing request.',
            'CLEARING_SEND_REQUEST'          =>  'send clearing request'. ($additionDesc ? ' but'.$additionDesc : '') .'.',
            'CLEARING_APPROVER_APPROVE'      =>  'approved clearing'.$additionDesc.' request.',
            'CLEARING_APPROVER_REJECT'       =>  'reject clearing'.$additionDesc.' request.',
            'CLEARING_APPROVER_SENDBACK'     =>  'send back clearing'.$additionDesc.' request.',
            'CLEARING_FINANCE_APPROVE'       =>  'approved clearing'.$additionDesc.' request.',
            'CLEARING_FINANCE_REJECT'        =>  'reject clearing'.$additionDesc.' request.',
            'CLEARING_FINANCE_SENDBACK'      =>  'send back clearing'.$additionDesc.' request.',
            'CANCEL_REQUEST'                 =>  'cancelled request.',
            'RE_APPLY'                       =>  'reapply request.',
            'CHANGE_APPROVER'                =>  'change approver.',
            
        ];
        
        if(array_key_exists($activity, $activityMessages)){
            $result = $activityMessages[$activity];
        }

        return $result;
    }

    private static function getAdditionDesc($parent)
    {
        $additionDesc = '';
        if($parent->over_budget && $parent->exceed_policy){
            $additionDesc = ' over budget and exceed policy';
        }elseif($parent->over_budget){
            $additionDesc = ' over budget';
        }elseif($parent->exceed_policy){
            $additionDesc = ' exceed policy';
        }
        return $additionDesc;
    }

}
