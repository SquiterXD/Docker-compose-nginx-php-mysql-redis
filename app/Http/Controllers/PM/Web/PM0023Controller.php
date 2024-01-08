<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0023ApiController;

class PM0023Controller extends BaseController
{
    /**
     * @var PM0023ApiController
     */
    private $api;

    /**
     * PM0020Controller constructor.
     * @param PM0023ApiController $api
     */
    public function __construct(PM0023ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $user = auth()->user();
        return $this->vue('pm0023', [
            'user' => $user,
        ]);
    }
}
