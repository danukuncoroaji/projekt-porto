<?=$this->extend('app/layout/default')?>
<?=$this->section('content')?>
<?php if($session->get('level') == 1 || $session->get('level') == 2){ ?>
<div class="row pb-5">
    <div class="col-12">
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
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5>Reservasi hari ini</h5>
            </div>
            <div class="card-body">
            </div>
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
            data: { "labels": ["1 Nov", "2 Nov", "3 Nov", "4 Nov", "5 Nov", "6 Nov", "7 Nov", "8 Nov", "9 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov", "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov", "22 Nov", "23 Nov", "24 Nov", "25 Nov", "26 Nov", "27 Nov", "28 Nov", "29 Nov", "30 Nov"], "datasets": [{ "label": "Orang", "type": "bar", "data": [0, 0, 1, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], "backgroundColor": "rgba(52, 152, 219,1.0)" }] },
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
                        label: function (tooltipItems, data) {
                            return tooltipItems.yLabel + ' €';
                        }
                    }
                },
            }
        });

        const ctx_pengunjung = document.getElementById('chart_pengunjung').getContext('2d');
        const pengunjung = new Chart(ctx_pengunjung, {
            type: 'bar',
            data: { "labels": ["1 Nov", "2 Nov", "3 Nov", "4 Nov", "5 Nov", "6 Nov", "7 Nov", "8 Nov", "9 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov", "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov", "22 Nov", "23 Nov", "24 Nov", "25 Nov", "26 Nov", "27 Nov", "28 Nov", "29 Nov", "30 Nov"], "datasets": [{ "label": "Orang", "type": "bar", "data": [0, 0, 1, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], "backgroundColor": "rgba(52, 152, 219,1.0)" }] },
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
                        label: function (tooltipItems, data) {
                            return tooltipItems.yLabel + ' €';
                        }
                    }
                },
            }
        });
    </script>
</div>
<?php } ?>
<?=$this->endSection()?>