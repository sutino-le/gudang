<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDataPelanggan;
use App\Models\ModelPelanggan;
use CodeIgniter\Validation\Rules;
use Config\Services;

class Pelanggan extends BaseController
{
    public function formtambah()
    {
        $json = [
            'data' => view('pelanggan/modaltambah')
        ];

        echo json_encode($json);
    }

    public function simpan()
    {
        $namapel = $this->request->getPost('namapel');
        $telp = $this->request->getPost('telp');
        $alamat = $this->request->getPost('alamat');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namapel' => [
                'rules'     => 'required',
                'label'     => 'Nama Pelanggan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            'telp' => [
                'rules'     => 'required|is_unique[pelanggan.peltelp]',
                'label'     => 'Nomor Telp/Hp',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'is_unique' => '{field} tidak boleh ada yang sama'
                ]
            ],
            'alamat' => [
                'rules'     => 'required',
                'label'     => 'Alamat',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $json = [
                'error' => [
                    'errNamaPelanggan' => $validation->getError('namapel'),
                    'errTelp' => $validation->getError('telp'),
                    'errAlamat' => $validation->getError('alamat'),
                ]
            ];
        } else {
            $modelPelanggan = new ModelPelanggan();

            $modelPelanggan->insert([
                'pelnama'       => $namapel,
                'peltelp'       => $telp,
                'pelalamat'     => $alamat
            ]);

            $rowData = $modelPelanggan->ambilDataTerakhir()->getRowArray();

            $json = [
                'sukses'        => 'Data pelanggan berhasil disimpan, ambil data terakhir ?',
                'namapelanggan' => $rowData['pelnama'],
                'idpelanggan'   => $rowData['pelid']
            ];
        }

        echo json_encode($json);
    }

    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('pelanggan/modaldata')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelDataPelanggan($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->pelid . "', '" . $list->pelnama . "')\" title=\"Pilih\"><i class='fas fa-hand-point-up'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->pelid . "', '" . $list->pelnama . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->pelnama;
                $row[] = $list->peltelp;
                $row[] = $list->pelalamat;
                $row[] = $tombolPilih . " " . $tombolHapus;
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

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelPelanggan = new ModelPelanggan();

            $modelPelanggan->delete($id);

            $json = [
                'sukses' => 'Data Pelanggan berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf, gagal menampilkan data');
        }
    }
}