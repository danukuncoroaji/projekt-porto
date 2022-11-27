<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class PembayaranController extends BaseController
{
    protected $session;
    protected $data;
    protected $user;

    protected $reservasi;
    protected $pembayaran;

    public function __construct()
    {
        $this->session = session();
        $this->data['session'] = $this->session;
        $this->data['validation'] = \Config\Services::validation();
        $this->level = $this->session->get('level');

        $this->user = new User();
        $this->reservasi = new Reservasi();
        $this->pembayaran = new Pembayaran();
    }

    public function index()
    {
        if ($this->level == 1) {
            $pembayarans = $this->pembayaran->orderBy('pembayaran.created_at','DESC')->findAll();
        } else if ($this->level == 3) {
            $pembayarans = $this->pembayaran
            ->select('pembayaran.id,pembayaran.jumlah,pembayaran.kategori,pembayaran.id_reservasi,pembayaran.status,pembayaran.created_at')
            ->join('reservasi','pembayaran.id_reservasi = reservasi.id')
            ->whereIn('reservasi.status',[2,3])
            ->where('pembayaran.id_user', $this->session->get('id'))
            ->orderBy('pembayaran.created_at','DESC')->findAll();
        }
        $this->data['pembayarans'] = $pembayarans;
        return view('app/pembayaran/index', $this->data);
    }

    public function riwayat()
    {
        if ($this->level == 1) {
            $pembayarans = $this->pembayaran->orderBy('pembayaran.created_at','DESC')->findAll();
        } else if ($this->level == 3) {
            $pembayarans = $this->pembayaran
            ->select('pembayaran.id,pembayaran.jumlah,pembayaran.kategori,pembayaran.id_reservasi,pembayaran.status,pembayaran.created_at')
            ->join('reservasi','pembayaran.id_reservasi = reservasi.id')
            ->whereIn('reservasi.status',[4,5])
            ->where('pembayaran.id_user', $this->session->get('id'))
            ->orderBy('pembayaran.created_at','DESC')->findAll();
        }
        $this->data['pembayarans'] = $pembayarans;
        return view('app/pembayaran/riwayat', $this->data);
    }

    public function detail($id)
    {
        $pembayaran = $this->pembayaran->find($id);
        if ($this->level == 1 || $this->level == 2 || $pembayaran['id_user'] == $this->session->get('id')) {
            $this->data['pembayaran'] = $pembayaran;
            return view('app/pembayaran/detail', $this->data);
        }else{
            return redirect()->to('/app/pembayaran/');
        }
    }

    public function konfirmasi($id)
    {
        try {
            $this->pembayaran->update($id, [
                'status' => 2,
            ]);

            $pembayaran = $this->pembayaran->find($id);
            $reservasi = $this->reservasi->find($pembayaran['id_reservasi']);
            $total_bayar = $this->pembayaran
                                ->select('sum(jumlah) as jumlah')
                                ->where('id_reservasi',$pembayaran['id_reservasi'])
                                ->where('status',2)
                                ->whereNotIn('id',[$id])
                                ->first();
            $total_bayar = $total_bayar['jumlah'] > 0 ? $total_bayar['jumlah'] : 0;

            // dd($total_bayar + $pembayaran['jumlah']);

            if(($total_bayar + $pembayaran['jumlah']) == $reservasi['harga']){
                $this->reservasi->update($pembayaran['id_reservasi'], [
                    'status' => 4
                ]);
            }

            session()->setFlashdata('success', "Pembayaran dikonfirmasi.");
            return redirect()->to('/app/pembayaran');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/pembayaran')->withInput(); //->with('validation', $this->validator);
        } 
    }

    public function tolak($id)
    {
        try {
            $this->pembayaran->update($id, [
                'status' => 3,
            ]);

            // $pembayaran = $this->pembayaran->find($id);

            // $this->reservasi->update($pembayaran['id_reservasi'], [
            //     'status' => 5
            // ]);
            
            session()->setFlashdata('success', "Pembayaran ditolak.");
            return redirect()->to('/app/pembayaran');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/pembayaran')->withInput(); //->with('validation', $this->validator);
        } 
    }

    public function bayar($id)
    {
        $this->data['id'] = $id;
        $reservasi = $this->reservasi->find($id);

        if ($reservasi['status'] == 3) {
            return redirect()->to('/app/reservasi/');
        }

        $cek1 = $this->pembayaran->select('sum(jumlah) as jumlah')->where('id_reservasi', $id)->where('status',2)->first();

        $total = $cek1['jumlah'] ? $cek1['jumlah'] : 0;

        $cek2 = $this->pembayaran->select('sum(jumlah) as jumlah')->where('id_reservasi', $id)->where('status',1)->first();
        $this->data['nunggu'] = $cek2['jumlah'] ? $cek2['jumlah'] : 0;

        $this->data['pembayarans'] = $this->pembayaran->where('id_reservasi', $id)->orderBy('created_at', 'desc')->findAll();

        $this->data['sudah'] = $total;
        $this->data['kurang'] = $reservasi['harga'] - $total;

        if ($reservasi['status'] == 1) {
            $this->data['nstat'] = 0;
        } else {
            $this->data['nstat'] = 1;
        }

        $this->data['reservasi'] = $reservasi;

        // dd($this->data);

        return view('app/pembayaran/bayar', $this->data);
    }

    public function store()
    {
        try {
            $valid = $this->validate([
                'file' => [
                    'uploaded[file]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
                'jml' => 'required',
                'id' => 'required',
            ]);

            $id = $this->request->getVar('id');

            if (!$valid) {
                throw new \Exception($this->validator->listErrors());
            }

            $jml = str_replace(',', '', str_replace('Rp ', '', $this->request->getVar('jml')));
            $reservasi = $this->reservasi->find($id);

            $invoice = $this->generateInvoice();

            $cek = $this->pembayaran->where('id_reservasi', $id)->orderBy('created_at', 'desc')->findAll();
            $sisa = $this->request->getVar('sisa');

            if (!((int)$jml > (int)$sisa)) {
                if (count($cek) == 0) {
                    if ($this->request->getVar('status') == 2) {
                        if ($jml <= ($sisa * 0.25)) {
                            throw new \Exception("Jumlah bayar kurang dari 25% !");
                        } else if ($jml >= ($sisa * 0.8)) {
                            throw new \Exception("Jumlah bayar melebihi 80% !");
                        } else {
                            $path = $this->uploadBukti($this->request->getFile('file'));
                            $this->pembayaran->insert([
                                'id' => $invoice,
                                'id_reservasi' => $id,
                                'id_user' => $this->session->get('id'),
                                'id_suite' => $reservasi['id_suite'],
                                'kategori' => $this->request->getVar('status'),
                                'jumlah' => $jml,
                                'bukti' => $path,
                                'status' => 1
                            ]);

                            $this->reservasi->update($id, [
                                'status' => 2
                            ]);

                            session()->setFlashdata('success', "Pembayaran berhasil, sisa tagihan anda = ".$sisa - $jml);
                        }
                    } else if ($this->request->getVar('status') == 1) {
                        if ($jml == $reservasi['harga']) {
                            $path = $this->uploadBukti($this->request->getFile('file'));

                            $this->pembayaran->insert([
                                'id' => $invoice,
                                'id_reservasi' => $id,
                                'id_user' => $this->session->get('id'),
                                'id_suite' => $reservasi['id_suite'],
                                'kategori' => $this->request->getVar('status'),
                                'jumlah' => $jml,
                                'bukti' => $path,
                                'status' => 1
                            ]);
                            $this->reservasi->update($id, [
                                'status' => 3
                            ]);
                            session()->setFlashdata('success', "Pembayaran berhasil, menunggu konfirmasi admin.");
                        } else {
                            throw new \Exception("Jumlah bayar tidak mencukupi !");
                        }
                    }
                } else {
                    if ($jml < $sisa) {
                        //blm lunas
                        $path = $this->uploadBukti($this->request->getFile('file'));
                        $this->pembayaran->insert([
                            'id' => $invoice,
                            'id_reservasi' => $id,
                            'id_user' => $this->session->get('id'),
                            'id_suite' => $reservasi['id_suite'],
                            'kategori' => 2,
                            'jumlah' => $jml,
                            'bukti' => $path,
                            'status' => 1
                        ]);
                        $this->reservasi->update($id, [
                            'status' => 2
                        ]);
                        session()->setFlashdata('success', "Pembayaran berhasil, sisa tagihan anda = ".$sisa - $jml);
                    } else if ($jml == $sisa) {
                        //lunas
                        $path = $this->uploadBukti($this->request->getFile('file'));
                        $this->pembayaran->insert([
                            'id' => $invoice,
                            'id_reservasi' => $id,
                            'id_user' => $this->session->get('id'),
                            'id_suite' => $reservasi['id_suite'],
                            'kategori' => 2,
                            'jumlah' => $jml,
                            'bukti' => $path,
                            'status' => 1
                        ]);
                        $this->reservasi->update($id, [
                            'status' => 3
                        ]);
                        session()->setFlashdata('success', "Pembayaran telah lunas, menunggu konfirmasi admin.");
                    } else {
                        throw new \Exception("Jumlah bayar melebihi tagihan !");
                    }
                }
            } else {
                throw new \Exception("Jumlah bayar melebihi tagihan !");
            }

            return redirect()->to('/app/pembayaran/');
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('/app/pembayaran/bayar/' . $id)->withInput(); //->with('validation', $this->validator);
        }
    }

    function generateInvoice()
    {
        $q = $this->pembayaran->select('MAX(RIGHT(id,4)) as kd_max')->where('DATE(created_at)', date('Y-m-d'))->findAll();
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
        return 'PAY'.date('dmy') . $kd;
    }

    function uploadBukti($file)
    {
        $name = $file->getRandomName();
        $upload = $file->move(ROOTPATH . 'public/assets/uploads/bukti_bayar', $name);
        $path = 'assets/uploads/bukti_bayar/' . $name;
        return $path;
    }
}
