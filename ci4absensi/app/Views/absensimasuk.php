<?= $this->extend("layouts/master_app") ?>

<?= $this->section("content") ?>
<!-- Main content -->

<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h4 class="box-title text-capitalize">Data absensi masuk</h4>
      <!-- <button type="button" class="btn float-end btn-primary btn-sm" onclick="save()" title="<?= lang("App.new") ?>"> <?= lang('App.new') ?></button> -->
    </div>
    <div class="box-body">
      <table id="data_table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Qr code</th>
            <th>Waktu</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>

<!-- /Main content -->

<?= $this->endSection() ?>
<!-- page script -->
<?= $this->section("script") ?>
<script>
  let csrfHash = '<?= csrf_hash(); ?>'
  let csrfToken = '<?= csrf_token(); ?>'
  // dataTables
  $(function() {
    var table = $('#data_table').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollY": '30vh',
      "scrollX": true,
      "scrollCollapse": false,
      "responsive": false,
      "ajax": {
        "url": '<?php echo base_url($controller . "/getAll") ?>',
        "type": "POST",
        "dataType": "json",
        async: "true"
      }
    });
  });
</script>


<?= $this->endSection() ?>