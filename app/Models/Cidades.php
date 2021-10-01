<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado_id',
        'cidade_nome',
        'cidade_uf'
    ];
    
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estados::class,'cidade_id', 'estado_id');
    }
}
