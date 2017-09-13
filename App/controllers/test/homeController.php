<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 11:55 AM
 */
App::_model('parking.parkingModel');
App::_model('resident.residentModel');

class homeController extends _controllerBase
{

    function __construct()
    {
        parent::__construct();

        $this->model = new parkingModel();
        $this->residentModel = new residentModel();

        $countActive = $this->model->CountRow(1);
        $countResident = $this->residentModel->CountRow();

        App::_view('home.view',[
            'countActive' => $countActive,
            'countResident' => $countResident,
        ]);
    }




}