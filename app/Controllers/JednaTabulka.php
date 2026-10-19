<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RaceYear;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Stage;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;

class JednaTabulka extends BaseController
{
    protected Stage $stage;
    protected RaceYear $raceYear;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->stage = new Stage();
        $this->raceYear = new RaceYear();
    }

    public function index()
    {
        // Sum(stage.distance) as total_distance
        //
        $vse = $this->raceYear->select('race_year.*, Sum(final_stage.distance) as total_distance')->like('race_year.real_name', 'Paris - Nice')->join('stage', 'race_year.id = stage.id_race_year', 'left')->groupBy('race_year.id')->orderBy('race_year.year', 'ASC')->findAll();

        $data = [
            'vse' => $vse
        ];

        return view('hlavni', $data);
    }
}
