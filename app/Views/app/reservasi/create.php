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
                    <li class="breadcrumb-item"><a href="<?= base_url('/app'); ?>">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/reservasi'); ?>">Reservasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
            <h1>Tambah Reservasi</h1>
        </div>
        <div class="card">
            <form method="POST" action="<?= base_url('/app/reservasi/konfirmasi'); ?>">
                <input type="hidden" name="id" value="">
                <div class="card-body">
                    <div class="row">
                        <?php if ($session->get('level') == 1) { ?>
                            <div class="col-12 col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="customer" class="form-label">Customer</label>
                                    <select class="form-control" name="customer">
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?> - <?= $user['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="keluarga" name="keluarga">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Keluarga
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
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
                                <input type="date" class="form-control <?php if ($validation->getError('check_in')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" name="check_in" id="check_in" min='<?= date('Y-m-d') ?>' value="<?= date('Y-m-d') ?>">
                                <?php if ($validation->getError('check_in')) { ?>
                                    <small class="text-danger">
                                        <?php echo $validation->getError('check_in'); ?>
                                    </small>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="check_out" class="form-label">Tanggal Check out</label>
                                <input type="date" class="form-control <?php if ($validation->getError('check_out')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" name="check_out" id="check_out" min='<?php $datetime = new DateTime('tomorrow');
                                                                                                                    echo $datetime->format('Y-m-d'); ?>' value="<?= $datetime->format('Y-m-d') ?>">
                                <?php if ($validation->getError('check_out')) { ?>
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
        <div class="card">
            <div class="card-header">
                <h5>Ketersediaan</h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialDate: "<?= date('Y-m-d') ?>",
            editable: false,
            selectable: true,
            businessHours: true,
            dayMaxEvents: true, // allow "more" link when too many events
            events: [
                <?php
                foreach ($reservasis_1 as $reservasi) {
                    if ($reservasi['status'] != 1) {
                ?> {
                            title: "<?= $reservasi['suite_name'] ?>",
                            start: "<?= $reservasi['check_in'] ?>",
                            end: "<?= date('Y-m-d', strtotime($reservasi['check_out'] . ' +1 days')); ?>"
                        },
                <?php }
                } ?>
            ]
        });

        calendar.render();
    });
</script>
<?= $this->endSection() ?>