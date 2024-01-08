<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmSampleV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_SAMPLES_V';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    public function gmdSample()
    {
        return $this->hasOne(GmdSample::class, 'sample_id', 'oracle_sample_id');
    }

    public function results()
    {
        return $this->hasMany(PtqmResultV::class, 'sample_id', 'oracle_sample_id');
    }

    public function gmdResults()
    {
        return $this->hasMany(GmdResult::class, 'sample_id', 'oracle_sample_id');
    }

    public function primaryResults()
    {
        return $this->hasMany(PtqmResultPrimaryV::class, 'sample_id', 'oracle_sample_id');
    }

    public function siloResults()
    {
        return $this->hasMany(PtqmResultSiloV::class, 'sample_id', 'oracle_sample_id');
    }

    public function machineLocator()
    {
        return $this->belongsTo(PtqmMachineRelationV::class, 'locator_code', 'locator_code');
    }

    public function reportLeakRates()
    {
        return $this->hasMany(PtqmQmr0010V::class, 'sample_no', 'sample_no');
    }

    public function getDateDrawnFormattedAttribute()
    {
        return date("Y-m-d", strtotime($this->date_drawn));
    }

    public function getTimeDrawnFormattedAttribute()
    {
        return date("H:i", strtotime($this->date_drawn));
    }

    public function scopeGetListOpts($query, $organizationId)
    {
        return $query->select('sample_opt')
            // ->where('organization_id', $organizationId)
            ->whereNotNull('sample_opt')
            ->groupBy('sample_opt')
            ->orderBy('sample_opt');
    }

    public function scopeSearch($query, $keywords)
    {

        // sample_no
        if (array_key_exists("sample_no", $keywords)) {
            if ($keywords['sample_no']) {
                $query->where(function ($q) use ($keywords) {
                    $q->where('sample_no', 'like', '%' . $keywords['sample_no'] . '%');
                });
            }
        }

        // sample_no_from && sample_no_to
        if (array_key_exists("sample_no_from", $keywords) && array_key_exists("sample_no_to", $keywords)) {
            if ($keywords['sample_no_from'] && $keywords['sample_no_to']) {
                $query->where(function($q) use ($keywords) {
                    $q->where('sample_no', '>=', $keywords['sample_no_from'])
                    ->where('sample_no', '<=', $keywords['sample_no_to']);
                });
            } elseif ($keywords['sample_no_from']) {
                $query->where('sample_no', 'like', '%' . $keywords['sample_no_from'] . '%');
            } elseif ($keywords['sample_no_to']) {
                $query->where('sample_no', 'like', '%' . $keywords['sample_no_to'] . '%');
            }
        } elseif(array_key_exists("sample_no_from", $keywords)) {
            if ($keywords['sample_no_from']) {
                $query->where('sample_no', 'like', '%' . $keywords['sample_no_from'] . '%');
            }
        } elseif(array_key_exists("sample_no_to", $keywords)) {
            if ($keywords['sample_no_to']) {
                $query->where('sample_no', 'like', '%' . $keywords['sample_no_to'] . '%');
            }
        }

        // qm_group
        if (array_key_exists("qm_group_from", $keywords) && array_key_exists("qm_group_to", $keywords)) {
            if ($keywords['qm_group_from'] && $keywords['qm_group_to']) {
                $query->where(function($query) use ($keywords) {
                    $query->where('qm_group', $keywords['qm_group_from'])
                    ->orWhere('qm_group', $keywords['qm_group_to']);
                });
            } elseif ($keywords['qm_group_from']) {
                $query->where('qm_group', $keywords['qm_group_from']);
            } elseif ($keywords['qm_group_to']) {
                $query->where('qm_group', $keywords['qm_group_to']);
            }
        } elseif(array_key_exists("qm_group_from", $keywords)) {
            if ($keywords['qm_group_from']) {
                $query->where('qm_group', $keywords['qm_group_from']);
            }
        } elseif(array_key_exists("qm_group_to", $keywords)) {
            if ($keywords['qm_group_to']) {
                $query->where('qm_group', $keywords['qm_group_to']);
            }
        }

        // locator_id
        if (array_key_exists("locator_id", $keywords)) {
            if ($keywords['locator_id']) {
                $query->where('locator_id', $keywords['locator_id']);
            }
        }

        // build_name_from && build_name_to
        if (array_key_exists("build_name_from", $keywords) && array_key_exists("build_name_to", $keywords)) {
            if ($keywords['build_name_from'] && $keywords['build_name_to']) {
                $query->where(function($q) use ($keywords) {
                    $q->where('build_name', '>=', $keywords['build_name_from'])
                    ->where('build_name', '<=', $keywords['build_name_to']);
                });
            } elseif ($keywords['build_name_from']) {
                $query->where('build_name', $keywords['build_name_from']);
            } elseif ($keywords['build_name_to']) {
                $query->where('build_name', $keywords['build_name_to']);
            }
        } elseif(array_key_exists("build_name_from", $keywords)) {
            if ($keywords['build_name_from']) {
                $query->where('build_name', $keywords['build_name_from']);
            }
        } elseif(array_key_exists("build_name_to", $keywords)) {
            if ($keywords['build_name_to']) {
                $query->where('build_name', $keywords['build_name_to']);
            }
        }

        // department_name_from && department_name_to
        if (array_key_exists("department_name_from", $keywords) && array_key_exists("department_name_to", $keywords)) {
            if ($keywords['department_name_from'] && $keywords['department_name_to']) {
                $query->where(function($q) use ($keywords) {
                    $q->where('department_name', '>=', $keywords['department_name_from'])
                    ->where('department_name', '<=', $keywords['department_name_to']);
                });
            } elseif ($keywords['department_name_from']) {
                $query->where('department_name', $keywords['department_name_from']);
            } elseif ($keywords['department_name_to']) {
                $query->where('department_name', $keywords['department_name_to']);
            }
            
        } elseif(array_key_exists("department_name_from", $keywords)) {
            if ($keywords['department_name_from']) {
                $query->where('department_name', $keywords['department_name_from']);
            }
        } elseif(array_key_exists("department_name_to", $keywords)) {
            if ($keywords['department_name_to']) {
                $query->where('department_name', $keywords['department_name_to']);
            }
        }

        // location_desc_from && location_desc_to
        if (array_key_exists("location_desc_from", $keywords) && array_key_exists("location_desc_to", $keywords)) {
            if ($keywords['location_desc_from'] && $keywords['location_desc_to']) {
                $query->where(function($q) use ($keywords) {
                    $q->where('location_desc', '>=', $keywords['location_desc_from'])
                    ->where('location_desc', '<=', $keywords['location_desc_to']);
                });
            } elseif ($keywords['location_desc_from']) {
                $query->where('location_desc', $keywords['location_desc_from']);
            } elseif ($keywords['location_desc_to']) {
                $query->where('location_desc', $keywords['location_desc_to']);
            }
        } elseif(array_key_exists("location_desc_from", $keywords)) {
            if ($keywords['location_desc_from']) {
                $query->where('location_desc', $keywords['location_desc_from']);
            }
        } elseif(array_key_exists("location_desc_to", $keywords)) {
            if ($keywords['location_desc_to']) {
                $query->where('location_desc', $keywords['location_desc_to']);
            }
        }

        // locator_desc_from && locator_desc_to
        if (array_key_exists("locator_desc_from", $keywords) && array_key_exists("locator_desc_to", $keywords)) {
            if ($keywords['locator_desc_from'] && $keywords['locator_desc_to']) {
                $query->where(function($q) use ($keywords) {
                    $q->where('locator_desc', '>=', $keywords['locator_desc_from'])
                    ->where('locator_desc', '<=', $keywords['locator_desc_to']);
                });
            } elseif ($keywords['locator_desc_from']) {
                $query->where('locator_desc', $keywords['locator_desc_from']);
            } elseif ($keywords['locator_desc_to']) {
                $query->where('locator_desc', $keywords['locator_desc_to']);
            }
        } elseif(array_key_exists("locator_desc_from", $keywords)) {
            if ($keywords['locator_desc_from']) {
                $query->where('locator_desc', $keywords['locator_desc_from']);
            }
        } elseif(array_key_exists("locator_desc_to", $keywords)) {
            if ($keywords['locator_desc_to']) {
                $query->where('locator_desc', $keywords['locator_desc_to']);
            }
        }

        // opt
        if (array_key_exists("opt", $keywords)) {
            if ($keywords['opt']) {
                $query->where('opt', $keywords['opt']);
            }
        }

        // sample_opt
        if (array_key_exists("sample_opt", $keywords)) {
            if ($keywords['sample_opt']) {
                $query->where('sample_opt', $keywords['sample_opt']);
            }
        }

        // qc_area
        if (array_key_exists("qc_area", $keywords)) {
            if ($keywords['qc_area']) {
                $query->where('qc_area', $keywords['qc_area']);
            }
        }

        // task_type_code
        if (array_key_exists("task_type_code", $keywords)) {
            if ($keywords['task_type_code']) {
                $query->where('task_type_code', $keywords['task_type_code']);
            }
        }
        
        // machine_set
        if (array_key_exists("machine_set", $keywords)) {
            if ($keywords['machine_set']) {
                $query->where('machine_set', $keywords['machine_set']);
            }
        }

        // machine_name
        if (array_key_exists("machine_name", $keywords)) {
            if ($keywords['machine_name']) {
                $query->where('machine_name', $keywords['machine_name']);
            }
        }

        // qtm_brand
        if (array_key_exists("qtm_brand", $keywords)) {
            if ($keywords['qtm_brand']) {
                $query->where('lot_number', $keywords['qtm_brand']);
            }
        }

        // qtm_maker
        if (array_key_exists("qtm_maker", $keywords)) {
            if ($keywords['qtm_maker']) {
                $query->where('maker', $keywords['qtm_maker']);
            }
        }

        // brand
        if (array_key_exists("brand", $keywords)) {
            if ($keywords['brand']) {
                $query->where('brand', $keywords['brand']);
            }
        }

        // maker
        if (array_key_exists("maker", $keywords)) {
            if ($keywords['maker']) {
                $query->where('maker', $keywords['maker']);
            }
        }

        // sample_date_from
        if (array_key_exists("sample_date_from", $keywords)) {
            if ($keywords['sample_date_from']) {
                if($keywords['sample_time_from'] && !isset($keywords['skip_sample_time_from'])) {
                    $query->where('date_drawn', '>=', parseFromDateTh($keywords['sample_date_from'])." ". $keywords['sample_time_from'] .":00");
                } else {
                    $query->where('date_drawn', '>=', parseFromDateTh($keywords['sample_date_from'])." 00:00:00");
                }
            }
        }
        // sample_date_to
        if (array_key_exists("sample_date_to", $keywords)) {
            if ($keywords['sample_date_to']) {
                if($keywords['sample_time_to'] && !isset($keywords['skip_sample_time_to'])) {
                    $query->where('date_drawn', '<=', parseFromDateTh($keywords['sample_date_to'])." ". $keywords['sample_time_to'] .":59");
                } else {
                    $query->where('date_drawn', '<=', parseFromDateTh($keywords['sample_date_to'])." 23:59:59");
                }
            }
        }

        // sample_disposition
        if (array_key_exists("pending_sample_disposition", $keywords) || array_key_exists("incorrect_sample_disposition", $keywords) || array_key_exists("correct_sample_disposition", $keywords)) {

            if ($keywords['pending_sample_disposition'] == "true" && $keywords['incorrect_sample_disposition'] == "true" && $keywords['correct_sample_disposition'] == "true") {
                // SELECT ALL
            } else {
                $whereInSampleDispositions = [];
                array_push($whereInSampleDispositions, "4A");
                array_push($whereInSampleDispositions, "5AV");
                array_push($whereInSampleDispositions, "6RJ");
                if ($keywords['pending_sample_disposition'] == "true") {
                    array_push($whereInSampleDispositions, "1P");
                }
                if ($keywords['incorrect_sample_disposition'] == "true") {
                    array_push($whereInSampleDispositions, "2I");
                }
                if ($keywords['correct_sample_disposition'] == "true") {
                    array_push($whereInSampleDispositions, "3C");
                }
                $query->whereIn('sample_disposition', $whereInSampleDispositions);
            }

        }

        // sample_operation_status
        if (array_key_exists("pending_sample_operation_status", $keywords) || array_key_exists("inprogress_sample_operation_status", $keywords) || array_key_exists("completed_sample_operation_status", $keywords) || array_key_exists("rejected_sample_operation_status", $keywords)) {

            if ($keywords['pending_sample_operation_status'] == "true" && $keywords['inprogress_sample_operation_status'] == "true" && $keywords['completed_sample_operation_status'] == "true" && $keywords['rejected_sample_operation_status'] == "true") {
                // SELECT ALL
            } else {
                $whereInSampleOperationStatus = [];
                if ($keywords['pending_sample_operation_status'] == "true") {
                    array_push($whereInSampleOperationStatus, "");
                    array_push($whereInSampleOperationStatus, "PD");
                }
                if ($keywords['inprogress_sample_operation_status'] == "true") {
                    array_push($whereInSampleOperationStatus, "IP");
                }
                if ($keywords['completed_sample_operation_status'] == "true") {
                    array_push($whereInSampleOperationStatus, "CP");
                }
                if ($keywords['rejected_sample_operation_status'] == "true") {
                    array_push($whereInSampleOperationStatus, "RJ");
                }

                if ($keywords['pending_sample_operation_status'] == "true") {
                    $query->where(function($query) use ($whereInSampleOperationStatus) {
                        $query->whereIn('result_set_status', $whereInSampleOperationStatus)
                        ->orWhereNull('result_set_status');
                    });
                } else {
                    $query->whereIn('result_set_status', $whereInSampleOperationStatus);
                }
            }

        }

        // sample_result_status
        if (array_key_exists("pending_sample_result_status", $keywords) || array_key_exists("conform_sample_result_status", $keywords) || array_key_exists("nonconform_sample_result_status", $keywords) || array_key_exists("rejected_sample_result_status", $keywords)) {

            if($keywords['pending_sample_result_status'] == "true" && $keywords['conform_sample_result_status'] == "true" && $keywords['nonconform_sample_result_status'] == "true" && $keywords['rejected_sample_result_status'] == "true") {
                // SELECT ALL
            } else {
                $whereInSampleResultStatus = [];
                if ($keywords['pending_sample_result_status'] == "true") {
                    array_push($whereInSampleResultStatus, "");
                    array_push($whereInSampleResultStatus, "PD");
                }
                if ($keywords['conform_sample_result_status'] == "true") {
                    array_push($whereInSampleResultStatus, "CF");
                }
                if ($keywords['nonconform_sample_result_status'] == "true") {
                    array_push($whereInSampleResultStatus, "NC");
                }
                if ($keywords['rejected_sample_result_status'] == "true") {
                    array_push($whereInSampleResultStatus, "RJ");
                }

                if ($keywords['pending_sample_result_status'] == "true") {
                    $query->where(function($query) use ($whereInSampleResultStatus) {
                        $query->whereIn('result_set_conformity', $whereInSampleResultStatus)
                        ->orWhereNull('result_set_conformity');
                    });
                } else {
                    $query->whereIn('result_set_conformity', $whereInSampleResultStatus);
                }
            }

        }

        // approve_status
        if(array_key_exists("approval_role_level_code", $keywords)) { 

            if($keywords['pending_approval_status'] == "true" && $keywords['approved_approval_status'] == "true" && $keywords['rejected_approval_status'] == "true") {
                // SELECT ALL
            } else {

                $whereInApproveStatus = [];

                if($keywords['approval_role_level_code'] == "1") { // OPERATOR

                    if($keywords['pending_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "");
                        array_push($whereInApproveStatus, "10");
                        array_push($whereInApproveStatus, "20");
                    }
                    if($keywords['approved_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "11");
                        array_push($whereInApproveStatus, "21");
                        array_push($whereInApproveStatus, "31");
                    }
                    if($keywords['rejected_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "12");
                        array_push($whereInApproveStatus, "22");
                        array_push($whereInApproveStatus, "32");
                    }
                    
                }

                if($keywords['approval_role_level_code'] == "2") { // SUPERVISOR

                    if($keywords['pending_approval_status'] == "true") {
                        if($keywords['approval_step_level'] == "2") {
                            array_push($whereInApproveStatus, "");
                            array_push($whereInApproveStatus, "10");
                        }
                        array_push($whereInApproveStatus, "11");
                        array_push($whereInApproveStatus, "20");
                    }
                    if($keywords['approved_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "21");
                        array_push($whereInApproveStatus, "31");
                    }
                    if($keywords['rejected_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "12");
                        array_push($whereInApproveStatus, "22");
                        array_push($whereInApproveStatus, "32");
                    }

                }

                if($keywords['approval_role_level_code'] == "3") { // LEADER

                    if($keywords['pending_approval_status'] == "true") {
                        // array_push($whereInApproveStatus, "");
                        // array_push($whereInApproveStatus, "10");
                        // array_push($whereInApproveStatus, "11");
                        // array_push($whereInApproveStatus, "20");
                        array_push($whereInApproveStatus, "21");
                    }
                    if($keywords['approved_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "31");
                    }
                    if($keywords['rejected_approval_status'] == "true") {
                        array_push($whereInApproveStatus, "12");
                        array_push($whereInApproveStatus, "22");
                        array_push($whereInApproveStatus, "32");
                    }
                    
                }

                if($keywords['pending_approval_status'] == "true" && ( $keywords['approval_role_level_code'] == "1" || ( $keywords['approval_role_level_code'] == "2" && $keywords['approval_step_level'] == "2" ) ) ) {
                    $query->where(function($query) use ($whereInApproveStatus) {
                        $query->whereIn('approve_status', $whereInApproveStatus)
                        ->orWhereNull('approve_status');
                    });
                } else {
                    $query->whereIn('approve_status', $whereInApproveStatus);
                }

            }

        }

        return $query;
    }

    public function scopeGetListQtmMachineNames($query)
    {
        return $query->select(DB::raw("machine_name as machine_name_value, 'QTM'||machine_name as machine_name_label, machine_name"))
            ->whereNotNull('machine_name')
            ->where('program_code', 'QMP0003')
            ->groupBy('machine_name')
            ->orderBy('machine_name');
    }


}
