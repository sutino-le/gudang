<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<div class="card">
    <div class="card-header">
        <?= form_button('', '<i class="fa fa-plus-circle"></i> Input Faktur', [
            'class'     => 'btn btn-sm btn-primary',
            'onclick'   => "location.href=('" . site_url('barangkeluar/input') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <?= form_open('barangkeluar/data'); ?>
        <div class="input-group mb-3">
            <!-- <input type="text" value="<?= ""; //$cari; 
                                            ?>" class="form-control" placeholder="Cari Berdasarkan Faktur"
                name="cari" autofocus="true"> -->
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari"><i
                        class="fas fa-search"></i></button>
            </div>
        </div>
        <?= form_close(); ?>


    </div>
</div>


<?= $this->endSection('isi') ?>