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
                    <li class="breadcrumb-item active" aria-current="page">Customer</li>
                </ol>
            </nav>
            <h1>Customer</h1>
            <span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis viverra dapibus.<br>Maecenas
                eleifend augue convallis tellus rhoncus scelerisque. Aliquam eu nunc sit amet velit pharetra cursus, <a
                    href="#">disini</a>.
            </span>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="tabel" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No Hp</th>
                            <th>Jumlah Reservasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor</td>
                            <td>081234124645</td>
                            <td>1x</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                            <td>
                                <a href="<?= base_url('app/customer/detail/1'); ?>"
                                    class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Lorem ipsum dolor</td>
                            <td>081234124645</td>
                            <td>1x</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                            <td>
                                <a href="<?= base_url('app/customer/detail/1'); ?>"
                                    class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Lorem ipsum dolor</td>
                            <td>081234124645</td>
                            <td>4x</td>
                            <td><span class="badge badge-success">Aktif</span></td>
                            <td>
                                <a href="<?= base_url('app/customer/detail/1'); ?>"
                                    class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        <tr>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th>No</th>
                            <th>Nama</th>
                            <th>No Hp</th>
                            <th>Jumlah Reservasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
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