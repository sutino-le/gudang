<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\Modelbarangmasuk;
use App\Models\Modeldetailbarangmasuk;
use App\Models\Modeltempbarangmasuk;
use CodeIgniter\Throttle\ThrottlerInterface;

class Barangmasuk extends BaseController
{
    public function index()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Faktur'
        ];
        return view('barangmasuk/forminput', $data);
    }

    function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur     = $this->request->getPost('faktur');

            $modelTemp  = new Modeltempbarangmasuk();
            $data   = [
                'judul'     => 'Home',
                'subjudul'  => 'Input Faktur',
                'datatemp'  => $modelTemp->tampilDataTemp($faktur)
            ];

            $json = [
                'data'      => view('barangmasuk/datatemp', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang     = $this->request->getPost('kodebarang');

            $modelBarang    = new Modelbarang();
            $ambilData      = $modelBarang->find($kodebarang);

            if ($ambilData == NULL) {
                $json = [
                    'error'     => 'Data barang tidak ditemukan...'
                ];
            } else {
                $data   = [
                    'judul'     => 'Home',
                    'subjudul'  => 'Input Faktur Pembelian',
                    'namabarang'    => $ambilData['brgnama'],
                    'hargajual'     => $ambilData['brgharga']
                ];

                $json = [
                    'sukses'      => $data
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, barang tidak ditemukan');
        }
    }

    function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargajual = $this->request->getPost('hargajual');
            $hargabeli = $this->request->getPost('hargabeli');
            $jumlah = $this->request->getPost('jumlah');

            $modelTempBarang = new Modeltempbarangmasuk();

            $modelTempBarang->insert([
                'detfaktur'         => $faktur,
                'detbrgkode'        => $kodebarang,
                'dethargamasuk'     => $hargabeli,
                'dethargajual'      => $hargajual,
                'detjml'            => $jumlah,
                'detsubtotal'       => intval($jumlah) * intval($hargabeli)
            ]);

            $json = [
                'sukses'    => 'Item berhasil ditambahkan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menyimpan data');
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $id     = $this->request->getPost('id');

            $modelTempBarang    = new Modeltempbarangmasuk();
            $modelTempBarang->delete($id);


            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menghapus data');
        }
    }

    function cariDataBarang()
    {
        if ($this->request->isAJAX()) {
            $json   = [
                'data'  => view('barangmasuk/modalcaribarang')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menghapus data');
        }
    }

    function detailCariBarang()
    {
        if ($this->request->isAJAX()) {
            $cari = $this->request->getPost('cari');

            $modalBarang = new Modelbarang();

            $data          = $modalBarang->tampildata_cari($cari)->get();

            if ($data != null) {
                $json   = [
                    'data'  => view('barangmasuk/detaildatabarang', [
                        'tampildata'    => $data
                    ])
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menghapus data');
        }
    }

    function selesaiTransaksi()
    {
        if ($this->request->isAJAX()) {
            $faktur     = $this->request->getPost('faktur');
            $tglfaktur  = $this->request->getPost('tglfaktur');

            $modelTemp  = new Modeltempbarangmasuk();

            $dataTemp   = $modelTemp->getWhere(['detfaktur' => $faktur]);

            if ($dataTemp->getNumRows() == 0) {
                $json = [
                    'error' => 'Maaf, data item untuk faktur ini belum ada..'
                ];
            } else {
                // exit('Maaf, gagal menghapus data');

                // Simpan ke tabel barang masuk
                $modelBarangMasuk = new Modelbarangmasuk();

                $totalSubTotal = 0;
                foreach ($dataTemp->getResultArray() as $total) :
                    $totalSubTotal += intval($total['detsubtotal']);
                endforeach;

                $modelBarangMasuk->insert([
                    'faktur'        => $faktur,
                    'tglfaktur'     => $tglfaktur,
                    'totalharga'    => $totalSubTotal
                ]);



                // simpan ke detail barang masuk
                $modelDetailBarangMasuk = new Modeldetailbarangmasuk();
                foreach ($dataTemp->getResultArray() as $rowtemp) :
                    $modelDetailBarangMasuk->insert([
                        'detfaktur'         => $rowtemp['detfaktur'],
                        'detbrgkode'        => $rowtemp['detbrgkode'],
                        'dethargamasuk'     => $rowtemp['dethargamasuk'],
                        'dethargajual'      => $rowtemp['dethargajual'],
                        'detjml'            => $rowtemp['detjml'],
                        'detsubtotal'       => $rowtemp['detsubtotal'],
                    ]);
                endforeach;

                // hapus temp barang masuk berdasarkan faktur
                $modelTemp->where(['detfaktur' => $faktur]);
                $modelTemp->delete();

                // $modelTemp->emptyTable();

                $json   = [
                    'sukses'  => 'Faktur berhasil disimpan'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menghapus data');
        }
    }

    public function data()
    {

        $tombolcari = $this->request->getPost('tombolcari');

        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_faktur', $cari);
            redirect()->to('/barangmasuk/data');
        } else {
            $cari = session()->get('cari_faktur');
        }

        $modelBarangMasuk = new Modelbarangmasuk();

        $totaldata = $cari ? $modelBarangMasuk->tampildata_cari($cari)->countAllResults() : $modelBarangMasuk->countAllResults();

        $dataBarangMasuk = $cari ? $modelBarangMasuk->tampildata_cari($cari)->paginate(10, 'barangmasuk') : $modelBarangMasuk->paginate(10, 'barangmasuk');

        $nohalaman = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;

        $data   = [
            'judul'         => 'Home',
            'subjudul'      => 'Data Barang Masuk',
            'tampildata'    => $dataBarangMasuk,
            'pager'         => $modelBarangMasuk->pager,
            'nohalaman'     => $nohalaman,
            'totaldata'     => $totaldata,
            'cari'          => $cari
        ];

        return view('barangmasuk/viewdata', $data);
    }

    function detailItem()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new Modeldetailbarangmasuk();
            $data = [
                'tampildatadetail' => $modelDetail->dataDetail($faktur)
            ];

            $json = [
                'data' => view('barangmasuk/modaldetailitem', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    function edit($faktur)
    {
        $modelBarangMasuk = new Modelbarangmasuk();
        $cekFaktur = $modelBarangMasuk->cekFaktur($faktur);

        if ($cekFaktur->getNumRows() > 0) {
            $row = $cekFaktur->getRowArray();

            $data = [
                'judul'         => 'Home',
                'subjudul'      => 'Edit Faktur',
                'nofaktur'      => $row['faktur'],
                'tanggal'       => $row['tglfaktur']
            ];
            return view('barangmasuk/formedit', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $faktur     = $this->request->getPost('faktur');

            $modelDetail  = new Modeldetailbarangmasuk();

            $data   = [
                'judul'     => 'Home',
                'subjudul'  => 'Input Faktur',
                'datadetail'  => $modelDetail->dataDetail($faktur)
            ];

            $total_HargaFaktur = number_format($modelDetail->ambilTotalHarga($faktur), 0, ",", ".");

            $json = [
                'data'      => view('barangmasuk/datadetail', $data),
                'totalharga'  => $total_HargaFaktur
            ];

            echo json_encode($json);
        }
    }

    function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');

            $modelDetail   = new Modeldetailbarangmasuk();
            $ambilData = $modelDetail->ambilDetailBerdasarkanID($iddetail);

            $row = $ambilData->getRowArray();

            $data = [
                'kodebarang' => $row['detbrgkode'],
                'namabarang' => $row['brgnama'],
                'hargajual' => $row['dethargajual'],
                'hargabeli' => $row['dethargamasuk'],
                'jumlah' => $row['detjml'],
            ];

            $json = [
                'sukses' => $data
            ];

            echo json_encode($json);
        }
    }

    function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargajual = $this->request->getPost('hargajual');
            $hargabeli = $this->request->getPost('hargabeli');
            $jumlah = $this->request->getPost('jumlah');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->insert([
                'detfaktur'         => $faktur,
                'detbrgkode'        => $kodebarang,
                'dethargamasuk'     => $hargabeli,
                'dethargajual'      => $hargajual,
                'detjml'            => $jumlah,
                'detsubtotal'       => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses'    => 'Item berhasil ditambahkan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menyimpan data');
        }
    }

    function updateItem()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargajual = $this->request->getPost('hargajual');
            $hargabeli = $this->request->getPost('hargabeli');
            $jumlah = $this->request->getPost('jumlah');
            $iddetail = $this->request->getPost('iddetail');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->update($iddetail, [
                'dethargamasuk'     => $hargabeli,
                'dethargajual'      => $hargajual,
                'detjml'            => $jumlah,
                'detsubtotal'       => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses'    => 'Item berhasil diUpdate'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menyimpan data');
        }
    }

    function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $id     = $this->request->getPost('id');
            $faktur     = $this->request->getPost('faktur');

            $modelDetail    = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->delete($id);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);


            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menghapus data');
        }
    }

    function hapusTransaksi()
    {
        $faktur = $this->request->getPost('faktur');

        $db = \Config\Database::connect();
        // $modelDetail = new Modeldetailbarangmasuk();
        $modelBarangMasuk = new Modelbarangmasuk();

        $db->table('detail_barangmasuk')->delete(['detfaktur' => $faktur]);

        // $modelDetail->where(['detfaktur' => $faktur]);
        // $modelDetail->delete();

        $modelBarangMasuk->delete($faktur);

        $json = [
            'sukses' => "Data Faktur berhasil dihapus"
        ];

        echo json_encode($json);
    }
}
