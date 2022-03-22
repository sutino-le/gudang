<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelkategori;
use CodeIgniter\Validation\Rules;

class Kategori extends BaseController
{
    public function __construct()
    {
        $this->kategori = new Modelkategori();
    }

    public function index()
    {
        // $tombolcari = $this->request->getPost('tombolcari');
        // if (isset($tombolcari)) {
        //     $cari = $this->request->getPost('cari');
        //     session()->set('cari_kategori', $cari);
        //     redirect()->to('/kategori/index');
        // } else {
        //     $cari = session()->get('cari_kategori');
        // }

        // $dataKategori = $cari ? $this->kategori->cariData($cari)->paginate(5, 'kategori') : $this->kategori->paginate(5, 'kategori');

        // $nohalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        // $data = [
        //     'judul'         => 'Home',
        //     'subjudul'      => 'Data Kategori',
        //     'tampildata'    => $dataKategori,
        //     'pager'         => $this->kategori->pager,
        //     'nohalaman'     => $nohalaman,
        //     'cari'          => $cari
        // ];
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Data Kategori',
            'tampildata'    => $this->kategori->findAll()
        ];
        return view('kategori/viewkategori', $data);
    }

    public function formtambah()
    {
        $data['judul']      = 'Home';
        $data['subjudul']   = 'Tambah Kategori';
        return view('kategori/formtambah', $data);
    }

    public function simpandata()
    {
        $namakategori = $this->request->getVar('namakategori');

        $validation = \config\Services::validation();

        $valid = $this->validate([
            'namakategori'  => [
                'rules'     => 'required',
                'label'     => 'Nama Kategori',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<div class="alert alert-danger m-1">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('kategori/formtambah');
        } else {
            $this->kategori->insert([
                'katnama'   => $namakategori
            ]);

            $pesan = [
                'sukses'    => '<div class="alert alert-success m-1"">Data kategori berhasil ditambahkan...!!!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('kategori/index');
        }
    }

    public function formedit($id)
    {
        $rowData    = $this->kategori->find($id);

        if ($rowData) {
            $data   = [
                'judul'     => 'Home',
                'subjudul'  => 'Edit Kategori',
                'id'        => $id,
                'nama'      => $rowData['katnama']
            ];

            return view('kategori/formedit', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata()
    {
        $idkategori = $this->request->getVar('idkategori');
        $namakategori = $this->request->getVar('namakategori');

        $validation = \config\Services::validation();

        $valid = $this->validate([
            'namakategori'  => [
                'rules'     => 'required',
                'label'     => 'Nama Kategori',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<div class="alert alert-danger m-1">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('kategori/formedit' . $idkategori);
        } else {
            $this->kategori->update($idkategori, [
                'katnama'   => $namakategori
            ]);

            $pesan = [
                'sukses'    => '<div class="alert alert-success m-1"">Data kategori berhasil dirubah...!!!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('kategori/index');
        }
    }

    public function hapus($id)
    {
        $rowData    = $this->kategori->find($id);

        if ($rowData) {
            $this->kategori->delete($id);

            $pesan = [
                'sukses'    => '<div class="alert alert-success m-1"">Data kategori berhasil dihapus...!!!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('kategori/index');
        } else {
            exit('Data tidak ditemukan');
        }
    }
}