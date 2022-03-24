<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'pelid';
    protected $allowedFields    = [
        'pelnama', 'peltelp', 'pelalamat'
    ];

    public function ambilDataTerakhir()
    {
        return $this->table('pelanggan')->limit(1)->orderBy('pelid', 'Desc')->get();
    }
}