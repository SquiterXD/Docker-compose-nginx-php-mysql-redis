<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\ItemLocationsKfv;
use App\Models\PM\Settings\TransactionTypes;

class OrgTransferController extends Controller
{
    public function getLocationsFrom(Request $request)
    {
        $itemLocationsFrom = ItemLocationsKfv::selectRaw('rowidtochar(row_id) as row_id, 
                                                                            inventory_location_id,
                                                                            organization_id,
                                                                            concatenated_segments,
                                                                            segment1,
                                                                            segment2,
                                                                            subinventory_code,
                                                                            description')
                                            ->where('organization_id', $request->organization)
                                            ->get();
                                
        return response()->json(['itemLocationsFrom' => $itemLocationsFrom]);
    }

    public function getLocationsTo(Request $request)
    {
        $itemLocationsTo = ItemLocationsKfv::selectRaw('rowidtochar(row_id) as row_id, 
                                                                            inventory_location_id,
                                                                            organization_id,
                                                                            concatenated_segments,
                                                                            segment1,
                                                                            segment2,
                                                                            subinventory_code,
                                                                            description')
                                            ->where('organization_id', $request->organization)
                                            ->get();

        return response()->json(['itemLocationsTo' => $itemLocationsTo]);
    }

    public function getTransactionTypes(Request $request)
    {
        $query = $request['0'];
        $transactionTypes = TransactionTypes::whereRaw("LOWER(transaction_type_name) like LOWER('%{$query}%')")
                                            // ->whereRaw("(attribute2 != 'Y' or attribute2 is null)")
                                            ->orderBy('transaction_type_id')
                                            ->get();

        return response()->json(['transactionTypes' => $transactionTypes]);
    }

}
