<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Suites;
use App\Models\KategoriHarga;
use App\Models\Harga;

class LaporanController extends BaseController
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
        $laporan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan = $i;
            $tahun = date('Y');
            array_push($laporan,$this->getData($bulan,$tahun));
        }
        $this->data['laporans'] = $laporan;
        $this->data['judul'] = 'semua';
        return view('app/laporan/index', $this->data);
    }

    public function filter()
    {
        $bulan = date('m', strtotime($this->request->getVar('filter')));
        $tahun = date('Y', strtotime($this->request->getVar('filter')));
        $laporan = [];
        array_push($laporan,$this->getData($bulan,$tahun));
        $this->data['laporans'] = $laporan;
        $this->data['judul'] = date('F', strtotime($this->request->getVar('filter'))).' '.$tahun;
        return view('app/laporan/index', $this->data);
    }

    function getData($bulan,$tahun)
    {
        $laporan = [];

        $dateObj   = \DateTime::createFromFormat('!m', $bulan);
        $monthName = $dateObj->format('F');
        $laporan['bulan'] = $monthName;

        $reservasis = $this->reservasi
            ->where('Month(created_at)', $bulan)
            ->where('Year(created_at)', $tahun)
            ->findAll();
        $total = 0;
        foreach ($reservasis as $key => $value) {
            $reservasis[$key]['nama'] = $this->user->find($reservasis[$key]['id_user'])['nama'];
            $reservasis[$key]['no_hp'] = $this->user->find($reservasis[$key]['id_user'])['no_hp'];
            $reservasis[$key]['suite'] = $this->suite->find($reservasis[$key]['id_suite'])['nama'];
            $last = $this->pembayaran->where('id_reservasi', $reservasis[$key]['id'])->orderBy('created_at', 'desc')->first();

            $reservasis[$key]['kategori_pembayaran'] = $last ? $last['kategori'] : 0;
            $reservasis[$key]['status_pembayaran'] = $last ? $last['status'] : 0;
            $total += $reservasis[$key]['harga'];
        }
        $laporan['data'] = $reservasis;
        $laporan['total'] = $total;
        return $laporan;
    }
}
