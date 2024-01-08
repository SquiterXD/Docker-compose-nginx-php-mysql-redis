<?php

    function getItemIdFmQr($text) {
        try {
            // $text = "x',xx";
            $itemId = trim($text);
            $text = json_decode($text);
            if (count((array) $text)) {
                $itemId = data_get($text, 'item_id', $itemId);
            }

            $item  = collect(\DB::select("
                SELECT  inventory_item_id, segment1
                FROM    mtl_system_items_b
                WHERE   1=1
                AND     to_char(inventory_item_id) = '$itemId'
                OR      segment1 = '$itemId'
            "))->first();

            if ($item) {
                $itemId = $item->inventory_item_id;
            } else {
                $itemId = -999;
            }

        } catch (\Exception $e) {
            $itemId = -999;
        }
        // dd('xx', $itemId, $text);
        return $itemId;
    }

    function getUserIdFmQr($text) {
        try {
            // $text = "x',xx";
            $id = trim($text);
            $text = json_decode($text);
            if (count((array) $text)) {
                $id = data_get($text, 'user_id', $id);
            }
            $userTable = (new \App\Models\User)->getTable();
            $data  = collect(\DB::select("
                SELECT  user_id, username
                FROM    $userTable
                WHERE   1=1
                AND     to_char(user_id) = '$id'
                OR      username = '$id'
            "))->first();

            if ($data) {
                $id = $data->user_id;
            } else {
                $id = false;
            }

        } catch (\Exception $e) {
            $id = false;
        }
        // dd('xx', $id, $text);
        return $id;
    }

    function getMachineSetFmQr($text) {
        try {
            // machine_set
            // $text = "x',xx";
            $id = trim($text);
            $text = json_decode($text);
            if (count((array) $text)) {
                $id = data_get($text, 'machine_set', $id);
            }

            $table = (new App\Models\PM\PtpmMachineRelationsV)->getTable();
            $data  = collect(\DB::select("
                SELECT  machine_set, machine_group_desc
                FROM    $table
                WHERE   1=1
                AND     to_char(machine_set) = '$id'
                --OR      username = '$id'
            "))->first();

            if ($data) {
                $id = $data->machine_set;
            } else {
                $id = false;
            }

        } catch (\Exception $e) {
            $id = false;
        }
        // dd('xx', $id, $text);
        return $id;
    }
