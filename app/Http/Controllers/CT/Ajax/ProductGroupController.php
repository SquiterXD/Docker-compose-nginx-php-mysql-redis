<?php

namespace App\Http\Controllers\CT\Ajax;

use PDO;
use App\Models\CT\ProductGroup;
use App\Models\CT\CostCenterOrg;
use App\Models\CT\ProductGroupDetail;
use App\Models\CT\CostCenter;
use App\Models\CT\ProductItemNumberV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductGroupController extends Controller
{
    const url = '/ct/product_group';

    public function index()
    {
        $res = ProductGroup::all();

        return response()->json($res);
    }

    public function getDataFromView()
    {
        $productGroups = DB::table('ptct_product_group_v')->get();
        $costCodeList = collect(DB::select("
            SELECT DISTINCT
                COST_CODE  AS VALUE
                , COST_CODE ||' : '|| DESCRIPTION AS LABEL
            FROM PTCT_COST_CENTER_V
            ORDER BY LABEL
        "));

        data_set($productGroups, '*.show_edit_form', false);
        data_set($productGroups, '*.loading', false);

        $data = [
            'product_groups' => $productGroups,
            'cost_code_list' => $costCodeList
        ];

        return $data;

        return DB::table('ptct_product_group_v')
            ->get();

    }

    public function storeCostCode(Request $request)
    {
        $profile = getDefaultData(self::url);

        $createdBy = $profile->fnd_user_id;
        $dataType = 'add';
        $costCode = data_get($request->input, 'cost_code');
        $productGroup = data_get($request->input, 'product_group');
        $description = data_get($request->input, 'description');


        try {

            $costCodeList = collect(DB::select("
                SELECT count(*) as has_data
                FROM ptct_product_group_v
                WHERE 1=1
                AND     cost_code = '$costCode'
                AND     product_group = '$productGroup'
            "))->first();

            if ($costCodeList->has_data > 0) {
                throw new \Exception("ข้อมูลศูนย์ต้นทุน: {$costCode}, กลุ่มผลิตภัณฑ์: {$productGroup} มีในระบบแล้ว");
            }


            if (!$costCode) {
                throw new \Exception('โปรดระบุศูนย์ต้นทุน');
            }

            if (!$productGroup) {
                throw new \Exception('โปรดระบุกลุ่มผลิตภัณฑ์');
            }

            $db     =   DB::connection('oracle')->getPdo();
            $sql    =   "
                DECLARE
                    v_debug         NUMBER :=0;

                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(4000) := NULL;

                    v_data_rec        apps.PTCT_UPDATE_MASTER_PKG.CT03_PARAM_REC;
                BEGIN
                    dbms_output.put_line('------  S T A R T ------');

                    v_data_rec  := NULL;
                    ----***Require field
                    v_data_rec.CREATED_BY               := :CREATED_BY  ;      --USER_NAME => MERCURY
                    v_data_rec.DATA_TYPE                := :DATA_TYPE ;   --ADD/NEW,UPDATE/CREATE/DELETE/Del
                    v_data_rec.COST_CODE                := :COST_CODE  ;  --** PTCT_COST_CENTER_V.COST_CODE
                    v_data_rec.PRODUCT_GROUP            := :PRODUCT_GROUP  ;
                    v_data_rec.DESCRIPTION              := :DESCRIPTION  ;
                        ---- output
                    v_data_rec.RETURN_STATUS        := NULL;
                    v_data_rec.RETURN_MESSAGE       := NULL;
                    apps.PTCT_UPDATE_MASTER_PKG.WEB_CTM03_PRDGRP( P_PARAM_DATA => v_data_rec);

                    dbms_output.put_line('Output : interface_name = '||v_data_rec.INTERFACE_NAME );
                    dbms_output.put_line('Output : return_status = '||v_data_rec.RETURN_status );
                    dbms_output.put_line('Output : message       = '||v_data_rec.RETURN_MESSAGE );

                    :P_RETURN_STATUS :=  v_data_rec.RETURN_STATUS;
                    :P_RETURN_MESSAGE :=  v_data_rec.RETURN_MESSAGE;
                    dbms_output.put_line('------  E N D ------');
                EXCEPTION WHEN OTHERS THEN
                 dbms_output.put_line('***Error-'||sqlerrm);
                END;
            ";

            // $sql = preg_replace("/[\r\n]*/", "", $sql);

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':CREATED_BY', $createdBy, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DATA_TYPE', $dataType, PDO::PARAM_STR, 100);
            $stmt->bindParam(':COST_CODE', $costCode, PDO::PARAM_STR, 100);
            $stmt->bindParam(':PRODUCT_GROUP', $productGroup, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DESCRIPTION', $description, PDO::PARAM_STR, 100);


            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            if ($result['status'] != 'C') {
                throw new \Exception($result['message']);
            }
            $data = [
                'status' => 'S',
                'message' => ''
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($data);
    }

    public function updateCostCode(Request $request)
    {
        $profile = getDefaultData(self::url);

        $createdBy = $profile->fnd_user_id;
        $dataType = 'UPDATE';
        $costCode = data_get($request->input, 'cost_code');
        $productGroup = data_get($request->input, 'product_group');
        $description = data_get($request->input, 'description');


        try {
            if (!$costCode) {
                throw new \Exception('โปรดระบุศูนย์ต้นทุน');
            }

            if (!$productGroup) {
                throw new \Exception('โปรดระบุกลุ่มผลิตภัณฑ์');
            }

            $db     =   DB::connection('oracle')->getPdo();
            $sql    =   "
                DECLARE
                    v_debug         NUMBER :=0;

                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(4000) := NULL;

                    v_data_rec        apps.PTCT_UPDATE_MASTER_PKG.CT03_PARAM_REC;
                BEGIN
                    dbms_output.put_line('------  S T A R T ------');

                    v_data_rec  := NULL;
                    ----***Require field
                    v_data_rec.CREATED_BY               := :CREATED_BY  ;      --USER_NAME => MERCURY
                    v_data_rec.DATA_TYPE                := :DATA_TYPE ;   --ADD/NEW,UPDATE/CREATE/DELETE/Del
                    v_data_rec.COST_CODE                := :COST_CODE  ;  --** PTCT_COST_CENTER_V.COST_CODE
                    v_data_rec.PRODUCT_GROUP            := :PRODUCT_GROUP  ;
                    v_data_rec.DESCRIPTION              := :DESCRIPTION  ;
                        ---- output
                    v_data_rec.RETURN_STATUS        := NULL;
                    v_data_rec.RETURN_MESSAGE       := NULL;
                    apps.PTCT_UPDATE_MASTER_PKG.WEB_CTM03_PRDGRP( P_PARAM_DATA => v_data_rec);

                    dbms_output.put_line('Output : interface_name = '||v_data_rec.INTERFACE_NAME );
                    dbms_output.put_line('Output : return_status = '||v_data_rec.RETURN_status );
                    dbms_output.put_line('Output : message       = '||v_data_rec.RETURN_MESSAGE );

                    :P_RETURN_STATUS :=  v_data_rec.RETURN_STATUS;
                    :P_RETURN_MESSAGE :=  v_data_rec.RETURN_MESSAGE;
                    dbms_output.put_line('------  E N D ------');
                EXCEPTION WHEN OTHERS THEN
                 dbms_output.put_line('***Error-'||sqlerrm);
                END;
            ";

            // $sql = preg_replace("/[\r\n]*/", "", $sql);

            \Log::info("CREATED_BY : $createdBy");
            \Log::info("DATA_TYPE : $dataType");
            \Log::info("COST_CODE : $costCode");
            \Log::info("PRODUCT_GROUP : $productGroup");
            \Log::info("DESCRIPTION : $description");

            \Log::info($sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':CREATED_BY', $createdBy, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DATA_TYPE', $dataType, PDO::PARAM_STR, 100);
            $stmt->bindParam(':COST_CODE', $costCode, PDO::PARAM_STR, 100);
            $stmt->bindParam(':PRODUCT_GROUP', $productGroup, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DESCRIPTION', $description, PDO::PARAM_STR, 100);


            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 2000);
            $stmt->execute();




            if ($result['status'] != 'C') {
                throw new \Exception($result['message']);
            }
            $data = [
                'status' => 'S',
                'message' => ''
            ];

        } catch (\Exception $e) {
            \Log::info($e);
            $data = [
                'status' => 'E',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($data);
    }

    public function delCostCode(Request $request)
    {
        $profile = getDefaultData(self::url);

        $createdBy = $profile->fnd_user_id;
        $dataType = 'DELETE';
        $costCode = data_get($request->input, 'cost_code');
        $productGroup = data_get($request->input, 'product_group');
        $description = data_get($request->input, 'description');


        try {
            if (!$costCode) {
                throw new \Exception('โปรดระบุศูนย์ต้นทุน');
            }

            if (!$productGroup) {
                throw new \Exception('โปรดระบุกลุ่มผลิตภัณฑ์');
            }

            $db     =   DB::connection('oracle')->getPdo();
            $sql    =   "
                DECLARE
                    v_debug         NUMBER :=0;

                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(4000) := NULL;

                    v_data_rec        apps.PTCT_UPDATE_MASTER_PKG.CT03_PARAM_REC;
                BEGIN
                    dbms_output.put_line('------  S T A R T ------');

                    v_data_rec  := NULL;
                    ----***Require field
                    v_data_rec.CREATED_BY               := :CREATED_BY  ;      --USER_NAME => MERCURY
                    v_data_rec.DATA_TYPE                := :DATA_TYPE ;   --ADD/NEW,UPDATE/CREATE/DELETE/Del
                    v_data_rec.COST_CODE                := :COST_CODE  ;  --** PTCT_COST_CENTER_V.COST_CODE
                    v_data_rec.PRODUCT_GROUP            := :PRODUCT_GROUP  ;
                    v_data_rec.DESCRIPTION              := :DESCRIPTION  ;
                        ---- output
                    v_data_rec.RETURN_STATUS        := NULL;
                    v_data_rec.RETURN_MESSAGE       := NULL;
                    apps.PTCT_UPDATE_MASTER_PKG.WEB_CTM03_PRDGRP( P_PARAM_DATA => v_data_rec);

                    dbms_output.put_line('Output : interface_name = '||v_data_rec.INTERFACE_NAME );
                    dbms_output.put_line('Output : return_status = '||v_data_rec.RETURN_status );
                    dbms_output.put_line('Output : message       = '||v_data_rec.RETURN_MESSAGE );

                    :P_RETURN_STATUS :=  v_data_rec.RETURN_STATUS;
                    :P_RETURN_MESSAGE :=  v_data_rec.RETURN_MESSAGE;
                    dbms_output.put_line('------  E N D ------');
                EXCEPTION WHEN OTHERS THEN
                 dbms_output.put_line('***Error-'||sqlerrm);
                END;
            ";

            // $sql = preg_replace("/[\r\n]*/", "", $sql);

            \Log::info("CREATED_BY : $createdBy");
            \Log::info("DATA_TYPE : $dataType");
            \Log::info("COST_CODE : $costCode");
            \Log::info("PRODUCT_GROUP : $productGroup");
            \Log::info("DESCRIPTION : $description");

            \Log::info($sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':CREATED_BY', $createdBy, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DATA_TYPE', $dataType, PDO::PARAM_STR, 100);
            $stmt->bindParam(':COST_CODE', $costCode, PDO::PARAM_STR, 100);
            $stmt->bindParam(':PRODUCT_GROUP', $productGroup, PDO::PARAM_STR, 100);
            $stmt->bindParam(':DESCRIPTION', $description, PDO::PARAM_STR, 100);


            $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 2000);
            $stmt->execute();




            if ($result['status'] != 'C') {
                throw new \Exception($result['message']);
            }
            $data = [
                'status' => 'S',
                'message' => ''
            ];

        } catch (\Exception $e) {
            \Log::info($e);
            $data = [
                'status' => 'E',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($data);
    }

    /*
     *  Copy ProductGroupDetail From ProductGroup
     *
     */
    public function copy(Request $request)
    {   
        $fromProductGroupDetails =  ProductGroupDetail::query()
            ->select('OACT.ptct_product_group_details.code', 'OACT.ptct_product_group_details.name')
            ->join('OACT.ptct_product_groups', 'OACT.ptct_product_groups.product_group_id', '=', 'OACT.ptct_product_group_details.product_group_id')
            ->join('OACT.ptct_cost_centers', 'OACT.ptct_cost_centers.cost_center_id', '=', 'OACT.ptct_product_groups.cost_center_id')
            ->where('OACT.ptct_product_group_details.product_group_id', $request->from_product_group_id)
            ->where('OACT.ptct_cost_centers.fiscal_year', $request->fiscal_year_from)
            ->get();
        
        \DB::beginTransaction();
        try {

            foreach ($fromProductGroupDetails as $key => $fromProductGroupDetail) {
                ProductGroupDetail::create([
                    'product_group_id' =>  $request->to_product_group_id,
                    'code' =>  $fromProductGroupDetail->code,
                    'name' =>  $fromProductGroupDetail->name,
                ]);
            }

            \DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function find(Request $request)
    {
        $res = ProductGroup::query()
            ->select('OACT.ptct_product_groups.product_group_id', 'OACT.ptct_product_groups.code', 'OACT.ptct_product_groups.name', 'OACT.ptct_product_groups.cost_center_id')
            ->where('OACT.ptct_cost_centers.fiscal_year',  $request->query('fiscal_year'))
            ->where('OACT.ptct_cost_centers.code', $request->query('cost_center_code'))
            ->join('OACT.ptct_cost_centers', 'OACT.ptct_cost_centers.cost_center_id', '=', 'OACT.ptct_product_groups.cost_center_id')
            ->get();

        return response()->json($res);
    }

    public function copyProductGroup($cost_center_code)
    {
        $cost_center = CostCenter::where('code',$cost_center_code)->first();
        $cost_center_org = CostCenterOrg::where('cost_center_id', $cost_center->cost_center_id)->get();
        $product_group = ProductGroup::where('cost_center_id',$cost_center->cost_center_id)->get();
        return response()->json(
            [
                "cost_center" => $cost_center,
                "cost_center_org" => $cost_center_org,
                "product_group" => $product_group,
            ]
        );
    }

    public function delete($id)
    {
        if (ProductGroupDetail::where('product_group_id', $id)->count() > 0) {
            return response()->json([
                'msg' => 'ลบไม่สำเร็จ !! เนื่องจากมีผลิตภัณฑ์ผูกอยู่กับกลุ่มผลิตภัณฑ์นี้',
                'error' => "error"
            ], 403);
        };

        ProductGroup::find($id)->delete();
        return response()->json(['msg' => 'ลบสำเร็จ !!']);
    }

    public function store(Request $request)
    {
        $productItemIsExist =  ProductItemNumberV::checkVersionExist([
            'cost_code'     => $request->cost_code,
            'product_group'   => $request->product_group,
        ]);

        if ($productItemIsExist) {
            return response()->json([
                'error' => 'Version unique',
                'msg' => "error", 
                'data' => 'Version unique'
            ], 400);
        }
        

        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                        v_status         varchar2(5);
                        v_err_msg        varchar2(2000);
                        begin
                            
                            ptct_item_cat_inf(P_SEMENT1             => '{$request->cost_code}'
                                            ,P_SEMENT2              => '{$request->product_group}'
                                            ,P_INVENTORY_ITEM_ID    => 21710
                                            ,P_FLAG                 => 'CREATE'
                                            ,V_MESSAGE              => :v_err_msg
                                            ,V_STATUS               => :v_status);
                                                        
                                dbms_output.put_line('Status : ' || :v_status);
                                dbms_output.put_line('Error : ' || :v_err_msg);
                        end;
                    ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['data'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        if ($result['status'] === "S") {
            return response()->json([
                'msg' => "success"
            ], 200);
        } elseif ($result['status'] === "E") {
            return response()->json([
                'error' => 'Something wrong',
                'msg' => "error",
                'data' => $result['data']
            ], 500);
        } else {
            return response()->json([
                'error' => 'Something wrong',
                'msg' => "error"
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $costCode = $request->input('product_groups')['cost_code'];
        $productGroups = $request->input('product_groups')['children'];

        $result = [];
        $data = [];
        try {
            $db = DB::getPdo();

            foreach ($productGroups as $key => $productGroup) {
                
                $ratio = (str_replace(",", "", $productGroup['ratio']));
                $width = (str_replace(",", "", $productGroup['width']));
                $length = (str_replace(",", "", $productGroup['length']));
                $around = (str_replace(",", "", $productGroup['around']));
                $area = (str_replace(",", "", $productGroup['area']));
                $cost_qty = (str_replace(",", "", $productGroup['quantity_prd']));
                $uom = $productGroup['uom_code_prd'];

                $sql = "
                    DECLARE
                        P_RETURN_STATUS          varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                          NUMBER :=1;
                        
                        v_param_rec        PTCT_M009_PKG.CTM09_PARAM_REC;
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
                        v_debug := 22;
                        v_param_rec := NULL; 
                        v_param_rec.PRDGRP_YEAR_ID        := {$productGroup['prdgrp_year_id']};
                        v_param_rec.COST_CODE             := '{$costCode}';
                        v_param_rec.product_group         := '{$productGroup['pg_code']}';
                        
                        v_param_rec.ratio                  := {$ratio};
                        v_param_rec.width                  := {$width};
                        v_param_rec.length                 := {$length};
                        v_param_rec.around                 := {$around};
                        v_param_rec.area                   := {$area};   
                        v_param_rec.cost_qty               := {$cost_qty};
                        v_param_rec.uom                    := '{$uom}';
                    
                        v_debug := 29;
                        
                        PTCT_M009_PKG.WEB_CT09_PRDGRP( P_PARAM_DATA      =>  v_param_rec ) ;

                        :P_RETURN_STATUS := v_param_rec.RETURN_STATUS;
                        :P_RETURN_MESSAGE := v_param_rec.RETURN_MESSAGE;
                    
                        dbms_output.put_line(
                            'OUTPUT : ' || v_param_rec.RETURN_STATUS ||
                            'MSG :' || v_param_rec.RETURN_MESSAGE
                        );

                        dbms_output.put_line('---------------------  E N D. -------------------');
                    EXCEPTION WHEN others THEN 
                        dbms_output.put_line(v_debug||'**call_error'|| sqlerrm );                   
                    END ;
                ";
                
                $result = [];
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
                $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
                $stmt->execute();

                if ($result['status'] != 'C') {
                    throw new \Exception($result['message']);
                }
            }

            $data = [
                'status' => 'C',
                'msg' => ''
            ];
        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);

    }

    public function storeProductItem(Request $request)
    {
        $profile = getDefaultData(self::url);
        $costCode = data_get($request->input, 'cost_code');
        $productGroup = data_get($request->input, 'product_group');
        $items = data_get($request->input, 'items', []) ?? [];


        try {

            if (count($items) == 0) {
                throw new \Exception("โปรดระบุผลิตภัณฑ์ อย่างน้อง 1 รายการ");
            }

            foreach ($items as $key => $itemId) {
                $db     =   DB::connection('oracle')->getPdo();
                $sql    =   "
                    DECLARE
                        ---Category set = TOAT Costing Category
                        v_status         varchar2(5);
                        v_err_msg        varchar2(4000);
                    begin
                           ptct_item_cat_inf(P_SEMENT1          => '{$costCode}'    --cost_code
                                                ,P_SEMENT2              => '{$productGroup}'    --product_group
                                                ,P_INVENTORY_ITEM_ID    => {$itemId}
                                                ,P_FLAG                 => 'CREATE' --CREATE/UPDATE/DELETE
                                                ,V_MESSAGE              => :v_err_msg
                                                ,V_STATUS               => :v_status);
                            dbms_output.put_line('Status : ' || v_status);
                            dbms_output.put_line('Error : ' || v_err_msg);
                    end;
                ";

                // $sql = preg_replace("/[\r\n]*/", "", $sql);

                \Log::info($sql);
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
                $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
                $stmt->execute();
                \Log::info($result);
                sleep(1);

                if ($result['status'] != 'S') {
                    throw new \Exception($result['message']);
                }
            }
            $data = [
                'status' => 'S',
                'message' => ''
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($data);
    }

    public function delProductItem(Request $request)
    {
        $profile = getDefaultData(self::url);
        $costCode = data_get($request->input, 'cost_code');
        $productGroup = data_get($request->input, 'product_group');
        $delItems = data_get($request->input, 'del_items', []) ?? [];


        try {

            if (count($delItems) == 0) {
                throw new \Exception("โปรดระบุผลิตภัณฑ์ อย่างน้อง 1 รายการ");
            }

            foreach ($delItems as $key => $itemId) {
                $db     =   DB::connection('oracle')->getPdo();
                $sql    =   "
                    DECLARE
                        ---Category set = TOAT Costing Category
                        v_status         varchar2(5);
                        v_err_msg        varchar2(4000);
                    begin
                           ptct_item_cat_inf(P_SEMENT1          => '{$costCode}'    --cost_code
                                                ,P_SEMENT2              => '{$productGroup}'    --product_group
                                                ,P_INVENTORY_ITEM_ID    => {$itemId}
                                                ,P_FLAG                 => 'DELETE' --CREATE/UPDATE/DELETE
                                                ,V_MESSAGE              => :v_err_msg
                                                ,V_STATUS               => :v_status);
                            dbms_output.put_line('Status : ' || v_status);
                            dbms_output.put_line('Error : ' || v_err_msg);
                    end;
                ";

                // $sql = preg_replace("/[\r\n]*/", "", $sql);

                \Log::info($sql);
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
                $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
                $stmt->execute();
                \Log::info($result);
                sleep(1);

                if ($result['status'] != 'S') {
                    throw new \Exception($result['message']);
                }
            }
            $data = [
                'status' => 'S',
                'message' => ''
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($data);
    }

    public function itemCosting(Request $request)
    {
      $whereSearch = "";
      if ($request->search) {
        // $whereSearch = "AND product_item_number LIKE LOWER('%$request->search%') OR description LIKE '%$request->search%'";
        $whereSearch = "AND LOWER(product_item_number || ' ' ||  description ) LIKE LOWER('%$request->search%') ";
      }
      $data = collect(DB::select("
      SELECT DISTINCT
        product_item_id
        , product_item_number
        , description
        , product_item_id AS VALUE
        , product_item_number ||' : '|| description AS LABEL
      FROM
          oact.ptct_item_costing_v
      WHERE ROWNUM <= 300 
      $whereSearch
      ORDER BY
          label
      "));
      
      
      return response()->json([
        'message' => "success",
        'data'  => $data,
        'status' => true
      ], 200);
    }
}
