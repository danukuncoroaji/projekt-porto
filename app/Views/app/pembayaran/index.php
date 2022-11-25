<?= $this->extend('app/layout/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="col-12">
            <div class="alert alert-danger text-white">
                <strong>Terdapat Kesalahan !</strong>
                <?= session()->getFlashdata('error'); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="col-12">
            <div class="alert alert-success text-white">
                <i class="fas fa-check"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col">
        <div class="page-description">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(''); ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                </ol>
            </nav>
            <h1>Pembayaran</h1>
            <span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis viverra dapibus.<br>Maecenas
                eleifend augue convallis tellus rhoncus scelerisque. Aliquam eu nunc sit amet velit pharetra cursus, <a href="#">disini</a>.
            </span>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="tabel" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Reservasi</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($pembayarans as $pembayaran) { ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $pembayaran['id']; ?></td>
                                <td><a href="<?= base_url('/app/reservasi/detail/' . $pembayaran['id_reservasi']); ?>">detail</a></td>
                                <td>
                                    <?php if ($pembayaran['kategori'] == '1') { ?>
                                        <span class="badge badge-secondary">Full</span>
                                    <?php } else if ($pembayaran['kategori'] == '2') { ?>
                                        <span class="badge badge-secondary">DP 50%</span>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                                <td class="currency"><?= $pembayaran['jumlah']; ?></td>
                                <td><?= $pembayaran['created_at']; ?></td>
                                <td>
                                    <?php if ($pembayaran['status'] == '1') { ?>
                                        <span class="badge badge-info">Menunggu Konfirmasi</span>
                                    <?php } else if ($pembayaran['status'] == '2') { ?>
                                        <span class="badge badge-success">Lunas</span>
                                    <?php } else if ($pembayaran['status'] == '3') { ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('/app/pembayaran/detail/'.$pembayaran['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                                    <?php if (($session->get('level') == 1 || $session->get('level') == 2) && $pembayaran['status'] == '1') { ?>
                                        <a href="<?= base_url('/app/pembayaran/konfirmasi/'.$pembayaran['id']); ?>" class="btn btn-success btn-sm">Konfirmasi</a>
                                        <a href="<?= base_url('/app/pembayaran/tolak/'.$pembayaran['id']); ?>" class="btn btn-danger btn-sm">Tolak</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php $i++;
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Reservasi</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
<?= $this->endSection() ?>