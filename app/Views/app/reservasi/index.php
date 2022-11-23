<?=$this->extend('app/layout/default')?>
<?=$this->section('content')?>
<div class="row">
    <?php if(session()->getFlashdata('error')):?>
    <div class="col-12">
        <div class="alert alert-danger text-white">
            <strong>Terdapat Kesalahan !</strong>
            <?= session()->getFlashdata('error'); ?>
        </div>
    </div>
    <?php endif;?>
    <?php if(session()->getFlashdata('success')):?>
    <div class="col-12">
        <div class="alert alert-success text-white">
            <i class="fas fa-check"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    </div>
    <?php endif;?>
    <div class="col">
        <div class="page-description">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(''); ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reservasi</li>
                </ol>
            </nav>
            <h1>Reservasi</h1>
            <span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis viverra dapibus.<br>Maecenas
                eleifend augue convallis tellus rhoncus scelerisque. Aliquam eu nunc sit amet velit pharetra cursus, <a
                    href="#">disini</a>.
            </span>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="tabel" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Suite</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($reservasis as $reservasi){ ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $reservasi['suite_name']; ?></td>
                            <td><?= $reservasi['check_in']; ?></td>
                            <td><?= $reservasi['check_out']; ?></td>
                            <td><?= $reservasi['created_at']; ?></td>
                            <td>
                                <a href="<?= base_url('/app/reservasi/detail/'.$reservasi['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                                <?php if ($session->get('level') == 3) { ?>
                                    <a href="<?= base_url('/app/reservasi/edit/'.$reservasi['id']); ?>" class="btn btn-warning btn-sm">Ubah</a>
                                    <?php if ($reservasi['status'] == 3) { ?>
                                        <a href="<?= base_url('/app/pembayaran/bayar/'.$reservasi['id']); ?>" class="btn btn-primary btn-sm">Bayar</a>
                                        <a href="<?= base_url('/app/reservasi/delete/'.$reservasi['id']); ?>" class="btn btn-danger btn-sm">Batalkan</a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th>No</th>
                            <th>Nama</th>
                            <th>Suite</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php if ($session->get('level') == 3) { ?>
            <div class="card-footer">
                <a class="btn btn-success" href="<?= base_url('/app/reservasi/tambah'); ?>">Tambah Reservasi</a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
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
<?=$this->endSection()?>