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
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/tanggal'); ?>">Tanggal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Kategori <?= $kategori['nama'] ?></li>
                </ol>
            </nav>
            <h1>Edit Kategori <?= $kategori['nama'] ?></h1>
        </div>
        <div class="card">
            <form method="POST" action="<?= base_url('/app/tanggal/kategori/update/' . $kategori['id']); ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="text" class="form-control <?php if ($validation->getError('harga')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" name="harga" id="harga" value="<?= $kategori['harga'] ?>">
                                <?php if ($validation->getError('harga')) { ?>
                                    <small class="text-danger">
                                        <?php echo $validation->getError('harga'); ?>
                                    </small>
                                <?php } ?>
                            </div>
                            <script>
                                $("#harga").inputmask('currency', {
                                    rightAlign: false,
                                    prefix: "Rp ",
                                    allowMinus: false,
                                    radixPoint: '.',
                                    digits: 0
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<?= $this->endSection() ?>