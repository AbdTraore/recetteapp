<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collecteurs extends Model
{
    use HasFactory;
    protected $fillable = ["nomcollecteur", "prenomcollecteur", "telephone"];
}
