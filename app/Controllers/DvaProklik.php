<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Stage;
use App\Models\RaceYear;
use App\Models\Result;
use Psr\Log\LoggerInterface;
use Override;

class DvaProklik extends BaseController
{
    protected $stage;
    protected $raceYear;
    protected $resultModel;

    #[Override]
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->stage = new Stage();
        $this->raceYear = new RaceYear();
        $this->resultModel = new Result();
    }

    public function index($raceYearId)
    {
        $raceYear = $this->raceYear->find($raceYearId);

        $stages = $this->stage->select('
            stage.*, 
            parcour_type.name as parcour_name,
            rider.first_name as winner_first,
            rider.last_name as winner_last
        ')
            ->join('parcour_type', 'stage.parcour_type = parcour_type.id', 'left')
            ->join('result', 'result.id_stage = stage.id AND result.rank = 1 AND result.type_result = 1', 'left')
            ->join('rider', 'result.id_rider = rider.id', 'left')
            ->where('stage.id_race_year', $raceYearId)
            ->orderBy('stage.number', 'ASC')
            ->findAll();

        $data = [
            'data_nice' => $raceYear,
            'stages'    => $stages
        ];

        return view('vs_rocniky', $data);
    }

    public function vysledek($stageId, $typeResult)
    {
        $stage = $this->stage->find($stageId);

        $this->resultModel->select('result.*, rider.first_name, rider.last_name, rider.photo');
        $this->resultModel->join('rider', 'result.id_rider = rider.id', 'left');
        $this->resultModel->where('result.id_stage', $stageId);
        $this->resultModel->where('result.type_result', $typeResult);
        $this->resultModel->orderBy('result.rank', 'ASC');

        $query = $this->resultModel->get();
        $results = $query->getResult();

        $data = array(
            'stage' => $stage,
            'results' => $results,
            'typeResult' => $typeResult
        );

        return view('result', $data);
    }
}