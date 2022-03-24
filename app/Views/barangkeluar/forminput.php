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
                    'onclick'   => "location.href=('" . site_url('barangkeluar/data') . "')"
                ]) ?>
            </div>
        </div>
    </div>

    <div class="body">

        <ul class='list-group list-group-flush'>
            <li class='list-group-item'>

                <div class="row">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">No. Faktur</label>
                            <input type="text" name="nofaktur" id="nofaktur" value="<?= $nofaktur ?>"
                                class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Tgl. Faktur</label>
                            <input type="date" name="tglfaktur" id="tglfaktur" class="form-control"
                                value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Cari Pelanggan</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Pelanggan"
                                    name="namapelanggan" readonly id="namapelanggan" readonly>
                                <input type="hidden" name="idpelanggan" id="idpelanggan">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariPelanggan"
                                        title="Cari Pelanggan"><i class="fas fa-search"></i></button>
                                    <button class="btn btn-outline-success" type="button" id="tombolTambahPelanggan"
                                        title="Tambah Pelanggan"><i class="fas fa-plus-square"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kode Barang</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang"
                                    id="kodebarang">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Harga Jual (Rp)</label>
                            <input type="text" class="form-control" name="hargajual" id="hargajual" readonly>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" class="form-control" name="jml" id="jml" value="1">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">#</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-success" title="Simpan Item" id="tombolSimpanItem">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </li>
        </ul>

    </div>

    <div class='card-footer'>
        <div class='row'>
            <div class='col text-right'>
                <button type="submit" class="btn btn-sm btn-success" id="tombolSelesaiTransaksi"><i
                        class="fa fa-save"></i>
                    Selesaikan Faktur</button>
            </div>
        </div>
    </div>

</div>

<div class="viewmodal" style="display: none;"></div>

<script>
function buatNoFaktur() {
    let tanggal = $('#tglfaktur').val();

    $.ajax({
        type: "post",
        url: "/barangkeluar/buatNoFaktur",
        data: {
            tanggal: tanggal
        },
        dataType: "json",
        success: function(response) {
            $('#nofaktur').val(response.nofaktur);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });

}

$(document).ready(function() {
    $('#tglfaktur').change(function(e) {
        buatNoFaktur();
    });

    $('#tombolTambahPelanggan').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/pelanggan/formtambah",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambahpelanggan').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });



    $('#tombolCariPelanggan').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/pelanggan/modalData",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldatapelanggan').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
});
</script>

<?= $this->endsection('isi') ?>