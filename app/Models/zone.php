<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zone extends Model
{
    use HasFactory;
    protected $fillable = ["nom", "collecteurs_id"];

    public function collecteurs(){
        return $this->belongsTo(collecteur::class);
    }
}
