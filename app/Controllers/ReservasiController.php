<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use DateTime;

use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Suites;
use App\Models\KategoriHarga;

class ReservasiController extends BaseController
{
    protected $session;
    protected $data;

    protected $user;
    protected $reservasi;
    protected $pembayaran;
    protected $suite;
    protected $harga;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->level = $this->session->get('level');

        $this->user = new User();
        $this->reservasi = new Reservasi();
        $this->pembayaran = new Pembayaran();
        $this->suite = new Suites();
        $this->harga = new KategoriHarga();
    }

    public function index()
    {
        if ($this->level == 1) {
            $reservasis = $this->reservasi->findAll();
        } else if ($this->level == 3) {
            $reservasis = $this->reservasi
            ->where('id_user', $this->session->get('id'))
            ->where('DATE(check_out) > ', date('Y-m-d'))
            ->orderBy('created_at','DESC')->findAll();
        }
        foreach ($reservasis as $key => $value) {
            $reservasis[$key]['suite_name'] = $this->suite->find($reservasis[$key]['id_suite'])['nama'];
            $last = $this->pembayaran->where('id_reservasi', $reservasis[$key]['id'])->orderBy('created_at', 'desc')->first();

            $reservasis[$key]['kategori_pembayaran'] = $last ? $last['kategori'] : 0;
            $reservasis[$key]['status_pembayaran'] = $last ? $last['status'] : 0;
        }
        // dd($reservasis);
        $this->data['reservasis'] = $reservasis;
        return view('app/reservasi/index', $this->data);
    }

    public function riwayat()
    {
        if ($this->level == 1) {
            $reservasis = $this->reservasi->findAll();
        } else if ($this->level == 3) {
            $reservasis = $this->reservasi
            ->where('id_user', $this->session->get('id'))
            ->where('DATE(check_out) < ', date('Y-m-d'))
            ->orderBy('created_at','DESC')->findAll();
        }
        foreach ($reservasis as $key => $value) {
            $reservasis[$key]['suite_name'] = $this->suite->find($reservasis[$key]['id_suite'])['nama'];
            $last = $this->pembayaran->where('id_reservasi', $reservasis[$key]['id'])->orderBy('created_at', 'desc')->first();

            $reservasis[$key]['kategori_pembayaran'] = $last ? $last['kategori'] : 0;
            $reservasis[$key]['status_pembayaran'] = $last ? $last['status'] : 0;
        }
        // dd($reservasis);
        $this->data['reservasis'] = $reservasis;
        return view('app/reservasi/riwayat', $this->data);
    }

    public function create()
    {
        $this->data['suites'] = $this->suite->findAll();
        return view('app/reservasi/create', $this->data);
    }

    public function konfirmasi()
    {
        try {
            $valid = $this->validate([
                'check_in' => 'required',
                'check_out' => 'required',
            ]);

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $harga_weekday = $this->harga->where('id_suite', $this->request->getVar('suite'))->where('nama', 'weekday')->first()['harga'];
            $harga_weekend = $this->harga->where('id_suite', $this->request->getVar('suite'))->where('nama', 'weekend')->first()['harga'];

            $checkin =  new \DateTime($this->request->getVar('check_in'));
            $checkout =  new \DateTime(date('Y-m-d', strtotime($this->request->getVar('check_out') . "+1 days")));

            $interval = \DateInterval::createFromDateString('1 day');
            $daterange = new \DatePeriod($checkin, $interval, $checkout);

            $data = [];
            $total = 0;
            foreach ($daterange as $date) {
                $sub = 0;
                if ($this->isWeekend($date->format("Y-m-d"))) {
                    $sub = $harga_weekend;
                    $status = 'weekend';
                } else if (!$this->isWeekend($date->format("Y-m-d"))) {
                    $sub = $harga_weekday;
                    $status = 'weekday';
                }
                $total += $sub;
                array_push($data, [$date->format("Y-m-d"), $sub, $status]);
            }

            $this->data['suite'] = $this->suite->find($this->request->getVar('suite'))['nama'];
            $this->data['suite_id'] = $this->request->getVar('suite');
            $this->data['check_in'] = $this->request->getVar('check_in');
            $this->data['check_out'] = $this->request->getVar('check_out');
            $this->data['malam'] = $checkout->diff($checkin)->format("%a");
            $this->data['total'] = $total;
            $this->data['datas'] = $data;

            if (!empty($this->request->getVar('id'))) {
                $this->data['id'] = $this->request->getVar('id');
            } else {
                $this->data['id'] = "";
            }

            return view('app/reservasi/konfirmasi', $this->data);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/reservasi/tambah')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function store()
    {
        try {
            $id_r = $this->request->getVar('id_r');
            if (empty($id_r)) {
                $this->reservasi->insert([
                    'id' => $this->generateInvoice(),
                    'id_suite' => $this->request->getVar('suite'),
                    'id_user' => $this->session->get('id'),
                    'check_in' => $this->request->getVar('check_in'),
                    'check_out' => $this->request->getVar('check_out'),
                    'harga' => $this->request->getVar('total'),
                    'status' => 1,
                ]);
                session()->setFlashdata('success', "Reservasi berhasil ditambah.");
            } else {
                $this->reservasi->update($id_r, [
                    'id_suite' => $this->request->getVar('suite'),
                    'check_in' => $this->request->getVar('check_in'),
                    'check_out' => $this->request->getVar('check_out'),
                    'harga' => $this->request->getVar('total'),
                ]);
                session()->setFlashdata('success', "Reservasi berhasil diubah.");
            }
            return redirect()->to('/app/reservasi');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/reservasi')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function detail($id)
    {
        $reservasi = $this->reservasi->find($id);

        $harga_weekday = $this->harga->where('id_suite', $reservasi['id_suite'])->where('nama', 'weekday')->first()['harga'];
        $harga_weekend = $this->harga->where('id_suite', $reservasi['id_suite'])->where('nama', 'weekend')->first()['harga'];

        $checkin =  new \DateTime($reservasi['check_in']);
        $checkout =  new \DateTime(date('Y-m-d', strtotime($reservasi['check_out'] . "+1 days")));

        $interval = \DateInterval::createFromDateString('1 day');
        $daterange = new \DatePeriod($checkin, $interval, $checkout);

        $data = [];
        $total = 0;
        foreach ($daterange as $date) {
            $sub = 0;
            if ($this->isWeekend($date->format("Y-m-d"))) {
                $sub = $harga_weekend;
                $status = 'weekend';
            } else if (!$this->isWeekend($date->format("Y-m-d"))) {
                $sub = $harga_weekday;
                $status = 'weekday';
            }
            $total += $sub;
            array_push($data, [$date->format("Y-m-d"), $sub, $status]);
        }

        $last = $this->pembayaran->where('id_reservasi', $reservasi['id'])->orderBy('created_at', 'desc')->first();

        $reservasi['kategori_pembayaran'] = $last ? $last['kategori'] : 0;
        $reservasi['status_pembayaran'] = $last ? $last['status'] : 0;

        $this->data['suite'] = $this->suite->find($reservasi['id_suite'])['nama'];
        $this->data['suite_id'] = $reservasi['id_suite'];
        $this->data['check_in'] = $reservasi['check_in'];
        $this->data['check_out'] = $reservasi['check_out'];
        $this->data['total'] = $total;
        $this->data['datas'] = $data;
        $this->data['malam'] = $checkout->diff($checkin)->format("%a");
        $this->data['total'] = $total;
        $this->data['datas'] = $data;
        $this->data['reservasi'] = $reservasi;
        $this->data['pembayarans'] = $this->pembayaran->where('id_reservasi', $id)->orderBy('created_at', 'desc')->findAll();

        // dd($this->data);
        return view('app/reservasi/detail', $this->data);
    }

    public function edit($id)
    {
        $this->data['reservasi'] = $this->reservasi->find($id);
        $this->data['suites'] = $this->suite->findAll();
        return view('app/reservasi/edit', $this->data);
    }

    public function delete($id)
    {
        try {

            $this->reservasi->delete($id);

            session()->setFlashdata('success', "Reservasi dibatalkan.");
            return redirect()->to('/app/reservasi');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/reservasi')->withInput(); //->with('validation', $this->validator);
        }
    }

    function isWeekend($date)
    {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 6);
    }

    function generateInvoice()
    {
        $q = $this->reservasi->select('MAX(RIGHT(id,4)) as kd_max')->where('DATE(created_at)', date('Y-m-d'))->findAll();
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int)$k['kd_max']) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'RES' . date('dmy') . $kd;
    }
}
