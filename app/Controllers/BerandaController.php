<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BerandaController extends BaseController
{
    protected $session;
    protected $data;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->level = $this->session->get('level');
    }

    public function index()
    {
        return view('app/home', $this->data);
    }
}
