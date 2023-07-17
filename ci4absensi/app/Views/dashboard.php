<?= $this->extend("layouts/master_app") ?>

<?= $this->section("content") ?>
<section class="content">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-headset"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Admin</span>
                    <span class="info-box-number"><?= $a->a; ?>

                    </span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Karyawan</span>
                    <span class="info-box-number"><?= $k->k; ?></span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fad fa-users-class"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Absensi Masuk</span>
                    <span class="info-box-number"><?= $tm->tm; ?></span>
                </div>

            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fad fa-users-class"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Absensi Keluar</span>
                    <span class="info-box-number"><?= $tk->tk; ?></span>
                </div>

            </div>
        </div>


    </div>

</section>
<?= $this->endSection() ?>
