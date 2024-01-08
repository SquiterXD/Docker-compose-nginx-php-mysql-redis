<?php

function getResponse($collection)
{
    return [
        'data'   => $collection,
        'status' => 200
    ];
}

function success($data = null)
{
    return [
        'data'    => $data,
        'message' => 'บันทึกสำเร็จ',
        'status'  => 200
    ];
}

function duplicate($message = 'ข้อมูลซ้ำ', $status = 400)
{
    return [
        'message' => $message,
        'status'  => $status
    ];
}

function error($message = false, $status = 400)
{
    return [
        'message' => $message,
        'status'  => $status
    ];
}
