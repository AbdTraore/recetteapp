<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contribuable extends Model
{
    use HasFactory;
    protected $fillable = ["codecontribuable", "nom", "prenom", "telephone", "activites_id", "zones_id", "exercice"];

    public function Taxes()
    {
        return $this->belongsToMany(taxes::class, 'contribuable_taxes');
    }
    public function activites(){
        return $this->belongsTo(activite::class);
    }
    public function contribuables(){
        return $this->belongsTo(contribuable::class);
    }

    public function zones(){
        return $this->belongsTo(zone::class);
    }
}
