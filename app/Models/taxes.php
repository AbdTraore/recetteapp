<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxes extends Model
{
    use HasFactory;

    protected $table = "taxes";


    public function Contribuables()
    {
        return $this->belongsToMany(contribuable::class, 'contribuable_taxes');
    }
}
