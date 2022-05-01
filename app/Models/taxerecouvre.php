<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxerecouvre extends Model
{
    use HasFactory;
    protected $fillable = ["taxemensuelle","taxeannuelle","janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre","exercice", "contribuables_id", "taxes_id"]; 

    public function taxes(){
        return $this->belongsTo(taxes::class);
    }

    public function activites(){
        return $this->belongsTo(activite::class);
    }

    public function zones(){
        return $this->belongsTo(zone::class);
    }
}
