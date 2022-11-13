<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class LoginController extends BaseController
{
    protected $session;
    protected $data;
    protected $user;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->user = new User();
    }

    public function index()
    {
        return view('app/login', $this->data);
    }

    public function loginAuth()
    {
        try {
            $valid = $this->validate([
                'username' => [
                    'rules' => 'required',
                ],
                'password' => [
                    'rules' => 'required',
                ],
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $data = $this->user->where('username', $username)->first();

            if ($data) {
                $pass = $data['password'];
                $authenticatePassword = password_verify($password, $pass);
                if ($authenticatePassword) {
                    $ses_data = [
                        'id' => $data['id'],
                        'nama' => $data['nama'],
                        'level' => $data['level'],
                        'isLoggedIn' => true,
                    ];

                    $this->session->set($ses_data);
                    return redirect()->to('/app/beranda');

                } else {
                    $this->session->setFlashdata('error', 'Username atau password salah.');
                    return redirect()->to('/app/login');
                }

            } else {
                $this->session->setFlashdata('error', 'Username atau password salah.');
                return redirect()->to('/app/login');
            }

        } catch (\Exception$e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/login')->withInput()->with('validation', $this->validator);
        }
    }

    public function register()
    {
        return view('app/register', $this->data);
    }

    public function registerStore()
    {
        try {
            $valid = $this->validate(
                [
                    'nama' => [
                        'rules' => 'required',
                    ],
                    'username' => [
                        'rules' => 'required|is_unique[user.username]',
                    ],
                    'password' => [
                        'rules' => 'required|min_length[8]',
                    ],
                    'upassword' => [
                        'rules' => 'required|matches[password]',
                    ],
                ],
                [
                    'nama' => [
                        'required' => 'Nama tidak boleh kosong.',
                    ],
                    'username' => [
                        'required' => 'Username tidak boleh kosong.',
                        'is_unique' => 'Mohon gunakan username yang lain.',
                    ],
                    'password' => [
                        'required' => 'Password tidak boleh kosong.',
                        'min_length' => 'Karakter password anda kurang panjang.',
                    ],
                    'upassword' => [
                        'required' => 'Ulangi Password tidak boleh kosong.',
                        'matches' => 'Password tidak sama.',
                    ],
                ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $this->user->insert([
                'nama' => $this->request->getVar('nama'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'level' => 3
            ]);  

            session()->setFlashdata('success', "Registrasi berhasil, silahkan masuk.");
            return redirect()->to('/app/login');

        } catch (\Exception$e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/register')->withInput()->with('validation', $this->validator);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/app/login');
    }
}
