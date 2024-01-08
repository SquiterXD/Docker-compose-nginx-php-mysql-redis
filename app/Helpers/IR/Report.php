<?php
use App\Models\IR\Settings\PolicySetHeader;

function policySetHead($policyId)
{
    $policy = PolicySetHeader::findOrFail($policyId);
    return $policy? $policy->policy_set_description: '';
}