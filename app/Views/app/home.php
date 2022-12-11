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
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js" integrity="sha512-Fd3EQng6gZYBGzHbKd52pV76dXZZravPY7lxfg01nPx5mdekqS8kX4o1NfTtWiHqQyKhEGaReSf4BrtfKc+D5w==" crossorigin="anonymous"></script>
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
<?php if ($session->get('level') == 1 || $session->get('level') == 2) { ?>
    <div class="row pb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
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
                            foreach ($reservasis_all as $reservasi) {
                                if ($reservasi['status'] != 1) {
                            ?> {
                                        title: "<?= $reservasi['suite_name'] ?> - <?= $reservasi['pemesan'] ?>",
                                        url: "<?= base_url('/app/reservasi/detail/' . $reservasi['id']); ?>",
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
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Pendapatan</h5>
                </div>
                <div class="card-body">
                    <canvas id="chart_pendapatan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Pengunjung</h5>
                </div>
                <div class="card-body">
                    <canvas id="chart_pengunjung"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Reservasi hari ini</h5>
                </div>
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
                                        <a href="<?= base_url('/app/reservasi/detail/' . $reservasi['id']); ?>" class="btn btn-info btn-sm">Detail</a>

                                        <?php if ($reservasi['status'] == 1) { ?>
                                            <a href="<?= base_url('/app/reservasi/edit/' . $reservasi['id']); ?>" class="btn btn-warning btn-sm">Ubah</a>
                                            <a href="<?= base_url('/app/pembayaran/bayar/' . $reservasi['id']); ?>" class="btn btn-primary btn-sm">Bayar</a>
                                            <a href="<?= base_url('/app/reservasi/delete/' . $reservasi['id']); ?>" class="btn btn-outline-danger btn-sm">Batalkan</a>
                                        <?php } else if ($reservasi['status'] == 2) { ?>
                                            <a href="<?= base_url('/app/pembayaran/bayar/' . $reservasi['id']); ?>" class="btn btn-primary btn-sm">Bayar Sisa Tagihan</a>
                                        <?php } else if ($reservasi['status'] == 1) { ?>
                                            <a href="<?= base_url('/app/reservasi/delete/' . $reservasi['id']); ?>" class="btn btn-outline-danger btn-sm">Batalkan</a>
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
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Laporan</h5>
                </div>
                <div class="card-body">
                    <table class="table" id="laporan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer id</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>No Invoice</th>
                                <th>Suites</th>
                                <th>Tanggal Check in</th>
                                <th>Tanggal Check out</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Tanggal Transaksi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($laporans as $reservasi) { ?>
                                <tr>
                                    <td colspan="12" class="bg-secondary text-center"><?= $reservasi['bulan'] ?></td>
                                </tr>
                                <?php foreach ($reservasi['data'] as $data) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $data['id_user'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['no_hp'] ?></td>
                                        <td><?= $data['id'] ?></td>
                                        <td><?= $data['suite'] ?></td>
                                        <td><?= $data['check_in'] ?></td>
                                        <td><?= $data['check_out'] ?></td>
                                        <td class="currency text-end"><?= $data['harga'] ?></td>
                                        <td>
                                            <?php if ($data['status'] == '1') { ?>
                                                <span class="badge badge-warning">Belum Bayar</span>
                                            <?php } else if ($data['status'] == '2') { ?>
                                                <span class="badge badge-secondary">Belum Lunas</span>
                                            <?php } else if ($data['status'] == '3') { ?>
                                                <span class="badge badge-info">Menunggu Konfirmasi</span>
                                            <?php } else if ($data['status'] == '4') { ?>
                                                <span class="badge badge-success">Terkonfirmasi</span>
                                            <?php } else if ($data['status'] == '5') { ?>
                                                <span class="badge badge-danger">Ditolak</span>
                                            <?php } else { ?>
                                                <span class="badge badge-warning">Belum bayar</span>
                                            <?php } ?>
                                        </td>
                                        <td><?= $data['created_at'] ?></td>
                                        <td><?= $data['keluarga'] == 0 ? "" : "Keluarga"; ?></td>
                                    </tr>
                                <?php $i++;
                                } ?>
                                <tr>
                                    <td colspan="8" class="text-end">Total</td>
                                    <td class="currency text-end"><?= $reservasi['total'] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a class="btn btn-success" onclick="cetak()"><i class="material-icons">print</i> Cetak</a>
                </div>
            </div>
            <script>
                function cetak() {
                    $('#laporan').printThis({
                        importCSS: true, // to import the page css
                        importStyle: true, // to import <style>css here will be imported !</style> the stylesheets (bootstrap included !)
                        loadCSS: true, // to import style="The css writed Here will be imported !"
                        canvas: true // only if you Have image/Charts ... 
                    });
                }
            </script>
        </div>
    </div>
    <style>
        canvas {
            min-height: 350px !important;
        }
    </style>
    <script>
        const ctx_pendapatan = document.getElementById('chart_pendapatan').getContext('2d');
        const pendapatan = new Chart(ctx_pendapatan, {
            type: 'bar',
            data: <?= $grafik_pendapatan ?>,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return tooltipItems.yLabel + ' €';
                        }
                    }
                },
            }
        });

        const ctx_pengunjung = document.getElementById('chart_pengunjung').getContext('2d');
        const pengunjung = new Chart(ctx_pengunjung, {
            type: 'bar',
            data: {
                "labels": ["1 Nov", "2 Nov", "3 Nov", "4 Nov", "5 Nov", "6 Nov", "7 Nov", "8 Nov", "9 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov", "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov", "22 Nov", "23 Nov", "24 Nov", "25 Nov", "26 Nov", "27 Nov", "28 Nov", "29 Nov", "30 Nov"],
                "datasets": [{
                    "label": "Orang",
                    "type": "bar",
                    "data": [0, 0, 1, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    "backgroundColor": "rgba(52, 152, 219,1.0)"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return tooltipItems.yLabel + ' €';
                        }
                    }
                },
            }
        });
    </script>
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
<?php } ?>
<?= $this->endSection() ?>