<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Harga;
use App\Models\Suites;
use App\Models\KategoriHarga;

class TanggalController extends BaseController
{
    protected $session;
    protected $data;
    protected $user;
    protected $harga;
    protected $suite;
    protected $kategori_harga;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->level = $this->session->get('level');

        $this->user = new User();
        $this->suite = new Suites();
        $this->kategori_harga = new KategoriHarga();
        $this->harga = new Harga();
    }

    public function index()
    {
        if ($this->level != "1") {
            return redirect()->to('/app');
        }
        $this->data['hargas'] = $this->harga->findAll();
        $this->data['suites'] = $this->suite->findAll();
        $this->data['kategoris'] = $this->kategori_harga->findAll();

        foreach ($this->data['kategoris'] as $key => $value) {
            $this->data['kategoris'][$key]['suite'] = $this->suite->find($this->data['kategoris'][$key]['id_suite'])['nama'];
        }

        foreach ($this->data['hargas'] as $key => $value) {
            $this->data['hargas'][$key]['suite'] = $this->suite->find($this->data['hargas'][$key]['id_suite'])['nama'];
        }
        return view('app/tanggal/index', $this->data);
    }

    public function store()
    {
        try {
            $valid = $this->validate([
                'harga' => 'required',
                'tanggal' => 'required',
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $harga = str_replace(',', '', str_replace('Rp ', '', $this->request->getVar('harga')));

            $id_kategori = $this->kategori_harga->where('id_suite',$this->request->getVar('suite'))->where('nama','peak day')->first()['id'];

            $this->harga->insert([
                'id_suite' => $this->request->getVar('suite'),
                'id_kategori_harga' => $id_kategori,
                'tanggal' => $this->request->getVar('tanggal'),
                'harga' => $harga
            ]);

            session()->setFlashdata('success', "Harga peak day berhasil di simpan.");
            return redirect()->to('/app/tanggal');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/tanggal')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function editKategori($id)
    {
        $this->data['kategori'] = $this->kategori_harga->find($id);
        return view('app/tanggal/editKategori', $this->data);
    }

    public function updateKategori($id)
    {
        try {

            $valid = $this->validate([
                'harga' => 'required'
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $harga = str_replace(',', '', str_replace('Rp ', '', $this->request->getVar('harga')));

            $this->kategori_harga->update($id,[
                'harga' => $harga
            ]);

            session()->setFlashdata('success', "Harga berhasil dirubah");
            return redirect()->to('/app/tanggal');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/tanggal')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function edit($id)
    {
        $this->data['harga'] = $this->harga->find($id);
        return view('app/tanggal/edit', $this->data);
    }

    public function update($id)
    {
        try {

            $valid = $this->validate([
                'harga' => 'required'
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $harga = str_replace(',', '', str_replace('Rp ', '', $this->request->getVar('harga')));

            $this->harga->update($id,[
                'harga' => $harga
            ]);

            session()->setFlashdata('success', "Harga berhasil dirubah");
            return redirect()->to('/app/tanggal');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/tanggal')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function delete($id)
    {
    }
}
