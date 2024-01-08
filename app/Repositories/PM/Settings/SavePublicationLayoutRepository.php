<?php
namespace App\Repositories\PM\Settings;

use Illuminate\Database\Eloquent\Collection;

use DB;
use PDO;
use Arr;


class SavePublicationLayoutRepository
{
    function getLetterTranTypeName()
    {
        return 'T16:จ่าย-Letterข้ามItem';
    }

    function isLetterPageType($transId = '', $transName = false)
    {
        if ($transId == '') {
            return false;
        }
        if ($transName) {
            return $this->getLetterTranTypeName() == $transName;
        }

        $data = collect(DB::select("
            SELECT
                    transaction_type_id,
                    transaction_type_name
            from    mtl_transaction_types
            where  1=1
            and     transaction_type_id = $transId
        "))->first();

        return trim($this->getLetterTranTypeName()) == $data->transaction_type_name;
    }

    function conversionInfoUpdateSetup($conversion, $setup)
    {
        $conversion->from_organization_id       = $setup->from_organization_id;
        $conversion->from_subinv                = $setup->from_subinventory;
        $conversion->from_locator_id            = $setup->from_locator_id;
        $conversion->transaction_type_id        = $setup->wip_transaction_type_id;
        $conversion->to_organization_id         = $setup->to_organization_id;
        $conversion->to_subinv                  = $setup->to_subinventory;
        $conversion->to_locator_id              = $setup->to_locator_id;
        $conversion->org_transfer_id            = $setup->id;
        $conversion->save();
    }
}
