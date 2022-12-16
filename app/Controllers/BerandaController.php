<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Suites;
use App\Models\KategoriHarga;
use App\Models\Harga;

class BerandaController extends BaseController
{
    protected $session;
    protected $data;

    protected $user;
    protected $reservasi;
    protected $pembayaran;
    protected $suite;
    protected $harga;
    protected $kategori_harga;

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
        $this->harga = new Harga();
        $this->kategori_harga = new KategoriHarga();
    }

    public function index()
    {
        if ($this->level == 1) {
            //reservasi hari ini & kalender==================================================================================================
            $reservasi_all = $this->reservasi->findAll();
            $reservasis = $this->reservasi
                ->where('DATE(created_at)', date('Y-m-d'))
                ->findAll();
            foreach ($reservasis as $key => $value) {
                $reservasis[$key]['suite_name'] = $this->suite->find($reservasis[$key]['id_suite'])['nama'];
                $reservasis[$key]['pemesan'] = $this->user->find($reservasis[$key]['id_user'])['nama'];
                $last = $this->pembayaran->where('id_reservasi', $reservasis[$key]['id'])->orderBy('created_at', 'desc')->first();

                $reservasis[$key]['kategori_pembayaran'] = $last ? $last['kategori'] : 0;
                $reservasis[$key]['status_pembayaran'] = $last ? $last['status'] : 0;
            }
            foreach ($reservasi_all as $key => $value) {
                $reservasi_all[$key]['suite_name'] = $this->suite->find($reservasi_all[$key]['id_suite'])['nama'];
                $reservasi_all[$key]['pemesan'] = $this->user->find($reservasi_all[$key]['id_user'])['nama'];
            }
            $this->data['reservasis_all'] = $reservasi_all;
            $this->data['reservasis'] = $reservasis;

            //grafik pendapatan==================================================================================================
            $tahun = date('Y');
            $warna = ['rgba(241, 196, 15,1.0)', 'rgba(46, 204, 113,1.0)', 'rgba(52, 152, 219,1.0)'];
            $data = array();
            $ar = array();
            $data['labels'] = array();
            for ($n = 1; $n <= 12; $n++) {
                array_push($data['labels'], date('F', strtotime($tahun . '-' . $n)) . ' ' . $tahun);
            }

            $data['datasets'] = array();
            $nar = array();
            $nar['label'] = ['Grafik Pendapatan'];
            $nar['type'] = 'bar';
            $nar['data'] = array();
            for ($n = 1; $n <= 12; $n++) {
                $n = str_pad($n, 2, '0', STR_PAD_LEFT);
                $get = $this->pembayaran
                    ->select('sum(pembayaran.jumlah) as jml')
                    ->where("pembayaran.status", 2)
                    ->where('MONTH(created_at)', $n)
                    ->where('YEAR(created_at)', $tahun)
                    ->first();
                $jml = $get['jml'] ? (int)$get['jml'] : 0;
                array_push($nar['data'], $jml);
            }
            $nar['backgroundColor'] = $warna[0];
            array_push($data['datasets'], $nar);

            $this->data['grafik_pendapatan'] = json_encode($data);

            //grafik pengujung==================================================================================================
            $tahun = date('Y');
            $warna = ['rgba(241, 196, 15,1.0)', 'rgba(46, 204, 113,1.0)', 'rgba(52, 152, 219,1.0)'];
            $data = array();
            $ar = array();
            $data['labels'] = array();
            for ($n = 1; $n <= 12; $n++) {
                array_push($data['labels'], date('F', strtotime($tahun . '-' . $n)) . ' ' . $tahun);
            }

            $data['datasets'] = array();
            $nar = array();
            $nar['label'] = ['Grafik Pengunjung'];
            $nar['type'] = 'bar';
            $nar['data'] = array();
            for ($n = 1; $n <= 12; $n++) {
                $n = str_pad($n, 2, '0', STR_PAD_LEFT);
                $get = $this->reservasi
                    ->select('count(id) as jml')
                    ->whereIn("status", [2,3,4])
                    ->where('MONTH(created_at)', $n)
                    ->where('YEAR(created_at)', $tahun)
                    ->first();
                $jml = $get['jml'] ? (int)$get['jml'] : 0;
                array_push($nar['data'], $jml);
            }
            $nar['backgroundColor'] = $warna[1];
            array_push($data['datasets'], $nar);
            $this->data['grafik_pengunjung'] = json_encode($data);

        } else {
            $reservasi_1 = $this->reservasi->findAll();
            foreach ($reservasi_1 as $key => $value) {
                $reservasi_1[$key]['suite_name'] = $this->suite->find($reservasi_1[$key]['id_suite'])['nama'];
                $reservasi_1[$key]['pemesan'] = $this->user->find($reservasi_1[$key]['id_user'])['nama'];
            }
            $this->data['reservasis_1'] = $reservasi_1;
            $this->data['reservasis'] = $reservasi_1;
        }
        // dd($this->data);
        return view('app/home', $this->data);
    }
}
