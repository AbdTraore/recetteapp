<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContribuableTaxe extends Model
{
    use HasFactory;
    protected $table = "contribuable_taxes";
    protected $fillable = ["contribuable_id", "taxes_id"] ;
}
