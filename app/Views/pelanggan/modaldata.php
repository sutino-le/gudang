 <!-- DataTables -->
 <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
 <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
 <script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

 <div class="modal fade" id="modaldatapelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Data Pelanggan Pelanggan</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">

                 <table style="width: 100%;" id="datapelanggan"
                     class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
                     <thead>
                         <tr>
                             <th>No</th>
                             <th>Nama Pelanggan</th>
                             <th>Telp.</th>
                             <th>Alamat</th>
                             <th>Aksi</th>
                         </tr>
                     </thead>
                     <tbody>

                     </tbody>
                 </table>

             </div>
         </div>
     </div>
 </div>

 <script>
function listDataPelanggan() {
    var table = $('#datapelanggan').dataTable({
        destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "/pelanggan/listData",
            "type": "POST",
        },
        "colomnDefs": [{
            "targets": [0, 4],
            "orderable": false,
        }, ],
    });
}

function pilih(id, nama) {
    $('#namapelanggan').val(nama);
    $('#idpelanggan').val(id);

    $('#modaldatapelanggan').modal('hide');
}

function hapus(id, nama) {
    Swal.fire({
        title: 'Hapus Pelanggan?',
        text: "Yakin ingin menghapus ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus !'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/pelanggan/hapus",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            text: response.sukses
                        });

                        listDataPelanggan();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}

$(document).ready(function() {
    listDataPelanggan();
});
 </script>