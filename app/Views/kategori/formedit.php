<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>


<style>
.list-group-flush {
    height: 400px;
    overflow-y: auto;
}
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<div class='card'>
    <div class='card-header bg-info'>
        <div class='row'>
            <div class='col'>
                <?= form_button('', '<i class="fas fa-arrow-alt-circle-left"></i> Kembali', [
                    'class'     => 'btn btn-sm btn-warning',
                    'onclick'   => "location.href=('" . site_url('kategori/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <?=
    form_open('kategori/updatedata', '', [
        'idkategori' => $id
    ]);
    ?>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="form-group">
                    <label for="namakategori">Nama Kategori</label>
                    <?= form_input('namakategori', $nama, [
                        'class'         => 'form-control',
                        'id'            => 'namakategori',
                        'autofocus'     => true
                    ]) ?>
                    <?= session()->getFlashdata('errorNamaKategori'); ?>
                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i>
                    Simpan</button>
            </div>
        </div>
    </div>

    <?= form_close(); ?>

</div>



<?= $this->endSection('isi') ?>