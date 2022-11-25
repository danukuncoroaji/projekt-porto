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
                    <li class="breadcrumb-item active" aria-current="page">Detail <?= $pembayaran['id']; ?></li>
                </ol>
            </nav>
            <h1>Detail <?= $pembayaran['id']; ?></h1>
        </div>
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="mb-2">Tagihan</label>
                            <h5 class="currency"><?= $pembayaran['jumlah']; ?></h5>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="mb-2">Tanggal</label>
                            <h5><?= $pembayaran['created_at']; ?></h5>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                        <label class="mb-2">Bukti pembayaran</label>
                            <img class="img-fluid" src="<?= base_url($pembayaran['bukti']); ?>">
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
</div>
<?= $this->endSection() ?>