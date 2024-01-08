<?php

    function activeIcon($active)
    {
        if($active){ 
        	return '<span class="label label-primary">Active</span>'; 
        }else{
        	return '<span class="label bg-secondary text-white">Inactive</span>';
        }
    }

    function activeMiniIcon($active)
    {
        if($active){ 
            return '<i class="fa fa-circle text-navy"></i>'; 
        }else{
            return '<i class="fa fa-circle "></i>';
        }
    }

    function checkCircleIcon($check)
    {
        if($check){ 
        	return '<i class="fa fa-check text-navy"></i>'; 
        }else{
        	return '';
        }
    }

    function statusIconCA($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                $result = '<span class="label-status bg-primary text-white"> NEW REQUEST </span>';
                break;
            case "BLOCKED":
                $result = '<span class="label-status btn-danger btn-outline"> BLOCKED </span>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status bg-warning text-white"> APPROVER DECISION </span>';
                $result = '<span class="label-status bg-warning text-white"> DECISION </span>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status bg-danger text-white"> APPROVER REJECTED </span>';
                $result = '<span class="label-status bg-danger text-white"> REJECTED </span>';
                break;
            case "FINANCE_PROCESS":
                // $result = '<span class="label-status bg-warning text-white"> FINANCE PROCESS </span>';
                $result = '<span class="label-status bg-warning text-white"> PROCESS </span>';
                break;
            case "FINANCE_REJECTED":
                // $result = '<span class="label-status bg-danger text-white"> FINANCE REJECTED </span>';
                $result = '<span class="label-status bg-danger text-white"> REJECTED </span>';
                break;
            case "APPROVED":
                $result = '<span class="label-status bg-success text-white"> APPROVED </span>';
                break;
            case "CLEARING_REQUEST":
                // $result = '<span class="label-status bg-primary text-white"> CLEARING REQUEST </span>';
                $result = '<span class="label-status bg-info text-white">CLEARING REQUEST </span>';
                break;
            case "CLEARING_APPROVER_DECISION":
                // $result = '<span class="label-status bg-warning text-white"> CLEARING APPROVER DECISION </span>';
                $result = '<span class="label-status bg-warning text-white"> DECISION </span>';
                break;
            case "CLEARING_APPROVER_REJECTED":
                // $result = '<span class="label-status bg-danger text-white"> CLEARING APPROVER REJECTED </span>';
                $result = '<span class="label-status bg-danger text-white"> REJECTED </span>';
                break;
            case "CLEARING_FINANCE_PROCESS":
                // $result = '<span class="label-status bg-warning text-white"> CLEARING FINANCE PROCESS </span>';
                $result = '<span class="label-status bg-warning text-white"> PROCESS </span>';
                break;
            case "CLEARING_FINANCE_REJECTED":
                // $result = '<span class="label-status bg-danger text-white"> CLEARING FINANCE REJECTED </span>';
                $result = '<span class="label-status bg-danger text-white"> REJECTED </span>';
                break;
            case "CLEARED":
                $result = '<span class="label-status bg-success btn-outline"> CLEARED </span>';
                break;
            case "CANCELLED":
                $result = '<span class="label-status bg-danger text-white"> CANCELLED </span>';
                break;
        }
        return $result;
    }

    function statusIconREIM($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                $result = '<span class="label-status bg-primary text-white "> NEW REQUEST </span>';
                break;
            case "RESERVE_ENCUMBRANCE":
                $result = '<span class="label-status bg-warning text-white"> RESERVE ENCUMBRANCE </span>';
                break;
            case "BLOCKED":
                $result = '<span class="label-status btn-danger btn-outline"> BLOCKED </span>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status bg-warning text-white"> APPROVER DECISION </span>';
                $result = '<span class="label-status bg-warning text-white"> DECISION </span>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status bg-danger text-white"> APPROVER REJECTED </span>';
                $result = '<span class="label-status bg-danger text-white"> REJECTED </span>';
                break;
            case "APPROVED":
                $result = '<span class="label-status bg-success text-white"> APPROVED </span>';
                break;
            case "CANCELLED":
                $result = '<span class="label-status bg-danger text-white"> CANCELLED </span>';
                break;
        }
        return $result;
    }

    function statusMiniIconCA($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                // $result = '<span class="label-status bg-primary text-white" title="NEW REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle" title="NEW REQUEST"></i>';
                break;
            case "BLOCKED":
                // $result = '<span class="label-status btn-danger btn-outline" title="BLOCKED"> &nbsp; </span>';
                $result = '<i class="fa fa-ban text-danger" title="BLOCKED"></i>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status bg-warning text-white" title="APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="DECISION"></i>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status bg-danger text-white" title="APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="REJECTED"></i>';
                break;
            case "FINANCE_PROCESS":
                // $result = '<span class="label-status bg-warning text-white" title="FINANCE PROCESS"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="PROCESS"></i>';
                break;
            case "FINANCE_REJECTED":
                // $result = '<span class="label-status bg-danger text-white" title="FINANCE REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="REJECTED"></i>';
                break;
            case "APPROVED":
                // $result = '<span class="label-status bg-success text-white" title="APPROVED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-success" title="APPROVED"></i>';
                break;
            case "CLEARING_REQUEST":
                // $result = '<span class="label-status bg-primary text-white" title="CLEARING REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o" title="CLEARING REQUEST"></i>';
                break;
            case "CLEARING_APPROVER_DECISION":
                // $result = '<span class="label-status bg-warning text-white" title="CLEARING APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-warning" title="DECISION"></i>';
                break;
            case "CLEARING_APPROVER_REJECTED":
                // $result = '<span class="label-status bg-danger text-white" title="CLEARING APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-danger" title="REJECTED"></i>';
                break;
            case "CLEARING_FINANCE_PROCESS":
                // $result = '<span class="label-status bg-warning text-white" title="CLEARING FINANCE PROCESS"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-warning" title="PROCESS"></i>';
                break;
            case "CLEARING_FINANCE_REJECTED":
                // $result = '<span class="label-status bg-danger text-white" title="CLEARING FINANCE REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-danger" title="REJECTED"></i>';
                break;
            case "CLEARED":
                // $result = '<span class="label-status btn-success btn-outline" title="CLEARED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle-o text-success" title="CLEARED"></i>';
                break;
            case "CANCELLED":
                // $result = '<span class="label-status bg-danger text-white" title="CANCELLED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-danger" title="CANCELLED"></i>';
                break;
        }
        return $result;
    }

    function statusMiniIconREIM($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                // $result = '<span class="label-status bg-primary text-white" title="NEW REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle" title="NEW REQUEST"></i>';
                break;
            case "RESERVE_ENCUMBRANCE":
                $result = '<i class="fa fa-circle" title="RESERVE ENCUMBRANCE"></i>';
                break;
            case "BLOCKED":
                // $result = '<span class="label-status btn-danger btn-outline" title="BLOCKED"> &nbsp; </span>';
                $result = '<i class="fa fa-ban text-danger" title="BLOCKED"></i>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status bg-warning text-white" title="APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="DECISION"></i>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status bg-danger text-white" title="APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="REJECTED"></i>';
                break;
            case "APPROVED":
                // $result = '<span class="label-status bg-success text-white" title="APPROVED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-success" title="APPROVED"></i>';
                break;
            case "CANCELLED":
                // $result = '<span class="label-status bg-danger text-white" title="CANCELLED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-danger" title="CANCELLED"></i>';
                break;
        }
        return $result;
    }

    function statusIconInterface($status)
    {
        $result = "";
        switch ($status) {
            case "P":
                $result = '<span class="label-status btn-warning btn-outline"> PENDING... </span>';
                break;
            case "S":
                $result = '<span class="label-status bg-success btn-outline"> SUCCESS </span>';
                break;
            case "E":
                $result = '<span class="label-status btn-danger btn-outline"> ERROR </span>';
                break;
        }
        return $result;
    }

    function statusMiniIconInterface($status)
    {
        $result = "";
        switch ($status) {
            case "P":
                // $result = '<span class="label-status btn-warning btn-outline"> PENDING... </span>';
                $result = '<i class="fa fa-spinner text-warning" title="PENDING..."></i>';
                break;
            case "S":
                // $result = '<span class="label-status btn-success btn-outline"> SUCCESS </span>';
                $result = '<i class="fa fa-check-circle text-success" title="SUCCESS"></i>';
                break;
            case "E":
                // $result = '<span class="label-status btn-danger btn-outline"> ERROR </span>';
                $result = '<i class="fa fa-times-circle text-danger" title="ERROR"></i>';
                break;
        }
        return $result;
    }
