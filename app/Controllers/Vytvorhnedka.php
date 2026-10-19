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

class Vytvorhnedka extends BaseController
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

    public function vytvor()
    {
        $races = $this->raceYear->where('sex', 'M')->where('category', 'E')->findAll();

        $data = array(
            'races' => $races
        );

        return view('formularek', $data);
    }

    public function uchovejto()
    {
        $rules = [
            'real_name' => 'required',
            'race_id'   => 'required',
            'logo'      => 'uploaded[logo]|is_image[logo]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('logo');
        $logoName = null;

        if ($file->isValid() && !$file->hasMoved()) {
            $logoName = $file->getRandomName();
            $file->move('assets/img/logos/', $logoName);
        }

        $this->raceYear->insert([
            'real_name' => $this->request->getPost('real_name'),
            'race_id'   => $this->request->getPost('race_id'),
            'logo'      => $logoName
        ]);

        return redirect()->to(base_url());
    }
}
