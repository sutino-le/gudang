<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\ModelBarangKeluar;
use App\Models\ModelDatabarang;
use App\Models\ModelDataBarangKeluar;
use App\Models\ModelDetailBarangKeluar;
use App\Models\ModelPelanggan;
use App\Models\ModelTempBarangKeluar;
use Config\Services;

class Barangkeluar extends BaseController
{
    private function buatFaktur()
    {
        $tanggalSekarang = date("Y-m-d");
        $modelBarangKeluar = new ModelBarangKeluar();

        $hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }

    public function buatNoFaktur()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $modelBarangKeluar = new ModelBarangKeluar();

        $hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);


        $json = [
            'nofaktur' => $noFaktur
        ];

        echo json_encode($json);
    }

    public function data()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Data Barang Keluar'
        ];
        return view('barangkeluar/viewdata', $data);
    }

    public function input()
    {
        $data   = [
            'judul'     => 'Home',
            'subjudul'  => 'Input Faktur Penjualan',
            'nofaktur'  => $this->buatFaktur()
        ];
        return view('barangkeluar/forminput', $data);
    }

    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modalTempBarangKeluar = new ModelTempBarangKeluar();
            $dataTemp = $modalTempBarangKeluar->tampilDataTemp($nofaktur);

            $data = [
                'tampildata' => $dataTemp
            ];

            $json = [
                'data' => view('barangkeluar/datatemp', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang    = new Modelbarang();
            $cekData        = $modelBarang->find($kodebarang);

            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf, Data barang tidak ditemukan'
                ];
            } else {
                $data = [
                    'namabarang' => $cekData['brgnama'],
                    'hargajual'  => $cekData['brgharga']
                ];

                $json = [
                    'sukses' => $data
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = $this->request->getPost('hargajual');
            $jml = $this->request->getPost('jml');

            $modalTempBarangKeluar = new ModelTempBarangKeluar();
            $modelBarang = new Modelbarang();

            $ambilDataBarang = $modelBarang->find($kodebarang);

            $stokBarang = $ambilDataBarang['brgstok'];

            if ($jml > intval($stokBarang)) {
                $json = [
                    'error' => 'Maaf, Stok tidak mencukupi'
                ];
            } else {
                $modalTempBarangKeluar->insert([
                    'detfaktur'     => $nofaktur,
                    'detbrgkode'    => $kodebarang,
                    'dethargajual'  => $hargajual,
                    'detjml'        => $jml,
                    'detsubtotal'   => intval($jml) * intval($hargajual)
                ]);

                $json = [
                    'sukses' => 'Item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelTempBarangKeluar->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }


    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data'  => view('barangkeluar/modalcaribarang')
            ];

            echo json_encode($json);
        }
    }

    public function listDataBarang()
    {
        $request = Services::request();
        $datamodel = new ModelDatabarang($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgkode . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";

                $row[] = $no;
                $row[] = $list->brgkode;
                $row[] = $list->brgnama;
                $row[] = number_format($list->brgharga, 0, ",", ".");
                $row[] = number_format($list->brgstok, 0, ",", ".");
                $row[] = $tombolPilih;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    function modalPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $totalharga = $this->request->getPost('totalharga');

            $modelTemp = new ModelTempBarangKeluar();

            $cekdata = $modelTemp->tampilDataTemp($nofaktur);

            if ($cekdata->getNumRows() > 0) {
                $data = [
                    'nofaktur'      => $nofaktur,
                    'tglfaktur'     => $tglfaktur,
                    'idpelanggan'   => $idpelanggan,
                    'totalharga'    => $totalharga
                ];

                $json = [
                    'data'  => view('barangkeluar/modalpembayaran', $data)
                ];
            } else {
                $json = [
                    'error'  => 'Maaf, item belum ada'
                ];
            }

            echo json_encode($json);
        }
    }

    function simpanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

            $modelBarangKeluar = new ModelBarangKeluar();

            //simpan ke table barang keluar
            $modelBarangKeluar->insert([
                'faktur'        => $nofaktur,
                'tglfaktur'     => $tglfaktur,
                'idpel'         => $idpelanggan,
                'totalharga'    => $totalbayar,
                'jumlahuang'    => $jumlahuang,
                'sisauang'      => $sisauang
            ]);

            $modelTemp      = new ModelTempBarangKeluar();
            $dataTemp       = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur'     => $row['detfaktur'],
                    'detbrgkode'    => $row['detbrgkode'],
                    'dethargajual'  => $row['dethargajual'],
                    'detjml'        => $row['detjml'],
                    'detsubtotal'   => $row['detsubtotal']
                ];
            }

            $modelDetail = new ModelDetailBarangKeluar();
            $modelDetail->insertBatch($fieldDetail);


            // hapus temp barang masuk berdasarkan faktur
            $modelTemp->where(['detfaktur' => $nofaktur]);
            $modelTemp->delete();

            $json = [
                'sukses'        => 'Transaksi berhasil disimpan',
                'cetakfaktur'   => site_url('barangkeluar/cetakfaktur/' . $nofaktur)
            ];

            echo json_encode($json);
        }
    }

    public function cetakFaktur($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $modelDetail = new ModelDetailBarangKeluar();
        $modelPelanggan = new ModelPelanggan();

        $cekData = $modelBarangKeluar->find($faktur);
        $dataPelanggan = $modelPelanggan->find($cekData['idpel']);

        $namaPelanggan = ($dataPelanggan != null) ? $dataPelanggan['pelnama'] : '-';
        if ($cekData != null) {
            $data = [
                'faktur'            => $faktur,
                'tanggal'           => $cekData['tglfaktur'],
                'namapelanggan'     => $namaPelanggan,
                'jumlahuang'        => $cekData['jumlahuang'],
                'sisauang'          => $cekData['sisauang'],
                'detailbarang'      => $modelDetail->tampilDataDetail($faktur)
            ];

            return view('barangkeluar/cetakfaktur', $data);
        } else {
            return redirect()->to(site_url('barangkeluar/input'));
        }
    }

    public function listData()
    {

        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelDataBarangKeluar($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"cetak('" . $list->faktur . "')\" title=\"Cetak\"><i class='fas fa-print'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->faktur . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";
                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->faktur . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";

                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tglfaktur;
                $row[] = $list->pelnama;
                $row[] = number_format($list->totalharga, 0, ",", ".");
                $row[] = $tombolCetak . ' ' . $tombolHapus . ' ' . $tombolEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new ModelDetailBarangKeluar();
            $modelBarangKeluar = new ModelBarangKeluar();

            // hapus detail
            $modelDetail->where(['detfaktur' => $faktur]);
            $modelDetail->delete();
            $modelBarangKeluar->delete($faktur);

            $json = [
                'sukses' => 'Barang keluar berhasil dihapus'
            ];

            echo json_encode($json);
        }
    }

    public function edit($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $rowData = $modelBarangKeluar->find($faktur);


        $modelPelanggan = new ModelPelanggan();
        $rowPelanggan = $modelPelanggan->find($rowData['idpel']);

        if ($rowData['idpel'] == 0) {
            $pelanggan = '';
        } else {
            $pelanggan = $rowPelanggan['pelnama'];
        }

        $data = [
            'judul'                 => 'Home',
            'subjudul'              => 'Edit Faktur Penjualan',
            'nofaktur'              => $faktur,
            'tanggal'               => $rowData['tglfaktur'],
            'namapelanggan'         => $pelanggan
        ];

        return view('barangkeluar/formedit', $data);
    }
}
