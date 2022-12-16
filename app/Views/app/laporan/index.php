<?= $this->extend('app/layout/default') ?>
<?= $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js" integrity="sha512-Fd3EQng6gZYBGzHbKd52pV76dXZZravPY7lxfg01nPx5mdekqS8kX4o1NfTtWiHqQyKhEGaReSf4BrtfKc+D5w==" crossorigin="anonymous"></script>
<style>
    .fc-h-event {
        color: #ffff !important;
        background: #e74c3c !important;
        border-color: #e74c3c !important;
        padding: 4px 7px !important;
    }

    .fc-h-event .fc-event-main {
        color: #ffff !important;
    }

    .fc .fc-daygrid-event {
        margin-top: 0px !important;
        margin-bottom: 5px !important;
    }
</style>
<div class="row pb-5">
    <div class="page-description">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(''); ?>">Beranda</a></li>
                <?php if ($judul !== 'semua') { ?>
                    <li class="breadcrumb-item"><a href="<?= base_url('laporan'); ?>">Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $judul ?></li>
                <?php } else { ?>
                    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                <?php } ?>
            </ol>
        </nav>
        <h1>Laporan <?php echo $judul !== 'semua' ? ' - ' . $judul : ""; ?></h1>
        <span>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis viverra dapibus.<br>Maecenas
            eleifend augue convallis tellus rhoncus scelerisque. Aliquam eu nunc sit amet velit pharetra cursus, <a href="#">disini</a>.
        </span>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Filter</h5>
            </div>
            <form method="POST" action="<?= base_url('/app/laporan'); ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="input-bulan">
                            <div class="form-group">
                                <label class="mb-2">Bulan - Tahun</label>
                                <input class="form-control flatpickr1" type="text" name="filter" placeholder="Pilih Bulan">
                            </div>
                            <script>
                                $(".flatpickr1").flatpickr({
                                    plugins: [
                                        new monthSelectPlugin({
                                            shorthand: true, //defaults to false
                                            dateFormat: "F - Y", //defaults to "F Y"
                                            altFormat: "F Y", //defaults to "F Y"
                                            theme: "dark" // defaults to "light"
                                        })
                                    ]
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 col-lg-6 text-start">
                            <button class="btn btn-success" type="submit"> Tampilkan</button>
                        </div>
                        <?php if ($judul !== 'semua') { ?>
                            <div class="col-12 col-lg-6 text-end">
                                <a href="<?= base_url('app/laporan'); ?>" class="btn btn-info text-end">Semua</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Laporan</h5>
            </div>
            <div class="card-body">
                <table class="table" id="laporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <!-- <th>Customer id</th> -->
                            <th>Nama</th>
                            <!-- <th>No HP</th> -->
                            <!-- <th>No Invoice</th> -->
                            <th>Suites</th>
                            <th>Tanggal Check in</th>
                            <th>Tanggal Check out</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Tanggal Transaksi</th>
                            <!-- <th>Keterangan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($laporans as $reservasi) { ?>
                            <tr>
                                <td colspan="12" class="bg-secondary text-center"><?= $reservasi['bulan'] ?></td>
                            </tr>
                            <?php foreach ($reservasi['data'] as $data) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <!-- <td><?= $data['id_user'] ?></td> -->
                                    <td><?= $data['nama'] ?></td>
                                    <!-- <td><?= $data['no_hp'] ?></td> -->
                                    <!-- <td><?= $data['id'] ?></td> -->
                                    <td><?= $data['suite'] ?></td>
                                    <td><?= $data['check_in'] ?></td>
                                    <td><?= $data['check_out'] ?></td>
                                    <td class="currency text-end"><?= $data['harga'] ?></td>
                                    <td>
                                        <?php if ($data['status'] == '1') { ?>
                                            <span class="badge badge-warning">Belum Bayar</span>
                                        <?php } else if ($data['status'] == '2') { ?>
                                            <span class="badge badge-secondary">Belum Lunas</span>
                                        <?php } else if ($data['status'] == '3') { ?>
                                            <span class="badge badge-info">Menunggu Konfirmasi</span>
                                        <?php } else if ($data['status'] == '4') { ?>
                                            <span class="badge badge-success">Terkonfirmasi</span>
                                        <?php } else if ($data['status'] == '5') { ?>
                                            <span class="badge badge-danger">Ditolak</span>
                                        <?php } else { ?>
                                            <span class="badge badge-warning">Belum bayar</span>
                                        <?php } ?>
                                    </td>
                                    <td><?= $data['created_at'] ?></td>
                                    <!-- <td><?= $data['keluarga'] == 0 ? "" : "Keluarga"; ?></td> -->
                                </tr>
                            <?php $i++;
                            } ?>
                            <tr>
                                <!-- <td colspan="8" class="text-end">Total</td> -->
                                <td colspan="5" class="text-end">Total</td>
                                <td class="currency text-end"><?= $reservasi['total'] ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a class="btn btn-success" onclick="cetak()"><i class="material-icons">print</i> Cetak</a>
            </div>
        </div>
        <script>
            function cetak() {
                $('#laporan').printThis({
                    importCSS: true, // to import the page css
                    importStyle: true, // to import <style>css here will be imported !</style> the stylesheets (bootstrap included !)
                    loadCSS: true, // to import style="The css writed Here will be imported !"
                    canvas: true // only if you Have image/Charts ... 
                });
            }
        </script>
    </div>
</div>
<style>
    canvas {
        min-height: 350px !important;
    }
</style>
<script src="<?php echo base_url('assets/plugins/datatables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pages/datatables.js'); ?>"></script>
<script>
    $("#tabel").DataTable({
        "language": {
            "decimal": "",
            "emptyTable": "Belum ada data.",
            "info": "Menampilkan _START_ ke _END_ dari total : _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 dari 0 data",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Tampilkan _MENU_ data",
            "loadingRecords": "Mohon tunggu...",
            "processing": "Memproses...",
            "search": "Cari:",
            "zeroRecords": "Data tidak ditemukan",
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });
</script>
<?= $this->endSection() ?>