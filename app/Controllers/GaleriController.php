<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Galeri;

class GaleriController extends BaseController
{
    protected $session;
    protected $data;
    protected $user;
    protected $galeri;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->level = $this->session->get('level');

        $this->user = new User();
        $this->galeri = new Galeri();

        if ($this->level !== 1) {
            return redirect()->to('/');
        }
    }

    public function index()
    {
        $this->data['galeris'] = $this->galeri->findAll();
        return view('app/galeri/index', $this->data);
    }

    public function store()
    {
        try {
            $valid = $this->validate([
                'file' => 'uploaded[file]|max_size[file,200000]|ext_in[file,jpg,png,jpeg,mp4]',
            ]);


            $files = $this->request->getFileMultiple('file');

            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $name = $file->getRandomName();
                    $file->move(ROOTPATH . 'public/assets/uploads/galeri', $name);
                    $path = 'assets/uploads/galeri/' . $name;
                    $this->galeri->insert([
                        'name' => $name,
                        'path' => $path,
                        'keterangan' => $this->request->getVar('keterangan'),
                        'size' => $file->getSizeByUnit('kb'),
                        'type' => $file->getClientMimeType(),
                    ]);
                }
            }

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }
            session()->setFlashdata('success', "Galeri berhasil ditambah.");
            return redirect()->to('/app/galeri');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/galeri')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function delete($id)
    {
        try {
            
            $gambar = $this->galeri->find($id);

            if(file_exists($_SERVER['DOCUMENT_ROOT'] .'/'.$gambar['path'])){
                unlink($_SERVER['DOCUMENT_ROOT'] .'/'.$gambar['path']);
            }
            $this->galeri->delete($id);


            session()->setFlashdata('success', "Galeri berhasil dihapus.");
            return redirect()->to('/app/galeri');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/galeri')->withInput(); //->with('validation', $this->validator);
        }
    }
}
