<?php

namespace App\Controllers;

use App\Models\Suites;
use App\Models\Galeri;

class LandingController extends BaseController
{
    protected $data;
    protected $suite;
    protected $galeri;

    public function __construct()
    {
        $this->suite = new Suites();
        $this->galeri = new Galeri();
    }

    public function index()
    {
        $this->data['suites'] = $this->suite->findAll();
        $this->data['galeris'] = $this->galeri->findAll();
        return view('landing/index',$this->data);
    }
}
