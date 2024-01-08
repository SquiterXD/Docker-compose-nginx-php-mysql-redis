<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRStampInterfaceTemp extends Model
{
    use HasFactory;
    protected $table = "oapp.ptpp_pr_stamp_interface_t";
    public $timestamps = false;
    protected $appends = [
        'pr_create_date_format',
        'need_by_date_format',
        'status_lable_html',
        'cancel_pr_date_format',
    ];

    public function getPrCreateDateFormatAttribute()
    {
        return parseToDateTh(date('Y-m-d', strtotime($this->pr_creation_date)));
    }

    public function getNeedByDateFormatAttribute()
    {
        return parseToDateTh($this->need_by_date);
    }

    public function getStatusLableHtmlAttribute()
    {
        return view('planning.stamp-follow._lable_status', ['status' => trim($this->authorization_status)])->render();
    }

    public function getCancelPrDateFormatAttribute()
    {
        return parseToDateTh($this->cancelled_date);
    }

    public function poLists()
    {
        return $this->hasMany(PRPOStampV::class, 'pr_number', 'pr_number');
    }

    public function callCreatePRPackage($batchNo)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_return_status     varchar2(1) := null ;
                    v_return_msg        varchar2(4000) := null ;
                    begin 
                            ptpp_pr_stamp_inf_pkg.create_pr( p_batch_no         => '{$batchNo}'
                                                           , o_return_status    => :v_return_status
                                                           , o_return_msg       => :v_return_msg
                                                        );

                            dbms_output.put_line('v_return_status = ' || v_return_status);
                            dbms_output.put_line('v_return_msg    = ' || v_return_msg);
                    end ;
                ";

        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callCancelPRPackage($batchNo)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_return_status     varchar2(1) := null ;
                    v_return_msg        varchar2(4000) := null ;
                    begin 
                            ptpp_pr_stamp_inf_pkg.cancel_pr( p_batch_no         => '{$batchNo}'
                                                           , o_return_status    => :v_return_status
                                                           , o_return_msg       => :v_return_msg
                                                        );

                            dbms_output.put_line('v_return_status = ' || v_return_status);
                            dbms_output.put_line('v_return_msg    = ' || v_return_msg);
                    end ;
                ";

        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callCTReportPackage($prNumber)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare 
                    v_return_status     varchar2(1):= null ;
                    v_return_msg        varchar2(4000):= null ;
                    v_request_id        number :=0 ;
                    begin 
                            ptpp_pr_stamp_inf_pkg.submit_report_po_009(p_org_id         => 81
                                                                    , p_pr_num_fr       => '{$prNumber}'
                                                                    , p_pr_num_to       => '{$prNumber}'
                                                                    , o_request_id      => :v_request_id
                                                                    , o_return_status   => :v_return_status
                                                                    , o_return_msg      => :v_return_msg
                                                                );
                            dbms_output.put_line('v_request_id    = '||v_request_id);
                            dbms_output.put_line('v_return_status = '||v_return_status);
                            dbms_output.put_line('v_return_msg    = '||v_return_msg);
                    end ;
                ";

        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_request_id', $result['request_id'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
