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
                    <li class="breadcrumb-item"><a href="<?= base_url('/app'); ?>">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/reservasi'); ?>">Reservasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Konfirmasi</li>
                </ol>
            </nav>
            <h1>Konfirmasi Reservasi</h1>
        </div>
        <div class="card">
            <form method="POST" action="<?= base_url('/app/reservasi/store'); ?>">
            <input type="hidden" name="id_r" value="<?= $id; ?>">
            <input type="hidden" name="id_u" value="<?= $id_u; ?>">
            <input type="hidden" name="keluarga" value="<?= $keluarga; ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="mb-2">Suite</label>
                            <h5><?= $suite; ?></h5>
                            <input type="hidden" name="suite" value="<?= $suite_id; ?>">
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <label class="mb-2">Tanggal Check in</label>
                            <h5><?= $check_in; ?></h5>
                            <input type="hidden" name="check_in" value="<?= $check_in; ?>">
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <label class="mb-2">Tanggal Check out</label>
                            <h5><?= $check_out; ?></h5>
                            <input type="hidden" name="check_out" value="<?= $check_out; ?>">
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <label class="mb-2">Jangka waktu</label>
                            <h5><?= $malam; ?> Malam</h5>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="mb-2">Detail</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Tanggal</td>
                                        <td>Ket</td>
                                        <td class="text-end">Harga</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($datas as $data) { ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $data[0]; ?></td>
                                            <td><?= $data[2]; ?></td>
                                            <td class="currency text-end"><?= $data[1]; ?></td>
                                            
                                        </tr>
                                    <?php
                                        $i++;
                                    } ?>
                                    <tr>
                                        <td></td>
                                        <td>Total</td>
                                        <td></td>
                                        <td class="currency text-end"><?= $total; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="total" value="<?= $total; ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit">Selanjutnya</button>
                </div>
            </form>
        </div>
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