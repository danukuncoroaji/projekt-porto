<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class PembayaranController extends BaseController
{
    protected $session;
    protected $data;
    protected $user;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->level = $this->session->get('level');

        $this->user = new User();

        if($this->level !== 1){
            return redirect()->to('/');
        }

        
    }

    public function index()
    {
        $this->data['users'] = $this->user->findAll();
        return view('app/pembayaran/index', $this->data);
    }

    public function update($id)
    {
    }

    public function delete($id)
    {
    }
}
