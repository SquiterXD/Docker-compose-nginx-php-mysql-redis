<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\Ptom\PtomClaimHeader;
use App\Repositories\OM\ClaimHeaderRepo;
use App\Repositories\OM\ClaimLineRepo;
use App\Repositories\OM\ClaimStatusVRepo;
use App\Repositories\OM\ProformaInvoiceRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClaimApproveApiController extends Controller
{
    protected $repo, $header, $line, $status;
    public function __construct(ProformaInvoiceRepo $repo, ClaimHeaderRepo $header, ClaimLineRepo $line, ClaimStatusVRepo $status)
    {
        $this->header = $header;
        $this->line   = $line;
        $this->repo   = $repo;
        $this->status   = $status;
    }

    public function getClaim(Request $request) 
    {
        try {
            return response()->json($this->header->getClaimRepo($request));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status'=> 'error']);
        }
    }


    public function getCustomer(Request $request) 
    {
        $customer = Customer::query();
        $customer->where(function($q) use($request) {
            $q->where('customer_number', 'LIKE', '%'. $request->qs .'%');
            $q->orwhere('customer_name', 'LIKE', '%'. $request->qs .'%');
        });
        $customer->where('sales_classification_code', 'Export')->orderBy('customer_id');
        $customer->selectRaw($request->field);
        return response()->json($customer->get(), 200);
    }

    public function getListInvoiceNumber(Request $request)
    {
        return $this->repo->getListsInvoiceNumber($request);
    }

    public function getClaimListNum(Request $request)
    {
        return response()->json($this->header->getClaimListNumber($request));
    }

    public function getListInvoice(Request $request)
    {
        return response()->json($this->repo->getInvoice($request));
    }
    public function updateHeader(Request $request)
    {
        $this->header->update($request);
    }
    public function closeHeaderClaim(Request $request)
    {
        $this->header->closeClaim($request);
    }

    public function getListHeaderDatatable(Request $request)
    {
        dd($this->header->getHeaders($request));
        $default = [
            'draw' => 1,
            "recordsTotal" => 57,
            "recordsFiltered" => 57,
            "data" => []
        ];

        return $default;
    }
    public function getListHeader(Request $request)
    {
        return response()->json($this->header->getHeaders($request));
    }
    public function storeHeader($request, $number)
    {
        return $this->header->store($request, $number);
    }
    public function claimStatusAction(Request $request)
    {
        switch ($request->type) {
            case 'cancel_status':
                $res = PtomClaimHeader::where('claim_number', $request->id)->update(['STATUS_CLAIM_CODE' => 9, 'STATUS_CLAIM' => 'ยกเลิก']);
                break;
            case 'confirm_credit_not':
                $res = PtomClaimHeader::where('claim_number', $request->id)->update(['STATUS_CLAIM_CODE' => 7, 'STATUS_CLAIM' => 'Credit Note Issued']);
                break;
            case 'confirm_to_be_delivered':
                $res = PtomClaimHeader::where('claim_number', $request->id)->update(['STATUS_CLAIM_CODE' => 6, 'STATUS_CLAIM' => 'Delivered']);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
    public function storeLine($request, $number, $header)
    {
        return $this->line->store($request, $number, $header);
    }
    public function claimStatusList()
    {
        return $this->status->getList();
    }
    public function getClaimNumber(Request $request)
    {
        return $this->header->getClaimNumber($request);
    }


    public function genarateClaimDoc(Request $request)
    {
        $lv_doc_sequence_number = '';
        $lv_return_status = '';
        $lv_return_msg = '';
        $command = "DECLARE 
        LV_DOC_SEQUENCE_NUMBER VARCHAR2(100) := NULL;
        LV_RETURN_STATUS VARCHAR2(100) := NULL;
        LV_RETURN_MSG VARCHAR2(4000) := NULL;
        BEGIN
            PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER (	
            I_DOCUMENT_CODE => 'OMP0081_CLAIM_NUM_EXP', 
            O_DOC_SEQUENCE_NUMBER => :LV_DOC_SEQUENCE_NUMBER, 
            O_RETURN_STATUS => :LV_RETURN_STATUS, 
            O_RETURN_MSG => :LV_RETURN_MSG 
            );
        END;";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($command);
        // Binding param v_result
        $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $lv_doc_sequence_number, \PDO::PARAM_STR, 100);
        $stmt->bindParam(':LV_RETURN_STATUS', $lv_return_status, \PDO::PARAM_STR, 100);
        $stmt->bindParam(':LV_RETURN_MSG', $lv_return_msg, \PDO::PARAM_STR, 4000);
        $ret_code = $stmt->execute();
        if ($request->gen_documents == true) {
        } else {
            DB::beginTransaction();
            $header = $this->storeHeader($request, $lv_doc_sequence_number);
            $dataLines = $this->storeLine($request, $lv_doc_sequence_number, $header->claim_header_id);
            #status code 100 ไม่สามารถบันทึกได้เนื่องจากจำนวนขอเคลมเกินจำนวนที่ซื้อ
            if (@$dataLines['status'] === false) {
                DB::rollback();
                return ['status' => false, 'code' => 100];
            };
        }
        // DB::rollBack();
        DB::commit();
        return ['lv_doc_sequence_number' => $lv_doc_sequence_number, 'date_current' => now(), 'lv_return_status' => $lv_return_status, 'lv_return_msg' => $lv_return_msg, 'data_lines' => $dataLines ?? []];
    }
}
