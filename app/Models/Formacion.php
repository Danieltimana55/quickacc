<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formacion extends Model
{
    use HasFactory;
    
    protected $table = 'formaciones';
    
    protected $fillable = [
        'nombre',
        'nivel',
        'numero_ficha',
        'instructor_id',
        'numero_ambiente',
        'fecha_inicio',
        'fecha_fin',
        'jornada_id'
    ];
    
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];
    
    /**
     * Obtiene el instructor asignado a esta formación
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    
    /**
     * Obtiene la jornada de esta formación
     */
    public function jornada(): BelongsTo
    {
        return $this->belongsTo(Jornada::class, 'jornada_id');
    }
    
    /**
     * Obtiene los aprendices de esta formación
     */
    public function aprendices(): HasMany
    {
        return $this->hasMany(User::class, 'formacion_id');
    }
}
