<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0004ApiController extends Controller
{

    public function show(int $id): JsonResponse
    {
        $header = PtpmRequestHeader::query()
            ->find($id);

        if (!$header) return response()->json([
            'message' => 'data not found',
        ], 404);

        $lines = PtpmRequestLine::query()
            ->where('request_header_id', $id)
            ->get();

        return response()->json([
            'header' => $header,
            'lines' => $lines,
        ]);
    }

    public function index(): JsonResponse
    {
        $headers = PtpmRequestHeader::query()->get();
        return response()->json($headers);
    }

    public function store(Request $request)
    {
        $headerData = $request->input('header');
        $linesData = $request->input('lines');
        $user = auth()->user();

        $headerData = array_merge($headerData, [
            'program_code' => 'PMP0005',
            'created_by' => $user->user_id,
            'creation_date' => date('Y-m-d'),
        ]);

        DB::beginTransaction();
        try {
            $header = PtpmRequestHeader::query()
                ->create($headerData);

            $lines = [];
            foreach ($linesData as $lineData) {
                $lineData['request_header_id'] = $header->request_header_id;
                $lines[] = PtpmRequestLine::query()
                    ->create($lineData);
            }

            return response()->json([
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $headerData = $request->input('header');
        $linesData = $request->input('lines');
        $user = auth()->user();

        $headerData = array_merge($headerData, [
            'last_updated_by' => $user->user_id,
            'last_update_date' => date('Y-m-d'),
        ]);

        DB::beginTransaction();
        try {
            $header = PtpmRequestHeader::query()
                ->find($id);
            $header->update($headerData);

            PtpmRequestLine::query()
                ->where('request_header_id', $id)
                ->delete();

            $lines = [];
            foreach ($linesData as $lineData) {
                $lineData['request_header_id'] = $header->request_header_id;
                $lines[] = PtpmRequestLine::query()
                    ->create($lineData);
            }

            DB::commit();
            return response([
                'header' => $header,
                'lines' => $lines,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }

    }

    public function deleteLines(Request $request)
    {
        $ids = $request->get('ids');

        DB::beginTransaction();
        try {
            $res = PtpmRequestLine::query()
                ->whereIn('request_line_id', $ids)
                ->delete();

            DB::commit();
            return response([
                'affectedRows' => $res,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
