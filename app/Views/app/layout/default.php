<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Satyagraha Suites</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/perfectscroll/perfect-scrollbar.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/pace/pace.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/highlight/styles/github-gist.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/summernote/summernote-lite.min.css'); ?>" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="<?php echo base_url('assets/css/main.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/neptune.png'); ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/neptune.png'); ?>" />

    <!-- Javascripts -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/perfectscroll/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/pace/pace.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/apexcharts/apexcharts.min.js'); ?>"></script>

    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>

    <script src="<?php echo base_url('assets/js/main.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.min.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="app full-width-header align-content-stretch d-flex flex-wrap">
        <?= $this->include('app/layout/sidebar') ?>
        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                            </ul>

                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link" href="#">Aplikasi Website Villa Satyagraha Suites</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>
            </div>
        </div>
</body>
<script>
    $('.currency').each(function() {
        $(this).html(formatRupiah($(this).html(), 'Rp '));
    });




    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }
</script>

</html>