<?= $this->extend('app/layout/default') ?>
<?= $this->section('content') ?>
<link href="<?= base_url('assets/plugins/pace/pace.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/plugins/highlight/styles/github-gist.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/plugins/fullcalendar/lib/main.min.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/pages/calendar.js') ?>"></script>
<script src="<?= base_url('assets/plugins/perfectscroll/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pace/pace.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/highlight/highlight.pack.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fullcalendar/lib/main.min.js') ?>"></script>
<style>
    .fc-h-event {
        color: #ffff !important;
        background: #e74c3c !important;
        border-color: #e74c3c !important;
        padding: 4px 7px !important;
    }

    .fc-h-event .fc-event-main {
        color: #ffff !important;
    }

    .fc .fc-daygrid-event {
        margin-top: 0px !important;
        margin-bottom: 5px !important;
    }
</style>
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
                    <li class="breadcrumb-item active" aria-current="page">Reservasi</li>
                </ol>
            </nav>
            <h1>Reservasi</h1>
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
                            <th>Suite</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Kategori Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($reservasis as $reservasi) { ?>
                        <tr>
                            <td>
                                <?= $i; ?>
                            </td>
                            <td>
                                <?= $reservasi['suite_name']; ?>
                            </td>
                            <td>
                                <?= $reservasi['check_in']; ?>
                            </td>
                            <td>
                                <?= $reservasi['check_out']; ?>
                            </td>
                            <td>
                                <?php if ($reservasi['kategori_pembayaran'] == '1') { ?>
                                <span class="badge badge-secondary">Full</span>
                                <?php } else if ($reservasi['kategori_pembayaran'] == '2') { ?>
                                <span class="badge badge-secondary">DP 50%</span>
                                <?php } else { ?>
                                -
                                <?php } ?>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <a href="<?= base_url('/app/reservasi/detail/' . $reservasi['id']); ?>"
                                    class="btn btn-info btn-sm">Detail</a>

                                <?php if ($reservasi['status'] == 1) { ?>
                                <a href="<?= base_url('/app/reservasi/edit/' . $reservasi['id']); ?>"
                                    class="btn btn-warning btn-sm">Ubah</a>
                                <a href="<?= base_url('/app/pembayaran/bayar/' . $reservasi['id']); ?>"
                                    class="btn btn-primary btn-sm">Bayar</a>
                                <a href="<?= base_url('/app/reservasi/delete/' . $reservasi['id']); ?>"
                                    class="btn btn-outline-danger btn-sm">Batalkan</a>
                                <?php } else if ($reservasi['status'] == 2) { ?>
                                <a href="<?= base_url('/app/pembayaran/bayar/' . $reservasi['id']); ?>"
                                    class="btn btn-primary btn-sm">Bayar Sisa Tagihan</a>
                                <?php } else if ($reservasi['status'] == 1) { ?>
                                <a href="<?= base_url('/app/reservasi/delete/' . $reservasi['id']); ?>"
                                    class="btn btn-outline-danger btn-sm">Batalkan</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $i++;
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Suite</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Kategori Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer">
                <a class="btn btn-success" href="<?= base_url('/app/reservasi/tambah'); ?>">Tambah Reservasi</a>
            </div>
        </div>
        <?php if ($session->get('level') == 1 || $session->get('level') == 2) { ?>
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
        <?php } ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialDate: "<?= date('Y-m-d') ?>",
            editable: false,
            selectable: true,
            businessHours: true,
            dayMaxEvents: true, // allow "more" link when too many events
            events: [
                <? php
                    foreach($reservasis_1 as $reservasi) {
                    if($reservasi['status'] != 1){
                    ?>
        {
            title: "<?= $reservasi['suite_name'] ?> - <?= $reservasi['pemesan'] ?>",
            url: "<?= base_url('/app/reservasi/detail/' . $reservasi['id']); ?>",
            start: "<?= $reservasi['check_in'] ?>",
            end: "<?= date('Y-m-d',strtotime($reservasi['check_out'].' +1 days')); ?>"
        },
                <? php }} ?>
            ]
        });

    calendar.render();
    });
</script>
<?= $this->endSection() ?>