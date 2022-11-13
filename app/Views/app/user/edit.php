<?=$this->extend('app/layout/default')?>
<?=$this->section('content')?>
<div class="row pb-5">
    <?php if(session()->getFlashdata('error')):?>
    <div class="col-12">
        <div class="alert alert-danger text-white">
            <strong>Terdapat Kesalahan !</strong>
            <?= session()->getFlashdata('error'); ?>
        </div>
    </div>
    <?php endif;?>
    <div class="col">
        <div class="page-description">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(''); ?>">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('app/user'); ?>">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $user['nama']; ?></li>
                </ol>
            </nav>
            <h1><?= $user['nama']; ?></h1>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Tambah User</h5>
            </div>
            <form method="POST" action="<?= base_url('app/user/update/'.$user['id']); ?>" id="form-tambah">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-12 mb-4">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text"
                                    class="form-control <?php if($validation->getError('nama')){ echo 'is-invalid'; } ?>"
                                    name="nama" id="nama" aria-describedby="nama" value="<?= $user['nama']; ?>">
                                <?php if($validation->getError('nama')){ ?>
                                <small class="text-danger">
                                    <?php echo $validation->getError('nama'); ?>
                                </small>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="form-label">Username</label>
                                <input type="text"
                                    class="form-control <?php if($validation->getError('username')){ echo 'is-invalid'; } ?>"
                                    name="username" id="username" aria-describedby="username" value="<?= $user['username']; ?>">
                                <?php if($validation->getError('username')){ ?>
                                <small class="text-danger">
                                    <?php echo $validation->getError('username'); ?>
                                </small>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="form-label">Level</label>
                                <select name="level" class="form-control" name="level">
                                    <option value="1" selected>Admin</option>
                                    <option value="2">Pegawai</option>
                                    <option value="3">Warga</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="form-label">Password</label>
                                <input type="password"
                                    class="form-control <?php if($validation->getError('password')){ echo 'is-invalid'; } ?>"
                                    name="password" id="password" aria-describedby="password">
                                <?php if($validation->getError('password')){ ?>
                                <small class="text-danger">
                                    <?php echo $validation->getError('password'); ?>
                                </small>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="material-icons">save</i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        CKEDITOR.replace( 'editor' );
    });
</script>
<?=$this->endSection()?>