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
                    'onclick'   => "location.href=('" . site_url('barang/index') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <?= form_open_multipart('barang/update'); ?>
    <?= session()->getFlashdata('error'); ?>
    <?= session()->getFlashdata('sukses'); ?>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="form-group row">
                    <label for="kodebarang" class="col-sm-4 col-form-label">Kode Barang</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="kodebarang" name="kodebarang" readonly
                            value="<?= $kodebarang; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namabarang" class="col-sm-4 col-form-label">Nama Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="namabarang" name="namabarang"
                            value="<?= $namabarang; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                    <div class="col-sm-4">
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($datakategori as $kat) : ?>

                            <?php if ($kat['katid'] == $kategori) : ?>

                            <option value="<?= $kat['katid'] ?>" selected><?= $kat['katnama'] ?></option>

                            <?php else : ?>

                            <option value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>

                            <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="satuan" class="col-sm-4 col-form-label">Satuan</label>
                    <div class="col-sm-4">
                        <select name="satuan" id="satuan" class="form-control">
                            <option value="">Pilih Satuan</option>
                            <?php foreach ($datasatuan as $sat) : ?>

                            <?php if ($kat['katid'] == $kategori) : ?>

                            <option value="<?= $sat['satid'] ?>" selected><?= $sat['satnama'] ?></option>

                            <?php else : ?>

                            <option value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>

                            <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="harga" class="col-sm-4 col-form-label">Harga</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="harga" name="harga" value="<?= $harga; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stok" class="col-sm-4 col-form-label">Stok</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="stok" name="stok" value="<?= $stok; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gambar" class="col-sm-4 col-form-label">Gambar yang sudah ada</label>
                    <div class="col-sm-4">
                        <img src="<?= base_url() ?>/upload/<?= $gambar ?>" class="img-thumbnail" style="width: 50%;"
                            alt="Gambar Barang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gambar" class="col-sm-4 col-form-label">Gambar (<i>jika diganti</i>)</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control-file" id="gambar" name="gambar">
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label for="gambar" class="col-sm-4 col-form-label">Upload Gambar (<i>Jika ada</i>)</label>
                    <div class="col-sm-4">
                        <input type="file" id="gambar" name="gambar">
                    </div>
                </div> -->

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