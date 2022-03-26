<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="card">
    <div class="card-header">
        <?= form_button('', '<i class="fa fa-plus-circle"></i> Input Faktur', [
            'class'     => 'btn btn-sm btn-primary',
            'onclick'   => "location.href=('" . site_url('barangkeluar/input') . "')"
        ]) ?>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row mb-2">
            <div class="col">
                <label for="">Filter Data</label>
            </div>
            <div class="col">
                <input type="date" name="tglawal" id="tglawal" class="form-control">
            </div>
            <div class="col">
                <input type="date" name="tglakhir" id="tglakhir" class="form-control">
            </div>
            <div class="col">
                <button type="button" class="btn btn-block btn-primary" id="tombolTampil">Tampilkan</button>
            </div>
        </div>

        <table style="width: 100%;" id="databarangkeluar" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>TotalHarga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>
<script>
    function listDataBarangKeluar() {
        var table = $('#databarangkeluar').dataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/barangkeluar/listData",
                "type": "POST",
                "data": {
                    tglawal: $('#tglawal').val(),
                    tglakhir: $('#tglakhir').val(),
                }
            },
            "colomnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }, ],
        });
    }

    $(document).ready(function() {
        listDataBarangKeluar();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            listDataBarangKeluar();
        });
    });

    function cetak(faktur) {
        let windowCetak = window.open('/barangkeluar/cetakfaktur/' + faktur, "Cetak Faktur Penjualan", "width=400, height=600");

        windowCetak.focus();
    }

    function hapus(faktur) {
        Swal.fire({
            title: 'Hapus Faktur?',
            text: "Apakah ingin menghapus transaksi !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/hapusTransaksi",
                    data: {
                        faktur: faktur
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            swal.fire('Berhasil', response.sukes, 'success');
                            listDataBarangKeluar();
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
        window.location.href = ('/barangkeluar/edit/') + faktur;
    }
</script>

<?= $this->endSection('isi') ?>