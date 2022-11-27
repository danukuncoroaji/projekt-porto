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
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
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
          <li class="breadcrumb-item active" aria-current="page">Tanggal dan Harga</li>
        </ol>
      </nav>
      <h1>Tanggal dan Harga</h1>
      <span>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis viverra dapibus.<br>Maecenas
        eleifend augue convallis tellus rhoncus scelerisque. Aliquam eu nunc sit amet velit pharetra cursus, <a href="#">disini</a>.
      </span>
    </div>
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-header">
            <h5>Tambah Harga Peak Day</h5>
          </div>
          <form method="POST" action="<?= base_url('/app/tanggal/store') ?>">
            <div class="card-body">
              <div class="row">
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
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control <?php if ($validation->getError('tanggal')) {
                                                              echo 'is-invalid';
                                                            } ?>" name="tanggal" id="tanggal" min='<?= date('Y-m-d') ?>' value="<?= date('Y-m-d') ?>">
                    <?php if ($validation->getError('tanggal')) { ?>
                      <small class="text-danger">
                        <?php echo $validation->getError('tanggal'); ?>
                      </small>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                  <div class="form-group">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" class="form-control <?php if ($validation->getError('harga')) {
                                                              echo 'is-invalid';
                                                            } ?>" name="harga" id="harga" value="<?= old('harga') ?>">
                    <?php if ($validation->getError('harga')) { ?>
                      <small class="text-danger">
                        <?php echo $validation->getError('harga'); ?>
                      </small>
                    <?php } ?>
                  </div>
                  <script>
                    $("#harga").inputmask('currency', {
                      rightAlign: false,
                      prefix: "Rp ",
                      allowMinus: false,
                      radixPoint: '.',
                      digits: 0
                    });
                  </script>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button class="btn btn-success" type="submit">Simpan</button>
            </div>
          </form>
        </div>
        <div class="card">
          <div class="card-header">
            <h5>Harga Peak Day</h5>
          </div>
          <div class="card-body">
            <table id="tabel1" class="display table table-striped dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($hargas as $harga) { ?>
                  <tr>
                    <td>
                      <?= $i; ?>
                    </td>
                    <td>
                      <?= $harga['tanggal']; ?>
                    </td>
                    <td class="currency text-end">
                      <?= $harga['harga']; ?>
                    </td>
                    <td>
                      <a href="<?= base_url('/app/tanggal/edit/' . $harga['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                  </tr>
                <?php $i++;
                } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4" id="peakday">
        <div class="card">
          <div class="card-header">
            <h5>Kategori</h5>
          </div>
          <div class="card-body">
            <table id="tabel2" class="display table table-striped dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Suite</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($kategoris as $kategori) { ?>
                  <tr>
                    <td>
                      <?= $i; ?>
                    </td>
                    <td>
                      <?= $kategori['suite']; ?>
                    </td>
                    <td>
                      <?= $kategori['nama']; ?>
                    </td>
                    <td class="currency text-end">
                      <?= $kategori['harga']; ?>
                    </td>
                    <td>
                      <a href="<?= base_url('/app/tanggal/kategori/edit/' . $kategori['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                  </tr>
                <?php $i++;
                } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Suite</th>
                  <th>Harga</th>
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
            <h5>Kalender Peak Day</h5>
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
  $("#tabel1").DataTable({
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
      },
      "responsive": true
    }
  });

  $("#tabel2").DataTable({
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
      },
      "responsive": true
    }
  });

  new $.fn.dataTable.FixedHeader(table);
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
        foreach ($hargas as $harga) { ?> {
            eventClassNames : "currency",
            title: "<?= $harga['suite'] ?> - Rp <?= number_format((float)$harga['harga'],0);?>",
            start: "<?= $harga['tanggal'] ?>",

          },
        <?php } ?>
      ]
    });

    calendar.render();
  });
</script>
<?= $this->endSection() ?>