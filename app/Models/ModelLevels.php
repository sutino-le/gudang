<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLevels extends Model
{
    protected $table            = 'levels';
    protected $primaryKey       = 'levelid';
    protected $allowedFields    = [
        'levelnama'
    ];
}
