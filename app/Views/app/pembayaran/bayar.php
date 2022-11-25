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
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/pembayaran'); ?>">Pembayaran</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bayar</li>
                </ol>
            </nav>
            <h1>Bayar</h1>
        </div>
        <div class="card">
            <form method="POST" action="<?= base_url('/app/pembayaran/store/'); ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="sisa" value="<?= $kurang ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="alert alert-primary alert-style-light" role="alert">
                                <h3>Rekening pembayaran</h3>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sodales, diam sit amet auctor auctor,
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="mb-2">Tagihan</label>
                            <h5 class="currency"><?= $reservasi['harga']; ?></h5>
                            <a href="<?= base_url('/app/reservasi/detail/' . $id); ?>">detail</a>
                        </div>
                        <?php if ($nstat == 1) { ?>
                            <div class="col-12 col-lg-3 mb-4">
                                <label class="mb-2">Yang sudah dibayar</label>
                                <h5 class="currency"><?= $sudah; ?></h5>
                            </div>
                            <div class="col-12 col-lg-3 mb-4">
                                <label class="mb-2">Sedang menunggu konfirmasi</label>
                                <h5 class="currency"><?= $nunggu; ?></h5>
                            </div>
                            <div class="col-12 mb-4">
                                <label class="mb-2">Total Tagihan</label>
                                <h5 class="currency"><?= $kurang; ?></h5>
                            </div>
                        <?php } ?>

                        <?php if ($nstat == 0) { ?>
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label for="status" class="form-label">Status Pembayaran</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Lunas</option>
                                    <option value="2">Dp 50%</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="jml" class="form-label">Jumlah Bayar</label>
                                <input type="text" class="form-control <?php if ($validation->getError('jml')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" name="jml" id="jml" value="<?= old('jml') ?>">
                                <?php if ($validation->getError('jml')) { ?>
                                    <small class="text-danger">
                                        <?php echo $validation->getError('jml'); ?>
                                    </small>
                                <?php } ?>
                            </div>
                            <script>
                                $("#jml").inputmask('currency', {
                                    rightAlign: false,
                                    prefix: "Rp ",
                                    allowMinus: false,
                                    radixPoint: '.',
                                    digits: 0
                                });
                            </script>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="jml" class="form-label">Bukti Pembayaran</label>
                                <input type="file" class="form-control <?php if ($validation->getError('file')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" name="file" id="file" aria-describedby="file" multiple>
                                <?php if ($validation->getError('file')) { ?>
                                    <small class="text-danger">
                                        <?php echo $validation->getError('file'); ?>
                                    </small>
                                <?php } else { ?>
                                    <div id="file" class="form-text">Sertakan gambar berbentuk jpeg, png maks 4mb.</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit">Kirim</button>
                </div>
            </form>
        </div>
        <?php if ($nstat == 1) { ?>
            <div class="card mt-4">
                <div class="card-header">Riwayat pembayaran</div>
                <div class="card-body">
                    <table id="tabel" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($pembayarans as $pembayaran) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $pembayaran['id']; ?></td>
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
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php } ?>
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