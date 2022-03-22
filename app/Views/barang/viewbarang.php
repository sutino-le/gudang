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
        <?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
            'class'     => 'btn btn-sm btn-primary',
            'onclick'   => "location.href=('" . site_url('barang/formtambah') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <?= session()->getFlashdata('sukses'); ?>
        <?= session()->getFlashdata('error'); ?>
        <?= ""; //form_open('barang/index'); 
        ?>
        <!-- <div class="input-group mb-3">
            <input type="text" name="cari" value="<?= ""; //$cari; 
                                                    ?>" class="form-control" placeholder="Cari data Barang"
                aria-label="Cari data Barang" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari"><i
                        class="fas fa-search"></i></button>
            </div>
        </div> -->
        <?= ""; //form_close(); 
        ?>

        <table id="example1" class="table table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $no = 1 + (($nohalaman - 1) * 5);
                $no = 1;
                foreach ($tampildata->getResultArray() as $row) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['brgkode']; ?></td>
                    <td><?= $row['brgnama']; ?></td>
                    <td><?= $row['katnama']; ?></td>
                    <td><?= $row['satnama']; ?></td>
                    <td><?= number_format($row['brgharga'], 0); ?></td>
                    <td><?= number_format($row['brgstok'], 0); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" title="Edit Data"
                            ondblclick="edit('<?= $row['brgkode'] ?>')"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" title="Hapus Data"
                            ondblclick="hapus('<?= $row['brgkode'] ?>')"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- <div class="float-center m-1">
            <?= ""; //$pager->links('barang', 'paging'); 
            ?>
        </div> -->
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
function edit(id) {
    window.location = ('/barang/formedit/' + id);
}

function hapus(id) {
    $pesan = confirm('Apakah Anda ingin menghapus data barang ?');

    if ($pesan) {
        window.location = ('/barang/hapus/' + id);
    } else {
        return false;
    }
}
</script>


<?= $this->endSection('isi') ?>