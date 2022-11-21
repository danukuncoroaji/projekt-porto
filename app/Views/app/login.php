<?= $this->extend('app/layout/login') ?>
<?= $this->section('content') ?>
<style>
    .app-auth-sign-in .app-auth-background {
        background: url('<?= base_url('/assets/images/background-login.jpg') ?>') no-repeat;
        background-size: cover;
    background-position: center;
    }
</style>
<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <div class="logo">
            <a href="<?php echo base_url('app/') ?>">Satyagraha Suites</a>
            <small>Aplikasi Website Villa Satyagraha Suites</small>
        </div>
        <p class="auth-description">Silahkan login untuk mengakses aplikasi.<br>Tidak punya akun ? <a href="<?php echo base_url('app/register') ?>">Daftar</a></p>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger text-white">
                <i class="fas fa-exclamation"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success text-white">
                <i class="fas fa-exclamation"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php base_url('app/login'); ?>">
            <div class="auth-credentials m-b-xxl">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control m-b-md <?php if ($validation->getError('username')) {
                                                                    echo "
                    is-invalid ";
                                                                } ?>" id="username" name="username">
                <?php if ($validation->getError('username')) { ?>
                    <small class="text-danger">
                        <?php echo $validation->getError('username'); ?>
                    </small>
                <?php } ?>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?php if ($validation->getError('password')) {
                                                                echo "
                    is-invalid ";
                                                            } ?>" id="password" name="password">
                <?php if ($validation->getError('password')) { ?>
                    <small class="text-danger">
                        <?php echo $validation->getError('password'); ?>
                    </small>
                <?php } ?>
            </div>
            <div class="auth-submit">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>