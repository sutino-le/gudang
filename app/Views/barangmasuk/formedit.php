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

                                <input type="hidden" name="iddetail" id="iddetail">

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
                                    &nbsp;
                                    <button style="display: none;" type="button" class="btn btn-sm btn-primary"
                                        title="Edit Item" id="tombolEditItem"><i class="fas fa-edit"></i></button>
                                    &nbsp;
                                    <button style="display: none;" type="button" class="btn btn-sm btn-secondary"
                                        title="Reload" id="tombolReload"><i class="fas fa-sync-alt"></i></button>
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
                <?= form_button('', '<i class="fas fa-save"></i> Selesai', [
                    'class'     => 'btn btn-sm btn-success',
                    'onclick'   => "location.href=('" . site_url('barangmasuk/data') . "')"
                ]) ?>
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


function kosong() {
    $('#kdbarang').val('');
    $('#namabarang').val('');
    $('#hargajual').val('');
    $('#hargabeli').val('');
    $('#jumlah').val('');
    $('#kdbarang').focus();
}

function ambilDataBarang() {
    let kodebarang = $('#kdbarang').val();

    $.ajax({
        type: "post",
        url: "/barangmasuk/ambilDataBarang",
        data: {
            kodebarang: kodebarang
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;
                $('#namabarang').val(data.namabarang);
                $('#hargajual').val(data.hargajual);

                $('#hargabeli').focus();
            }

            if (response.error) {
                alert(response.error);
                kosong();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    dataDetail();

    $('#tombolReload').click(function(e) {
        e.preventDefault();
        $('#iddetail').val('');
        $(this).hide();
        $('#tombolEditItem').hide();
        $('#tombolTambahItem').fadeIn();
        kosong();
    })


    $('#tombolTambahItem').click(function(e) {
        e.preventDefault();
        let faktur = $('#faktur').val();
        let kodebarang = $('#kdbarang').val();
        let hargajual = $('#hargajual').val();
        let hargabeli = $('#hargabeli').val();
        let jumlah = $('#jumlah').val();

        if (faktur.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maaf, Nomor Faktur tidak boleh kosong'
            })
        } else if (kodebarang.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maaf, Kode barang tidak boleh kosong'
            })
        } else if (hargabeli.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maaf, Harap masukan harga beli...!!!'
            })
        } else if (jumlah.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maaf, Harap masukan jumlah barang...!!!'
            })
        } else {
            $.ajax({
                type: "post",
                url: "/barangmasuk/simpanDetail",
                data: {
                    faktur: faktur,
                    kodebarang: kodebarang,
                    hargajual: hargajual,
                    hargabeli: hargabeli,
                    jumlah: jumlah
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        alert(response.sukses);
                        kosong();
                        dataDetail();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    });


    $('#tombolEditItem').click(function(e) {
        e.preventDefault();
        let faktur = $('#faktur').val();
        let kodebarang = $('#kdbarang').val();
        let hargajual = $('#hargajual').val();
        let hargabeli = $('#hargabeli').val();
        let jumlah = $('#jumlah').val();
        $.ajax({
            type: "post",
            url: "/barangmasuk/updateItem",
            data: {
                iddetail: $('#iddetail').val(),
                faktur: faktur,
                kodebarang: kodebarang,
                hargajual: hargajual,
                hargabeli: hargabeli,
                jumlah: jumlah
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    alert(response.sukses);
                    kosong();
                    dataDetail();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolCariBarang').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/barangmasuk/cariDataBarang",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalcaribarang').html(response.data).show();
                    $('#modalcaribarang').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

});
</script>



<?= $this->endSection('isi') ?>