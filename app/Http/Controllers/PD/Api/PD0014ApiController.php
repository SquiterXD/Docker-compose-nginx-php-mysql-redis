<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PD\PtpdSalesFiscalYearV;
use App\Models\PD\PtpdEstimateMtSaleHeader;
use App\Models\PD\PtpdEstimateMtSaleLine;
use App\Models\PD\PtdpItemEstimateMtSaleV;
use App\Models\PD\PtdpSpeciesForecastV;
use PDO;
use DB;
use App\Models\User;

class PD0014ApiController extends Controller
{
    public function getYears()
    {
        $userProfile = getDefaultData('/pd/');

        $years = PtpdSalesFiscalYearV::selectRaw('DISTINCT sales_fiscal_year_th , sales_fiscal_year_eng')
            ->orderBy('sales_fiscal_year_th')
            ->get();

        return response()->json([
            'years' => $years,
        ]);
    }

    public function searchHeaders()
    {
        $request = request();
        $headers = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT    fiscal_year_th,
                                                                    sales_fiscal_year_no,
                                                                    sales_fiscal_year_revision,
                                                                    fiscal_year_vision,
                                                                    tran_approval_date,
                                                                    tran_status,
                                                                    web_h_id,
                                                                    user_name")
                    ->when($request->year, function($q) use ($request) {
                        $q->where('fiscal_year_th', $request->year);
                    })
                    ->when($request->salesFiscalYearNo, function($q) use ($request) {
                        $q->where('sales_fiscal_year_no', $request->salesFiscalYearNo);
                    })
                    ->when($request->salesFiscalYearRevision, function($q) use ($request) {
                        $q->where('sales_fiscal_year_revision', $request->salesFiscalYearRevision);
                    })
                    ->when($request->fiscalYearVision, function($q) use ($request) {
                        $q->where('fiscal_year_vision', $request->fiscalYearVision);
                    })
                    ->whereNotNull('fiscal_year_vision')
                    ->orderBy('fiscal_year_th', 'desc')
                    ->orderBy('fiscal_year_vision', 'desc')
                    ->orderBy('sales_fiscal_year_revision', 'desc')
                    ->get([ 'web_h_id', 
                            'fiscal_year_vision', 
                            'fiscal_year_th', 
                            'sales_fiscal_year_revision', 
                            'sales_fiscal_year_no',
                            'tran_approval_date',
                            'tran_status',
                            'user_name']);

        return response()->json([
            'headers' => $headers
        ]);
    }

    public function checkNumberFromYear($year = null)
    {
        if (!$year) {
            return response()->json([
                'yearNumber' => 1
            ]);
        }

        $yearNumber = 1;
        $headers    = PtpdEstimateMtSaleHeader::where('sales_fiscal_year_th', $year)
                                            ->get();

        if (!$headers) {
            $yearNumber = 1;
        } else {
            $yearNumber = count($headers) + 1;
        }


        return response()->json([
            'yearNumber' => $yearNumber
        ]);
    }

