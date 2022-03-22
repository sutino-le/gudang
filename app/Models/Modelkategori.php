<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelkategori extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kategori';
    protected $primaryKey       = 'katid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'katid', 'katnama'
    ];

    // public function cariData($cari)
    // {
    //     return $this->table('kategori')->like('katnama', $cari);
    // }
}