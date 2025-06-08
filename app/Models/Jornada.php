<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jornada extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'hora_entrada',
        'hora_salida'
    ];
    
    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];
    
    /**
     * Obtiene las formaciones asociadas a esta jornada
     */
    public function formaciones(): HasMany
    {
        return $this->hasMany(Formacion::class, 'jornada_id');
    }
}
