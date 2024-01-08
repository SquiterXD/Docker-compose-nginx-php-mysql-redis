<?php


namespace App\Repositories\PD;


use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;
use Illuminate\Database\Eloquent\Collection;

class RequestRepository
{
    /**
     * @return Collection
     */
    public function getRequestHeaders(): Collection
    {
        return PtpmRequestHeader::query()->get();
    }

    public function getRequestHeader(int $id): Collection
    {
        return PtpmRequestHeader::query()->find($id);
    }

    public function getRequestLines(int $requestHeaderId): Collection
    {
        return PtpmRequestLine::query()
            ->where('request_header_id', $requestHeaderId)
            ->get();
    }
}
