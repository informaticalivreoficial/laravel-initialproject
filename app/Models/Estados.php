<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado_nome',
        'estado_uf',
        'estado_regiao'
    ];    
    
    public $timestamps = false;
    
    public function municipios()
    {
      return $this->hasMany(Cidades::class,'estado_id', 'estado_id');
    }
}
