<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\PersonsRequest;
use App\Models\IR\PtirPersons;
use App\Models\IR\PtirWebUtilitiesPkg;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class PersonsController extends Controller
{
    protected $userId;
    protected $listId = [];

    public function __construct()
    {
        $this->userId = optional(auth()->user())->user_id ?? -1;
    }
   /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\IR\Settings\PersonsRequest
     * @return \Illuminate\Http\Response
     */
    public function index(PersonsRequest $request)
    {
        $collection = (new PtirPersons())->getAllPerson($request->year,
                                                        $request->policy_type_code,
                                                        $request->invoice_type,
                                                        $request->status);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\PersonseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdate(PersonsRequest $request)
    {
        $requestData = $request->all()['data'];
        $i = 0;
        foreach($requestData as $index) {
            $validator = Validator::make($index, [
            ]);

            $validator->validate();
            $data['person_id']              = isset($index['person_id']) ? $index['person_id'] : '';
            $data['document_number']        = isset($index['document_number']) ? $index['document_number'] : '';
            $data['status']                 = isset($index['status']) ? strtoupper($index['status']) : '';
            $data['year']                   = isset($index['year']) ? convertYearToAd($index['year']) : '';
            $data['invoice_type']           = isset($index['invoice_type']) ? $index['invoice_type'] : '';
            $data['invoice_number']         = isset($index['invoice_number']) ? $index['invoice_number'] : '';
            $data['voucher_number']         = isset($index['voucher_number']) ? $index['voucher_number'] : '';
            $data['policy_number']          = isset($index['policy_number']) ? $index['policy_number'] : '';
            $data['start_date']             = isset($index['start_date']) ? parseFromDateTh($index['start_date']) : '';
            $data['end_date']               = isset($index['end_date']) ? parseFromDateTh($index['end_date']) : '';
            $data['total_days']             = isset($index['total_days']) ? $index['total_days'] : '';
            $data['person_name']            = isset($index['person_name']) ? $index['person_name'] : '';
            $data['policy_type_code']       = isset($index['policy_type_code']) ? $index['policy_type_code'] : '';
            $data['policy_type_name']       = isset($index['policy_type_name']) ? $index['policy_type_name'] : '';
            $data['insurance_amount']       = isset($index['insurance_amount']) ? $index['insurance_amount'] : '';
            $data['discount_amount']        = isset($index['discount']) ? str_replace(',', '',$index['discount']) : 0;
            $data['duty_amount']            = isset($index['duty_amount']) ? str_replace(',', '',$index['duty_amount']) : '';
            $data['vat_amount']             = isset($index['vat_amount']) ? str_replace(',', '',$index['vat_amount']) : '';
            $data['net_amount']             = isset($index['net_amount']) ? str_replace(',', '',$index['net_amount']) : '';
            $data['company_id']             = isset($index['company_id']) ? $index['company_id'] : '';
            $data['company_name']           = isset($index['company_name']) ? $index['company_name'] : '';
            $data['expense_account_id']     = isset($index['expense_account_id']) ? $index['expense_account_id'] : '';
            $data['expense_account']        = isset($index['expense_account']) ? $index['expense_account'] : '';
            $data['expense_account_desc']   = isset($index['expense_account_desc']) ? $index['expense_account_desc'] : '';
            $data['expense_flag']           = isset($index['expense_flag']) ? $index['expense_flag'] : '';
            $data['policy_set_header_id']   = isset($index['policy_set_header_id']) ? $index['policy_set_header_id'] : '';
            $data['payment_status']         = isset($index['payment_status']) ? $index['payment_status'] : '';
            $data['payment_date']           = isset($index['payment_date']) ? parseFromDateTh($index['payment_date']) : '';
            $data['premium_rate']           = isset($index['premium_rate']) ? $index['premium_rate'] : '';
            $data['revenue_stamp']          = isset($index['revenue_stamp']) ? $index['revenue_stamp'] : '';
            $data['tax']                    = isset($index['tax']) ? $index['tax'] : '';
            $data['prepaid_insurance']      = isset($index['prepaid_insurance']) ? $index['prepaid_insurance'] : '';
            $data['program_code']           = isset($index['program_code']) ? $index['program_code'] : 'IRP0007';
            $data['created_at']             = Carbon::now();
            $data['created_by_id']          = $this->userId;
            $data['created_by']             = $this->userId;
            $data['last_updated_by']        = $this->userId;
            $data['updated_at']             = Carbon::now();
            $data['creation_date']          = Carbon::now();
            $data['last_update_date']       = Carbon::now();
            $i += 1;

            try {

                DB::beginTransaction();;
                if ($data['expense_account_id'] == '') {
                    $id = DB::table('ptir_accounts_mapping_v')
                        ->where('account_combine',$data['expense_account'])
                        ->first();
                    if($id){
                        $data['expense_account_id'] = $id->account_id;
                    }else{
                        $response = error('ไม่มีรหัสบัญชีนี้ โปรดเลือกบัญชีใหม่');
                        DB::rollback();
                        return response($response, $response['status']);
                    }
                }
                $stockHeader = PtirPersons::find($data['person_id']);
                if ($stockHeader !== null)
                {
                    (new PtirPersons())->updatePersons($data);
                }
                else
                {
                    $persons = PtirPersons::create($data);
                    $data['person_id'] = $persons->person_id;
                }

                DB::commit();

                if ($data['document_number'] == '')
                {
                    $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['person_id'])['document_number'];
                }
                (new PtirPersons())->updatePersons($data);
                $this->listId[$i - 1]['person_id'] = $data['person_id'];
                $this->listId[$i - 1]['document_number'] = $data['document_number'];
                $this->listId[$i - 1]['row_id'] = isset($index['row_id']) ? $index['row_id'] : '';

                DB::commit();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError($e->getMessage());
            }
        }

        $obj = new \stdClass();
        $obj->rows = $this->listId;

        $response   = success($obj);
        return response($response, $response['status']);
    }

    public function duplicateCheck(PersonsRequest $request)
    {
        $requestData = $request->all()['data'];
        $rows = $requestData['rows'];
        for($i = 0; $i < count($rows); $i++) {
            if ($i != count($rows)-1 && $i != $requestData['row_id'])
            {
                if ($rows[$i]['year'] == $requestData['year'] && $rows[$i]['person_name'] == $requestData['person_name'] &&
                    $rows[$i]['policy_type_code'] == $requestData['policy_type_code'] && $rows[$i]['status'] != 'Cancelled')
                {
                    $response = duplicate();
                    return response($response, $response['status']);
                }
            }

            if ($rows[$i]['status'] != 'Cancelled' && $rows[$i]['person_name'] == $requestData['person_name']) {
                $person = PtirPersons::where('year', convertYearToAd($requestData['year']))
                                        ->where('person_name', $requestData['person_name'])
                                        ->where('policy_type_code', $requestData['policy_type_code'])
                                        ->where('status', '!=', 'CANCELLED')
                                        ->first();

                if ($person != null) {
                    $response = duplicate();
                    return response($response, $response['status']);
                }
            }
        }

        $response = duplicate('ข้อมูลไม่ซ้ำ', 200);

        return response($response, $response['status']);
    }

    public function updateStatus(PersonsRequest $request)
    {
        $requestData = $request->all()['data'];
        $db = PtirPersons::find($requestData['person_id']);
        $db->status                = isset($requestData['status']) ? $requestData['status'] : $db->status;
        $db->updated_at            = Carbon::now();
        $db->last_updated_by       = $this->userId;
        $db->last_update_date      = Carbon::now();
        $db->save();
    }

    public function invoiceNumberCheck(PersonsRequest $request)
    {
        $requestData = $request->all()['data'];
        $rows = $requestData['rows'];
        $data = [];
        foreach ($rows as $index => $row){
            if($requestData['row_id'] === $row['row_id']){
                $person = PtirPersons::where('invoice_number', $requestData['invoice_number'])
                                      ->first();

                if ($person != null) {
                    $response = duplicate();
                    return response($response, $response['status']);
                }
            }else {
                if ($rows[$index]['invoice_number'] == $requestData['invoice_number'])
                {
                    $response = duplicate();
                    return response($response, $response['status']);
                }
            }
        }

        $response = duplicate('ข้อมูลไม่ซ้ำ', 200);

        return response($response, $response['status']);
    }

    public function destroy()
    {
        $person = PtirPersons::find(request()->person_id);
        $person->delete();

        return response('success');
    }
}