    public function getSalesFiscals()
    {
        $request    = request();
        $action     = $request->action;

        if($action == 'get-salesFiscalYearTH'){
            $salesFiscalYearTHCreateArr = PtpdSalesFiscalYearV::selectRaw("DISTINCT sales_fiscal_year_th, org_id")
                                                                ->when($request->salesFiscalYearNo, function($q) use($request) {
                                                                    $q->where('sales_fiscal_year_no', $request->salesFiscalYearNo);
                                                                })
                                                                ->orderBy('sales_fiscal_year_th' , 'desc')
                                                                ->get();
            return  ['salesFiscalYearTHCreateArr' =>  $salesFiscalYearTHCreateArr];
        }

        if($action == "get-version"){
            $salesFiscalsVersionCreateArr = PtpdSalesFiscalYearV::selectRaw("DISTINCT   sales_fiscal_year_revision, 
                                                                                        sales_fiscal_year_no, 
                                                                                        sales_fiscal_year_th, 
                                                                                        org_id")
                                                                ->when($request->year, function($q) use($request) {
                                                                    $q->where('sales_fiscal_year_th', $request->year);
                                                                })
                                                                ->when($request->salesFiscalYearNo, function($q) use($request) {
                                                                    $q->where('sales_fiscal_year_no', $request->salesFiscalYearNo);
                                                                })
                                                                ->orderBy('sales_fiscal_year_revision' , 'desc')
                                                                ->get();
            return  ['salesFiscalsVersionCreateArr' => $salesFiscalsVersionCreateArr];
        }

        if($action=="search"){
                $salesFiscals =  PtpdSalesFiscalYearV::when($request->year, function($q) use($request) {
                                                        $q->where('sales_fiscal_year_th', 'like', '%'.$request->year.'%');
                                                    })
                                                    ->when($request->salesFiscalYearNo, function($q) use($request) {
                                                        $q->where('sales_fiscal_year_no', 'like', '%'.$request->salesFiscalYearNo.'%');
                                                    })
                                                    ->when($request->salesFiscalYearRevision, function($q) use($request) {
                                                        $q->where('sales_fiscal_year_revision', 'like', '%'.$request->salesFiscalYearRevision.'%');
                                                    })
                                                    ->orderBy('sales_fiscal_year_th' , 'desc')
                                                    ->orderBy('sales_fiscal_year_revision' , 'desc')
                                                    ->get();

            return response()->json(['salesFiscals' => $salesFiscals]);
        }
    }

    public function getItems()
    {
        $request = request();
        $items = PtdpItemEstimateMtSaleV::where('sales_fiscal_year_th', $request->period_year)
            ->where('sales_fiscal_year_revision', $request->planning_version)
            ->where('ingredien_tobacco_type', $request->type)
            ->get();

        return response()->json([
            'items' => $items
        ]);
    }

    public function createLine()
    {
        $request        = request();
        $userProfile    = getDefaultData('/pd/');
        $yearNumber     = 1;
        $salesFiscalV   = PtpdSalesFiscalYearV::where('sales_fiscal_year_th', $request->year)
                                            ->where('sales_fiscal_year_no', $request->sales_fiscal_year_no)
                                            ->where('sales_fiscal_year_revision', $request->sales_fiscal_year_revision)
                                            ->first();

        if (!$salesFiscalV) {
            return response()->json([
                'header'        => '',
                'lines'         => [],
                'resultMsg'     => 'โปรดเลือกข้อมูลให้ครบถ้วน',
                'result'        => 'E'
            ]);
        }
        
        $items = PtdpItemEstimateMtSaleV::where('sales_fiscal_year_th', $request->year)
                                        ->where('sales_fiscal_year_revision', $request->sales_fiscal_year_revision)
                                        ->where('sales_fiscal_year_no', $request->sales_fiscal_year_no)
                                        ->orderby('item_code', 'asc') 
                                        ->get();

        $batchNo = uniqid();
        $returnMsg = [];

        try {
            $sql = "
                DECLARE
                    V_INTERFACE_STATUS      VARCHAR2(4000);
                    V_INTERFACE_MSG      VARCHAR2(4000);
                    V_WEB_H_ID              NUMBER;

                    BEGIN

                        PTPD_ESTIMATE_MT_SALE_PKG.MAIN_IMPORT (P_WEB_BATCH_NO    => '$batchNo'
                                            ,P_SALES_FISCAL_YEAR_ENG           => $salesFiscalV->sales_fiscal_year_eng
                                            ,P_SALES_FISCAL_YEAR_NO            => '$salesFiscalV->sales_fiscal_year_no'
                                            ,P_SALES_FISCAL_YEAR_REVISION      => $salesFiscalV->sales_fiscal_year_revision
                                            ,P_USER_ID                         => $userProfile->user_id
                                            ,P_INTERFACE_STATUS                => :V_INTERFACE_STATUS
                                            ,P_INTERFACE_MSG                   => :V_INTERFACE_MSG 
                                            ,P_WEB_H_ID                        => :V_WEB_H_ID);

                        dbms_output.put_line(:V_INTERFACE_STATUS);
                        dbms_output.put_line(:V_INTERFACE_MSG);
                        dbms_output.put_line(:V_WEB_H_ID);
                    END;
            ";

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":V_INTERFACE_STATUS", $returnMsg['V_INTERFACE_STATUS'], PDO::PARAM_STR, 20);
            $stmt->bindParam(":V_INTERFACE_MSG", $returnMsg['V_INTERFACE_MSG'], PDO::PARAM_STR, 2000);
            $stmt->bindParam(":V_WEB_H_ID", $returnMsg['V_WEB_H_ID'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            if($returnMsg['V_INTERFACE_STATUS'] == 'E'){
                return response()->json([
                    'header'        => '',
                    'lines'         => [],
                    'resultMsg'     => $returnMsg['V_INTERFACE_MSG'],
                    'result'        => $returnMsg['V_INTERFACE_STATUS']
                ]);
            }

            $header = PtpdEstimateMtSaleHeader::where('web_batch_no', $batchNo)->first();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'header'        => '',
                'lines'         => [],
                'resultMsg'     => $e->getMessage(),
                'result'        => 'E'
            ]);
        }

        $yearNumber = $header->fiscal_year_vision;

        $header['last_update_date']     = parseToDateTh($header['last_update_date']);
        $header['creation_date']        = parseToDateTh($header['creation_date']);
        $header['tran_approval_date']   = parseToDateTh($header['tran_approval_date']);

        DB::commit();
        return response()->json([
            'header'        => $header,            
            'lines'         => $items,
            'resultMsg'     => 'SUCCESS',
            'result'        => 'S',
            'yearNumber'    => $yearNumber,
            'year'          => $request->planning_year 
        ]);
    }

