<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0020ApiController;
use App\Models\Mock;
use stdClass;

class PM0020Controller extends BaseController
{

    /**
     * @var PM0020ApiController
     */
    private $api;

    /**
     * PM0020Controller constructor.
     * @param PM0020ApiController $api
     */
    public function __construct(PM0020ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        //TODO change to real data
        $user = Mock::getMockUser();

        $ingredientRequest = new stdClass();
        $ingredientRequest->department_name = $user->department_name;
        $ingredientRequest->user_id = $user->user_id;
        $ingredientRequest->request_date = date('Y-m-d');

        $data = [
            'is_create_new' => true,
            'init_ingredient_request' => $ingredientRequest,
            'init_lines' => (array)[],
            'user' => $user,
        ];

        return $this->vue('pm0020', $data);
    }

    /** @noinspection DuplicatedCode */
    public function show($id = null)
    {
        $user = auth()->user();

        $response = $this->api->show($id);
        if ($response->isNotFound()) {
            return view('404');
        } else {
            $info = $response->getData();
            $data = [
                'is_create_new' => false,
                'init_ingredient_request' => $info->ingredientRequest,
                'init_lines' => $info->lines,
                'user' => $user,
            ];
        }

        return $this->vue('pm0020', $data);
    }
}
