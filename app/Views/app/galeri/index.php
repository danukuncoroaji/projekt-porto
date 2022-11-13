<?=$this->extend('app/layout/default')?>
<?=$this->section('content')?>
<div class="row">
    <?php if(session()->getFlashdata('error')):?>
    <div class="col-12">
        <div class="alert alert-danger text-white">
            <strong>Terdapat Kesalahan !</strong>
            <?= session()->getFlashdata('error'); ?>
        </div>
    </div>
    <?php endif;?>
    <?php if(session()->getFlashdata('success')):?>
    <div class="col-12">
        <div class="alert alert-success text-white">
            <i class="fas fa-check"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    </div>
    <?php endif;?>
    <div class="col">
        <div class="page-description">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(''); ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Galeri</li>
                </ol>
            </nav>
            <h1>Galeri</h1>
            <span><a class ="btn btn-success" href="#">Tambah</a>
            </span>
        </div>
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="https://loremflickr.com/640/360">
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="https://loremflickr.com/640/360">
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="https://loremflickr.com/640/360">
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="https://loremflickr.com/640/360">
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="https://loremflickr.com/640/360">
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-danger btn-sm">Hapus</a>
                    </div>
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
<?=$this->endSection()?>