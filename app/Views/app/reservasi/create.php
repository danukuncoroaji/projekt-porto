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
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
            <h1>Tambah Reservasi</h1>
        </div>
        <div class="card">
            <form method="POST" action="<?= base_url('/app/reservasi/konfirmasi'); ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label for="suite" class="form-label">Suite</label>
                                <select name="suite" class="form-control">
                                    <?php foreach ($suites as $suite) { ?>
                                    <option value="<?= $suite['id']; ?>">
                                        <?= $suite['nama']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="check_out" class="form-label">Tanggal Check in</label>
                                <input type="date" class="form-control <?php if($validation->getError('check_in')){ echo 'is-invalid'; } ?>" name="check_in" id="check_in">
                                <?php if($validation->getError('check_in')){ ?>
                                    <small class="text-danger">
                                        <?php echo $validation->getError('check_in'); ?>
                                    </small>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="check_out" class="form-label">Tanggal Check out</label>
                                <input type="date" class="form-control <?php if($validation->getError('check_out')){ echo 'is-invalid'; } ?>" name="check_out" id="check_out">
                                <?php if($validation->getError('check_out')){ ?>
                                    <small class="text-danger">
                                        <?php echo $validation->getError('check_out'); ?>
                                    </small>
                                <?php } ?>
                            </div>
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