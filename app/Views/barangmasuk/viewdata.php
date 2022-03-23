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
            'onclick'   => "location.href=('" . site_url('barangmasuk/index') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <?= form_open('barangmasuk/data'); ?>
        <div class="input-group mb-3">
            <input type="text" value="<?= $cari; ?>" class="form-control" placeholder="Cari Berdasarkan Faktur"
                name="cari" autofocus="true">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari"><i
                        class="fas fa-search"></i></button>
            </div>
        </div>
        <?= form_close(); ?>

        <span class="badge badge-success">Total Data : <?= $totaldata; ?></span>
        <table class="table table-sm table-bordered table-head-fixed table-hover">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Jumlah Item</th>
                    <th>Total Harga (Rp)</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1 + (($nohalaman - 1) * 5);
                foreach ($tampildata as $row) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['faktur']; ?></td>
                    <td><?= date("d-m-Y", strtotime($row['tglfaktur'])); ?></td>
                    <td align="center">
                        <?php
                            $db = \Config\Database::connect();

                            $jumlahItem = $db->table('detail_barangmasuk')->where('detfaktur', $row['faktur'])->countAllResults();
                            ?>
                        <span style="cursor: pointer; font-weight: bold; color:blue;"
                            onclick="detailItem('<?= $row['faktur'] ?>')"><?= $jumlahItem; ?></span>
                    </td>
                    <td><?= number_format($row['totalharga'], 0, ",", "."); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-info" title="Edit Faktur"
                            onclick="edit('<?= sha1($row['faktur']) ?>')"><i class="fas fa-edit"></i></button>
                        &nbsp;

                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Faktur"
                            onclick="hapusTransaksi('<?= $row['faktur'] ?>')"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="viewmodal" style="display: none;"></div>

        <div class="float-left mt-4">
            <?= $pager->links('barangmasuk', 'paging'); ?>
        </div>


    </div>
</div>

<script>
function hapusTransaksi(faktur) {
    Swal.fire({
        title: 'Hapus Faktur?',
        text: "Yakin Anda ingin menghapus",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangmasuk/hapusTransaksi",
                data: {
                    faktur: faktur,
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        }).then((result) => {
                            window.location.reload();
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}


function edit(faktur) {
    window.location.href = ('/barangmasuk/edit/') + faktur;
}



function detailItem(faktur) {
    $.ajax({
        type: "post",
        url: "/barangmasuk/detailItem",
        data: {
            faktur: faktur
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modalitem').modal('show');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
</script>

<?= $this->endSection('isi') ?>