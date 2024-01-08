<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0006ApiController;
use Illuminate\Http\Request;

class PM0006Controller extends BaseController
{
    /**
     * @var PM0006ApiController
     */
    private $api;

    /**
     * PM0033Controller constructor.
     * @param PM0006ApiController $api
     */
    public function __construct(PM0006ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $results = $this->api->showJobs()->getData();

        $data = [
            'init_summary_job_grouping' => $results->summaryJobGrouping,
            'init_max_wip_steps' => $results->maxWipSteps,
        ];

        return $this->vue('pm0006', $data);
    }

    public function showJob($batchNo)
    {
        $response = $this->api->showJob($batchNo);
        if($response->isNotFound()){
            return view('404');
        }

        $results = $response->getData();
        $data = [
            'init_job_summary' => $results->jobSummary,
            'init_jobs' => $results->jobs,
            'init_opts' => $results->opts,
        ];

        return $this->vue('pm0006-job', $data);
    }
}
