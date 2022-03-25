<table class="table table-sm table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th style="text-align: right;">
                <?php
                $totalHarga = 0;
                foreach ($tampildata->getResultArray() as $row) :
                    $totalHarga += $row['detsubtotal'];
                endforeach;
                ?>
                <h2>Total : Rp. <?= number_format($totalHarga, 0, ",", "."); ?></h2>
                <input type="hidden" id="totalharga" value="<?= $totalHarga ?>">
            </th>
        </tr>
    </thead>
</table>

<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jumlah</th>
            <th>Sub.Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['detbrgkode']; ?></td>
            <td><?= $row['brgnama']; ?></td>
            <td align="right"><?= number_format($row['dethargajual'], 0, ",", "."); ?></td>
            <td align="right"><?= number_format($row['detjml'], 0, ",", "."); ?></td>
            <td align="right"><?= number_format($row['detsubtotal'], 0, ",", "."); ?></td>
            <td align="right">
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['id'] ?>')">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function hapusItem(id) {
    Swal.fire({
        title: 'Hapus Item ?',
        text: "Yakin ingin menghapus Item ini !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangkeluar/hapusItem",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        swal.fire('Berhasil', response.sukses, 'success');
                        tampilDataTemp();
                        kosong();
                    }
                }
            });
        }
    })
}
</script>