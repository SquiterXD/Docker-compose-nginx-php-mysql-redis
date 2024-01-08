<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0021ApiController;
use App\Models\PM\Lookup\PtpmMatInternalStatusLookup;
use Illuminate\Http\Request;

class PM0021Controller extends BaseController
{

    /**
     * @var PM0021ApiController
     */
    private $api;

    /**
     * PM0021Controller constructor.
     * @param PM0021ApiController $api
     */
    public function __construct(PM0021ApiController $api)
    {
        $this->api = $api;
    }

    /** @noinspection DuplicatedCode */
    public function index(Request $request)
    {
        $queries = $request->all();
        if (!array_key_exists('date', $queries)) {
            $queries['date'] = date('Y-m-d');
            return redirect()->route('pm.ingredient-requests.index', $queries);
        }

        $results = $this->api->index($request)->getData();

        $materialStatusLookup = PtpmMatInternalStatusLookup::query()
            ->get()
            ->toArray();

        $data = [
            "btn_trans" => trans('btn'),

            'material_status_lookup' => $materialStatusLookup,
            'ingredient_requests' => $results->ingredient_requests,
            'queries' => $queries,
        ];

        return $this->vue('pm0021', $data);
    }
}
