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
                    'onclick'   => "location.href=('" . site_url('barangmasuk/data') . "')"
                ]) ?>
            </div>
        </div>
    </div>
    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <table class="table table-sm table-striped table-hover" style="width: 100%;">
                    <tr>
                        <td style="width: 20%;">No. Faktur</td>
                        <td style="width: 2%;">:</td>
                        <td style="width: 28%;"><?= $nofaktur; ?></td>
                        <td rowspan="3"
                            style="vertical-align:middle; text-align:center; font-weight:bold; font-size: 25pt;"
                            id="totalHarga">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Tanggal Faktur</td>
                        <td style="width: 2%;">:</td>
                        <td style="width: 28%;"><?= date("d-m-Y", strtotime($tanggal)); ?></td>
                    </tr>
                </table>

                <input type="hidden" id="faktur" value="<?= $nofaktur ?>">

                <div class="card">
                    <div class="card-header bg-primary m-sm">
                        Edit Faktur
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">Kode Barang</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Kode Barang" name="kdbarang"
                                        id="kdbarang">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>

                                <input type="text" name="iddetail" id="iddetail">

                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Nama Barang</label>
                                <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Harga Jual</label>
                                <input type="text" class="form-control" name="hargajual" id="hargajual" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Harga Beli</label>
                                <input type="number" class="form-control" name="hargabeli" id="hargabeli">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="">Aksi</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-sm btn-info" title="Tambah Item"
                                        id="tombolTambahItem"><i class="fas fa-plus-square"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="tampilDataDetail"></div>

                    </div>
                </div>

                <div class="modalcaribarang" style="display: none;"></div>




            </li>
        </ul>

    </div>

    <div class='card-footer'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i
                        class="fa fa-save"></i>
                    Simpan Faktur</button>
            </div>
        </div>
    </div>

</div>


<script>
function dataDetail() {
    let faktur = $('#faktur').val();
    $.ajax({
        type: "post",
        url: "/barangmasuk/datadetail",
        data: {
            faktur: faktur
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('#tampilDataDetail').html(response.data);
                $('#totalHarga').html(response.totalharga);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    dataDetail();
});
</script>



<?= $this->endSection('isi') ?>