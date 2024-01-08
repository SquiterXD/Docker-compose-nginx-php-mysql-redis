<?php

namespace App\Http\Controllers\PP\Web;

use App\Http\Controllers\PM\Api\PM0036ApiController;
use App\Http\Controllers\PP\Api\PP0000ApiController;
use App\Models\Lookup\PtBiweeklyLookup;
use App\Models\Mock;
use Illuminate\Http\Request;

class PP0000Controller extends BaseController
{
    /**
     * @var PP0000ApiController
     */
    private $api;

    /**
     * PP0000Controller constructor.
     * @param PP0000ApiController $api
     */
    public function __construct(PP0000ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $user = Mock::getMockUser();

        return $this->vue('pp-0000', [
            'user' => $user,
        ]);
    }
}
