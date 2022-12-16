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
                    <li class="breadcrumb-item active" aria-current="page">Galeri</li>
                </ol>
            </nav>
            <h1>Galeri</h1>
            <span><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#galeriModal">Tambah</button>
                <div class="modal fade" id="galeriModal" tabindex="-1" aria-labelledby="galeriModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form method="post" action="<?= base_url('app/galeri/store'); ?>" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="galeriModalLabel">Tambah Galeri</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <label for="file" class="form-label">File</label>
                                            <input type="file" class="form-control <?php if ($validation->getError('file')) {
                                                                                        echo 'is-invalid';
                                                                                    } ?>" name="file[]" id="file" aria-describedby="file" multiple>
                                            <?php if ($validation->getError('file')) { ?>
                                                <small class="text-danger">
                                                    <?php echo $validation->getError('file'); ?>
                                                </small>
                                            <?php } else { ?>
                                                <div id="file" class="form-text">Sertakan file foto berbentuk gambar jpeg,
                                                    png atau video mp4
                                                    maks 200mb.</div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="file" class="form-label">Keterangan</label>
                                            <textarea class="form-control" name="keterangan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </span>
        </div>
        <div class="row">
            <?php
            foreach ($galeris as $galeri) {
            ?>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($galeri['type'] == "video/mp4") { ?>
                                <video controls class="img-fluid">
                                    <source src="<?= base_url($galeri['path']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                            <?php } else { ?>
                                <img class="img-fluid" src="<?= base_url($galeri['path']); ?>">
                            <?php } ?>
                            <div class="alert alert-light mt-3" role="alert">
                                <?= $galeri['keterangan'] ?>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a class="btn btn-danger btn-sm" href="<?= base_url('/app/galeri/delete/' . $galeri['id']); ?>">Hapus</a>
                        </div>
                    </div>
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
<?= $this->endSection() ?>