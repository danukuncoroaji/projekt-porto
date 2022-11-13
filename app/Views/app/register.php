<?=$this->extend('app/layout/login')?>
<?=$this->section('content')?>
<div class="app app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <div class="logo">
            <a href="<?php echo base_url('app/') ?>">SIPDEPO</a>
            <small>Sistem Informasi Pengaduan Desa Pojok</small>
        </div>
        <p class="auth-description">Mohon lengkapi data berikut untuk membuat akun.<br>Sudak punya akun ? <a
                href="<?php echo base_url('app/login') ?>">Masuk</a></p>

        <form method="POST" href="<?php echo base_url('app/register') ?>">
            <div class="auth-credentials m-b-xxl">
                <div class="m-b-md">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control <?php if($validation->getError('nama')){ echo "
                    is-invalid "; } ?>" id="nama" placeholder="Nama Lengkap">
                    <?php if($validation->getError('nama')){ ?>
                        <small class="text-danger">
                            <?php echo $validation->getError('nama'); ?>
                        </small>
                        <?php } ?>
                </div>
                <div class="m-b-md">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control <?php if($validation->getError('username')){ echo "
                    is-invalid "; } ?>" id="username" placeholder="Username">
                    <?php if($validation->getError('username')){ ?>
                    <small class="text-danger">
                        <?php echo $validation->getError('username'); ?>
                    </small>
                    <?php } ?>
                </div>
                <div class="m-b-md">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control <?php if($validation->getError('password')){ echo "
                    is-invalid "; } ?>" id="password" placeholder="Password">
                    <?php if($validation->getError('password')){ ?>
                        <small class="text-danger">
                            <?php echo $validation->getError('password'); ?>
                        </small>
                        <?php } ?>
                    <div class="form-text">Panjang password minimal 8 karakter</div>
                </div>
                <div class="m-b-md">
                    <label for="upassword" class="form-label">Ulangi Password</label>
                    <input type="password" name="upassword" class="form-control <?php if($validation->getError('upassword')){ echo "
                    is-invalid "; } ?>" id="upassword" placeholder="Ulangi Password">
                    <?php if($validation->getError('upassword')){ ?>
                        <small class="text-danger">
                            <?php echo $validation->getError('upassword'); ?>
                        </small>
                        <?php } ?>
                </div>
            </div>

            <div class="auth-submit">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>
    </div>
</div>
<?=$this->endSection()?>