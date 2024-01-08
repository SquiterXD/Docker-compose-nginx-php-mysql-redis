<?php


namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\PD\Api\PD0006ApiController;

class PD0006Controller extends BaseController
{

    /**
     * @var PD0006ApiController
     */
    private $api;

    /**
     * PD0006Controller constructor.
     * @param PD0006ApiController $api
     */
    public function __construct(PD0006ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->index()->getData();
        $data = [
            'header' => $response->header,

            'leaf_formulae' => $response->leaf_formulae,
            'flavours' => $response->flavours,
            'statuses' => $response->statuses,
            'created_by_user' => $response->created_by_user,
            'leaf_formulae_lookup' => $response->leaf_formulae_lookup,
        ];

        return $this->vue('pd0006', $data);
    }

    public function show($blendId)
    {
        //validating
        $response = $this->api->show($blendId);
        if ($response->isNotFound()) {
            return view('404');
        } else if (!$response->isSuccessful()) {
            return view('500');
        }

        $blendFormula = $response->getData();
        $data = [
            'header' => $blendFormula->header,
            'leaf_formulae' => $blendFormula->leaf_formulae,
            'casings' => $blendFormula->casings,
            'flavours' => $blendFormula->flavours,
            'example_cigarette' => $blendFormula->example_cigarette,
            'raw_materials' => $blendFormula->raw_materials,

            //look up
            'lookup_leaf_formulae' => $blendFormula->lookup_leaf_formulae,
            'lookup_tastes' => $blendFormula->lookup_tastes,
            'lookup_statuses' => $blendFormula->lookup_statuses,
        ];

        return $this->vue('pd0006', $data);
    }
}

?>