    public function findLines($id)
    {
        $lines = PtpdEstimateMtSaleLine::where('web_h_id', $id)
                                        ->orderby('item_code', 'asc')                                         
                                        ->get();
         
        $mapLines =  $lines->mapWithKeys(function($item, $key) {
            return [$item->item_code.$item->medicinal_leaves.$item->ingredien_species_type => $item];
        });
        
        $medicinalLeaves = [];
        $medicinalLeaves = $lines->groupBy('medicinal_leaves')->sortBy('medicinal_leaves');

        $thML = [];
        foreach ($medicinalLeaves->sortBy('medicinal_leaves') as $key => $medicinalLeav) {
            if($key == '' || $key==null){
                continue;
            }
            $thML[] = $key;
            foreach ($medicinalLeav as $value) {
                $thML[] = $key;
                break;
            }
        }


        $headerTable =[];
        foreach ($lines->sortBy('item_code')->groupBy('item_code') as $itemCode => $line) {
            $c = $line->first()->quantity * 1;
            $d = $line->first()->qty_lld ?? 1;
            $e = $line->first()->qty_use_year;
            $f = $line->first()->qty_use_month;
            $data[] =   [
                            'item_desc'                 => $line->first()->item_description,
                            'item_code'                 => $line->first()->item_code,
                            'ingredien_tobacco_type'    => $line->first()->ingredien_tobacco_type,
                            'quantity'                  => $c,
                            'qty_lld'                   => $d*1,
                            'year_quantity'             => $e,
                            'month_quantity'            => $f,
                            'merge_tr'                  => count($medicinalLeaves),
                            'medicinal_leaves'          => $medicinalLeaves->sortBy('medicinal_leaves')->keys(),
                            'medicinal_leaves_tr'       => $thML,
                            'lines'                     => $line,
                        ];
                        
        }   

        return response()->json([
            'lines'             => (object)collect($data)->sortBy('medicinal_leaves'),
            'header_table'      => (object)[collect($data)->sortBy('medicinal_leaves')->first()],
            'medicinalLeaves'   => $medicinalLeaves,
            'dLines'            => $lines,
            'mapLines'          => $mapLines
        ]);
    }

