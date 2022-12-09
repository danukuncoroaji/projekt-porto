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
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            <h1>Detail Reservasi</h1>
            <span>
                <?php if ($session->get('level') == 1 && ($reservasi['status'] == '4' || $reservasi['status'] == '2')) { ?>
                <a class="btn btn-success" onclick="cetak()"><i class="material-icons">print</i> Cetak</a>
                <?php } ?>
            </span>
        </div>
        <div id="cetakdong">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <label class="mb-2">Kode</label>
                            <h5><?= $reservasi['id']; ?></h5>
                        </div>
                        <div class="col-4 col-lg-3 mb-4">
                            <label class="mb-2">Pemesan</label>
                            <h5><?= $user['nama']; ?></h5>
                        </div>
                        <div class="col-4 col-lg-3 mb-4">
                            <label class="mb-2">Suite</label>
                            <h5><?= $suite; ?></h5>
                            <input type="hidden" name="suite" value="<?= $suite_id; ?>">
                        </div>
                        <div class="col-4 col-lg-3 mb-4">
                            <label class="mb-2">Status</label>
                            <h5>
                                <?php if ($reservasi['status'] == '1') { ?>
                                    <span class="badge badge-warning">Belum Bayar</span>
                                <?php } else if ($reservasi['status'] == '2') { ?>
                                    <span class="badge badge-secondary">Belum Lunas</span>
                                <?php } else if ($reservasi['status'] == '3') { ?>
                                    <span class="badge badge-info">Menunggu Konfirmasi</span>
                                <?php } else if ($reservasi['status'] == '4') { ?>
                                    <span class="badge badge-success">Terkonfirmasi</span>
                                <?php } else if ($reservasi['status'] == '5') { ?>
                                    <span class="badge badge-danger">Ditolak</span>
                                <?php } else { ?>
                                    <span class="badge badge-warning">Belum bayar</span>
                                <?php } ?>
                            </h5>
                            <?php if ($reservasi['keluarga'] == "1") { ?>
                                <h5><span class="badge badge-secondary">Keluarga</span></h5>
                            <?php } ?>
                        </div>
                        <div class="col-12"></div>
                        <div class="col-4 col-lg-3 mb-4">
                            <label class="mb-2">Tanggal Check in</label>
                            <h5><?= $check_in; ?></h5>
                            <input type="hidden" name="check_in" value="<?= $check_in; ?>">
                        </div>
                        <div class="col-4 col-lg-3 mb-4">
                            <label class="mb-2">Tanggal Check out</label>
                            <h5><?= $check_out; ?></h5>
                            <input type="hidden" name="check_out" value="<?= $check_out; ?>">
                        </div>
                        <div class="col-4 col-lg-3 mb-4">
                            <label class="mb-2">Jangka waktu</label>
                            <h5><?= $malam; ?> Malam</h5>
                        </div>
                        <div class="col-12 mb-4">
                            <hr>
                        </div>
                        <?php if ($reservasi['status'] !== '4') { ?>
                        <div class="col-12 mb-4">
                            <label class="mb-2">Tagihan</label>
                            <h5 class="currency"><?= $reservasi['harga']; ?></h5>
                        </div>
                        <div class="col-6 col-lg-3 mb-4">
                            <label class="mb-2">Yang sudah dibayar</label>
                            <h5 class="currency"><?= $sudah; ?></h5>
                        </div>
                        <div class="col-6 col-lg-3 mb-4">
                            <label class="mb-2">Sedang menunggu konfirmasi</label>
                            <h5 class="currency"><?= $nunggu; ?></h5>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="mb-2">Total Tagihan</label>
                            <h5 class="currency"><?= $kurang; ?></h5>
                        </div>
                        <div class="col-12 mb-4">
                            <hr>
                        </div>
                        <?php } ?>
                        <div class="col-12 mb-4">
                            <label class="mb-2">Detail</label>
                            <table class="table table-striped">
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

                <?php if ($session->get('level') == 3 && $reservasi['status_pembayaran'] == 0) { ?>
                    <div class="card-footer">
                        <a href="<?= base_url('/app/pembayaran/bayar/' . $reservasi['id']); ?>" class="btn btn-primary">Bayar</a>
                        <a href="<?= base_url('/app/reservasi/delete/' . $reservasi['id']); ?>" class="btn btn-outline-danger">Batalkan</a>
                    </div>
                <?php } else if ($session->get('level') == 3 && $reservasi['status_pembayaran'] == 1) { ?>
                    <div class="card-footer">
                        <a href="<?= base_url('/app/pembayaran/bayar/' . $reservasi['id']); ?>" class="btn btn-primary">Bayar sisa tagihan</a>
                    </div>
                <?php } ?>

                </form>
            </div>
            <?php if ($reservasi['status'] > 1) { ?>
                <div class="card mt-5">
                    <div class="card-header">Riwayat pembayaran</div>
                    <div class="card-body">
                        <table class="table table-striped">
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
                                                <span class="badge badge-success">Terkonfirmasi</span>
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
</div>
<script src="<?php echo base_url('assets/plugins/datatables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pages/datatables.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js" integrity="sha512-Fd3EQng6gZYBGzHbKd52pV76dXZZravPY7lxfg01nPx5mdekqS8kX4o1NfTtWiHqQyKhEGaReSf4BrtfKc+D5w==" crossorigin="anonymous"></script>
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

    function cetak() {
        $('#cetakdong').printThis({
            importCSS: true, // to import the page css
            importStyle: true, // to import <style>css here will be imported !</style> the stylesheets (bootstrap included !)
            loadCSS: true, // to import style="The css writed Here will be imported !"
            canvas: true // only if you Have image/Charts ... 
        });
    }
</script>
<?= $this->endSection() ?>