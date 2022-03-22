<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelsatuan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'satuan';
    protected $primaryKey       = 'satid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'satid', 'satnama', 'satjumlah'
    ];

    // public function cariData($cari)
    // {
    //     return $this->table('satuan')->like('satnama', $cari);
    // }
}