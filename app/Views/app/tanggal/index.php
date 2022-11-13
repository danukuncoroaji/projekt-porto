<?=$this->extend('app/layout/default')?>
<?=$this->section('content')?>
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
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
                    <li class="breadcrumb-item active" aria-current="page">Tanggal dan Harga</li>
                </ol>
            </nav>
            <h1>Tanggal dan Harga</h1>
            <span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis viverra dapibus.<br>Maecenas
                eleifend augue convallis tellus rhoncus scelerisque. Aliquam eu nunc sit amet velit pharetra cursus, <a
                    href="#">disini</a>.
            </span>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="calendar" style="height: 800px"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
<script>
    const Calendar = tui.Calendar;
    const calendar = new Calendar('#calendar', {
  defaultView: 'week',
  template: {
    time(event) {
      const { start, end, title } = event;

      return `<span style="color: white;">${formatTime(start)}~${formatTime(end)} ${title}</span>`;
    },
    allday(event) {
      return `<span style="color: gray;">${event.title}</span>`;
    },
  },
  calendars: [
    {
      id: 'cal1',
      name: 'Personal',
      backgroundColor: '#03bd9e',
    },
    {
      id: 'cal2',
      name: 'Work',
      backgroundColor: '#00a9ff',
    },
  ],
});
    </script>
<?=$this->endSection()?>