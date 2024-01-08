<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Models\IR\Settings\SubGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxSubGroupsController extends Controller
{
    public function show($id)
    {
        $subGroups = SubGroups::where('policy_set_header_id', $id)->get();
        return view('ir.settings.sub-groups._table_edit_rows', compact('subGroups'));
        return response()->json(['subGroups' => $subGroups]);
    }

    public function checkPolicy($policy_id)
    {
        $subGroups = SubGroups::where('policy_set_header_id', $policy_id)->get();
        $status = '';
        if (count($subGroups)) {
            $status = 'Y';
        }
        return response()->json(['status' => $status]);
    }
}
