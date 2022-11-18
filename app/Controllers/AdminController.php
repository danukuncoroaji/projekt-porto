<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class AdminController extends BaseController
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
        return view('app/admin/index', $this->data);
    }

    public function create()
    {
        return view('app/admin/create', $this->data);
    }

    public function store()
    {
        try {

            $valid = $this->validate([
                'nama' => 'required',
                'username' => 'required|is_unique[user.username]',
                'password' => 'required|min_length[8]',
                'no_hp' => 'required',
                'alamat' => 'required',
                'level' => 'required',
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $this->user->insert([
                'nama' => $this->request->getVar('nama'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'level' => $this->request->getVar('level'),
                'no_hp' => $this->request->getVar('no_hp'),
                'alamat' => $this->request->getVar('alamat'),
            ]);

            session()->setFlashdata('success', "User berhasil ditambah.");
            return redirect()->to('/app/admin');
        } catch (\Exception$e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/admin/tambah')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function edit($id)
    {
        $this->data['user'] = $this->user->find($id);
        return view('app/admin/edit', $this->data);
    }

    public function update($id)
    {
        try {

            $valid = $this->validate([
                'nama' => 'required',
                'level' => 'required',
                'no_hp' => 'required',
                'alamat' => 'required',
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }
            if($this->request->getVar('password')){
                $this->user->update($id, [
                    'nama' => $this->request->getVar('nama'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'level' => $this->request->getVar('level'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'alamat' => $this->request->getVar('alamat'),
                ]);
            }else{
                $this->user->update($id, [
                    'nama' => $this->request->getVar('nama'),
                    'level' => $this->request->getVar('level'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'alamat' => $this->request->getVar('alamat'),
                ]);
            }

            session()->setFlashdata('success', "User berhasil diubah.");
            return redirect()->to('/app/admin');
        } catch (\Exception$e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/admin/edit/' . $id)->withInput(); //->with('validation', $this->validator);
        }
    }

    public function delete($id)
    {
        try {

            $this->user->delete(['id' => $id]);

            session()->setFlashdata('success', "User berhasil dihapus.");

            return redirect()->to('/app/admin');
        } catch (\Exception$e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/admin')->withInput(); //->with('validation', $this->validator);
        }
    }
}
