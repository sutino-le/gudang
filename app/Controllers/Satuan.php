<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelsatuan;

class Satuan extends BaseController
{
    public function __construct()
    {
        $this->satuan = new Modelsatuan();
    }


    public function index()
    {
        // $tombolcari = $this->request->getPost('tombolcari');
        // if (isset($tombolcari)) {
        //     $cari = $this->request->getPost('cari');
        //     session()->set('cari_satuan', $cari);
        //     redirect()->to('/satuan/index');
        // } else {
        //     $cari = session()->get('cari_satuan');
        // }

        // $dataSatuan = $cari ? $this->satuan->cariData($cari)->paginate(5, 'satuan') : $this->satuan->paginate(5, 'satuan');

        // $nohalaman = $this->request->getVar('page_satuan') ? $this->request->getVar('page_satuan') : 1;
        // $data = [
        //     'judul'         => 'Home',
        //     'subjudul'      => 'Data Satuan',
        //     'tampildata'    => $dataSatuan,
        //     'pager'         => $this->satuan->pager,
        //     'nohalaman'     => $nohalaman,
        //     'cari'          => $cari
        // ];
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Data Satuan',
            'tampildata'    => $this->satuan->findAll()
        ];
        return view('satuan/viewsatuan', $data);
    }

    public function formtambah()
    {
        $data['judul']      = 'Home';
        $data['subjudul']   = 'Tambah Satuan';
        return view('satuan/formtambah', $data);
    }

    public function simpandata()
    {
        $namasatuan = $this->request->getVar('namasatuan');

        $validation = \config\Services::validation();

        $valid = $this->validate([
            'namasatuan'  => [
                'rules'     => 'required',
                'label'     => 'Nama Satuan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaSatuan' => '<div class="alert alert-danger m-1">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('satuan/formtambah');
        } else {
            $this->satuan->insert([
                'satnama'   => $namasatuan
            ]);

            $pesan = [
                'sukses'    => '<div class="alert alert-success m-1"">Data satuan berhasil ditambahkan...!!!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('satuan/index');
        }
    }

    public function formedit($id)
    {
        $rowData    = $this->satuan->find($id);

        if ($rowData) {
            $data   = [
                'judul'     => 'Home',
                'subjudul'  => 'Edit Satuan',
                'id'        => $id,
                'nama'      => $rowData['satnama']
            ];

            return view('satuan/formedit', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata()
    {
        $idsatuan = $this->request->getVar('idsatuan');
        $namasatuan = $this->request->getVar('namasatuan');

        $validation = \config\Services::validation();

        $valid = $this->validate([
            'namasatuan'  => [
                'rules'     => 'required',
                'label'     => 'Nama Satuan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaSatuan' => '<div class="alert alert-danger m-1">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('satuan/formedit' . $idsatuan);
        } else {
            $this->satuan->update($idsatuan, [
                'satnama'   => $namasatuan
            ]);

            $pesan = [
                'sukses'    => '<div class="alert alert-success m-1"">Data satuan berhasil dirubah...!!!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('satuan/index');
        }
    }

    public function hapus($id)
    {
        $rowData    = $this->satuan->find($id);

        if ($rowData) {
            $this->satuan->delete($id);

            $pesan = [
                'sukses'    => '<div class="alert alert-success m-1"">Data satuan berhasil dihapus...!!!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('satuan/index');
        } else {
            exit('Data tidak ditemukan');
        }
    }
}