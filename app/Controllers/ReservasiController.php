<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use DateTime;

use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Suites;
use App\Models\KategoriHarga;
use App\Models\Harga;

class ReservasiController extends BaseController
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
        $reservasi_1 = $this->reservasi->findAll();
        if ($this->level == 1) {
            $reservasis = $this->reservasi
                ->orderBy('check_in', 'DESC')
                ->where('DATE(check_out) > ', date('Y-m-d'))
                ->orderBy('check_in', 'DESC')
                ->findAll();
        } else if ($this->level == 3) {
            $reservasis = $this->reservasi
                ->where('id_user', $this->session->get('id'))
                ->where('DATE(check_out) > ', date('Y-m-d'))
                ->orderBy('check_in', 'DESC')->findAll();
        }
        foreach ($reservasis as $key => $value) {
            $reservasis[$key]['suite_name'] = $this->suite->find($reservasis[$key]['id_suite'])['nama'];
            $reservasis[$key]['pemesan'] = $this->user->find($reservasis[$key]['id_user'])['nama'];
            $last = $this->pembayaran->where('id_reservasi', $reservasis[$key]['id'])->orderBy('created_at', 'desc')->first();

            $reservasis[$key]['kategori_pembayaran'] = $last ? $last['kategori'] : 0;
            $reservasis[$key]['status_pembayaran'] = $last ? $last['status'] : 0;
        }
        foreach ($reservasi_1 as $key => $value) {
            $reservasi_1[$key]['suite_name'] = $this->suite->find($reservasi_1[$key]['id_suite'])['nama'];
            $reservasi_1[$key]['pemesan'] = $this->user->find($reservasi_1[$key]['id_user'])['nama'];
        }
        $this->data['reservasis_1'] = $reservasi_1;
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
                ->orderBy('check_in', 'DESC')->findAll();
        }
        foreach ($reservasis as $key => $value) {
            $reservasis[$key]['suite_name'] = $this->suite->find($reservasis[$key]['id_suite'])['nama'];
            $reservasis[$key]['pemesan'] = $this->user->find($reservasis[$key]['id_user'])['nama'];
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
        $this->data['users'] = $this->user->where('level', 3)->findAll();

        $reservasi_1 = $this->reservasi->findAll();
        foreach ($reservasi_1 as $key => $value) {
            $reservasi_1[$key]['suite_name'] = $this->suite->find($reservasi_1[$key]['id_suite'])['nama'];
            $reservasi_1[$key]['pemesan'] = $this->user->find($reservasi_1[$key]['id_user'])['nama'];
        }
        $this->data['reservasis_1'] = $reservasi_1;

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
            $id_u = 0;
            if ($this->level == 1) {
                $id_u = $this->request->getVar('customer');
            }

            if ($this->request->getVar('suite') == "0") {
                $suite = [1, 2];
                $status = true;
                foreach ($suite as $key => $value) {
                    $status = $this->cekReservasi(
                        $suite[$key],
                        date("Y-m-d", strtotime($this->request->getVar('check_in'))),
                        date("Y-m-d", strtotime($this->request->getVar('check_out'))),
                        $status
                    );
                }
                if ($status) {

                    $checkin =  new \DateTime($this->request->getVar('check_in'));
                    $checkout =  new \DateTime($this->request->getVar('check_out'));

                    $interval = \DateInterval::createFromDateString('1 day');
                    $daterange = new \DatePeriod($checkin, $interval, $checkout);

                    $data = [];
                    $total = 0;

                    foreach ($daterange as $date) {
                        foreach ($suite as $key => $value) {
                            $harga_weekday = $this->kategori_harga->where('id_suite', $suite[$key])->where('nama', 'weekday')->first()['harga'];
                            $harga_weekend = $this->kategori_harga->where('id_suite', $suite[$key])->where('nama', 'weekend')->first()['harga'];
                            $detailSuite = $this->suite->find($suite[$key]);
                            $sub = 0;

                            if ($this->request->getVar('keluarga')) {
                                $sub = $this->kategori_harga->where('id_suite', $suite[$key])->where('nama', 'keluarga')->first()['harga'];
                                $status = 'keluarga - ' . $detailSuite['nama'];
                            } else {
                                $cek = $this->harga->where('id_suite', $suite[$key])->where('tanggal', $date->format("Y-m-d"))->first();
                                if ($cek) {
                                    $sub = $cek['harga'];
                                    $status = 'peak day - ' . $detailSuite['nama'];;
                                } else if ($this->isWeekend($date->format("Y-m-d"))) {
                                    $sub = $harga_weekend;
                                    $status = 'weekend - ' . $detailSuite['nama'];;
                                } else if (!$this->isWeekend($date->format("Y-m-d"))) {
                                    $sub = $harga_weekday;
                                    $status = 'weekday - ' . $detailSuite['nama'];;
                                }
                            }

                            $total += $sub;
                            array_push($data, [$date->format("Y-m-d"), $sub, $status]);
                        }
                    }
                    $this->data['suite'] = "Hapsari & Prameswari";
                    $this->data['suite_id'] = "0";
                } else {
                    throw new \Exception("Suite tidak tersedia pada tanggal tersebut. mohon pilih tanggal yang lain.");
                }
            } else {
                $status = true;

                $status = $this->cekReservasi(
                    $this->request->getVar('suite'),
                    date("Y-m-d", strtotime($this->request->getVar('check_in'))),
                    date("Y-m-d", strtotime($this->request->getVar('check_out'))),
                    $status
                );

                if ($status) {
                    $harga_weekday = $this->kategori_harga->where('id_suite', $this->request->getVar('suite'))->where('nama', 'weekday')->first()['harga'];
                    $harga_weekend = $this->kategori_harga->where('id_suite', $this->request->getVar('suite'))->where('nama', 'weekend')->first()['harga'];

                    $checkin =  new \DateTime($this->request->getVar('check_in'));
                    $checkout =  new \DateTime($this->request->getVar('check_out'));

                    $interval = \DateInterval::createFromDateString('1 day');
                    $daterange = new \DatePeriod($checkin, $interval, $checkout);

                    $data = [];
                    $total = 0;
                    foreach ($daterange as $date) {
                        $sub = 0;

                        if ($this->request->getVar('keluarga')) {
                            $sub = $this->kategori_harga->where('id_suite', $this->request->getVar('suite'))->where('nama', 'keluarga')->first()['harga'];
                            $status = 'keluarga';
                        } else {
                            $cek = $this->harga->where('id_suite', $this->request->getVar('suite'))->where('tanggal', $date->format("Y-m-d"))->first();
                            if ($cek) {
                                $sub = $cek['harga'];
                                $status = 'peak day';
                            } else if ($this->isWeekend($date->format("Y-m-d"))) {
                                $sub = $harga_weekend;
                                $status = 'weekend';
                            } else if (!$this->isWeekend($date->format("Y-m-d"))) {
                                $sub = $harga_weekday;
                                $status = 'weekday';
                            }
                        }

                        $total += $sub;
                        array_push($data, [$date->format("Y-m-d"), $sub, $status]);
                    }

                    $this->data['suite'] = $this->suite->find($this->request->getVar('suite'))['nama'];
                    $this->data['suite_id'] = $this->request->getVar('suite');
                } else {
                    throw new \Exception("Suite tidak tersedia pada tanggal tersebut. mohon pilih tanggal yang lain.");
                }
            }
            $this->data['check_in'] = $this->request->getVar('check_in');
            $this->data['check_out'] = $this->request->getVar('check_out');
            $this->data['malam'] = $checkout->diff($checkin)->format("%a");
            $this->data['total'] = $total;
            $this->data['datas'] = $data;
            $this->data['id_u'] = $id_u;
            $this->data['keluarga'] = $this->request->getVar('keluarga') ? $this->request->getVar('keluarga') : 0;

            if (!empty($this->request->getVar('id'))) {
                $this->data['id'] = $this->request->getVar('id');
            } else {
                $this->data['id'] = "";
            }
            // dd($this->data);
            return view('app/reservasi/konfirmasi', $this->data);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/reservasi/tambah')->withInput(); //->with('validation', $this->validator);
        }
    }

    public function store()
    {
        try {
            $id_u = $this->request->getVar('id_u') == "0" ? $this->session->get('id') : $this->request->getVar('id_u');
            if ($this->request->getVar('suite') == "0") {
                $suite = [1,2];
                foreach ($suite as $key => $value) {

                    $harga_weekday = $this->kategori_harga->where('id_suite', $suite[$key])->where('nama', 'weekday')->first()['harga'];
                    $harga_weekend = $this->kategori_harga->where('id_suite', $suite[$key])->where('nama', 'weekend')->first()['harga'];

                    $checkin =  new \DateTime($this->request->getVar('check_in'));
                    $checkout =  new \DateTime($this->request->getVar('check_out'));

                    $interval = \DateInterval::createFromDateString('1 day');
                    $daterange = new \DatePeriod($checkin, $interval, $checkout);

                    $data = [];
                    $total = 0;
                    foreach ($daterange as $date) {
                        $sub = 0;

                        if ($this->request->getVar('keluarga')) {
                            $sub = $this->kategori_harga->where('id_suite', $suite[$key])->where('nama', 'keluarga')->first()['harga'];
                            $status = 'keluarga';
                        } else {
                            $cek = $this->harga->where('id_suite', $suite[$key])->where('tanggal', $date->format("Y-m-d"))->first();
                            if ($cek) {
                                $sub = $cek['harga'];
                                $status = 'peak day';
                            } else if ($this->isWeekend($date->format("Y-m-d"))) {
                                $sub = $harga_weekend;
                                $status = 'weekend';
                            } else if (!$this->isWeekend($date->format("Y-m-d"))) {
                                $sub = $harga_weekday;
                                $status = 'weekday';
                            }
                        }

                        $total += $sub;
                    }

                    $this->reservasi->insert([
                        'id' => $this->generateInvoice(),
                        'id_suite' => $suite[$key],
                        'id_user' => $id_u,
                        'check_in' => $this->request->getVar('check_in'),
                        'check_out' => $this->request->getVar('check_out'),
                        'harga' => $total,
                        'keluarga' => $this->request->getVar('keluarga'),
                        'status' => 1,
                    ]);
                }
            } else {
                $id_r = $this->request->getVar('id_r');
                if (empty($id_r)) {
                    $this->reservasi->insert([
                        'id' => $this->generateInvoice(),
                        'id_suite' => $this->request->getVar('suite'),
                        'id_user' => $id_u,
                        'check_in' => $this->request->getVar('check_in'),
                        'check_out' => $this->request->getVar('check_out'),
                        'harga' => $this->request->getVar('total'),
                        'keluarga' => $this->request->getVar('keluarga'),
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
        $user = $this->user->find($reservasi['id_user']);

        $harga_weekday = $this->kategori_harga->where('id_suite', $reservasi['id_suite'])->where('nama', 'weekday')->first()['harga'];
        $harga_weekend = $this->kategori_harga->where('id_suite', $reservasi['id_suite'])->where('nama', 'weekend')->first()['harga'];

        $checkin =  new \DateTime($reservasi['check_in']);
        $checkout =  new \DateTime($reservasi['check_out']);

        $interval = \DateInterval::createFromDateString('1 day');
        $daterange = new \DatePeriod($checkin, $interval, $checkout);

        $data = [];
        $total = 0;
        foreach ($daterange as $date) {
            $sub = 0;
            if ($reservasi['keluarga'] == "1") {
                $sub = $this->kategori_harga->where('id_suite', $reservasi['id_suite'])->where('nama', 'keluarga')->first()['harga'];
                $status = 'keluarga';
            } else {
                $cek = $this->harga->where('id_suite', $reservasi['id_suite'])->where('tanggal', $date->format("Y-m-d"))->first();
                if ($cek) {
                    $sub = $cek['harga'];
                    $status = 'peak day';
                } else if ($this->isWeekend($date->format("Y-m-d"))) {
                    $sub = $harga_weekend;
                    $status = 'weekend';
                } else if (!$this->isWeekend($date->format("Y-m-d"))) {
                    $sub = $harga_weekday;
                    $status = 'weekday';
                }
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
        $this->data['user'] = $user;

        $cek1 = $this->pembayaran->select('sum(jumlah) as jumlah')->where('id_reservasi', $id)->where('status', 2)->first();
        $this->data['sudah'] = $cek1['jumlah'] ? $cek1['jumlah'] : 0;
        $cek2 = $this->pembayaran->select('sum(jumlah) as jumlah')->where('id_reservasi', $id)->where('status', 1)->first();
        $this->data['nunggu'] = $cek2['jumlah'] ? $cek2['jumlah'] : 0;
        $this->data['kurang'] = $reservasi['harga'] - $this->data['sudah'];
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

    public function citak($id){
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

    function cekReservasi($suite, $cekin, $cekout, $status)
    {
        $cekreservasis = $this->reservasi
            ->whereIn('status', [2, 3, 4])
            ->where('id_suite', $suite)
            ->findAll();
        // dd($suite);
        foreach ($cekreservasis as $reservasi) {
            $n1 = date('Y-m-d', strtotime($reservasi['check_in']));
            $n2 = date('Y-m-d', strtotime($reservasi['check_out']));
            if (($cekin >= $n1) && ($cekin <= $n2)) {
                $status = false;
            }
            if (($cekout >= $n1) && ($cekout <= $n2)) {
                $status = false;
            }
        }
        return $status;
    }
}
