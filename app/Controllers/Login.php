<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLevels;
use App\Models\ModelLogin;
use Config\Services;

class Login extends BaseController
{
    public function index()
    {
        return view('login/index');
    }

    public function cekUser()
    {
        $iduser = $this->request->getPost('iduser');
        $pass = $this->request->getPost('pass');

        $validation = \Config\Services::validation();



        $valid = $this->validate([
            'iduser'    => [
                'label'     => 'ID User',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            'pass'    => [
                'label'     => 'Password',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $sessError = [
                'errIdUser'     => $validation->getError('iduser'),
                'errPassword'   => $validation->getError('pass')
            ];

            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        } else {
            $modelLogin  = new ModelLogin();

            $cekUserLogin = $modelLogin->find($iduser);
            if ($cekUserLogin == null) {
                $sessError = [
                    'errIdUser'     => 'Maaf user tidak terdaftar',
                ];

                session()->setFlashdata($sessError);
                return redirect()->to(site_url('login/index'));
            } else {
                $passwordUser = $cekUserLogin['userpassword'];

                if (password_verify($pass, $passwordUser)) {
                    //lanjutkan
                    $idlevel = $cekUserLogin['userlevelid'];

                    $modelLevel = new ModelLevels();
                    $cekLevel = $modelLevel->find($idlevel);

                    $simpan_session = [
                        'iduser'    => $iduser,
                        'namauser'  => $cekUserLogin['usernama'],
                        'levelnama'  => $cekLevel['levelnama'],
                        'idlevel'   => $idlevel
                    ];
                    session()->set($simpan_session);

                    return redirect()->to('/main/index');
                } else {
                    $sessError = [
                        'errPassword'     => 'Maaf password anda salah !!',
                    ];

                    session()->setFlashdata($sessError);
                    return redirect()->to(site_url('login/index'));
                }
            }
        }
    }

    public function keluar()
    {
        session()->destroy();
        return redirect()->to('/login/index');
    }
}