    public function updateLine($id)
    {
        $request        = request();
        $userProfile    = getDefaultData();
        $header         = PtpdEstimateMtSaleHeader::find($id);
        $req            = $request['params'];

        if($header['fiscal_year_vision'] == null){
            try {
                $sql = "
                    declare 
                        V_FISCAL_YEAR_NO          NUMBER;
                    
                    begin
                    
                    PTPD_ESTIMATE_MT_SALE_PKG.UPDATE_VERSION_FISCAL_YEAR_NO (P_WEB_BATCH_NO   => '$header->web_batch_no'      
                                                                            ,P_WEB_H_ID       => '$header->web_h_id'
                                                                            ,P_FISCAL_YEAR_NO => :V_FISCAL_YEAR_NO );

                    dbms_output.put_line(:V_FISCAL_YEAR_NO);
                    end ;
                ";
    
    
    
                $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
                $stmt->bindParam(":V_FISCAL_YEAR_NO", $result['V_FISCAL_YEAR_NO'], PDO::PARAM_STR, 20);
                $stmt->execute();

                if($result['V_FISCAL_YEAR_NO']){
                    return response()->json([
                        'fiscalYearNo'      => $result['V_FISCAL_YEAR_NO'],
                        'resultMsg'         => 'SUCCESS',
                        'result'            => 'S'
                    ]);
                }else{
                    return response()->json([
                        'resultMsg'     => 'ERROR',
                        'result'        => 'เกิดข้อผิดพลาดระบบไม่สามารถ สร้างปรับครั้งที่ได้'
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
            }

            if($req['textarea']){
                $header->attribute1                 = $req['textarea'];
                $header->web_status                 = 'UPDATE';
                $header->last_updated_by            = $userProfile->user_id;
                $header->last_update_date           = now();
                $header->updated_by_id              = $userProfile->user_id;
    
                $header->save();
            }
        }else{
            if( $req['form_update']['tran_status'] && 
                $req['form_update']['tran_status'] == 'APPROVED'){
                $data = PtpdEstimateMtSaleHeader::where('sales_fiscal_year_eng', $header['sales_fiscal_year_eng'])
                                              ->where('sales_fiscal_year_no', $header['sales_fiscal_year_no'])
                                              ->where('sales_fiscal_year_revision', $header['sales_fiscal_year_revision'])
                                              ->where('tran_status', 'APPROVED')
                                              ->get();
                                    
                if(count($data) == 1 && $id != $data[0]['web_h_id']){
                    return response()->json([
                        'resultMsg'     => 'มีรายการที่อนุมัติไปแล้วในปีงบประมาณ(ฝ่ายขาย)ที่ '.$data['0']['sales_fiscal_year_th']. ', ปรับครั้งที่(ชนป.) '
                                            .$data['0']['sales_fiscal_year_revision'].
                                            ' ต้องการที่จะ INACTIVE เวอร์ชั่นดังกล่าวนี้ และต้องการ APPROVED เวอร์ชั่นที่เลือกใช่หรอไม่ ?',
                        'result'        => 'E'
                    ]);
                }
            }            
            
            if($req['form_update']['tran_status']){         
                $header->tran_status                =   $req['form_update']['tran_status'];
                $header->tran_approval_date         =   $req['form_update']['tran_status'] == "INACTIVE" ? '' : 
                                                        $req['form_update']['tran_status'] == "APPROVED" ? 
                                                        parseFromDateTh($req['form_update']['tran_approval_date']) : '';
                $header->web_status                 =   'UPDATE';
                $header->last_updated_by            =   $userProfile->user_id;
                $header->last_update_date           =   now();
                $header->updated_by_id              =   $userProfile->user_id;
    
                $header->save();
            }
            
            if(!empty($req['form_update']['lines'])){
                foreach ($req['form_update']['lines'] as $key => $rLine) {
                    $line = PtpdEstimateMtSaleLine::find($rLine['web_l_id']);
        
                    if($line->ingredien_percent_item != $rLine['ingredien_percent_item']){
                        $line->web_status               = 'UPDATE';
                        $line->ingredien_percent_item   = $rLine['ingredien_percent_item'];
                        $line->cal_leaves_qty_use       = $line->qty_use_year * ($rLine['ingredien_percent_item'] * 0.01);
                    }
                    
                    $line->last_updated_by          = $userProfile->user_id;
                    $line->last_update_date         = now();
                    $line->updated_by_id            = $userProfile->user_id;
                    $line->updated_at               = now();
        
                    $line->save();
                }
            }

            $header->attribute1                 = $req['textarea'];
            $header->web_status                 = 'UPDATE';
            $header->last_updated_by            = $userProfile->user_id;
            $header->last_update_date           = now();
            $header->updated_by_id              = $userProfile->user_id;

            $header->save();
            
            return response()->json([
                'resultMsg'  => 'SUCCESS',
                'result'     => 'S'
            ]);
        }
    }

    public function selectHeader($id)
    {
        $header = PtpdEstimateMtSaleHeader::find($id);
        $nameUser = User::where('user_id', $header['created_by'])->value('name');

        $header['last_update_date']     = parseToDateTh($header['last_update_date']);
        $header['creation_date']        = parseToDateTh($header['creation_date']);
        $header['tran_approval_date']   = parseToDateTh($header['tran_approval_date']);
        $header['name_user']            = $nameUser;

        return response()->json([
            'header' => $header
        ]);
    }

    public function getLines($id)
    {
        $request    = request();
        $header     = PtpdEstimateMtSaleHeader::find($id);
        $lines      = $header->lines->map(function($item) {
                        return $item->sum_ingredien_percent_item = $item->ingredien_percent_item;
                    });

        $mapLines = $this->mapLines($header->lines);
        $lines = $header->lines
                        ->where('ingredien_species_type', $request->ingredien_species_type)
                        ->where('ingredien_tobacco_type', $request->ingredien_tobacco_type)
                        ->sortBy('medicinal_leaves');
            
        if(count($lines) == 0){
            return response()->json([
                'status'            => 'E',
                'lines'             => (object)[],
                'header_table'      => (object)[],
                'medicinalLeaves'   => [],
                'dLines'            => [],
                'mapLines'          => []
            ]);
        }
    
        $medicinalLeaves    = [];
        $medicinalLeaves    = $lines->where('medicinal_leaves', '!=', '')->sortBy('medicinal_leaves')->groupBy('medicinal_leaves');
        $thML               = $this->groupML($medicinalLeaves);
        $data               = $this->data($lines, $thML ,$medicinalLeaves);

        return response()->json([
            'status'            => 'S',
            'lines'             => (object)collect($data)->sortBy('medicinal_leaves'),
            'header_table'      => (object)[collect($data)->sortBy('medicinal_leaves')->first()],
            'medicinalLeaves'   => $medicinalLeaves,
            'dLines'            => $lines,
            'mapLines'          => $mapLines
        ]);
    }

    public function mapLines($lines)
    {
        $mapLines = $lines->mapWithKeys(function($item, $key) {
            return [$item->item_code.$item->medicinal_leaves.$item->ingredien_species_type => $item];
        });

        return  $mapLines;
    }

    public function groupML($medicinalLeaves)
    {
        $thML = [];
        foreach ($medicinalLeaves as $key => $medicinalLeaf) {
            if($key == '' || $key==null){
                continue;
            }
            $thML[] = $key;
            foreach ($medicinalLeaf as $value) {
                $thML[] = $key;
                break;
            }
        }

        return $thML;
    }

    public function data($lines,  $thML ,$medicinalLeaves)
    {
        $data = [];
        foreach ($lines->sortBy('item_code')->groupBy('item_code') as $itemCode => $line) {
            $c = $line->first()->quantity * 1;
            $d = $line->first()->qty_lld ?? 1;
            $e = $line->first()->qty_use_year;
            $f = $line->first()->qty_use_month;
            $data[] =   [
                            'item_desc'                 => $line->first()->item_description,
                            'item_code'                 => $line->first()->item_code,
                            'ingredien_tobacco_type'    => $line->first()->ingredien_tobacco_type,
                            'quantity'                  => $c,
                            'qty_lld'                   => $d*1,
                            'year_quantity'             => $e,
                            'month_quantity'            => $f,
                            'merge_tr'                  => count($medicinalLeaves),
                            'medicinal_leaves'          => $medicinalLeaves->keys(),
                            'medicinal_leaves_tr'       => $thML,
                            'lines'                     => $line,
                            'calculateKM'               => 0
                        ];                        
        }  

        return  $data;
    }

    public function searchSpecies()
    {
        $species = [];
        $request = request()->all();
        
        if($request['tobacco_type_code'] == '1001' && $request['tobacco_type_code'] != null){
            $species = PtdpSpeciesForecastV::where('tobacco_type_code_1', $request['tobacco_type_code'])->get();
        }elseif ($request['tobacco_type_code'] == '1002' && $request['tobacco_type_code'] != null) {
            $species = PtdpSpeciesForecastV::where('tobacco_type_code_2', $request['tobacco_type_code'])->get();
        }else{
            if($request['tobacco_type_code'] != null){
                $species = PtdpSpeciesForecastV::where('tobacco_type_code_3', $request['tobacco_type_code'])->get();
            }
        }

        return response()->json([
            'species' => $species
        ]);
    }

    public function getTempSalesFiscalYearTH()
    {
        $request = request()->all();
        $salesFiscalYearTHArr = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT sales_fiscal_year_th")
                                                            ->where('sales_fiscal_year_no' , $request['salesFiscalYearNo'])
                                                            ->whereNotNull('sales_fiscal_year_th')
                                                            ->orderBy('sales_fiscal_year_th' , 'desc')
                                                            ->get();
        return response()->json([
            'salesFiscalYearTHArr' => $salesFiscalYearTHArr
        ]);
    }

    public function getTempSalesFiscalYearRevision()
    {
        $request = request()->all();
        $salesFiscalYearRevision = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT sales_fiscal_year_revision")
                                                            ->where('fiscal_year_th' , $request['year'])
                                                            ->where('sales_fiscal_year_no' , $request['salesFiscalYearNo'])
                                                            ->whereNotNull('sales_fiscal_year_revision')
                                                            ->orderBy('sales_fiscal_year_revision' , 'desc')
                                                            ->get();
        return response()->json([
            'salesFiscalYearRevision' => $salesFiscalYearRevision
        ]);
    }

    public function getTempFiscalYearVision()
    {
        $request = request()->all();
        $fiscalYearVision = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT fiscal_year_vision")
                                                            ->where('fiscal_year_th' , $request['year'])
                                                            ->where('sales_fiscal_year_no' , $request['salesFiscalYearNo'])
                                                            ->where('sales_fiscal_year_revision' , $request['salesFiscalYearRevision'])
                                                            ->whereNotNull('fiscal_year_vision')
                                                            ->orderBy('fiscal_year_vision' , 'desc')
                                                            ->get();
        return response()->json([
            'fiscalYearVision' => $fiscalYearVision
        ]);
    }

    public function getRetrieveLeaves($id)
    {
        $request    = request()->all();
        $profile    = getDefaultData();

        try {
            $sql = "
                    DECLARE
                    V_INTERFACE_STATUS      VARCHAR2(4000);
                    V_INTERFACE_MSG      VARCHAR2(4000);
                    V_WEB_H_ID              NUMBER;

                    BEGIN

                        PTPD_ESTIMATE_MT_SALE_PKG.RESET_DATA_DETAIL( P_WEB_H_ID                 => '$id'
                                                                    ,P_LLD_YEAR                 => '{$request['P_LLD_YEAR']}'
                                                                    ,P_USER_ID                  => '$profile->user_id'
                                                                    ,P_INTERFACE_STATUS         => :V_INTERFACE_STATUS
                                                                    ,P_INTERFACE_MSG            => :V_INTERFACE_MSG  );


                    END ;
                ";

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":V_INTERFACE_STATUS", $result['V_INTERFACE_STATUS'], PDO::PARAM_STR, 20);
            $stmt->bindParam(":V_INTERFACE_MSG", $result['V_INTERFACE_MSG'], PDO::PARAM_STR, 20);
            $stmt->execute();

            return response()->json([
                'resultMsg'     => $result['V_INTERFACE_MSG'],
                'result'        => $result['V_INTERFACE_STATUS']
            ]);
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function getConfirmApproved($id)
    {
        $header         = PtpdEstimateMtSaleHeader::find($id);
        $request        = request()->all();
        $userProfile    = getDefaultData('/pd/PDP0014');
        try {
            $sql = "
                        DECLARE
                        V_INTERFACE_STATUS  VARCHAR2(1);
                        V_INTERFACE_MSG     VARCHAR2(4000);
                        BEGIN
                        
                        PTPD_ESTIMATE_MT_SALE_PKG.UPDATE_STATUS_APPROVED (P_WEB_BATCH_NO            => '$header->web_batch_no'
                                                                        ,P_WEB_H_ID                 => '$header->web_h_id'
                                                                        ,P_INTERFACE_STATUS         => :V_INTERFACE_STATUS
                                                                        ,P_INTERFACE_MSG            => :V_INTERFACE_MSG ) ;
                        
                        dbms_output.put_line('V_INTERFACE_STATUS = '||V_INTERFACE_STATUS);
                        dbms_output.put_line('V_INTERFACE_MSG = '||V_INTERFACE_MSG);
                        
                        
                        END ;
                    ";

            $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
            $stmt->bindParam(":V_INTERFACE_STATUS", $result['V_INTERFACE_STATUS'], PDO::PARAM_STR, 20);
            $stmt->bindParam(":V_INTERFACE_MSG", $result['V_INTERFACE_MSG'], PDO::PARAM_STR, 20);
            $stmt->execute();

            
        } catch (\Exception $e) {
            DB::rollback();
        }
        
        if($result['V_INTERFACE_STATUS'] == 'C'){
            $header['tran_approval_date']   = $request['tran_approval_date'] ? 
                                              parseFromDateTh($request['tran_approval_date']) : 
                                              '';
            $header['attribute1']           = $request['textarea'];
            $header['web_status']           = 'UPDATE';
            $header['last_updated_by']      = $userProfile->user_id;
            $header['last_update_date']     = now();
            $header['updated_by_id']        = $userProfile->user_id;

            $header->save();
        }

        return response()->json([
            'resultMsg'     => $result['V_INTERFACE_MSG'],
            'result'        => $result['V_INTERFACE_STATUS']
        ]);

    }
}
